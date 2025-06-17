<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::unprepared('
            CREATE TRIGGER `after_product_update_handle_stock_adjustment`
            AFTER UPDATE ON `product`
            FOR EACH ROW
            BEGIN
                DECLARE quantity_diff INT;

                -- Hanya jalankan jika nilai stok benar-benar berubah
                IF NEW.stok <> OLD.stok THEN
                    
                    -- Hitung selisih stok (selalu positif menggunakan ABS)
                    SET quantity_diff = ABS(NEW.stok - OLD.stok);

                    -- Jika stok BERTAMBAH (stok baru > stok lama)
                    IF NEW.stok > OLD.stok THEN
                        INSERT INTO `stockmutation` (
                            `product_id`, `outlet_id`, `quantity`, `type`, 
                            `reference_type`, `reference_id`, `created_at`, `updated_at`
                        )
                        VALUES (
                            NEW.id, NEW.outlet_id, quantity_diff, "in", 
                            "adjustment", NULL, NOW(), NOW()
                        );
                    
                    -- Jika stok BERKURANG (stok baru < stok lama)
                    ELSEIF NEW.stok < OLD.stok THEN
                        INSERT INTO `stockmutation` (
                            `product_id`, `outlet_id`, `quantity`, `type`, 
                            `reference_type`, `reference_id`, `created_at`, `updated_at`
                        )
                        VALUES (
                            NEW.id, NEW.outlet_id, quantity_diff, "out", 
                            "adjustment", NULL, NOW(), NOW()
                        );
                    END IF;
                END IF;
            END
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS `after_product_update_handle_stock_adjustment`');
    }
};
