<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use App\Domain\Habit\Models\Habit;
use App\Domain\Habit\Models\HabitCompletion;
use App\Domain\Habit\Services\HabitService;
use App\Domain\Habit\Enums\FrequencyType;
use App\Domain\Goal\Models\GoalLibrary;
use App\Domain\Goal\Models\Category;

class HabitController extends Controller
{
    public function __construct(
        private HabitService $habitService
    ) {}

    /**
     * Display a listing of the user's habits.
     */
    public function index(Request $request): View
    {
        $filter = $request->get('filter', 'active');
        
        $query = auth()->user()->habits()
            ->with(['goal', 'statistics', 'completions' => function ($q) {
                $q->where('date', now()->toDateString());
            }]);

        if ($filter === 'active') {
            $query->active();
        } elseif ($filter === 'archived') {
            $query->archived();
        }

        $habits = $query->orderBy('created_at', 'desc')->get();

        // Group habits by frequency
        $groupedHabits = $habits->groupBy(function ($habit) {
            return $habit->frequency_type->label();
        });

        // Calculate statistics
        $totalHabits = auth()->user()->habits()->active()->count();
        $completedToday = $habits->filter(fn($h) => $h->isCompletedToday())->count();
        $currentStreaks = $habits->sum(fn($h) => $h->statistics?->current_streak ?? 0);

        // Calculate filter counts
        $allHabits = auth()->user()->habits()->get();
        $activeCount = $allHabits->filter(fn($h) => !$h->archived_at)->count();
        $archivedCount = $allHabits->filter(fn($h) => $h->archived_at)->count();
        $allCount = $allHabits->count();

        return view('habits.index', compact(
            'habits',
            'groupedHabits',
            'totalHabits',
            'completedToday',
            'currentStreaks',
            'filter',
            'activeCount',
            'archivedCount',
            'allCount'
        ));
    }

    /**
     * Show the form for creating a new habit.
     */
    public function create(): View
    {
        $goalsLibrary = auth()->user()->goalsLibrary()
            ->with('category')
            ->orderBy('name')
            ->get();

        $categories = Category::active()->ordered()->get();
        $frequencyTypes = FrequencyType::options();

        return view('habits.create', compact('goalsLibrary', 'categories', 'frequencyTypes'));
    }

    /**
     * Store a newly created habit in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'goal_library_id' => 'required_without:new_goal_name|exists:goals_library,id',
            'new_goal_name' => 'required_without:goal_library_id|string|max:255',
            'new_goal_description' => 'nullable|string',
            'new_goal_category_id' => 'nullable|exists:categories,id',
            'new_goal_icon' => 'nullable|string|max:10',
            'frequency_type' => 'required|in:daily,weekly,monthly,yearly',
            'frequency_count' => $request->input('frequency_type') === 'daily' 
                ? 'required|integer|in:1' 
                : 'required|integer|min:1|max:100',
            'weekly_days' => 'nullable|array',
            'weekly_days.*' => 'integer|min:1|max:7',
        ]);

        // Create new goal if needed
        if ($request->filled('new_goal_name')) {
            $goalLibrary = GoalLibrary::create([
                'user_id' => auth()->id(),
                'name' => $validated['new_goal_name'],
                'description' => $validated['new_goal_description'] ?? null,
                'category_id' => $validated['new_goal_category_id'] ?? null,
                'icon' => $validated['new_goal_icon'] ?? null,
            ]);
            $validated['goal_library_id'] = $goalLibrary->id;
        }

        // Prepare frequency config
        $frequencyConfig = null;
        if ($validated['frequency_type'] === 'weekly' && !empty($validated['weekly_days'])) {
            $frequencyConfig = ['days' => $validated['weekly_days']];
        }

        // Create habit
        $habit = Habit::create([
            'user_id' => auth()->id(),
            'goal_library_id' => $validated['goal_library_id'],
            'frequency_type' => $validated['frequency_type'],
            'frequency_count' => $validated['frequency_count'],
            'frequency_config' => $frequencyConfig,
            'is_active' => true,
        ]);

        // Initialize statistics
        $habit->statistics()->create([
            'current_streak' => 0,
            'best_streak' => 0,
            'total_completions' => 0,
        ]);

        return redirect()->route('habits.show', $habit)
            ->with('success', 'Habit created successfully!');
    }

    /**
     * Display the specified habit.
     */
    public function show(Habit $habit): View
    {
        $this->authorize('view', $habit);

        $habit->load(['goal', 'statistics']);

        // Get current month calendar
        $year = request('year', now()->year);
        $month = request('month', now()->month);
        $calendar = $this->habitService->getMonthlyCalendar($habit, $year, $month);

        // Calculate monthly stats
        $monthlyStats = $this->getMonthlyStats($habit, $year, $month);

        return view('habits.show', compact(
            'habit',
            'calendar',
            'monthlyStats',
            'year',
            'month'
        ));
    }

    /**
     * Show the form for editing the specified habit.
     */
    public function edit(Habit $habit): View
    {
        $this->authorize('update', $habit);

        $goalsLibrary = auth()->user()->goalsLibrary()
            ->orderBy('name')
            ->get();

        $frequencyTypes = FrequencyType::options();

        return view('habits.edit', compact('habit', 'goalsLibrary', 'frequencyTypes'));
    }

