<?php

namespace Database\Seeders;

use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Product;
use App\Models\Sale;
use App\Models\Outlet;
use App\Models\Lembaga;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class ProdukPenjualanSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('🚀 Mulai seeding data penjualan...');

        /**
         * 1️⃣ Pastikan kategori ada
         */
        if (Kategori::count() === 0) {
            Kategori::factory()->count(10)->create();
            $this->command->info('✔ 10 kategori dibuat');
        }

        /**
         * 2️⃣ Barang & Produk
         */
        Barang::factory()->count(40)->create();
        $this->command->info('✔ 40 barang dibuat');

        Product::factory()->count(100)->create();
        $this->command->info('✔ 100 produk dibuat');

        /**
         * 3️⃣ SALE WAJIB 7 HARI TERAKHIR (PER LEMBAGA)
         */
        $lembagas = Lembaga::with('outlets')->get();

        foreach ($lembagas as $lembaga) {
            // Ambil 1 outlet saja
            $outlet = $lembaga->outlets->random();

            $this->command->info("📌 Lembaga {$lembaga->id} → Outlet {$outlet->id}");

            // 7 hari ke belakang
            for ($day = 0; $day < 7; $day++) {
                $date = Carbon::now()->subDays($day);

                Sale::factory()
                    ->count(rand(1, 3)) // 1–3 transaksi per hari
                    ->state([
                        'outlet_id' => $outlet->id,
                        'sale_date' => $date,
                        'created_at' => $date,
                        'updated_at' => $date,
                    ])
                    ->create();
            }
        }

        Sale::factory()->count(150)->create();
        $this->command->info('✔ 150 transaksi tambahan dibuat');

        $this->command->info('✅ Seeder penjualan SELESAI & VALID');
    }
}
