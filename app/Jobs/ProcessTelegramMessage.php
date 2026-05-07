<?php

namespace App\Jobs;

use App\Services\BotService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ProcessTelegramMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Максимум попыток при сбое (AI-сервис, сеть).
     */
    public int $tries = 2;

    /**
     * Таймаут выполнения одного задания (сек).
     */
    public int $timeout = 60;

    public function __construct(
        public readonly int    $chatId,
        public readonly string $messageText,
    ) {}

    public function handle(BotService $botService): void
    {
        Log::info('TelegramJob: processing', [
            'chat_id' => $this->chatId,
            'text'    => $this->messageText,
        ]);

        // Индикатор «печатает»
        $this->sendChatAction($this->chatId, 'typing');

        $response = $botService->handle($this->messageText, (string) $this->chatId, 'telegram');

        if (! is_array($response) || ! isset($response['choices'][0]['message']['content'])) {
            Log::error('TelegramJob: invalid BotService response', ['response' => $response]);
            $this->sendMessage($this->chatId, '❌ Ошибка генерации ответа. Попробуйте позже.');
            return;
        }

        $reply = $botService->markdownToTelegramHtml($response['choices'][0]['message']['content']);

        Log::info('TelegramJob: sending reply', [
            'chat_id'      => $this->chatId,
            'reply_length' => strlen($reply),
        ]);

        $this->sendMessage($this->chatId, $reply);
    }

    public function failed(\Throwable $e): void
    {
        Log::error('TelegramJob: failed', [
            'chat_id' => $this->chatId,
            'error'   => $e->getMessage(),
        ]);

        $this->sendMessage($this->chatId, '⚠️ Произошла ошибка при обработке запроса.');
    }

    // ----------------------------------------------------------------
    // Вспомогательные методы (дублируют логику TelegramController,
    // но Job самодостаточен и не зависит от HTTP-контекста).
    // ----------------------------------------------------------------

    private function sendMessage(int $chatId, string $text): void
    {
        $token  = config('services.telegram.bot_token');
        $apiUrl = "https://api.telegram.org/bot{$token}/sendMessage";

        $maxLength = 4000;

        if (strlen($text) <= $maxLength) {
            $this->post($apiUrl, ['chat_id' => $chatId, 'text' => $text, 'parse_mode' => 'HTML']);
            return;
        }

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
            $this->post($apiUrl, ['chat_id' => $chatId, 'text' => $part, 'parse_mode' => 'HTML']);
        }
    }

    private function sendChatAction(int $chatId, string $action = 'typing'): void
    {
        $token = config('services.telegram.bot_token');
        try {
            $this->http(5)->post(
                "https://api.telegram.org/bot{$token}/sendChatAction",
                ['chat_id' => $chatId, 'action' => $action]
            );
        } catch (\Exception $e) {
            Log::debug('TelegramJob: sendChatAction failed: ' . $e->getMessage());
        }
    }

    private function post(string $url, array $payload): void
    {
        try {
            $response = $this->http(10)->post($url, $payload);
            if (! $response->successful()) {
                Log::error('TelegramJob: API error', [
                    'status' => $response->status(),
                    'body'   => $response->json(),
                ]);
            }
        } catch (\Exception $e) {
            Log::error('TelegramJob: post exception: ' . $e->getMessage());
        }
    }

    private function http(int $timeout): PendingRequest
    {
        $request = Http::timeout($timeout);
        $options = $this->proxyOptions();

        return $options !== [] ? $request->withOptions($options) : $request;
    }

    private function proxyOptions(): array
    {
        $proxy = config('services.telegram.http_proxy');

        if (! is_string($proxy) || $proxy === '') {
            $host = config('services.telegram.proxy_host');
            $port = config('services.telegram.proxy_port');

            if (is_string($host) && $host !== '' && $port !== null && $port !== '') {
                $user     = config('services.telegram.proxy_user');
                $password = config('services.telegram.proxy_password');
                $auth     = is_string($user) && $user !== ''
                    ? rawurlencode($user) . ':' . rawurlencode((string) $password) . '@'
                    : '';

                $proxy = 'http://' . $auth . $host . ':' . (int) $port;
            }
        }

        return is_string($proxy) && $proxy !== '' ? ['proxy' => $proxy] : [];
    }
}
