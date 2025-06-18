<?php

namespace Database\Factories;

use App\Models\Kategori;
use App\Models\Lembaga;
use Illuminate\Database\Eloquent\Factories\Factory;

class KategoriFactory extends Factory
{
    protected $model = Kategori::class;

    public function definition(): array
    {
        // Daftar nama kategori yang realistis untuk pet shop
        $kategori = [
            'Makanan Kering Kucing', 'Makanan Basah Kucing', 'Snack Kucing',
            'Makanan Kering Anjing', 'Makanan Basah Anjing', 'Snack Anjing',
            'Mainan Hewan', 'Aksesoris', 'Kandang & Tas Hewan',
            'Pasir Kucing & Toilet', 'Perawatan & Grooming', 'Obat & Vitamin',
        ];

        return [
            // Memilih satu nama secara acak dari daftar di atas
            'nama' => $this->faker->unique()->randomElement($kategori),
            'deskripsi' => $this->faker->sentence(8),
            'lembaga_id' => Lembaga::first()->id
        ];
    }
}