<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('test_questions') && ! Schema::hasColumn('test_questions', 'block_number')) {
            Schema::table('test_questions', function (Blueprint $table) {
                $table->unsignedTinyInteger('block_number')->default(1)->after('order');
            });

            DB::table('test_questions')->update([
                'block_number' => DB::raw('CASE
                    WHEN `order` BETWEEN 1 AND 6 THEN 1
                    WHEN `order` BETWEEN 7 AND 14 THEN 2
                    WHEN `order` BETWEEN 15 AND 19 THEN 3
                    WHEN `order` BETWEEN 20 AND 24 THEN 4
                    ELSE 1 END'),
            ]);
        }

        if (Schema::hasTable('test_result_fields') && ! Schema::hasColumn('test_result_fields', 'block_number')) {
            Schema::table('test_result_fields', function (Blueprint $table) {
                $table->unsignedTinyInteger('block_number')->default(1)->after('field_number');
            });

            DB::table('test_result_fields')->update([
                'block_number' => DB::raw('CASE `field_number`
                    WHEN 1 THEN 1 WHEN 2 THEN 1
                    WHEN 3 THEN 2 WHEN 4 THEN 2 WHEN 5 THEN 2
                    WHEN 6 THEN 3 WHEN 7 THEN 3
                    WHEN 8 THEN 4 WHEN 9 THEN 4
                    ELSE 1 END'),
            ]);
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('test_questions') && Schema::hasColumn('test_questions', 'block_number')) {
            Schema::table('test_questions', function (Blueprint $table) {
                $table->dropColumn('block_number');
            });
        }

        if (Schema::hasTable('test_result_fields') && Schema::hasColumn('test_result_fields', 'block_number')) {
            Schema::table('test_result_fields', function (Blueprint $table) {
                $table->dropColumn('block_number');
            });
        }
    }
};
