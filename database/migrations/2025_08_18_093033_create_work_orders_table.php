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
        Schema::create('work_orders', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->foreignId('company_id')->constrained(
                table: 'companies', indexName: 'workorder_company_id'
            );
            $table->foreignId('issued_by')->constrained(
                table: 'users', indexName: 'workorder_created_user_id'
            );
            $table->foreignId('authorized_by')->constrained(
                table: 'users', indexName: 'workorder_authorized_user_id'
            );
            $table->foreignId('sales_by')->constrained(
                table: 'users', indexName: 'workorder_sales_user_id'
            );
            $table->string('status')->default('Open');
            $table->integer('qunatity')->nullable();
            $table->longText('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_orders');
    }
};
