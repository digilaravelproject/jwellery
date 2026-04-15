<?php

namespace App\Services;

use App\Models\AISelection;
use App\Models\AICredential;
use Illuminate\Support\Facades\Http;

class GeminiService
{
    protected $credential;
    protected $selection;
    protected $apiKey;

    public function __construct($credential, $selection)
    {
        $this->credential = $credential;
        $this->selection = $selection;
        
        $this->apiKey = $credential->getDecryptedApiKey();
        if (!$this->apiKey) {
            throw new \Exception('Failed to retrieve Gemini API key');
        }
    }

    /**
     * Analyze an image and generate a detailed prompt
     */
    public function analyzeImage($imageBase64, $prompt)
    {
        try {
            $visionModel = $this->selection->vision_model ?? 'gemini-1.5-pro-latest';
            if ($visionModel === 'gemini-1.5-flash') $visionModel = 'gemini-1.5-flash-latest';
            if ($visionModel === 'gemini-1.5-pro') $visionModel = 'gemini-1.5-pro-latest';

            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post("https://generativelanguage.googleapis.com/v1beta/models/{$visionModel}:generateContent?key=" . $this->apiKey, [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $prompt],
                            [
                                'inline_data' => [
                                    'mime_type' => 'image/jpeg',
                                    'data' => $imageBase64
                                ]
                            ]
                        ]
                    ]
                ],
                'generationConfig' => [
                    'maxOutputTokens' => 1024,
                ]
            ]);

            if ($response->failed()) {
                throw new \Exception('API Error: ' . $response->body());
            }

            $data = $response->json();
            return $data['candidates'][0]['content']['parts'][0]['text'] ?? '';

        } catch (\Exception $e) {
            throw new \Exception('Gemini image analysis failed: ' . $e->getMessage());
        }
    }

    /**
     * Generate an image from a prompt
     */
    public function generateImage($prompt, $size = '1024x1024', $quality = 'hd')
    {
        try {
            $imageModel = $this->selection->image_model ?? 'imagen-3.0-generate-002'; // Imagen 3 model via Gemini API
            
            // Format for Imagen is different from Gemini text models
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post("https://generativelanguage.googleapis.com/v1beta/models/{$imageModel}:predict?key=" . $this->apiKey, [
                'instances' => [
                    [
                        'prompt' => $prompt
                    ]
                ],
                'parameters' => [
                    'sampleCount' => 1,
                    // aspect ratio can be provided here if needed, defaults are typically 1:1
                ]
            ]);

            if ($response->failed()) {
                throw new \Exception('API Error: ' . $response->body());
            }

            $data = $response->json();
            
            // Returns base64 payload
            $base64 = $data['predictions'][0]['bytesBase64Encoded'] ?? null;
            if (!$base64) {
                throw new \Exception('No image data returned from Imagen model');
            }

            return 'data:image/jpeg;base64,' . $base64;
        } catch (\Exception $e) {
            throw new \Exception('Gemini image generation failed: ' . $e->getMessage());
        }
    }

    /**
     * Generate text completion
     */
    public function generateText($prompt, $maxTokens = 1024)
    {
        try {
            $textModel = $this->selection->text_model ?? 'gemini-1.5-pro-latest';
            if ($textModel === 'gemini-1.5-flash') $textModel = 'gemini-1.5-flash-latest';
            if ($textModel === 'gemini-1.5-pro') $textModel = 'gemini-1.5-pro-latest';

            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post("https://generativelanguage.googleapis.com/v1beta/models/{$textModel}:generateContent?key=" . $this->apiKey, [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $prompt]
                        ]
                    ]
                ],
                'generationConfig' => [
                    'maxOutputTokens' => $maxTokens,
                ]
            ]);

            if ($response->failed()) {
                throw new \Exception('API Error: ' . $response->body());
            }

            $data = $response->json();
            return $data['candidates'][0]['content']['parts'][0]['text'] ?? '';
            
        } catch (\Exception $e) {
            throw new \Exception('Gemini text generation failed: ' . $e->getMessage());
        }
    }

    /**
     * Get the provider name
     */
    public function getProviderName()
    {
        return 'Google Gemini';
    }

    /**
     * Get the current model configuration
     */
    public function getModelConfig()
    {
        return [
            'vision_model' => $this->selection->vision_model ?? 'gemini-1.5-pro',
            'image_model' => $this->selection->image_model ?? 'imagen-3.0-generate-002',
            'text_model' => $this->selection->text_model ?? 'gemini-1.5-pro',
        ];
    }
}
