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
        Schema::create('files', function (Blueprint $table) {


            $table->id();

            // System-generated name (stored filename)
            $table->string('name');

            // Original filename
            $table->string('original_name');

            // Optional description
            $table->string('description')->nullable();

            // Document type (Invoice, Delivery Note, etc.)
            $table->string('document_type')->nullable();

            // File path in storage
            $table->string('path');

            // MIME type
            $table->string('mime_type')->nullable();

            // File size in bytes
            $table->unsignedBigInteger('size')->nullable();

            // Polymorphic relation
            $table->morphs('fileable');

            // Who uploaded the file
            $table->foreignId('uploaded_by')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();

            // Cloud Archive fields
            $table->string('storage_disk')->default('local'); 
            $table->foreignId('archived_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('archived_at')->nullable();
            $table->string('remote_path')->nullable();
            $table->string('hash')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('files');
    }
};
