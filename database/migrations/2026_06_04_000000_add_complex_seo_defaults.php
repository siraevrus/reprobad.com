<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $exists = DB::table('seo')->where('page_type', 'Complex')->exists();

        if ($exists) {
            return;
        }

        DB::table('seo')->insert([
            'page_type' => 'Complex',
            'title' => 'Комплексы Система РЕПРО',
            'description' => 'Комплексы биологически активных добавок Система РЕПРО для подготовки пары к беременности: 4 этапа программы.',
            'keywords' => 'Система РЕПРО, комплексы БАД, подготовка к беременности, репрорелакс, репродетокси, репрометабо, репроэмбрио',
            'og_title' => 'Комплексы Система РЕПРО',
            'og_description' => 'Комплексы биологически активных добавок Система РЕПРО для подготовки пары к беременности.',
            'og_image' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        DB::table('seo')->where('page_type', 'Complex')->delete();
    }
};
