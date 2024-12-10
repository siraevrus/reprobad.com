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
        Schema::create('complex', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('alias');
            $table->string('subtitle')->nullable();
            $table->text('content')->nullable();
            $table->longText('image_left')->nullable();
            $table->longText('image_right')->nullable();
            $table->string('title_left')->nullable();
            $table->string('title_right')->nullable();
            $table->text('description')->nullable();
            $table->string('color')->nullable();
            $table->string('products')->nullable();
            $table->boolean('active')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('complex');
    }
};
