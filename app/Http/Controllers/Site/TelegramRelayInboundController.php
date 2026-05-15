<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Services\BotService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * Вход для промежуточного сервера (реле): только логика бота, без запросов к api.telegram.org.
 */
class TelegramRelayInboundController extends Controller
{
    public function process(Request $request, BotService $botService): JsonResponse
    {
        $data = $request->validate([
            'chat_id' => 'required|integer',
            'text'    => 'required|string|max:10000',
        ]);

        try {
            $response = $botService->handle($data['text'], (string) $data['chat_id'], 'telegram');
        } catch (\Throwable $e) {
            Log::error('Telegram relay inbound: ' . $e->getMessage(), [
                'chat_id' => $data['chat_id'],
            ]);

            return response()->json([
                'ok'           => false,
                'user_message' => '⚠️ Произошла ошибка при обработке запроса.',
            ]);
        }

        if (! is_array($response) || ! isset($response['choices'][0]['message']['content'])) {
            Log::error('Telegram relay: invalid BotService response', ['response' => $response]);

            return response()->json([
                'ok'           => false,
                'user_message' => '❌ Ошибка генерации ответа. Попробуйте позже.',
            ]);
        }

        $reply = $botService->markdownToTelegramHtml($response['choices'][0]['message']['content']);

        return response()->json([
            'ok'         => true,
            'reply_html' => $reply,
        ]);
    }
}
