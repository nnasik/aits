<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void{
        Schema::create('training_trainee', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trainee_id')->constrained()->onDelete('cascade');
            $table->foreignId('training_id')->constrained()->onDelete('cascade');
            $table->string('signature')->nullable();
            $table->string('candidate_name_in_certificate')->nullable();
            $table->string('company_name_in_certificate')->nullable();
            $table->string('training_name_in_certificate')->nullable();
            $table->string('certificate_no')->nullable();
            $table->string('photo')->nullable();
            $table->string('certificate_status')->nullable();
            $table->string('id_card_status')->nullable();
            $table->string('training_status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void{
        Schema::dropIfExists('training_trainee');
    }
};
