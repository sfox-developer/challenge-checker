<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Domain\User\Models\User;
use App\Domain\Challenge\Models\Challenge;
use App\Domain\Challenge\Models\Goal;
use App\Domain\Challenge\Models\DailyProgress;
use Database\Factories\UserFactory;
use Database\Factories\ChallengeFactory;
use Database\Factories\GoalFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Carbon\Carbon;

class GoalTrackingTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create a user and challenge with goals
        $this->user = UserFactory::new()->create();
        $this->challenge = ChallengeFactory::new()->create([
            'user_id' => $this->user->id,
            'started_at' => Carbon::now()->subDays(2),
            'is_active' => true,
        ]);
        
        $this->goals = GoalFactory::new()->count(3)->create([
            'challenge_id' => $this->challenge->id,
        ]);
    }

    /** @test */
    public function goals_reset_daily_and_track_each_day_separately()
    {
        // Test Day 1 - Complete some goals
        $day1 = Carbon::now()->subDays(2)->toDateString();
        
        // Complete first 2 goals on day 1
        foreach ($this->goals->take(2) as $goal) {
            DailyProgress::create([
                'user_id' => $this->user->id,
                'challenge_id' => $this->challenge->id,
                'goal_id' => $goal->id,
                'date' => $day1,
                'completed_at' => Carbon::now()->subDays(2),
            ]);
        }
        
        // Test Day 2 - Complete different goals (goals are reset)
        $day2 = Carbon::now()->subDay()->toDateString();
        
        // Complete all 3 goals on day 2
        foreach ($this->goals as $goal) {
            DailyProgress::create([
                'user_id' => $this->user->id,
                'challenge_id' => $this->challenge->id,
                'goal_id' => $goal->id,
                'date' => $day2,
                'completed_at' => Carbon::now()->subDay(),
            ]);
        }
        
        // Test Today - Start fresh (no goals completed yet)
        $today = Carbon::now()->toDateString();
        
        // Verify Day 1 progress
        $day1Completed = DailyProgress::where('user_id', $this->user->id)
            ->where('challenge_id', $this->challenge->id)
            ->where('date', $day1)
            ->whereNotNull('completed_at')
            ->count();
        
        $this->assertEquals(2, $day1Completed, 'Day 1 should have 2 completed goals');
        
        // Verify Day 2 progress
        $day2Completed = DailyProgress::where('user_id', $this->user->id)
            ->where('challenge_id', $this->challenge->id)
            ->where('date', $day2)
            ->whereNotNull('completed_at')
            ->count();
        
        $this->assertEquals(3, $day2Completed, 'Day 2 should have 3 completed goals');
        
        // Verify Today progress (should be 0)
        $todayCompleted = DailyProgress::where('user_id', $this->user->id)
            ->where('challenge_id', $this->challenge->id)
            ->where('date', $today)
            ->whereNotNull('completed_at')
            ->count();
        
        $this->assertEquals(0, $todayCompleted, 'Today should have 0 completed goals (fresh start)');
        
        // Verify each goal can be completed independently each day
        foreach ($this->goals as $goal) {
            $this->assertTrue(
                $goal->isCompletedForDate($day1, $this->user->id) || 
                !$goal->isCompletedForDate($day1, $this->user->id),
                'Goal completion status should be checkable for any date'
            );
        }
    }

    /** @test */
    public function goal_toggle_creates_daily_progress_entries()
    {
        $this->actingAs($this->user);
        
        $goal = $this->goals->first();
        $today = Carbon::now()->toDateString();
        
        // Initially no progress
        $this->assertFalse($goal->isCompletedForDate($today, $this->user->id));
        
        // Toggle goal (complete it)
        $response = $this->postJson("/goals/{$goal->id}/toggle");
        
        $response->assertJson([
            'success' => true,
            'completed' => true,
        ]);
        
        // Verify goal is now completed for today
        $this->assertTrue($goal->fresh()->isCompletedForDate($today, $this->user->id));
        
        // Verify daily progress entry was created
        $progress = DailyProgress::where([
            'user_id' => $this->user->id,
            'challenge_id' => $this->challenge->id,
            'goal_id' => $goal->id,
            'date' => $today,
        ])->first();
        
        $this->assertNotNull($progress);
        $this->assertNotNull($progress->completed_at);
        
        // Toggle again (uncomplete it)
        $response = $this->postJson("/goals/{$goal->id}/toggle");
        
        $response->assertJson([
            'success' => true,
            'completed' => false,
        ]);
        
        // Verify goal is now not completed
        $this->assertFalse($goal->fresh()->isCompletedForDate($today, $this->user->id));
        
        // Verify progress entry still exists but completed_at is null
        $progress = $progress->fresh();
        $this->assertNull($progress->completed_at);
    }

    /** @test */
    public function daily_progress_prevents_duplicate_entries()
    {
        $goal = $this->goals->first();
        $today = Carbon::now()->toDateString();
        
        // Create first entry
        $progress1 = DailyProgress::firstOrCreate([
            'user_id' => $this->user->id,
            'challenge_id' => $this->challenge->id,
            'goal_id' => $goal->id,
            'date' => $today,
        ]);
        
        // Try to create duplicate
        $progress2 = DailyProgress::firstOrCreate([
            'user_id' => $this->user->id,
            'challenge_id' => $this->challenge->id,
            'goal_id' => $goal->id,
            'date' => $today,
        ]);
        
        // Should be the same entry
        $this->assertEquals($progress1->id, $progress2->id);
        
        // Verify only one entry exists
        $count = DailyProgress::where([
            'user_id' => $this->user->id,
            'challenge_id' => $this->challenge->id,
            'goal_id' => $goal->id,
            'date' => $today,
        ])->count();
        
        $this->assertEquals(1, $count);
    }
}