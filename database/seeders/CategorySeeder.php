<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Domain\Goal\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Health',
                'slug' => 'health',
                'icon' => '❤️',
                'color' => 'red',
                'description' => 'Health and wellness related goals',
                'order' => 1,
            ],
            [
                'name' => 'Fitness',
                'slug' => 'fitness',
                'icon' => '💪',
                'color' => 'orange',
                'description' => 'Physical fitness and exercise goals',
                'order' => 2,
            ],
            [
                'name' => 'Learning',
                'slug' => 'learning',
                'icon' => '📚',
                'color' => 'blue',
                'description' => 'Educational and skill development goals',
                'order' => 3,
            ],
            [
                'name' => 'Productivity',
                'slug' => 'productivity',
                'icon' => '⚡',
                'color' => 'yellow',
                'description' => 'Work and productivity related goals',
                'order' => 4,
            ],
            [
                'name' => 'Mindfulness',
                'slug' => 'mindfulness',
                'icon' => '🧘',
                'color' => 'purple',
                'description' => 'Mental health and mindfulness goals',
                'order' => 5,
            ],
            [
                'name' => 'Social',
                'slug' => 'social',
                'icon' => '👥',
                'color' => 'pink',
                'description' => 'Social and relationship goals',
                'order' => 6,
            ],
            [
                'name' => 'Other',
                'slug' => 'other',
                'icon' => '🎯',
                'color' => 'gray',
                'description' => 'Other miscellaneous goals',
                'order' => 99,
            ],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }
    }
}
