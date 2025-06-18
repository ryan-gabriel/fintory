<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::unprepared('
            DROP PROCEDURE IF EXISTS `GetDashboardSummary`
        ');

        DB::unprepared('
            CREATE PROCEDURE `GetDashboardSummary`(
                IN p_lembaga_id INT,
                IN p_outlet_id INT UNSIGNED
            )
            BEGIN
                SELECT
                    -- Total Penjualan Hari Ini
                    (
                        SELECT IFNULL(SUM(s.total), 0)
                        FROM sale s
                        JOIN outlet o ON s.outlet_id = o.id
                        WHERE o.lembaga_id = p_lembaga_id
                        AND DATE(s.sale_date) = CURDATE()
                        AND (p_outlet_id IS NULL OR s.outlet_id = p_outlet_id)
                    ) AS total_sales_today,

                    -- Total Transaksi Hari Ini
                    (
                        SELECT COUNT(s.id)
                        FROM sale s
                        JOIN outlet o ON s.outlet_id = o.id
                        WHERE o.lembaga_id = p_lembaga_id
                        AND DATE(s.sale_date) = CURDATE()
                        AND (p_outlet_id IS NULL OR s.outlet_id = p_outlet_id)
                    ) AS total_transactions_today,

                    -- Total Produk Aktif
                    (
                        SELECT COUNT(p.id)
                        FROM product p
                        JOIN outlet o ON p.outlet_id = o.id
                        WHERE o.lembaga_id = p_lembaga_id
                        AND p.is_active = 1
                        AND (p_outlet_id IS NULL OR p.outlet_id = p_outlet_id)
                    ) AS active_products,

                    -- Produk dengan Stok Rendah
                    (
                        SELECT COUNT(p.id)
                        FROM product p
                        JOIN outlet o ON p.outlet_id = o.id
                        WHERE o.lembaga_id = p_lembaga_id
                        AND p.is_active = 1
                        AND p.stok < 10
                        AND (p_outlet_id IS NULL OR p.outlet_id = p_outlet_id)
                    ) AS low_stock_products;
            END
        ');

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS `GetDashboardSummary`');
    }
};