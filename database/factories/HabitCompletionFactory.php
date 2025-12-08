<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Domain\Habit\Models\HabitCompletion;
use App\Domain\Habit\Models\Habit;
use App\Domain\User\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Domain\Habit\Models\HabitCompletion>
 */
class HabitCompletionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = HabitCompletion::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'habit_id' => HabitFactory::new(),
            'user_id' => UserFactory::new(),
            'date' => now()->toDateString(),
            'completed_at' => now(),
            'notes' => null,
            'duration_minutes' => null,
            'mood' => null,
            'metadata' => null,
        ];
    }

    /**
     * Indicate completion with notes.
     */
    public function withNotes(string $notes = null): static
    {
        return $this->state(fn (array $attributes) => [
            'notes' => $notes ?? fake()->sentence(),
        ]);
    }

    /**
     * Indicate completion with duration.
     */
    public function withDuration(int $minutes = null): static
    {
        return $this->state(fn (array $attributes) => [
            'duration_minutes' => $minutes ?? fake()->numberBetween(5, 120),
        ]);
    }

    /**
     * Indicate completion with mood.
     */
    public function withMood(string $mood = 'happy'): static
    {
        return $this->state(fn (array $attributes) => [
            'mood' => $mood,
        ]);
    }
}
