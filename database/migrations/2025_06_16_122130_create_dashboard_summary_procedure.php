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
        // Hapus procedure lama jika ada untuk memastikan definisi baru yang diterapkan
        DB::unprepared('DROP PROCEDURE IF EXISTS `GetDashboardSummary`');

        // Buat procedure baru dengan referensi kolom yang jelas
        DB::unprepared('
            CREATE PROCEDURE `GetDashboardSummary`(
                IN p_lembaga_id INT,
                IN p_outlet_id_param VARCHAR(10)
            )
            BEGIN
                SELECT
                    -- Query Penjualan Hari Ini sebagai subquery
                    (SELECT IFNULL(SUM(total), 0) FROM sale s
                        JOIN outlet o ON s.outlet_id = o.id
                        WHERE o.lembaga_id = p_lembaga_id
                        AND DATE(s.sale_date) = CURDATE()
                        AND (p_outlet_id_param = "all" OR s.outlet_id = p_outlet_id_param)
                    ) AS total_sales_today,
                    
                    -- Query Transaksi Hari Ini sebagai subquery
                    (SELECT COUNT(s.id) FROM sale s -- Diperjelas menjadi s.id
                        JOIN outlet o ON s.outlet_id = o.id
                        WHERE o.lembaga_id = p_lembaga_id
                        AND DATE(s.sale_date) = CURDATE()
                        AND (p_outlet_id_param = "all" OR s.outlet_id = p_outlet_id_param)
                    ) AS total_transactions_today,
                    
                    -- Query Produk Aktif sebagai subquery
                    (SELECT COUNT(p.id) FROM product p -- Diperjelas menjadi p.id
                        JOIN outlet o ON p.outlet_id = o.id
                        WHERE o.lembaga_id = p_lembaga_id
                        AND p.is_active = 1
                        AND (p_outlet_id_param = "all" OR p.outlet_id = p_outlet_id_param)
                    ) AS active_products,
                    
                    -- Query Stok Kritis sebagai subquery
                    (SELECT COUNT(p.id) FROM product p -- Diperjelas menjadi p.id
                        JOIN outlet o ON p.outlet_id = o.id
                        WHERE o.lembaga_id = p_lembaga_id
                        AND p.stok < 10 AND p.is_active = 1
                        AND (p_outlet_id_param = "all" OR p.outlet_id = p_outlet_id_param)
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