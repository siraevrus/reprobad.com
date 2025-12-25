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
        Schema::create('bot_rate_limits', function (Blueprint $table) {
            $table->id();
            $table->string('ip_address', 45)->index();
            $table->date('date')->index();
            $table->integer('count')->default(0);
            $table->timestamps();
            
            $table->unique(['ip_address', 'date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bot_rate_limits');
    }
};
