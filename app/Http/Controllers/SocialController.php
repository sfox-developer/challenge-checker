<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Domain\User\Models\User;

class SocialController extends Controller
{
    /**
     * Follow a user.
     */
    public function follow(Request $request, User $user): RedirectResponse
    {
        $currentUser = $request->user();
        
        if ($currentUser->id === $user->id) {
            return back()->with('error', 'You cannot follow yourself.');
        }

        if ($currentUser->isFollowing($user)) {
            return back()->with('info', 'You are already following this user.');
        }

        $currentUser->follow($user);

        return back()->with('success', "You are now following {$user->name}!");
    }

    /**
     * Unfollow a user.
     */
    public function unfollow(Request $request, User $user): RedirectResponse
    {
        $currentUser = $request->user();
        
        if (!$currentUser->isFollowing($user)) {
            return back()->with('info', 'You are not following this user.');
        }

        $currentUser->unfollow($user);

        return back()->with('success', "You have unfollowed {$user->name}.");
    }
}
