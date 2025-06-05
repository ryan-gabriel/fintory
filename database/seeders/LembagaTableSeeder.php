<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LembagaTableSeeder extends Seeder
{
    public function run(): void
    {
        // If you want to avoid duplicates, you can truncate first:
        // DB::table('lembaga')->truncate();

        DB::table('lembaga')->insert([
            [
                'name'       => 'Moezza Petshop',
                'industry'   => null,
                'phone'      => null,
                'email'      => null,
                'address'    => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
