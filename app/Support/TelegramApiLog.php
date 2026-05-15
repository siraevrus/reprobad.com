<?php

namespace App\Support;

final class TelegramApiLog
{
    /**
     * Маскирует bot-токен в URL: cURL/Guzzle включают полный URL в текст исключения.
     */
    public static function redact(string $message): string
    {
        $redacted = preg_replace(
            '#https://api\.telegram\.org/bot[0-9]+:[A-Za-z0-9_-]+#',
            'https://api.telegram.org/bot[REDACTED]',
            $message
        );

        return is_string($redacted) ? $redacted : $message;
    }
}
