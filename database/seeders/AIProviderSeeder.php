<?php

namespace Database\Seeders;

use App\Models\AIProvider;
use Illuminate\Database\Seeder;

class AIProviderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // OpenAI Provider
        AIProvider::firstOrCreate(
            ['name' => 'openai'],
            [
                'display_name' => 'OpenAI',
                'description' => 'OpenAI API for image generation and analysis',
                'api_url' => 'https://api.openai.com/v1',
                'supported_models' => [
                    'gpt-4o',
                    'gpt-4-vision',
                    'dall-e-3',
                    'gpt-4-turbo',
                ],
                'is_active' => true,
            ]
        );

        // Open Router Provider
        AIProvider::firstOrCreate(
            ['name' => 'openrouter'],
            [
                'display_name' => 'Open Router',
                'description' => 'Open Router API for various AI models',
                'api_url' => 'https://openrouter.ai/api/v1',
                'supported_models' => [
                    'google/gemini-pro-vision',
                    'openai/gpt-4-turbo-preview',
                    'openai/gpt-3.5-turbo',
                    'anthropic/claude-3-opus',
                ],
                'is_active' => true,
            ]
        );
    }
}
