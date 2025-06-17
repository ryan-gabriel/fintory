<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     * Method ini akan membuat Trigger di database.
     */
    public function up(): void
    {
        DB::unprepared('
            CREATE TRIGGER `after_product_insert_handle_stock`
            AFTER INSERT ON `product`
            FOR EACH ROW
            BEGIN
                -- Hanya jalankan jika stok awal yang di-input lebih dari 0
                IF NEW.stok > 0 THEN
                    -- 1. Buat catatan di tabel stockmutation sebagai "pembelian" awal
                    INSERT INTO `stockmutation` (
                        `product_id`, `outlet_id`, `quantity`, `type`,
                        `reference_type`, `reference_id`, `created_at`, `updated_at`
                    )
                    VALUES (
                        NEW.id, NEW.outlet_id, NEW.stok, "in",
                        "purchase", NULL, NOW(), NOW()
                    );
                END IF;
            END
        ');
    }

    /**
     * Reverse the migrations.
     * Method ini akan menghapus Trigger.
     */
    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS `after_product_insert_handle_stock`');
    }
};