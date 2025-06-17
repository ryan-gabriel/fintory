<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('outletbalance', function (Blueprint $table) {
            $table->unsignedBigInteger('outlet_id')->primary();
            $table->decimal('saldo', 14, 2)->default(0);
            $table->timestamp('last_updated')->useCurrent();
            $table->timestamps();

            // Foreign key dengan cascade delete
            $table->foreign('outlet_id')
                ->references('id')->on('outlet')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('outletbalance');
    }
};
