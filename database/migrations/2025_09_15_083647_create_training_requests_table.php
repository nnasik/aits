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
        Schema::create('training_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_request_id')->constrained(
                table: 'job_requests'
            );
            $table->foreignId('training_course_id')->constrained(
                table: 'training_courses', indexName: 'trainings_training_course_id'
            );
            $table->string('course_title_in_certificate')->nullable();
            $table->integer('quantity');
            $table->string('training_mode')->nullable();
            $table->date('requesting_date')->nullable();
            $table->time('requesting_time')->nullable();
            $table->boolean('is_zoom_link_required')->nullable();

            $table->string('remarks')->nullable();
            $table->string('status')->default('Created');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('training_requests');

    }
};
