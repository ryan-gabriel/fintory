<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Membuat 50 data karyawan dummy menggunakan factory.
        // Angka 50 bisa Anda ubah sesuai kebutuhan.
        Employee::factory()->count(50)->create();

        $this->command->info('50 data karyawan dummy berhasil dibuat.');
    }
}