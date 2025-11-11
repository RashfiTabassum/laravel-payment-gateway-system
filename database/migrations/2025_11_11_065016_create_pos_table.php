<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('pos');

        Schema::create('pos', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('bank_id')->constrained('banks')->onDelete('cascade');
            $table->foreignId('currency_id')->constrained('currencies')->onDelete('cascade');
            $table->tinyInteger('status')->default(1);
            $table->decimal('commission_percentage', 5, 2)->default(0);
            $table->decimal('commission_fixed', 10, 2)->default(0);
            $table->decimal('bank_fee', 10, 2)->default(0);
            $table->integer('settlement_day')->default(0);
            // Replace timestamps() with explicit datetime columns
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pos');
    }
};