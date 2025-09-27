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
                table: 'training_courses', indexName: 'trainings_request_training_course_id'
            );
            $table->string('course_title_in_certificate')->nullable();
            $table->string('company_name_in_certificate')->nullable();
            $table->integer('quantity');
            $table->string('training_mode');
            $table->date('requesting_date')->nullable();
            $table->time('requesting_time')->nullable();
            $table->boolean('is_zoom_link_required')->nullable();
            $table->string('zoom_link')->nullable();

            $table->string('remarks')->nullable();
            $table->foreignId('user_id')->constrained(
                table: 'users', indexName: 'training_request_user_id'
            );

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
