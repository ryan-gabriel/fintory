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

        // Buat procedure baru dengan logika filter yang disempurnakan
        DB::unprepared('
            CREATE PROCEDURE `GetDashboardSummary`(
                IN p_lembaga_id INT,      -- Parameter untuk ID Lembaga (WAJIB)
                IN p_outlet_id_param VARCHAR(10) -- Bisa "all" atau ID Outlet
            )
            BEGIN
                -- Filter outlet, hanya berlaku jika bukan "all"
                SET @outlet_filter = IF(p_outlet_id_param = "all", "1=1", CONCAT("outlet_id = ", p_outlet_id_param));

                -- Query untuk Penjualan & Transaksi Hari Ini
                -- Data diambil dari tabel `sale` yang di-join dengan `outlet`
                -- untuk memastikan hanya data dari lembaga yang benar yang terambil.
                SELECT 
                    IFNULL(SUM(s.total), 0) AS total_sales_today,
                    COUNT(s.id) AS total_transactions_today
                FROM sale s
                JOIN outlet o ON s.outlet_id = o.id
                WHERE o.lembaga_id = p_lembaga_id
                  AND DATE(s.sale_date) = CURDATE()
                  AND (p_outlet_id_param = "all" OR s.outlet_id = p_outlet_id_param);

                -- Query untuk Produk Aktif & Stok Kritis
                -- Data diambil dari tabel `product` yang di-join dengan `outlet`
                SELECT 
                    COUNT(CASE WHEN p.is_active = 1 THEN p.id END) AS active_products,
                    COUNT(CASE WHEN p.stok < 10 AND p.is_active = 1 THEN p.id END) AS low_stock_products
                FROM product p
                JOIN outlet o ON p.outlet_id = o.id
                WHERE o.lembaga_id = p_lembaga_id
                  AND (p_outlet_id_param = "all" OR p.outlet_id = p_outlet_id_param);
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