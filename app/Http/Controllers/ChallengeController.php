<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Domain\Challenge\Models\Challenge;
use App\Domain\Goal\Models\GoalLibrary;
use App\Domain\Goal\Models\Category;
use App\Domain\Activity\Services\ActivityService;
use App\Http\Requests\StoreChallengeRequest;
use App\Http\Requests\UpdateChallengeRequest;

class ChallengeController extends Controller
{
    public function __construct(
        private ActivityService $activityService
    ) {}
    /**
     * Display a listing of the user's challenges.
     */
    public function index(): View
    {
        $challenges = auth()->user()->challenges()
            ->with('goals')
            ->orderBy('created_at', 'desc')
            ->get();

        // Check and auto-complete expired challenges
        foreach ($challenges as $challenge) {
            $challenge->checkAndAutoComplete();
        }

        // Calculate statistics
        $totalChallenges = $challenges->count();
        $activeChallenges = $challenges->where('started_at', '!=', null)
            ->where('completed_at', null)
            ->where('is_active', true)
            ->count();

        return view('challenges.index', compact('challenges', 'totalChallenges', 'activeChallenges'));
    }

    /**
     * Show the form for creating a new challenge.
     */
    public function create(): View
    {
        $goalsLibrary = auth()->user()->goalsLibrary()
            ->with('category')
            ->orderBy('name')
            ->get();

        $categories = Category::active()->ordered()->get();

        return view('challenges.create', compact('goalsLibrary', 'categories'));
    }

    /**
     * Store a newly created challenge in storage.
     */
    public function store(StoreChallengeRequest $request): RedirectResponse
    {
        $challenge = auth()->user()->challenges()->create([
            'name' => $request->name,
            'description' => $request->description,
            'days_duration' => $request->days_duration,
            'is_public' => $request->boolean('is_public'),
        ]);

        // Create goals from library or new goals
        if ($request->has('goal_library_ids')) {
            foreach ($request->goal_library_ids as $index => $goalLibraryId) {
                $goalLibrary = GoalLibrary::find($goalLibraryId);
                if ($goalLibrary) {
                    $challenge->goals()->create([
                        'goal_library_id' => $goalLibrary->id,
                        'name' => $goalLibrary->name,
                        'description' => $goalLibrary->description,
                        'order' => $index + 1,
                    ]);
                }
            }
        }
        
        // Create new goals that will be added to library
        if ($request->has('new_goals')) {
            foreach ($request->new_goals as $index => $newGoalData) {
                // Create in goal library first
                $goalLibrary = GoalLibrary::create([
                    'user_id' => auth()->id(),
                    'name' => $newGoalData['name'],
                    'description' => $newGoalData['description'] ?? null,
                    'icon' => $newGoalData['icon'] ?? null,
                    'category_id' => $newGoalData['category_id'] ?? null,
                ]);
                
                // Then link to challenge
                $challenge->goals()->create([
                    'goal_library_id' => $goalLibrary->id,
                    'name' => $goalLibrary->name,
                    'description' => $goalLibrary->description,
                    'order' => count($request->goal_library_ids ?? []) + $index + 1,
                ]);
            }
        }

        return redirect()->route('challenges.show', $challenge)
            ->with('success', 'Challenge created successfully!');
    }

    /**
     * Display the specified challenge.
     */
    public function show(Challenge $challenge): View
    {
        $this->authorize('view', $challenge);

        // Check and auto-complete if expired
        if ($challenge->checkAndAutoComplete()) {
            $challenge->refresh();
        }

        // Store current URL as potential back URL for edit
        session(['challenge_back_url' => url()->previous()]);

        $challenge->load(['goals', 'dailyProgress']);
        
        // Calculate progress statistics
        $totalDays = $challenge->days_duration;
        $totalGoals = $challenge->goals->count();
        $progressPercentage = $challenge->getProgressPercentage();

        return view('challenges.show', compact('challenge', 'totalDays', 'totalGoals', 'progressPercentage'));
    }

    /**
     * Show the form for editing the specified challenge.
     */
    public function edit(Challenge $challenge): View
    {
        $this->authorize('update', $challenge);

        return view('challenges.edit', compact('challenge'));
    }

    /**
     * Update the specified challenge in storage.
     */
    public function update(UpdateChallengeRequest $request, Challenge $challenge): RedirectResponse
    {
        $this->authorize('update', $challenge);

        $challenge->update([
            'name' => $request->name,
            'description' => $request->description,
            'days_duration' => $request->days_duration,
            'is_public' => $request->boolean('is_public'),
        ]);

        // Redirect back to where user came from (challenge show or challenges index)
        $backUrl = $request->input('back', route('challenges.show', $challenge));
        
        return redirect($backUrl)
            ->with('success', 'Challenge updated successfully!');
    }

    /**
     * Remove the specified challenge from storage.
     */
    public function destroy(Challenge $challenge): RedirectResponse
    {
        $this->authorize('delete', $challenge);

        $challenge->delete();

        return redirect()->route('challenges.index')
            ->with('success', 'Challenge deleted successfully!');
    }

    /**
     * Start the specified challenge.
     */
    public function start(Challenge $challenge): RedirectResponse
    {
        $this->authorize('update', $challenge);

        $challenge->start();
        
        // Create activity
        $this->activityService->createChallengeStartedActivity($challenge);

        return redirect()->route('challenges.show', $challenge)
            ->with('success', 'Challenge started! Good luck!');
    }

    /**
     * Pause the specified challenge.
     */
    public function pause(Challenge $challenge): RedirectResponse
    {
        $this->authorize('update', $challenge);

        $challenge->pause();
        
        // Create activity
        $this->activityService->createChallengePausedActivity($challenge);

        return redirect()->route('challenges.show', $challenge)
            ->with('success', 'Challenge paused. You can resume anytime!');
    }

    /**
     * Resume the specified challenge.
     */
    public function resume(Challenge $challenge): RedirectResponse
    {
        $this->authorize('update', $challenge);

        $challenge->resume();
        
        // Create activity
        $this->activityService->createChallengeResumedActivity($challenge);

        return redirect()->route('challenges.show', $challenge)
            ->with('success', 'Challenge resumed! Keep going!');
    }

    /**
     * Complete the specified challenge.
     */
    public function complete(Challenge $challenge): RedirectResponse
    {
        $this->authorize('update', $challenge);

        $challenge->complete();
        
        // Create activity
        $this->activityService->createChallengeCompletedActivity($challenge);

        return redirect()->route('challenges.show', $challenge)
            ->with('success', 'Congratulations! Challenge completed! 🎉');
    }
}
