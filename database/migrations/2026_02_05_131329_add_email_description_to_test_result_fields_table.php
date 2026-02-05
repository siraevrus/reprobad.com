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
        Schema::table('test_result_fields', function (Blueprint $table) {
            $table->longText('email_description')->nullable()->after('description')->comment('Расширенное описание рекомендаций для email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('test_result_fields', function (Blueprint $table) {
            $table->dropColumn('email_description');
        });
    }
};
