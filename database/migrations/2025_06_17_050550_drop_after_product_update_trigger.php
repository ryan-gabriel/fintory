<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Hapus trigger yang menyebabkan duplikasi
        DB::unprepared('DROP TRIGGER IF EXISTS `after_product_update_handle_stock_adjustment`');
    }

    public function down(): void
    {
        // (Opsional) Jika Anda ingin bisa rollback, Anda bisa menaruh kode
        // untuk membuat trigger lama di sini. Tapi untuk kasus ini, lebih aman menghapusnya saja.
        // DB::unprepared('CREATE TRIGGER ...'); // Kode trigger lama
    }
};