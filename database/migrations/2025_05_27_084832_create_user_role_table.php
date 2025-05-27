<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserRoleTable extends Migration
{
    public function up()
    {
        Schema::create('user_role', function (Blueprint $table) {
            // composite primary key
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('role_id');
            $table->primary(['user_id', 'role_id']);

            // foreign keys
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');

            $table->foreign('role_id')
                ->references('id')->on('roles')
                ->onDelete('cascade');

            // (optional) if you want to track assignment time
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_role');
    }
}
