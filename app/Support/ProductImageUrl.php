<?php

declare(strict_types=1);

namespace App\Support;

use App\Models\Product;

final class ProductImageUrl
{
    /**
     * Абсолютный URL изображения упаковки продукта для SEO / YML (без SVG и base64).
     */
    public static function resolve(Product $product): ?string
    {
        foreach (self::candidates($product) as $url) {
            $absolute = self::toAbsolute($url);
            if ($absolute !== null && self::isSuitableForSnippet($absolute)) {
                return $absolute;
            }
        }

        return null;
    }

    /** @return list<string> */
    private static function candidates(Product $product): array
    {
        $candidates = [];

        $images = $product->images;
        if (is_array($images)) {
            foreach ($images as $row) {
                if (is_array($row) && ! empty($row['url'])) {
                    $candidates[] = (string) $row['url'];
                }
            }
        }

        foreach (['photo', 'image', 'image_left'] as $field) {
            $value = $product->{$field} ?? null;
            if (filled($value)) {
                $candidates[] = (string) $value;
            }
        }

        return $candidates;
    }

    public static function toAbsolute(?string $url): ?string
    {
        $url = trim((string) $url);
        if ($url === '' || str_starts_with($url, 'data:')) {
            return null;
        }

        if (str_starts_with($url, 'http://') || str_starts_with($url, 'https://')) {
            return $url;
        }

        return rtrim((string) config('app.url'), '/') . '/' . ltrim($url, '/');
    }

    public static function isSuitableForSnippet(string $url): bool
    {
        if (str_starts_with($url, 'data:')) {
            return false;
        }

        $path = parse_url($url, PHP_URL_PATH) ?? '';

        return ! preg_match('/\.svg$/i', $path);
    }
}
