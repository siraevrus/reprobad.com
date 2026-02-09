#!/bin/bash

# Скрипт для исправления конфликта при обновлении на сервере
# Выполните на сервере: bash fix-server-update.sh

echo "=== ИСПРАВЛЕНИЕ КОНФЛИКТА ПРИ ОБНОВЛЕНИИ ==="
echo ""

cd /var/www/repro || { echo "❌ Ошибка: директория /var/www/repro не найдена"; exit 1; }

# Удаление конфликтующих неотслеживаемых файлов
echo "Удаление конфликтующих файлов из public/images/test/..."
rm -f public/images/test/reprotest-check.svg
rm -f public/images/test/reprotest-ic-1.svg
rm -f public/images/test/reprotest-ic-2.svg
rm -f public/images/test/reprotest-ic-3.svg
rm -f public/images/test/reprotest-ic-4.svg
rm -f public/images/test/reprotest-white-check.svg
rm -f public/images/test/test-cover-2-p-1080.webp
rm -f public/images/test/test-cover-2-p-1600.webp
rm -f public/images/test/test-cover-2-p-500.webp
rm -f public/images/test/test-cover-2-p-800.webp
rm -f public/images/test/test-cover-2.webp
rm -f public/images/test/test-cover-3-p-500.webp
rm -f public/images/test/test-cover-3-p-800.webp
rm -f public/images/test/test-cover-3.webp
rm -f public/images/test/test-cover-p-500.webp
rm -f public/images/test/test-cover-p-800.webp
rm -f public/images/test/test-cover.webp

echo "✅ Конфликтующие файлы удалены"
echo ""

# Теперь можно обновить код
echo "Обновление кода из GitHub..."
git fetch origin
git pull origin master

if [ $? -eq 0 ]; then
    echo ""
    echo "✅ Код успешно обновлен"
    CURRENT_COMMIT=$(git rev-parse HEAD)
    echo "Текущий коммит: ${CURRENT_COMMIT:0:8}"
    echo ""
    
    # Применение миграций
    echo "Применение миграций..."
    php artisan migrate --force
    
    # Очистка кеша
    echo ""
    echo "Очистка кеша..."
    php artisan config:clear
    php artisan cache:clear
    php artisan view:clear
    php artisan route:clear
    php artisan route:cache
    
    echo ""
    echo "=== ОБНОВЛЕНИЕ ЗАВЕРШЕНО ==="
else
    echo ""
    echo "❌ Ошибка при обновлении кода"
    exit 1
fi
