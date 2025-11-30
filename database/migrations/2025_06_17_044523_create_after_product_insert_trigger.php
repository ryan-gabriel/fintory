<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {

    public function up(): void
    {
        // Hapus trigger & function jika sudah ada
        DB::unprepared('DROP TRIGGER IF EXISTS after_product_insert_handle_stock ON product;');
        DB::unprepared('DROP FUNCTION IF EXISTS after_product_insert_handle_stock();');

        // Buat function PostgreSQL
        DB::unprepared("
            CREATE OR REPLACE FUNCTION after_product_insert_handle_stock()
            RETURNS TRIGGER
            LANGUAGE plpgsql
            AS $$
            BEGIN
                -- Jalankan hanya jika stok awal > 0
                IF NEW.stok > 0 THEN
                    INSERT INTO stockmutation (
                        product_id, outlet_id, quantity, type,
                        reference_type, reference_id, created_at, updated_at
                    )
                    VALUES (
                        NEW.id, NEW.outlet_id, NEW.stok, 'in',
                        'purchase', NULL, NOW(), NOW()
                    );
                END IF;

                RETURN NEW;
            END;
            $$;
        ");

        // Buat trigger PostgreSQL
        DB::unprepared("
            CREATE TRIGGER after_product_insert_handle_stock
            AFTER INSERT ON product
            FOR EACH ROW
            EXECUTE FUNCTION after_product_insert_handle_stock();
        ");
    }

    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS after_product_insert_handle_stock ON product;');
        DB::unprepared('DROP FUNCTION IF EXISTS after_product_insert_handle_stock();');
    }
};
