<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Hapus function jika sudah ada (versi aman)
        DB::unprepared('DROP FUNCTION IF EXISTS public.formatsaleid(BIGINT)');

        // Buat ulang dengan standar PostgreSQL yang benar
        DB::unprepared("
            CREATE FUNCTION public.formatsaleid(sale_id BIGINT)
            RETURNS TEXT
            LANGUAGE plpgsql
            AS $$
            BEGIN
                RETURN 'TRX-' || LPAD(sale_id::text, 5, '0');
            END;
            $$;
        ");
    }

    public function down(): void
    {
        DB::unprepared('DROP FUNCTION IF EXISTS public.formatsaleid(BIGINT)');
    }
};
