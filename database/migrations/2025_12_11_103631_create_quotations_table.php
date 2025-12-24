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
        Schema::create('quotations', function (Blueprint $table) {
            $table->id();
            $table->string('reference');
            $table->integer('revision')->default(0);

            $table->date('date');
            $table->date('valid_until');

            $table->unsignedBigInteger('company_id');
            $table->string('company_name')->nullable();
            $table->text('company_address')->nullable();
            $table->string('company_phone')->nullable();
            $table->string('company_email')->nullable();
            $table->string('quote_for')->nullable();

            $table->decimal('sub_total', 15, 2)->default(0.00);
            $table->decimal('discount', 15, 2)->default(0.00);
            $table->decimal('vat', 15, 2)->default(0.00);
            $table->decimal('grand_total', 15, 2)->default(0.00);

            $table->unsignedBigInteger('prepared_by')->nullable();
            $table->string('prepared_by_name')->nullable();
            $table->string('prepared_by_email')->nullable();
            $table->string('prepared_by_contact')->nullable();

            $table->unsignedBigInteger('terms_and_conditions_id')->nullable();
            
            $table->text('note')->nullable();

            $table->text('text_1')->nullable();
            $table->text('text_2')->nullable();
            $table->text('text_3')->nullable();
            $table->text('text_4')->nullable();
            $table->text('text_5')->nullable();

            $table->enum('status', ['Draft', 'Finalized', 'Sent', 'Accepted', 'Rejected'])->default('Draft');

            $table->foreign('company_id')->references('id')->on('companies');
            $table->foreign('prepared_by')->references('id')->on('users');
            $table->foreign('terms_and_conditions_id')->references('id')->on('documents');
            $table->unique(['reference', 'revision']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotations');
    }
};
