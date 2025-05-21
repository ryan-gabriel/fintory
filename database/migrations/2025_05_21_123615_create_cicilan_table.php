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
        Schema::create('cicilan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('hutang_id');
            $table->date('tanggal_bayar');
            $table->decimal('jumlah_bayar', 14, 2);
            $table->string('metode_pembayaran')->nullable();
            $table->text('deskripsi')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('hutang_id')->references('id')->on('hutang')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cicilan');
    }
};
