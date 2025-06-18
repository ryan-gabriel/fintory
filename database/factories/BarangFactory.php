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
        $brands = ['Royal Canin', 'Whiskas', 'Pro Plan', 'Me-O', 'Friskies', 'Bolt', 'Cat Choize', 'Equilibrio', 'Pedigree', 'Happy Dog', 'Life Cat', 'Maxi', 'Kit Cat', 'Wellness'];
        $types = [
            'Kitten Pouch 85g', 'Adult Tuna 1.2kg', 'Mini Adult 2kg', 'Persian Adult', 'Indoor Cat Formula', 
            'Dental Care Stick', 'Shampoo Anti Kutu', 'Kalung Lonceng', 'Mainan Bola Kerincing', 'Mainan Tikus',
            'Tempat Makan Anti Semut', 'Botol Minum Gantung', 'Kandang Lipat Besi (L)', 'Tas Ransel Astronot',
            'Pasir Gumpal Wangi Kopi 10L', 'Pasir Kucing Tofu Apel', 'Vitamin Minyak Ikan', 'Obat Cacing', 
            'Obat Tetes Mata', 'Adult Salmon 1kg', 'Junior Ocean Fish 450g', 'Hair & Skin Care'
        ];

        // Gabungkan merek dan tipe produk secara acak
        $nama_barang = $this->faker->randomElement($brands) . ' ' . $this->faker->randomElement($types);

        return [
            // Kita tidak lagi menggunakan unique() karena kombinasi acak sudah sangat mungkin unik
            // Jika Anda masih ingin jaminan unik, pastikan jumlah kombinasi > jumlah data yang dibuat
            'nama' => $nama_barang,
            'deskripsi' => 'Deskripsi lengkap untuk produk ' . $nama_barang,
        ];
    }
}