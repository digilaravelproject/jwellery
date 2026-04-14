<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Services\AIService;

class JewelryDesignController extends Controller
{
    protected $aiService;

    /**
     * Generate jewelry design from sketch using selected AI service
     */
    public function generateDesign(Request $request)
    {
        try {
            // First, validate the request
            $request->validate([
                'sketch' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120', // 5MB max
            ]);

            // Verify that AI is configured before proceeding
            try {
                $this->aiService = AIService::getService('design_generation');
            } catch (\Exception $aiError) {
                return response()->json([
                    'success' => false,
                    'message' => 'AI Service not configured. Please ask the administrator to set up an AI provider in the admin panel.',
                    'error_code' => 'AI_NOT_CONFIGURED',
                ], 503);
            }

            // Store the uploaded sketch
            $sketchPath = $request->file('sketch')->store('sketches', 'public');
            $sketchUrl = Storage::url($sketchPath);
            $sketchFullPath = Storage::disk('public')->path($sketchPath);

            // Read the sketch image as base64
            $imageData = base64_encode(file_get_contents($sketchFullPath));

            // Step 1: Use Vision model to analyze the sketch and generate a detailed prompt
            $designPrompt = $this->aiService->analyzeImage(
                $imageData,
                'You are a jewelry designer. Analyze this hand-drawn jewelry sketch and create a detailed, descriptive specification for a professional, luxury jewelry design. Include: jewelry type, style details, materials (gold, silver, diamonds, gems, etc.), design elements, dimensions, estimated craftsmanship time, and overall aesthetic. Format as a clear, professional jewelry design specification.'
            );

            // Get provider info
            $providerName = $this->aiService->getProviderName();

            // Prepare response with design specification
            // For Open Router or other non-image-generating providers, return the design specification
            $responseData = [
                'success' => true,
                'message' => 'Jewelry design specification generated successfully!',
                'sketch_url' => $sketchUrl,
                'design_specification' => str_replace(["\r", "\n", "\t"], " ", strip_tags($designPrompt)),
                'sketch_path' => $sketchPath,
                'ai_provider' => $providerName,
                'design_type' => 'specification', // Text-based design spec instead of image
            ];

            return response()->json($responseData, 200);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error: File must be a valid image (JPG, PNG, or GIF) and less than 5MB.',
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Jewelry Design Generation Error', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);
            
            // Provide user-friendly error message
            $errorMessage = 'Error generating design';
            
            // Check for specific error types and display the actual error message
            if (strpos($e->getMessage(), 'No active AI provider') !== false) {
                $errorMessage = 'AI service not configured. Ask administrator to setup.';
            } elseif (strpos($e->getMessage(), 'does not support') !== false) {
                $errorMessage = 'Current provider does not support this feature.';
            } elseif (strpos($e->getMessage(), 'Open Router API error') !== false) {
                // Display the actual Open Router API error (including rate limit errors)
                $errorMessage = $e->getMessage();
            } elseif (strpos($e->getMessage(), 'API') !== false) {
                // For other API errors, show the actual message
                $errorMessage = $e->getMessage();
            } else {
                $errorMessage .= ': ' . substr($e->getMessage(), 0, 100);
            }
            
            return response()->json([
                'success' => false,
                'message' => $errorMessage,
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
