<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Services\BotService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TelegramController extends Controller
{
    public function __construct(private BotService $botService)
    {
    }

    /**
     * Webhook для обработки входящих сообщений от Telegram
     */
    public function webhook(Request $request): JsonResponse
    {
        try {
            $update = $request->all();

            if (!isset($update['message'])) {
                Log::warning('Telegram webhook: no message received', $update);
                return response()->json(['status' => 'error', 'message' => 'No message received'], 400);
            }

            $chatId = $update['message']['chat']['id'] ?? null;
            $messageText = trim($update['message']['text'] ?? '');
            $userName = $update['message']['from']['first_name'] ?? '';

            if (!$chatId || !$messageText) {
                return response()->json(['status' => 'error', 'message' => 'Invalid message data'], 400);
            }

            $this->sendChatAction($chatId, 'typing');

            $response = $this->botService->handle($messageText, (string)$chatId, 'telegram');

            $reply = $this->botService->markdownToHtml($response['llm_answer'] ?? '❌ Ошибка генерации ответа');

            $this->sendMessage($chatId, $reply);

            return response()->json(['status' => 'ok']);

        } catch (\Exception $e) {
            Log::error('Telegram webhook error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);

            if (isset($chatId)) {
                $this->sendMessage($chatId, '⚠️ Произошла ошибка при обработке запроса.');
            }

            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Отправка сообщения в Telegram
     */
    protected function sendMessage(int $chatId, string $text): void
    {
        $botToken = config('services.telegram.bot_token');
        
        if (!$botToken) {
            Log::error('Telegram bot token not configured');
            return;
        }

        $apiUrl = "https://api.telegram.org/bot{$botToken}/sendMessage";

        try {
            Http::timeout(10)->post($apiUrl, [
                'chat_id' => $chatId,
                'text' => $text,
                'parse_mode' => 'HTML',
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to send Telegram message: ' . $e->getMessage());
        }
    }

    /**
     * Отправка действия (например, "печатает...")
     */
    protected function sendChatAction(int $chatId, string $action = 'typing'): void
    {
        $botToken = config('services.telegram.bot_token');
        
        if (!$botToken) {
            return;
        }

        $apiUrl = "https://api.telegram.org/bot{$botToken}/sendChatAction";

        try {
            Http::timeout(5)->post($apiUrl, [
                'chat_id' => $chatId,
                'action' => $action,
            ]);
        } catch (\Exception $e) {
            Log::debug('Failed to send chat action: ' . $e->getMessage());
        }
    }
}