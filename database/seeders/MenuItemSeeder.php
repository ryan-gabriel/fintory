<?php

namespace Database\Seeders;

use App\Models\MenuItem;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing menu items safely
        DB::table('menu_roles')->delete();
        MenuItem::query()->delete();
        
        // Reset auto increment
        DB::statement('ALTER TABLE menu_items AUTO_INCREMENT = 1');

        // Dashboard
        $dashboard = MenuItem::create([
            'menu_name' => 'Dashboard',
            'icon'      => 'fas fa-tachometer-alt',
            'route'     => '#',
            'is_parent' => false,
            'order'     => 1,
        ]);
        

        // Penjualan
        $penjualan = MenuItem::create([
            'menu_name' => 'Penjualan',
            'icon' => 'fa-solid fa-magnifying-glass-chart',
            'route' => '/dashboard/penjualan',
            'is_parent' => false,
            'order' => 2
        ]);

        // Produk & Stok
        $produkStok = MenuItem::create([
            'menu_name' => 'Produk & Stok',
            'icon' => 'fa-solid fa-boxes-stacked',
            'route' => null,
            'is_parent' => true,
            'order' => 3
        ]);

        MenuItem::create([
            'menu_name' => 'Daftar Produk',
            'icon' => 'fa-solid fa-clipboard-list',
            'route' => '/dashboard/produk-stok/produk',
            'is_parent' => false,
            'parent_id' => $produkStok->id,
            'order' => 1
        ]);

        MenuItem::create([
            'menu_name' => 'Manajemen Barang',
            'icon' => 'fa-solid fa-list-check',
            'route' => '/dashboard/produk-stok/barang',
            'is_parent' => false,
            'parent_id' => $produkStok->id,
            'order' => 2
        ]);

        MenuItem::create([
            'menu_name' => 'Mutasi Stok',
            'icon' => 'fa-solid fa-truck-moving',
            'route' => '/dashboard/produk-stok/mutasi',
            'is_parent' => false,
            'parent_id' => $produkStok->id,
            'order' => 3
        ]);

        // Keuangan
        $keuangan = MenuItem::create([
            'menu_name' => 'Keuangan',
            'icon' => 'fa-solid fa-coins',
            'route' => null,
            'is_parent' => true,
            'order' => 4
        ]);

        MenuItem::create([
            'menu_name' => 'Kas & Ledger',
            'icon' => 'fa-solid fa-money-bills',
            'route' => '/dashboard/keuangan/kas-ledger',
            'is_parent' => false,
            'parent_id' => $keuangan->id,
            'order' => 1
        ]);

        MenuItem::create([
            'menu_name' => 'Hutang',
            'icon' => 'fa-solid fa-sack-xmark',
            'route' => '/dashboard/keuangan/hutang',
            'is_parent' => false,
            'parent_id' => $keuangan->id,
            'order' => 2
        ]);

        MenuItem::create([
            'menu_name' => 'Cicilan',
            'icon' => 'fa-solid fa-sack-dollar',
            'route' => '/dashboard/keuangan/cicilan',
            'is_parent' => false,
            'parent_id' => $keuangan->id,
            'order' => 3
        ]);

        // Outlet & Karyawan
        $outletKaryawan = MenuItem::create([
            'menu_name' => 'Outlet & Karyawan',
            'icon' => 'fa-solid fa-shop',
            'route' => null,
            'is_parent' => true,
            'order' => 5
        ]);

        MenuItem::create([
            'menu_name' => 'Daftar Outlet',
            'icon' => 'fa-solid fa-store',
            'route' => '#',
            'is_parent' => false,
            'parent_id' => $outletKaryawan->id,
            'order' => 1
        ]);

        MenuItem::create([
            'menu_name' => 'Saldo Outlet',
            'icon' => 'fa-solid fa-scale-balanced',
            'route' => '#',
            'is_parent' => false,
            'parent_id' => $outletKaryawan->id,
            'order' => 2
        ]);

        MenuItem::create([
            'menu_name' => 'Karyawan',
            'icon' => 'fa-solid fa-users-line',
            'route' => '#',
            'is_parent' => false,
            'parent_id' => $outletKaryawan->id,
            'order' => 3
        ]);

        // Laporan
        $laporan = MenuItem::create([
            'menu_name' => 'Laporan',
            'icon' => 'fa-solid fa-book',
            'route' => null,
            'is_parent' => true,
            'order' => 6
        ]);

        MenuItem::create([
            'menu_name' => 'Laporan Penjualan',
            'icon' => 'fa-solid fa-square-poll-vertical',
            'route' => '/dashboard/laporan/penjualan',
            'is_parent' => false,
            'parent_id' => $laporan->id,
            'order' => 1
        ]);

        MenuItem::create([
            'menu_name' => 'Laporan Stok',
            'icon' => 'fa-solid fa-cubes-stacked',
            'route' => '#',
            'is_parent' => false,
            'parent_id' => $laporan->id,
            'order' => 2
        ]);

        MenuItem::create([
            'menu_name' => 'Laporan Keuangan',
            'icon' => 'fa-solid fa-magnifying-glass-dollar',
            'route' => '/dashboard/laporan/keuangan',
            'is_parent' => false,
            'parent_id' => $laporan->id,
            'order' => 3
        ]);

        // Pengaturan
        $pengaturan = MenuItem::create([
            'menu_name' => 'Pengaturan',
            'icon' => 'fa-solid fa-gear',
            'route' => null,
            'is_parent' => true,
            'order' => 7
        ]);

        MenuItem::create([
            'menu_name' => 'Manajemen User & Role',
            'icon' => 'fa-solid fa-users-gear',
            'route' => '#',
            'is_parent' => false,
            'parent_id' => $pengaturan->id,
            'order' => 1
        ]);

        MenuItem::create([
            'menu_name' => 'Manajemen Role & Menu',
            'icon' => 'fa-solid fa-list-ul',
            'route' => '/dashboard/admin/menu',
            'is_parent' => false,
            'parent_id' => $pengaturan->id,
            'order' => 2
        ]);

        MenuItem::create([
            'menu_name' => 'Kategori Produk',
            'icon' => 'fa-solid fa-tags',
            'route' => '/dashboard/produk-stok/kategori',
            'is_parent' => false,
            'parent_id' => $pengaturan->id,
            'order' => 3
        ]);

        // Log Aktivitas
        MenuItem::create([
            'menu_name' => 'Log Aktivitas',
            'icon' => 'fa-solid fa-timeline',
            'route' => '#',
            'is_parent' => false,
            'order' => 8
        ]);
    }
}