<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LembagaUserRoleTableSeeder extends Seeder
{
    public function run(): void
    {
        // 1) Look up user_id = 1 (already exists)
        $userId = 1;

        // 2) Look up the 'super' role ID
        $superRoleId = DB::table('roles')
            ->where('role_name', 'super')
            ->value('id');

        // 3) Look up the lembaga ID for "Moezza Petshop"
        $lembagaId = DB::table('lembaga')
            ->where('name', 'Moezza Petshop')
            ->value('id');

        // If either lookup fails, stop here
        if (! $userId || ! $superRoleId || ! $lembagaId) {
            // You can throw an exception or just return
            return;
        }

        // 4) Insert into the pivot table
        DB::table('lembaga_user_role')->insert([
            'user_id'     => $userId,
            'role_id'     => $superRoleId,
            'lembaga_id'  => $lembagaId,
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);
    }
}
