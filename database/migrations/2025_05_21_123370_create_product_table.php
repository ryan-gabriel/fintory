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
            $table->unsignedBigInteger('kategori_id')->nullable(); // nullable karena kita akan SET NULL
            $table->decimal('harga_jual', 12, 2);
            $table->integer('stok')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            // Foreign keys
            $table->foreign('outlet_id')
                ->references('id')->on('outlet')
                ->onDelete('cascade'); // Jika outlet dihapus, product juga terhapus

            $table->foreign('barang_id')
                ->references('kode_barang')->on('barang')
                ->onDelete('cascade'); // Jika barang dihapus, product juga terhapus

            $table->foreign('kategori_id')
                ->references('id')->on('kategori')
                ->onDelete('set null'); // Jika kategori dihapus, field jadi null
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
