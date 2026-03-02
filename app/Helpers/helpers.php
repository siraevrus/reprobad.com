<?php

if (!function_exists('formatMenuNumber')) {
    /**
     * Форматирует число из меню, правильно обрабатывая запятую как разделитель десятичных знаков
     * 
     * @param mixed $value Значение (может быть строкой с запятой или числом)
     * @param int $decimals Количество знаков после запятой
     * @return string Отформатированное число с запятой как разделителем
     */
    function formatMenuNumber($value, $decimals = 2): string
    {
        if (empty($value) && $value !== '0' && $value !== 0) {
            return number_format(0, $decimals, ',', '');
        }
        
        // Если это строка с запятой, заменяем запятую на точку для преобразования
        if (is_string($value)) {
            $value = str_replace(',', '.', $value);
        }
        
        $floatValue = (float) $value;
        return number_format($floatValue, $decimals, ',', '');
    }
}

if (!function_exists('canonical_url')) {
    /**
     * Возвращает канонический URL для текущей страницы или null, если тег не нужно выводить.
     * - Главная: корень сайта (APP_URL).
     * - Страницы с пагинацией (page >= 2): null — тег не выводим.
     * - Остальные: URL без GET-параметров, без index.php; хост и протокол из config('app.url').
     *
     * @return string|null
     */
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
