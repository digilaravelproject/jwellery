<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\JewelryDesignController;
use App\Http\Controllers\AIManagementController;
use App\Http\Controllers\SelectionManagementController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\DebugAIController;

// Public routes
// Route::get('/', function () {
//     return view('welcome');
// });

// User Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/signup', [AuthController::class, 'showSignup'])->name('signup');
    Route::post('/signup', [AuthController::class, 'signup']);
    Route::get('/signin', [AuthController::class, 'showSignin'])->name('signin');
    Route::post('/signin', [AuthController::class, 'signin']);
});

// User Dashboard Routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Jewelry Design Routes
    Route::post('/design/generate', [JewelryDesignController::class, 'generateDesign'])->name('design.generate');
    Route::get('/design/designs', [JewelryDesignController::class, 'getDesigns'])->name('design.list');
    
    // Selections API for frontend
    Route::get('/selections/active', [SelectionManagementController::class, 'getActive'])->name('selections.active');
    
    // Debug AI Status (for troubleshooting)
    Route::get('/debug/ai-status', [DebugAIController::class, 'checkStatus'])->name('debug.ai.status');
    
    // FORCE FIX: Update Open Router models to correct values (bypass CSRF)
    Route::post('/debug/ai-fix-openrouter', function() {
        try {
            // Find Open Router credential
            $openRouterCred = \App\Models\AICredential::whereHas('provider', function($q) {
                $q->where('name', 'openrouter');
            })->where('status', 'active')->first();
            
            if (!$openRouterCred) {
                return response()->json([
                    'success' => false,
                    'message' => 'No active Open Router credential found. Please add one in Credentials section.',
                ], 400);
            }
            
            // Delete old selection
            \App\Models\AISelection::where('feature', 'design_generation')->delete();
            
            // Create new selection with CORRECT models that work on Open Router
            $selection = \App\Models\AISelection::create([
                'feature' => 'design_generation',
                'ai_credential_id' => $openRouterCred->id,
                'vision_model' => 'mistral/pixtral-12b',
                'image_model' => 'N/A (Use OpenAI for image generation)',
                'text_model' => 'mistral/mistral-7b-instruct',
                'is_active' => true,
            ]);
            
            return response()->json([
                'success' => true,
                'message' => '✓ FIXED! Open Router configured with working vision model: mistral/pixtral-12b',
                'selection' => $selection,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
            ], 500);
        }
    })->middleware('auth')->name('debug.ai.fix.openrouter');
});

// Admin Authentication Routes
Route::middleware('guest')->prefix('admin')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
    Route::post('/login', [AdminAuthController::class, 'login']);
});

