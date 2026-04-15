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
        Schema::create('design_selections', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // e.g., "Metal Type", "Stone Type", "Design Style"
            $table->json('values'); // Array of values: {"values": ["Gold", "Silver", "Platinum"]}
            $table->string('prompt_template')->nullable(); // e.g., "The jewelry should be made of {value}"
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('design_selections');
    }
};
