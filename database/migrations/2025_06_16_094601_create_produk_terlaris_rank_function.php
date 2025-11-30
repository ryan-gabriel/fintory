<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::unprepared('DROP VIEW IF EXISTS best_seller_products_monthly');

        DB::unprepared('
            CREATE OR REPLACE VIEW best_seller_products_monthly AS
            SELECT
                si.product_id,
                COALESCE(b.nama, \'Produk Tidak Diketahui\') AS product_name,
                o.lembaga_id AS lembaga_id,
                p.outlet_id AS outlet_id,
                SUM(si.quantity) AS total_qty,
                RANK() OVER (PARTITION BY o.lembaga_id ORDER BY SUM(si.quantity) DESC) AS rank_num
            FROM saleitem si
            JOIN sale s ON s.id = si.sale_id
            LEFT JOIN product p ON p.id = si.product_id
            LEFT JOIN barang b ON b.kode_barang = p.barang_id
            LEFT JOIN outlet o ON o.id = p.outlet_id
            WHERE s.sale_date BETWEEN date_trunc(\'month\', CURRENT_DATE)
                                  AND (date_trunc(\'month\', CURRENT_DATE) + INTERVAL \'1 month - 1 day\')
            GROUP BY si.product_id, b.nama, o.lembaga_id, p.outlet_id;
        ');
    }

    public function down(): void
    {
        DB::unprepared('DROP VIEW IF EXISTS best_seller_products_monthly');
    }
};
