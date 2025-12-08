<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Domain\Challenge\Models\Goal;
use App\Domain\Challenge\Models\DailyProgress;
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
    public function toggle(Goal $goal): JsonResponse
    {
        $user = auth()->user();
        $today = now()->toDateString();

        // Verify that the goal belongs to the user's challenge
        if ($goal->challenge->user_id !== $user->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $challenge = $goal->challenge;

        // Find existing progress entry for today
        $progress = DailyProgress::where([
            'user_id' => $user->id,
            'challenge_id' => $goal->challenge_id,
            'goal_id' => $goal->id,
            'date' => $today,
        ])->first();

        // Check if already completed
        $isCompleted = $progress && $progress->isCompleted();
        
        if ($isCompleted) {
            // Undo completion
            $progress->markUncompleted();
            $message = 'Goal marked as not completed';
            $completed = false;
        } else {
            // Check if we can complete based on frequency limits
            if (!$this->challengeService->canCompleteGoal($challenge, $goal, new \DateTime($today))) {
                $frequencyDesc = $challenge->getFrequencyDescription();
                return response()->json([
                    'error' => true,
                    'message' => "You've reached the limit for this period ({$frequencyDesc}). Great work!"
                ], 422);
            }

            // Create or update progress entry
            if (!$progress) {
                $progress = DailyProgress::create([
                    'user_id' => $user->id,
                    'challenge_id' => $goal->challenge_id,
                    'goal_id' => $goal->id,
                    'date' => $today,
                ]);
            }
            
            $progress->markCompleted();
            $message = 'Goal completed! Great job!';
            $completed = true;
            
            // Create activity for goal completion
            $this->activityService->createGoalCompletedActivity($user, $challenge, $goal);
        }

        // Check if all goals are completed for current period
        $allGoalsCompleted = $this->challengeService->areAllGoalsCompletedForPeriod($challenge, new \DateTime($today));
        
        // Create activity for period completion if all goals done
        if ($allGoalsCompleted && $completed) {
            $periodName = $challenge->frequency_type?->label() ?? 'day';
            $this->activityService->createDayCompletedActivity($user, $challenge);
        }

        // Get progress for current period
        $progressText = $this->challengeService->getProgressText($challenge, $goal);
        $progressPercentage = $this->challengeService->getProgressPercentage($challenge, $goal);

        return response()->json([
            'success' => true,
            'completed' => $completed,
            'message' => $message,
            'all_goals_completed' => $allGoalsCompleted,
            'celebration' => $allGoalsCompleted ? 'All goals completed for this period! 🎉' : null,
            'progress' => [
                'text' => $progressText,
                'percentage' => $progressPercentage,
                'current' => $this->challengeService->getCompletionCountForPeriod($challenge, $goal, new \DateTime($today)),
                'target' => $challenge->frequency_count ?? 1,
            ],
        ]);
    }
}
