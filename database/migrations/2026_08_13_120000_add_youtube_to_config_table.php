<?php

use App\Models\Config;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        if (! Config::query()->where('key', 'youtube')->exists()) {
            Config::query()->create([
                'key' => 'youtube',
                'value' => 'https://www.youtube.com/@reprobad',
            ]);
        }
    }

    public function down(): void
    {
        Config::query()->where('key', 'youtube')->delete();
    }
};
