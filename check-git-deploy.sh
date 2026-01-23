#!/bin/bash

echo "=== ПРОВЕРКА ДЕПЛОЯ ИЗ GIT ==="
echo ""

# Цвета для вывода
GREEN='\033[0;32m'
RED='\033[0;31m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Проверка локального статуса
echo "1. Проверка локального git статуса:"
LOCAL_COMMIT=$(git rev-parse HEAD)
LOCAL_MESSAGE=$(git log -1 --pretty=format:"%h - %s")
echo "   Локальный коммит: ${LOCAL_COMMIT:0:8}"
echo "   Сообщение: $LOCAL_MESSAGE"

echo ""
echo "2. Проверка удаленного репозитория:"
git fetch origin 2>/dev/null
REMOTE_COMMIT=$(git rev-parse origin/master 2>/dev/null)

if [ -z "$REMOTE_COMMIT" ]; then
    echo "   ${RED}❌ Не удалось получить данные из удаленного репозитория${NC}"
    exit 1
fi

REMOTE_MESSAGE=$(git log -1 --pretty=format:"%h - %s" origin/master)
echo "   Удаленный коммит: ${REMOTE_COMMIT:0:8}"
echo "   Сообщение: $REMOTE_MESSAGE"

echo ""
echo "3. Сравнение коммитов:"
if [ "$LOCAL_COMMIT" = "$REMOTE_COMMIT" ]; then
    echo "   ${GREEN}✅ Локальная и удаленная ветки синхронизированы${NC}"
else
    echo "   ${YELLOW}⚠️  Локальная и удаленная ветки различаются${NC}"
    echo "   Локальный:  ${LOCAL_COMMIT:0:8}"
    echo "   Удаленный: ${REMOTE_COMMIT:0:8}"
    echo ""
    echo "   Выполните: git push origin master"
fi

echo ""
echo "4. Последние 5 коммитов в удаленном репозитории:"
git log origin/master --oneline -5

echo ""
echo "=== ИНСТРУКЦИИ ДЛЯ ПРОВЕРКИ НА СЕРВЕРЕ ==="
echo ""
echo "Выполните на сервере следующие команды (через SSH):"
echo ""
echo "${GREEN}1. Подключитесь к серверу:${NC}"
echo "   ssh user@your-server.com"
echo ""
echo "${GREEN}2. Перейдите в директорию проекта:${NC}"
echo "   cd /var/www/repro-ruslan  # или путь к вашему проекту"
echo ""
echo "${GREEN}3. Проверьте текущий коммит на сервере:${NC}"
echo "   git log --oneline -1"
echo "   git rev-parse HEAD"
echo ""
echo "${GREEN}4. Сравните с удаленным репозиторием:${NC}"
echo "   git fetch origin"
echo "   git log origin/master --oneline -1"
echo "   git rev-parse origin/master"
echo ""
echo "${GREEN}5. Если коммиты различаются, обновите код:${NC}"
echo "   git pull origin master"
echo ""
echo "${GREEN}6. Очистите кеш Laravel:${NC}"
echo "   php artisan view:clear"
echo "   php artisan cache:clear"
echo "   php artisan config:clear"
echo "   php artisan route:clear"
echo ""
echo "${GREEN}7. Проверьте конкретные файлы, которые были изменены:${NC}"
echo "   # Например, проверка файла логотипа:"
echo "   grep -A 5 'brand-text-mobile' resources/views/site/layouts/base.blade.php"
echo ""
echo "${GREEN}8. Проверьте GitHub Actions (если настроен CI/CD):${NC}"
echo "   https://github.com/flamedeluxe/repro-ruslan/actions"
echo ""
