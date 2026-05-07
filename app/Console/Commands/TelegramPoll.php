<?php

namespace App\Console\Commands;

use App\Jobs\ProcessTelegramMessage;
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

    public function __construct()
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

        Log::info('Telegram polling: dispatching job', [
            'chat_id' => $chatId,
            'text'    => $messageText,
        ]);

        $this->info("[{$chatId}] → {$messageText} (dispatched to queue)");

        // Диспатчим в очередь — обработка параллельная, polling не блокируется
        ProcessTelegramMessage::dispatch($chatId, $messageText);
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
