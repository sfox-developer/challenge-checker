<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Domain\Goal\Models\GoalLibrary;
use App\Domain\User\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Domain\Goal\Models\GoalLibrary>
 */
class GoalLibraryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = GoalLibrary::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $goals = [
            ['name' => 'Drink 8 glasses of water', 'icon' => '💧', 'category' => 'Health'],
            ['name' => 'Exercise for 30 minutes', 'icon' => '💪', 'category' => 'Fitness'],
            ['name' => 'Meditate for 10 minutes', 'icon' => '🧘', 'category' => 'Mindfulness'],
            ['name' => 'Read for 30 minutes', 'icon' => '📚', 'category' => 'Learning'],
            ['name' => 'Practice gratitude', 'icon' => '🙏', 'category' => 'Mindfulness'],
            ['name' => 'Learn something new', 'icon' => '🎓', 'category' => 'Learning'],
            ['name' => 'Eat healthy meals', 'icon' => '🥗', 'category' => 'Nutrition'],
            ['name' => 'Get 8 hours of sleep', 'icon' => '😴', 'category' => 'Health'],
        ];

        $goal = fake()->randomElement($goals);

        return [
            'user_id' => UserFactory::new(),
            'name' => $goal['name'],
            'description' => fake()->optional(0.5)->sentence(),
            'icon' => $goal['icon'],
            'category' => $goal['category'],
        ];
    }

    /**
     * Indicate a custom goal name.
     */
    public function named(string $name): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => $name,
        ]);
    }

    /**
     * Indicate a specific category.
     */
    public function category(string $category): static
    {
        return $this->state(fn (array $attributes) => [
            'category' => $category,
        ]);
    }
}
