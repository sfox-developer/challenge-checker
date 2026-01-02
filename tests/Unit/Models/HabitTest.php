<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Domain\User\Models\User;
use App\Domain\Habit\Models\Habit;
use App\Domain\Habit\Models\HabitCompletion;
use App\Domain\Habit\Models\HabitStatistic;
use App\Domain\Goal\Models\Goal;
use App\Domain\Habit\Enums\FrequencyType;
use Database\Factories\UserFactory;
use Database\Factories\HabitFactory;
use Database\Factories\HabitCompletionFactory;
use Database\Factories\GoalFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Carbon\Carbon;

class HabitTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected Goal $goal;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = UserFactory::new()->create();
        $this->goal = GoalLibraryFactory::new()->create(['user_id' => $this->user->id]);
    }

    /** @test */
    public function test_habit_is_active_by_default()
    {
        $habit = HabitFactory::new()->create([
            'user_id' => $this->user->id,
            'goal_id' => $this->goal->id,
        ]);

        $this->assertTrue($habit->is_active);
        $this->assertNull($habit->archived_at);
        $this->assertFalse($habit->isArchived());
    }

    /** @test */
    public function test_archive_method_marks_habit_as_archived()
    {
        $habit = HabitFactory::new()->create([
            'user_id' => $this->user->id,
            'goal_id' => $this->goal->id,
            'is_active' => true,
        ]);

        $habit->archive();

        $this->assertNotNull($habit->archived_at);
        $this->assertFalse($habit->is_active);
        $this->assertTrue($habit->isArchived());
    }

    /** @test */
    public function test_restore_method_reactivates_archived_habit()
    {
        $habit = HabitFactory::new()->create([
            'user_id' => $this->user->id,
            'goal_id' => $this->goal->id,
            'archived_at' => now(),
            'is_active' => false,
        ]);

        $habit->restore();

        $this->assertNull($habit->archived_at);
        $this->assertTrue($habit->is_active);
        $this->assertFalse($habit->isArchived());
    }

    /** @test */
    public function test_active_scope_returns_only_active_habits()
    {
        $activeHabit = HabitFactory::new()->create([
            'user_id' => $this->user->id,
            'goal_id' => $this->goal->id,
            'is_active' => true,
            'archived_at' => null,
        ]);

        $archivedHabit = HabitFactory::new()->create([
            'user_id' => $this->user->id,
            'goal_id' => $this->goal->id,
            'is_active' => false,
            'archived_at' => now(),
        ]);

        $activeHabits = Habit::active()->get();

        $this->assertTrue($activeHabits->contains($activeHabit));
        $this->assertFalse($activeHabits->contains($archivedHabit));
    }

    /** @test */
    public function test_archived_scope_returns_only_archived_habits()
    {
        $activeHabit = HabitFactory::new()->create([
            'user_id' => $this->user->id,
            'goal_id' => $this->goal->id,
            'archived_at' => null,
        ]);

        $archivedHabit = HabitFactory::new()->create([
            'user_id' => $this->user->id,
            'goal_id' => $this->goal->id,
            'archived_at' => now(),
        ]);

        $archivedHabits = Habit::archived()->get();

        $this->assertFalse($archivedHabits->contains($activeHabit));
        $this->assertTrue($archivedHabits->contains($archivedHabit));
    }

    /** @test */
    public function test_is_completed_today_returns_true_when_completed_today()
    {
        $habit = HabitFactory::new()->create([
            'user_id' => $this->user->id,
            'goal_id' => $this->goal->id,
        ]);

        HabitCompletionFactory::new()->create([
            'habit_id' => $habit->id,
            'user_id' => $this->user->id,
            'date' => now()->toDateString(),
            'completed_at' => now(),
        ]);

        $this->assertTrue($habit->isCompletedToday());
    }

    /** @test */
    public function test_is_completed_today_returns_false_when_not_completed_today()
    {
        $habit = HabitFactory::new()->create([
            'user_id' => $this->user->id,
            'goal_id' => $this->goal->id,
        ]);

        HabitCompletionFactory::new()->create([
            'habit_id' => $habit->id,
            'user_id' => $this->user->id,
            'date' => now()->subDay()->toDateString(),
            'completed_at' => now()->subDay(),
        ]);

        $this->assertFalse($habit->isCompletedToday());
    }

    /** @test */
    public function test_is_due_today_for_daily_habit_not_completed()
    {
        $habit = HabitFactory::new()->create([
            'user_id' => $this->user->id,
            'goal_id' => $this->goal->id,
            'frequency_type' => FrequencyType::DAILY,
            'frequency_count' => 1,
        ]);

        $this->assertTrue($habit->isDueToday());
    }

    /** @test */
    public function test_is_due_today_for_daily_habit_already_completed()
    {
        $habit = HabitFactory::new()->create([
            'user_id' => $this->user->id,
            'goal_id' => $this->goal->id,
            'frequency_type' => FrequencyType::DAILY,
            'frequency_count' => 1,
        ]);

        HabitCompletionFactory::new()->create([
            'habit_id' => $habit->id,
            'user_id' => $this->user->id,
            'date' => now()->toDateString(),
            'completed_at' => now(),
        ]);

        $this->assertFalse($habit->isDueToday());
    }

    /** @test */
    public function test_get_completion_count_for_period_weekly()
    {
        $habit = HabitFactory::new()->create([
            'user_id' => $this->user->id,
            'goal_id' => $this->goal->id,
            'frequency_type' => FrequencyType::WEEKLY,
            'frequency_count' => 3,
        ]);

        // Create 2 completions this week
        HabitCompletionFactory::new()->create([
            'habit_id' => $habit->id,
            'user_id' => $this->user->id,
            'date' => now()->toDateString(),
            'completed_at' => now(),
        ]);

        HabitCompletionFactory::new()->create([
            'habit_id' => $habit->id,
            'user_id' => $this->user->id,
            'date' => now()->subDay()->toDateString(),
            'completed_at' => now()->subDay(),
        ]);

        // Create 1 completion last week (should not count)
        HabitCompletionFactory::new()->create([
            'habit_id' => $habit->id,
            'user_id' => $this->user->id,
            'date' => now()->subWeek()->toDateString(),
            'completed_at' => now()->subWeek(),
        ]);

        $count = $habit->getCompletionCountForPeriod();
        $this->assertEquals(2, $count);
    }

    /** @test */
    public function test_get_progress_text_shows_current_and_required_completions()
    {
        $habit = HabitFactory::new()->create([
            'user_id' => $this->user->id,
            'goal_id' => $this->goal->id,
            'frequency_type' => FrequencyType::WEEKLY,
            'frequency_count' => 5,
        ]);

        // Complete 2 times this week (use different dates)
        HabitCompletionFactory::new()->create([
            'habit_id' => $habit->id,
            'user_id' => $this->user->id,
            'date' => now()->toDateString(),
            'completed_at' => now(),
        ]);

        HabitCompletionFactory::new()->create([
            'habit_id' => $habit->id,
            'user_id' => $this->user->id,
            'date' => now()->subDay()->toDateString(),
            'completed_at' => now()->subDay(),
        ]);

        $progressText = $habit->getProgressText();
        $this->assertStringContainsString('2', $progressText);
        $this->assertStringContainsString('5', $progressText);
    }

    /** @test */
    public function test_get_progress_percentage_calculates_correctly()
    {
        $habit = HabitFactory::new()->create([
            'user_id' => $this->user->id,
            'goal_id' => $this->goal->id,
            'frequency_type' => FrequencyType::WEEKLY,
            'frequency_count' => 4,
        ]);

        // Complete 3 out of 4 = 75%
        for ($i = 0; $i < 3; $i++) {
            HabitCompletionFactory::new()->create([
                'habit_id' => $habit->id,
                'user_id' => $this->user->id,
                'date' => now()->subDays($i)->toDateString(),
                'completed_at' => now()->subDays($i),
            ]);
        }

        $this->assertEquals(75, $habit->getProgressPercentage());
    }

    /** @test */
    public function test_get_progress_percentage_caps_at_100()
    {
        $habit = HabitFactory::new()->create([
            'user_id' => $this->user->id,
            'goal_id' => $this->goal->id,
            'frequency_type' => FrequencyType::WEEKLY,
            'frequency_count' => 3,
        ]);

        // Complete 5 times (more than required)
        for ($i = 0; $i < 5; $i++) {
            HabitCompletionFactory::new()->create([
                'habit_id' => $habit->id,
                'user_id' => $this->user->id,
                'date' => now()->subDays($i)->toDateString(),
                'completed_at' => now()->subDays($i),
            ]);
        }

        $this->assertEquals(100, $habit->getProgressPercentage());
    }

    /** @test */
    public function test_get_frequency_description_for_daily()
    {
        $habit = HabitFactory::new()->create([
            'user_id' => $this->user->id,
            'goal_id' => $this->goal->id,
            'frequency_type' => FrequencyType::DAILY,
            'frequency_count' => 1,
        ]);

        $this->assertStringContainsString('Daily', $habit->getFrequencyDescription());
    }

    /** @test */
    public function test_get_frequency_description_for_weekly()
    {
        $habit = HabitFactory::new()->create([
            'user_id' => $this->user->id,
            'goal_id' => $this->goal->id,
            'frequency_type' => FrequencyType::WEEKLY,
            'frequency_count' => 3,
        ]);

        $description = $habit->getFrequencyDescription();
        $this->assertStringContainsString('3', $description);
        $this->assertStringContainsString('week', $description);
    }

    /** @test */
    public function test_habit_relationships_exist()
    {
        $habit = HabitFactory::new()->create([
            'user_id' => $this->user->id,
            'goal_id' => $this->goal->id,
        ]);

        $this->assertInstanceOf(User::class, $habit->user);
        $this->assertInstanceOf(Goal::class, $habit->goal);
        $this->assertEquals($this->user->id, $habit->user->id);
        $this->assertEquals($this->goal->id, $habit->goal->id);
    }

    /** @test */
    public function test_habit_has_completions_relationship()
    {
        $habit = HabitFactory::new()->create([
            'user_id' => $this->user->id,
            'goal_id' => $this->goal->id,
        ]);

        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\HasMany::class, $habit->completions());
    }

    /** @test */
    public function test_habit_has_statistics_relationship()
    {
        $habit = HabitFactory::new()->create([
            'user_id' => $this->user->id,
            'goal_id' => $this->goal->id,
        ]);

        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\HasOne::class, $habit->statistics());
    }

    /** @test */
    public function test_frequency_type_casts_to_enum()
    {
        $habit = HabitFactory::new()->create([
            'user_id' => $this->user->id,
            'goal_id' => $this->goal->id,
            'frequency_type' => FrequencyType::WEEKLY,
        ]);

        $this->assertInstanceOf(FrequencyType::class, $habit->frequency_type);
        $this->assertEquals(FrequencyType::WEEKLY, $habit->frequency_type);
    }

    /** @test */
    public function test_frequency_config_casts_to_array()
    {
        $config = ['days' => [1, 3, 5]];
        $habit = HabitFactory::new()->create([
            'user_id' => $this->user->id,
            'goal_id' => $this->goal->id,
            'frequency_config' => $config,
        ]);

        $this->assertIsArray($habit->frequency_config);
        $this->assertEquals($config, $habit->frequency_config);
    }
}
