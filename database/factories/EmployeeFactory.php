<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\Lembaga;
use App\Models\Outlet;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeFactory extends Factory
{
    /**
     * Tentukan model yang terhubung dengan factory ini.
     *
     * @var string
     */
    protected $model = Employee::class;

    /**
     * Definisikan "resep" untuk membuat data karyawan dummy.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Ambil outlet secara acak yang sudah ada di database.
        // Ini penting karena karyawan harus terhubung ke outlet & lembaga yang valid.
        $outlet = Outlet::inRandomOrder()->first();
        
        // Jika tidak ada outlet, buat satu sebagai fallback.
        if (!$outlet) {
             $lembaga = Lembaga::first() ?? Lembaga::factory()->create();
             $outlet = Outlet::factory()->create(['lembaga_id' => $lembaga->id]);
        }

        return [
            // Membuat user baru untuk setiap karyawan agar user_id nya unik.
            'user_id' => User::factory(),
            
            // Nama karyawan
            'name' => $this->faker->name(),
            
            // Menggunakan outlet_id dan lembaga_id dari outlet yang kita ambil di atas
            'outlet_id' => $outlet->id,
            'lembaga_id' => $outlet->lembaga_id,
            
            // Posisi/jabatan acak
            'position' => $this->faker->randomElement(['Kasir', 'Staff Gudang', 'Manager Outlet', 'Admin']),
            
            // Tanggal bergabung acak dalam 3 tahun terakhir
            'joined_at' => $this->faker->dateTimeBetween('-3 years', 'now'),
        ];
    }
}