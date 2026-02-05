# Инструкция по импорту данных тестовых таблиц на продакшн

## Шаг 1: Экспорт данных с локальной БД (уже выполнено)

Данные уже экспортированы в:
- `storage/app/test-export/test-data.json` - JSON файл с данными
- `storage/app/test-export/images/` - папка с изображениями
- `test-data-export.tar.gz` - архив для передачи на сервер

## Шаг 2: Передача данных на продакшн сервер

### Вариант А: Через SCP

```bash
# Передать архив на сервер
scp test-data-export.tar.gz user@your-server:/tmp/

# Или передать всю папку
scp -r storage/app/test-export user@your-server:/tmp/
```

### Вариант Б: Через Git (если файлы добавлены в репозиторий)

```bash
git add storage/app/test-export/test-data.json
git commit -m "Добавлены данные для импорта тестовых таблиц"
git push origin master
```

## Шаг 3: Импорт данных на продакшн сервере

### Подключитесь к серверу по SSH:

```bash
ssh user@your-server
cd /var/www/repro
```

### Распакуйте архив (если передавали через SCP):

```bash
# Распакуйте архив
tar -xzf /tmp/test-data-export.tar.gz -C storage/app/test-export/

# Или если передавали папку напрямую
cp -r /tmp/test-export/* storage/app/test-export/
```

### Запустите импорт:

```bash
# Импорт без перезаписи существующих данных
php artisan test:import-data import --file=test-data.json

# Или с перезаписью существующих данных (если нужно обновить)
php artisan test:import-data import --file=test-data.json --force
```

## Шаг 4: Проверка импорта

```bash
# Проверить количество вопросов
php artisan tinker --execute="echo 'Вопросов: ' . \App\Models\TestQuestion::count();"

# Проверить количество полей результатов
php artisan tinker --execute="echo 'Полей результатов: ' . \App\Models\TestResultField::count();"

# Проверить конкретное поле
php artisan tinker --execute="echo json_encode(\App\Models\TestResultField::where('field_number', 1)->first()->toArray(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);"
```

## Альтернативный способ: Прямой SQL импорт

Если у вас есть SQL дамп с данными тестовых таблиц:

```bash
# На сервере
mysql -u username -p database_name < test_tables.sql

# Или только для конкретных таблиц
mysql -u username -p database_name -e "USE database_name; SOURCE test_questions.sql;"
mysql -u username -p database_name -e "USE database_name; SOURCE test_result_fields.sql;"
```

## Структура экспортированных данных

Файл `test-data.json` содержит:
- `test_questions` - массив всех вопросов теста (24 вопроса)
- `test_result_fields` - массив полей результатов (9 полей)
- `exported_at` - дата и время экспорта

Каждое поле результата включает:
- `field_number` - номер поля (1-9)
- `description` - описание для сайта
- `email_description` - расширенное описание для email
- `color` - цвет блока (null, 'green', 'lavender', 'orange')
- `image1`, `image2` - пути к изображениям продуктов
- `link1`, `link2` - ссылки на продукты
- `active` - активность поля
- `order` - порядок сортировки

## Важные замечания

1. **Изображения**: При импорте изображения копируются в `public/storage/testresultfield/{id}/`. Убедитесь, что папка `storage/app/public` имеет символическую ссылку на `public/storage`.

2. **Права доступа**: После импорта проверьте права на файлы:
   ```bash
   chmod -R 775 storage/app/public/testresultfield
   chown -R www-data:www-data storage/app/public/testresultfield
   ```

3. **Очистка кеша**: После импорта очистите кеш:
   ```bash
   php artisan cache:clear
   php artisan config:clear
   php artisan view:clear
   ```

4. **Бэкап**: Перед импортом рекомендуется создать бэкап БД:
   ```bash
   mysqldump -u username -p database_name test_questions test_result_fields > backup_test_tables_$(date +%Y%m%d_%H%M%S).sql
   ```

## Откат импорта

Если нужно откатить импорт:

```bash
# Удалить все вопросы и поля результатов
php artisan tinker --execute="\App\Models\TestQuestion::truncate(); \App\Models\TestResultField::truncate();"

# Или удалить только импортированные данные (если есть способ их идентифицировать)
```
