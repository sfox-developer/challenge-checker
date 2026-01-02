<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use App\Domain\Goal\Models\Goal;
use App\Domain\Goal\Models\Category;

class GoalController extends Controller
{
    /**
     * Display a listing of the user's goal library.
     */
    public function index(Request $request): View
    {
        $search = $request->get('search');
        $categoryId = $request->get('category');

        $query = auth()->user()->goals()
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
        $totalGoals = auth()->user()->goals()->count();
        $usedInChallenges = auth()->user()->goals()
            ->has('challenges')
            ->distinct()
            ->count();
        $usedInHabits = auth()->user()->goals()
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
    public function show(Goal $goal): View
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

        // Get calendar data
        $year = request('year', now()->year);
        $month = request('month', now()->month);
        $calendar = $this->getMonthlyCalendar($goal, $year, $month);

        // Get deep analytics
        $analytics = [
            'consistency' => $this->getConsistencyScore($goal),
            'patterns' => $this->getTimePatterns($goal),
            'milestones' => $this->getMilestones($goal),
            'charts' => [
                'monthly_trend' => $this->getMonthlyTrendData($goal),
                'milestone_progress' => $this->getMilestoneProgressData($goal),
            ],
        ];

        return view('dashboard.goals.show', compact('goal', 'challenges', 'habits', 'stats', 'categories', 'calendar', 'year', 'month', 'analytics'));
    }

    /**
     * Get total completions across all challenges and habits.
     */
    private function getTotalCompletions(Goal $goal): int
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
    private function getFirstUsed(Goal $goal): ?string
    {
        $firstChallenge = $goal->challenges->min('created_at');
        $firstHabit = $goal->habits->min('created_at');

        $dates = array_filter([$firstChallenge, $firstHabit]);
        
        return $dates ? min($dates) : null;
    }

    /**
     * Get last activity date.
     */
    private function getLastActive(Goal $goal): ?string
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

