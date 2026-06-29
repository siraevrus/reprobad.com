<?php

namespace App\Console\Commands;

use App\Models\Advise;
use App\Models\Article;
use App\Services\CleanWordHtmlService;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;

class CleanWordHtmlContent extends Command
{
    protected $signature = 'content:clean-word-html
                            {--dry-run : Показать изменения без сохранения}
                            {--only= : Обработать только articles или advises}';

    protected $description = 'Очистить Word-HTML в content и description статей и советов';

    /** @var array<class-string<Model>, list<string>> */
    private array $modelsConfig = [
        Article::class => ['content', 'description'],
        Advise::class => ['content', 'description'],
    ];

    public function handle(CleanWordHtmlService $cleaner): int
    {
        $dryRun = (bool) $this->option('dry-run');
        $only = $this->option('only');

        if ($only !== null && ! in_array($only, ['articles', 'advises'], true)) {
            $this->error('Опция --only принимает значения: articles, advises');

            return self::FAILURE;
        }

        if ($dryRun) {
            $this->warn('Режим dry-run: изменения в БД не сохраняются.');
        }

        $stats = [
            'records' => 0,
            'updated' => 0,
            'fields' => 0,
        ];

        foreach ($this->modelsConfig as $modelClass => $fields) {
            $label = $this->modelLabel($modelClass);

            if ($only !== null && $only !== $label) {
                continue;
            }

            $this->info("Обработка: {$label}");

            /** @var Model $modelClass */
            $modelClass::query()
                ->orderBy('id')
                ->chunkById(50, function ($records) use ($cleaner, $fields, $dryRun, &$stats, $label): void {
                    foreach ($records as $record) {
                        $stats['records']++;
                        $changes = [];

                        foreach ($fields as $field) {
                            $original = $record->{$field};
                            if (! is_string($original) || trim($original) === '') {
                                continue;
                            }

                            $cleaned = $cleaner->clean($original);
                            if ($cleaned === $original) {
                                continue;
                            }

                            $changes[$field] = $cleaned;
                            $stats['fields']++;
                        }

                        if ($changes === []) {
                            continue;
                        }

                        $stats['updated']++;
                        $this->line("  #{$record->id} {$record->title}");

                        if (! $dryRun) {
                            $record->fill($changes);
                            $record->save();
                        }
                    }
                });
        }

        $this->newLine();
        $this->info("Проверено записей: {$stats['records']}");
        $this->info("Будет обновлено записей: {$stats['updated']}");
        $this->info("Очищено полей: {$stats['fields']}");

        if ($dryRun && $stats['updated'] > 0) {
            $this->newLine();
            $this->comment('Запустите без --dry-run, чтобы сохранить изменения.');
        }

        return self::SUCCESS;
    }

    /** @param class-string<Model> $modelClass */
    private function modelLabel(string $modelClass): string
    {
        return match ($modelClass) {
            Article::class => 'articles',
            Advise::class => 'advises',
            default => class_basename($modelClass),
        };
    }
}
