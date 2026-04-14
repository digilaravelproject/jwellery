<?php

namespace App\Services;

use App\Models\AISelection;
use App\Models\AICredential;

class AIService
{
    /**
     * Get the active AI provider for a feature
     */
    public static function getActiveProvider($feature)
    {
        $selection = AISelection::where('feature', $feature)
            ->where('is_active', true)
            ->with('credential.provider')
            ->first();

        if (!$selection) {
            throw new \Exception("No active AI provider configured for feature: {$feature}");
        }

        return $selection;
    }

    /**
     * Get AI service instance based on provider
     */
    public static function getService($feature)
    {
        $selection = self::getActiveProvider($feature);
        $credential = $selection->credential;
        $provider = $credential->provider;

        if ($provider->name === 'openai') {
            return new OpenAIService($credential, $selection);
        } elseif ($provider->name === 'openrouter') {
            return new OpenRouterService($credential, $selection);
        }

        throw new \Exception("Unsupported AI provider: {$provider->name}");
    }

    /**
     * Get all active providers
     */
    public static function getActiveProviders()
    {
        return AISelection::where('is_active', true)
            ->with('credential.provider')
            ->groupBy('feature')
            ->get();
    }
}
