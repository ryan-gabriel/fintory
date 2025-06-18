<?php

namespace Database\Factories;

use App\Models\Barang;
use Illuminate\Database\Eloquent\Factories\Factory;

class BarangFactory extends Factory
{
    protected $model = Barang::class;

    /**
     * @var array Daftar nama produk yang akan digunakan. Dibuat static agar tidak di-reset setiap kali factory dipanggil.
     */
    protected static $productNames = [
        'Royal Canin Kitten Pouch 85g', 'Royal Canin Mini Adult 2kg', 'Royal Canin Persian Adult 1kg',
        'Whiskas Adult Tuna 1.2kg', 'Whiskas Junior Mackerel', 'Whiskas Pouch Ocean Fish',
        'Pro Plan Adult Chicken', 'Pro Plan Kitten Starter',
        'Me-O Kitten Persian', 'Me-O Adult Salmon', 'Me-O Cat Treat',
        'Friskies Seafood Sensation 1.1kg', 'Friskies Kitten Discoveries',
        'Bolt Tuna & Salmon Flavor 1kg', 'Bolt Cat Food Ikan',
        'Cat Choize Adult Salmon', 'Cat Choize Kitten Tuna',
        'Equilibrio Cat Adult', 'Equilibrio Kitten',
        'Pedigree Adult Beef', 'Pedigree Puppy Chicken & Egg', 'Pedigree Dentastix',
        'Happy Dog NaturCroq Lamb & Rice', 'Happy Dog Mini Adult',
        'Shampoo Anti Kutu & Jamur', 'Sisir Bulu Rontok', 'Gunting Kuku Hewan',
        'Kalung Lonceng Reflektif', 'Mainan Bola Kerincing', 'Mainan Tikus Interaktif',
        'Tempat Makan Anti Semut', 'Botol Minum Gantung',
        'Kandang Lipat Besi Ukuran M', 'Tas Ransel Astronot Hewan',
        'Pasir Gumpal Wangi Lavender 10L', 'Pasir Kucing Tofu Greentea',
        'Vitamin Minyak Ikan', 'Obat Cacing Kucing', 'Obat Tetes Mata Hewan'
    ];

    public function definition(): array
    {
        // Ambil nama produk dari daftar secara acak dan pastikan unik
        // 'unique()' akan mengingat nama yang sudah dipakai dalam satu sesi eksekusi
        // 'shuffle()' mengacak urutan agar tidak monoton
        $nama_barang = $this->faker->unique()->randomElement(static::$productNames);

        return [
            'nama' => $nama_barang,
            'deskripsi' => 'Deskripsi lengkap untuk produk ' . $nama_barang,
        ];
    }
}