#!/bin/bash

echo "=== ОБНОВЛЕНИЕ КОДА НА СЕРВЕРЕ ==="
echo ""

# Удаление конфликтующих файлов
echo "1. Удаление конфликтующих файлов..."
rm -f /var/www/repro/public/images/left-arrow.svg
rm -f /var/www/repro/public/images/right-arrow.svg
echo "   ✅ Файлы удалены"

# Обновление кода из git
echo ""
echo "2. Обновление кода из git..."
cd /var/www/repro
git fetch origin
git pull origin master

# Проверка результата
if [ $? -eq 0 ]; then
    echo "   ✅ Код успешно обновлен"
    CURRENT_COMMIT=$(git rev-parse HEAD)
    echo "   Текущий коммит: ${CURRENT_COMMIT:0:8}"
else
    echo "   ❌ Ошибка при обновлении кода"
    exit 1
fi

# Очистка кеша Laravel
echo ""
echo "3. Очистка кеша Laravel..."
php artisan view:clear
php artisan cache:clear
php artisan config:clear
php artisan route:clear
echo "   ✅ Кеш очищен"

echo ""
echo "=== ОБНОВЛЕНИЕ ЗАВЕРШЕНО ==="
