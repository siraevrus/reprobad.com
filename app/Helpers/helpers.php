<?php

if (!function_exists('formatMenuNumber')) {
    function formatMenuNumber($value, $decimals = 2): string
    {
        if (empty($value) && $value !== '0' && $value !== 0) {
            return number_format(0, $decimals, ',', '');
        }
        if (is_string($value)) {
            $value = str_replace(',', '.', $value);
        }
        
        $floatValue = (float) $value;
        return number_format($floatValue, $decimals, ',', '');
    }
}

if (!function_exists('seo_noindex')) {
    /**
     * Пометить текущий запрос как noindex.
     *
     * Контроллер вызывает seo_noindex(), чтобы:
     *  - canonical_url() вернул null (canonical на noindex-страницы запрещён);
     *  - middleware SeoMetaTags добавил <meta name="robots" content="noindex, nofollow">.
     */
    function seo_noindex(bool $value = true): void
    {
        request()->attributes->set('seo_noindex', $value);
    }
}

if (!function_exists('seo_is_noindex')) {
    /**
     * Помечен ли текущий запрос как noindex.
     */
    function seo_is_noindex(): bool
    {
        return (bool) request()->attributes->get('seo_noindex', false);
    }
}

if (!function_exists('seo_is_excluded_path')) {
    /**
     * Пути, для которых canonical/индексация не применяются:
     * админка, API и debugbar.
     */
    function seo_is_excluded_path(?string $path = null): bool
    {
        $path = trim($path ?? request()->path(), '/');

        foreach (['admin', 'api', '_debugbar'] as $prefix) {
            if ($path === $prefix || str_starts_with($path, $prefix . '/')) {
                return true;
            }
        }

        return false;
    }
}

if (!function_exists('canonical_url')) {
    /**
     * Абсолютный self-referencing canonical URL для текущего запроса.
     *
     * Правила:
     *  - схема/хост берутся из config('app.url') (не из Host-заголовка);
     *  - в query остаются только «контентные» параметры из белого списка,
     *    весь мусор (utm_*, gclid, сортировки, пагинация-нарезка и т.п.) удаляется;
     *  - пагинация блога/каталога (?page=N) сохраняется → каждая страница ссылается сама на себя;
     *  - для noindex и исключённых путей (admin/api/_debugbar) canonical не выдаётся.
     */
    function canonical_url(): ?string
    {
        if (seo_is_noindex() || seo_is_excluded_path()) {
            return null;
        }

        $base = rtrim(config('app.url'), '/');

        $path = str_replace('index.php', '', request()->path());
        $path = trim($path, '/');

        $url = $path === '' ? $base : $base . '/' . $path;

        $query = canonical_query_string();

        return $query === '' ? $url : $url . '?' . $query;
    }
}

if (!function_exists('canonical_query_string')) {
    /**
     * Очищенная query-строка для canonical: только параметры из белого списка.
     *
     * page оставляем только если это «настоящая» пагинация (page >= 2);
     * page=1 и page=0 дают дубль первой страницы — параметр убираем.
     */
    function canonical_query_string(): string
    {
        // Параметры, реально идентифицирующие контент.
        $allowed = ['id', 'slug', 'product_id', 'post_id', 'page'];

        $params = [];
        foreach ($allowed as $key) {
            $value = request()->query($key);

            if ($value === null || is_array($value) || $value === '') {
                continue;
            }

            if ($key === 'page' && (int) $value < 2) {
                continue;
            }

            $params[$key] = $value;
        }

        if ($params === []) {
            return '';
        }

        ksort($params);

        return http_build_query($params);
    }
}

if (!function_exists('public_asset')) {
    /**
     * URL для статики: пути из public/, storage/ или legacy «images/...».
     * http(s)://, data: и пути с ведущим «/» возвращаются без изменений.
     */
    function public_asset(?string $path): string
    {
        $path = trim((string) $path);
        if ($path === '') {
            return '';
        }

        if (str_starts_with($path, 'http://')
            || str_starts_with($path, 'https://')
            || str_starts_with($path, 'data:')) {
            return $path;
        }

        if (str_starts_with($path, '/')) {
            return $path;
        }

        return asset($path);
    }
}

if (!function_exists('product_section_heading')) {
    /**
     * Заголовок секции продукта на странице комплекса (для h2).
     *
     * Приоритет: alt_left/alt_right комплекса по порядку → logo_alt → title продукта.
     */
    function product_section_heading(\App\Models\Product $product, \App\Models\Complex $complex, int $index): string
    {
        $anchorAlts = array_values(array_filter([
            $complex->alt_left,
            $complex->alt_right,
        ]));

        $heading = $anchorAlts[$index - 1]
            ?? $product->logo_alt
            ?? $product->title
            ?? '';

        $heading = strip_tags((string) $heading);
        $heading = preg_replace('/^(САШЕ|БАНКА)\s*"/u', '', $heading) ?? $heading;

        return trim($heading, " \t\n\r\0\x0B\"");
    }
}
