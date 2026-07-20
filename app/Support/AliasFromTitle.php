<?php

declare(strict_types=1);

namespace App\Support;

class AliasFromTitle
{
    /** @var array<string, string> */
    private const MAP = [
        'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'yo',
        'ж' => 'zh', 'з' => 'z', 'и' => 'i', 'й' => 'y', 'к' => 'k', 'л' => 'l', 'м' => 'm',
        'н' => 'n', 'о' => 'o', 'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u',
        'ф' => 'f', 'х' => 'h', 'ц' => 'ts', 'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sch', 'ъ' => '',
        'ы' => 'y', 'ь' => '', 'э' => 'e', 'ю' => 'yu', 'я' => 'ya',
        ' ' => '-', '_' => '-',
    ];

    /**
     * Человекочитаемый URL-алиас из заголовка (транслит кириллицы).
     */
    public static function make(?string $title): string
    {
        $title = html_entity_decode(strip_tags((string) $title), ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $title = mb_strtolower(trim($title), 'UTF-8');

        if ($title === '') {
            return '';
        }

        $out = '';
        $len = mb_strlen($title, 'UTF-8');
        for ($i = 0; $i < $len; $i++) {
            $char = mb_substr($title, $i, 1, 'UTF-8');
            $out .= self::MAP[$char] ?? $char;
        }

        $out = preg_replace('/[^a-z0-9-]+/', '-', $out) ?? '';
        $out = preg_replace('/-+/', '-', $out) ?? '';

        return trim($out, '-');
    }
}
