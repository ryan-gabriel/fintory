<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Hapus trigger PostgreSQL (wajib sebutkan nama tabelnya)
        DB::unprepared('
            DROP TRIGGER IF EXISTS after_product_update_handle_stock_adjustment ON product;
        ');
    }

    public function down(): void
    {
        // Tidak membuat ulang trigger
    }
};
