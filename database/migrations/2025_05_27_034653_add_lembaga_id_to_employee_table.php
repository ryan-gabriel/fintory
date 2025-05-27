<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('employee', function (Blueprint $table) {
            $table->unsignedBigInteger('lembaga_id')->after('outlet_id');

            $table->foreign('lembaga_id')
                ->references('id')->on('lembaga')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('employee', function (Blueprint $table) {
            $table->dropForeign(['lembaga_id']);
            $table->dropColumn('lembaga_id');
        });
    }
};
