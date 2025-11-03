<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Domain\Challenge\Models\Challenge;
use App\Http\Requests\StoreChallengeRequest;
use App\Http\Requests\UpdateChallengeRequest;

class ChallengeController extends Controller
{
    /**
     * Display a listing of the user's challenges.
     */
    public function index(): View
    {
        $challenges = auth()->user()->challenges()
            ->with('goals')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('challenges.index', compact('challenges'));
    }

    /**
     * Show the form for creating a new challenge.
     */
    public function create(): View
    {
        return view('challenges.create');
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
        ]);

        // Create goals
        if ($request->has('goals')) {
            foreach ($request->goals as $index => $goalData) {
                $challenge->goals()->create([
                    'name' => $goalData['name'],
                    'description' => $goalData['description'] ?? null,
                    'order' => $index + 1,
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

        return redirect()->route('challenges.show', $challenge)
            ->with('success', 'Congratulations! Challenge completed! 🎉');
    }
}
