<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('config', function (Blueprint $table) {
            $table->longText('value')->change();
        });
    }

    public function down()
    {
        Schema::table('config', function (Blueprint $table) {
            $table->string('value')->change();
        });
    }
}; 