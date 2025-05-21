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
        Schema::create('product', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('outlet_id');
            $table->unsignedInteger('barang_id');
            $table->unsignedBigInteger('kategori_id');
            $table->decimal('harga_jual', 12, 2);
            $table->integer('stok')->default(0);
            $table->boolean('is_active')->default(true);
            $table->foreign('outlet_id')->references('id')->on('outlet');
            $table->foreign('barang_id')->references('kode_barang')->on('barang');
            $table->foreign('kategori_id')->references('id')->on('kategori');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product');
    }
};
