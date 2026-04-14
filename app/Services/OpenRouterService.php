<?php

namespace App\Services;

class OpenRouterService
{
    protected $credential;
    protected $selection;
    protected $apiKey;
    protected $baseUrl = 'https://openrouter.ai/api/v1';

    public function __construct($credential, $selection)
    {
        $this->credential = $credential;
        $this->selection = $selection;

        $apiKey = $credential->getDecryptedApiKey();
        if (!$apiKey) {
            throw new \Exception('Failed to decrypt Open Router API key');
        }

        $this->apiKey = $apiKey;
    }

    /**
     * Analyze an image and generate a detailed prompt
     */
    public function analyzeImage($imageBase64, $prompt)
    {
        try {
            // Use configured vision model from selection
            // Use format: google/gemma-4-31b-it:free (with colon before free)
            $visionModel = $this->selection->vision_model ?? 'google/gemma-4-31b-it:free';

            $payload = [
                'model' => $visionModel,
                'max_tokens' => 1024,
                'messages' => [
                    [
                        'role' => 'user',
                        'content' => [
                            [
                                'type' => 'image_url',
                                'image_url' => [
                                    'url' => 'data:image/jpeg;base64,' . $imageBase64,
                                ],
                            ],
                            [
                                'type' => 'text',
                                'text' => $prompt,
                            ]
                        ],
                    ]
                ],
            ];

            $response = $this->makeRequest($payload);

            if (isset($response['choices'][0]['message']['content'])) {
                return $response['choices'][0]['message']['content'];
            }

            throw new \Exception('Invalid response from Open Router');
        } catch (\Exception $e) {
            throw new \Exception('Open Router image analysis failed: ' . $e->getMessage());
        }
    }

    /**
     * Generate an image from a prompt
     */
    public function generateImage($prompt, $size = '1024x1024', $quality = 'default')
    {
        try {
            // Open Router doesn't have native image generation, so we'll use an image generation model
            $imageModel = $this->selection->image_model ?? 'openai/dall-e-3';

            // For now, we'll return a placeholder or use an alternative approach
            // You might want to use a different service for image generation
            throw new \Exception('Open Router does not support image generation. Please use OpenAI for image generation features.');
        } catch (\Exception $e) {
            throw new \Exception('Open Router image generation failed: ' . $e->getMessage());
        }
    }

    /**
     * Generate text completion
     */
    public function generateText($prompt, $maxTokens = 1024)
    {
        try {
            // Use valid Open Router model
            $textModel = $this->selection->text_model ?? 'mistral/mistral-7b-instruct';

            $payload = [
                'model' => $textModel,
                'max_tokens' => $maxTokens,
                'messages' => [
                    [
                        'role' => 'user',
                        'content' => $prompt,
                    ]
                ],
            ];

            $response = $this->makeRequest($payload);

            if (isset($response['choices'][0]['message']['content'])) {
                return $response['choices'][0]['message']['content'];
            }

            throw new \Exception('Invalid response from Open Router');
        } catch (\Exception $e) {
            throw new \Exception('Open Router text generation failed: ' . $e->getMessage());
        }
    }

    /**
     * Make HTTP request to Open Router API
     */
    protected function makeRequest($payload)
    {
        $ch = curl_init($this->baseUrl . '/chat/completions');

        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $this->apiKey,
            'Content-Type: application/json',
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode !== 200) {
            $errorData = json_decode($response, true);
            throw new \Exception('Open Router API error (HTTP ' . $httpCode . '): ' . 
                ($errorData['error']['message'] ?? 'Unknown error'));
        }

        return json_decode($response, true);
    }

    /**
     * Get the provider name
     */
    public function getProviderName()
    {
        return 'Open Router';
    }

    /**
     * Get the current model configuration
     */
    public function getModelConfig()
    {
        return [
            'vision_model' => $this->selection->vision_model ?? 'mistral/pixtral-12b',
            'image_model' => $this->selection->image_model ?? 'N/A (Use OpenAI)',
            'text_model' => $this->selection->text_model ?? 'mistral/mistral-7b-instruct',
        ];
    }
}
