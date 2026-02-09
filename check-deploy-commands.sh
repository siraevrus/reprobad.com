#!/bin/bash

# Команды для проверки деплоя на продакшн сервере
# Выполните эти команды через SSH на сервере

echo "=== ПРОВЕРКА ДЕПЛОЯ НА СЕРВЕРЕ ==="
echo ""

# 1. Переход в директорию проекта
echo "1. Переход в директорию проекта..."
cd /var/www/repro

# 2. Проверка текущего коммита
echo ""
echo "2. Проверка текущего коммита на сервере:"
git log --oneline -1
echo ""
echo "Ожидаемый последний коммит: ed10fc4 - Оптимизирована предзагрузка: устранен FOUC, улучшен критический путь рендеринга"

# 3. Проверка синхронизации с origin/master
echo ""
echo "3. Проверка синхронизации с origin/master:"
git fetch origin
LOCAL=$(git rev-parse HEAD)
REMOTE=$(git rev-parse origin/master)
if [ "$LOCAL" = "$REMOTE" ]; then
    echo "✅ Локальная и удаленная ветки синхронизированы (${LOCAL:0:8})"
else
    echo "⚠️  Локальная и удаленная ветки различаются"
    echo "   Локальный:  ${LOCAL:0:8}"
    echo "   Удаленный: ${REMOTE:0:8}"
    echo "   Выполните: git pull origin master"
fi

# 4. Проверка наличия критических файлов
echo ""
echo "4. Проверка наличия критических файлов:"
FILES=(
    "resources/views/site/layouts/base.blade.php"
    "resources/views/site/test/index.blade.php"
    "app/Console/Commands/ImportTestData.php"
    "app/Console/Commands/TestEmailCommand.php"
    "app/Mail/TestResultMail.php"
    "app/Services/TestCalculationService.php"
    "public/images/test/reprotest-check.svg"
    "public/js/webflow-test.js"
)

for file in "${FILES[@]}"; do
    if [ -f "$file" ]; then
        echo "✅ $file"
    else
        echo "❌ $file - НЕ НАЙДЕН!"
    fi
done

# 5. Проверка миграций
echo ""
echo "5. Проверка статуса миграций:"
php artisan migrate:status | tail -10

# 6. Проверка таблиц тестовых данных
echo ""
echo "6. Проверка таблиц тестовых данных:"
php artisan tinker --execute="
echo 'test_results: ' . (Schema::hasTable('test_results') ? 'существует' : 'НЕ существует') . PHP_EOL;
echo 'test_questions: ' . (Schema::hasTable('test_questions') ? 'существует' : 'НЕ существует') . PHP_EOL;
echo 'test_result_fields: ' . (Schema::hasTable('test_result_fields') ? 'существует' : 'НЕ существует') . PHP_EOL;
"

# 7. Проверка количества данных
echo ""
echo "7. Проверка количества данных:"
php artisan tinker --execute="
echo 'Вопросов: ' . \App\Models\TestQuestion::count() . PHP_EOL;
echo 'Полей результатов: ' . \App\Models\TestResultField::count() . PHP_EOL;
echo 'Результатов тестов: ' . \App\Models\TestResult::count() . PHP_EOL;
"

# 8. Проверка кеша
echo ""
echo "8. Проверка кеша:"
php artisan config:clear
php artisan cache:clear
php artisan view:clear
echo "✅ Кеш очищен"

# 9. Проверка прав на файлы
echo ""
echo "9. Проверка прав на файлы:"
ls -la storage/app/public/testresultfield/ 2>/dev/null | head -5 || echo "Директория storage/app/public/testresultfield/ не существует"

# 10. Проверка последних изменений в base.blade.php
echo ""
echo "10. Проверка последних изменений в base.blade.php:"
if grep -q "css-loaded" resources/views/site/layouts/base.blade.php; then
    echo "✅ Изменения по оптимизации предзагрузки присутствуют"
else
    echo "❌ Изменения по оптимизации предзагрузки НЕ найдены"
fi

if grep -q "webflow.css.*stylesheet" resources/views/site/layouts/base.blade.php; then
    echo "✅ webflow.css загружается синхронно"
else
    echo "❌ webflow.css НЕ загружается синхронно"
fi

echo ""
echo "=== ПРОВЕРКА ЗАВЕРШЕНА ==="
