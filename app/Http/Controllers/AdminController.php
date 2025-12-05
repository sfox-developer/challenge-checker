<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Domain\User\Models\User;
use App\Domain\Challenge\Models\Challenge;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!auth()->check() || !auth()->user()->is_admin) {
                abort(403, 'Access denied');
            }
            return $next($request);
        });
    }

    /**
     * Show admin dashboard with all users
     */
    public function dashboard(): View
    {
        $users = User::withCount(['challenges', 'challenges as completed_challenges_count' => function ($query) {
                $query->whereNotNull('completed_at');
            }, 'challenges as active_challenges_count' => function ($query) {
                $query->whereNotNull('started_at')
                      ->whereNull('completed_at')
                      ->where('is_active', true);
            }])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.dashboard', compact('users'));
    }

    /**
     * Show user details with their challenges
     */
    public function showUser(User $user): View
    {
        $user->load(['challenges.goals.dailyProgress' => function ($query) {
            $query->orderBy('date', 'desc');
        }]);

        $user->loadCount([
            'followers', 
            'following', 
            'habits',
            'goalsLibrary',
            'activities'
        ]);

        return view('admin.user-details', compact('user'));
    }

    /**
     * Delete a user and all their data permanently
     */
    public function deleteUser(User $user)
    {
        // Prevent admin from deleting themselves
        if ($user->id === auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'You cannot delete your own account.'
            ], 403);
        }

        // Prevent deletion of other admin users
        if ($user->is_admin) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete admin users.'
            ], 403);
        }

        try {
            $userName = $user->name;
            
            // Laravel will cascade delete related records based on foreign key constraints
            // This includes: challenges, habits, activities, goal library, follows, activity likes, etc.
            $user->delete();

            return response()->json([
                'success' => true,
                'message' => "User '{$userName}' and all their data have been permanently deleted."
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while deleting the user. Please try again.'
            ], 500);
        }
    }
}
