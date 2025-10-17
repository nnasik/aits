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
        Schema::table('work_orders', function (Blueprint $table) {
            //
            $table->string('invoice_no')->nullable();
            $table->date('invoice_date')->nullable();
            $table->float('invoice_amount',10,2)->default('0.00');
            $table->date('invoice_due_date')->nullable();
            $table->string('payment_status')->default('Unpaid');
            $table->string('delivery_note_no')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('work_orders', function (Blueprint $table) {
            //
        });
    }
};