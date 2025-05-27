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
        Schema::create('subscription_status', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lembaga_id');
            $table->enum('status', ['active', 'inactive', 'trial', 'cancelled']);
            $table->enum('tier', ['free', 'basic', 'pro', 'enterprise']);
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->boolean('is_active')->default(true);

            $table->foreign('lembaga_id')->references('id')->on('lembaga')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscription_status');
    }
};
