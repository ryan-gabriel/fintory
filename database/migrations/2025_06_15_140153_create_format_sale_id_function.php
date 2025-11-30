<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Hapus function jika sudah ada
        DB::unprepared('DROP FUNCTION IF EXISTS FormatSaleID(INT)');

        // Buat ulang dengan syntax PostgreSQL
        DB::unprepared('
            CREATE OR REPLACE FUNCTION FormatSaleID(sale_id INT)
            RETURNS VARCHAR(15)
            LANGUAGE plpgsql
            AS $$
            BEGIN
                RETURN \'TRX-\' || LPAD(sale_id::text, 5, \'0\');
            END;
            $$;
        ');
    }

    public function down(): void
    {
        DB::unprepared('DROP FUNCTION IF EXISTS FormatSaleID(INT)');
    }
};
