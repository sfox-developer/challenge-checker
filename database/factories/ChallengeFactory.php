<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Domain\Challenge\Models\Challenge>
 */
class ChallengeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \App\Domain\Challenge\Models\Challenge::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(),
            'days_duration' => $this->faker->numberBetween(7, 30),
            'is_active' => false,
            'started_at' => null,
            'completed_at' => null,
        ];
    }
}
