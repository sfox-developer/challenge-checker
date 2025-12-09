<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
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

        return view('dashboard.feed.index', compact('activities'));
    }

    /**
     * Toggle like on an activity.
     */
    public function toggleLike(Request $request, Activity $activity): RedirectResponse|JsonResponse
    {
        $liked = $this->activityService->toggleLike($activity, $request->user());
        
        // Refresh the activity to get updated likes count
        $activity->loadCount('likes');

        // Return JSON for AJAX requests
        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'liked' => $liked,
                'likes_count' => $activity->likes_count,
                'message' => $liked ? 'Activity liked!' : 'Activity unliked!'
            ]);
        }

        // Return redirect for traditional form submission
        return back()->with('success', $liked ? 'Activity liked!' : 'Activity unliked!');
    }

    /**
     * Get likes for an activity.
     */
    public function getLikes(Activity $activity): JsonResponse
    {
        $likes = $activity->likes()
            ->with(['user' => function ($query) {
                $query->select('id', 'name', 'email', 'avatar');
            }])
            ->get();

        return response()->json([
            'success' => true,
            'likes' => $likes->map(function ($like) {
                return [
                    'id' => $like->id,
                    'user' => [
                        'id' => $like->user->id,
                        'name' => $like->user->name,
                        'email' => $like->user->email,
                        'avatar_url' => $like->user->getAvatarUrl(),
                        'profile_url' => route('users.show', $like->user)
                    ]
                ];
            }),
            'likes_count' => $likes->count()
        ]);
    }
}
