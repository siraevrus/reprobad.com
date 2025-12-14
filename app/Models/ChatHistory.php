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
}

