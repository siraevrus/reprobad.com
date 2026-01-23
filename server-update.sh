#!/bin/bash

echo "=== ОБНОВЛЕНИЕ КОДА НА СЕРВЕРЕ ==="
echo ""

# Переход в директорию проекта
cd /var/www/repro || { echo "❌ Ошибка: директория /var/www/repro не найдена"; exit 1; }

# Удаление конфликтующих неотслеживаемых файлов
echo "1. Проверка и удаление конфликтующих файлов..."
CONFLICT_FILES=$(git status --porcelain | grep "^??" | awk '{print $2}' | grep -E "(left-arrow\.svg|right-arrow\.svg)" || true)

if [ -n "$CONFLICT_FILES" ]; then
    echo "$CONFLICT_FILES" | while read file; do
        if [ -f "$file" ]; then
            echo "   Удаление: $file"
            rm -f "$file"
        fi
    done
    echo "   ✅ Конфликтующие файлы удалены"
else
    echo "   ✅ Конфликтующих файлов не найдено"
fi

# Обновление кода из git
echo ""
echo "2. Обновление кода из git..."
git fetch origin

# Проверка наличия изменений
LOCAL=$(git rev-parse HEAD)
REMOTE=$(git rev-parse origin/master)

if [ "$LOCAL" = "$REMOTE" ]; then
    echo "   ✅ Код уже актуален (коммит: ${LOCAL:0:8})"
else
    echo "   Обновление с ${LOCAL:0:8} до ${REMOTE:0:8}..."
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
