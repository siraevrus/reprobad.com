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
        if (!Schema::hasTable('test_questions')) {
            Schema::create('test_questions', function (Blueprint $table) {
                $table->id();
                $table->text('question_text'); // Текст вопроса
                $table->integer('order')->unique(); // Порядок вопроса (1-24)
                $table->json('answers'); // Варианты ответов с баллами [{"text": "Никогда", "value": 0}, ...]
                $table->boolean('active')->default(true); // Активен ли вопрос
                $table->timestamps();
                
                $table->index('order');
                $table->index('active');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('test_questions');
    }
};
