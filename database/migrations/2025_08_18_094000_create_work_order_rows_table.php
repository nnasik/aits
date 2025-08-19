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
        Schema::create('work_order_rows', function (Blueprint $table) {
            $table->id();
            $table->foreignId('worker_order_id')->constrained(
                table: 'work_orders', indexName: 'work_order_row_work_order_id'
            );
            $table->foreignId('training_course_id')->constrained(
                table: 'training_courses', indexName: 'work_order_row_training_course_id'
            );
            $table->integer('quantity');
            $table->string('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_order_rows');
    }
};
