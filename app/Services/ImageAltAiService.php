<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class ImageAltAiService
{
    public function generate(string $image, string $title = '', string $context = ''): array
    {
        $imageUrl = $this->resolveImageForApi($image);

        if ($imageUrl === null) {
            return [
                'success' => false,
                'error'   => 'Не удалось прочитать изображение',
            ];
        }

        $apiKey = config('services.hydraai.key');

        if (empty($apiKey)) {
            return [
                'success' => false,
                'error'   => 'AI_TOKEN (или HYDRA_AI_KEY) не задан в .env',
            ];
        }

        $title = strip_tags($title);
        $context = strip_tags(mb_substr($context, 0, 500));

        $prompt = "Ты SEO-специалист. Сайт reprobad.com — репродуктивное здоровье, подготовка к беременности, система РЕПРО.\n"
            . "Посмотри на изображение и напиши короткий alt-текст для SEO (до 125 символов).\n"
            . "Alt должен описывать то, что видно на фото, быть уникальным и полезным для поиска.\n"
            . "Не начинай с «изображение», «фото», «картинка». Без кавычек. Только русский язык. Одна строка.\n\n"
            . ($title ? "Заголовок материала: {$title}\n" : '')
            . ($context ? "Контекст материала: {$context}\n" : '');

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
            return [
                'success' => false,
                'error'   => 'Ошибка API: ' . $response->status(),
            ];
        }

        $data   = $response->json();
        $result = $data['choices'][0]['message']['content'] ?? null;

        if (empty($result)) {
            return [
                'success' => false,
                'error'   => 'Пустой ответ от AI',
            ];
        }

        $result = trim($result);
        $result = trim($result, "\"'«»");
        $result = preg_replace('/\s+/', ' ', $result) ?? $result;

        if (mb_strlen($result) > 125) {
            $result = mb_substr($result, 0, 125);
        }

        return [
            'success' => true,
            'result'  => $result,
        ];
    }

    public function resolveImageForApi(string $image): ?string
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
                return $this->fileToDataUrl(Storage::disk('public')->path($relativePath));
            }
        }

        $relativePath = ltrim($path, '/');
        if (Storage::disk('public')->exists($relativePath)) {
            return $this->fileToDataUrl(Storage::disk('public')->path($relativePath));
        }

        $publicPath = public_path($relativePath);
        if (is_file($publicPath)) {
            return $this->fileToDataUrl($publicPath);
        }

        return rtrim(config('app.url'), '/') . '/' . $relativePath;
    }

    private function fileToDataUrl(string $path): string
    {
        $mime = mime_content_type($path) ?: 'image/jpeg';

        return 'data:' . $mime . ';base64,' . base64_encode(file_get_contents($path));
    }
}
