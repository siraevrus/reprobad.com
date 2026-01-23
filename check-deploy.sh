#!/bin/bash

echo "=== ПРОВЕРКА ДЕПЛОЯ ==="
echo ""

# Проверка локального файла
echo "1. Проверка локального файла:"
if [ -f "resources/views/admin/components/image-crop-input.blade.php" ]; then
    LINES=$(wc -l < resources/views/admin/components/image-crop-input.blade.php)
    echo "   ✅ Файл существует (${LINES} строк)"
    
    # Проверка наличия нового кода
    if grep -q "image-crop-container" resources/views/admin/components/image-crop-input.blade.php; then
        echo "   ✅ Новый код присутствует (image-crop-container найден)"
    else
        echo "   ❌ Новый код не найден!"
    fi
else
    echo "   ❌ Файл не найден!"
fi

echo ""
echo "2. Проверка git статуса:"
git status --short

echo ""
echo "3. Последние коммиты:"
git log --oneline -5

echo ""
echo "4. Проверка удаленного репозитория:"
git fetch origin 2>/dev/null
LOCAL=$(git rev-parse HEAD)
REMOTE=$(git rev-parse origin/master 2>/dev/null)

if [ "$LOCAL" = "$REMOTE" ]; then
    echo "   ✅ Локальная и удаленная ветки синхронизированы"
else
    echo "   ⚠️  Локальная и удаленная ветки различаются"
    echo "   Локальный:  $LOCAL"
    echo "   Удаленный: $REMOTE"
fi

echo ""
echo "=== ИНСТРУКЦИИ ПО ПРОВЕРКЕ ==="
echo ""
echo "1. Проверьте GitHub Actions:"
echo "   https://github.com/flamedeluxe/repro-ruslan/actions"
echo ""
echo "2. Проверьте файл на сервере (если есть SSH доступ):"
echo "   ssh user@server 'wc -l /var/www/repro/resources/views/admin/components/image-crop-input.blade.php'"
echo ""
echo "3. Очистите кеш Laravel на сервере:"
echo "   php artisan view:clear"
echo "   php artisan cache:clear"
echo ""
