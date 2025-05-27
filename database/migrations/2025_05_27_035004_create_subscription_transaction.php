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
        Schema::create('subscription_transaction', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lembaga_id');
            $table->date('payment_date');
            $table->decimal('amount', 14, 2);
            $table->enum('payment_method', ['credit_card', 'bank_transfer', 'ewallet', 'paypal'])->nullable();
            $table->enum('status', ['paid', 'pending', 'failed', 'refunded']);
            $table->string('reference_code')->unique();
            $table->text('notes')->nullable();

            $table->foreign('lembaga_id')->references('id')->on('lembaga')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscription_transaction');
    }
};
