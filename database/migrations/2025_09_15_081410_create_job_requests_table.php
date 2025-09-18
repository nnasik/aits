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
        Schema::create('job_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained(
                table: 'companies', indexName: 'job_request_company_id'
            );
            $table->string('company_name_in_work_order');

            $table->string('training_mode')->nullable();

            $table->boolean('is_zoom_link_required')->default(false);
            
            $table->datetime('requested_on');
            $table->foreignId('request_by')->constrained(
                table: 'users', indexName: 'job_request_user_id'
            );

            $table->datetime('accepted_on')->nullable();
            $table->foreignId('accepted_by')->nullable()->constrained(
                table: 'users', indexName: 'job_accept_user_id'
            );

            $table->string('request_status')->default('Requested');
            $table->string('training_status')->nullable();
            $table->string('certificate_status')->nullable();
            $table->string('invoice_status')->nullable();
            $table->string('delivery_note_status')->nullable();

            $table->string('priority')->default('Normal');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_requests');
    }
};
