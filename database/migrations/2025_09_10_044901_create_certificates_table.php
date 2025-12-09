<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_id')->constrained(
                table: 'work_orders'
            );
            $table->foreignId('trainee_id')->constrained(
                table: 'trainees'
            );
            $table->string('candidate_name_in_certificate');
            $table->string('company_name_in_certificate');
            $table->string('company_location');
            $table->string('text_1')->nullable();
            $table->string('text_2')->nullable();
            $table->string('text_3')->nullable();
            $table->string('course_name_in_certificate');
            $table->string('eid_no')->nullable();
            $table->string('passport_no')->nullable();
            $table->date('date');
            $table->date('valid_unit');
            $table->string('live_photo');
            $table->string('hash')->nullable()->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificates');
    }
};
