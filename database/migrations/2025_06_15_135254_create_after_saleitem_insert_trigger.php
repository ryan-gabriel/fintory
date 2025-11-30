<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::unprepared('
            CREATE OR REPLACE FUNCTION after_saleitem_insert_func()
            RETURNS trigger AS $$
            DECLARE 
                sale_outlet_id INT;
            BEGIN
                -- 1. Ambil outlet_id dari tabel sale
                SELECT outlet_id INTO sale_outlet_id
                FROM sale
                WHERE id = NEW.sale_id;

                -- 2. Kurangi stok product
                UPDATE product
                SET stok = stok - NEW.quantity
                WHERE id = NEW.product_id;

                -- 3. Tambahkan catatan stockmutation
                INSERT INTO stockmutation (
                    product_id, outlet_id, quantity, type,
                    reference_type, reference_id, created_at, updated_at
                )
                VALUES (
                    NEW.product_id, sale_outlet_id, NEW.quantity, \'out\',
                    \'sale\', NEW.sale_id, NOW(), NOW()
                );

                RETURN NEW;
            END;
            $$ LANGUAGE plpgsql;

            CREATE TRIGGER after_saleitem_insert
            AFTER INSERT ON saleitem
            FOR EACH ROW
            EXECUTE FUNCTION after_saleitem_insert_func();
        ');
    }

    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS after_saleitem_insert ON saleitem;');
        DB::unprepared('DROP FUNCTION IF EXISTS after_saleitem_insert_func();');
    }
};
