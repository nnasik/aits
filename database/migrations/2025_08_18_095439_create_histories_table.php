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
        Schema::create('histories', function (Blueprint $table) {
            $table->id();
            $table->morphs('subject'); // model + id (ex: JobRequest, Training, etc.)
            $table->foreignId('user_id')->constrained(
                table: 'users',
                indexName: 'history_user_id'
            );        
            $table->string('event'); // created, updated, deleted
            $table->json('changes')->nullable(); // what changed
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('histories');
    }
};
