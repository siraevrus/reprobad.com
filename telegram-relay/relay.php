<?php

declare(strict_types=1);

/**
 * Промежуточный сервер: webhook от Telegram → РЕПРО (AI) → sendMessage в Telegram.
 * Размещается на VPS вне РФ. Требуется PHP 8.1+ с curl.
 *
 * Развёртывание: скопировать каталог на сервер, заполнить .env, указать в nginx root этот файл
 * или: location / { try_files $uri /relay.php?$query_string; } с rewrite для POST на relay.php
 *
 * Проще всего: DocumentRoot = эта папка, index relay.php, в nginx:
 *   location / { try_files $uri /relay.php$is_args$args; }
 */

$envFile = __DIR__ . '/.env';
if (is_readable($envFile)) {
    foreach (file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) ?: [] as $line) {
        $line = trim($line);
        if ($line === '' || str_starts_with($line, '#')) {
            continue;
        }
        if (! str_contains($line, '=')) {
            continue;
        }
        [$k, $v] = explode('=', $line, 2);
        $k = trim($k);
        $v = trim($v, " \t\"'");
        if ($k !== '') {
            putenv(sprintf('%s=%s', $k, $v));
            $_ENV[$k]      = $v;
            $_SERVER[$k]   = $v;
        }
    }
}

$botToken = (string) (getenv('TELEGRAM_BOT_TOKEN') ?: '');
$webhookSecret = (string) (getenv('TELEGRAM_WEBHOOK_SECRET') ?: '');
$reproUrl = rtrim((string) (getenv('REPRO_RELAY_URL') ?: ''), '/');
$reproSecret = (string) (getenv('REPRO_RELAY_SECRET') ?: '');
$reproTimeout = (int) (getenv('REPRO_HTTP_TIMEOUT') ?: '120');
if ($reproTimeout < 30) {
    $reproTimeout = 120;
}

header('Content-Type: application/json; charset=utf-8');

if (($_SERVER['REQUEST_METHOD'] ?? '') === 'GET') {
    echo json_encode(['status' => 'telegram-relay', 'ok' => true]);
    exit;
}

if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
    http_response_code(405);
    echo json_encode(['ok' => false]);
    exit;
}

if ($botToken === '' || $reproUrl === '' || $reproSecret === '') {
    http_response_code(500);
    error_log('telegram-relay: missing TELEGRAM_BOT_TOKEN, REPRO_RELAY_URL or REPRO_RELAY_SECRET');
    echo json_encode(['ok' => false]);
    exit;
}

$raw = file_get_contents('php://input') ?: '';
$update = json_decode($raw, true);
if (! is_array($update)) {
    http_response_code(400);
    echo json_encode(['ok' => false]);
    exit;
}

if ($webhookSecret !== '') {
    $hdr = (string) ($_SERVER['HTTP_X_TELEGRAM_BOT_API_SECRET_TOKEN'] ?? '');
    if ($hdr === '' || ! hash_equals($webhookSecret, $hdr)) {
        http_response_code(403);
        echo json_encode(['ok' => false]);
        exit;
    }
}

if (! isset($update['message'])) {
    echo json_encode(['ok' => true]);
    exit;
}

$chatId = $update['message']['chat']['id'] ?? null;
$text   = trim((string) ($update['message']['text'] ?? ''));
if (! $chatId || $text === '') {
    echo json_encode(['ok' => true]);
    exit;
}

telegramSendChatAction($botToken, (int) $chatId);

$payload = json_encode([
    'chat_id' => (int) $chatId,
    'text'    => $text,
], JSON_UNESCAPED_UNICODE);

$ch = curl_init($reproUrl);
curl_setopt_array($ch, [
    CURLOPT_POST           => true,
    CURLOPT_HTTPHEADER     => [
        'Content-Type: application/json',
        'Authorization: Bearer ' . $reproSecret,
        'Accept: application/json',
    ],
    CURLOPT_POSTFIELDS     => $payload,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT        => $reproTimeout,
]);
$reproBody = curl_exec($ch);
$reproErr  = curl_error($ch);
$reproCode = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($reproBody === false || $reproCode !== 200) {
    error_log('telegram-relay: repro HTTP ' . $reproCode . ' err=' . $reproErr . ' body=' . substr((string) $reproBody, 0, 500));
    telegramSendMessage($botToken, (int) $chatId, '⚠️ Сервис временно недоступен. Попробуйте позже.');
    echo json_encode(['ok' => true]);
    exit;
}

$reproJson = json_decode((string) $reproBody, true);
if (! is_array($reproJson)) {
    telegramSendMessage($botToken, (int) $chatId, '⚠️ Ошибка ответа сервера.');
    echo json_encode(['ok' => true]);
    exit;
}

if (empty($reproJson['ok'])) {
    $um = (string) ($reproJson['user_message'] ?? '❌ Ошибка обработки.');
    telegramSendMessage($botToken, (int) $chatId, $um);
    echo json_encode(['ok' => true]);
    exit;
}

$reply = (string) ($reproJson['reply_html'] ?? '');
telegramSendMessageChunks($botToken, (int) $chatId, $reply);

echo json_encode(['ok' => true]);
exit;

/** @return array<string, mixed> */
function telegramApi(string $botToken, string $method, array $fields): array
{
    $url = sprintf('https://api.telegram.org/bot%s/%s', $botToken, $method);
    $ch  = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_POST           => true,
        CURLOPT_POSTFIELDS     => $fields,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT        => 60,
    ]);
    $res = curl_exec($ch);
    curl_close($ch);
    $j = json_decode((string) $res, true);

    return is_array($j) ? $j : [];
}

function telegramSendChatAction(string $botToken, int $chatId): void
{
    telegramApi($botToken, 'sendChatAction', [
        'chat_id' => $chatId,
        'action'  => 'typing',
    ]);
}

function telegramSendMessage(string $botToken, int $chatId, string $text): void
{
    telegramApi($botToken, 'sendMessage', [
        'chat_id'    => $chatId,
        'text'       => $text,
        'parse_mode' => 'HTML',
    ]);
}

function telegramSendMessageChunks(string $botToken, int $chatId, string $text): void
{
    $max = 4000;
    if (mb_strlen($text) <= $max) {
        telegramSendMessage($botToken, $chatId, $text);

        return;
    }
    $rest = $text;
    $first = true;
    while ($rest !== '') {
        if (! $first) {
            usleep(500_000);
        }
        $first = false;
        $chunk = mb_substr($rest, 0, $max);
        $rest  = (string) mb_substr($rest, mb_strlen($chunk));
        telegramSendMessage($botToken, $chatId, $chunk);
    }
}
