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
        Schema::create('ai_credentials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ai_provider_id')->constrained('ai_providers')->onDelete('cascade');
            $table->text('api_key')->nullable(); // Encrypted API key (use text for longer encrypted values)
            $table->json('additional_config')->nullable(); // JSON for any other config
            $table->string('status')->default('inactive'); // 'active', 'inactive', 'error'
            $table->string('last_error')->nullable();
            $table->timestamp('last_tested_at')->nullable();
            $table->boolean('is_default')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ai_credentials');
    }
};
