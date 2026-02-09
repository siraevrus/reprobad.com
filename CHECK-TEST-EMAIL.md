# Проверка отправки писем из раздела /test

## Быстрая проверка

Запустите скрипт диагностики:
```bash
php check-test-email.php [email]
```

Например:
```bash
php check-test-email.php ruslan@siraev.ru
```

Скрипт проверит:
1. ✅ Настройки почты в `.env`
2. ✅ Ошибки в логах
3. ✅ Состояние очереди писем
4. ✅ Отправит тестовое письмо

## Возможные проблемы и решения

### 1. Письма попадают в очередь, но не отправляются

**Проблема:** В `.env` установлено `QUEUE_CONNECTION=database`, но воркер очереди не запущен.

**Решение:**
```bash
# Запустите воркер очереди
php artisan queue:work

# Или в фоновом режиме (рекомендуется для продакшена)
php artisan queue:work --daemon
```

**Для продакшена** добавьте в cron:
```bash
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```

Или используйте supervisor для постоянной работы воркера.

### 2. Ошибки SMTP подключения

**Проверьте:**
- Доступность сервера `smtp.msndr.net` на порту 587
- Правильность логина и пароля в `.env`
- Не блокирует ли firewall порт 587

**Тест подключения:**
```bash
telnet smtp.msndr.net 587
```

### 3. Проверка логов

Просмотр последних ошибок:
```bash
tail -n 100 storage/logs/laravel.log | grep "Ошибка отправки письма"
```

Или все ошибки:
```bash
tail -f storage/logs/laravel.log
```

### 4. Использование команды Laravel

Также доступна команда для тестирования:
```bash
php artisan test:email ruslan@siraev.ru
```

### 5. Проверка неудачных заданий в очереди

Если письма попадают в очередь и не отправляются:
```bash
# Просмотр неудачных заданий
php artisan queue:failed

# Повторная попытка отправки
php artisan queue:retry all

# Очистка неудачных заданий
php artisan queue:flush
```

## Настройки в .env

Убедитесь, что в `.env` правильно настроены:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.msndr.net
MAIL_PORT=587
MAIL_USERNAME=ruslan@siraev.ru
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="ruslan@siraev.ru"
MAIL_FROM_NAME="Система РЕПРО"

# Если хотите синхронную отправку (без очереди):
QUEUE_CONNECTION=sync

# Если используете очередь:
QUEUE_CONNECTION=database
```

## Отладка в коде

В контроллере `TestController::subscribe()` теперь логируется:
- Попытка отправки письма
- Успешная отправка
- Детальная информация об ошибках (если есть)

Все логи сохраняются в `storage/logs/laravel.log`.
