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
