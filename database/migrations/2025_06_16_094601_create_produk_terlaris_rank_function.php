<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::unprepared('DROP VIEW IF EXISTS best_seller_products_monthly');
        DB::unprepared('
            CREATE OR REPLACE VIEW best_seller_products_monthly AS
            SELECT
                si.product_id,
                COALESCE(b.nama, "Produk Tidak Diketahui") AS product_name,
                o.lembaga_id AS lembaga_id,
                p.outlet_id AS outlet_id, -- ✅ Tambahkan outlet_id
                SUM(si.quantity) AS total_qty,
                RANK() OVER (PARTITION BY o.lembaga_id ORDER BY SUM(si.quantity) DESC) AS rank_num
            FROM saleitem si
            JOIN sale s ON s.id = si.sale_id
            LEFT JOIN product p ON p.id = si.product_id
            LEFT JOIN barang b ON b.kode_barang = p.barang_id
            LEFT JOIN outlet o ON o.id = p.outlet_id
            WHERE s.sale_date BETWEEN DATE_FORMAT(CURDATE(), "%Y-%m-01") AND LAST_DAY(CURDATE())
            GROUP BY si.product_id, b.nama, o.lembaga_id, p.outlet_id
        ');

    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP VIEW IF EXISTS best_seller_products_monthly');
    }
};
