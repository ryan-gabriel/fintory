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
        Schema::create('menu_roles', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('menu_item_id')->unsigned();
            $table->bigInteger('role_id')->unsigned();
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('menu_item_id')->references('id')->on('menu_items')->onDelete('cascade');
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');

            // Unique constraint to prevent duplicate entries
            $table->unique(['menu_item_id', 'role_id']);

            // Indexes for better performance
            $table->index(['menu_item_id']);
            $table->index(['role_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_roles');
    }
};