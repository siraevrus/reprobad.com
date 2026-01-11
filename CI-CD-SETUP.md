# CI/CD Setup для Laravel проекта

## Обзор

Настроен полный CI/CD pipeline для Laravel проекта с использованием GitHub Actions.

## Workflows

### 1. CI/CD Pipeline (`ci-cd.yml`)

Основной workflow, который запускается при:
- Push в ветки `master` и `develop`
- Pull Request в ветку `master`

**Этапы:**
- **Test**: Запуск тестов с MySQL и SQLite
- **Security**: Проверка безопасности зависимостей
- **Deploy**: Создание пакета для деплоя (только для master)

### 2. Dependency Review (`dependency-review.yml`)

Проверка безопасности зависимостей при Pull Request.

### 3. Release (`release.yml`)

Автоматическое создание релизов при push тегов вида `v*`.

### 4. Deploy Example (`deploy-example.yml`)

Пример workflow для деплоя на сервер.

## Настройка

### 1. Секреты GitHub

Добавьте следующие секреты в настройках репозитория (Settings > Secrets and variables > Actions):

#### Для SSH деплоя:
```
HOST=192.168.1.100          # IP адрес вашего сервера
USERNAME=deploy              # Имя пользователя на сервере
SSH_KEY=-----BEGIN OPENSSH PRIVATE KEY-----...  # Приватный SSH ключ с локальной машины
SSH_PORT=22                  # Порт SSH (обычно 22)
```

**Важно:** `SSH_KEY` - это приватный ключ с вашей локальной машины (не с сервера). Получить его можно командой:
```bash
cat ~/.ssh/id_rsa
```

#### Для FTP деплоя:
```
FTP_SERVER=ftp.example.com    # Адрес FTP сервера
FTP_USERNAME=deploy           # Имя пользователя FTP
FTP_PASSWORD=your-password    # Пароль для FTP
```

### 2. Environment Protection

Создайте environment `production` в настройках репозитория:
1. Settings > Environments
2. Create environment: `production`
3. Add protection rules (опционально)

### 3. Настройка сервера

#### Подготовка сервера для деплоя:

```bash
# Создание директории для приложения
sudo mkdir -p /var/www/your-app
sudo chown -R $USER:$USER /var/www/your-app

# Клонирование репозитория (первый раз)
cd /var/www
git clone https://github.com/your-username/your-repo.git your-app
cd your-app

# Установка зависимостей
composer install --no-dev --optimize-autoloader

# Копирование .env файла
cp .env.example .env
php artisan key:generate

# Настройка прав доступа
sudo chown -R www-data:www-data /var/www/your-app
sudo chmod -R 775 /var/www/your-app/storage
sudo chmod -R 775 /var/www/your-app/bootstrap/cache

# Настройка MySQL (если нужно)
sudo mysql -u root -p
CREATE DATABASE laravel;
CREATE USER 'laravel'@'localhost' IDENTIFIED BY 'your_password';
GRANT ALL PRIVILEGES ON laravel.* TO 'laravel'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

#### SSH доступ:
```bash
# Создание SSH ключа
ssh-keygen -t rsa -b 4096 -C "github-actions"

# Добавление публичного ключа на сервер
# Для обычного пользователя:
ssh-copy-id -i ~/.ssh/id_rsa.pub user@your-server

# Для root пользователя:
ssh-copy-id -i ~/.ssh/id_rsa.pub root@your-server

# Или если нужно скопировать вручную:
cat ~/.ssh/id_rsa.pub | ssh user@your-server "mkdir -p ~/.ssh && cat >> ~/.ssh/authorized_keys"

