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
        Schema::create('trainings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('work_order_id')->constrained(
                table: 'work_orders', indexName: 'trainings_work_order_id'
            );
            $table->foreignId('training_course_id')->constrained(
                table: 'training_courses', indexName: 'trainings_training_course_id'
            );
            $table->integer('quantity');
            $table->string('training_mode')->nullable();
            $table->date('scheduled_date')->nullable();
            $table->time('scheduled_time')->nullable();
            $table->string('remarks')->nullable();
            $table->longText('training_link')->nullable();
            $table->string('status')->default('Created');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trainings');
    }
};
