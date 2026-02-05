<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Mail\TestResultMail;
use App\Models\Subscribe;
use App\Models\TestQuestion;
use App\Models\TestResult;
use App\Services\TestCalculationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class TestController extends Controller
{
    public function index(): View
    {
        $resource = (object)[
            'title' => 'Тест «Репродуктивное здоровье»',
            'description' => 'Ответьте на 24 вопроса, получите оценку по важным категориям вашего здоровья',
        ];
        $pageType = 'Test';
        
        // Получаем активные вопросы из БД, отсортированные по порядку
        $questions = TestQuestion::active()
            ->ordered()
            ->get();
        
        return view('site.test.index', compact('resource', 'pageType', 'questions'));
    }

    public function calculate(Request $request, TestCalculationService $calculationService): JsonResponse
    {
        $request->headers->set('Accept', 'application/json');

        // Получаем количество активных вопросов
        $questionsCount = TestQuestion::active()->count();
        
        if ($questionsCount === 0) {
            return response()->json([
                'success' => false,
                'message' => 'Вопросы теста не настроены'
            ], 422);
        }

        $validator = Validator::make($request->all(), [
            'answers' => "required|array|size:{$questionsCount}",
            'answers.*' => 'required|integer|min:0|max:3',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $answers = $request->get('answers');
        $email = $request->get('email');
        
        try {
            $calculationResult = $calculationService->calculate($answers);
            
            // Сохраняем результат в базу данных
            $testResult = TestResult::create([
                'email' => $email,
                'answers' => $answers,
                'results' => $calculationResult,
            ]);

            return response()->json([
                'success' => true,
                'data' => $calculationResult,
                'result_id' => $testResult->id,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ошибка при расчете результатов: ' . $e->getMessage()
            ], 500);
        }
    }

    public function updateEmail(Request $request): JsonResponse
    {
        $request->headers->set('Accept', 'application/json');

        $validator = Validator::make($request->all(), [
            'result_id' => 'required|integer|exists:test_results,id',
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $testResult = TestResult::findOrFail($request->get('result_id'));
        $testResult->email = $request->get('email');
        $testResult->save();

        return response()->json([
            'success' => true,
            'message' => 'Email обновлен'
        ]);
    }

    public function subscribe(Request $request): JsonResponse
    {
        $request->headers->set('Accept', 'application/json');

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'agree' => 'required|accepted',
            'result_id' => 'nullable|integer|exists:test_results,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $email = $request->get('email');
        
        // Создаем подписку
        Subscribe::query()->create([
            'email' => $email,
        ]);

        // Отправляем письмо с результатами теста, если передан result_id
        if ($request->has('result_id')) {
            try {
                $testResult = TestResult::findOrFail($request->get('result_id'));
                
                // Обновляем email в результате, если он еще не установлен
                if (empty($testResult->email)) {
                    $testResult->email = $email;
                    $testResult->save();
                }
                
                // Отправляем письмо
                Mail::to($email)->send(new TestResultMail($testResult));
            } catch (\Exception $e) {
                \Log::error('Ошибка отправки письма с результатами теста: ' . $e->getMessage());
                // Не прерываем выполнение, если письмо не отправилось
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Результаты теста отправлены!'
        ]);
    }
}
