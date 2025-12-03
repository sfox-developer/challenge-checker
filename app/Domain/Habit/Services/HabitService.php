<?php

namespace App\Domain\Habit\Services;

use App\Domain\Habit\Models\Habit;
use App\Domain\Habit\Models\HabitCompletion;
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
    public function quickToggle(Habit $habit, User $user, ?string $date = null): ?HabitCompletion
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
    ): HabitCompletion {
        $date = $date ?? now()->toDateString();

        return DB::transaction(function () use ($habit, $user, $date, $notes, $durationMinutes, $mood, $metadata) {
            // Create or update completion
            $completion = $habit->completions()->updateOrCreate(
                [
                    'user_id' => $user->id,
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
        HabitCompletion $completion,
        ?string $notes = null,
        ?int $durationMinutes = null,
        ?string $mood = null
    ): HabitCompletion {
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
    public function deleteCompletion(HabitCompletion $completion): void
    {
        DB::transaction(function () use ($completion) {
            $habit = $completion->habit;
            $completion->delete();
            
            // Recalculate statistics
            $this->updateStatistics($habit);
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
        $startDate = sprintf('%04d-%02d-01', $year, $month);
        $endDate = date('Y-m-t', strtotime($startDate));

        $completions = $habit->completions()
            ->whereBetween('date', [$startDate, $endDate])
            ->get()
            ->keyBy(function ($completion) {
                return $completion->date->format('Y-m-d');
            });

        $calendar = [];
        $currentDate = new \DateTime($startDate);
        $lastDate = new \DateTime($endDate);

        while ($currentDate <= $lastDate) {
            $dateKey = $currentDate->format('Y-m-d');
            $calendar[$dateKey] = [
                'date' => $dateKey,
                'day' => (int) $currentDate->format('d'),
                'completed' => isset($completions[$dateKey]),
                'completion' => $completions[$dateKey] ?? null,
            ];
            $currentDate->modify('+1 day');
        }

        return $calendar;
    }
}
