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

        return view('admin.user-details', compact('user'));
    }
}
