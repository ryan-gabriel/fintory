<?php

namespace Database\Seeders;

use App\Models\MenuItem;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing menu_roles data safely
        DB::table('menu_roles')->delete();

        // Get roles
        $superRole = Role::where('role_name', 'super')->first();
        $adminRole = Role::where('role_name', 'admin')->first();
        $keuanganRole = Role::where('role_name', 'keuangan')->first();
        $managerRole = Role::where('role_name', 'manager')->first();
        $employeeRole = Role::where('role_name', 'employee')->first();
        $viewerRole = Role::where('role_name', 'viewer')->first();

        if (!$superRole || !$adminRole || !$keuanganRole || !$managerRole || !$employeeRole || !$viewerRole) {
            $this->command->error('Some roles are missing. Please run RoleSeeder first.');
            return;
        }

        // Define menu access by role
        $menuAccess = [
            // Dashboard - accessible by all roles
            'Dashboard' => [$superRole->id, $adminRole->id, $keuanganRole->id, $managerRole->id, $employeeRole->id, $viewerRole->id],
            
            // Penjualan - accessible by admin, manager, employee
            'Penjualan' => [$superRole->id, $adminRole->id, $managerRole->id, $employeeRole->id],
            
            // Produk & Stok and its children - accessible by admin, manager, employee
            'Produk & Stok' => [$superRole->id, $adminRole->id, $managerRole->id, $employeeRole->id],
            'Daftar Produk' => [$superRole->id, $adminRole->id, $managerRole->id, $employeeRole->id],
            'Manajemen Barang' => [$superRole->id, $adminRole->id, $managerRole->id],
            'Mutasi Stok' => [$superRole->id, $adminRole->id, $managerRole->id, $employeeRole->id],
            
            // Keuangan and its children - accessible by admin, keuangan, manager
            'Keuangan' => [$superRole->id, $adminRole->id, $keuanganRole->id, $managerRole->id],
            'Kas & Ledger' => [$superRole->id, $adminRole->id, $keuanganRole->id, $managerRole->id],
            'Hutang' => [$superRole->id, $adminRole->id, $keuanganRole->id, $managerRole->id],
            'Cicilan' => [$superRole->id, $adminRole->id, $keuanganRole->id, $managerRole->id],
            
            // Outlet & Karyawan and its children - accessible by super and admin only
            'Outlet & Karyawan' => [$superRole->id, $adminRole->id],
            'Daftar Outlet' => [$superRole->id, $adminRole->id],
            'Saldo Outlet' => [$superRole->id, $adminRole->id],
            'Karyawan' => [$superRole->id, $adminRole->id],
            
            // Laporan and its children - accessible by all except employee
            'Laporan' => [$superRole->id, $adminRole->id, $keuanganRole->id, $managerRole->id, $viewerRole->id],
            'Laporan Penjualan' => [$superRole->id, $adminRole->id, $keuanganRole->id, $managerRole->id, $viewerRole->id],
            'Laporan Stok' => [$superRole->id, $adminRole->id, $managerRole->id, $viewerRole->id],
            'Laporan Keuangan' => [$superRole->id, $adminRole->id, $keuanganRole->id, $managerRole->id, $viewerRole->id],
            
            // Pengaturan and its children
            'Pengaturan' => [$superRole->id, $adminRole->id],
            'Manajemen User & Role' => [$adminRole->id], // Only admin
            'Kategori Produk' => [$superRole->id, $adminRole->id, $managerRole->id],
            
            // Log Aktivitas - accessible by admin and manager
            'Log Aktivitas' => [$superRole->id, $adminRole->id, $managerRole->id],
            
            // New menu item - Manajemen Role & Menu - only super
            'Manajemen Role & Menu' => [$superRole->id],
        ];

        // Insert menu roles
        $insertData = [];
        foreach ($menuAccess as $menuName => $roleIds) {
            $menuItem = MenuItem::where('menu_name', $menuName)->first();
            
            if ($menuItem) {
                foreach ($roleIds as $roleId) {
                    $insertData[] = [
                        'menu_item_id' => $menuItem->id,
                        'role_id' => $roleId,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            } else {
                $this->command->warn("Menu item '{$menuName}' not found!");
            }
        }

        // Batch insert for better performance
        if (!empty($insertData)) {
            DB::table('menu_roles')->insert($insertData);
            $this->command->info('Menu roles seeded successfully! Total records: ' . count($insertData));
        } else {
            $this->command->error('No menu roles data to insert!');
        }
    }
}