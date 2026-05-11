<?php

namespace App\Console\Commands;

use App\Mail\TestResultMail;
use App\Models\TestResult;
use App\Services\TestCalculationService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TestEmailCommand extends Command
{
    protected $signature = 'test:email
        {email=ruslan@siraev.ru : Адрес получателя}
        {--all-clear : Все ответы 0 (сценарий «всё в норме»)}
        {--answer=2 : Балл для всех 24 ответов (0..3), если не задан --result-id}
        {--result-id= : Использовать существующий TestResult из БД}
        {--save : Сохранить тестовый результат в БД (иначе только в памяти)}';

    protected $description = 'Отправить тестовое письмо. Данные (текст рекомендаций и фото продуктов) берутся из админки через TestResultField — как и при реальной отправке.';

    public function handle(TestCalculationService $calc): int
    {
        $email = (string) $this->argument('email');
        $resultId = $this->option('result-id');
        $allClear = (bool) $this->option('all-clear');
        $value = max(0, min(3, (int) $this->option('answer')));
        $save = (bool) $this->option('save');

        try {
            if ($resultId !== null && $resultId !== '') {
                $testResult = TestResult::query()->findOrFail((int) $resultId);
                $this->info("Использую существующий TestResult #{$testResult->id}.");
            } else {
                $answers = $allClear ? array_fill(0, 24, 0) : array_fill(0, 24, $value);
                $this->info('Расчёт результата через TestCalculationService (используется БД test_result_fields)...');
                $results = $calc->calculate($answers);

                $testResult = new TestResult;
                $testResult->email = $email;
                $testResult->answers = $answers;
                $testResult->results = $results;

                if ($save) {
                    $testResult->save();
                    $this->info("Тестовый результат сохранён в БД, id #{$testResult->id}.");
                }
            }
        } catch (\Throwable $e) {
            $this->error('Не удалось подготовить данные: '.$e->getMessage());
            $this->line('Подсказка: команда требует доступ к БД, чтобы взять тексты «email_description» и изображения image1/image2 из админки. Запускайте на сервере, где БД доступна, либо передайте --result-id существующего результата.');

            return Command::FAILURE;
        }

        $this->info("Отправка письма на {$email}...");

        try {
            Mail::to($email)->send(new TestResultMail($testResult));
            $this->info('✓ Письмо успешно отправлено!');

            return Command::SUCCESS;
        } catch (\Throwable $e) {
            $this->error('✗ Ошибка при отправке письма: '.$e->getMessage());
            $this->error($e->getTraceAsString());

            return Command::FAILURE;
        }
    }
}
