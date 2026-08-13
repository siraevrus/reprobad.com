<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class IndexNowService
{
    /**
     * @param  list<string>  $urls
     */
    public function submit(array $urls): bool
    {
        if (! config('indexnow.enabled')) {
            return false;
        }

        $key = trim((string) config('indexnow.key'));
        if ($key === '') {
            return false;
        }

        $urls = array_values(array_unique(array_filter($urls, static fn ($url) => is_string($url) && $url !== '')));
        if ($urls === []) {
            return false;
        }

        $base = rtrim((string) config('app.url'), '/');
        $host = parse_url($base, PHP_URL_HOST) ?: 'reprobad.com';
        $endpoint = (string) config('indexnow.endpoint');

        try {
            $response = Http::timeout(10)->acceptJson()->asJson()->post($endpoint, [
                'host' => $host,
                'key' => $key,
                'keyLocation' => $base.'/'.$key.'.txt',
                'urlList' => $urls,
            ]);

            if ($response->failed()) {
                Log::warning('IndexNow submit failed', [
                    'status' => $response->status(),
                    'body' => mb_substr($response->body(), 0, 500),
                ]);

                return false;
            }

            return true;
        } catch (\Throwable $e) {
            Log::warning('IndexNow submit error: '.$e->getMessage());

            return false;
        }
    }
}
