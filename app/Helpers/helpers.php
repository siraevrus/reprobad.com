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

        $base = rtrim(config('app.url'), '/');
        $path = request()->path();

        if ($path === '' || $path === '/') {
            return $base;
        }

        $path = '/' . ltrim(str_replace('index.php', '', $path), '/');
        return $base . $path;
    }
}
