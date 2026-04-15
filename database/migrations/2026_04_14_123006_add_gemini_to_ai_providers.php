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
        \Illuminate\Support\Facades\DB::table('ai_providers')->updateOrInsert(
            ['name' => 'gemini'],
            [
                'display_name' => 'Google Gemini',
                'description' => 'Google Gemini API for image generation and analysis',
                'api_url' => 'https://generativelanguage.googleapis.com/v1beta',
                'supported_models' => json_encode([
                    'gemini-1.5-pro',
                    'gemini-1.5-flash',
                    'imagen-3.0-generate-002',
                ]),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        \Illuminate\Support\Facades\DB::table('ai_providers')->where('name', 'gemini')->delete();
    }
};
