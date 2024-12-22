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
        Schema::table('points', function (Blueprint $table) {
            $table->string('phone')->nullable();
            $table->string('time')->nullable();
            $table->string('days')->nullable();
            $table->string('site')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('points', function (Blueprint $table) {
            $table->dropColumn('phone');
            $table->dropColumn('time');
            $table->dropColumn('days');
            $table->dropColumn('site');
        });
    }
};
