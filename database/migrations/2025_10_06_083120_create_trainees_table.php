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
        Schema::create('trainees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('training_id')->constrained();
            $table->foreignId('trainee_request_id')->constrained(
                table:'trainee_requests',
            )->nullable();
            $table->string('candidate_name_in_certificate')->nullable();
            $table->string('company_name_in_certificate')->nullable();
            $table->string('course_name_in_certificate')->nullable();
            $table->string('live_photo')->nullable();
            $table->string('eid_no')->nullable();
            $table->date('date')->nullable();
            $table->string('passport_no')->nullable();
            $table->string('dl_no')->nullable();
            $table->date('dl_issued')->nullable();
            $table->date('dl_expiry')->nullable();
            $table->string('signature')->nullable();
            $table->bool('attendance_confirmed')->nullable();
            $table->foreignId('attendance_confirmed_by')->constrained(
                table:'users',
            )->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trainees');
    }
};
