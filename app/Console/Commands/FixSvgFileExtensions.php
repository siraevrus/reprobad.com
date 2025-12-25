<?php

namespace App\Console\Commands;

use App\Models\Advise;
use App\Models\Article;
use App\Models\Complex;
use App\Models\Event;
use App\Models\Point;
use App\Models\Product;
use App\Models\Question;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class FixSvgFileExtensions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'images:fix-svg-extensions {--dry-run : Показать что будет исправлено без выполнения}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Исправляет расширения файлов .svg+xml на .svg и обновляет пути в БД';

    /**
     * Модели и их поля с изображениями
     */
    protected array $modelsConfig = [
        Product::class => ['image', 'photo', 'logo', 'image_left', 'image_right'],
        Article::class => ['image', 'icon'],
        Advise::class => ['image'],
        Complex::class => ['image_left', 'image_right'],
        Event::class => ['image', 'logo'],
        Point::class => ['image'],
        Question::class => ['icon'],
    ];

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $dryRun = $this->option('dry-run');
        
        if ($dryRun) {
            $this->info('🔍 Режим проверки (dry-run). Изменения не будут сохранены.');
        } else {
            $this->info('🚀 Начинаю исправление расширений SVG файлов...');
        }

        $totalFixed = 0;

        foreach ($this->modelsConfig as $modelClass => $fields) {
            $this->info("\n📦 Обработка модели: " . class_basename($modelClass));
            
            $fixed = $this->processModel($modelClass, $fields, $dryRun);
            $totalFixed += $fixed;
            
            $this->info("   ✅ Исправлено: {$fixed} записей");
        }

        $this->info("\n✨ Готово! Всего исправлено: {$totalFixed} записей");
        
        return Command::SUCCESS;
    }

    /**
     * Обработка одной модели
     */
    protected function processModel(string $modelClass, array $fields, bool $dryRun): int
    {
        $fixed = 0;
        
        foreach ($fields as $field) {
            $records = $modelClass::whereNotNull($field)
                ->where($field, '!=', '')
                ->where($field, 'like', '%svg+xml%')
                ->get();

            foreach ($records as $record) {
                $oldPath = $record->$field;
                
                // Убираем /storage/ префикс для работы с Storage
                $storagePath = str_replace('/storage/', '', $oldPath);
                
                // Проверяем существование файла
                if (!Storage::disk('public')->exists($storagePath)) {
                    $this->warn("   ⚠️  Файл не найден: {$storagePath}");
                    continue;
                }
                
                // Создаем новый путь с правильным расширением
                $newStoragePath = str_replace('.svg+xml', '.svg', $storagePath);
                $newPath = '/storage/' . $newStoragePath;
                
                if ($dryRun) {
                    $this->line("   [DRY-RUN] {$record->getTable()}#{$record->id} -> {$field}");
                    $this->line("            {$oldPath} -> {$newPath}");
                } else {
                    // Переименовываем файл
                    Storage::disk('public')->move($storagePath, $newStoragePath);
                    
                    // Обновляем путь в БД
                    $record->$field = $newPath;
                    $record->save();
                    
                    $this->line("   ✓ {$record->getTable()}#{$record->id} -> {$field}");
                }
                $fixed++;
            }
        }

        return $fixed;
    }
}
