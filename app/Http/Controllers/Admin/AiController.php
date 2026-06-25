<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class AiController extends Controller
{
    public function generate(Request $request): JsonResponse
    {
        $request->validate([
            'type'    => 'required|in:keywords,description,image_alt',
            'content' => 'required_unless:type,image_alt|string|max:50000',
            'title'   => 'nullable|string|max:500',
            'image'   => 'required_if:type,image_alt|nullable|string|max:15000000',
        ]);

        if ($request->input('type') === 'image_alt') {
            return $this->generateImageAlt($request);
        }

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

        return $this->callTextModel($prompt, 300);
    }

    private function generateImageAlt(Request $request): JsonResponse
    {
        $imageUrl = $this->resolveImageForApi($request->input('image', ''));

        if ($imageUrl === null) {
            return response()->json([
                'success' => false,
                'error'   => 'Не удалось прочитать изображение. Загрузите фото и попробуйте снова.',
            ], 400);
        }

        $title = strip_tags($request->input('title', ''));
        $context = strip_tags(mb_substr($request->input('content', ''), 0, 500));

        $prompt = "Ты SEO-специалист. Сайт reprobad.com — репродуктивное здоровье, подготовка к беременности, система РЕПРО.\n"
            . "Посмотри на изображение и напиши короткий alt-текст для SEO (до 125 символов).\n"
            . "Alt должен описывать то, что видно на фото, быть уникальным и полезным для поиска.\n"
            . "Не начинай с «изображение», «фото», «картинка». Без кавычек. Только русский язык. Одна строка.\n\n"
            . ($title ? "Заголовок материала: {$title}\n" : '')
            . ($context ? "Контекст материала: {$context}\n" : '');

        $apiKey = config('services.hydraai.key');

        if (empty($apiKey)) {
            return response()->json(['success' => false, 'error' => 'AI_TOKEN (или HYDRA_AI_KEY) не задан в .env'], 500);
        }

        $model = config('services.hydraai.vision_model', 'gpt-4o-mini');

        $response = Http::timeout(90)
            ->withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type'  => 'application/json',
            ])
            ->post('https://api.hydraai.ru/v1/chat/completions', [
                'model'       => $model,
                'messages'    => [
                    [
                        'role'    => 'user',
                        'content' => [
                            ['type' => 'text', 'text' => $prompt],
                            ['type' => 'image_url', 'image_url' => ['url' => $imageUrl]],
                        ],
                    ],
                ],
                'max_tokens'  => 150,
                'temperature' => 0.5,
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

        $result = trim($result);
        $result = trim($result, "\"'«»");
        $result = preg_replace('/\s+/', ' ', $result) ?? $result;

        if (mb_strlen($result) > 125) {
            $result = mb_substr($result, 0, 125);
        }

        return response()->json(['success' => true, 'result' => $result]);
    }

    private function callTextModel(string $prompt, int $maxTokens): JsonResponse
    {
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
                'max_tokens'  => $maxTokens,
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

    private function resolveImageForApi(string $image): ?string
    {
        $image = trim($image);

        if ($image === '') {
            return null;
        }

        if (str_starts_with($image, 'data:')) {
            return $image;
        }

        if (str_starts_with($image, 'http://') || str_starts_with($image, 'https://')) {
            return $image;
        }

        $path = $image;
        if (str_starts_with($path, '//')) {
            return 'https:' . $path;
        }

        if (str_starts_with($path, '/storage/')) {
            $relativePath = ltrim(str_replace('/storage/', '', $path), '/');
            if (Storage::disk('public')->exists($relativePath)) {
                $mime = Storage::disk('public')->mimeType($relativePath) ?: 'image/jpeg';
                $binary = Storage::disk('public')->get($relativePath);

                return 'data:' . $mime . ';base64,' . base64_encode($binary);
            }
        }

        if (Storage::disk('public')->exists(ltrim($path, '/'))) {
            $relativePath = ltrim($path, '/');
            $mime = Storage::disk('public')->mimeType($relativePath) ?: 'image/jpeg';
            $binary = Storage::disk('public')->get($relativePath);

            return 'data:' . $mime . ';base64,' . base64_encode($binary);
        }

        $publicPath = public_path(ltrim($path, '/'));
        if (is_file($publicPath)) {
            $mime = mime_content_type($publicPath) ?: 'image/jpeg';

            return 'data:' . $mime . ';base64,' . base64_encode(file_get_contents($publicPath));
        }

        return rtrim(config('app.url'), '/') . '/' . ltrim($path, '/');
    }
}
