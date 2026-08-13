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
        // Проверяем существование таблицы config перед загрузкой данных.
        // В случае ошибок подключения к БД (например, при отсутствии настроек/миграций)
        // просто пропускаем инициализацию, чтобы не ломать запуск приложения локально.
        try {
            if (!app()->environment('testing') && Schema::hasTable('config')) {
                $configs = Config::all();
                foreach ($configs as $config) {
                    config([$config->key => $config->value]);
                }
            }
        } catch (\Exception $e) {
            // Игнорируем любые ошибки подключения к БД на этапе бута приложения.
            // При необходимости можно добавить логирование:
            // logger()->warning('Config bootstrap failed', ['exception' => $e]);
        }

        //Paginator::useTailwind();
    }
}
