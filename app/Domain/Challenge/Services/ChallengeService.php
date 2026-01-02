<?php

namespace App\Domain\Challenge\Services;

use App\Domain\Challenge\Models\Challenge;
use App\Domain\Goal\Models\Goal;
use App\Domain\Goal\Models\GoalCompletion;
use App\Domain\User\Models\User;
use App\Domain\Habit\Enums\FrequencyType;

class ChallengeService
{
    /**
     * Get completion count for current period based on challenge frequency.
     */
    public function getCompletionCountForPeriod(Challenge $challenge, Goal $goal, ?\DateTime $date = null): int
    {
        $date = $date ?? new \DateTime();
        $frequencyType = $challenge->frequency_type ?? FrequencyType::DAILY;
        
        $start = $frequencyType->periodStart($date);
        $end = $frequencyType->periodEnd($date);

        return GoalCompletion::where('goal_id', $goal->id)
            ->where('user_id', $challenge->user_id)
            ->whereBetween('date', [
                $start->format('Y-m-d'),
                $end->format('Y-m-d')
            ])
            ->whereNotNull('completed_at')
            ->count();
    }

    /**
     * Check if goal can be completed based on frequency limits.
     */
    public function canCompleteGoal(Challenge $challenge, Goal $goal, ?\DateTime $date = null): bool
    {
        $date = $date ?? new \DateTime();
        $frequencyType = $challenge->frequency_type ?? FrequencyType::DAILY;
        $frequencyCount = $challenge->frequency_count ?? 1;
        
        // For daily frequency, only one completion per day
        if ($frequencyType === FrequencyType::DAILY) {
            return !GoalCompletion::where('goal_id', $goal->id)
                ->where('user_id', $challenge->user_id)
                ->where('date', $date->format('Y-m-d'))
                ->whereNotNull('completed_at')
                ->exists();
        }

        // For other frequencies, check if limit reached
        $completed = $this->getCompletionCountForPeriod($challenge, $goal, $date);
        return $completed < $frequencyCount;
    }

    /**
     * Get progress text for a goal in current period.
     */
    public function getProgressText(Challenge $challenge, Goal $goal): string
    {
        $completed = $this->getCompletionCountForPeriod($challenge, $goal);
        $required = $challenge->frequency_count ?? 1;

        return "{$completed}/{$required}";
    }

    /**
     * Get progress percentage for a goal in current period.
     */
    public function getProgressPercentage(Challenge $challenge, Goal $goal): int
    {
        $completed = $this->getCompletionCountForPeriod($challenge, $goal);
        $required = $challenge->frequency_count ?? 1;

        if ($required === 0) {
            return 0;
        }

        return min(100, (int) round(($completed / $required) * 100));
    }

    /**
     * Check if all goals are completed for the current period.
     */
    public function areAllGoalsCompletedForPeriod(Challenge $challenge, ?\DateTime $date = null): bool
    {
        $date = $date ?? new \DateTime();
        $goals = $challenge->goals;
        
        if ($goals->isEmpty()) {
            return false;
        }

        foreach ($goals as $goal) {
            $completed = $this->getCompletionCountForPeriod($challenge, $goal, $date);
            $required = $challenge->frequency_count ?? 1;
            
            if ($completed < $required) {
                return false;
            }
        }

        return true;
    }
}
