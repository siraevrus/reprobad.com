#!/bin/bash

SERVER="root@45.131.41.102"
SERVER_PATH="/var/www/repro"
LOCAL_ENV=".env"
SERVER_ENV="$SERVER_PATH/.env"

echo "=== ПРОВЕРКА .ENV ФАЙЛА НА СЕРВЕРЕ ==="
echo ""

# Проверка наличия локального .env файла
if [ ! -f "$LOCAL_ENV" ]; then
    echo "❌ Локальный .env файл не найден!"
    exit 1
fi

echo "📋 Локальный .env файл найден"
echo ""

# Вариант 1: Автоматическое сравнение через SSH
echo "=== ВАРИАНТ 1: АВТОМАТИЧЕСКОЕ СРАВНЕНИЕ ==="
echo ""
echo "Выполняется сравнение файлов..."
echo ""

# Создаем временный файл для серверного .env
TEMP_SERVER_ENV=$(mktemp)

# Загружаем .env с сервера
echo "Загрузка .env с сервера..."
if ssh "$SERVER" "cat $SERVER_ENV" > "$TEMP_SERVER_ENV" 2>/dev/null; then
    echo "✅ .env файл успешно загружен с сервера"
    echo ""
    
    # Сравниваем файлы
    if diff -q "$LOCAL_ENV" "$TEMP_SERVER_ENV" > /dev/null; then
        echo "✅ Файлы идентичны - .env на сервере актуален!"
    else
        echo "⚠️  Файлы РАЗЛИЧАЮТСЯ!"
        echo ""
        echo "=== РАЗЛИЧИЯ ==="
        diff -u "$LOCAL_ENV" "$TEMP_SERVER_ENV" || diff "$LOCAL_ENV" "$TEMP_SERVER_ENV"
        echo ""
        echo "=== ЛОКАЛЬНЫЙ .ENV (первые 20 строк) ==="
        head -20 "$LOCAL_ENV"
        echo ""
        echo "=== СЕРВЕРНЫЙ .ENV (первые 20 строк) ==="
        head -20 "$TEMP_SERVER_ENV"
    fi
    
    # Удаляем временный файл
    rm -f "$TEMP_SERVER_ENV"
else
    echo "❌ Не удалось загрузить .env с сервера"
    echo ""
    echo "=== ВАРИАНТ 2: РУЧНАЯ ПРОВЕРКА ==="
    echo ""
    echo "Выполните следующие команды вручную:"
    echo ""
    echo "1. Подключитесь к серверу:"
    echo "   ssh $SERVER"
    echo ""
    echo "2. Просмотрите .env файл на сервере:"
    echo "   cat $SERVER_ENV"
    echo ""
    echo "3. Или сравните конкретные переменные:"
    echo "   grep 'APP_URL' $SERVER_ENV"
    echo "   grep 'DB_' $SERVER_ENV"
    echo "   grep 'MAIL_' $SERVER_ENV"
    echo ""
    echo "4. Для копирования .env с сервера локально:"
    echo "   scp $SERVER:$SERVER_ENV .env.server"
    echo "   diff .env .env.server"
fi

echo ""
echo "=== ДОПОЛНИТЕЛЬНЫЕ КОМАНДЫ ==="
echo ""
echo "Для обновления .env на сервере:"
echo "   scp $LOCAL_ENV $SERVER:$SERVER_ENV"
echo ""
echo "Для просмотра только различий в ключах (без значений):"
echo "   diff <(cut -d= -f1 $LOCAL_ENV | sort) <(ssh $SERVER \"cut -d= -f1 $SERVER_ENV | sort\")"
echo ""
