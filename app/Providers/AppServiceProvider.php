<?php

namespace App\Providers;

use App\Models\Config;
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
        $configs = Config::all();
        foreach ($configs as $config) {
            config([$config->key => $config->value]);
        }
    }
}
