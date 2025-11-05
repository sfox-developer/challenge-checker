<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class QuickGoalsController extends Controller
{
    /**
     * Get active challenges with today's goals for quick completion
     */
    public function index(): View
    {
        $user = auth()->user();
        
        $activeChallenges = $user->challenges()
            ->where('is_active', true)
            ->where('started_at', '!=', null)
            ->whereNull('completed_at')
            ->with('goals')
            ->get();

        return view('partials.quick-goals', compact('activeChallenges'));
    }
}
