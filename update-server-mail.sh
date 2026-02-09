#!/bin/bash

SERVER="root@45.131.41.102"
SERVER_PATH="/var/www/repro"
SERVER_ENV="$SERVER_PATH/.env"

echo "=== ОБНОВЛЕНИЕ НАСТРОЕК ПОЧТЫ НА СЕРВЕРЕ ==="
echo ""

# Новые настройки почты
MAIL_HOST="smtp.msndr.net"
MAIL_PORT="587"
MAIL_USERNAME="ruslan@siraev.ru"
MAIL_PASSWORD="fee6ddd6f5ee429263e7f9c7f0963684"
MAIL_ENCRYPTION="tls"
MAIL_FROM_ADDRESS="ruslan@siraev.ru"
MAIL_FROM_NAME="Система РЕПРО"

echo "Обновление настроек почты на сервере..."
echo ""

# Обновляем настройки через SSH
ssh "$SERVER" << EOF
cd $SERVER_PATH

# Создаем резервную копию .env
cp .env .env.backup.\$(date +%Y%m%d_%H%M%S)

# Обновляем настройки почты
sed -i 's|^MAIL_HOST=.*|MAIL_HOST=$MAIL_HOST|' .env
sed -i 's|^MAIL_PORT=.*|MAIL_PORT=$MAIL_PORT|' .env
sed -i 's|^MAIL_USERNAME=.*|MAIL_USERNAME=$MAIL_USERNAME|' .env
sed -i 's|^MAIL_PASSWORD=.*|MAIL_PASSWORD=$MAIL_PASSWORD|' .env
sed -i 's|^MAIL_ENCRYPTION=.*|MAIL_ENCRYPTION=$MAIL_ENCRYPTION|' .env
sed -i 's|^MAIL_FROM_ADDRESS=.*|MAIL_FROM_ADDRESS="$MAIL_FROM_ADDRESS"|' .env
sed -i 's|^MAIL_FROM_NAME=.*|MAIL_FROM_NAME="$MAIL_FROM_NAME"|' .env

# Удаляем MAIL_TO_ADDRESS, если он есть
sed -i '/^MAIL_TO_ADDRESS=/d' .env

# Очищаем кеш конфигурации Laravel
php artisan config:clear
php artisan cache:clear

echo "✅ Настройки почты обновлены!"
echo ""
echo "Проверка обновленных настроек:"
grep "^MAIL_" .env
EOF

echo ""
echo "=== ГОТОВО ==="
echo ""
echo "Для проверки выполните:"
echo "  ssh $SERVER 'grep \"^MAIL_\" $SERVER_ENV'"
