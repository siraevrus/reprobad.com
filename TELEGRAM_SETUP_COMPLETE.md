# Telegram бот - Настройка завершена

## ✅ Что сделано:

1. **Добавлен токен в .env:**
   ```
   TELEGRAM_BOT_TOKEN=8384124270:AAFC6InbJbYG3FwrQ4nas5qHAYNeBcvu_6g
   ```

2. **Webhook настроен:**
   - URL: `https://reprobad.com/api/telegram/webhook`
   - Статус: активен
   - Ожидающих сообщений: 0

3. **Проверки:**
   - ✅ Маршрут существует: `POST api/telegram/webhook`
   - ✅ Endpoint отвечает: `{"status":"ok"}`
   - ✅ Миграция выполнена: `chat_history` таблица создана
   - ✅ System prompt настроен
   - ✅ Бот активен: `@reprobad_bot`

## 🧪 Тестирование:

### Способ 1: Telegram приложение

1. Найдите бота: **@reprobad_bot**
2. Нажмите `/start` или отправьте любое сообщение
3. Бот должен ответить

### Способ 2: Через API

```bash
# Отправить сообщение как будто от Telegram
curl -X POST "https://reprobad.com/api/telegram/webhook" \
  -H "Content-Type: application/json" \
  -d '{
    "message": {
      "chat": {"id": 123456},
      "text": "Привет!",
      "from": {"first_name": "Test"}
    }
  }'
```

## 📊 Мониторинг:

### Просмотр логов в реальном времени:

```bash
ssh repro "cd /var/www/repro && tail -f storage/logs/laravel.log | grep -E 'Telegram|Bot chat'"
```

### Проверка последних логов:

```bash
ssh repro "cd /var/www/repro && tail -50 storage/logs/laravel.log"
```

### Проверка webhook статуса:

```bash
curl -s "https://api.telegram.org/bot8384124270:AAFC6InbJbYG3FwrQ4nas5qHAYNeBcvu_6g/getWebhookInfo" | python3 -m json.tool
```

## 🔍 Если бот не отвечает:

### 1. Проверить логи на ошибки:

```bash
ssh repro "cd /var/www/repro && grep ERROR storage/logs/laravel.log | tail -20"
```

### 2. Проверить права доступа:

```bash
ssh repro "cd /var/www/repro && ls -la storage/logs/"
```

### 3. Проверить таблицу chat_history:

```bash
ssh repro "cd /var/www/repro && php artisan tinker --execute='echo DB::table(\"chat_history\")->exists() ? \"Table exists\" : \"Table not found\";'"
```

### 4. Проверить BotService:

```bash
ssh repro "cd /var/www/repro && php artisan tinker --execute='echo class_exists(\"App\\\\Services\\\\BotService\") ? \"Service OK\" : \"Service not found\";'"
```

## 📝 Информация о боте:

- **Username:** @reprobad_bot
- **ID:** 8384124270
- **Token:** 8384124270:AAFC6InbJbYG3FwrQ4nas5qHAYNeBcvu_6g
- **Webhook:** https://reprobad.com/api/telegram/webhook
- **Статус:** Активен

## ⚠️ Возможные проблемы:

### Бот не отвечает:

1. **Проблема с BotService API:**
   - Проверьте, что API ключ настроен
   - Проверьте доступ к RAG API

2. **Проблема с базой данных:**
   - Проверьте подключение к БД
   - Проверьте, что таблица chat_history создана

3. **Проблема с конфигурацией:**
   - Очистите кэш: `php artisan config:clear`
   - Проверьте .env файл

## 🎯 Следующие шаги:

1. Отправьте сообщение боту в Telegram
2. Проверьте, что он отвечает
3. Проверьте логи на наличие записей
4. Отправьте несколько сообщений для проверки памяти

## ✨ Готово!

Бот настроен и готов к работе. Отправьте ему сообщение в Telegram для проверки.

