<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Вспомогательная функция для проверки существования индекса
        $hasIndex = function($tableName, $indexName) {
            $driver = DB::getDriverName();
            if ($driver === 'sqlite') {
                // Для SQLite проверяем через sqlite_master
                $result = DB::select("SELECT name FROM sqlite_master WHERE type='index' AND name=?", [$indexName]);
                return count($result) > 0;
            } else {
                // Для MySQL и других
                $indexes = DB::select("SHOW INDEXES FROM `{$tableName}` WHERE Key_name = ?", [$indexName]);
                return count($indexes) > 0;
            }
        };

        // Индексы для таблицы articles
        if (!$hasIndex('articles', 'articles_active_index')) {
            Schema::table('articles', function (Blueprint $table) {
                $table->index('active', 'articles_active_index');
            });
        }
        if (!$hasIndex('articles', 'articles_category_index')) {
            $driver = DB::getDriverName();
            if ($driver === 'sqlite') {
                Schema::table('articles', function (Blueprint $table) {
                    $table->index('category', 'articles_category_index');
                });
            } else {
                DB::statement('CREATE INDEX articles_category_index ON articles (category(255))');
            }
        }
        if (!$hasIndex('articles', 'articles_created_at_index')) {
            Schema::table('articles', function (Blueprint $table) {
                $table->index('created_at', 'articles_created_at_index');
            });
        }
        if (!$hasIndex('articles', 'articles_home_index')) {
            Schema::table('articles', function (Blueprint $table) {
                $table->index('home', 'articles_home_index');
            });
        }
        if (!$hasIndex('articles', 'articles_active_created_at_index')) {
            Schema::table('articles', function (Blueprint $table) {
                $table->index(['active', 'created_at'], 'articles_active_created_at_index');
            });
        }

        // Индексы для таблицы advises
        if (!$hasIndex('advises', 'advises_active_index')) {
            Schema::table('advises', function (Blueprint $table) {
                $table->index('active', 'advises_active_index');
            });
        }
        if (!$hasIndex('advises', 'advises_category_index')) {
            $driver = DB::getDriverName();
            if ($driver === 'sqlite') {
                Schema::table('advises', function (Blueprint $table) {
                    $table->index('category', 'advises_category_index');
                });
            } else {
                DB::statement('CREATE INDEX advises_category_index ON advises (category(255))');
            }
        }
        if (!$hasIndex('advises', 'advises_created_at_index')) {
            Schema::table('advises', function (Blueprint $table) {
                $table->index('created_at', 'advises_created_at_index');
            });
        }
        if (!$hasIndex('advises', 'advises_active_created_at_index')) {
            Schema::table('advises', function (Blueprint $table) {
                $table->index(['active', 'created_at'], 'advises_active_created_at_index');
            });
        }

        // Индексы для таблицы complex
        if (!$hasIndex('complex', 'complex_active_index')) {
            Schema::table('complex', function (Blueprint $table) {
                $table->index('active', 'complex_active_index');
            });
        }
        if (!$hasIndex('complex', 'complex_alias_index')) {
            Schema::table('complex', function (Blueprint $table) {
                $table->index('alias', 'complex_alias_index');
            });
        }
        if (!$hasIndex('complex', 'complex_sort_index')) {
            Schema::table('complex', function (Blueprint $table) {
                $table->index('sort', 'complex_sort_index');
            });
        }
        if (!$hasIndex('complex', 'complex_active_sort_index')) {
            Schema::table('complex', function (Blueprint $table) {
                $table->index(['active', 'sort'], 'complex_active_sort_index');
            });
        }

        // Индексы для таблицы products
        if (!$hasIndex('products', 'products_active_index')) {
            Schema::table('products', function (Blueprint $table) {
                $table->index('active', 'products_active_index');
            });
        }
        if (!$hasIndex('products', 'products_complex_id_index')) {
            Schema::table('products', function (Blueprint $table) {
                $table->index('complex_id', 'products_complex_id_index');
            });
        }
        if (!$hasIndex('products', 'products_sort_index')) {
            Schema::table('products', function (Blueprint $table) {
                $table->index('sort', 'products_sort_index');
            });
        }
        if (!$hasIndex('products', 'products_complex_active_sort_index')) {
            Schema::table('products', function (Blueprint $table) {
                $table->index(['complex_id', 'active', 'sort'], 'products_complex_active_sort_index');
            });
        }

        // Индексы для таблицы events
        if (!$hasIndex('events', 'events_active_index')) {
            Schema::table('events', function (Blueprint $table) {
                $table->index('active', 'events_active_index');
            });
        }
        if (!$hasIndex('events', 'events_sort_index')) {
            Schema::table('events', function (Blueprint $table) {
                $table->index('sort', 'events_sort_index');
            });
        }
        if (!$hasIndex('events', 'events_home_index')) {
            Schema::table('events', function (Blueprint $table) {
                $table->index('home', 'events_home_index');
            });
        }
        if (!$hasIndex('events', 'events_created_at_index')) {
            Schema::table('events', function (Blueprint $table) {
                $table->index('created_at', 'events_created_at_index');
            });
        }
        if (!$hasIndex('events', 'events_active_sort_index')) {
            Schema::table('events', function (Blueprint $table) {
                $table->index(['active', 'sort'], 'events_active_sort_index');
            });
        }
        if (!$hasIndex('events', 'events_active_created_at_index')) {
            Schema::table('events', function (Blueprint $table) {
                $table->index(['active', 'created_at'], 'events_active_created_at_index');
            });
        }
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
