<?php

namespace Database\Seeders;

use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Database\Seeder;

class ProdukPenjualanSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan Kategori dan Outlet sudah ada. Kita bisa membuatnya di sini jika kosong.
        if (Kategori::count() == 0) {
            Kategori::factory()->count(10)->create();
            $this->command->info('10 Kategori dummy dibuat.');
        }

        // 1. Buat 50 master barang
        Barang::factory()->count(50)->create();
        $this->command->info('50 Barang dummy berhasil dibuat.');

        // 2. Buat 100 produk yang tersebar di outlet-outlet
        Product::factory()->count(100)->create();
        $this->command->info('100 Produk dummy berhasil dibuat.');

        // 3. Buat 250 transaksi penjualan
        Sale::factory()->count(250)->create();
        $this->command->info('250 Transaksi Penjualan dummy berhasil dibuat.');
    }
}