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

            Log::info('Telegram: Processing message', ['chat_id' => $chatId, 'message' => $messageText]);

            $response = $this->botService->handle($messageText, (string)$chatId, 'telegram');

            Log::info('Telegram: BotService response', ['response' => $response]);

            $reply = $this->botService->markdownToHtml($response['llm_answer'] ?? '❌ Ошибка генерации ответа');

            Log::info('Telegram: Sending reply', ['chat_id' => $chatId, 'reply_length' => strlen($reply)]);

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
        $botToken = env('TELEGRAM_BOT_TOKEN');
        
        if (!$botToken) {
            Log::error('Telegram bot token not configured');
            return;
        }

        $apiUrl = "https://api.telegram.org/bot{$botToken}/sendMessage";

        // Telegram лимит 4096 символов
        $maxLength = 4000; // Оставляем запас для HTML тегов
        
        if (strlen($text) > $maxLength) {
            // Разбиваем длинное сообщение на части
            $messages = [];
            $current = '';
            
            // Сначала пробуем разбить по абзацам
            $paragraphs = explode("\n\n", $text);
            
            foreach ($paragraphs as $paragraph) {
                $testLength = strlen($current) + strlen($paragraph) + 2; // +2 для \n\n
                
                if ($testLength > $maxLength) {
                    // Если текущий буфер не пуст, сохраняем его
                    if (!empty(trim($current))) {
                        $messages[] = trim($current);
                        $current = '';
                    }
                    
                    // Если сам абзац длиннее лимита, разбиваем его построчно
                    if (strlen($paragraph) > $maxLength) {
                        $lines = explode("\n", $paragraph);
                        foreach ($lines as $line) {
                            if (strlen($current) + strlen($line) + 1 > $maxLength) {
                                if (!empty(trim($current))) {
                                    $messages[] = trim($current);
                                }
                                $current = $line;
                            } else {
                                $current .= ($current ? "\n" : '') . $line;
                            }
                        }
                    } else {
                        $current = $paragraph;
                    }
                } else {
                    $current .= ($current ? "\n\n" : '') . $paragraph;
                }
            }
            
            // Добавляем остаток
            if (!empty(trim($current))) {
                $messages[] = trim($current);
            }
            
            Log::info('Telegram: Splitting message', ['parts' => count($messages), 'original_length' => strlen($text)]);
            
            // Отправляем по частям
            foreach ($messages as $index => $message) {
                if ($index > 0) {
                    usleep(500000); // 0.5 секунды между сообщениями
                }
                
                try {
                    Http::timeout(10)->post($apiUrl, [
                        'chat_id' => $chatId,
                        'text' => $message,
                        'parse_mode' => 'HTML',
                    ]);
                    Log::info('Telegram: Message part sent', ['part' => $index + 1, 'total' => count($messages), 'length' => strlen($message)]);
                } catch (\Exception $e) {
                    Log::error('Failed to send Telegram message part: ' . $e->getMessage());
                }
            }
        } else {
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