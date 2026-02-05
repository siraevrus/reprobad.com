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
            // Удаляем старое поле products (JSON)
            $table->dropColumn('products');
            
            // Меняем description на longText
            $table->longText('description')->change();
            
            // Добавляем новые поля для изображений и ссылок
            $table->string('image1')->nullable()->after('color')->comment('Путь к изображению продукта 1');
            $table->string('link1')->nullable()->after('image1')->comment('Ссылка на продукт 1');
            $table->string('image2')->nullable()->after('link1')->comment('Путь к изображению продукта 2');
            $table->string('link2')->nullable()->after('image2')->comment('Ссылка на продукт 2');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('test_result_fields', function (Blueprint $table) {
            // Возвращаем products
            $table->json('products')->after('color');
            
            // Удаляем новые поля
            $table->dropColumn(['image1', 'link1', 'image2', 'link2']);
            
            // Возвращаем description к text
            $table->text('description')->change();
        });
    }
};
