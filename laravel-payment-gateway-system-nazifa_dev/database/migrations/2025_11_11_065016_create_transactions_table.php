<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('transactions');

        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_id');
            $table->string('order_id');
            $table->enum('transaction_state', ['Completed', 'Pending', 'Refunded', 'Partial Refunded', 'Failed']);
            $table->decimal('gross', 15, 2);
            $table->decimal('net', 15, 2);
            $table->decimal('fee', 15, 2)->default(0);
            $table->decimal('refunded_amount', 15, 2)->default(0);
            $table->foreignId('pos_id')->constrained('pos')->onDelete('cascade');
            $table->foreignId('currency_id')->constrained('currencies')->onDelete('cascade');
            $table->foreignId('merchant_id')->constrained('merchants')->onDelete('cascade');
            $table->date('settlement_date')->nullable();
            // Replace timestamps() with explicit datetime columns
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};