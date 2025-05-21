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
        Schema::create('employee', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('outlet_id');
            $table->string('position', 100)->nullable();
            $table->date('joined_at')->nullable();
            $table->unique(['user_id', 'outlet_id']);
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('outlet_id')->references('id')->on('outlet');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee');
    }
};
