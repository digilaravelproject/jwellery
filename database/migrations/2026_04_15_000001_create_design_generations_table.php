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
        Schema::create('design_generations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('sketch_path'); // Path to uploaded sketch
            $table->text('prompt'); // Full prompt used for generation
            $table->string('generated_design_path')->nullable(); // Path to generated design
            $table->text('design_specification')->nullable(); // Design description/text
            $table->string('design_type')->default('image'); // 'image' or 'specification'
            $table->string('ai_provider')->nullable(); // e.g., 'openai', 'openrouter'
            $table->timestamps();
            
            // Index for user queries
            $table->index('user_id');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('design_generations');
    }
};
