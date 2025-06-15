<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LembagaUserRoleTableSeeder extends Seeder
{
    public function run(): void
    {
        // Clear existing data for user_id = 1
        DB::table('lembaga_user_role')->where('user_id', 1)->delete();

        // 1) Look up user_id = 1 (already exists)
        $userId = 1;

        // 2) Get all role IDs
        $roles = DB::table('roles')->get(['id', 'role_name']);

        // 3) Look up the lembaga ID for "Moezza Petshop"
        $lembagaId = DB::table('lembaga')
            ->where('name', 'Moezza Petshop')
            ->value('id');

        // If lookup fails, stop here
        if (!$userId || $roles->isEmpty() || !$lembagaId) {
            $this->command->error('Required data not found: user_id=1, roles, or lembaga "Moezza Petshop"');
            return;
        }

        // 4) Insert all roles for user_id = 1 in lembaga_id = 1
        $insertData = [];
        foreach ($roles as $role) {
            $insertData[] = [
                'user_id'     => $userId,
                'role_id'     => $role->id,
                'lembaga_id'  => $lembagaId,
                'created_at'  => now(),
                'updated_at'  => now(),
            ];
        }

        // Batch insert for better performance
        DB::table('lembaga_user_role')->insert($insertData);

        $this->command->info("Successfully assigned all roles to user_id={$userId} for lembaga_id={$lembagaId}:");
        foreach ($roles as $role) {
            $this->command->info("- {$role->role_name} (role_id: {$role->id})");
        }
    }
}