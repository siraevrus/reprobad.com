<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('test_result_fields', 'popup_html')) {
            return;
        }
        Schema::table('test_result_fields', function (Blueprint $table) {
            $table->longText('popup_html')->nullable()->after('description')->comment('HTML для модального окна «Подробнее»');
        });
    }

    public function down(): void
    {
        Schema::table('test_result_fields', function (Blueprint $table) {
            $table->dropColumn('popup_html');
        });
    }
};
