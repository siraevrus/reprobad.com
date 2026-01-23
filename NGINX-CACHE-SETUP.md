# Настройка кеширования в Nginx

## Пошаговая инструкция

### Шаг 1: Определите расположение конфигурации Nginx

Обычно конфигурационные файлы Nginx находятся в одной из следующих директорий:
- `/etc/nginx/sites-available/` (Ubuntu/Debian)
- `/etc/nginx/conf.d/` (CentOS/RHEL)
- `/etc/nginx/nginx.conf` (основной файл)

### Шаг 2: Найдите конфигурацию вашего сайта

```bash
# На Ubuntu/Debian
ls -la /etc/nginx/sites-available/

# На CentOS/RHEL
ls -la /etc/nginx/conf.d/
```

Обычно файл называется по имени домена, например: `reprobad.com` или `default`.

### Шаг 3: Откройте конфигурационный файл для редактирования

```bash
# Замените your-site на имя вашего файла конфигурации
sudo nano /etc/nginx/sites-available/your-site
# или
sudo nano /etc/nginx/conf.d/your-site.conf
```

### Шаг 4: Добавьте блоки кеширования

Найдите блок `server { ... }` и добавьте следующие блоки `location` **ПЕРЕД** основным блоком `location /`:

```nginx
server {
    listen 80;
    server_name your-domain.com;
    root /var/www/your-app/public;

    # ... существующие настройки ...

    # ⬇️ ДОБАВЬТЕ ЭТИ БЛОКИ НИЖЕ ⬇️

    # JavaScript файлы - кешируем на 1 год
    location ~* \.(js)$ {
        expires 1y;
        add_header Cache-Control "public, immutable";
        access_log off;
        log_not_found off;
    }

    # CSS файлы - кешируем на 1 год
    location ~* \.(css)$ {
        expires 1y;
        add_header Cache-Control "public, immutable";
        access_log off;
        log_not_found off;
    }

    # Изображения - кешируем на 1 год
    location ~* \.(jpg|jpeg|png|gif|ico|svg|webp|avif)$ {
        expires 1y;
        add_header Cache-Control "public, immutable";
        access_log off;
        log_not_found off;
    }

    # Шрифты - кешируем на 1 год
    location ~* \.(woff|woff2|ttf|eot)$ {
        expires 1y;
        add_header Cache-Control "public, immutable";
        access_log off;
        log_not_found off;
    }

    # ⬆️ КОНЕЦ ДОБАВЛЕННЫХ БЛОКОВ ⬆️

    # Основной location для Laravel (должен быть ПОСЛЕ блоков кеширования)
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    # ... остальные настройки ...
}
```

### Шаг 5: Проверьте синтаксис конфигурации

```bash
sudo nginx -t
```

Если все правильно, вы увидите:
```
nginx: the configuration file /etc/nginx/nginx.conf syntax is ok
nginx: configuration file /etc/nginx/nginx.conf test is successful
```

### Шаг 6: Перезагрузите Nginx

```bash
# Перезагрузка конфигурации без остановки сервера
sudo systemctl reload nginx

# Или полная перезагрузка
sudo systemctl restart nginx
```

### Шаг 7: Проверьте работу кеширования

Откройте сайт в браузере и проверьте заголовки ответа:

1. Откройте DevTools (F12)
2. Перейдите на вкладку Network
3. Обновите страницу (F5)
4. Найдите любой `.js` файл (например, `head.js`)
5. Откройте его и проверьте заголовки Response Headers

Вы должны увидеть:
```
Cache-Control: public, immutable
Expires: [дата через год]
```

## Полный пример конфигурации

См. файл `nginx.conf.example` в корне проекта для полного примера конфигурации.

## Важные замечания

1. **Порядок блоков важен!** Блоки кеширования должны быть **ПЕРЕД** основным `location /`, иначе они не будут работать.

2. **Версионирование файлов**: Мы используем версионирование через `md5_file()` в Blade шаблонах (например, `/js/head.js?v=abc123`). Это позволяет обновлять кеш при изменении файлов.

3. **`immutable`**: Заголовок `immutable` говорит браузеру, что файл никогда не изменится, что позволяет агрессивное кеширование.

4. **`access_log off`**: Отключает логирование для статических файлов, что уменьшает нагрузку на диск.

## Troubleshooting

### Если кеширование не работает:

1. Проверьте порядок блоков `location` - блоки кеширования должны быть перед `location /`
2. Убедитесь, что файлы действительно находятся в `public/js/`, `public/css/` и т.д.
3. Проверьте права доступа к файлам: `ls -la /var/www/your-app/public/js/`
4. Проверьте логи Nginx: `sudo tail -f /var/log/nginx/error.log`

### Если нужно временно отключить кеширование:

Закомментируйте блоки кеширования:
```nginx
# location ~* \.(js)$ {
#     expires 1y;
#     ...
# }
```

Затем перезагрузите Nginx: `sudo systemctl reload nginx`
