<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Индексы для таблицы articles
        Schema::table('articles', function (Blueprint $table) {
            $table->index('active', 'articles_active_index');
            $table->index('category', 'articles_category_index');
            $table->index('created_at', 'articles_created_at_index');
            $table->index('home', 'articles_home_index');
            // Составной индекс для частых запросов
            $table->index(['active', 'created_at'], 'articles_active_created_at_index');
        });

        // Индексы для таблицы advises
        Schema::table('advises', function (Blueprint $table) {
            $table->index('active', 'advises_active_index');
            $table->index('category', 'advises_category_index');
            $table->index('created_at', 'advises_created_at_index');
            // Составной индекс для частых запросов
            $table->index(['active', 'created_at'], 'advises_active_created_at_index');
        });

        // Индексы для таблицы complex
        Schema::table('complex', function (Blueprint $table) {
            $table->index('active', 'complex_active_index');
            $table->index('alias', 'complex_alias_index');
            $table->index('sort', 'complex_sort_index');
            // Составной индекс для scopeActive
            $table->index(['active', 'sort'], 'complex_active_sort_index');
        });

        // Индексы для таблицы products
        Schema::table('products', function (Blueprint $table) {
            $table->index('active', 'products_active_index');
            $table->index('complex_id', 'products_complex_id_index');
            $table->index('sort', 'products_sort_index');
            // Составной индекс для частых запросов
            $table->index(['complex_id', 'active', 'sort'], 'products_complex_active_sort_index');
        });

        // Индексы для таблицы events
        Schema::table('events', function (Blueprint $table) {
            $table->index('active', 'events_active_index');
            $table->index('sort', 'events_sort_index');
            $table->index('home', 'events_home_index');
            $table->index('created_at', 'events_created_at_index');
            // Составной индекс для частых запросов
            $table->index(['active', 'sort'], 'events_active_sort_index');
            $table->index(['active', 'created_at'], 'events_active_created_at_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Удаление индексов для articles
        Schema::table('articles', function (Blueprint $table) {
            $table->dropIndex('articles_active_index');
            $table->dropIndex('articles_category_index');
            $table->dropIndex('articles_created_at_index');
            $table->dropIndex('articles_home_index');
            $table->dropIndex('articles_active_created_at_index');
        });

        // Удаление индексов для advises
        Schema::table('advises', function (Blueprint $table) {
            $table->dropIndex('advises_active_index');
            $table->dropIndex('advises_category_index');
            $table->dropIndex('advises_created_at_index');
            $table->dropIndex('advises_active_created_at_index');
        });

        // Удаление индексов для complex
        Schema::table('complex', function (Blueprint $table) {
            $table->dropIndex('complex_active_index');
            $table->dropIndex('complex_alias_index');
            $table->dropIndex('complex_sort_index');
            $table->dropIndex('complex_active_sort_index');
        });

        // Удаление индексов для products
        Schema::table('products', function (Blueprint $table) {
            $table->dropIndex('products_active_index');
            $table->dropIndex('products_complex_id_index');
            $table->dropIndex('products_sort_index');
            $table->dropIndex('products_complex_active_sort_index');
        });

        // Удаление индексов для events
        Schema::table('events', function (Blueprint $table) {
            $table->dropIndex('events_active_index');
            $table->dropIndex('events_sort_index');
            $table->dropIndex('events_home_index');
            $table->dropIndex('events_created_at_index');
            $table->dropIndex('events_active_sort_index');
            $table->dropIndex('events_active_created_at_index');
        });
    }
};
