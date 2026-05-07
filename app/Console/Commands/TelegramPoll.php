<?php

namespace App\Console\Commands;

use App\Services\BotService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TelegramPoll extends Command
{
    protected $signature = 'telegram:poll
                            {--timeout=25 : Long-polling таймаут (сек), макс. 30}
                            {--sleep=1 : Пауза между итерациями при ошибке (сек)}';

    protected $description = 'Получает обновления от Telegram через long-polling (вместо webhook)';

    private int $offset = 0;

    public function __construct(private BotService $botService)
    {
        parent::__construct();
    }

    public function handle(): int
    {
        $token = config('services.telegram.bot_token');

        if (! $token) {
            $this->error('TELEGRAM_BOT_TOKEN не задан в .env');
            return Command::FAILURE;
        }

        $pollTimeout = (int) $this->option('timeout');
        $sleepOnError = (int) $this->option('sleep');

        $this->info('Telegram polling запущен. Ctrl+C для остановки.');
        $this->info("Bot token: {$token}");

        // Удаляем webhook, чтобы он не конфликтовал с polling
        $this->deleteWebhook($token);

        while (true) {
            try {
                $updates = $this->getUpdates($token, $pollTimeout);

                if ($updates === null) {
                    sleep($sleepOnError);
                    continue;
                }

                foreach ($updates as $update) {
                    $this->processUpdate($update);
                    $this->offset = $update['update_id'] + 1;
                }
            } catch (\Exception $e) {
                Log::error('Telegram polling error: ' . $e->getMessage());
                $this->error('Ошибка: ' . $e->getMessage());
                sleep($sleepOnError);
            }
        }
    }

    private function getUpdates(string $token, int $timeout): ?array
    {
        $apiUrl = "https://api.telegram.org/bot{$token}/getUpdates";

        try {
            $response = $this->telegramHttp($timeout + 5)->get($apiUrl, [
                'offset'  => $this->offset,
                'timeout' => $timeout,
                'allowed_updates' => ['message'],
            ]);

            if (! $response->successful()) {
                Log::warning('Telegram getUpdates failed', [
                    'status' => $response->status(),
                    'body'   => $response->body(),
                ]);
                return null;
            }

            $data = $response->json();

            if (! ($data['ok'] ?? false)) {
                Log::warning('Telegram getUpdates: ok=false', $data);
                return null;
            }

            return $data['result'] ?? [];

        } catch (\Exception $e) {
            Log::error('Telegram getUpdates exception: ' . $e->getMessage());
            return null;
        }
    }

    private function processUpdate(array $update): void
    {
        if (! isset($update['message'])) {
            return;
        }

        $chatId      = $update['message']['chat']['id'] ?? null;
        $messageText = trim($update['message']['text'] ?? '');

        if (! $chatId || ! $messageText) {
            return;
        }

        Log::info('Telegram polling: incoming message', [
            'chat_id' => $chatId,
            'text'    => $messageText,
        ]);

        $this->info("[{$chatId}] → {$messageText}");

        // Показываем индикатор «печатает»
        $this->sendChatAction($chatId, 'typing');

        // Обрабатываем через BotService
        $response = $this->botService->handle($messageText, (string) $chatId, 'telegram');

        if (! is_array($response) || ! isset($response['choices'][0]['message']['content'])) {
            Log::error('Telegram polling: invalid BotService response', ['response' => $response]);
            $this->sendMessage($chatId, '❌ Ошибка генерации ответа. Попробуйте позже.');
            return;
        }

        $reply = $this->botService->markdownToTelegramHtml($response['choices'][0]['message']['content']);

        Log::info('Telegram polling: sending reply', [
            'chat_id'      => $chatId,
            'reply_length' => strlen($reply),
        ]);

        $this->sendMessage($chatId, $reply);

        $this->info("[{$chatId}] ← " . mb_substr(strip_tags($reply), 0, 80) . '...');
    }

    private function sendMessage(int $chatId, string $text): void
    {
        $token  = config('services.telegram.bot_token');
        $apiUrl = "https://api.telegram.org/bot{$token}/sendMessage";

        $maxLength = 4000;

        if (strlen($text) <= $maxLength) {
            $this->postToTelegram($apiUrl, [
                'chat_id'    => $chatId,
                'text'       => $text,
                'parse_mode' => 'HTML',
            ]);
            return;
        }

        // Разбиваем длинное сообщение по абзацам
        $messages = [];
        $current  = '';

        foreach (explode("\n\n", $text) as $paragraph) {
            if (strlen($current) + strlen($paragraph) + 2 > $maxLength) {
                if ($current !== '') {
                    $messages[] = trim($current);
                }
                $current = strlen($paragraph) > $maxLength
                    ? mb_substr($paragraph, 0, $maxLength)
                    : $paragraph;
            } else {
                $current .= ($current ? "\n\n" : '') . $paragraph;
            }
        }

        if ($current !== '') {
            $messages[] = trim($current);
        }

        foreach ($messages as $i => $part) {
            if ($i > 0) {
                usleep(500_000);
            }
            $this->postToTelegram($apiUrl, [
                'chat_id'    => $chatId,
                'text'       => $part,
                'parse_mode' => 'HTML',
            ]);
        }
    }

    private function sendChatAction(int $chatId, string $action = 'typing'): void
    {
        $token  = config('services.telegram.bot_token');
        $apiUrl = "https://api.telegram.org/bot{$token}/sendChatAction";

        try {
            $this->telegramHttp(5)->post($apiUrl, [
                'chat_id' => $chatId,
                'action'  => $action,
            ]);
        } catch (\Exception $e) {
            Log::debug('Telegram sendChatAction failed: ' . $e->getMessage());
        }
    }

    private function postToTelegram(string $url, array $payload): void
    {
        try {
            $response = $this->telegramHttp(10)->post($url, $payload);

            if (! $response->successful()) {
                Log::error('Telegram sendMessage failed', [
                    'status' => $response->status(),
                    'error'  => $response->json(),
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Telegram sendMessage exception: ' . $e->getMessage());
        }
    }

    private function deleteWebhook(string $token): void
    {
        try {
            $response = $this->telegramHttp(10)
                ->post("https://api.telegram.org/bot{$token}/deleteWebhook", [
                    'drop_pending_updates' => false,
                ]);

            if ($response->successful() && ($response->json()['ok'] ?? false)) {
                $this->info('Webhook удалён, переходим на polling.');
                Log::info('Telegram: webhook deleted, polling started');
            }
        } catch (\Exception $e) {
            Log::warning('Telegram: failed to delete webhook: ' . $e->getMessage());
        }
    }

    /**
     * HTTP-клиент с опциональным прокси (те же настройки, что и в TelegramController).
     */
    private function telegramHttp(int $timeoutSeconds): \Illuminate\Http\Client\PendingRequest
    {
        $request      = Http::timeout($timeoutSeconds);
        $proxyOptions = $this->buildProxyOptions();

        if ($proxyOptions !== []) {
            $request = $request->withOptions($proxyOptions);
        }

        return $request;
    }

    private function buildProxyOptions(): array
    {
        $proxy = config('services.telegram.http_proxy');

        if (! is_string($proxy) || $proxy === '') {
            $host = config('services.telegram.proxy_host');
            $port = config('services.telegram.proxy_port');

            if (is_string($host) && $host !== '' && $port !== null && $port !== '') {
                $user     = config('services.telegram.proxy_user');
                $password = config('services.telegram.proxy_password');
                $auth     = '';

                if (is_string($user) && $user !== '') {
                    $auth = rawurlencode($user) . ':' . rawurlencode((string) $password) . '@';
                }

                $proxy = 'http://' . $auth . $host . ':' . (int) $port;
            }
        }

        if (! is_string($proxy) || $proxy === '') {
            return [];
        }

        return ['proxy' => $proxy];
    }
}
