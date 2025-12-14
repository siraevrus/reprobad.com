<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Services\BotService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class BotController extends Controller
{
    public function __construct(private BotService $botService) {
    }

    /**
     * Обработка сообщений из веб-чата на сайте
     */
    public function ask(Request $request): JsonResponse
    {
        try {
            // Валидация входящих данных
            $message = trim($request->input('message', ''));
            $userId = $request->input('user_id', 'guest');

            if (empty($message)) {
                return response()->json([
                    'reply' => 'Пожалуйста, введите ваш вопрос.',
                    'error' => true
                ], 400);
            }

            // Логируем запрос для статистики
            Log::info('Bot chat request', [
                'user_id' => $userId,
                'message' => $message,
                'ip' => $request->ip()
            ]);

            // Обрабатываем запрос через BotService с историей
            $response = $this->botService->handle($message, $userId, 'web');

            // Проверяем наличие ответа
            if (!isset($response['llm_answer'])) {
                Log::error('Bot service returned no answer', ['response' => $response]);
                return response()->json([
                    'reply' => 'Извините, сервис временно недоступен. Попробуйте позже.'
                ]);
            }

            // Конвертируем markdown в HTML
            $htmlAnswer = $this->botService->markdownToHtml($response['llm_answer']);

            // Возвращаем ответ в формате, ожидаемом фронтендом
            return response()->json([
                'reply' => $htmlAnswer,
                'user_id' => $userId
            ]);

        } catch (\Exception $e) {
            Log::error('Bot chat error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'request' => $request->all()
            ]);

            return response()->json([
                'reply' => 'Произошла ошибка при обработке вашего запроса. Попробуйте еще раз.'
            ], 500);
        }
    }

    /**
     * Очистка истории чата для пользователя
     */
    public function clearHistory(Request $request): JsonResponse
    {
        try {
            $userId = $request->input('user_id', 'guest');
            
            $this->botService->clearHistory($userId, 'web');
            
            Log::info('Chat history cleared', ['user_id' => $userId]);
            
            return response()->json([
                'status' => 'success',
                'message' => 'История чата очищена'
            ]);
            
        } catch (\Exception $e) {
            Log::error('Failed to clear chat history: ' . $e->getMessage());
            
            return response()->json([
                'status' => 'error',
                'message' => 'Не удалось очистить историю'
            ], 500);
        }
    }
}