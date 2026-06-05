<?php

declare(strict_types=1);

namespace App\Support;

/**
 * Строит Guzzle-опции для проксирования исходящих запросов к api.telegram.org.
 *
 * Guzzle не парсит схему socks5[h]:// самостоятельно, поэтому для SOCKS5
 * передаём cURL-константы напрямую вместо ключа 'proxy'.
 */
class TelegramProxy
{
    /**
     * Возвращает массив опций для Http::withOptions() / Guzzle RequestOptions.
     *
     * Для socks5[h]:// → ['curl' => [CURLOPT_PROXYTYPE => ..., CURLOPT_PROXY => 'host:port']]
     * Для http[s]://   → ['proxy' => 'http://...']
     * Если прокси не задан → []
     */
    public static function guzzleOptions(): array
    {
        $proxy = self::resolveProxyUrl();

        if ($proxy === '') {
            return [];
        }

        if (str_starts_with($proxy, 'socks5')) {
            $parsed = parse_url($proxy);
            $host   = $parsed['host'] ?? '127.0.0.1';
            $port   = $parsed['port'] ?? 1080;
            $type   = str_starts_with($proxy, 'socks5h') ? CURLPROXY_SOCKS5_HOSTNAME : CURLPROXY_SOCKS5;

            return [
                'curl' => [
                    CURLOPT_PROXYTYPE => $type,
                    CURLOPT_PROXY     => "{$host}:{$port}",
                ],
            ];
        }

        return ['proxy' => $proxy];
    }

    private static function resolveProxyUrl(): string
    {
        $proxy = config('services.telegram.http_proxy');

        if (is_string($proxy) && $proxy !== '') {
            return $proxy;
        }

        $host = config('services.telegram.proxy_host');
        $port = config('services.telegram.proxy_port');

        if (! is_string($host) || $host === '' || $port === null || $port === '') {
            return '';
        }

        $user     = config('services.telegram.proxy_user');
        $password = config('services.telegram.proxy_password');
        $auth     = is_string($user) && $user !== ''
            ? rawurlencode($user) . ':' . rawurlencode((string) $password) . '@'
            : '';

        return 'http://' . $auth . $host . ':' . (int) $port;
    }
}
