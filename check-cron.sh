#!/bin/bash

# Скрипт для проверки настроен ли cron для Laravel Scheduler
# Использование: ./check-cron.sh

echo "=== Проверка настроек Laravel Scheduler (Cron) ==="
echo ""

# Путь к проекту (можно изменить)
PROJECT_PATH="/var/www/repro"

# Проверка существования проекта
if [ ! -d "$PROJECT_PATH" ]; then
    echo "❌ Ошибка: Директория проекта не найдена: $PROJECT_PATH"
    echo "   Укажите правильный путь к проекту в переменной PROJECT_PATH"
    exit 1
fi

cd "$PROJECT_PATH" || exit 1

echo "📁 Путь к проекту: $PROJECT_PATH"
echo ""

# Проверка текущего пользователя
CURRENT_USER=$(whoami)
echo "👤 Текущий пользователь: $CURRENT_USER"
echo ""

# Проверка crontab для текущего пользователя
echo "🔍 Проверка crontab для пользователя $CURRENT_USER:"
echo "---"

CRON_JOBS=$(crontab -l 2>/dev/null)

if [ -z "$CRON_JOBS" ]; then
    echo "❌ Cron не настроен для пользователя $CURRENT_USER"
    echo ""
    echo "📝 Для настройки выполните:"
    echo "   crontab -e"
    echo "   Добавьте строку:"
    echo "   * * * * * cd $PROJECT_PATH && php artisan schedule:run >> /dev/null 2>&1"
else
    echo "✅ Найдены следующие cron задачи:"
    echo "$CRON_JOBS" | grep -v "^#"
    echo ""
    
    # Проверка наличия Laravel schedule:run
    if echo "$CRON_JOBS" | grep -q "schedule:run"; then
        echo "✅ Laravel Scheduler настроен!"
        SCHEDULE_LINE=$(echo "$CRON_JOBS" | grep "schedule:run")
        echo "   Найдена строка: $SCHEDULE_LINE"
    else
        echo "❌ Laravel Scheduler НЕ настроен"
        echo ""
        echo "📝 Для настройки выполните:"
        echo "   crontab -e"
        echo "   Добавьте строку:"
        echo "   * * * * * cd $PROJECT_PATH && php artisan schedule:run >> /dev/null 2>&1"
    fi
fi

echo ""
echo "---"
echo ""

# Проверка работы Laravel планировщика
echo "🔍 Проверка запланированных задач Laravel:"
echo "---"

if [ -f "artisan" ]; then
    php artisan schedule:list 2>/dev/null
    if [ $? -eq 0 ]; then
        echo ""
        echo "✅ Laravel планировщик работает корректно"
    else
        echo "⚠️  Не удалось получить список задач планировщика"
    fi
else
    echo "❌ Файл artisan не найден в $PROJECT_PATH"
fi

echo ""
echo "=== Проверка завершена ==="
