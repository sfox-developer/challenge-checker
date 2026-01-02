<?php

namespace App\Domain\Habit\Services;

use App\Domain\Habit\Models\Habit;
use App\Domain\Goal\Models\GoalCompletion;
use App\Domain\Habit\Models\HabitStatistic;
use App\Domain\User\Models\User;
use Illuminate\Support\Facades\DB;

class HabitService
{
    public function __construct(
        private HabitStreakCalculator $streakCalculator
    ) {}

    /**
     * Quick toggle completion for a habit (no notes).
     */
    public function quickToggle(Habit $habit, User $user, ?string $date = null): ?GoalCompletion
    {
        $date = $date ?? now()->toDateString();

        // Check if already completed
        $existing = $habit->completions()
            ->where('user_id', $user->id)
            ->where('date', $date)
            ->first();

        if ($existing) {
            // Undo completion
            $this->deleteCompletion($existing);
            return null;
        }

        // Create completion
        return $this->completeHabit($habit, $user, $date);
    }

    /**
     * Complete a habit with optional notes and metadata.
     */
    public function completeHabit(
        Habit $habit,
        User $user,
        ?string $date = null,
        ?string $notes = null,
        ?int $durationMinutes = null,
        ?string $mood = null,
        ?array $metadata = null
    ): GoalCompletion {
        $date = $date ?? now()->toDateString();

        return DB::transaction(function () use ($habit, $user, $date, $notes, $durationMinutes, $mood, $metadata) {
            // Create or update completion
            $completion = $habit->completions()->updateOrCreate(
                [
                    'user_id' => $user->id,
                    'goal_id' => $habit->goal_id,
                    'date' => $date,
                ],
                [
                    'completed_at' => now(),
                    'notes' => $notes,
                    'duration_minutes' => $durationMinutes,
                    'mood' => $mood,
                    'metadata' => $metadata,
                ]
            );

            // Update statistics
            $this->updateStatistics($habit);

            return $completion;
        });
    }

    /**
     * Add or update notes for an existing completion.
     */
    public function updateCompletionNotes(
        GoalCompletion $completion,
        ?string $notes = null,
        ?int $durationMinutes = null,
        ?string $mood = null
    ): GoalCompletion {
        $completion->update([
            'notes' => $notes,
            'duration_minutes' => $durationMinutes,
            'mood' => $mood,
        ]);

        return $completion;
    }

    /**
     * Delete a completion and update statistics.
     */
    public function deleteCompletion(GoalCompletion $completion): void
    {
        DB::transaction(function () use ($completion) {
            // Find habits using this goal for this user
            $habits = Habit::where('goal_id', $completion->goal_id)
                ->where('user_id', $completion->user_id)
                ->get();
            
            $completion->delete();
            
            // Recalculate statistics for all affected habits
            foreach ($habits as $habit) {
                $this->updateStatistics($habit);
            }
        });
    }

    /**
     * Update habit statistics (streak, total completions, etc.).
     */
    public function updateStatistics(Habit $habit): void
    {
        $statistics = $habit->statistics ?: new HabitStatistic(['habit_id' => $habit->id]);

        // Calculate streak
        $streakData = $this->streakCalculator->calculateStreak($habit);
        
        $statistics->current_streak = $streakData['current_streak'];
        $statistics->best_streak = max($statistics->best_streak, $streakData['current_streak']);
        $statistics->total_completions = $habit->completions()->count();
        $statistics->last_completed_at = $habit->completions()->latest('completed_at')->first()?->completed_at;
        $statistics->streak_start_date = $streakData['streak_start_date'];

        $statistics->save();
    }

    /**
     * Check if this is a milestone completion (e.g., first time, or special count).
     */
    private function isMilestone(Habit $habit): bool
    {
        $totalCompletions = $habit->completions()->count();
        
        // Milestones: 1st, 10th, 50th, 100th, etc.
        $milestones = [1, 10, 50, 100, 250, 500, 1000];
        
        return in_array($totalCompletions, $milestones);
    }

    /**
     * Archive a habit (soft delete, keep data).
     */
    public function archiveHabit(Habit $habit): void
    {
        $habit->archive();
    }

    /**
     * Restore an archived habit.
     */
    public function restoreHabit(Habit $habit): void
    {
        $habit->restore();
    }

    /**
     * Get today's habits for a user.
     */
    public function getTodaysHabits(User $user)
    {
        return $user->habits()
            ->active()
            ->with(['goal', 'statistics', 'completions' => function ($query) {
                $query->where('date', now()->toDateString());
            }])
            ->get()
            ->filter(function ($habit) {
                return $habit->isDueToday() || $habit->isCompletedToday();
            });
    }

    /**
     * Get habit completion calendar data for a month.
     */
    public function getMonthlyCalendar(Habit $habit, int $year, int $month): array
    {
        $firstDay = \Carbon\Carbon::create($year, $month, 1);
        $daysInMonth = $firstDay->daysInMonth;
        $startDayOfWeek = $firstDay->dayOfWeekIso; // 1 = Monday, 7 = Sunday

        $startDate = $firstDay->format('Y-m-d');
        $endDate = $firstDay->copy()->endOfMonth()->format('Y-m-d');

        $completions = $habit->completions()
            ->whereBetween('date', [$startDate, $endDate])
            ->get()
            ->keyBy(function ($completion) {
                return $completion->date->format('Y-m-d');
            });

        $calendar = [];
        
        // Add empty cells for days before the first day of month
        for ($i = 1; $i < $startDayOfWeek; $i++) {
            $calendar[] = [
                'day' => null,
                'date' => null,
                'is_completed' => false,
                'is_today' => false,
                'completion' => null,
            ];
        }

        // Add days of the month
        $today = now()->format('Y-m-d');
        for ($day = 1; $day <= $daysInMonth; $day++) {
            $date = \Carbon\Carbon::create($year, $month, $day);
            $dateKey = $date->format('Y-m-d');
            
            $completion = $completions[$dateKey] ?? null;
            
            $calendar[] = [
                'date' => $dateKey,
                'day' => $day,
                'is_completed' => isset($completions[$dateKey]),
                'is_today' => $dateKey === $today,
                'completion' => $completion ? [
                    'completed_at' => $completion->completed_at?->toISOString(),
                    'notes' => $completion->notes,
                    'duration_minutes' => $completion->duration_minutes,
                    'mood' => $completion->mood,
                ] : null,
            ];
        }

        return $calendar;
    }
}
