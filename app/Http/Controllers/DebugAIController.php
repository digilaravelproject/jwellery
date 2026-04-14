<?php

namespace App\Http\Controllers;

use App\Models\AISelection;
use App\Models\AICredential;
use App\Models\AIProvider;

class DebugAIController extends Controller
{
    /**
     * Check AI Configuration Status
     */
    public function checkStatus()
    {
        try {
            // Check providers
            $providers = AIProvider::all();
            $credentials = AICredential::with('provider')->get();
            $selections = AISelection::with('credential.provider')->get();
            
            // Find active selection for design_generation
            $activeSelection = AISelection::where('feature', 'design_generation')
                ->where('is_active', true)
                ->with('credential.provider')
                ->first();

            return response()->json([
                'success' => true,
                'providers_count' => $providers->count(),
                'credentials_count' => $credentials->count(),
                'credentials' => $credentials->map(function($c) {
                    return [
                        'id' => $c->id,
                        'provider' => $c->provider->display_name ?? 'Unknown',
                        'status' => $c->status,
                        'is_default' => $c->is_default,
                    ];
                }),
                'selections_count' => $selections->count(),
                'design_generation_active' => $activeSelection ? true : false,
                'active_selection' => $activeSelection ? [
                    'provider' => $activeSelection->credential->provider->display_name,
                    'vision_model' => $activeSelection->vision_model,
                    'image_model' => $activeSelection->image_model,
                    'text_model' => $activeSelection->text_model,
                ] : null,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
