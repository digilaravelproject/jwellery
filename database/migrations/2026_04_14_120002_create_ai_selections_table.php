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
        Schema::create('ai_selections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ai_credential_id')->constrained('ai_credentials')->onDelete('cascade');
            $table->string('feature'); // 'design_generation', 'chatbot', etc.
            $table->string('vision_model')->nullable(); // For image analysis models
            $table->string('image_model')->nullable(); // For image generation models
            $table->string('text_model')->nullable(); // For text/chat models
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            // Unique constraint: one active selection per feature
            $table->unique(['feature', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ai_selections');
    }
};
