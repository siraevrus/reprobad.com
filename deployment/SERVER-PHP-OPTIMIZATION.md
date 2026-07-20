# Рекомендуемые настройки PHP/nginx/MySQL для VPS ~2GB (reprobad)

## PHP-FPM pool (`/etc/php/8.4/fpm/pool.d/www.conf`)
```
pm = dynamic
pm.max_children = 8
pm.start_servers = 2
pm.min_spare_servers = 1
pm.max_spare_servers = 3
pm.max_requests = 500
slowlog = /var/log/php8.4-fpm-slow.log
request_slowlog_timeout = 5s
request_terminate_timeout = 120s
```

## OPcache (`/etc/php/8.4/mods-available/opcache.ini`)
См. также `deployment/99-pcre-jit.ini`.
```
opcache.enable=1
opcache.validate_timestamps=0
opcache.revalidate_freq=0
opcache.memory_consumption=128
opcache.jit=tracing
opcache.jit_buffer_size=32M
```

После деплоя кода: `systemctl reload php8.4-fpm` (из‑за `validate_timestamps=0`).

## MySQL (`/etc/mysql/mysql.conf.d/mysqld.cnf`)
```
innodb_buffer_pool_size = 256M
```
(для БД ~30–50MB на 2GB RAM)

## Nginx
- `listen 443 ssl http2;`
- `server_tokens off;`
- gzip + expires на статику (уже в site config)

## Laravel `.env` (прод)
```
CACHE_STORE=file
SESSION_DRIVER=file
LOG_LEVEL=info
QUEUE_CONNECTION=database
```
