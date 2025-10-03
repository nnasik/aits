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
        Schema::table('work_orders', function (Blueprint $table) {
            //
            $table->string('company_name_in_work_order')->nullable()->after('company_id');
            $table->string('priority')->nullable();
            $table->boolean('is_zoom_link_required')->nullable();
            $table->string('training_status')->default('Waiting');
            $table->string('certificate_status')->default('Waiting');
            $table->string('invoice_status')->default('Waiting');
            $table->string('delivery_note_status')->default('Waiting');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('work_orders', function (Blueprint $table) {
            //
             
        });
    }
};
