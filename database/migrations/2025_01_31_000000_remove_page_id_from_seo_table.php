<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('seo', function (Blueprint $table) {
            $table->dropUnique(['page_type', 'page_id']);
            $table->dropColumn('page_id');
            $table->unique('page_type');
        });
    }

    public function down()
    {
        Schema::table('seo', function (Blueprint $table) {
            $table->dropUnique(['page_type']);
            $table->unsignedBigInteger('page_id')->after('page_type');
            $table->unique(['page_type', 'page_id']);
        });
    }
}; 