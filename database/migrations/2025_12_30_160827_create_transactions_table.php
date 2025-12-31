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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_no')->unique(); // INV/YYMM/XXXX
            $table->date('date');
            $table->foreignId('customer_id')->constrained('customers');
            // Snapshot data customer (supaya data historis aman jika master berubah)
            $table->string('cust_code_snapshot')->nullable();
            $table->string('cust_name_snapshot')->nullable();
            $table->text('cust_address_snapshot')->nullable();
            $table->decimal('total_amount', 15, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
