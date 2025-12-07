@props(['challenge', 'adminView' => false])

<div class="card card-hover">
    <!-- Challenge Header -->
    <div class="flex items-start justify-between mb-4">
        <div class="flex-1">
            <h4 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-2">{{ $challenge->name }}</h4>
            @if($challenge->description)
                <p class="text-gray-700 dark:text-gray-100 mb-3">{{ Str::limit($challenge->description, 150) }}</p>
            @endif
        </div>
        <a href="{{ $adminView ? route('admin.challenge', $challenge) : route('challenges.show', $challenge) }}" 
           class="ml-4 text-blue-600 hover:text-blue-500 font-medium whitespace-nowrap">
            View →
        </a>
    </div>

    <!-- Challenge Stats -->
    <div class="flex flex-wrap items-center gap-3 pt-4 border-t border-gray-100 dark:border-gray-700">
        <div class="challenge-stat-item">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <span>{{ $challenge->days_duration }} {{ Str::plural('day', $challenge->days_duration) }}</span>
        </div>
        @if($challenge->started_at)
            <div class="challenge-stat-item">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span>{{ $challenge->getCompletedDaysCount() }} / {{ $challenge->days_duration }} completed</span>
            </div>
        @endif
        @if($challenge->completed_at)
            <span class="badge-completed">✓ Completed</span>
        @elseif($challenge->is_active)
            <span class="badge-challenge-active">Active</span>
        @elseif($challenge->started_at)
            <span class="badge-challenge-paused">Paused</span>
        @else
            <span class="badge-challenge-draft">Not Started</span>
        @endif
    </div>
</div>
