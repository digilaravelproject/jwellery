<?php

namespace App\Http\Controllers;

use App\Models\Selection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SelectionManagementController extends Controller
{
    /**
     * Display listing of all selections
     */
    public function index()
    {
        $selections = Selection::latest()->get();
        return view('admin.selections.index', compact('selections'));
    }

    /**
     * Show create form
     */
    public function create()
    {
        return view('admin.selections.create');
    }

    /**
     * Store a new selection
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255|unique:design_selections,title',
            'values' => 'required|array|min:1',
            'values.*' => 'required|string|max:255',
            'prompt_template' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        try {
            Selection::create([
                'title' => $request->title,
                'values' => $request->values,
                'prompt_template' => $request->prompt_template ?? 'Incorporate {value}',
                'is_active' => $request->boolean('is_active', true),
            ]);

            return redirect()->route('admin.selections.index')
                ->with('success', 'Selection created successfully!');
        } catch (\Exception $e) {
            Log::error('Error creating selection', ['error' => $e->getMessage()]);
            return back()->with('error', 'Error creating selection: ' . $e->getMessage());
        }
    }

    /**
     * Show edit form
     */
    public function edit($id)
    {
        $selection = Selection::findOrFail($id);
        return view('admin.selections.edit', compact('selection'));
    }

    /**
     * Update selection
     */
    public function update(Request $request, $id)
    {
        $selection = Selection::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255|unique:design_selections,title,' . $id,
            'values' => 'required|array|min:1',
            'values.*' => 'required|string|max:255',
            'prompt_template' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        try {
            $selection->update([
                'title' => $request->title,
                'values' => $request->values,
                'prompt_template' => $request->prompt_template ?? 'Incorporate {value}',
                'is_active' => $request->boolean('is_active', true),
            ]);

            return redirect()->route('admin.selections.index')
                ->with('success', 'Selection updated successfully!');
        } catch (\Exception $e) {
            Log::error('Error updating selection', ['error' => $e->getMessage()]);
            return back()->with('error', 'Error updating selection: ' . $e->getMessage());
        }
    }

    /**
     * Delete selection
     */
    public function destroy($id)
    {
        try {
            $selection = Selection::findOrFail($id);
            $selection->delete();

            return redirect()->route('admin.selections.index')
                ->with('success', 'Selection deleted successfully!');
        } catch (\Exception $e) {
            Log::error('Error deleting selection', ['error' => $e->getMessage()]);
            return back()->with('error', 'Error deleting selection: ' . $e->getMessage());
        }
    }

    /**
     * Get all active selections (API endpoint for frontend)
     */
    public function getActive()
    {
        try {
            $selections = Selection::where('is_active', true)->latest()->get();
            return response()->json([
                'success' => true,
                'selections' => $selections,
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching active selections', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error fetching selections: ' . $e->getMessage(),
            ], 500);
        }
    }
}
