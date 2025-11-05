<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Domain\User\Models\User;

class UserController extends Controller
{
    /**
     * Display user search page.
     */
    public function search(Request $request): View
    {
        $query = $request->input('query');
        $currentUser = $request->user();
        
        $users = collect();
        
        if ($query && strlen($query) >= 2) {
            $users = User::where('id', '!=', $currentUser->id)
                ->where(function ($q) use ($query) {
                    $q->where('name', 'LIKE', "%{$query}%")
                      ->orWhere('email', 'LIKE', "%{$query}%");
                })
                ->withCount(['followers', 'following'])
                ->limit(20)
                ->get();
        }

        return view('users.search', compact('users', 'query'));
    }

    /**
     * Display user profile.
     */
    public function show(Request $request, User $user): View
    {
        $currentUser = $request->user();
        
        $user->loadCount(['followers', 'following', 'challenges']);
        
        $publicChallenges = $user->challenges()
            ->where('is_public', true)
            ->latest()
            ->paginate(10, ['*'], 'challenges_page');

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

        return view('users.show', compact('user', 'publicChallenges', 'activities', 'isFollowing'));
    }
}
