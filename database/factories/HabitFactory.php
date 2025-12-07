<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Domain\Habit\Models\Habit;
use App\Domain\User\Models\User;
use App\Domain\Goal\Models\GoalLibrary;
use App\Domain\Habit\Enums\FrequencyType;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Domain\Habit\Models\Habit>
 */
class HabitFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = Habit::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => UserFactory::new(),
            'goal_library_id' => GoalLibraryFactory::new(),
            'frequency_type' => FrequencyType::DAILY,
            'frequency_count' => 1,
            'frequency_config' => null,
            'is_active' => true,
            'archived_at' => null,
        ];
    }

    /**
     * Indicate that the habit is archived.
     */
    public function archived(): static
    {
        return $this->state(fn (array $attributes) => [
            'archived_at' => now(),
            'is_active' => false,
        ]);
    }

    /**
     * Indicate that the habit is weekly.
     */
    public function weekly(int $count = 3): static
    {
        return $this->state(fn (array $attributes) => [
            'frequency_type' => FrequencyType::WEEKLY,
            'frequency_count' => $count,
        ]);
    }

    /**
     * Indicate that the habit is monthly.
     */
    public function monthly(int $count = 4): static
    {
        return $this->state(fn (array $attributes) => [
            'frequency_type' => FrequencyType::MONTHLY,
            'frequency_count' => $count,
        ]);
    }
}
