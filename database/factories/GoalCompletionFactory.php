<?php

namespace Database\Factories;

use App\Domain\Goal\Models\GoalCompletion;
use App\Domain\User\Models\User;
use App\Domain\Goal\Models\GoalLibrary;
use App\Domain\Challenge\Models\Challenge;
use App\Domain\Habit\Models\Habit;
use Illuminate\Database\Eloquent\Factories\Factory;

class GoalCompletionFactory extends Factory
{
    protected $model = GoalCompletion::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'goal_id' => GoalLibrary::factory(),
            'date' => $this->faker->dateTimeBetween('-30 days', 'now')->format('Y-m-d'),
            'completed_at' => $this->faker->dateTimeBetween('-30 days', 'now'),
            'source_type' => $this->faker->randomElement(['challenge', 'habit', 'manual']),
            'source_id' => null, // Set explicitly when creating
            'notes' => $this->faker->optional(0.3)->sentence(),
            'duration_minutes' => $this->faker->optional(0.2)->numberBetween(5, 120),
            'mood' => $this->faker->optional(0.2)->randomElement(['great', 'good', 'okay', 'bad']),
            'metadata' => null,
        ];
    }

    /**
     * Indicate that this completion is for a challenge.
     */
    public function forChallenge(Challenge $challenge): static
    {
        return $this->state(fn (array $attributes) => [
            'user_id' => $challenge->user_id,
            'source_type' => 'challenge',
            'source_id' => $challenge->id,
        ]);
    }

    /**
     * Indicate that this completion is for a habit.
     */
    public function forHabit(Habit $habit): static
    {
        return $this->state(fn (array $attributes) => [
            'user_id' => $habit->user_id,
            'goal_id' => $habit->goal_id,
            'source_type' => 'habit',
            'source_id' => $habit->id,
        ]);
    }

    /**
     * Indicate that this completion is manual (not from a challenge or habit).
     */
    public function manual(): static
    {
        return $this->state(fn (array $attributes) => [
            'source_type' => 'manual',
            'source_id' => null,
        ]);
    }

    /**
     * Indicate that this completion is completed.
     */
    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'completed_at' => now(),
        ]);
    }

    /**
     * Indicate that this completion is not yet completed.
     */
    public function incomplete(): static
    {
        return $this->state(fn (array $attributes) => [
            'completed_at' => null,
        ]);
    }
}
