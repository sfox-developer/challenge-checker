<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Domain\User\Models\User;
use App\Domain\Challenge\Models\Challenge;
use App\Domain\Challenge\Models\Goal;
use App\Domain\Challenge\Models\DailyProgress;
use App\Domain\Habit\Enums\FrequencyType;
use Database\Factories\UserFactory;
use Database\Factories\ChallengeFactory;
use Database\Factories\GoalFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Carbon\Carbon;

class ChallengeTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected Challenge $challenge;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = UserFactory::new()->create();
    }

    /** @test */
    public function test_challenge_starts_with_correct_initial_state()
    {
        $challenge = ChallengeFactory::new()->create([
            'user_id' => $this->user->id,
        ]);

        $this->assertNull($challenge->started_at);
        $this->assertNull($challenge->completed_at);
        $this->assertFalse($challenge->is_active);
        $this->assertTrue($challenge->isNotStarted());
        $this->assertFalse($challenge->isActive());
        $this->assertFalse($challenge->isCompleted());
        $this->assertEquals('draft', $challenge->status);
    }

    /** @test */
    public function test_start_method_sets_started_at_and_activates_challenge()
    {
        $challenge = ChallengeFactory::new()->create([
            'user_id' => $this->user->id,
        ]);

        $challenge->start();

        $this->assertNotNull($challenge->started_at);
        $this->assertTrue($challenge->is_active);
        $this->assertTrue($challenge->isActive());
        $this->assertFalse($challenge->isNotStarted());
        $this->assertEquals('active', $challenge->status);
    }

    /** @test */
    public function test_pause_method_deactivates_challenge()
    {
        $challenge = ChallengeFactory::new()->create([
            'user_id' => $this->user->id,
            'started_at' => now(),
            'is_active' => true,
        ]);

        $challenge->pause();

        $this->assertFalse($challenge->is_active);
        $this->assertTrue($challenge->isPaused());
        $this->assertFalse($challenge->isActive());
        $this->assertEquals('paused', $challenge->status);
    }

    /** @test */
    public function test_resume_method_reactivates_paused_challenge()
    {
        $challenge = ChallengeFactory::new()->create([
            'user_id' => $this->user->id,
            'started_at' => now(),
            'is_active' => false,
        ]);

        $challenge->resume();

        $this->assertTrue($challenge->is_active);
        $this->assertTrue($challenge->isActive());
        $this->assertFalse($challenge->isPaused());
        $this->assertEquals('active', $challenge->status);
    }

    /** @test */
    public function test_complete_method_marks_challenge_as_completed()
    {
        $challenge = ChallengeFactory::new()->create([
            'user_id' => $this->user->id,
            'started_at' => now(),
            'is_active' => true,
        ]);

        $challenge->complete();

        $this->assertNotNull($challenge->completed_at);
        $this->assertFalse($challenge->is_active);
        $this->assertTrue($challenge->isCompleted());
        $this->assertFalse($challenge->isActive());
        $this->assertEquals('completed', $challenge->status);
    }

    /** @test */
    public function test_end_date_calculated_correctly_from_start_date_and_duration()
    {
        $startDate = Carbon::parse('2025-01-01');
        $challenge = ChallengeFactory::new()->create([
            'user_id' => $this->user->id,
            'started_at' => $startDate,
            'days_duration' => 30,
        ]);

        $expectedEndDate = $startDate->copy()->addDays(30);
        $this->assertEquals($expectedEndDate->toDateString(), $challenge->end_date->toDateString());
    }

    /** @test */
    public function test_end_date_is_null_when_challenge_not_started()
    {
        $challenge = ChallengeFactory::new()->create([
            'user_id' => $this->user->id,
            'started_at' => null,
        ]);

        $this->assertNull($challenge->end_date);
    }

    /** @test */
    public function test_has_expired_returns_true_when_duration_exceeded()
    {
        $challenge = ChallengeFactory::new()->create([
            'user_id' => $this->user->id,
            'started_at' => now()->subDays(31),
            'days_duration' => 30,
            'is_active' => true,
        ]);

        $this->assertTrue($challenge->hasExpired());
    }

    /** @test */
    public function test_has_expired_returns_false_when_duration_not_exceeded()
    {
        $challenge = ChallengeFactory::new()->create([
            'user_id' => $this->user->id,
            'started_at' => now()->subDays(10),
            'days_duration' => 30,
            'is_active' => true,
        ]);

        $this->assertFalse($challenge->hasExpired());
    }

    /** @test */
    public function test_has_expired_returns_false_when_not_started()
    {
        $challenge = ChallengeFactory::new()->create([
            'user_id' => $this->user->id,
            'started_at' => null,
        ]);

        $this->assertFalse($challenge->hasExpired());
    }

    /** @test */
    public function test_has_expired_returns_false_when_completed()
    {
        $challenge = ChallengeFactory::new()->create([
            'user_id' => $this->user->id,
            'started_at' => now()->subDays(31),
            'days_duration' => 30,
            'completed_at' => now(),
        ]);

        $this->assertFalse($challenge->hasExpired());
    }

    /** @test */
    public function test_check_and_auto_complete_completes_expired_challenge()
    {
        $challenge = ChallengeFactory::new()->create([
            'user_id' => $this->user->id,
            'started_at' => now()->subDays(31),
            'days_duration' => 30,
            'is_active' => true,
        ]);

        $result = $challenge->checkAndAutoComplete();

        $this->assertTrue($result);
        $this->assertNotNull($challenge->completed_at);
        $this->assertTrue($challenge->isCompleted());
    }

    /** @test */
    public function test_check_and_auto_complete_does_not_affect_active_challenge()
    {
        $challenge = ChallengeFactory::new()->create([
            'user_id' => $this->user->id,
            'started_at' => now()->subDays(10),
            'days_duration' => 30,
            'is_active' => true,
        ]);

        $result = $challenge->checkAndAutoComplete();

        $this->assertFalse($result);
        $this->assertNull($challenge->completed_at);
        $this->assertFalse($challenge->isCompleted());
    }

    /** @test */
    public function test_get_current_day_returns_correct_day_number()
    {
        $challenge = ChallengeFactory::new()->create([
            'user_id' => $this->user->id,
            'started_at' => now()->subDays(5),
            'days_duration' => 30,
        ]);

        $this->assertEquals(6, $challenge->getCurrentDay()); // Day 6 (started 5 days ago + 1)
    }

    /** @test */
    public function test_get_current_day_returns_zero_when_not_started()
    {
        $challenge = ChallengeFactory::new()->create([
            'user_id' => $this->user->id,
            'started_at' => null,
        ]);

        $this->assertEquals(0, $challenge->getCurrentDay());
    }

    /** @test */
    public function test_get_current_day_caps_at_duration_when_completed()
    {
        $challenge = ChallengeFactory::new()->create([
            'user_id' => $this->user->id,
            'started_at' => now()->subDays(35),
            'days_duration' => 30,
            'completed_at' => now(),
        ]);

        $this->assertEquals(30, $challenge->getCurrentDay());
    }

    /** @test */
    public function test_progress_percentage_calculated_correctly()
    {
        $challenge = ChallengeFactory::new()->create([
            'user_id' => $this->user->id,
            'started_at' => now(),
            'days_duration' => 10,
        ]);

        // Create 2 goals
        $goal1 = GoalFactory::new()->create(['challenge_id' => $challenge->id]);
        $goal2 = GoalFactory::new()->create(['challenge_id' => $challenge->id]);

        // Total: 2 goals × 10 days = 20 goal-days
        // Complete 5 goal-days (25%)
        for ($i = 0; $i < 3; $i++) {
            DailyProgress::create([
                'user_id' => $this->user->id,
                'challenge_id' => $challenge->id,
                'goal_id' => $goal1->id,
                'date' => now()->subDays($i)->toDateString(),
                'completed_at' => now()->subDays($i),
            ]);
        }

        DailyProgress::create([
            'user_id' => $this->user->id,
            'challenge_id' => $challenge->id,
            'goal_id' => $goal2->id,
            'date' => now()->toDateString(),
            'completed_at' => now(),
        ]);

        DailyProgress::create([
            'user_id' => $this->user->id,
            'challenge_id' => $challenge->id,
            'goal_id' => $goal2->id,
            'date' => now()->subDay()->toDateString(),
            'completed_at' => now()->subDay(),
        ]);

        $challenge = $challenge->fresh(['goals', 'dailyProgress']);
        $this->assertEquals(25.0, $challenge->getProgressPercentage());
    }

    /** @test */
    public function test_progress_percentage_is_zero_when_not_started()
    {
        $challenge = ChallengeFactory::new()->create([
            'user_id' => $this->user->id,
            'started_at' => null,
        ]);

        $this->assertEquals(0, $challenge->getProgressPercentage());
    }

    /** @test */
    public function test_progress_percentage_is_zero_when_no_goals()
    {
        $challenge = ChallengeFactory::new()->create([
            'user_id' => $this->user->id,
            'started_at' => now(),
        ]);

        $this->assertEquals(0, $challenge->getProgressPercentage());
    }

    /** @test */
    public function test_get_completed_days_count_returns_correct_count()
    {
        $challenge = ChallengeFactory::new()->create([
            'user_id' => $this->user->id,
            'started_at' => now(),
        ]);

        $goal1 = GoalFactory::new()->create(['challenge_id' => $challenge->id]);
        $goal2 = GoalFactory::new()->create(['challenge_id' => $challenge->id]);

        // Day 1: Both goals completed
        DailyProgress::create([
            'user_id' => $this->user->id,
            'challenge_id' => $challenge->id,
            'goal_id' => $goal1->id,
            'date' => now()->toDateString(),
            'completed_at' => now(),
        ]);

        DailyProgress::create([
            'user_id' => $this->user->id,
            'challenge_id' => $challenge->id,
            'goal_id' => $goal2->id,
            'date' => now()->toDateString(),
            'completed_at' => now(),
        ]);

        // Day 2: Only one goal completed
        DailyProgress::create([
            'user_id' => $this->user->id,
            'challenge_id' => $challenge->id,
            'goal_id' => $goal1->id,
            'date' => now()->subDay()->toDateString(),
            'completed_at' => now()->subDay(),
        ]);

        $challenge = $challenge->fresh(['goals', 'dailyProgress']);
        $this->assertEquals(1, $challenge->getCompletedDaysCount()); // Only day 1 had all goals completed
    }

    /** @test */
    public function test_frequency_description_for_daily_frequency()
    {
        $challenge = ChallengeFactory::new()->create([
            'user_id' => $this->user->id,
            'frequency_type' => FrequencyType::DAILY,
            'frequency_count' => 1,
        ]);

        $this->assertStringContainsString('Daily', $challenge->getFrequencyDescription());
    }

    /** @test */
    public function test_frequency_description_for_weekly_frequency()
    {
        $challenge = ChallengeFactory::new()->create([
            'user_id' => $this->user->id,
            'frequency_type' => FrequencyType::WEEKLY,
            'frequency_count' => 3,
        ]);

        $this->assertStringContainsString('3', $challenge->getFrequencyDescription());
        $this->assertStringContainsString('week', $challenge->getFrequencyDescription());
    }

    /** @test */
    public function test_get_duration_uses_days_duration_for_backward_compatibility()
    {
        $challenge = ChallengeFactory::new()->create([
            'user_id' => $this->user->id,
            'days_duration' => 60,
        ]);

        $this->assertEquals(60, $challenge->getDuration());
    }

    /** @test */
    public function test_get_duration_defaults_to_30_when_no_days_duration()
    {
        $challenge = ChallengeFactory::new()->create([
            'user_id' => $this->user->id,
            'days_duration' => null,
        ]);

        $this->assertEquals(30, $challenge->getDuration());
    }

    /** @test */
    public function test_challenge_relationships_exist()
    {
        $challenge = ChallengeFactory::new()->create([
            'user_id' => $this->user->id,
        ]);

        $this->assertInstanceOf(User::class, $challenge->user);
        $this->assertEquals($this->user->id, $challenge->user->id);
    }

    /** @test */
    public function test_is_paused_returns_correct_state()
    {
        // Started but not active and not completed = paused
        $challenge = ChallengeFactory::new()->create([
            'user_id' => $this->user->id,
            'started_at' => now(),
            'is_active' => false,
            'completed_at' => null,
        ]);

        $this->assertTrue($challenge->isPaused());
    }

    /** @test */
    public function test_is_paused_returns_false_for_active_challenge()
    {
        $challenge = ChallengeFactory::new()->create([
            'user_id' => $this->user->id,
            'started_at' => now(),
            'is_active' => true,
        ]);

        $this->assertFalse($challenge->isPaused());
    }

    /** @test */
    public function test_is_paused_returns_false_for_completed_challenge()
    {
        $challenge = ChallengeFactory::new()->create([
            'user_id' => $this->user->id,
            'started_at' => now(),
            'is_active' => false,
            'completed_at' => now(),
        ]);

        $this->assertFalse($challenge->isPaused());
    }
}
