<?php

namespace Database\Factories;

use App\Models\Barang;
use Illuminate\Database\Eloquent\Factories\Factory;

class BarangFactory extends Factory
{
    protected $model = Barang::class;

    public function definition(): array
    {
        // Daftar merek dan tipe produk yang realistis
        $brands = ['Royal Canin', 'Whiskas', 'Pro Plan', 'Me-O', 'Friskies', 'Bolt', 'Cat Choize', 'Equilibrio', 'Pedigree', 'Happy Dog'];
        $types = ['Kitten Pouch 85g', 'Adult Tuna 1.2kg', 'Mini Adult 2kg', 'Persian Adult', 'Indoor Cat Formula', 'Dental Care Stick', 'Shampoo Anti Kutu', 'Kalung Anti Kutu', 'Bola Kerincing', 'Sisir Bulu Halus'];

        // Gabungkan merek dan tipe produk secara acak
        $nama_barang = $this->faker->randomElement($brands) . ' ' . $this->faker->randomElement($types);

        return [
            'nama' => $nama_barang,
            'deskripsi' => 'Deskripsi untuk ' . $nama_barang,
        ];
    }
}