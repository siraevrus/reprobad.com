# Telegram relay (прокладка)

Сервер с доступом к `api.telegram.org` принимает **webhook** от Telegram, дергает **РЕПРО** (`POST /api/telegram/relay/process`), отправляет ответ пользователю через Telegram API. На **РЕПРО** не нужен исходящий доступ к Telegram (ни прокси, ни polling).

## На стороне РЕПРО

1. В `.env` задать длинный случайный секрет:
   - `TELEGRAM_RELAY_INBOUND_SECRET=...`
2. Опционально убрать `TELEGRAM_HTTP_PROXY` и останов `telegram:poll`.
3. `php artisan config:clear` и деплой.

## На VPS-реле

1. `cp config.example.env .env` и заполнить переменные.
2. `REPRO_RELAY_SECRET` = тот же текст, что `TELEGRAM_RELAY_INBOUND_SECRET` на РЕПРО.
3. `REPRO_RELAY_URL` = `https://<ваш-домен>/api/telegram/relay/process` (с той же схемы, что открыт с реле).
4. Nginx: раздавать каталог, все запросы на `relay.php` (пример ниже).
5. У BotFather / `setWebhook` указать URL реле (например `https://relay.example.com/relay.php`) и тот же `secret_token`, что `TELEGRAM_WEBHOOK_SECRET` на реле.

### Пример Nginx

```nginx
server {
    root /var/www/telegram-relay;
    location / {
        try_files $uri /relay.php$is_args$args;
    }
    location = /relay.php {
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $document_root/relay.php;
        fastcgi_pass unix:/run/php/php8.2-fpm.sock;
    }
}
```

Проверка: `curl -sS 'https://relay.example.com/'` → `{"status":"telegram-relay","ok":true}`.

## Безопасность

- Не коммитить `.env` реле.
- Ограничить по IP только если есть фиксированные IP Telegram (обычно проще секрет в webhook + сильный `REPRO_RELAY_SECRET`).
