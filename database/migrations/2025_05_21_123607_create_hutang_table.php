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
        Schema::create('hutang', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('outlet_id');
            $table->string('nama_pemberi_hutang');
            $table->date('tanggal_hutang');
            $table->decimal('jumlah', 14, 2);
            $table->decimal('sisa_hutang', 14, 2)->nullable();
            $table->text('deskripsi')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('outlet_id')->references('id')->on('outlet');
            $table->foreign('created_by')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hutang');
    }
};
