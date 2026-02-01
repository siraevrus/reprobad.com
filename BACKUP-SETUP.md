# Настройка автоматического бэкапа базы данных

## Описание

Скрипт `backup-database.sh` автоматически создает бэкапы базы данных MySQL, сжимает их и удаляет старые бэкапы (старше 30 дней).

## Особенности

- ✅ Автоматическое чтение параметров БД из `.env` файла
- ✅ Сжатие бэкапов с помощью gzip
- ✅ Автоматическое удаление бэкапов старше 30 дней
- ✅ Логирование всех операций
- ✅ Проверка успешности создания бэкапа

## Установка на сервере

### 1. Убедитесь, что скрипт исполняемый

```bash
chmod +x /var/www/repro/backup-database.sh
```

### 2. Создайте директорию для бэкапов (если её нет)

```bash
mkdir -p /var/www/repro/storage/backups
chmod 755 /var/www/repro/storage/backups
```

### 3. Проверьте работу скрипта вручную

```bash
cd /var/www/repro
./backup-database.sh
```

Проверьте, что бэкап создался:
```bash
ls -lh /var/www/repro/storage/backups/
```

### 4. Настройка cron задачи

Откройте crontab для редактирования:
```bash
crontab -e
```

Добавьте одну из следующих строк в зависимости от частоты бэкапов:

#### Ежедневно в 2:00 ночи
```bash
0 2 * * * /var/www/repro/backup-database.sh >> /var/www/repro/storage/logs/backup-cron.log 2>&1
```

#### Ежедневно в 3:00 ночи
```bash
0 3 * * * /var/www/repro/backup-database.sh >> /var/www/repro/storage/logs/backup-cron.log 2>&1
```

#### Каждые 6 часов
```bash
0 */6 * * * /var/www/repro/backup-database.sh >> /var/www/repro/storage/logs/backup-cron.log 2>&1
```

#### Еженедельно (каждый понедельник в 2:00)
```bash
0 2 * * 1 /var/www/repro/backup-database.sh >> /var/www/repro/storage/logs/backup-cron.log 2>&1
```

**Рекомендуется:** Ежедневный бэкап в 2:00 ночи (когда нагрузка на сервер минимальна).

### 5. Проверка настроек cron

Проверьте, что задача добавлена:
```bash
crontab -l
```

Вы должны увидеть строку с `backup-database.sh`.

## Расположение файлов

- **Скрипт бэкапа:** `/var/www/repro/backup-database.sh`
- **Директория бэкапов:** `/var/www/repro/storage/backups/`
- **Лог скрипта:** `/var/www/repro/storage/logs/backup.log`
- **Лог cron:** `/var/www/repro/storage/logs/backup-cron.log`

## Формат имени файлов бэкапов

Бэкапы сохраняются в формате:
```
backup_название_базы_YYYYMMDD_HHMMSS.sql.gz
```

Пример:
```
backup_laravel_20250201_020000.sql.gz
```

## Управление бэкапами

### Просмотр списка бэкапов

```bash
ls -lh /var/www/repro/storage/backups/
```

### Просмотр логов

```bash
tail -f /var/www/repro/storage/logs/backup.log
```

### Восстановление из бэкапа

```bash
# Распаковка (если сжат)
gunzip backup_laravel_20250201_020000.sql.gz

# Восстановление
mysql -u DB_USERNAME -p DB_DATABASE < backup_laravel_20250201_020000.sql
```

Или одной командой:
```bash
gunzip < backup_laravel_20250201_020000.sql.gz | mysql -u DB_USERNAME -p DB_DATABASE
```

## Настройка хранения бэкапов

По умолчанию скрипт удаляет бэкапы старше 30 дней. Чтобы изменить это значение, откройте `backup-database.sh` и найдите строку:

```bash
find "$BACKUP_DIR" -name "backup_*.sql*" -type f -mtime +30 -delete
```

Измените `+30` на нужное количество дней (например, `+7` для недели, `+90` для 3 месяцев).

## Мониторинг

Для проверки работы автоматических бэкапов:

1. Проверьте логи:
   ```bash
   tail -n 50 /var/www/repro/storage/logs/backup.log
   ```

2. Проверьте последний созданный бэкап:
   ```bash
   ls -lt /var/www/repro/storage/backups/ | head -5
   ```

3. Проверьте размер директории с бэкапами:
   ```bash
   du -sh /var/www/repro/storage/backups/
   ```

## Устранение проблем

### Ошибка: mysqldump не найден

Установите mysql-client:
```bash
# Ubuntu/Debian
sudo apt-get install mysql-client

# CentOS/RHEL
sudo yum install mysql
```

### Ошибка доступа к базе данных

Проверьте параметры подключения в `.env` файле:
- `DB_HOST`
- `DB_PORT`
- `DB_DATABASE`
- `DB_USERNAME`
- `DB_PASSWORD`

### Ошибка прав доступа

Убедитесь, что у пользователя есть права на запись в директорию:
```bash
chmod 755 /var/www/repro/storage/backups
chown -R www-data:www-data /var/www/repro/storage/backups
```

## Безопасность

⚠️ **Важно:** Бэкапы содержат все данные базы данных. Убедитесь, что:

1. Директория `/var/www/repro/storage/backups/` недоступна через веб-сервер
2. Права доступа настроены правильно (только для владельца)
3. Регулярно копируйте бэкапы на внешний сервер или в облачное хранилище

## Пример полной настройки cron

После добавления задачи в crontab, ваш `crontab -l` должен выглядеть примерно так:

```
0 12 * * * /usr/bin/certbot renew --quiet
* * * * * cd /var/www/repro && php artisan schedule:run >> /dev/null 2>&1
0 2 * * * /var/www/repro/backup-database.sh >> /var/www/repro/storage/logs/backup-cron.log 2>&1
```
