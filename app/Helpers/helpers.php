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

if (!function_exists('canonical_url')) {
    function canonical_url(): ?string
    {
        $pageParam = request()->query('page');
        if ($pageParam !== null && (int) $pageParam >= 2) {
            return null;
        }

        $path = request()->path();
        $pathNormalized = trim($path, '/');

        // Страницы без canonical
        $noCanonicalPaths = [
            '',
            'about',
            'products',
            'company',
            'contacts',
            'faq',
            'map',
            'menu/day_1',
            'menu/day_2',
            'menu/day_3',
            'menu/day_4',
            'menu/day_5',
            'menu/day_6',
            'menu/day_7',
        ];
        if (in_array($pathNormalized, $noCanonicalPaths, true)) {
            return null;
        }

        $base = rtrim(config('app.url'), '/');
        if ($path === '' || $path === '/') {
            return $base;
        }

        $path = '/' . ltrim(str_replace('index.php', '', $path), '/');
        return $base . $path;
    }
}
