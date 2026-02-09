#!/bin/bash

# Скрипт для обновления кода на сервере
# Выполните на сервере: bash update-server.sh

echo "=== ОБНОВЛЕНИЕ КОДА НА СЕРВЕРЕ ==="
echo ""

cd /var/www/repro || { echo "❌ Ошибка: директория /var/www/repro не найдена"; exit 1; }

# Проверка текущего коммита
echo "Текущий коммит на сервере:"
git log --oneline -1
echo ""

# Получение изменений из GitHub
echo "Получение изменений из GitHub..."
git fetch origin

# Проверка наличия новых коммитов
LOCAL=$(git rev-parse HEAD)
REMOTE=$(git rev-parse origin/master)

if [ "$LOCAL" = "$REMOTE" ]; then
    echo "✅ Код уже актуален (коммит: ${LOCAL:0:8})"
    exit 0
fi

echo "Обновление с ${LOCAL:0:8} до ${REMOTE:0:8}..."
echo ""

# Обновление кода
echo "Выполнение git pull..."
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
