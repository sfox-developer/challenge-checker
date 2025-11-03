<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Domain\Challenge\Models\Goal;
use App\Domain\Challenge\Models\DailyProgress;

class GoalController extends Controller
{
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

        // Find or create daily progress entry
        $progress = DailyProgress::firstOrCreate([
            'user_id' => $user->id,
            'challenge_id' => $goal->challenge_id,
            'goal_id' => $goal->id,
            'date' => $today,
        ]);

        // Toggle completion status
        $isCompleted = $progress->isCompleted();
        
        if ($isCompleted) {
            $progress->markUncompleted();
            $message = 'Goal marked as not completed';
        } else {
            $progress->markCompleted();
            $message = 'Goal completed! Great job!';
        }

        // Check if all goals for today are completed
        $allGoalsCompleted = $this->checkAllGoalsCompletedForToday($goal->challenge_id, $user->id, $today);

        return response()->json([
            'success' => true,
            'completed' => !$isCompleted,
            'message' => $message,
            'all_goals_completed' => $allGoalsCompleted,
            'celebration' => $allGoalsCompleted ? 'All goals completed for today! 🎉' : null
        ]);
    }

    /**
     * Check if all goals for a challenge are completed for today.
     */
    private function checkAllGoalsCompletedForToday(int $challengeId, int $userId, string $date): bool
    {
        $totalGoals = Goal::where('challenge_id', $challengeId)->count();
        
        $completedGoals = DailyProgress::where('user_id', $userId)
            ->where('challenge_id', $challengeId)
            ->where('date', $date)
            ->whereNotNull('completed_at')
            ->count();

        return $totalGoals > 0 && $completedGoals === $totalGoals;
    }
}
