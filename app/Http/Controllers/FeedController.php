<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Domain\Activity\Models\Activity;
use App\Domain\Activity\Services\ActivityService;

class FeedController extends Controller
{
    public function __construct(
        private ActivityService $activityService
    ) {}

    /**
     * Display the activity feed.
     */
    public function index(Request $request): View
    {
        $user = $request->user();
        
        $activities = Activity::feed($user)
            ->withCount('likes')
            ->with([
                'likes.user' => function ($query) {
                    $query->select('id', 'name', 'email', 'avatar');
                }
            ])
            ->paginate(20);

        return view('feed.index', compact('activities'));
    }

    /**
     * Toggle like on an activity.
     */
    public function toggleLike(Request $request, Activity $activity): RedirectResponse
    {
        $liked = $this->activityService->toggleLike($activity, $request->user());

        return back()->with('success', $liked ? 'Activity liked!' : 'Activity unliked!');
    }
}