// Admin Dashboard Routes
Route::middleware('admin')->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminAuthController::class, 'dashboard'])->name('admin.dashboard');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
    
    // User Management Routes
    Route::resource('users', AdminUserController::class, ['as' => 'admin']);

    // AI Management Routes
    Route::prefix('ai')->group(function () {
        Route::get('/', [AIManagementController::class, 'index'])->name('admin.ai.index');
        Route::get('/credentials', [AIManagementController::class, 'credentials'])->name('admin.ai.credentials');
        Route::post('/credentials', [AIManagementController::class, 'storeCredential'])->name('admin.ai.credentials.store');
        Route::put('/credentials/{id}', [AIManagementController::class, 'updateCredential'])->name('admin.ai.credentials.update');
        Route::delete('/credentials/{id}', [AIManagementController::class, 'deleteCredential'])->name('admin.ai.credentials.delete');
        Route::post('/credentials/{id}/test', [AIManagementController::class, 'testCredential'])->name('admin.ai.credentials.test');
        
        Route::get('/agents', [AIManagementController::class, 'agents'])->name('admin.ai.agents');
        Route::post('/agents/select', [AIManagementController::class, 'saveAgentSelection'])->name('admin.ai.agents.select');
        Route::get('/agents/{feature}/active', [AIManagementController::class, 'getActiveSelection'])->name('admin.ai.agents.active');

        Route::get('/prompts', [AIManagementController::class, 'prompts'])->name('admin.ai.prompts');
        Route::post('/prompts', [AIManagementController::class, 'storePrompt'])->name('admin.ai.prompts.store');
        Route::put('/prompts/{id}', [AIManagementController::class, 'updatePrompt'])->name('admin.ai.prompts.update');
        Route::delete('/prompts/{id}', [AIManagementController::class, 'deletePrompt'])->name('admin.ai.prompts.delete');
        Route::post('/prompts/{id}/activate', [AIManagementController::class, 'activatePrompt'])->name('admin.ai.prompts.activate');
    });

    // Design Selection Management Routes
    Route::resource('selections', SelectionManagementController::class, ['as' => 'admin']);
    Route::get('/selections-api/active', [SelectionManagementController::class, 'getActive'])->name('admin.selections.api.active');

    // Design Analytics Routes
    Route::resource('analytics', AnalyticsController::class, ['as' => 'admin', 'only' => ['index', 'show', 'destroy']]);
    Route::get('/analytics/statistics', [AnalyticsController::class, 'statistics'])->name('admin.analytics.statistics');
    
    // Debug routes for AI configuration (admin only)
    Route::get('/debug/ai-config', function() {
        $providers = \App\Models\AIProvider::all();
        $credentials = \App\Models\AICredential::with('provider')->get();
        $selections = \App\Models\AISelection::with('credential.provider')->get();
        
        return response()->json([
            'providers' => $providers,
            'credentials' => $credentials->map(function($c) {
                return [
                    'id' => $c->id,
                    'provider' => $c->provider->display_name,
                    'status' => $c->status,
                    'last_tested_at' => $c->last_tested_at,
                ];
            }),
            'selections' => $selections->map(function($s) {
                return [
                    'id' => $s->id,
                    'feature' => $s->feature,
                    'provider' => $s->credential->provider->display_name,
                    'vision_model' => $s->vision_model,
                    'image_model' => $s->image_model,
                    'text_model' => $s->text_model,
                    'is_active' => $s->is_active,
                ];
            }),
        ]);
    })->name('admin.debug.ai.config');
    
    // Quick fix: Clear and reset AI selections
    Route::post('/debug/ai-reset', function() {
        // Delete all selections
        \App\Models\AISelection::truncate();
        
        return response()->json([
            'success' => true,
            'message' => '✓ All AI selections cleared! Now go to Admin → AI Agents and save the configuration again.',
        ]);
    })->name('admin.debug.ai.reset');
    
    // FORCE FIX: Update Open Router models to correct values
    Route::post('/debug/ai-fix-openrouter', function() {
        try {
            // Find Open Router credential
            $openRouterCred = \App\Models\AICredential::whereHas('provider', function($q) {
                $q->where('name', 'openrouter');
            })->where('status', 'active')->first();
            
            if (!$openRouterCred) {
                return response()->json([
                    'success' => false,
                    'message' => 'No active Open Router credential found. Please add one in Credentials section.',
                ], 400);
            }
            
            // Delete old selection
            \App\Models\AISelection::where('feature', 'design_generation')->delete();
            
            // Create new selection with CORRECT models
            $selection = \App\Models\AISelection::create([
                'feature' => 'design_generation',
                'ai_credential_id' => $openRouterCred->id,
                'vision_model' => 'google/gemini-1.5-pro',
                'image_model' => 'N/A (Use OpenAI for image generation)',
                'text_model' => 'google/gemini-1.5-pro',
                'is_active' => true,
            ]);
            
            return response()->json([
                'success' => true,
                'message' => '✓ FIXED! Open Router now configured with correct models: google/gemini-1.5-pro',
                'selection' => $selection,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
            ], 500);
        }
    })->name('debug.ai.fix.openrouter');
});

