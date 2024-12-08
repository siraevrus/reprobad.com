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
        Schema::table('products', function (Blueprint $table) {
            $table->renameColumn('imageleft', 'image_left');
            $table->renameColumn('imageright', 'image_right');
            $table->string('title_right')->nullable();
            $table->string('title_left')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->renameColumn('image_left', 'imageleft');
            $table->renameColumn('image_right', 'imageright');
            $table->dropColumn('title_right');
            $table->dropColumn('title_left');
        });
    }
};
