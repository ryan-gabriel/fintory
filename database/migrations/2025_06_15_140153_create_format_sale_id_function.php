<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Method ini akan membuat Stored Function di database.
     */
    public function up(): void
    {
        DB::unprepared('
            CREATE FUNCTION `FormatSaleID` (sale_id INT)
            RETURNS VARCHAR(15)
            DETERMINISTIC
            BEGIN
                RETURN CONCAT("TRX-", LPAD(sale_id, 5, "0"));
            END
        ');
    }

    /**
     * Reverse the migrations.
     * Method ini akan menghapus Stored Function dari database.
     */
    public function down(): void
    {
        DB::unprepared('DROP FUNCTION IF EXISTS `FormatSaleID`');
    }
};