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
            $table->foreignId('company_id')->constrained(
                table: 'companies', indexName: 'company_company_id'
            )->nullable();
            $table->string('name');
            $table->string('eid_no')->unique()->nullable();
            $table->string('designation')->nullable();
            $table->string('passport_no')->nullable();
            $table->string('dl_no')->nullable();
            $table->date('dob')->nullable();
            $table->date('dl_issued')->nullable();
            $table->date('dl_expiry')->nullable();
            $table->string('photo')->nullable();
            $table->string('live_photo')->nullable();
            $table->string('dl')->nullable();
            $table->string('eid')->nullable();
            $table->string('nationality')->nullable();
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
