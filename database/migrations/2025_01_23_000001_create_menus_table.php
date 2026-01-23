<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('day')->unique(); // День 1-7
            $table->string('title');
            $table->string('alias')->unique();
            $table->text('description')->nullable();
            $table->longText('menu_data')->nullable(); // JSON с данными о приемах пищи
            $table->boolean('active')->default(1);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
