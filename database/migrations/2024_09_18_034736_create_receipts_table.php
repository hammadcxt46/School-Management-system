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
        //this is the official ledger table
        Schema::create('receipts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('feepayment_id')->references('id')->on('fee_payments');
            $table->foreignId('student_id')->references('id')->on('students');
            $table->float('existing_balance', 8, 2)->default(0.00);
            $table->float('amount_paid', 8, 2)->default(0.00);
            $table->float('new_balance', 8, 2)->default(0.00);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('receipts');
    }
};
