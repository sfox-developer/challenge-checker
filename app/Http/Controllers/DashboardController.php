<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Domain\Challenge\Models\Challenge;
use App\Domain\Challenge\Models\DailyProgress;

class DashboardController extends Controller
{
    /**
     * Display the main dashboard.
     */
    public function index(): View
    {
        $user = auth()->user();
        
        // Get active challenges
        $activeChallenges = $user->challenges()
            ->where('is_active', true)
            ->with(['goals', 'dailyProgress'])
            ->get();

        // Get recent challenges (completed or inactive)
        $recentChallenges = $user->challenges()
            ->where('is_active', false)
            ->orderBy('updated_at', 'desc')
            ->limit(3)
            ->with('goals')
            ->get();

        // Calculate statistics
        $totalChallenges = $user->challenges()->count();
        $completedChallenges = $user->challenges()->whereNotNull('completed_at')->count();
        
        // Get today's progress for active challenges
        $todayProgress = collect();
        $today = now()->toDateString();
        
        foreach ($activeChallenges as $challenge) {
            $goalsCompletedToday = DailyProgress::where('user_id', $user->id)
                ->where('challenge_id', $challenge->id)
                ->where('date', $today)
                ->whereNotNull('completed_at')
                ->count();
                
            $totalGoals = $challenge->goals->count();
            
            $todayProgress->push([
                'challenge' => $challenge,
                'completed' => $goalsCompletedToday,
                'total' => $totalGoals,
                'percentage' => $totalGoals > 0 ? ($goalsCompletedToday / $totalGoals) * 100 : 0
            ]);
        }

        // Calculate streak (consecutive days with at least one goal completed)
        $currentStreak = $this->calculateCurrentStreak($user->id);

        return view('dashboard', compact(
            'activeChallenges',
            'recentChallenges',
            'totalChallenges',
            'completedChallenges',
            'todayProgress',
            'currentStreak'
        ));
    }

    /**
     * Calculate the current streak of consecutive days with completed goals.
     */
    private function calculateCurrentStreak(int $userId): int
    {
        $streak = 0;
        $currentDate = now();

        while (true) {
            $dateString = $currentDate->toDateString();
            
            $hasProgress = DailyProgress::where('user_id', $userId)
                ->where('date', $dateString)
                ->whereNotNull('completed_at')
                ->exists();

            if ($hasProgress) {
                $streak++;
                $currentDate->subDay();
            } else {
                break;
            }

            // Prevent infinite loop
            if ($streak > 365) break;
        }

        return $streak;
    }
}
