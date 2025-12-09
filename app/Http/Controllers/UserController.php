<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Domain\User\Models\User;

class UserController extends Controller
{
    /**
     * Display user search/discovery page.
     * Shows random active users when no search query provided.
     */
    public function search(Request $request): View
    {
        $query = $request->input('query');
        $currentUser = $request->user();
        
        $users = collect();
        
        if ($query && strlen($query) >= 2) {
            // Search mode: find users matching query
            $users = User::where('id', '!=', $currentUser->id)
                ->where(function ($q) use ($query) {
                    $q->where('name', 'LIKE', "%{$query}%")
                      ->orWhere('email', 'LIKE', "%{$query}%");
                })
                ->withCount(['followers', 'following'])
                ->limit(20)
                ->get();
        } else {
            // Discovery mode: show random active users
            // Prioritize users with recent activity and public challenges
            $users = User::where('id', '!=', $currentUser->id)
                ->whereHas('activities', function ($q) {
                    $q->where('created_at', '>=', now()->subDays(30));
                })
                ->withCount(['followers', 'following', 'challenges'])
                ->inRandomOrder()
                ->limit(12)
                ->get();
                
            // If not enough active users, fill with any users
            if ($users->count() < 12) {
                $additionalUsers = User::where('id', '!=', $currentUser->id)
                    ->whereNotIn('id', $users->pluck('id'))
                    ->withCount(['followers', 'following', 'challenges'])
                    ->inRandomOrder()
                    ->limit(12 - $users->count())
                    ->get();
                    
                $users = $users->merge($additionalUsers);
            }
        }

        return view('dashboard.users.search', compact('users', 'query'));
    }

    /**
     * Display user profile.
     */
    public function show(Request $request, User $user): View
    {
        $currentUser = $request->user();
        
        $user->loadCount(['followers', 'following', 'challenges', 'habits']);
        
        $publicChallenges = $user->challenges()
            ->where('is_public', true)
            ->latest()
            ->paginate(10, ['*'], 'challenges_page');

        $publicHabits = $user->habits()
            ->where('is_public', true)
            ->whereNull('archived_at')
            ->with(['goal', 'statistics'])
            ->latest()
            ->paginate(10, ['*'], 'habits_page');

        $activities = $user->activities()
            ->with(['user', 'challenge', 'goal'])
            ->withCount('likes')
            ->with([
                'likes.user' => function ($query) {
                    $query->select('id', 'name', 'email', 'avatar');
                }
            ])
            ->latest()
            ->paginate(10, ['*'], 'activities_page');

        $isFollowing = $currentUser->isFollowing($user);

        return view('dashboard.users.show', compact('user', 'publicChallenges', 'publicHabits', 'activities', 'isFollowing'));
    }
}
