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
        Schema::create('violations', function (Blueprint $table) {
            $table->id();
            $table->datetime('occurred_at')->nullable();
            $table->unsignedBigInteger('actor_user_id')->nullable();
            $table->unsignedBigInteger('reference_user_id')->nullable();

            $table->string('object_type');
            $table->unsignedBigInteger('object_id')->nullable();
            $table->string('object_ref')->nullable();

            $table->string('violation_type');
            $table->string('violation_subtype')->nullable();

            $table->longText('system_description')->nullable();
            $table->longText('user_reason')->nullable();

            $table->integer('severity')->default(3);
            $table->string('status')->default('open');
            $table->unsignedBigInteger('closed_by')->nullable();
            $table->longText('closing_notes')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('violations');
    }
};
