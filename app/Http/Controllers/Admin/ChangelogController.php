<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Domain\Admin\Models\Changelog;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ChangelogController extends Controller
{
    public function __construct()
    {
        // Only admin methods need authentication check
        $this->middleware(function ($request, $next) {
            if (!in_array($request->route()->getName(), ['changelog'])) {
                if (!auth()->check() || !auth()->user()->is_admin) {
                    abort(403, 'Access denied');
                }
            }
            return $next($request);
        });
    }

    /**
     * Display a listing of changelogs (public view).
     */
    public function index(): View
    {
        $changelogs = Changelog::published()->latest()->paginate(10);

        return view('changelog', compact('changelogs'));
    }

    /**
     * Display a listing of changelogs for admin management.
     */
    public function adminIndex(): View
    {
        $changelogs = Changelog::latest()->paginate(20);

        return view('admin.changelogs.index', compact('changelogs'));
    }

    /**
     * Show the form for creating a new changelog.
     */
    public function create(): View
    {
        return view('admin.changelogs.create');
    }

    /**
     * Store a newly created changelog in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'version' => 'required|string|max:50',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'changes' => 'required|string',
            'release_date' => 'required|date',
        ]);

        $validated['is_published'] = $request->has('is_published');
        $validated['is_major'] = $request->has('is_major');

        $changelog = Changelog::create($validated);

        return redirect()->route('admin.changelogs.index')
            ->with('success', 'Changelog created successfully!');
    }

    /**
     * Show the form for editing the specified changelog.
     */
    public function edit(Changelog $changelog): View
    {
        return view('admin.changelogs.edit', compact('changelog'));
    }

    /**
     * Update the specified changelog in storage.
     */
    public function update(Request $request, Changelog $changelog): RedirectResponse
    {
        $validated = $request->validate([
            'version' => 'required|string|max:50',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'changes' => 'required|string',
            'release_date' => 'required|date',
        ]);

        $validated['is_published'] = $request->has('is_published');
        $validated['is_major'] = $request->has('is_major');

        $changelog->update($validated);

        return redirect()->route('admin.changelogs.index')
            ->with('success', 'Changelog updated successfully!');
    }

    /**
     * Remove the specified changelog from storage.
     */
    public function destroy(Changelog $changelog): RedirectResponse
    {
        $changelog->delete();

        return redirect()->route('admin.changelogs.index')
            ->with('success', 'Changelog deleted successfully!');
    }
}