    /**
     * Update the specified habit in storage.
     */
    public function update(Request $request, Habit $habit): RedirectResponse
    {
        $this->authorize('update', $habit);

        $validated = $request->validate([
            'frequency_type' => 'required|in:daily,weekly,monthly,yearly',
            'frequency_count' => $request->input('frequency_type') === 'daily' 
                ? 'required|integer|in:1' 
                : 'required|integer|min:1|max:100',
            'is_active' => 'boolean',
        ]);

        $habit->update($validated);

        return redirect()->route('habits.show', $habit)
            ->with('success', 'Habit updated successfully!');
    }

    /**
     * Archive the specified habit.
     */
    public function destroy(Habit $habit): RedirectResponse
    {
        $this->authorize('delete', $habit);

        $this->habitService->archiveHabit($habit);

        return redirect()->route('habits.index')
            ->with('success', 'Habit archived successfully. Your completion history is preserved.');
    }

    /**
     * Archive the specified habit (alternative endpoint).
     */
    public function archive(Habit $habit): RedirectResponse
    {
        $this->authorize('delete', $habit);

        $this->habitService->archiveHabit($habit);

        return redirect()->route('habits.index')
            ->with('success', 'Habit archived successfully. Your completion history is preserved.');
    }

    /**
     * Restore an archived habit.
     */
    public function restore(Habit $habit): RedirectResponse
    {
        $this->authorize('update', $habit);

        $this->habitService->restoreHabit($habit);

        return redirect()->route('habits.show', $habit)
            ->with('success', 'Habit restored successfully!');
    }

    /**
     * Get today's habits for quick completion.
     */
    public function quickHabits(): View
    {
        $user = auth()->user();
        
        $todaysHabits = $user->habits()
            ->active()
            ->with(['goal', 'statistics'])
            ->get()
            ->filter(fn($habit) => $habit->isDueToday());

        return view('partials.quick-habits', compact('todaysHabits'));
    }

    /**
     * Quick toggle completion (AJAX).
     */
    public function toggle(Request $request, Habit $habit): JsonResponse
    {
        $this->authorize('update', $habit);

        $date = $request->get('date', now()->toDateString());
        $completion = $this->habitService->quickToggle($habit, auth()->user(), $date);

        $habit->refresh();
        $habit->load('statistics');

        return response()->json([
            'success' => true,
            'completed' => $completion !== null,
            'statistics' => [
                'current_streak' => $habit->statistics?->current_streak ?? 0,
                'total_completions' => $habit->statistics?->total_completions ?? 0,
            ],
            'progress' => [
                'text' => $habit->getProgressText(),
                'percentage' => $habit->getProgressPercentage(),
                'current' => $habit->getCompletionCountForPeriod(),
                'target' => $habit->frequency_count,
            ],
        ]);
    }

    /**
     * Complete habit with notes (AJAX).
     */
    public function complete(Request $request, Habit $habit): JsonResponse
    {
        $this->authorize('update', $habit);

        $validated = $request->validate([
            'date' => 'nullable|date',
            'notes' => 'nullable|string|max:1000',
            'duration_minutes' => 'nullable|integer|min:1|max:1440',
            'mood' => 'nullable|string|in:great,good,neutral,tired,struggling',
        ]);

        $completion = $this->habitService->completeHabit(
            $habit,
            auth()->user(),
            $validated['date'] ?? null,
            $validated['notes'] ?? null,
            $validated['duration_minutes'] ?? null,
            $validated['mood'] ?? null
        );

        $habit->refresh();
        $habit->load('statistics');

        return response()->json([
            'success' => true,
            'completion' => $completion,
            'statistics' => [
                'current_streak' => $habit->statistics?->current_streak ?? 0,
                'best_streak' => $habit->statistics?->best_streak ?? 0,
                'total_completions' => $habit->statistics?->total_completions ?? 0,
            ],
        ]);
    }

    /**
     * Show today's habits dashboard.
     */
    public function today(): View
    {
        $todaysHabits = $this->habitService->getTodaysHabits(auth()->user());

        $stats = [
            'total_due' => $todaysHabits->filter(fn($h) => $h->isDueToday())->count(),
            'completed' => $todaysHabits->filter(fn($h) => $h->isCompletedToday())->count(),
        ];

        return view('habits.today', compact('todaysHabits', 'stats'));
    }

    /**
     * Get monthly statistics helper.
     */
    private function getMonthlyStats(Habit $habit, int $year, int $month): array
    {
        $startDate = sprintf('%04d-%02d-01', $year, $month);
        $endDate = date('Y-m-t', strtotime($startDate));

        $completions = $habit->completions()
            ->whereBetween('date', [$startDate, $endDate])
            ->count();

        $daysInMonth = date('t', strtotime($startDate));
        $expectedCompletions = $this->calculateExpectedCompletions($habit, $daysInMonth);

        return [
            'completions' => $completions,
            'expected' => $expectedCompletions,
            'rate' => $expectedCompletions > 0 ? round(($completions / $expectedCompletions) * 100) : 0,
        ];
    }

    /**
     * Calculate expected completions based on frequency.
     */
    private function calculateExpectedCompletions(Habit $habit, int $daysInMonth): int
    {
        return match($habit->frequency_type) {
            FrequencyType::DAILY => $daysInMonth * $habit->frequency_count,
            FrequencyType::WEEKLY => ceil($daysInMonth / 7) * $habit->frequency_count,
            FrequencyType::MONTHLY => $habit->frequency_count,
            FrequencyType::YEARLY => 0, // Not relevant for monthly view
        };
    }
}
