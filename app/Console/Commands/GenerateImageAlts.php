<?php

namespace App\Console\Commands;

use App\Models\Advise;
use App\Models\Article;
use App\Services\ImageAltAiService;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;

class GenerateImageAlts extends Command
{
    protected $signature = 'content:generate-image-alts
                            {--type=all : articles, advises or all}
                            {--force : Перезаписать существующие alt}
                            {--dry-run : Только показать, без сохранения}
                            {--sleep=1 : Пауза между запросами к AI (сек)}
                            {--id= : Обработать только одну запись}';

    protected $description = 'Генерирует SEO alt для фото во всех статьях и советах через AI';

    public function handle(ImageAltAiService $imageAltAiService): int
    {
        $type = $this->option('type');
        $force = (bool) $this->option('force');
        $dryRun = (bool) $this->option('dry-run');
        $sleep = max(0, (int) $this->option('sleep'));
        $id = $this->option('id');

        if (empty(config('services.hydraai.key'))) {
            $this->error('AI_TOKEN (или HYDRA_AI_KEY) не задан в .env');

            return self::FAILURE;
        }

        $stats = [
            'processed' => 0,
            'updated' => 0,
            'skipped' => 0,
            'failed' => 0,
        ];

        if ($type === 'all' || $type === 'articles') {
            $this->processModel(Article::class, 'Статьи', $imageAltAiService, $force, $dryRun, $sleep, $id, $stats);
        }

        if ($type === 'all' || $type === 'advises') {
            $this->processModel(Advise::class, 'Советы', $imageAltAiService, $force, $dryRun, $sleep, $id, $stats);
        }

        if ($type !== 'all' && $type !== 'articles' && $type !== 'advises') {
            $this->error('Неверный --type. Используйте: articles, advises или all');

            return self::FAILURE;
        }

        $this->newLine();
        $this->info('Итого:');
        $this->line("  обработано: {$stats['processed']}");
        $this->line("  обновлено: {$stats['updated']}");
        $this->line("  пропущено: {$stats['skipped']}");
        $this->line("  ошибок: {$stats['failed']}");

        if ($dryRun) {
            $this->warn('Режим dry-run: изменения не сохранены.');
        }

        return $stats['failed'] > 0 ? self::FAILURE : self::SUCCESS;
    }

    private function processModel(
        string $modelClass,
        string $label,
        ImageAltAiService $imageAltAiService,
        bool $force,
        bool $dryRun,
        int $sleep,
        ?string $id,
        array &$stats,
    ): void {
        $query = $modelClass::query()
            ->whereNotNull('image')
            ->where('image', '!=', '');

        if ($id !== null && $id !== '') {
            $query->where('id', $id);
        }

        if (! $force) {
            $query->where(function ($builder) {
                $builder->whereNull('image_alt')->orWhere('image_alt', '');
            });
        }

        $items = $query->orderBy('id')->get();

        $this->info($label . ': найдено ' . $items->count());

        foreach ($items as $item) {
            $stats['processed']++;

            /** @var Model $item */
            $title = strip_tags((string) $item->title);
            $context = strip_tags((string) ($item->description ?: mb_substr((string) $item->content, 0, 500)));

            $this->line("→ [{$item->id}] {$title}");

            if (! $force && filled($item->image_alt)) {
                $this->comment('  пропуск: alt уже заполнен');
                $stats['skipped']++;

                continue;
            }

            $result = $imageAltAiService->generate((string) $item->image, $title, $context);

            if (! $result['success']) {
                $this->error('  ошибка: ' . ($result['error'] ?? 'неизвестная'));
                $stats['failed']++;

                continue;
            }

            $alt = $result['result'];
            $this->info("  alt: {$alt}");

            if (! $dryRun) {
                $item->image_alt = $alt;
                $item->save();
                $stats['updated']++;
            } else {
                $stats['updated']++;
            }

            if ($sleep > 0) {
                sleep($sleep);
            }
        }
    }
}
