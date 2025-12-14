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
        Schema::create('chat_history', function (Blueprint $table) {
            $table->id();
            $table->string('user_id', 100)->index();
            $table->string('source', 20)->default('web')->comment('web или telegram'); // web или telegram
            $table->string('chat_id', 100)->nullable()->index()->comment('Telegram chat_id если источник telegram');
            $table->text('user_message');
            $table->text('bot_response');
            $table->timestamps();
            
            // Индекс для быстрого получения последних сообщений
            $table->index(['user_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chat_history');
    }
};

