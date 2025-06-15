<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Method ini akan dijalankan saat Anda menjalankan 'php artisan migrate'.
     */
    public function up(): void
    {
        // Menjalankan SQL mentah untuk MEMBUAT trigger
        DB::unprepared('
            CREATE TRIGGER `after_saleitem_insert`
            AFTER INSERT ON `saleitem`
            FOR EACH ROW
            BEGIN
                DECLARE sale_outlet_id INT;

                -- 1. Ambil ID outlet dari tabel `sale` yang berelasi
                SELECT `outlet_id` INTO sale_outlet_id 
                FROM `sale` 
                WHERE `id` = NEW.sale_id;

                -- 2. Kurangi stok di tabel `product`
                UPDATE `product`
                SET `stok` = `stok` - NEW.quantity
                WHERE `id` = NEW.product_id;

                -- 3. Buat catatan baru di tabel `stockmutation`
                INSERT INTO `stockmutation` (
                    `product_id`, `outlet_id`, `quantity`, `type`, 
                    `reference_type`, `reference_id`, `created_at`, `updated_at`
                )
                VALUES (
                    NEW.product_id, sale_outlet_id, NEW.quantity, "out", 
                    "sale", NEW.sale_id, NOW(), NOW()
                );
            END
        ');
    }

    /**
     * Reverse the migrations.
     * Method ini akan dijalankan saat Anda menjalankan 'php artisan migrate:rollback'.
     */
    public function down(): void
    {
        // Menjalankan SQL mentah untuk MENGHAPUS trigger
        DB::unprepared('DROP TRIGGER IF EXISTS `after_saleitem_insert`');
    }
};