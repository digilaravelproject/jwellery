<?php

namespace App\Http\Controllers;

use App\Models\AIProvider;
use App\Models\AICredential;
use App\Models\AISelection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AIManagementController extends Controller
{
    /**
     * Display the AI management dashboard
     */
    public function index()
    {
        $providers = AIProvider::with(['credentials.selections'])->get();
        $selections = AISelection::with('credential.provider')->get();
        
        return view('admin.ai.index', [
            'providers' => $providers,
            'selections' => $selections,
        ]);
    }

    /**
     * Show AI credentials management page
     */
    public function credentials()
    {
        $providers = AIProvider::where('is_active', true)->get();
        $credentials = AICredential::with('provider')->get();

        return view('admin.ai.credentials', [
            'providers' => $providers,
            'credentials' => $credentials,
        ]);
    }

    /**
     * Store a new AI credential
     */
    public function storeCredential(Request $request)
    {
        $request->validate([
            'ai_provider_id' => 'required|exists:ai_providers,id',
            'api_key' => 'required|string|min:10',
        ]);

        try {
            $credential = new AICredential();
            $credential->ai_provider_id = $request->ai_provider_id;
            $credential->api_key = $request->api_key;
            $credential->status = 'inactive';
            $credential->save();

            return response()->json([
                'success' => true,
                'message' => 'AI Credential added successfully!',
                'credential' => $credential,
            ]);
        } catch (\Exception $e) {
            Log::error('Error storing AI credential', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error adding credential: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update AI credential
     */
    public function updateCredential(Request $request, $id)
    {
        $request->validate([
            'api_key' => 'required|string|min:10',
        ]);

        try {
            $credential = AICredential::findOrFail($id);
            $credential->api_key = $request->api_key;
            $credential->save();

            return response()->json([
                'success' => true,
                'message' => 'AI Credential updated successfully!',
                'credential' => $credential,
            ]);
        } catch (\Exception $e) {
            Log::error('Error updating AI credential', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error updating credential: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Delete AI credential
     */
    public function deleteCredential($id)
    {
        try {
            $credential = AICredential::findOrFail($id);
            $credential->delete();

            return response()->json([
                'success' => true,
                'message' => 'AI Credential deleted successfully!',
            ]);
        } catch (\Exception $e) {
            Log::error('Error deleting AI credential', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error deleting credential: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Test AI credential
     */
    public function testCredential($id)
    {
        try {
            $credential = AICredential::with('provider')->findOrFail($id);
            $provider = $credential->provider;
            $apiKey = $credential->getDecryptedApiKey();

            // Test based on provider
            $isValid = false;
            $message = '';

            if ($provider->name === 'openai') {
                $isValid = $this->testOpenAICredential($apiKey, $message);
            } elseif ($provider->name === 'openrouter') {
                $isValid = $this->testOpenRouterCredential($apiKey, $message);
            }

            if ($isValid) {
                $credential->update([
                    'status' => 'active',
                    'last_tested_at' => now(),
                    'last_error' => null,
                ]);
                $message = 'API Key tested successfully!';
            } else {
                $credential->update([
                    'status' => 'error',
                    'last_error' => $message,
                ]);
            }

            return response()->json([
                'success' => $isValid,
                'message' => $message,
                'credential' => $credential,
            ]);
        } catch (\Exception $e) {
            Log::error('Error testing AI credential', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error testing credential: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Show AI agent selection page
     */
    public function agents()
    {
        $activeCredentials = AICredential::where('status', 'active')->with('provider')->get();
        $selections = AISelection::with('credential.provider')->get();

        return view('admin.ai.agents', [
            'activeCredentials' => $activeCredentials,
            'selections' => $selections,
        ]);
    }

    /**
     * Save AI agent selection
     */
    public function saveAgentSelection(Request $request)
    {
        $request->validate([
            'feature' => 'required|string',
            'ai_credential_id' => 'required|exists:ai_credentials,id',
            'vision_model' => 'required|string|min:3',
            'image_model' => 'required|string|min:3',
            'text_model' => 'required|string|min:3',
        ]);

        try {
            // COMPLETELY DELETE all previous selections for this feature (cleanup old records)
            AISelection::where('feature', $request->feature)->delete();

            // Create fresh selection with new models
            $selection = AISelection::create([
                'feature' => $request->feature,
                'ai_credential_id' => $request->ai_credential_id,
                'vision_model' => $request->vision_model,
                'image_model' => $request->image_model,
                'text_model' => $request->text_model,
                'is_active' => true,
            ]);

            Log::info('AI Agent selection saved', [
                'feature' => $request->feature,
                'credential_id' => $request->ai_credential_id,
                'vision_model' => $request->vision_model,
                'image_model' => $request->image_model,
                'text_model' => $request->text_model,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'AI Agent selection saved successfully!',
                'selection' => $selection->load('credential.provider'),
            ]);
        } catch (\Exception $e) {
            Log::error('Error saving AI agent selection', [
                'error' => $e->getMessage(),
                'feature' => $request->feature,
                'credential_id' => $request->ai_credential_id,
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Error saving selection: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get active AI selection for a feature
     */
    public function getActiveSelection($feature)
    {
        try {
            $selection = AISelection::where('feature', $feature)
                ->where('is_active', true)
                ->with('credential.provider')
                ->first();

            if (!$selection) {
                return response()->json([
                    'success' => false,
                    'message' => 'No active AI selection for this feature',
                ], 404);
            }

            return response()->json([
                'success' => true,
                'selection' => $selection,
            ]);
        } catch (\Exception $e) {
            Log::error('Error getting active AI selection', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving selection: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Show AI prompts management page
     */
    public function prompts()
    {
        $prompts = \App\Models\AIPrompt::latest()->get();
        return view('admin.ai.prompts', compact('prompts'));
    }

    /**
     * Store new AI prompt
     */
    public function storePrompt(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'prompt_text' => 'required|string',
        ]);

        $prompt = \App\Models\AIPrompt::create($request->all());

        // Make active if it's the first
        if (\App\Models\AIPrompt::count() === 1) {
            $prompt->update(['is_active' => true]);
        }

        return redirect()->route('admin.ai.prompts')->with('success', 'Prompt created successfully.');
    }

    /**
     * Update AI prompt
     */
    public function updatePrompt(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'prompt_text' => 'required|string',
        ]);

        $prompt = \App\Models\AIPrompt::findOrFail($id);
        $prompt->update([
            'title' => $request->title,
            'prompt_text' => $request->prompt_text
        ]);

        return redirect()->route('admin.ai.prompts')->with('success', 'Prompt updated successfully.');
    }

    /**
     * Delete AI prompt
     */
    public function deletePrompt($id)
    {
        $prompt = \App\Models\AIPrompt::findOrFail($id);
        $prompt->delete();

        return redirect()->route('admin.ai.prompts')->with('success', 'Prompt deleted successfully.');
    }

    /**
     * Activate an AI prompt
     */
    public function activatePrompt($id)
    {
        \App\Models\AIPrompt::query()->update(['is_active' => false]);
        $prompt = \App\Models\AIPrompt::findOrFail($id);
        $prompt->update(['is_active' => true]);

        return redirect()->route('admin.ai.prompts')->with('success', 'Prompt activated successfully.');
    }

    /**
     * Test OpenAI API Key
     */
    private function testOpenAICredential($apiKey, &$message)
    {
        try {
            $ch = curl_init('https://api.openai.com/v1/models');
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Authorization: Bearer ' . $apiKey,
            ]);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($httpCode === 200) {
                return true;
            } else {
                $message = 'OpenAI API Key is invalid (HTTP ' . $httpCode . ')';
                return false;
            }
        } catch (\Exception $e) {
            $message = 'Error testing OpenAI credential: ' . $e->getMessage();
            return false;
        }
    }

    /**
     * Test Open Router API Key
     */
    private function testOpenRouterCredential($apiKey, &$message)
    {
        try {
            $ch = curl_init('https://openrouter.ai/api/v1/models');
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Authorization: Bearer ' . $apiKey,
            ]);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($httpCode === 200) {
                return true;
            } else {
                $message = 'Open Router API Key is invalid (HTTP ' . $httpCode . ')';
                return false;
            }
        } catch (\Exception $e) {
            $message = 'Error testing Open Router credential: ' . $e->getMessage();
            return false;
        }
    }
}
