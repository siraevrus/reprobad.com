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
        Schema::table('advises', function (Blueprint $table) {
            $table->text('time')->nullable();
            $table->text('category')->nullable();
            $table->longText('icon')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('advises', function (Blueprint $table) {
            $table->dropColumn('time');
            $table->dropColumn('category');
            $table->dropColumn('icon');
        });
    }
};
