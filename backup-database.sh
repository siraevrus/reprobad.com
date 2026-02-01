#!/bin/bash

# Скрипт для автоматического бэкапа базы данных MySQL
# Использование: ./backup-database.sh

# Цвета для вывода
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Путь к проекту
PROJECT_PATH="/var/www/repro"
BACKUP_DIR="$PROJECT_PATH/storage/backups"
LOG_FILE="$PROJECT_PATH/storage/logs/backup.log"

# Создание директории для бэкапов если её нет
mkdir -p "$BACKUP_DIR"
mkdir -p "$(dirname "$LOG_FILE")"

# Функция для логирования
log() {
    echo "[$(date '+%Y-%m-%d %H:%M:%S')] $1" | tee -a "$LOG_FILE"
}

# Переход в директорию проекта
cd "$PROJECT_PATH" || {
    log "${RED}Ошибка: Не удалось перейти в директорию проекта${NC}"
    exit 1
}

# Проверка наличия .env файла
if [ ! -f ".env" ]; then
    log "${RED}Ошибка: Файл .env не найден${NC}"
    exit 1
fi

# Загрузка переменных окружения из .env
export $(grep -v '^#' .env | grep -v '^$' | xargs)

# Получение параметров подключения к БД
DB_HOST="${DB_HOST:-127.0.0.1}"
DB_PORT="${DB_PORT:-3306}"
DB_DATABASE="${DB_DATABASE:-laravel}"
DB_USERNAME="${DB_USERNAME:-root}"
DB_PASSWORD="${DB_PASSWORD:-}"

# Проверка наличия mysqldump
if ! command -v mysqldump &> /dev/null; then
    log "${RED}Ошибка: mysqldump не найден. Установите mysql-client${NC}"
    exit 1
fi

# Формирование имени файла бэкапа с датой и временем
BACKUP_FILE="$BACKUP_DIR/backup_${DB_DATABASE}_$(date +%Y%m%d_%H%M%S).sql"

# Создание бэкапа
log "${YELLOW}Начало создания бэкапа базы данных: $DB_DATABASE${NC}"

if [ -z "$DB_PASSWORD" ]; then
    mysqldump -h "$DB_HOST" -P "$DB_PORT" -u "$DB_USERNAME" \
        --single-transaction \
        --quick \
        --lock-tables=false \
        "$DB_DATABASE" > "$BACKUP_FILE" 2>> "$LOG_FILE"
else
    mysqldump -h "$DB_HOST" -P "$DB_PORT" -u "$DB_USERNAME" -p"$DB_PASSWORD" \
        --single-transaction \
        --quick \
        --lock-tables=false \
        "$DB_DATABASE" > "$BACKUP_FILE" 2>> "$LOG_FILE"
fi

# Проверка результата
if [ $? -eq 0 ] && [ -f "$BACKUP_FILE" ] && [ -s "$BACKUP_FILE" ]; then
    # Сжатие бэкапа
    if command -v gzip &> /dev/null; then
        gzip "$BACKUP_FILE"
        BACKUP_FILE="${BACKUP_FILE}.gz"
        log "${GREEN}Бэкап успешно создан и сжат: $BACKUP_FILE${NC}"
    else
        log "${GREEN}Бэкап успешно создан: $BACKUP_FILE${NC}"
    fi
    
    # Получение размера файла
    FILE_SIZE=$(du -h "$BACKUP_FILE" | cut -f1)
    log "${GREEN}Размер бэкапа: $FILE_SIZE${NC}"
    
    # Удаление старых бэкапов (старше 30 дней)
    log "${YELLOW}Очистка старых бэкапов (старше 30 дней)...${NC}"
    find "$BACKUP_DIR" -name "backup_*.sql*" -type f -mtime +30 -delete 2>> "$LOG_FILE"
    DELETED_COUNT=$(find "$BACKUP_DIR" -name "backup_*.sql*" -type f -mtime +30 2>/dev/null | wc -l)
    if [ "$DELETED_COUNT" -gt 0 ]; then
        log "${GREEN}Удалено старых бэкапов: $DELETED_COUNT${NC}"
    else
        log "${GREEN}Старых бэкапов для удаления не найдено${NC}"
    fi
    
    # Показ информации о текущих бэкапах
    BACKUP_COUNT=$(find "$BACKUP_DIR" -name "backup_*.sql*" -type f | wc -l)
    log "${GREEN}Всего бэкапов в директории: $BACKUP_COUNT${NC}"
    
    exit 0
else
    log "${RED}Ошибка: Не удалось создать бэкап${NC}"
    if [ -f "$BACKUP_FILE" ]; then
        rm -f "$BACKUP_FILE"
    fi
    exit 1
fi
