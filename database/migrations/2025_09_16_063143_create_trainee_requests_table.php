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
            $table->string('company_name_in_certificate');
            $table->string('course_title');
            $table->string('is_certificate_hard_copy_needed')->default(true);
            $table->date('certificate_date')->nullable();
            $table->string('eid_front')->nullable();
            $table->string('eid_back')->nullable();
            $table->string('visa')->nullable();
            $table->string('passport')->nullable();
            $table->string('dl')->nullable();
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
