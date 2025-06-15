<?php

namespace Database\Factories;

use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Outlet;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'outlet_id' => Outlet::inRandomOrder()->first()->id,
            'barang_id' => Barang::inRandomOrder()->first()->kode_barang,
            'kategori_id' => Kategori::inRandomOrder()->first()->id,
            // Membuat harga jual yang lebih realistis (kelipatan 500 atau 1000)
            'harga_jual' => $this->faker->numberBetween(15, 300) * 1000,
            'stok' => $this->faker->numberBetween(10, 100),
            'is_active' => true,
        ];
    }
}