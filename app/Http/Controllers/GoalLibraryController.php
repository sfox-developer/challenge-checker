<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use App\Domain\Goal\Models\GoalLibrary;
use App\Domain\Goal\Models\Category;

class GoalLibraryController extends Controller
{
    /**
     * Display a listing of the user's goal library.
     */
    public function index(Request $request): View
    {
        $search = $request->get('search');
        $categoryId = $request->get('category');

        $query = auth()->user()->goalsLibrary()
            ->with('category')
            ->withCount(['challenges', 'habits']);

        if ($search) {
            $query->search($search);
        }

        if ($categoryId) {
            $query->byCategory($categoryId);
        }

        $goals = $query->orderBy('name')->get();

        // Get active categories from database
        $categories = Category::active()->ordered()->get();

        // Calculate stats
        $totalGoals = auth()->user()->goalsLibrary()->count();
        $usedInChallenges = auth()->user()->goalsLibrary()
            ->has('challenges')
            ->distinct()
            ->count();
        $usedInHabits = auth()->user()->goalsLibrary()
            ->has('habits')
            ->distinct()
            ->count();

        return view('dashboard.goals.index', compact(
            'goals', 
            'categories', 
            'search', 
            'categoryId',
            'totalGoals',
            'usedInChallenges',
            'usedInHabits'
        ));
    }

    /**
     * Display the specified goal.
     */
    public function show(GoalLibrary $goal): View
    {
        $this->authorize('view', $goal);

        // Load relationships with counts and eager loading
        $goal->load([
            'category',
            'challenges.completions',
            'habits.completions',
            'habits.statistics'
        ]);

        // Get challenges using this goal
        $challenges = $goal->challenges
            ->sortByDesc('created_at');

        // Get habits using this goal
        $habits = $goal->habits->sortByDesc('created_at');

        // Calculate statistics
        $stats = [
            'total_completions' => $this->getTotalCompletions($goal),
            'success_rate' => $this->getSuccessRate($challenges),
            'first_used' => $this->getFirstUsed($goal),
            'last_active' => $this->getLastActive($goal),
            'active_challenges' => $challenges->where('status', 'active')->count(),
            'active_habits' => $habits->where('is_archived', false)->count(),
        ];

        // Get active categories from database for edit modal
        $categories = Category::active()->ordered()->get();

        return view('dashboard.goals.show', compact('goal', 'challenges', 'habits', 'stats', 'categories'));
    }

    /**
     * Get total completions across all challenges and habits.
     */
    private function getTotalCompletions(GoalLibrary $goal): int
    {
        return $goal->completions()->whereNotNull('completed_at')->count();
    }

    /**
     * Get average success rate across active challenges.
     */
    private function getSuccessRate($challenges): float
    {
        $activeChallenges = $challenges->where('status', 'active');
        
        if ($activeChallenges->isEmpty()) {
            return 0;
        }

        $totalProgress = $activeChallenges->sum(function ($challenge) {
            return $challenge->getProgressPercentage();
        });

        return round($totalProgress / $activeChallenges->count(), 1);
    }

    /**
     * Get first usage date.
     */
    private function getFirstUsed(GoalLibrary $goal): ?string
    {
        $firstChallenge = $goal->challenges->min('created_at');
        $firstHabit = $goal->habits->min('created_at');

        $dates = array_filter([$firstChallenge, $firstHabit]);
        
        return $dates ? min($dates) : null;
    }

    /**
     * Get last activity date.
     */
    private function getLastActive(GoalLibrary $goal): ?string
    {
        $lastCompletion = $goal->completions()
            ->whereNotNull('completed_at')
            ->latest('completed_at')
            ->first();

        return $lastCompletion?->completed_at?->toDateString();
    }

    /**
     * Store a newly created goal in storage.
     */
    public function store(Request $request): RedirectResponse|JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
            'icon' => 'nullable|string|max:10',
        ]);

        $goal = GoalLibrary::create([
            'user_id' => auth()->id(),
            ...$validated
        ]);

        // Return JSON for AJAX requests
        if ($request->expectsJson()) {
            return response()->json([
                'id' => $goal->id,
                'name' => $goal->name,
                'icon' => $goal->icon,
                'description' => $goal->description,
                'category_id' => $goal->category_id,
                'created_at' => $goal->created_at,
            ]);
        }

        return redirect()->route('goals.show', $goal)
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
            'category_id' => 'nullable|exists:categories,id',
            'icon' => 'nullable|string|max:10',
        ]);

        $goal->update($validated);

        return redirect()->route('goals.show', $goal)
            ->with('success', 'Goal updated successfully!');
    }

    /**
     * Remove the specified goal from storage.
     */
    public function destroy(GoalLibrary $goal): RedirectResponse
    {
        $this->authorize('delete', $goal);

        // Check if goal is being used
        $usageCount = $goal->challenges()->count() + $goal->habits()->count();

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
