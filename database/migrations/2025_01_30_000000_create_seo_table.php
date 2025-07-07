<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('seo', function (Blueprint $table) {
            $table->id();
            $table->string('page_type'); // тип страницы (Article, Page, Product, etc.)
            $table->unsignedBigInteger('page_id'); // ID страницы
            $table->string('title')->nullable(); // meta title
            $table->text('description')->nullable(); // meta description
            $table->text('keywords')->nullable(); // meta keywords
            $table->string('og_title')->nullable(); // Open Graph title
            $table->text('og_description')->nullable(); // Open Graph description
            $table->string('og_image')->nullable(); // Open Graph image
            $table->timestamps();
            
            $table->unique(['page_type', 'page_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('seo');
    }
}; 