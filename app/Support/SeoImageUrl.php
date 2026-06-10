<?php

declare(strict_types=1);

namespace App\Support;

use App\Models\Complex;
use App\Models\Product;

final class SeoImageUrl
{
    /**
     * Изображение для og:image / сниппетов по типу ресурса страницы.
     */
    public static function forResource(?object $resource): ?string
    {
        if ($resource === null) {
            return null;
        }

        if ($resource instanceof Product) {
            return ProductImageUrl::resolve($resource);
        }

        if ($resource instanceof Complex) {
            if ($resource->relationLoaded('products')) {
                foreach ($resource->products as $product) {
                    $image = ProductImageUrl::resolve($product);
                    if ($image !== null) {
                        return $image;
                    }
                }
            }

            foreach (['image_left', 'image_right'] as $field) {
                $url = ProductImageUrl::toAbsolute($resource->{$field} ?? null);
                if ($url !== null && ProductImageUrl::isSuitableForSnippet($url)) {
                    return $url;
                }
            }
        }

        foreach (['image', 'photo', 'logo'] as $field) {
            if (! empty($resource->{$field})) {
                $url = ProductImageUrl::toAbsolute((string) $resource->{$field});
                if ($url !== null && ProductImageUrl::isSuitableForSnippet($url)) {
                    return $url;
                }
            }
        }

        return null;
    }
}
