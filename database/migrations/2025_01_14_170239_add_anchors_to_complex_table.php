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
        Schema::table('complex', function (Blueprint $table) {
            $table->text('anchor_left')->nullable();
            $table->text('anchor_right')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('complex', function (Blueprint $table) {
            $table->dropColumn('anchor_left');
            $table->dropColumn('anchor_right');
        });
    }
};
