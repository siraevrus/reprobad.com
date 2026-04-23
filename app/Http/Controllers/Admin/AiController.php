<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AiController extends Controller
{
    public function generate(Request $request): JsonResponse
    {
        $request->validate([
            'type'    => 'required|in:keywords,description',
            'content' => 'required|string|max:50000',
            'title'   => 'nullable|string|max:500',
        ]);

        $type    = $request->input('type');
        $content = strip_tags($request->input('content'));
        $title   = strip_tags($request->input('title', ''));

        if ($type === 'keywords') {
            $prompt = "Ты seo копирайтер, напиши 10-14 слов или словосочетаний из статьи на сайте.\n"
                    . "Необходимо подобрать и использовать слова и словосочетания, которые реально отражают содержание страницы.\n"
                    . "Избегайте «накрутки»: не добавляйте нерелевантные или избыточные ключевые слова.\n"
                    . "Ориентируйтесь на здравый смысл при составлении списка, а не на попытки «обмануть» поисковый алгоритм. "
                    . "Подобранные слова формируй через запятую.\n\n"
                    . "Текст статьи:\n" . $content;
        } else {
            $prompt = "Ты seo копирайтер, напиши одно описание до 180 символов из статьи на сайте.\n"
                    . "Стремитесь к лаконичности и информативности: описание должно кратко передавать суть страницы и быть полезным для пользователя.\n"
                    . "Рекомендуется создавать уникальное описание для каждой страницы.\n"
                    . "Можно включать в текст полезную для пользователя информацию: цену товара, его характеристики, город доставки и т. д.\n"
                    . "Убедитесь, что description отражает содержимое страницы, содержит правильно выстроенные предложения, "
                    . "без злоупотребления ключевыми словами, фразами, заглавными буквами, рекламными лозунгами и пр.\n"
                    . "Убедитесь, что description отличается от содержимого элемента Заголовок.\n\n"
                    . ($title ? "Заголовок: {$title}\n\n" : '')
                    . "Текст статьи:\n" . $content;
        }

        $apiKey = config('services.hydraai.key');

        if (empty($apiKey)) {
            return response()->json(['success' => false, 'error' => 'AI_TOKEN (или HYDRA_AI_KEY) не задан в .env'], 500);
        }

        $model = config('services.hydraai.model', 'deepseek-v3.2');

        $response = Http::timeout(60)
            ->withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type'  => 'application/json',
            ])
            ->post('https://api.hydraai.ru/v1/chat/completions', [
                'model'       => $model,
                'messages'    => [
                    ['role' => 'user', 'content' => $prompt],
                ],
                'max_tokens'  => 300,
                'temperature' => 0.7,
            ]);

        if ($response->failed()) {
            return response()->json([
                'success' => false,
                'error'   => 'Ошибка API: ' . $response->status(),
            ], 500);
        }

        $data   = $response->json();
        $result = $data['choices'][0]['message']['content'] ?? null;

        if (empty($result)) {
            return response()->json(['success' => false, 'error' => 'Пустой ответ от AI'], 500);
        }

        return response()->json(['success' => true, 'result' => trim($result)]);
    }
}
