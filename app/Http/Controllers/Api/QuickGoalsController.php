<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Domain\Goal\Models\GoalCompletion;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class QuickGoalsController extends Controller
{
    /**
     * Get goals from challenges only (for "Challenges" tab)
     */
    public function index(): View
    {
        $user = auth()->user();
        $today = Carbon::today();
        
        // Get challenge goals only
        $goalSources = $this->aggregateGoalSources($user, $today, 'challenge');
        
        // Get completion status for today
        $completedToday = GoalCompletion::query()
            ->where('user_id', $user->id)
            ->whereDate('date', $today)
            ->whereIn('goal_id', $goalSources->pluck('goal_id'))
            ->pluck('goal_id');
        
        // Map to simple format with completion status
        $challengeGoals = $goalSources->map(function($goal) use ($completedToday) {
            return [
                'goal_id' => $goal['goal_id'],
                'goal_name' => $goal['goal_name'],
                'goal_description' => $goal['goal_description'] ?? null,
                'source_name' => $goal['source_name'] ?? null,
                'is_completed_today' => $completedToday->contains($goal['goal_id']),
            ];
        })->sortBy(function($goal) {
            // Sort: pending first, then completed
            return $goal['is_completed_today'] ? 1 : 0;
        })->values();
        
        return view('dashboard.partials.quick-goals', compact('challengeGoals'));
    }
    
    /**
     * Get all available goals in a simple list format (for "All" tab)
     */
    public function all(): View
    {
        $user = auth()->user();
        $today = Carbon::today();
        
        // Get all goal sources
        $goalSources = $this->aggregateGoalSources($user, $today);
        
        // Get completion status for today
        $completedToday = GoalCompletion::query()
            ->where('user_id', $user->id)
            ->whereDate('date', $today)
            ->whereIn('goal_id', $goalSources->pluck('goal_id'))
            ->pluck('goal_id');
        
        // Map to simple format with completion status
        $allGoals = $goalSources->map(function($goal) use ($completedToday) {
            return [
                'goal_id' => $goal['goal_id'],
                'goal_name' => $goal['goal_name'],
                'goal_description' => $goal['goal_description'] ?? null,
                'source_name' => $goal['source_name'] ?? null,
                'is_completed_today' => $completedToday->contains($goal['goal_id']),
            ];
        })->sortBy(function($goal) {
            // Sort: pending first, then completed
            return $goal['is_completed_today'] ? 1 : 0;
        })->values();
        
        return view('dashboard.partials.quick-all', compact('allGoals'));
    }
    
    /**
     * Aggregate goals from all sources (challenges, habits, library)
     * 
     * @param string|null $filterType Filter by source type: 'challenge', 'habit', 'standalone', or null for all
     */
    private function aggregateGoalSources($user, $today, ?string $filterType = null)
    {
        $goalSources = collect();
        
        // 1. Goals from Active Challenges
        if (!$filterType || $filterType === 'challenge') {
            $activeChallenges = $user->challenges()
                ->where('is_active', true)
                ->where('started_at', '!=', null)
                ->whereNull('completed_at')
                ->with('goals')
                ->get();
                
            foreach ($activeChallenges as $challenge) {
                foreach ($challenge->goals as $goal) {
                    // Skip goals that don't have required data
                    if (!$goal || !$goal->name) {
                        continue;
                    }
                    
                    $goalSources->push([
                        'goal_id' => $goal->id,
                        'goal_name' => $goal->name,
                        'goal_description' => $goal->description ?? '',
                        'source_name' => $challenge->name,
                        'context' => "Challenge: {$challenge->name}",
                        'frequency_info' => $this->getFrequencyInfo($challenge),
                        'challenge_goal_id' => $goal->pivot->id ?? null
                    ]);
                }
            }
        }
        
        // 2. Goals from Active Habits
        if (!$filterType || $filterType === 'habit') {
            $activeHabits = $user->habits()
                ->where('is_active', true)
                ->whereNull('archived_at')
                ->with('goal')
                ->get();
                
            foreach ($activeHabits as $habit) {
                // Skip habits without a valid goal relationship or goal name
                if (!$habit->goal || !$habit->goal->name) {
                    continue;
                }
                
                $goalSources->push([
                    'goal_id' => $habit->goal_id,
                    'goal_name' => $habit->goal->name,
                    'goal_description' => $habit->goal->description,
                    'source_name' => 'Habit',
                    'context' => $this->getHabitFrequencyText($habit),
                    'frequency_info' => $this->getFrequencyInfo($habit),
                    'habit_id' => $habit->id
                ]);
            }
        }
        
        // 3. Standalone Goals from Library (recently used or favorited)
        if (!$filterType || $filterType === 'standalone') {
            $recentGoals = $user->goals()
                ->whereHas('completions', function($query) use ($user) {
                    $query->where('user_id', $user->id)
                        ->where('date', '>=', Carbon::now()->subDays(7));
                })
                ->whereDoesntHave('challenges', function($query) use ($user) {
                    $query->where('user_id', $user->id)
                        ->where('is_active', true);
                })
                ->whereDoesntHave('habits', function($query) use ($user) {
                    $query->where('user_id', $user->id)
                        ->where('is_active', true);
                })
                ->get();
                
            foreach ($recentGoals as $goal) {
                $goalSources->push([
                    'goal_id' => $goal->id,
                    'goal_name' => $goal->name,
                    'goal_description' => $goal->description,
                    'source_name' => 'Personal Goal',
                    'context' => 'From your goal library',
                    'frequency_info' => 'Any time',
                    'library_goal_id' => $goal->id
                ]);
            }
        }
        
        // Make unique by goal_id (same goal only appears once)
        return $goalSources->unique('goal_id');
    }
    
    /**
     * Get human-readable frequency information
     */
    private function getFrequencyInfo($model)
    {
        $type = $model->frequency_type ?? 'daily';
        $count = $model->frequency_count ?? 1;
        
        return match($type) {
            'daily' => 'Daily',
            'weekly' => $count === 1 ? 'Weekly' : "{$count}x per week",
            'monthly' => $count === 1 ? 'Monthly' : "{$count}x per month", 
            'yearly' => $count === 1 ? 'Yearly' : "{$count}x per year",
            default => 'Any time'
        };
    }
    
    /**
     * Get habit frequency display text
     */
    private function getHabitFrequencyText($habit)
    {
        $frequency = $this->getFrequencyInfo($habit);
        return "Habit - {$frequency}";
    }
}
