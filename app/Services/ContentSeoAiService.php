<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Advise;
use App\Models\Article;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ContentSeoAiService
{
    /** @var list<class-string<Model>> */
    public const SUPPORTED_MODELS = [
        Article::class,
        Advise::class,
    ];

    public function __construct(
        private readonly ImageAltAiService $imageAltAiService,
    ) {}

    public static function needsFill(Model $model): bool
    {
        if (! self::supports($model)) {
            return false;
        }

        if (blank($model->seo_description) || blank($model->seo_keywords)) {
            return filled(strip_tags((string) ($model->content ?? '')));
        }

        return blank($model->image_alt) && filled($model->image);
    }

    public static function supports(Model $model): bool
    {
        return in_array($model::class, self::SUPPORTED_MODELS, true);
    }

    /**
     * @return list<string> обновлённые поля
     */
    public function fillMissingFields(Model $model): array
    {
        if (! self::supports($model)) {
            return [];
        }

        if (empty(config('services.hydraai.key'))) {
            Log::warning('ContentSeoAiService: AI key not configured');

            return [];
        }

        $model->refresh();

        $title = strip_tags((string) ($model->title ?? ''));
        $content = strip_tags((string) ($model->content ?? ''));
        $context = strip_tags((string) ($model->description ?? ''))
            ?: mb_substr($content, 0, 500);

        $updates = [];

        if (blank($model->seo_description) && filled($content)) {
            $result = $this->generateDescription($content, $title);
            if ($result['success'] ?? false) {
                $updates['seo_description'] = $result['result'];
            } else {
                Log::warning('ContentSeoAiService: seo_description failed', [
                    'model' => $model::class,
                    'id' => $model->getKey(),
                    'error' => $result['error'] ?? 'unknown',
                ]);
            }
        }

        if (blank($model->seo_keywords) && filled($content)) {
            $result = $this->generateKeywords($content);
            if ($result['success'] ?? false) {
                $updates['seo_keywords'] = $result['result'];
            } else {
                Log::warning('ContentSeoAiService: seo_keywords failed', [
                    'model' => $model::class,
                    'id' => $model->getKey(),
                    'error' => $result['error'] ?? 'unknown',
                ]);
            }
        }

        if (blank($model->image_alt) && filled($model->image)) {
            $result = $this->imageAltAiService->generate(
                (string) $model->image,
                $title,
                $context,
            );
            if ($result['success'] ?? false) {
                $updates['image_alt'] = $result['result'];
            } else {
                Log::warning('ContentSeoAiService: image_alt failed', [
                    'model' => $model::class,
                    'id' => $model->getKey(),
                    'error' => $result['error'] ?? 'unknown',
                ]);
            }
        }

        if ($updates === []) {
            return [];
        }

        $model->refresh();
        $safeUpdates = [];

        foreach ($updates as $field => $value) {
            if (blank($model->{$field})) {
                $safeUpdates[$field] = $value;
            }
        }

        if ($safeUpdates === []) {
            return [];
        }

        $model->update($safeUpdates);

        Log::info('ContentSeoAiService: fields filled', [
            'model' => $model::class,
            'id' => $model->getKey(),
            'fields' => array_keys($safeUpdates),
        ]);

        return array_keys($safeUpdates);
    }

    /** @return array{success: bool, result?: string, error?: string} */
    public function generateKeywords(string $content): array
    {
        $content = strip_tags($content);

        $prompt = "Ты seo копирайтер, напиши 10-14 слов или словосочетаний из статьи на сайте.\n"
            . "Необходимо подобрать и использовать слова и словосочетания, которые реально отражают содержание страницы.\n"
            . "Избегайте «накрутки»: не добавляйте нерелевантные или избыточные ключевые слова.\n"
            . "Ориентируйтесь на здравый смысл при составлении списка, а не на попытки «обмануть» поисковый алгоритм. "
            . "Подобранные слова формируй через запятую.\n\n"
            . "Текст статьи:\n" . $content;

        return $this->callTextModel($prompt, 300);
    }

    /** @return array{success: bool, result?: string, error?: string} */
    public function generateDescription(string $content, string $title = ''): array
    {
        $content = strip_tags($content);
        $title = strip_tags($title);

        $prompt = "Ты seo копирайтер, напиши одно описание до 180 символов из статьи на сайте.\n"
            . "Стремитесь к лаконичности и информативности: описание должно кратко передавать суть страницы и быть полезным для пользователя.\n"
            . "Рекомендуется создавать уникальное описание для каждой страницы.\n"
            . "Можно включать в текст полезную для пользователя информацию: цену товара, его характеристики, город доставки и т. д.\n"
            . "Убедитесь, что description отражает содержимое страницы, содержит правильно выстроенные предложения, "
            . "без злоупотребления ключевыми словами, фразами, заглавными буквами, рекламными лозунгами и пр.\n"
            . "Убедитесь, что description отличается от содержимого элемента Заголовок.\n\n"
            . ($title ? "Заголовок: {$title}\n\n" : '')
            . "Текст статьи:\n" . $content;

        return $this->callTextModel($prompt, 300);
    }

    /** @return array{success: bool, result?: string, error?: string} */
    private function callTextModel(string $prompt, int $maxTokens): array
    {
        $apiKey = config('services.hydraai.key');

        if (empty($apiKey)) {
            return [
                'success' => false,
                'error' => 'AI_TOKEN (или HYDRA_AI_KEY) не задан в .env',
            ];
        }

        $model = config('services.hydraai.model', 'deepseek-v3.2');

        $response = Http::timeout(60)
            ->withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type' => 'application/json',
            ])
            ->post('https://api.hydraai.ru/v1/chat/completions', [
                'model' => $model,
                'messages' => [
                    ['role' => 'user', 'content' => $prompt],
                ],
                'max_tokens' => $maxTokens,
                'temperature' => 0.7,
            ]);

        if ($response->failed()) {
            return [
                'success' => false,
                'error' => 'Ошибка API: ' . $response->status(),
            ];
        }

        $data = $response->json();
        $result = $data['choices'][0]['message']['content'] ?? null;

        if (empty($result)) {
            return [
                'success' => false,
                'error' => 'Пустой ответ от AI',
            ];
        }

        return [
            'success' => true,
            'result' => trim($result),
        ];
    }
}
