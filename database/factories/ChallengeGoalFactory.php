<?php

namespace Database\Factories;

use App\Domain\Challenge\Models\ChallengeGoal;
use App\Domain\Challenge\Models\Challenge;
use App\Domain\Goal\Models\Goal;
use Illuminate\Database\Eloquent\Factories\Factory;

class ChallengeGoalFactory extends Factory
{
    protected $model = ChallengeGoal::class;

    public function definition(): array
    {
        return [
            'challenge_id' => Challenge::factory(),
            'goal_id' => Goal::factory(),
            'order' => $this->faker->numberBetween(1, 10),
        ];
    }
}
