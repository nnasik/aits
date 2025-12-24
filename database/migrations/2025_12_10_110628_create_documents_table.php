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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('document_no');
            $table->enum('type', ['Policy','Procedure','Work Instruction','Form/Template/Record','Other'])->default('Other'); // Policy, Procedure, Work Instruction, Forms / Templates / Records, Other
            $table->string('category'); // 
            $table->string('sub_category'); // T&C
            $table->string('title')->unique();
            $table->integer('rev_no'); 
            $table->date('date');
            $table->longText('content')->nullable();
            $table->text('changes_summary')->nullable();

            $table->date('effective_date')->nullable();
            $table->date('expiry_date')->nullable();

            $table->string('department')->nullable(); // Sales, Operations, Accounts

            $table->string('access_level')->nullable(); // public, internal, department, confidential

            $table->json('related_documents')->nullable();
            
            // Prepared By
            $table->unsignedBigInteger('prepared_by');
            $table->date('prepared_date');

            // reviewed_by
            $table->unsignedBigInteger('reviewed_by')->nullable();
            $table->date('reviewed_on')->nullable();

            // Approved By
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->date('approval_date')->nullable();

            $table->string('status')->default('draft'); // draft, review, approved, archived, obsolete

            $table->timestamps();

            $table->unique(['document_no', 'rev_no']);
            $table->foreign('prepared_by')->references('id')->on('users');
            $table->foreign('reviewed_by')->references('id')->on('users');
            $table->foreign('approved_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
