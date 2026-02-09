<?php

/**
 * Скрипт для проверки отправки писем из раздела /test
 * 
 * Использование:
 * php check-test-email.php [email]
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\TestResultMail;
use App\Models\TestResult;

$email = $argv[1] ?? 'ruslan@siraev.ru';

echo "========================================\n";
echo "Проверка отправки писем из раздела /test\n";
echo "========================================\n\n";

// 1. Проверка настроек почты
echo "1. Проверка настроек почты:\n";
echo "   MAIL_MAILER: " . env('MAIL_MAILER', 'не установлен') . "\n";
echo "   MAIL_HOST: " . env('MAIL_HOST', 'не установлен') . "\n";
echo "   MAIL_PORT: " . env('MAIL_PORT', 'не установлен') . "\n";
echo "   MAIL_USERNAME: " . env('MAIL_USERNAME', 'не установлен') . "\n";
echo "   MAIL_ENCRYPTION: " . env('MAIL_ENCRYPTION', 'не установлен') . "\n";
echo "   MAIL_FROM_ADDRESS: " . env('MAIL_FROM_ADDRESS', 'не установлен') . "\n";
echo "   QUEUE_CONNECTION: " . env('QUEUE_CONNECTION', 'sync') . "\n";
echo "\n";

// 2. Проверка логов на ошибки
echo "2. Проверка последних ошибок в логах:\n";
$logFile = storage_path('logs/laravel.log');
if (file_exists($logFile)) {
    $logContent = file_get_contents($logFile);
    $errorPattern = '/Ошибка отправки письма с результатами теста.*/';
    if (preg_match_all($errorPattern, $logContent, $matches)) {
        echo "   Найдены ошибки отправки писем:\n";
        foreach (array_slice($matches[0], -5) as $error) {
            echo "   - " . trim($error) . "\n";
        }
    } else {
        echo "   Ошибок отправки писем в логах не найдено\n";
    }
    
    // Проверка общих ошибок SMTP
    if (preg_match_all('/SMTP.*error|Connection.*failed|Authentication.*failed/i', $logContent, $smtpMatches)) {
        echo "\n   Найдены ошибки SMTP:\n";
        foreach (array_slice($smtpMatches[0], -5) as $error) {
            echo "   - " . trim($error) . "\n";
        }
    }
} else {
    echo "   Лог файл не найден: {$logFile}\n";
}
echo "\n";

// 3. Проверка очереди
echo "3. Проверка очереди писем:\n";
$queueConnection = env('QUEUE_CONNECTION', 'sync');
if ($queueConnection === 'database') {
    try {
        $jobsCount = \DB::table('jobs')->count();
        $failedJobsCount = \DB::table('failed_jobs')->count();
        echo "   Ожидающих заданий в очереди: {$jobsCount}\n";
        echo "   Неудачных заданий: {$failedJobsCount}\n";
        
        if ($jobsCount > 0) {
            echo "   ⚠️  ВНИМАНИЕ: Есть задания в очереди! Запустите: php artisan queue:work\n";
        }
        
        if ($failedJobsCount > 0) {
            echo "   ⚠️  ВНИМАНИЕ: Есть неудачные задания! Проверьте: php artisan queue:failed\n";
        }
    } catch (\Exception $e) {
        echo "   Ошибка при проверке очереди: " . $e->getMessage() . "\n";
    }
} else {
    echo "   Очередь не используется (синхронная отправка)\n";
}
echo "\n";

// 4. Тест отправки письма
echo "4. Тест отправки письма на {$email}:\n";
try {
    // Создаем тестовый результат
    $testResult = new TestResult();
    $testResult->email = $email;
    $testResult->answers = array_fill(0, 24, 2);
    $testResult->results = [
        'scores' => [
            'category1' => 12,
            'category2' => 16,
            'category3' => 10,
            'category4' => 11,
        ],
        'results' => [
            [
                'field_number' => 1,
                'description' => 'Тестовое описание',
                'email_description' => 'Тестовое описание для проверки отправки письма',
                'color' => null,
                'image1' => '/images/test/repro-relax-1.webp',
                'link1' => '/product-protect#first',
                'image2' => '/images/test/repro-relax-2.webp',
                'link2' => '/product-protect#second',
                'score' => 4,
            ],
        ],
        'hasResults' => true,
    ];
    
    // Отправляем синхронно (не через очередь)
    Mail::to($email)->send(new TestResultMail($testResult));
    
    echo "   ✓ Письмо успешно отправлено!\n";
    echo "   Проверьте почтовый ящик {$email}\n";
    
} catch (\Exception $e) {
    echo "   ✗ Ошибка при отправке письма:\n";
    echo "   Сообщение: " . $e->getMessage() . "\n";
    echo "   Файл: " . $e->getFile() . ":" . $e->getLine() . "\n";
    echo "\n   Детали ошибки:\n";
    echo "   " . str_replace("\n", "\n   ", $e->getTraceAsString()) . "\n";
    
    // Дополнительная диагностика
    if (strpos($e->getMessage(), 'SMTP') !== false || strpos($e->getMessage(), 'Connection') !== false) {
        echo "\n   💡 Рекомендации:\n";
        echo "   - Проверьте настройки SMTP в .env файле\n";
        echo "   - Убедитесь, что сервер smtp.msndr.net доступен\n";
        echo "   - Проверьте правильность логина и пароля\n";
        echo "   - Проверьте, не блокирует ли firewall порт 587\n";
    }
}

echo "\n========================================\n";
echo "Проверка завершена\n";
echo "========================================\n";
