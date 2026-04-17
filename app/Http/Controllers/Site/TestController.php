<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Mail\TestResultMail;
use App\Models\Subscribe;
use App\Models\TestQuestion;
use App\Models\TestResult;
use App\Services\TestCalculationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class TestController extends Controller
{
    public function index(): View
    {
        $resource = (object) [
            'title' => 'Тест «Репродуктивное здоровье»',
            'description' => 'Ответьте на 24 вопроса, получите оценку по важным категориям вашего здоровья',
        ];
        $pageType = 'Test';

        $questions = TestQuestion::active()->ordered()->get();
        $activeQuestionCount = $questions->count();
        $questionsConfigured = $activeQuestionCount === 24;

        return view('site.test.index', compact('resource', 'pageType', 'questions', 'activeQuestionCount', 'questionsConfigured'));
    }

    public function result(Request $request): View|RedirectResponse
    {
        if ($request->has('signature') && ! $request->hasValidSignature()) {
            abort(403);
        }

        $id = null;
        if ($request->hasValidSignature()) {
            $id = (int) $request->query('result', 0);
        }
        if (! $id) {
            $id = $request->session()->get('latest_test_result_id');
        }
        if (! $id) {
            return redirect()->route('site.test.index');
        }

        $testResult = TestResult::query()->find($id);
        if (! $testResult) {
            $request->session()->forget('latest_test_result_id');

            return redirect()->route('site.test.index');
        }

        $resource = (object) [
            'title' => 'Результаты теста «Репродуктивное здоровье»',
            'description' => 'Персональные рекомендации по результатам теста',
        ];
        $pageType = 'TestResult';

        $resultsForView = app(TestCalculationService::class)->resultsForView($testResult->results ?? []);

        return view('site.test.result', compact('resource', 'pageType', 'testResult', 'resultsForView'));
    }

    /**
     * Та же страница результата без прохождения теста: нули, без персональных текстов, без привязки к БД.
     * Доступна только если включено в config/repro_test.php (по умолчанию в APP_ENV=local).
     */
    public function resultPreview(): View
    {
        if (! config('repro_test.allow_result_preview')) {
            abort(404);
        }

        $testResult = new TestResult;
        $testResult->exists = false;
        $testResult->results = [
            'ibhb' => 0,
            'has_codings' => false,
        ];

        $resource = (object) [
            'title' => 'Результаты теста «Репродуктивное здоровье»',
            'description' => 'Предпросмотр страницы (без персональных данных)',
        ];
        $pageType = 'TestResult';
        $preview = true;

        return view('site.test.result', compact('resource', 'pageType', 'testResult', 'preview'));
    }

    public function calculate(Request $request, TestCalculationService $calculationService): JsonResponse
    {
        $request->headers->set('Accept', 'application/json');

        $questions = TestQuestion::active()->ordered()->get();
        if ($questions->count() !== 24) {
            return response()->json([
                'success' => false,
                'message' => 'В админке должно быть ровно 24 активных вопроса',
            ], 422);
        }

        $validator = Validator::make($request->all(), [
            'answers' => 'required|array|size:24',
            'answers.*' => 'required|integer|min:0|max:3',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $answers = array_values($request->get('answers'));

        $q10Index = $questions->search(static fn (TestQuestion $q): bool => (int) $q->order === 10);
        if ($q10Index !== false) {
            $v = (int) $answers[$q10Index];
            if ($v !== 0 && $v !== 3) {
                return response()->json([
                    'success' => false,
                    'message' => 'Для вопроса 10 допустимы только ответы с 0 или 3 баллами',
                    'errors' => ['answers' => ['Недопустимое значение для вопроса 10']],
                ], 422);
            }
        }

        $email = $request->get('email');

        try {
            $calculationResult = $calculationService->calculate($answers);

            $testResult = TestResult::create([
                'email' => $email,
                'answers' => $answers,
                'results' => $calculationResult,
            ]);

            $request->session()->put('latest_test_result_id', $testResult->id);

            // Подписанный URL: после AJAX сессия на части хостингов не доходит до GET /test — редирект всё равно открывает результат.
            $redirectUrl = URL::temporarySignedRoute(
                'site.test.result',
                now()->addHours(12),
                ['result' => $testResult->id]
            );

            return response()->json([
                'success' => true,
                'data' => $calculationResult,
                'result_id' => $testResult->id,
                'redirect' => $redirectUrl,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ошибка при расчете результатов: '.$e->getMessage(),
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
                'errors' => $validator->errors(),
            ], 422);
        }

        $testResult = TestResult::findOrFail($request->get('result_id'));
        $testResult->email = $request->get('email');
        $testResult->save();

        return response()->json([
            'success' => true,
            'message' => 'Email обновлен',
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
                'errors' => $validator->errors(),
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
                \Log::info('Попытка отправки письма с результатами теста', [
                    'email' => $email,
                    'result_id' => $testResult->id,
                    'mailer' => config('mail.default'),
                    'queue_connection' => config('queue.default'),
                ]);

                Mail::to($email)->send(new TestResultMail($testResult));

                \Log::info('Письмо с результатами теста успешно отправлено', [
                    'email' => $email,
                    'result_id' => $testResult->id,
                ]);
            } catch (\Exception $e) {
                \Log::error('Ошибка отправки письма с результатами теста', [
                    'email' => $email,
                    'result_id' => $testResult->id ?? null,
                    'message' => $e->getMessage(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'trace' => $e->getTraceAsString(),
                    'mailer' => config('mail.default'),
                    'mail_host' => config('mail.mailers.smtp.host'),
                    'queue_connection' => config('queue.default'),
                ]);
                // Не прерываем выполнение, если письмо не отправилось
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Результаты теста отправлены!',
        ]);
    }
}
