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
        if (!Schema::hasTable('test_result_fields')) {
            Schema::create('test_result_fields', function (Blueprint $table) {
                $table->id();
                $table->integer('field_number')->unique(); // Номер поля (1-9)
                $table->text('description'); // Текст описания для <p class="reprotest-p">
                $table->string('color')->nullable(); // Цвет блока (null, 'green', 'lavender', 'orange')
                $table->json('products'); // JSON массив продуктов [{"link": "...", "image": "..."}] до 2 элементов
                $table->boolean('active')->default(true); // Активность поля
                $table->integer('order')->default(0); // Порядок сортировки
                $table->timestamps();
                
                $table->index('field_number');
                $table->index('active');
                $table->index('order');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('test_result_fields');
    }
};
