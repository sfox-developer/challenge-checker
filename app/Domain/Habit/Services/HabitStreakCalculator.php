<?php

namespace App\Domain\Habit\Services;

use App\Domain\Habit\Models\Habit;
use App\Domain\Habit\Enums\FrequencyType;
use Illuminate\Support\Collection;

class HabitStreakCalculator
{
    /**
     * Calculate the current streak for a habit.
     */
    public function calculateStreak(Habit $habit): array
    {
        $completions = $habit->completions()
            ->orderBy('date', 'desc')
            ->get();

        if ($completions->isEmpty()) {
            return [
                'current_streak' => 0,
                'streak_start_date' => null,
            ];
        }

        return match($habit->frequency_type) {
            FrequencyType::DAILY => $this->calculateDailyStreak($completions),
            FrequencyType::WEEKLY => $this->calculateWeeklyStreak($completions),
            FrequencyType::MONTHLY => $this->calculateMonthlyStreak($completions),
            FrequencyType::YEARLY => $this->calculateYearlyStreak($completions),
        };
    }

    /**
     * Calculate streak for daily habits.
     */
    private function calculateDailyStreak(Collection $completions): array
    {
        $streak = 0;
        $today = now()->startOfDay();
        $checkDate = clone $today;
        $streakStartDate = null;

        // Check if completed today or yesterday (allow grace period)
        $lastCompletion = $completions->first();
        $daysSinceLastCompletion = $today->diffInDays($lastCompletion->date);

        if ($daysSinceLastCompletion > 1) {
            // Streak is broken
            return [
                'current_streak' => 0,
                'streak_start_date' => null,
            ];
        }

        // Count consecutive days
        foreach ($completions as $completion) {
            $completionDate = $completion->date->startOfDay();
            
            if ($checkDate->equalTo($completionDate) || $checkDate->subDay()->equalTo($completionDate)) {
                $streak++;
                $streakStartDate = $completionDate;
                $checkDate = clone $completionDate;
            } else {
                break;
            }
        }

        return [
            'current_streak' => $streak,
            'streak_start_date' => $streakStartDate,
        ];
    }

    /**
     * Calculate streak for weekly habits.
     */
    private function calculateWeeklyStreak(Collection $completions): array
    {
        $streak = 0;
        $currentWeekStart = now()->startOfWeek();
        $streakStartDate = null;

        // Group completions by week
        $weeklyCompletions = $completions->groupBy(function ($completion) {
            return $completion->date->startOfWeek()->format('Y-m-d');
        });

        // Check consecutive weeks
        $checkWeekStart = clone $currentWeekStart;

        foreach ($weeklyCompletions as $weekStart => $weekCompletions) {
            $weekStartDate = new \DateTime($weekStart);
            
            if ($checkWeekStart->format('Y-m-d') === $weekStart) {
                $streak++;
                $streakStartDate = $weekStartDate;
                $checkWeekStart->subWeek();
            } else {
                break;
            }
        }

        return [
            'current_streak' => $streak,
            'streak_start_date' => $streakStartDate,
        ];
    }

    /**
     * Calculate streak for monthly habits.
     */
    private function calculateMonthlyStreak(Collection $completions): array
    {
        $streak = 0;
        $currentMonthStart = now()->startOfMonth();
        $streakStartDate = null;

        // Group completions by month
        $monthlyCompletions = $completions->groupBy(function ($completion) {
            return $completion->date->format('Y-m');
        });

        // Check consecutive months
        $checkMonth = clone $currentMonthStart;

        foreach ($monthlyCompletions as $month => $monthCompletions) {
            if ($checkMonth->format('Y-m') === $month) {
                $streak++;
                $streakStartDate = $monthCompletions->last()->date;
                $checkMonth->subMonth();
            } else {
                break;
            }
        }

        return [
            'current_streak' => $streak,
            'streak_start_date' => $streakStartDate,
        ];
    }

    /**
     * Calculate streak for yearly habits.
     */
    private function calculateYearlyStreak(Collection $completions): array
    {
        $streak = 0;
        $currentYear = now()->year;
        $streakStartDate = null;

        // Group completions by year
        $yearlyCompletions = $completions->groupBy(function ($completion) {
            return $completion->date->year;
        });

        // Check consecutive years
        $checkYear = $currentYear;

        foreach ($yearlyCompletions as $year => $yearCompletions) {
            if ($checkYear === (int) $year) {
                $streak++;
                $streakStartDate = $yearCompletions->last()->date;
                $checkYear--;
            } else {
                break;
            }
        }

        return [
            'current_streak' => $streak,
            'streak_start_date' => $streakStartDate,
        ];
    }

    /**
     * Predict when the streak will break if not completed.
     */
    public function getStreakExpiryDate(Habit $habit): ?\DateTime
    {
        if (!$habit->statistics || $habit->statistics->current_streak === 0) {
            return null;
        }

        $lastCompletion = $habit->completions()->latest('date')->first();
        
        if (!$lastCompletion) {
            return null;
        }

        $expiryDate = clone $lastCompletion->date;

        return match($habit->frequency_type) {
            FrequencyType::DAILY => $expiryDate->addDays(2), // Grace period of 1 day
            FrequencyType::WEEKLY => $expiryDate->addWeeks(2),
            FrequencyType::MONTHLY => $expiryDate->addMonths(2),
            FrequencyType::YEARLY => $expiryDate->addYears(2),
        };
    }
}
