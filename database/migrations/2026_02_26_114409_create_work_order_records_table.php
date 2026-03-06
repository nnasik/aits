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
        Schema::create('work_order_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('work_order_id')->constrained(
                table: 'work_orders'
            );
            $table->integer('revision');
            $table->date('date');
            $table->foreignId('company_id')->constrained(
                table: 'companies'
            );
            $table->foreignId('issued_by')->constrained(
                table: 'users'
            );
            $table->foreignId('authorized_by')->constrained(
                table: 'users'
            );
            $table->foreignId('sales_by')->constrained(
                table: 'users'
            );
            $table->foreignId('job_request_id')->constrained(
                table: 'job_requests'
            );
            $table->string('training_mode')->nullable();
            $table->string('status')->default('Open');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_order_records');
    }
};