# Добавление приватного ключа в GitHub Secrets
cat ~/.ssh/id_rsa
```

#### Структура директорий на сервере:
```
/var/www/your-app/
├── .env
├── storage/
├── bootstrap/cache/
└── public/
```

### 4. Настройка веб-сервера

#### Nginx конфигурация:
```nginx
server {
    listen 80;
    server_name your-domain.com;
    root /var/www/your-app/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

## Использование

### Автоматический деплой

1. Создайте Pull Request в ветку `master`
2. После успешного прохождения тестов и проверок
3. Merge Pull Request
4. Автоматический деплой на сервер

### Создание релиза

```bash
# Создание тега
git tag v1.0.0

# Push тега
git push origin v1.0.0
```

### Ручной запуск

1. Перейдите в Actions в GitHub
2. Выберите нужный workflow
3. Нажмите "Run workflow"

## Мониторинг

### Уведомления

Настройте уведомления в GitHub:
1. Settings > Notifications
2. Настройте уведомления для Actions

### Логи

Все логи доступны в:
- GitHub Actions > Workflows > [Workflow Name] > Runs

## Troubleshooting

### Проблемы с правами доступа

```bash
# На сервере
sudo chown -R www-data:www-data /var/www/your-app
sudo chmod -R 775 /var/www/your-app/storage
sudo chmod -R 775 /var/www/your-app/bootstrap/cache
```

### Проблемы с SSH

```bash
# Проверка подключения
ssh -T user@your-server

# Проверка прав на ключ
chmod 600 ~/.ssh/id_rsa
```

### Проблемы с зависимостями

```bash
# Очистка кэша Composer
composer clear-cache

# Переустановка зависимостей
rm -rf vendor/
composer install
```

### Настройка Laravel Scheduler (Cron)

Для автоматической работы планировщика Laravel (например, генерация sitemap.xml) необходимо настроить cron job на сервере:

```bash
# На сервере откройте crontab
crontab -e

# Добавьте следующую строку (замените /var/www/repro на путь к вашему проекту)
* * * * * cd /var/www/repro && php artisan schedule:run >> /dev/null 2>&1
```

**Важно:**
- Эта команда должна запускаться каждую минуту
- Laravel сам определит, какие задачи нужно выполнить в данный момент
- В проекте настроена автоматическая генерация sitemap.xml раз в сутки через `Schedule::command('sitemap:generate')->daily()`

**Альтернатива:** Sitemap.xml также генерируется автоматически при каждом деплое через GitHub Actions, поэтому cron не является обязательным для работы sitemap.

**Проверка работы планировщика:**

```bash
# Проверка списка запланированных задач
php artisan schedule:list

# Ручной запуск планировщика (для тестирования)
php artisan schedule:run

# Ручная генерация sitemap
php artisan sitemap:generate

# Проверка настроен ли cron (используйте скрипт check-cron.sh)
./check-cron.sh

# Или проверка вручную:
crontab -l | grep schedule:run
```

**Автоматическая проверка при деплое:**

При каждом деплое через GitHub Actions автоматически проверяется, настроен ли cron для Laravel Scheduler. Если cron не настроен, в логах деплоя будет предупреждение с инструкциями по настройке.

## Дополнительные настройки

### Code Coverage

Для настройки Codecov:
1. Зарегистрируйтесь на [codecov.io](https://codecov.io)
2. Подключите репозиторий
3. Добавьте токен в GitHub Secrets: `CODECOV_TOKEN`

### PHP CS Fixer

Для автоматического форматирования кода:
```bash
# Установка
composer require --dev friendsofphp/php-cs-fixer

# Запуск
./vendor/bin/php-cs-fixer fix
```

### Дополнительные проверки

Можно добавить:
- PHPStan для статического анализа
- Psalm для анализа типов
- PHPUnit coverage reports
- Browser testing с Laravel Dusk

#### Laravel Dusk для browser testing:

```bash
# Установка Laravel Dusk
composer require --dev laravel/dusk

# Установка ChromeDriver
php artisan dusk:install

# Создание тестов
php artisan dusk:make TestName
```

Добавьте в workflow:
```yaml
- name: Install Chrome
  run: |
    wget -q -O - https://dl.google.com/linux/linux_signing_key.pub | apt-key add -
    echo "deb [arch=amd64] http://dl.google.com/linux/chrome/deb/ stable main" >> /etc/apt/sources.list.d/google.list
    apt-get update
    apt-get install -y google-chrome-stable

- name: Run Dusk Tests
  run: php artisan dusk
``` 