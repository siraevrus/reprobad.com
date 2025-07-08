<?php

namespace App\Providers;

use App\Models\Config;
use App\Models\Point;
use App\Policies\PointPolicy;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Проверяем существование таблицы config перед загрузкой данных
        // Пропускаем в тестовом окружении, чтобы избежать ошибок подключения к БД
        try {
            if (!app()->environment('testing') && Schema::hasTable('config')) {
                $configs = Config::all();
                foreach ($configs as $config) {
                    config([$config->key => $config->value]);
                }
            }
        } catch (\Exception $e) {
            // Игнорируем ошибки подключения к БД в тестовом окружении
            if (!app()->environment('testing')) {
                throw $e;
            }
        }

        //Paginator::useTailwind();
    }
}
