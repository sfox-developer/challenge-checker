<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use App\Domain\Goal\Models\GoalLibrary;

class GoalLibraryController extends Controller
{
    /**
     * Display a listing of the user's goal library.
     */
    public function index(Request $request): View
    {
        $search = $request->get('search');
        $category = $request->get('category');

        $query = auth()->user()->goalsLibrary()
            ->withCount(['challengeGoals', 'habits']);

        if ($search) {
            $query->search($search);
        }

        if ($category) {
            $query->byCategory($category);
        }

        $goals = $query->orderBy('name')->get();

        // Get all unique categories
        $categories = auth()->user()->goalsLibrary()
            ->whereNotNull('category')
            ->distinct()
            ->pluck('category')
            ->sort();

        return view('goals.index', compact('goals', 'categories', 'search', 'category'));
    }

    /**
     * Store a newly created goal in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'nullable|string|max:255',
            'icon' => 'nullable|string|max:10',
        ]);

        $goal = GoalLibrary::create([
            'user_id' => auth()->id(),
            ...$validated
        ]);

        return redirect()->route('goals.index')
            ->with('success', 'Goal added to your library!');
    }

    /**
     * Update the specified goal in storage.
     */
    public function update(Request $request, GoalLibrary $goal): RedirectResponse
    {
        $this->authorize('update', $goal);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'nullable|string|max:255',
            'icon' => 'nullable|string|max:10',
        ]);

        $goal->update($validated);

        return redirect()->route('goals.index')
            ->with('success', 'Goal updated successfully!');
    }

    /**
     * Remove the specified goal from storage.
     */
    public function destroy(GoalLibrary $goal): RedirectResponse
    {
        $this->authorize('delete', $goal);

        // Check if goal is being used
        $usageCount = $goal->challengeGoals()->count() + $goal->habits()->count();

        if ($usageCount > 0) {
            return redirect()->route('goals.index')
                ->with('error', "Cannot delete goal. It's being used in {$usageCount} challenge(s) or habit(s).");
        }

        $goal->delete();

        return redirect()->route('goals.index')
            ->with('success', 'Goal removed from library!');
    }

    /**
     * Search goals (AJAX).
     */
    public function search(Request $request): JsonResponse
    {
        $search = $request->get('q', '');

        $goals = auth()->user()->goalsLibrary()
            ->when($search, fn($q) => $q->search($search))
            ->orderBy('name')
            ->limit(20)
            ->get(['id', 'name', 'description', 'category', 'icon']);

        return response()->json($goals);
    }
}
