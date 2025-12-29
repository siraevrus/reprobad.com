<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Mail\DefaultMail;
use App\Models\Feedback;
use App\Models\Subscribe;
use App\Services\CityStatsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;

class FormController extends Controller
{
    public function subscribe(Request $request): JsonResponse
    {
        $request->headers->set('Accept', 'application/json');

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        Subscribe::query()->create([
            'email' => $request->get('email'),
        ]);

        // Отправляем email только если указан получатель
        $mailTo = env('MAIL_TO') ?? env('MAIL_TO_ADDRESS');
        if ($mailTo) {
            try {
                Mail::to($mailTo)->send(new DefaultMail($validator->validated()));
            } catch (\Exception $e) {
                // Логируем ошибку, но не прерываем выполнение
                \Log::error('Ошибка отправки email: ' . $e->getMessage());
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Успешно отправлено'
        ]);
    }

    public function feedback(Request $request): JsonResponse
    {
        $request->headers->set('Accept', 'application/json');

        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'nullable|string',
            'message' => 'required|string',
            'agree' => 'required'
        ]);
        
        // Проверяем, что согласие дано (может быть 1, true, "1", "true" и т.д.)
        if ($request->has('agree') && !in_array($request->get('agree'), [1, '1', true, 'true', 'on', 'yes'], true)) {
            return response()->json([
                'success' => false,
                'errors' => ['agree' => ['Необходимо дать согласие на обработку персональных данных']]
            ], 422);
        }

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $validated = $validator->validated();
        
        // Сохраняем вопрос в базу данных
        Feedback::query()->create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'message' => $validated['message'],
        ]);

        // Отправляем email только если указан получатель
        $mailTo = env('MAIL_TO') ?? env('MAIL_TO_ADDRESS');
        if ($mailTo) {
            try {
                Mail::to($mailTo)->send(new DefaultMail($validated));
            } catch (\Exception $e) {
                // Логируем ошибку, но не прерываем выполнение
                \Log::error('Ошибка отправки email: ' . $e->getMessage());
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Успешно отправлено'
        ]);
    }

    public function setCity(Request $request): JsonResponse
    {
        $request->headers->set('Accept', 'application/json');

        $validator = Validator::make($request->all(), [
            'city' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $city = trim($request->get('city'));
        
        // Сохраняем город в сессию
        session()->put('city', $city);
        
        // Записываем в статистику
        app(CityStatsService::class)->recordCitySelection($city);

        return response()->json([
            'success' => true,
            'message' => 'Город успешно сохранен',
            'city' => $city
        ]);
    }
}
