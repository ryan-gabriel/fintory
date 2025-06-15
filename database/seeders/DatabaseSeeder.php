<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Role;
use App\Models\Lembaga;
use App\Models\SubscriptionStatus;
use Carbon\Carbon;
use Database\Factories\BarangFactory;
use Database\Factories\KategoriFactory;
use Database\Factories\ProductFactory;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // First, seed all roles with complete information
        $this->seedRoles();
        
        // 1) CREATE OR GET THE "admin@gmail.com" USER
        $admin = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                // 'name'              => 'Admin User',
                'email_verified_at' => now(),
                'password'          => Hash::make('12345678'),
                'remember_token'    => Str::random(10),
                'created_at'        => now(),
                'updated_at'        => now(),
            ]
        );

        // 2) GET THE ROLES (they should exist from seedRoles method)
        $superRole = Role::where('role_name', 'super')->first();
        $adminRole = Role::where('role_name', 'admin')->first();
        $keuanganRole = Role::where('role_name', 'keuangan')->first();

        // 3) CREATE OR GET "Moezza Petshop" LEMBAGA
        $moezza = Lembaga::firstOrCreate(
            ['name' => 'Moezza Petshop'],
            [
                'industry'   => 'Pet Care & Retail',
                'phone'      => '+62 21 1234 5678',
                'email'      => 'info@moezzapetshop.com',
                'address'    => 'Jl. Pet Care No. 123, Jakarta',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        // 4) ATTACH user#1 AS "super" IN MOEZZA PETSHOP
        $admin->lembagaRoles()->syncWithoutDetaching([
            $superRole->id => ['lembaga_id' => $moezza->id]
        ]);

        // 5) CREATE SUBSCRIPTION STATUS FOR MOEZZA PETSHOP
        SubscriptionStatus::firstOrCreate(
            ['lembaga_id' => $moezza->id],
            [
                'status' => 'active',
                'tier' => 'pro',
                'start_date' => Carbon::today()->subDays(30),
                'end_date' => Carbon::today()->addYear(),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        $this->command->info('✅ DatabaseSeeder completed successfully!');
        $this->command->info('   - Admin user: admin@gmail.com (password: 12345678)');
        $this->command->info('   - Lembaga: Moezza Petshop with Pro subscription');
        $this->command->info('   - All roles seeded with descriptions');

        $this->call(MenuItemSeeder::class);
        $this->call(OutletSeeder::class);
        $this->call(ProdukPenjualanSeeder::class);
        $this->call(MenuRolesSeeder::class);
        $this->call(LembagaUserRoleTableSeeder::class);



        // keuangan seeder butuh outlet seeder terlebih dahulu
        $this->call(KeuanganSeeder::class);
        
    }

    /**
     * Seed all roles with complete information
     */
    private function seedRoles(): void
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

        $this->command->info('✅ Roles seeded: ' . implode(', ', array_column($roles, 'role_name')));
    }



}