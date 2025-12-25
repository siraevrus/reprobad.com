<?php

namespace App\Console\Commands;

use App\Models\Advise;
use App\Models\Article;
use App\Models\Complex;
use App\Models\Event;
use App\Models\Point;
use App\Models\Product;
use App\Models\Question;
use App\Services\ImageService;
use App\Services\InputService;
use Illuminate\Console\Command;

class ConvertBase64ImagesToFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'images:convert-base64-to-files {--dry-run : Показать что будет конвертировано без выполнения}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Конвертирует все base64 изображения в БД в файлы';

    /**
     * Модели и их поля с изображениями
     */
    protected array $modelsConfig = [
        Product::class => [
            'single' => ['image', 'photo', 'logo', 'image_left', 'image_right'],
            'gallery' => ['images']
        ],
        Article::class => [
            'single' => ['image', 'icon'],
            'gallery' => []
        ],
        Advise::class => [
            'single' => ['image'],
            'gallery' => []
        ],
        Complex::class => [
            'single' => ['image_left', 'image_right'],
            'gallery' => []
        ],
        Event::class => [
            'single' => ['image', 'logo'],
            'gallery' => ['images']
        ],
        Point::class => [
            'single' => ['image'],
            'gallery' => []
        ],
        Question::class => [
            'single' => ['icon'],
            'gallery' => []
        ],
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
            $this->info('🚀 Начинаю конвертацию base64 изображений в файлы...');
        }

        $totalConverted = 0;

        foreach ($this->modelsConfig as $modelClass => $config) {
            $this->info("\n📦 Обработка модели: " . class_basename($modelClass));
            
            $converted = $this->processModel($modelClass, $config, $dryRun);
            $totalConverted += $converted;
            
            $this->info("   ✅ Конвертировано: {$converted} записей");
        }

        $this->info("\n✨ Готово! Всего конвертировано: {$totalConverted} записей");
        
        return Command::SUCCESS;
    }

    /**
     * Обработка одной модели
     */
    protected function processModel(string $modelClass, array $config, bool $dryRun): int
    {
        $converted = 0;
        $model = new $modelClass;
        
        // Обработка одиночных полей
        foreach ($config['single'] as $field) {
            $records = $modelClass::whereNotNull($field)
                ->where($field, '<>', '')
                ->where($field, 'like', 'data:%')
                ->get();

            foreach ($records as $record) {
                if ($dryRun) {
                    $this->line("   [DRY-RUN] {$model->getTable()}#{$record->id} -> {$field}");
                } else {
                    InputService::uploadFile($record->$field, $record, $field);
                    $this->line("   ✓ {$model->getTable()}#{$record->id} -> {$field}");
                }
                $converted++;
            }
        }

        // Обработка галерей
        foreach ($config['gallery'] as $field) {
            $records = $modelClass::whereNotNull($field)
                ->where($field, '!=', '')
                ->get();

            foreach ($records as $record) {
                $images = $record->$field;
                
                if (!is_array($images)) {
                    continue;
                }

                $hasBase64 = false;
                $updatedImages = [];

                foreach ($images as $key => $image) {
                    if (!isset($image['url'])) {
                        continue;
                    }

                    $url = $image['url'];
                    
                    // Проверяем, является ли это base64
                    if (str_starts_with($url, 'data:')) {
                        $hasBase64 = true;
                        
                        if ($dryRun) {
                            $this->line("   [DRY-RUN] {$model->getTable()}#{$record->id} -> {$field}[{$key}]");
                        } else {
                            $class_name = strtolower(class_basename($record));
                            $path = ImageService::resize($url, 'png', $class_name . '/' . $record->id);
                            $image['url'] = $path;
                            $this->line("   ✓ {$model->getTable()}#{$record->id} -> {$field}[{$key}]");
                        }
                    }
                    
                    $updatedImages[$key] = $image;
                }

                if ($hasBase64 && !$dryRun) {
                    $record->$field = $updatedImages;
                    $record->save();
                    $converted++;
                } elseif ($hasBase64 && $dryRun) {
                    $converted++;
                }
            }
        }

        return $converted;
    }
}
