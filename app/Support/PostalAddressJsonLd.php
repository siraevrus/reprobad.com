<?php

declare(strict_types=1);

namespace App\Support;

final class PostalAddressJsonLd
{
    /**
     * CMS хранит адрес одной строкой вместе с «Поставщик АО „Р-Фарм“».
     * Для JSON-LD оставляем только PostalAddress.
     */
    public static function fromRaw(?string $raw): ?array
    {
        $text = self::normalize((string) $raw);
        if ($text === '') {
            return null;
        }

        $text = preg_replace('/^поставщик\s+ао\s*[«"„\']?р-фарм[»"“\']?\.?\s*/iu', '', $text) ?? $text;
        $text = preg_replace('/^владелец\s+сайта:\s*ао\s*[«"„\']?р-фарм[»"“\']?\.?\s*/iu', '', $text) ?? $text;
        $text = preg_replace('/почтовый\s+адрес:\s*/iu', '', $text) ?? $text;
        $text = trim($text, " \t\n\r\0\x0B.,;");
        if ($text === '') {
            return null;
        }

        $postalCode = null;
        if (preg_match('/\b(\d{6})\b/', $text, $m)) {
            $postalCode = $m[1];
            $text = trim(str_replace($m[1], '', $text), " \t,.;");
        }

        $locality = null;
        if (preg_match('/\bг\.?\s*([А-ЯЁа-яё-]+)/u', $text, $m)) {
            $locality = $m[1];
            $text = trim(preg_replace('/\bг\.?\s*'.preg_quote($m[1], '/').'\b/u', '', $text) ?? $text, " \t,.;");
        } elseif (preg_match('/\b(Москва|Санкт-Петербург)\b/u', $text, $m)) {
            $locality = $m[1];
            $text = trim(str_replace($m[1], '', $text), " \t,.;");
        }

        $street = self::collapse($text);

        $address = ['@type' => 'PostalAddress'];
        if ($street !== '') {
            $address['streetAddress'] = $street;
        }
        if ($locality) {
            $address['addressLocality'] = $locality;
        }
        if ($postalCode) {
            $address['postalCode'] = $postalCode;
        }
        $address['addressCountry'] = 'RU';

        return $address;
    }

    /**
     * @return array{ '@type': string, name: string, url: string }
     */
    public static function parentOrganization(): array
    {
        return [
            '@type' => 'Organization',
            'name' => 'АО «Р-Фарм»',
            'url' => 'https://www.r-pharm.com/ru',
        ];
    }

    private static function normalize(string $raw): string
    {
        $text = html_entity_decode(strip_tags($raw), ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $text = str_replace(["\xc2\xa0", '&nbsp;'], ' ', $text);

        return trim(preg_replace('/\s+/u', ' ', $text) ?? $text);
    }

    private static function collapse(string $text): string
    {
        $text = trim(preg_replace('/\s+/u', ' ', $text) ?? $text);
        $text = preg_replace('/(?:\s*,\s*)+/u', ', ', $text) ?? $text;

        return trim($text, " \t,.;");
    }
}
