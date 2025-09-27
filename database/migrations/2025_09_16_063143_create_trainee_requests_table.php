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
        Schema::create('trainee_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('training_request_id')->constrained(
                table: 'training_requests'
            )->onDelete('cascade'); // cascade deletes;
            
            $table->string('trainee_name')->nullable();
            $table->string('eid_no')->nullable();
            $table->string('profile_pic')->nullable();
            $table->string('company_name_in_certificate');
            $table->string('course_title_in_certificate');
            $table->string('is_certificate_hard_copy_needed')->default(true);
            $table->string('is_id_card_needed')->default(true);
            $table->date('certificate_date')->nullable();
            $table->string('eid_front_pic')->nullable();
            $table->string('eid_back_pic')->nullable();
            $table->string('visa_pic')->nullable();
            $table->string('passport_pic')->nullable();
            $table->string('dl_pic')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trainee_requests');
    }
};
