<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Domain\Challenge\Models\Challenge;
use App\Domain\Goal\Models\GoalLibrary;
use App\Domain\Goal\Models\GoalCompletion;
use App\Domain\Activity\Services\ActivityService;
use App\Domain\Challenge\Services\ChallengeService;

class GoalController extends Controller
{
    public function __construct(
        private ActivityService $activityService,
        private ChallengeService $challengeService
    ) {}

    /**
     * Toggle the completion status of a goal for today.
     */
    public function toggle(Challenge $challenge, GoalLibrary $goalLibrary): JsonResponse
    {
        $user = auth()->user();
        $today = now()->toDateString();

        // Verify that the challenge belongs to the user
        if ($challenge->user_id !== $user->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Verify that the goal is part of this challenge
        if (!$challenge->goals->contains($goalLibrary)) {
            return response()->json(['error' => 'Goal not found in this challenge'], 404);
        }

        // Find existing completion entry for today
        $completion = GoalCompletion::where([
            'user_id' => $user->id,
            'goal_id' => $goalLibrary->id,
            'source_type' => 'challenge',
            'source_id' => $challenge->id,
            'date' => $today,
        ])->first();

        // Check if already completed
        $isCompleted = $completion && $completion->completed_at !== null;
        
        if ($isCompleted) {
            // Undo completion
            $completion->update(['completed_at' => null]);
            $message = 'Goal marked as not completed';
            $completed = false;
        } else {
            // Check if we can complete based on frequency limits
            if (!$this->challengeService->canCompleteGoal($challenge, $goalLibrary, new \DateTime($today))) {
                $frequencyDesc = $challenge->getFrequencyDescription();
                return response()->json([
                    'error' => true,
                    'message' => "You've reached the limit for this period ({$frequencyDesc}). Great work!"
                ], 422);
            }

            // Create or update completion entry
            if (!$completion) {
                $completion = GoalCompletion::create([
                    'user_id' => $user->id,
                    'goal_id' => $goalLibrary->id,
                    'source_type' => 'challenge',
                    'source_id' => $challenge->id,
                    'date' => $today,
                    'completed_at' => now(),
                ]);
            } else {
                $completion->update(['completed_at' => now()]);
            }
            
            $message = 'Goal completed! Great job!';
            $completed = true;
            
            // Create activity for goal completion
            $this->activityService->createGoalCompletedActivity($user, $challenge, $goalLibrary);
        }

        // Check if all goals are completed for current period
        $allGoalsCompleted = $this->challengeService->areAllGoalsCompletedForPeriod($challenge, new \DateTime($today));
        
        // Create activity for period completion if all goals done
        if ($allGoalsCompleted && $completed) {
            $periodName = $challenge->frequency_type?->label() ?? 'day';
            $this->activityService->createDayCompletedActivity($user, $challenge);
        }

        // Get progress for current period
        $progressText = $this->challengeService->getProgressText($challenge, $goalLibrary);
        $progressPercentage = $this->challengeService->getProgressPercentage($challenge, $goalLibrary);

        return response()->json([
            'success' => true,
            'completed' => $completed,
            'message' => $message,
            'all_goals_completed' => $allGoalsCompleted,
            'celebration' => $allGoalsCompleted ? 'All goals completed for this period! 🎉' : null,
            'progress' => [
                'text' => $progressText,
                'percentage' => $progressPercentage,
                'current' => $this->challengeService->getCompletionCountForPeriod($challenge, $goalLibrary, new \DateTime($today)),
                'target' => $challenge->frequency_count ?? 1,
            ],
        ]);
    }
}
