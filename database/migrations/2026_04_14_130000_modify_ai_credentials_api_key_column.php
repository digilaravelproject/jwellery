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
        Schema::table('ai_credentials', function (Blueprint $table) {
            // Change api_key column from string to text
            $table->text('api_key')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ai_credentials', function (Blueprint $table) {
            // Revert back to string if needed
            $table->string('api_key')->nullable()->change();
        });
    }
};
