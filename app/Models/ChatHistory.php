<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatHistory extends Model
{
    protected $table = 'chat_history';

    protected $fillable = [
        'user_id',
        'source',
        'chat_id',
        'user_message',
        'bot_response',
    ];

    /**
     * Получить последние N сообщений для пользователя
     */
    public static function getRecentMessages(string $userId, string $source = 'web', int $limit = 10)
    {
        return self::where('user_id', $userId)
            ->where('source', $source)
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get()
            ->reverse()
            ->values();
    }

    /**
     * Очистить старую историю (старше N дней)
     */
    public static function cleanOldHistory(int $days = 30)
    {
        return self::where('created_at', '<', now()->subDays($days))->delete();
    }

    /**
     * Автоочистка истории для пользователя - оставляет только последние N записей
     * 
     * @param string $userId ID пользователя
     * @param string $source Источник (web или telegram)
     * @param int $keepLimit Количество записей для сохранения (по умолчанию 20)
     * @return int Количество удаленных записей
     */
    public static function autoCleanUserHistory(string $userId, string $source = 'web', int $keepLimit = 20): int
    {
        // Получаем ID последних N записей, которые нужно сохранить
        $keepIds = self::where('user_id', $userId)
            ->where('source', $source)
            ->orderBy('created_at', 'desc')
            ->limit($keepLimit)
            ->pluck('id')
            ->toArray();

        if (empty($keepIds)) {
            return 0;
        }

        // Удаляем все остальные записи для этого пользователя
        $deleted = self::where('user_id', $userId)
            ->where('source', $source)
            ->whereNotIn('id', $keepIds)
            ->delete();

        return $deleted;
    }
}

