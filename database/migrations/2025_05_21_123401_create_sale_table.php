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
        Schema::create('sale', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('outlet_id');
            $table->string('customer_name', 100)->nullable();
            $table->date('sale_date');
            $table->decimal('total', 14, 2);
            $table->unsignedBigInteger('created_by')->nullable();

            // Tambahkan cascade delete pada outlet
            $table->foreign('outlet_id')
                ->references('id')->on('outlet')
                ->onDelete('cascade');

            // Optional: biarkan null jika user dihapus
            $table->foreign('created_by')
                ->references('id')->on('users')
                ->nullOnDelete();

            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sale');
    }
};
