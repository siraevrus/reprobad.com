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
            $table->string('alt_left')->nullable()->after('image_left');
            $table->string('alt_right')->nullable()->after('image_right');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('complex', function (Blueprint $table) {
            $table->dropColumn(['alt_left', 'alt_right']);
        });
    }
};
