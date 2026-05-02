<?php

namespace App\Console\Commands;

use App\Models\TestQuestion;
use App\Models\TestResultField;
use App\Support\ReproTestBlocks;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ImportTestData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:import-data 
                            {action : export или import}
                            {--file=test-data.json : Путь к JSON файлу}
                            {--force : Перезаписать существующие данные}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Экспорт/импорт данных тестовых таблиц (test_questions, test_result_fields)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $action = $this->argument('action');
        $file = $this->option('file');

        if ($action === 'export') {
            return $this->exportData($file);
        } elseif ($action === 'import') {
            return $this->importData($file);
        } else {
            $this->error("Неизвестное действие: {$action}. Используйте 'export' или 'import'");

            return Command::FAILURE;
        }
    }

    /**
     * Экспорт данных в JSON файл
     */
    protected function exportData($filePath)
    {
        $this->info('Экспорт данных тестовых таблиц...');

        $data = [
            'test_questions' => [],
            'test_result_fields' => [],
            'exported_at' => now()->toDateTimeString(),
        ];

        // Экспорт вопросов
        $questions = TestQuestion::orderBy('order')->get();
        foreach ($questions as $question) {
            $data['test_questions'][] = [
                'question_text' => $question->question_text,
                'order' => $question->order,
                'block_number' => $question->block_number,
                'answers' => $question->answers,
                'active' => $question->active,
            ];
        }
        $this->info('Экспортировано вопросов: '.count($data['test_questions']));

        // Экспорт полей результатов
        $fields = TestResultField::orderBy('field_number')->get();
        foreach ($fields as $field) {
            $fieldData = [
                'field_number' => $field->field_number,
                'block_number' => $field->block_number,
                'description' => $field->description,
                'email_description' => $field->email_description,
                'color' => $field->color,
                'image1' => $field->image1,
                'link1' => $field->link1,
                'image2' => $field->image2,
                'link2' => $field->link2,
                'active' => $field->active,
                'order' => $field->order,
            ];

            // Копируем изображения, если они существуют
            if ($field->image1 && File::exists(public_path($field->image1))) {
                $imagePath = public_path($field->image1);
                $imageDir = storage_path('app/test-export/images/'.$field->id);
                File::ensureDirectoryExists($imageDir);
                File::copy($imagePath, $imageDir.'/image1'.pathinfo($field->image1, PATHINFO_EXTENSION));
                $fieldData['_image1_path'] = 'images/'.$field->id.'/image1'.pathinfo($field->image1, PATHINFO_EXTENSION);
            }

            if ($field->image2 && File::exists(public_path($field->image2))) {
                $imagePath = public_path($field->image2);
                $imageDir = storage_path('app/test-export/images/'.$field->id);
                File::ensureDirectoryExists($imageDir);
                File::copy($imagePath, $imageDir.'/image2'.pathinfo($field->image2, PATHINFO_EXTENSION));
                $fieldData['_image2_path'] = 'images/'.$field->id.'/image2'.pathinfo($field->image2, PATHINFO_EXTENSION);
            }

            $data['test_result_fields'][] = $fieldData;
        }
        $this->info('Экспортировано полей результатов: '.count($data['test_result_fields']));

        // Сохранение JSON файла
        $jsonPath = storage_path('app/test-export/'.$filePath);
        File::ensureDirectoryExists(dirname($jsonPath));
        File::put($jsonPath, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        $this->info("Данные экспортированы в: {$jsonPath}");
        $this->info('Изображения скопированы в: '.storage_path('app/test-export/images/'));

        return Command::SUCCESS;
    }

    /**
     * Импорт данных из JSON файла
     */
    protected function importData($filePath)
    {
        $this->info('Импорт данных тестовых таблиц...');

        $fullPath = storage_path('app/test-export/'.$filePath);

        if (! File::exists($fullPath)) {
            $this->error("Файл не найден: {$fullPath}");

            return Command::FAILURE;
        }

        $data = json_decode(File::get($fullPath), true);

        if (! $data) {
            $this->error('Ошибка чтения JSON файла');

            return Command::FAILURE;
        }

        DB::beginTransaction();

        try {
            // Импорт вопросов
            if (isset($data['test_questions'])) {
                $this->info('Импорт вопросов...');
                $imported = 0;
                $updated = 0;

                foreach ($data['test_questions'] as $questionData) {
                    $questionData = $this->normalizeQuestionImportRow($questionData);
                    $question = TestQuestion::where('order', $questionData['order'])->first();

                    if ($question) {
                        if ($this->option('force')) {
                            $question->update([
                                'question_text' => $questionData['question_text'],
                                'block_number' => $questionData['block_number'],
                                'answers' => $questionData['answers'],
                                'active' => $questionData['active'],
                            ]);
                            $updated++;
                        } else {
                            $this->warn("Вопрос с порядком {$questionData['order']} уже существует. Используйте --force для перезаписи.");
                        }
                    } else {
                        TestQuestion::create($questionData);
                        $imported++;
                    }
                }

                $this->info("Вопросов импортировано: {$imported}, обновлено: {$updated}");
            }

            // Импорт полей результатов
            if (isset($data['test_result_fields'])) {
                $this->info('Импорт полей результатов...');
                $imported = 0;
                $updated = 0;

                foreach ($data['test_result_fields'] as $fieldData) {
                    $fieldData = $this->normalizeResultFieldImportRow($fieldData);
                    $field = TestResultField::where('field_number', $fieldData['field_number'])->first();

                    // Сохраняем пути к изображениям для копирования
                    $image1Path = $fieldData['_image1_path'] ?? null;
                    $image2Path = $fieldData['_image2_path'] ?? null;
                    unset($fieldData['_image1_path'], $fieldData['_image2_path']);

                    if ($field) {
                        if ($this->option('force')) {
                            $field->update($fieldData);
                            $updated++;
                        } else {
                            $this->warn("Поле с номером {$fieldData['field_number']} уже существует. Используйте --force для перезаписи.");

                            continue;
                        }
                    } else {
                        $field = TestResultField::create($fieldData);
                        $imported++;
                    }

                    // Копирование изображений
                    if ($image1Path) {
                        $sourcePath = storage_path('app/test-export/'.$image1Path);
                        if (File::exists($sourcePath)) {
                            $destDir = public_path('storage/testresultfield/'.$field->id);
                            File::ensureDirectoryExists($destDir);
                            $ext = pathinfo($sourcePath, PATHINFO_EXTENSION);
                            $destPath = $destDir.'/image1.'.$ext;
                            File::copy($sourcePath, $destPath);
                            $field->update(['image1' => '/storage/testresultfield/'.$field->id.'/image1.'.$ext]);
                        }
                    }

                    if ($image2Path) {
                        $sourcePath = storage_path('app/test-export/'.$image2Path);
                        if (File::exists($sourcePath)) {
                            $destDir = public_path('storage/testresultfield/'.$field->id);
                            File::ensureDirectoryExists($destDir);
                            $ext = pathinfo($sourcePath, PATHINFO_EXTENSION);
                            $destPath = $destDir.'/image2.'.$ext;
                            File::copy($sourcePath, $destPath);
                            $field->update(['image2' => '/storage/testresultfield/'.$field->id.'/image2.'.$ext]);
                        }
                    }
                }

                $this->info("Полей результатов импортировано: {$imported}, обновлено: {$updated}");
            }

            DB::commit();
            $this->info('Импорт завершен успешно!');

            return Command::SUCCESS;
        } catch (\Exception $e) {
            DB::rollBack();
            $this->error('Ошибка при импорте: '.$e->getMessage());
            $this->error($e->getTraceAsString());

            return Command::FAILURE;
        }
    }

    /**
     * @param  array<string, mixed>  $questionData
     * @return array<string, mixed>
     */
    protected function normalizeQuestionImportRow(array $questionData): array
    {
        $order = (int) ($questionData['order'] ?? 0);
        if (! isset($questionData['block_number']) || $questionData['block_number'] === '' || $questionData['block_number'] === null) {
            try {
                $questionData['block_number'] = ReproTestBlocks::blockForQuestionOrder($order);
            } catch (\InvalidArgumentException) {
                $questionData['block_number'] = 1;
            }
        } else {
            $questionData['block_number'] = (int) $questionData['block_number'];
        }

        return $questionData;
    }

    /**
     * @param  array<string, mixed>  $fieldData
     * @return array<string, mixed>
     */
    protected function normalizeResultFieldImportRow(array $fieldData): array
    {
        $fieldNumber = (int) ($fieldData['field_number'] ?? 0);
        if (! isset($fieldData['block_number']) || $fieldData['block_number'] === '' || $fieldData['block_number'] === null) {
            $fieldData['block_number'] = ReproTestBlocks::blockForFieldNumber($fieldNumber) ?? 1;
        } else {
            $fieldData['block_number'] = (int) $fieldData['block_number'];
        }

        return $fieldData;
    }
}
