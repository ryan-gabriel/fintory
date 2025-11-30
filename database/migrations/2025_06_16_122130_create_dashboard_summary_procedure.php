<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::unprepared('DROP FUNCTION IF EXISTS GetDashboardSummary(INT, INT)');

        DB::unprepared("
            CREATE OR REPLACE FUNCTION GetDashboardSummary(
                p_lembaga_id INT,
                p_outlet_id INT
            )
            RETURNS TABLE (
                total_sales_today NUMERIC,
                total_transactions_today INT,
                active_products INT,
                low_stock_products INT
            )
            LANGUAGE plpgsql
            AS $$
            BEGIN
                RETURN QUERY
                SELECT
                    -- Total penjualan hari ini
                    COALESCE((
                        SELECT SUM(s.total)
                        FROM sale s
                        JOIN outlet o ON s.outlet_id = o.id
                        WHERE o.lembaga_id = p_lembaga_id
                        AND s.sale_date::date = CURRENT_DATE
                        AND (p_outlet_id IS NULL OR s.outlet_id = p_outlet_id)
                    ), 0) AS total_sales_today,

                    -- Total transaksi hari ini
                    COALESCE((
                        SELECT COUNT(s.id)
                        FROM sale s
                        JOIN outlet o ON s.outlet_id = o.id
                        WHERE o.lembaga_id = p_lembaga_id
                        AND s.sale_date::date = CURRENT_DATE
                        AND (p_outlet_id IS NULL OR s.outlet_id = p_outlet_id)
                    ), 0) AS total_transactions_today,

                    -- Produk aktif
                    COALESCE((
                        SELECT COUNT(p.id)
                        FROM product p
                        JOIN outlet o ON p.outlet_id = o.id
                        WHERE o.lembaga_id = p_lembaga_id
                        AND p.is_active = TRUE
                        AND (p_outlet_id IS NULL OR p.outlet_id = p_outlet_id)
                    ), 0) AS active_products,

                    -- Produk stok rendah
                    COALESCE((
                        SELECT COUNT(p.id)
                        FROM product p
                        JOIN outlet o ON p.outlet_id = o.id
                        WHERE o.lembaga_id = p_lembaga_id
                        AND p.is_active = TRUE
                        AND p.stok < 10
                        AND (p_outlet_id IS NULL OR p.outlet_id = p_outlet_id)
                    ), 0) AS low_stock_products;
            END;
            $$;
        ");
    }

    public function down(): void
    {
        DB::unprepared('DROP FUNCTION IF EXISTS GetDashboardSummary(INT, INT)');
    }
};
