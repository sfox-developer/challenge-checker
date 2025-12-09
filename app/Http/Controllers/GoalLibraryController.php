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
            ->withCount(['challengeGoals', 'habits']);

        if ($search) {
            $query->search($search);
        }

        if ($categoryId) {
            $query->byCategory($categoryId);
        }

        $goals = $query->orderBy('name')->get();

        // Get active categories from database
        $categories = Category::active()->ordered()->get();

        return view('dashboard.goals.index', compact('goals', 'categories', 'search', 'categoryId'));
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
            'challengeGoals.challenge' => function ($query) {
                $query->with('dailyProgress');
            },
            'habits.completions',
            'habits.statistics'
        ]);

        // Get challenges using this goal
        $challenges = $goal->challengeGoals
            ->map(fn($challengeGoal) => $challengeGoal->challenge)
            ->filter()
            ->unique('id')
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
        $challengeCompletions = $goal->challengeGoals->sum(function ($challengeGoal) {
            return $challengeGoal->is_completed ? 1 : 0;
        });

        $habitCompletions = $goal->habits->sum(function ($habit) {
            return $habit->completions->count();
        });

        return $challengeCompletions + $habitCompletions;
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
        $firstChallenge = $goal->challengeGoals->min('created_at');
        $firstHabit = $goal->habits->min('created_at');

        $dates = array_filter([$firstChallenge, $firstHabit]);
        
        return $dates ? min($dates) : null;
    }

    /**
     * Get last activity date.
     */
    private function getLastActive(GoalLibrary $goal): ?string
    {
        $lastChallengeActivity = $goal->challengeGoals
            ->flatMap(fn($cg) => $cg->challenge?->dailyProgress ?? [])
            ->max('date');

        $lastHabitActivity = $goal->habits
            ->flatMap(fn($h) => $h->completions)
            ->max('completed_at');

        $dates = array_filter([$lastChallengeActivity, $lastHabitActivity]);
        
        return $dates ? max($dates) : null;
    }

    /**
     * Store a newly created goal in storage.
     */
    public function store(Request $request): RedirectResponse
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
