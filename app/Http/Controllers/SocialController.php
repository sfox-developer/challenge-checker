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
    public function follow(Request $request, User $user): RedirectResponse|\Illuminate\Http\JsonResponse
    {
        $currentUser = $request->user();
        
        if ($currentUser->id === $user->id) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'You cannot follow yourself.'], 400);
            }
            return back()->with('error', 'You cannot follow yourself.');
        }

        if ($currentUser->isFollowing($user)) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'You are already following this user.'], 400);
            }
            return back()->with('info', 'You are already following this user.');
        }

        $currentUser->follow($user);

        if ($request->expectsJson()) {
            return response()->json([
                'message' => "You are now following {$user->name}!",
                'isFollowing' => true,
                'followersCount' => $user->followers()->count()
            ]);
        }

        return back()->with('success', "You are now following {$user->name}!");
    }

    /**
     * Unfollow a user.
     */
    public function unfollow(Request $request, User $user): RedirectResponse|\Illuminate\Http\JsonResponse
    {
        $currentUser = $request->user();
        
        if (!$currentUser->isFollowing($user)) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'You are not following this user.'], 400);
            }
            return back()->with('info', 'You are not following this user.');
        }

        $currentUser->unfollow($user);

        if ($request->expectsJson()) {
            return response()->json([
                'message' => "You have unfollowed {$user->name}.",
                'isFollowing' => false,
                'followersCount' => $user->followers()->count()
            ]);
        }

        return back()->with('success', "You have unfollowed {$user->name}.");
    }
}
