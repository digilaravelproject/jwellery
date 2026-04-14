<?php

namespace App\Services;

use OpenAI\Factory;

class OpenAIService
{
    protected $credential;
    protected $selection;
    protected $client;

    public function __construct($credential, $selection)
    {
        $this->credential = $credential;
        $this->selection = $selection;
        
        $apiKey = $credential->getDecryptedApiKey();
        if (!$apiKey) {
            throw new \Exception('Failed to decrypt OpenAI API key');
        }

        $this->client = (new Factory)->withApiKey($apiKey)->make();
    }

    /**
     * Analyze an image and generate a detailed prompt
     */
    public function analyzeImage($imageBase64, $prompt)
    {
        try {
            $visionModel = $this->selection->vision_model ?? 'gpt-4o';

            $response = $this->client->chat()->create([
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
            ]);

            return $response->choices[0]->message->content;
        } catch (\Exception $e) {
            throw new \Exception('OpenAI image analysis failed: ' . $e->getMessage());
        }
    }

    /**
     * Generate an image from a prompt
     */
    public function generateImage($prompt, $size = '1024x1024', $quality = 'hd')
    {
        try {
            $imageModel = $this->selection->image_model ?? 'dall-e-3';

            $response = $this->client->images()->create([
                'model' => $imageModel,
                'prompt' => $prompt,
                'n' => 1,
                'size' => $size,
                'quality' => $quality,
                'style' => 'natural',
            ]);

            return $response->data[0]->url;
        } catch (\Exception $e) {
            throw new \Exception('OpenAI image generation failed: ' . $e->getMessage());
        }
    }

    /**
     * Generate text completion
     */
    public function generateText($prompt, $maxTokens = 1024)
    {
        try {
            $textModel = $this->selection->text_model ?? 'gpt-4o';

            $response = $this->client->chat()->create([
                'model' => $textModel,
                'max_tokens' => $maxTokens,
                'messages' => [
                    [
                        'role' => 'user',
                        'content' => $prompt,
                    ]
                ],
            ]);

            return $response->choices[0]->message->content;
        } catch (\Exception $e) {
            throw new \Exception('OpenAI text generation failed: ' . $e->getMessage());
        }
    }

    /**
     * Get the provider name
     */
    public function getProviderName()
    {
        return 'OpenAI';
    }

    /**
     * Get the current model configuration
     */
    public function getModelConfig()
    {
        return [
            'vision_model' => $this->selection->vision_model ?? 'gpt-4o',
            'image_model' => $this->selection->image_model ?? 'dall-e-3',
            'text_model' => $this->selection->text_model ?? 'gpt-4o',
        ];
    }
}
