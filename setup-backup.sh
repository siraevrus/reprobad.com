#!/bin/bash

# Скрипт автоматической настройки бэкапа базы данных
# Использование: ./setup-backup.sh

set -e

echo "=== НАСТРОЙКА АВТОМАТИЧЕСКОГО БЭКАПА БАЗЫ ДАННЫХ ==="
echo ""

# Путь к проекту
PROJECT_PATH="/var/www/repro"
BACKUP_SCRIPT="$PROJECT_PATH/backup-database.sh"
BACKUP_DIR="$PROJECT_PATH/storage/backups"

# Проверка, что скрипт существует
if [ ! -f "$BACKUP_SCRIPT" ]; then
    echo "❌ Ошибка: Скрипт backup-database.sh не найден в $PROJECT_PATH"
    echo "   Убедитесь, что вы выполнили git pull"
    exit 1
fi

# 1. Создание директории для бэкапов
echo "1. Создание директории для бэкапов..."
mkdir -p "$BACKUP_DIR"
chmod 755 "$BACKUP_DIR"
echo "   ✅ Директория создана: $BACKUP_DIR"

# 2. Установка прав на скрипт
echo ""
echo "2. Установка прав на скрипт бэкапа..."
chmod +x "$BACKUP_SCRIPT"
echo "   ✅ Права установлены"

# 3. Тестовый запуск скрипта
echo ""
echo "3. Тестовый запуск скрипта бэкапа..."
cd "$PROJECT_PATH"
if "$BACKUP_SCRIPT"; then
    echo "   ✅ Тестовый бэкап создан успешно"
    
    # Показ информации о созданном бэкапе
    LATEST_BACKUP=$(ls -t "$BACKUP_DIR"/backup_*.sql* 2>/dev/null | head -1)
    if [ -n "$LATEST_BACKUP" ]; then
        BACKUP_SIZE=$(du -h "$LATEST_BACKUP" | cut -f1)
        echo "   📦 Последний бэкап: $(basename "$LATEST_BACKUP") ($BACKUP_SIZE)"
    fi
else
    echo "   ⚠️  Предупреждение: Тестовый запуск завершился с ошибкой"
    echo "   Проверьте логи: $PROJECT_PATH/storage/logs/backup.log"
fi

# 4. Проверка текущих cron задач
echo ""
echo "4. Проверка текущих cron задач..."
CURRENT_CRON=$(crontab -l 2>/dev/null || echo "")

if echo "$CURRENT_CRON" | grep -q "backup-database.sh"; then
    echo "   ✅ Cron задача для бэкапа уже настроена"
    echo ""
    echo "   Текущая задача:"
    echo "$CURRENT_CRON" | grep "backup-database.sh"
else
    echo "   ⚠️  Cron задача для бэкапа не найдена"
    echo ""
    echo "5. Добавление cron задачи..."
    echo ""
    echo "   Выберите частоту бэкапов:"
    echo "   1) Ежедневно в 2:00 ночи (рекомендуется)"
    echo "   2) Ежедневно в 3:00 ночи"
    echo "   3) Каждые 6 часов"
    echo "   4) Еженедельно (понедельник в 2:00)"
    echo "   5) Пропустить (добавить вручную позже)"
    echo ""
    read -p "   Ваш выбор (1-5): " choice
    
    case $choice in
        1)
            CRON_TIME="0 2 * * *"
            ;;
        2)
            CRON_TIME="0 3 * * *"
            ;;
        3)
            CRON_TIME="0 */6 * * *"
            ;;
        4)
            CRON_TIME="0 2 * * 1"
            ;;
        5)
            echo "   Пропущено. Добавьте вручную:"
            echo "   crontab -e"
            echo "   Добавьте строку:"
            echo "   0 2 * * * $BACKUP_SCRIPT >> $PROJECT_PATH/storage/logs/backup-cron.log 2>&1"
            exit 0
            ;;
        *)
            echo "   Неверный выбор. Пропущено."
            exit 0
            ;;
    esac
    
    CRON_LINE="$CRON_TIME $BACKUP_SCRIPT >> $PROJECT_PATH/storage/logs/backup-cron.log 2>&1"
    
    # Добавление задачи в crontab
    (crontab -l 2>/dev/null; echo "$CRON_LINE") | crontab -
    
    echo "   ✅ Cron задача добавлена:"
    echo "   $CRON_LINE"
fi

# 6. Финальная проверка
echo ""
echo "=== ПРОВЕРКА НАСТРОЙКИ ==="
echo ""

# Проверка crontab
echo "Текущие cron задачи:"
crontab -l | grep -E "(backup-database|schedule:run|certbot)" || echo "   (не найдено)"

echo ""
echo "Директория бэкапов:"
ls -lh "$BACKUP_DIR" 2>/dev/null | head -5 || echo "   (пусто)"

echo ""
echo "=== НАСТРОЙКА ЗАВЕРШЕНА ==="
echo ""
echo "📝 Полезные команды:"
echo "   Просмотр бэкапов: ls -lh $BACKUP_DIR"
echo "   Просмотр логов: tail -f $PROJECT_PATH/storage/logs/backup.log"
echo "   Ручной запуск: $BACKUP_SCRIPT"
echo "   Проверка cron: crontab -l"
