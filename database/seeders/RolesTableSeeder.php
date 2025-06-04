<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use App\Models\Role;

class RolesTableSeeder extends Seeder
{
    public function run(): void
    {
        // Check if the new columns exist
        $hasDisplayName = Schema::hasColumn('roles', 'display_name');
        $hasDescription = Schema::hasColumn('roles', 'description');

        // Define roles with complete data
        $roles = [
            [
                'role_name' => 'super',
                'display_name' => 'Super Administrator',
                'description' => 'Highest level access with all permissions across all lembaga',
            ],
            [
                'role_name' => 'admin',
                'display_name' => 'Administrator',
                'description' => 'Full access administrator with all permissions within lembaga',
            ],
            [
                'role_name' => 'keuangan',
                'display_name' => 'Staff Keuangan',
                'description' => 'Financial staff with access to financial modules and reports',
            ],
            [
                'role_name' => 'employee',
                'display_name' => 'Karyawan',
                'description' => 'Regular employee with basic operational permissions',
            ],
            [
                'role_name' => 'manager',
                'display_name' => 'Manager',
                'description' => 'Manager with limited administrative permissions',
            ],
            [
                'role_name' => 'viewer',
                'display_name' => 'Viewer',
                'description' => 'Read-only access to view data without modification rights',
            ],
        ];

        // Create or update each role
        foreach ($roles as $roleData) {
            $insertData = [
                'role_name' => $roleData['role_name'],
                'created_at' => now(),
                'updated_at' => now(),
            ];

            // Add new columns if they exist
            if ($hasDisplayName) {
                $insertData['display_name'] = $roleData['display_name'];
            }

            if ($hasDescription) {
                $insertData['description'] = $roleData['description'];
            }

            Role::updateOrCreate(
                ['role_name' => $roleData['role_name']],
                $insertData
            );
        }

        $this->command->info('✅ Roles seeded successfully with ' . count($roles) . ' roles.');
    }
}