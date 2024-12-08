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
            $table->longText('logo')->nullable();
            $table->longText('photo')->nullable();
            $table->text('subtitle')->nullable();
            $table->string('products')->nullable();
            $table->text('text')->nullable();
            $table->text('includes')->nullable();
            $table->text('usage')->nullable();
            $table->text('about')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('logo');
            $table->dropColumn('photo');
            $table->dropColumn('subtitle');
            $table->dropColumn('products');
            $table->dropColumn('text');
            $table->dropColumn('includes');
            $table->dropColumn('usage');
            $table->dropColumn('about');
        });
    }
};
