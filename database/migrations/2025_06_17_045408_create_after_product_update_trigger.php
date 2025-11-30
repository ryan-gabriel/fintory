<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Hapus trigger & function sebelumnya jika ada
        DB::unprepared('DROP TRIGGER IF EXISTS after_product_update_handle_stock_adjustment ON product;');
        DB::unprepared('DROP FUNCTION IF EXISTS handle_stock_adjustment();');

        // Buat FUNCTION PostgreSQL
        DB::unprepared("
            CREATE OR REPLACE FUNCTION handle_stock_adjustment()
            RETURNS TRIGGER
            LANGUAGE plpgsql
            AS $$
            DECLARE
                quantity_diff INT;
            BEGIN
                -- Jalankan hanya jika stok berubah
                IF NEW.stok <> OLD.stok THEN
                    
                    quantity_diff := ABS(NEW.stok - OLD.stok);

                    -- Jika stok bertambah
                    IF NEW.stok > OLD.stok THEN
                        INSERT INTO stockmutation (
                            product_id, outlet_id, quantity, type,
                            reference_type, reference_id, created_at, updated_at
                        )
                        VALUES (
                            NEW.id, NEW.outlet_id, quantity_diff, 'in',
                            'adjustment', NULL, NOW(), NOW()
                        );

                    -- Jika stok berkurang
                    ELSE
                        INSERT INTO stockmutation (
                            product_id, outlet_id, quantity, type,
                            reference_type, reference_id, created_at, updated_at
                        )
                        VALUES (
                            NEW.id, NEW.outlet_id, quantity_diff, 'out',
                            'adjustment', NULL, NOW(), NOW()
                        );
                    END IF;

                END IF;

                RETURN NEW;
            END;
            $$;
        ");

        // Buat TRIGGER PostgreSQL
        DB::unprepared("
            CREATE TRIGGER after_product_update_handle_stock_adjustment
            AFTER UPDATE ON product
            FOR EACH ROW
            EXECUTE FUNCTION handle_stock_adjustment();
        ");
    }

    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS after_product_update_handle_stock_adjustment ON product;');
        DB::unprepared('DROP FUNCTION IF EXISTS handle_stock_adjustment();');
    }
};
