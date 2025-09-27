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
        Schema::table('trainings', function (Blueprint $table) {
            //
            $table->foreignId('training_request_id')->nullable()->constrained('training_requests')->onDelete('set null')->after('id');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('trainings', function (Blueprint $table) {
            //
            $table->dropForeign(['training_request_id']);
            $table->dropColumn('training_request_id');
        });
    }
};
