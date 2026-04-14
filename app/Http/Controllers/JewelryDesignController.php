<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OpenAI\Factory;
use Illuminate\Support\Facades\Storage;

class JewelryDesignController extends Controller
{
    protected $client;

    public function __construct()
    {
        $apiKey = env('OPENAI_API_KEY');
        if (!$apiKey) {
            throw new \Exception('OPENAI_API_KEY not configured in .env file');
        }
        $this->client = (new Factory)->withApiKey($apiKey)->make();
    }

    /**
     * Generate jewelry design from sketch using OpenAI Vision and DALL-E
     */
    public function generateDesign(Request $request)
    {
        try {
            $request->validate([
                'sketch' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120', // 5MB max
            ]);

            // Store the uploaded sketch
            $sketchPath = $request->file('sketch')->store('sketches', 'public');
            $sketchUrl = Storage::url($sketchPath);
            $sketchFullPath = Storage::disk('public')->path($sketchPath);

            // Read the sketch image as base64
            $imageData = base64_encode(file_get_contents($sketchFullPath));

            // Step 1: Use GPT-4o Vision to analyze the sketch and generate a detailed prompt
            $analysisResponse = $this->client->chat()->create([
                'model' => 'gpt-4o',
                'max_tokens' => 1024,
                'messages' => [
                    [
                        'role' => 'user',
                        'content' => [
                            [
                                'type' => 'image_url',
                                'image_url' => [
                                    'url' => 'data:image/jpeg;base64,' . $imageData,
                                ],
                            ],
                            [
                                'type' => 'text',
                                'text' => 'You are a jewelry designer. Analyze this hand-drawn jewelry sketch and create a detailed, descriptive prompt for generating a professional, luxury jewelry product photo. Include: jewelry type, style details, materials (gold, silver, diamonds, gems, etc.), design elements, and overall aesthetic. Format as a clear, detailed prompt for image generation. Do not include any commentary, just the prompt.'
                            ]
                        ],
                    ]
                ],
            ]);

            $designPrompt = $analysisResponse->choices[0]->message->content;

            // Step 2: Use DALL-E 3 to generate the actual jewelry image
            $imageResponse = $this->client->images()->create([
                'model' => 'dall-e-3',
                'prompt' => $designPrompt . ' Professional product photography, luxury jewelry, studio lighting, high quality, detailed, 8k',
                'n' => 1,
                'size' => '1024x1024',
                'quality' => 'hd',
                'style' => 'natural',
            ]);

            $generatedImageUrl = $imageResponse->data[0]->url;

            // Download and store the generated image
            $imageContent = file_get_contents($generatedImageUrl);
            $generatedImagePath = 'designs/generated_' . time() . '.png';
            Storage::disk('public')->put($generatedImagePath, $imageContent);
            $generatedImageStorageUrl = Storage::url($generatedImagePath);

            return response()->json([
                'success' => true,
                'message' => 'Jewelry design generated successfully!',
                'sketch_url' => $sketchUrl,
                'design_url' => $generatedImageStorageUrl,
                'design_prompt' => $designPrompt,
                'sketch_path' => $sketchPath,
                'design_path' => $generatedImagePath,
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error: ' . $e->getMessage(),
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Jewelry Design Generation Error', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Error generating design: ' . $e->getMessage(),
                'details' => env('APP_DEBUG') ? $e->getTraceAsString() : null,
            ], 500);
        }
    }

    /**
     * Get stored sketch and design images for a user
     */
    public function getDesigns(Request $request)
    {
        try {
            // Get sketches from storage
            $sketches = Storage::disk('public')->files('sketches');
            $designs = Storage::disk('public')->files('designs');

            $results = [];
            foreach ($designs as $design) {
                $results[] = [
                    'design_url' => Storage::url($design),
                    'design_path' => $design,
                ];
            }

            return response()->json([
                'success' => true,
                'designs' => $results,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving designs: ' . $e->getMessage(),
            ], 500);
        }
    }
}
