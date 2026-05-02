#!/usr/bin/env bash
#
# Полное обновление приложения на продакшене (git pull + composer + migrate + кеши + PHP-FPM).
# Использование:
#   sudo -u www-data bash server-update.sh              # полный цикл с git pull
#   sudo bash server-update.sh --skip-pull              # только Laravel после уже выполненного git pull
# Переменные окружения:
#   APP_ROOT   каталог приложения (по умолчанию /var/www/repro)
#
set -euo pipefail

APP_ROOT="${APP_ROOT:-/var/www/repro}"
SKIP_PULL=false

while [[ "${1:-}" == --* ]]; do
    case "$1" in
        --skip-pull) SKIP_PULL=true ;;
        *) echo "Неизвестный аргумент: $1"; exit 1 ;;
    esac
    shift
done

cd "$APP_ROOT" || { echo "❌ Нет каталога $APP_ROOT"; exit 1; }

restart_php_fpm() {
    local restarted=false
    for svc in php8.4-fpm php8.3-fpm php8.2-fpm; do
        if systemctl is-active --quiet "${svc}" 2>/dev/null; then
            echo "   Перезапуск ${svc} (сброс OPcache в workers)..."
            systemctl restart "${svc}"
            restarted=true
            break
        fi
    done
    if [[ "$restarted" != true ]]; then
        echo "   ⚠️  Активный сервис php*-fpm не найден; при необходимости перезапустите PHP-FPM вручную."
    fi
}

laravel_refresh() {
    echo ""
    echo "=== Composer ==="
    if [[ -f composer.lock ]]; then
        composer install --no-dev --optimize-autoloader --no-interaction
    else
        echo "   (composer.lock нет, пропуск)"
    fi

    echo ""
    echo "=== Миграции ==="
    php artisan migrate --force

    echo ""
    echo "=== Сброс кешей Laravel ==="
    php artisan optimize:clear

    echo ""
    echo "=== Сборка оптимизированных кешей (config, routes, events, views) ==="
    php artisan optimize

    echo ""
    echo "=== PHP-FPM ==="
    restart_php_fpm

    echo ""
    echo "=== Sitemap (если команда есть) ==="
    if php artisan list | grep -q 'sitemap:generate'; then
        php artisan sitemap:generate
    else
        echo "   (команда sitemap:generate отсутствует, пропуск)"
    fi
}

echo "=== ОБНОВЛЕНИЕ: $APP_ROOT ==="

if [[ "$SKIP_PULL" == true ]]; then
    echo "Режим --skip-pull: git не трогаем."
    laravel_refresh
    echo ""
    echo "✅ Готово."
    exit 0
fi

echo ""
echo "1. Удаление конфликтующих неотслеживаемых файлов (стрелки слайдера)..."
CONFLICT_FILES=$(git status --porcelain 2>/dev/null | grep '^??' | awk '{print $2}' | grep -E '(left-arrow\.svg|right-arrow\.svg)' || true)
if [[ -n "$CONFLICT_FILES" ]]; then
    while IFS= read -r file; do
        [[ -z "$file" ]] && continue
        if [[ -f "$file" ]]; then
            echo "   Удаление: $file"
            rm -f "$file"
        fi
    done <<< "$CONFLICT_FILES"
else
    echo "   Нет конфликтующих файлов."
fi

echo ""
echo "2. Git: fetch / pull master..."
git fetch origin
LOCAL=$(git rev-parse HEAD)
REMOTE=$(git rev-parse origin/master)

if [[ "$LOCAL" == "$REMOTE" ]]; then
    echo "   Код уже совпадает с origin/master (${LOCAL:0:8})."
else
    echo "   Обновление ${LOCAL:0:8} → ${REMOTE:0:8}..."
    git pull origin master
fi

laravel_refresh

echo ""
echo "✅ ОБНОВЛЕНИЕ ЗАВЕРШЕНО"
