<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::unprepared('
            CREATE PROCEDURE `GetDashboardSummary`(
                IN p_outlet_id_param VARCHAR(10) -- Bisa "all" atau ID outlet
            )
            BEGIN
                -- Menyiapkan klausa WHERE dinamis untuk filter outlet
                SET @outlet_filter_sale = IF(p_outlet_id_param = "all", "1=1", CONCAT("outlet_id = ", p_outlet_id_param));
                SET @outlet_filter_product = IF(p_outlet_id_param = "all", "1=1", CONCAT("outlet_id = ", p_outlet_id_param));

                -- Menyiapkan query dinamis untuk mengambil semua data dalam satu baris
                SET @sql = CONCAT(
                    "SELECT ",
                    "(SELECT IFNULL(SUM(total), 0) FROM sale WHERE DATE(sale_date) = CURDATE() AND ", @outlet_filter_sale, ") AS total_sales_today, ",
                    "(SELECT COUNT(id) FROM sale WHERE DATE(sale_date) = CURDATE() AND ", @outlet_filter_sale, ") AS total_transactions_today, ",
                    "(SELECT COUNT(id) FROM product WHERE is_active = 1 AND ", @outlet_filter_product, ") AS active_products, ",
                    "(SELECT COUNT(id) FROM product WHERE stok < 10 AND is_active = 1 AND ", @outlet_filter_product, ") AS low_stock_products;"
                );

                -- Eksekusi query dinamis
                PREPARE stmt FROM @sql;
                EXECUTE stmt;
                DEALLOCATE PREPARE stmt;
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