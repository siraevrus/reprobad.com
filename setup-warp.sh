#!/bin/bash
# Установка Cloudflare WARP SOCKS5-прокси на российском VPS для обхода блокировки api.telegram.org.
# Запускать на сервере: ssh root@45.131.41.102 "bash /var/www/repro/setup-warp.sh"

set -e

REPRO_DIR="${REPRO_DIR:-/var/www/repro}"
ENV_FILE="$REPRO_DIR/.env"

echo "=== Шаг 1: Установка Docker (если не установлен) ==="
if ! command -v docker &>/dev/null; then
    apt-get update -q
    apt-get install -y ca-certificates curl gnupg lsb-release
    install -m 0755 -d /etc/apt/keyrings
    curl -fsSL https://download.docker.com/linux/ubuntu/gpg \
        | gpg --dearmor -o /etc/apt/keyrings/docker.gpg
    chmod a+r /etc/apt/keyrings/docker.gpg
    echo "deb [arch=$(dpkg --print-architecture) signed-by=/etc/apt/keyrings/docker.gpg] \
        https://download.docker.com/linux/ubuntu $(lsb_release -cs) stable" \
        > /etc/apt/sources.list.d/docker.list
    apt-get update -q
    apt-get install -y docker-ce docker-ce-cli containerd.io docker-compose-plugin
    systemctl enable --now docker
    echo "Docker установлен: $(docker --version)"
else
    echo "Docker уже установлен: $(docker --version)"
fi

echo ""
echo "=== Шаг 2: Запуск WARP-контейнера ==="
cd "$REPRO_DIR"
docker compose -f docker-compose.warp.yml pull
docker compose -f docker-compose.warp.yml up -d

echo "Ждём запуска WARP (15 сек)..."
sleep 15

echo ""
echo "=== Шаг 3: Проверка прокси ==="
if curl -s --max-time 10 --socks5-hostname 127.0.0.1:1080 https://api.telegram.org | grep -q "page"; then
    echo "OK: api.telegram.org доступен через WARP"
else
    echo "WARN: не удалось проверить через curl — проверьте вручную:"
    echo "  curl --socks5-hostname 127.0.0.1:1080 https://api.telegram.org"
fi

echo ""
echo "=== Шаг 4: Прокси в .env ==="
if grep -q "TELEGRAM_HTTP_PROXY" "$ENV_FILE" 2>/dev/null; then
    echo "TELEGRAM_HTTP_PROXY уже задан в .env:"
    grep "TELEGRAM_HTTP_PROXY" "$ENV_FILE"
    echo ""
    echo "Убедитесь, что строка НЕ закомментирована и равна:"
    echo "  TELEGRAM_HTTP_PROXY=socks5h://127.0.0.1:1080"
else
    echo "TELEGRAM_HTTP_PROXY=socks5h://127.0.0.1:1080" >> "$ENV_FILE"
    echo "Добавлено в .env: TELEGRAM_HTTP_PROXY=socks5h://127.0.0.1:1080"
fi

echo ""
echo "=== Шаг 5: Сброс кэша Laravel ==="
cd "$REPRO_DIR"
php artisan config:clear
php artisan config:cache
echo "Кэш конфигурации обновлён."

echo ""
echo "=== Готово ==="
echo "Webhook работает без прокси (Telegram сам стучится на 443)."
echo "Исходящие sendMessage/getUpdates — через WARP → Cloudflare → api.telegram.org."
echo ""
echo "Проверка логов:"
echo "  tail -f $REPRO_DIR/storage/logs/laravel.log | grep -i telegram"
echo ""
echo "Статус контейнера:"
echo "  docker ps --filter name=warp-proxy"
