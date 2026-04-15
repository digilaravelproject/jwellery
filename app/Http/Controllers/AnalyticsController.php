<?php

namespace App\Http\Controllers;

use App\Models\DesignGeneration;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class AnalyticsController extends Controller
{
    /**
     * Display all design generations
     */
    public function index()
    {
        $designGenerations = DesignGeneration::with('user')
            ->latest()
            ->paginate(15);

        return view('admin.analytics.index', compact('designGenerations'));
    }

    /**
     * View a specific design generation
     */
    public function show($id)
    {
        $design = DesignGeneration::with('user')->findOrFail($id);
        return view('admin.analytics.show', compact('design'));
    }

    /**
     * Delete a design generation
     */
    public function destroy($id)
    {
        try {
            $design = DesignGeneration::findOrFail($id);

            // Delete files from storage if they exist
            if (!empty($design->sketch_path) && Storage::disk('public')->exists($design->sketch_path)) {
                Storage::disk('public')->delete($design->sketch_path);
            }

            if (!empty($design->generated_design_path) && Storage::disk('public')->exists($design->generated_design_path)) {
                Storage::disk('public')->delete($design->generated_design_path);
            }

            // Delete the record
            $design->delete();

            return redirect()->route('admin.analytics.index')
                ->with('success', 'Design generation record deleted successfully!');
        } catch (\Exception $e) {
            Log::error('Error deleting design generation', ['error' => $e->getMessage()]);
            return back()->with('error', 'Error deleting record: ' . $e->getMessage());
        }
    }

    /**
     * Get analytics statistics
     */
    public function statistics()
    {
        $totalGenerations = DesignGeneration::count();
        $totalUsers = User::whereHas('designGenerations')->count();
        $totalByProvider = DesignGeneration::selectRaw('ai_provider, COUNT(*) as count')
            ->groupBy('ai_provider')
            ->get();
        $totalByType = DesignGeneration::selectRaw('design_type, COUNT(*) as count')
            ->groupBy('design_type')
            ->get();

        return response()->json([
            'success' => true,
            'total_generations' => $totalGenerations,
            'total_users' => $totalUsers,
            'by_provider' => $totalByProvider,
            'by_type' => $totalByType,
        ]);
    }
}
