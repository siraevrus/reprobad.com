<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class CityStatsService
{
    private const STATS_FILE = 'city_stats.json';

    /**
     * Записать выбор города в статистику
     */
    public function recordCitySelection(string $city): void
    {
        $stats = $this->getStats();
        
        if (isset($stats[$city])) {
            $stats[$city]++;
        } else {
            $stats[$city] = 1;
        }
        
        $this->saveStats($stats);
    }

    /**
     * Получить статистику выбора городов
     */
    public function getStats(): array
    {
        if (!Storage::exists(self::STATS_FILE)) {
            return [];
        }

        $content = Storage::get(self::STATS_FILE);
        return json_decode($content, true) ?? [];
    }

    /**
     * Получить статистику с сортировкой по количеству выборов
     */
    public function getStatsSorted(): array
    {
        $stats = $this->getStats();
        arsort($stats);
        return $stats;
    }

    /**
     * Получить общее количество выборов
     */
    public function getTotalSelections(): int
    {
        return array_sum($this->getStats());
    }

    /**
     * Очистить статистику
     */
    public function clearStats(): void
    {
        Storage::delete(self::STATS_FILE);
    }

    /**
     * Сохранить статистику в файл
     */
    private function saveStats(array $stats): void
    {
        Storage::put(self::STATS_FILE, json_encode($stats, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }
}