        $goal = Goal::create([
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
    public function update(Request $request, Goal $goal): RedirectResponse
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
    public function destroy(Goal $goal): RedirectResponse
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

        $goals = auth()->user()->goals()
            ->when($search, fn($q) => $q->search($search))
            ->orderBy('name')
            ->limit(20)
            ->get(['id', 'name', 'description', 'category', 'icon']);

        return response()->json($goals);
    }

    /**
     * Get monthly calendar for goal completion tracking.
     */
    private function getMonthlyCalendar(Goal $goal, int $year, int $month): array
    {
        $firstDay = \Carbon\Carbon::create($year, $month, 1);
        $daysInMonth = $firstDay->daysInMonth;
        $startDayOfWeek = $firstDay->dayOfWeekIso; // 1 = Monday, 7 = Sunday

        $calendar = [];
        
        // Add empty cells for days before the first day of month
        for ($i = 1; $i < $startDayOfWeek; $i++) {
            $calendar[] = [
                'day' => null, 
                'is_completed' => false, 
                'is_today' => false,
                'completed_count' => 0,
                'date' => null,
                'sources' => []
            ];
        }

        // Add days of the month
        for ($day = 1; $day <= $daysInMonth; $day++) {
            $date = \Carbon\Carbon::create($year, $month, $day);
            $isToday = $date->isToday();
            
            // Get all completions for this goal on this day
            $completions = $goal->completions()
                ->where('date', $date->toDateString())
                ->whereNotNull('completed_at')
                ->get();
            
            $completedCount = $completions->count();
            
            // Completions are now unified (no source tracking)
            $sources = [];

            $calendar[] = [
                'day' => $day,
                'is_completed' => $completedCount > 0,
                'is_today' => $isToday,
                'completed_count' => $completedCount,
                'date' => $date->toDateString(),
                'sources' => $sources,
            ];
        }

        return $calendar;
    }

    /**
     * Get consistency score and streak analytics
     */
    private function getConsistencyScore(Goal $goal): array
    {
        $completions = $goal->completions()
            ->whereNotNull('completed_at')
            ->orderBy('date')
            ->pluck('date')
            ->map(fn($date) => $date->format('Y-m-d'))
            ->unique()
            ->values();
        
        if ($completions->isEmpty()) {
            return [
                'current_streak' => 0,
                'longest_streak' => 0,
                'average_per_week' => 0,
                'consistency_percentage' => 0,
                'total_active_days' => 0,
            ];
        }
        
        // Calculate streaks
        $currentStreak = 0;
        $longestStreak = 0;
        $tempStreak = 1;
        
        $today = now()->format('Y-m-d');
        $yesterday = now()->subDay()->format('Y-m-d');
        
        // Check if there's activity today or yesterday for current streak
        if ($completions->contains($today) || $completions->contains($yesterday)) {
            $checkDate = $completions->contains($today) ? now() : now()->subDay();
            
            foreach ($completions->reverse() as $date) {
                if ($date === $checkDate->format('Y-m-d')) {
                    $currentStreak++;
                    $checkDate->subDay();
                } else {
                    break;
                }
            }
        }
        
        // Calculate longest streak
        for ($i = 1; $i < $completions->count(); $i++) {
            $prevDate = \Carbon\Carbon::parse($completions[$i - 1]);
            $currDate = \Carbon\Carbon::parse($completions[$i]);
            
            if ($currDate->diffInDays($prevDate) === 1) {
                $tempStreak++;
                $longestStreak = max($longestStreak, $tempStreak);
            } else {
                $tempStreak = 1;
            }
        }
        $longestStreak = max($longestStreak, 1);
        
        // Calculate consistency
        $firstCompletion = \Carbon\Carbon::parse($completions->first());
        $daysSinceStart = max(1, $firstCompletion->diffInDays(now()) + 1);
        $activeDays = $completions->count();
        $consistencyPercentage = round(($activeDays / $daysSinceStart) * 100, 1);
        
        // Average per week
        $weeks = max(1, ceil($daysSinceStart / 7));
        $averagePerWeek = round($goal->completions()->whereNotNull('completed_at')->count() / $weeks, 1);
        
        return [
            'current_streak' => $currentStreak,
            'longest_streak' => $longestStreak,
            'average_per_week' => $averagePerWeek,
            'consistency_percentage' => $consistencyPercentage,
            'total_active_days' => $activeDays,
        ];
    }

    /**
     * Get time and pattern analysis
     */
    private function getTimePatterns(Goal $goal): array
    {
        $completions = $goal->completions()
            ->whereNotNull('completed_at')
            ->get();
        
        if ($completions->isEmpty()) {
            return [
                'best_day_of_week' => null,
                'day_of_week_distribution' => [],
                'monthly_distribution' => [],
            ];
        }
        
        // Day of week analysis
        $dayOfWeekCounts = $completions->groupBy(function ($completion) {
            return $completion->date->dayOfWeek;
        })->map->count()->sortDesc();
        
        $bestDayOfWeek = null;
        if ($dayOfWeekCounts->isNotEmpty()) {
            $bestDayIndex = $dayOfWeekCounts->keys()->first();
            $days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
            $bestDayOfWeek = $days[$bestDayIndex];
        }
        
        // Get full distribution
        $dayDistribution = [];
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        foreach ([1, 2, 3, 4, 5, 6, 0] as $index => $dayNum) {
            $dayDistribution[$days[$index]] = $dayOfWeekCounts->get($dayNum, 0);
        }
        
        // Monthly distribution (last 12 months)
        $monthlyDistribution = [];
        for ($i = 11; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $count = $completions->filter(function ($completion) use ($month) {
                return $completion->date->format('Y-m') === $month->format('Y-m');
            })->count();
            
            $monthlyDistribution[$month->format('M Y')] = $count;
        }
        
        return [
            'best_day_of_week' => $bestDayOfWeek,
            'day_of_week_distribution' => $dayDistribution,
            'monthly_distribution' => $monthlyDistribution,
        ];
    }

    /**
     * Get milestone progress with dynamic milestone generation
     */
    private function getMilestones(Goal $goal): array
    {
        $totalCompletions = $goal->completions()->whereNotNull('completed_at')->count();
        $firstCompletion = $goal->completions()
            ->whereNotNull('completed_at')
            ->orderBy('date')
            ->first();
        
        $daysSinceFirst = $firstCompletion 
            ? $firstCompletion->date->diffInDays(now()) + 1 
            : 0;
        
        // Dynamic milestone targets - always show achieved + next unachieved
        $baseMilestones = [10, 25, 50, 100, 250, 500, 1000, 2500, 5000, 10000, 25000, 50000, 100000];
        
        // Find all achieved and the next unachieved milestone
        $milestones = [];
        $foundUnachieved = false;
        
        foreach ($baseMilestones as $target) {
            $achieved = $totalCompletions >= $target;
            $progress = min(100, ($totalCompletions / $target) * 100);
            
            // Always include achieved milestones
            if ($achieved) {
                $milestones[] = [
                    'target' => $target,
                    'achieved' => true,
                    'progress' => 100,
                    'remaining' => 0,
                ];
            }
            // Include the first unachieved milestone (the goal to work towards)
            elseif (!$foundUnachieved) {
                $milestones[] = [
                    'target' => $target,
                    'achieved' => false,
                    'progress' => round($progress, 1),
                    'remaining' => $target - $totalCompletions,
                ];
                $foundUnachieved = true;
                break; // Only show one unachieved milestone
            }
        }
        
        // If no milestones exist yet (less than 10 completions), show the first one
        if (empty($milestones)) {
            $milestones[] = [
                'target' => 10,
                'achieved' => false,
                'progress' => round(($totalCompletions / 10) * 100, 1),
                'remaining' => 10 - $totalCompletions,
            ];
        }
        
        // Find next milestone (first unachieved)
        $nextMilestone = collect($milestones)->firstWhere('achieved', false);
        
        // Calculate projection for next milestone
        $projectedDate = null;
        if ($nextMilestone && $daysSinceFirst > 0) {
            $averagePerDay = $totalCompletions / $daysSinceFirst;
            if ($averagePerDay > 0) {
                $daysToNext = ceil($nextMilestone['remaining'] / $averagePerDay);
                $projectedDate = now()->addDays($daysToNext)->format('M d, Y');
            }
        }
        
        return [
            'milestones' => $milestones,
            'next_milestone' => $nextMilestone,
            'projected_date' => $projectedDate,
            'days_since_first' => $daysSinceFirst,
        ];
    }

    /**
     * Get monthly trend data for line chart (last 12 months)
     */
    private function getMonthlyTrendData(Goal $goal): array
    {
        $labels = [];
        $data = [];
        
        for ($i = 11; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $labels[] = $month->format('M Y');
            
            $count = $goal->completions()
                ->whereNotNull('completed_at')
                ->whereYear('date', $month->year)
                ->whereMonth('date', $month->month)
                ->count();
            
            $data[] = $count;
        }
        
        return [
            'labels' => $labels,
            'data' => $data,
        ];
    }

    /**
     * Get milestone progress data for doughnut chart
     */
    private function getMilestoneProgressData(Goal $goal): array
    {
        $totalCompletions = $goal->completions()->whereNotNull('completed_at')->count();
        
        // Find next unachieved milestone
        $milestoneTargets = [10, 25, 50, 100, 250, 500, 1000, 2500, 5000, 10000];
        $nextMilestone = $milestoneTargets[0]; // Default to first milestone
        
        foreach ($milestoneTargets as $target) {
            if ($totalCompletions < $target) {
                $nextMilestone = $target;
                break;
            }
        }
        
        // If all milestones achieved, use the next increment
        if ($totalCompletions >= 10000) {
            $nextMilestone = ceil($totalCompletions / 10000) * 10000 + 10000;
        }
        
        $completed = $totalCompletions;
        $remaining = max(1, $nextMilestone - $totalCompletions); // Ensure at least 1 to show the chart
        
        return [
            'labels' => ['Completed', 'Remaining'],
            'data' => [$completed, $remaining],
            'total' => $totalCompletions,
            'target' => $nextMilestone,
            'percentage' => $nextMilestone > 0 ? round(($totalCompletions / $nextMilestone) * 100, 1) : 0,
        ];
    }
}
