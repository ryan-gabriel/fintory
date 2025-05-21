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
        Schema::create('cashledger', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('outlet_id');
            $table->timestamp('tanggal')->useCurrent();
            $table->enum('tipe', ['INCOME','EXPENSE','TRANSFER_IN','TRANSFER_OUT','ADJUSTMENT']);
            $table->string('sumber', 100)->nullable();
            $table->unsignedBigInteger('referensi_id')->nullable();
            $table->text('deskripsi')->nullable();
            $table->decimal('amount', 14, 2);
            $table->decimal('saldo_setelah', 14, 2)->nullable();
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
        Schema::dropIfExists('cashledger');
    }
};
