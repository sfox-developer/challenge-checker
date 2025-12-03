<?php

namespace App\Domain\Activity\Services;

use App\Domain\Activity\Models\Activity;
use App\Domain\User\Models\User;
use App\Domain\Challenge\Models\Challenge;
use App\Domain\Challenge\Models\Goal;

class ActivityService
{
    /**
     * Create an activity when a goal is completed.
     */
    public function createGoalCompletedActivity(User $user, Challenge $challenge, Goal $goal): ?Activity
    {
        // Only create activity if challenge is public or it's the user's own challenge
        if (!$challenge->is_public && $challenge->user_id !== $user->id) {
            return null;
        }

        // Check if activity already exists for this goal today
        $today = now()->toDateString();
        $existing = Activity::where('user_id', $user->id)
            ->where('challenge_id', $challenge->id)
            ->where('goal_id', $goal->id)
            ->where('type', Activity::TYPE_GOAL_COMPLETED)
            ->whereDate('created_at', $today)
            ->first();

        if ($existing) {
            return $existing; // Return existing activity instead of creating duplicate
        }

        return Activity::create([
            'user_id' => $user->id,
            'challenge_id' => $challenge->id,
            'goal_id' => $goal->id,
            'type' => Activity::TYPE_GOAL_COMPLETED,
            'data' => [
                'goal_name' => $goal->name,
                'challenge_name' => $challenge->name,
            ],
        ]);
    }

    /**
     * Create an activity when all goals for the day are completed.
     */
    public function createDayCompletedActivity(User $user, Challenge $challenge): ?Activity
    {
        if (!$challenge->is_public && $challenge->user_id !== $user->id) {
            return null;
        }

        // Check if activity already exists for this challenge today
        $today = now()->toDateString();
        $existing = Activity::where('user_id', $user->id)
            ->where('challenge_id', $challenge->id)
            ->where('type', Activity::TYPE_DAY_COMPLETED)
            ->whereDate('created_at', $today)
            ->first();

        if ($existing) {
            return $existing; // Return existing activity instead of creating duplicate
        }

        return Activity::create([
            'user_id' => $user->id,
            'challenge_id' => $challenge->id,
            'type' => Activity::TYPE_DAY_COMPLETED,
            'data' => [
                'challenge_name' => $challenge->name,
                'goals_count' => $challenge->goals->count(),
            ],
        ]);
    }

    /**
     * Create an activity when a challenge is started.
     */
    public function createChallengeStartedActivity(Challenge $challenge): ?Activity
    {
        return Activity::create([
            'user_id' => $challenge->user_id,
            'challenge_id' => $challenge->id,
            'type' => Activity::TYPE_CHALLENGE_STARTED,
            'data' => [
                'challenge_name' => $challenge->name,
                'days_duration' => $challenge->days_duration,
            ],
        ]);
    }

    /**
     * Create an activity when a challenge is completed.
     */
    public function createChallengeCompletedActivity(Challenge $challenge): ?Activity
    {
        return Activity::create([
            'user_id' => $challenge->user_id,
            'challenge_id' => $challenge->id,
            'type' => Activity::TYPE_CHALLENGE_COMPLETED,
            'data' => [
                'challenge_name' => $challenge->name,
                'days_duration' => $challenge->days_duration,
                'completion_date' => now()->toDateString(),
            ],
        ]);
    }

    /**
     * Create an activity when a challenge is paused.
     */
    public function createChallengePausedActivity(Challenge $challenge): ?Activity
    {
        if (!$challenge->is_public) {
            return null;
        }

        return Activity::create([
            'user_id' => $challenge->user_id,
            'challenge_id' => $challenge->id,
            'type' => Activity::TYPE_CHALLENGE_PAUSED,
            'data' => [
                'challenge_name' => $challenge->name,
            ],
        ]);
    }

    /**
     * Create an activity when a challenge is resumed.
     */
    public function createChallengeResumedActivity(Challenge $challenge): ?Activity
    {
        if (!$challenge->is_public) {
            return null;
        }

        return Activity::create([
            'user_id' => $challenge->user_id,
            'challenge_id' => $challenge->id,
            'type' => Activity::TYPE_CHALLENGE_RESUMED,
            'data' => [
                'challenge_name' => $challenge->name,
            ],
        ]);
    }

    /**
     * Toggle a like on an activity.
     */
    public function toggleLike(Activity $activity, User $user): bool
    {
        $like = $activity->likes()->where('user_id', $user->id)->first();

        if ($like) {
            $like->delete();
            return false; // Unliked
        }

        $activity->likes()->create([
            'user_id' => $user->id,
        ]);

        return true; // Liked
    }

    /**
     * Create a generic activity (for habits and other uses).
     */
    public function createActivity(
        User $user,
        string $type,
        ?int $challengeId = null,
        ?int $goalId = null,
        ?int $habitId = null,
        array $data = []
    ): ?Activity {
        return Activity::create([
            'user_id' => $user->id,
            'challenge_id' => $challengeId,
            'goal_id' => $goalId,
            'habit_id' => $habitId,
            'type' => $type,
            'data' => $data,
        ]);
    }
}
