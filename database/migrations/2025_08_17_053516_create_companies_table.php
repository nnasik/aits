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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('description')->nullable();

            // Branding
            $table->string('logo')->nullable();
            $table->string('website')->nullable();

            // Address & Location
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('emirate')->nullable();
            $table->string('country')->nullable();
            
            // Contact
            $table->string('contact_person')->nullable();
            $table->string('contact_no')->nullable();
            $table->string('email')->nullable();

            // Company Info
            $table->string('registration_no')->nullable();   // Trade license / business reg no
            $table->string('tax_id')->nullable();            // VAT/TIN

            $table->foreignId('sales_by')->constrained(
                table: 'users', indexName: 'sales_person_user_id'
            )->nullable();

            // Settings
            $table->string('status')->default('active');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
