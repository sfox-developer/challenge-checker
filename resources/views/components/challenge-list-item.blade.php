@props(['challenge', 'adminView' => false])

<a href="{{ $adminView ? route('admin.challenge', $challenge) : route('challenges.show', $challenge) }}" 
   class="card card-link group">
    <div class="flex items-center gap-4">
        <!-- Icon (if challenge has a primary goal with icon) -->
        @if($challenge->goals->first()?->icon)
            <div class="flex-shrink-0 w-12 h-12 bg-slate-100 dark:bg-slate-900 rounded-lg flex items-center justify-center text-slate-700 dark:text-slate-400 text-2xl">
                {{ $challenge->goals->first()->icon }}
            </div>
        @endif
        
        <!-- Content -->
        <div class="flex-1 min-w-0">
            <!-- Header with Badge -->
            <div class="flex items-start justify-between gap-3 mb-2">
                <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100 group-hover:text-slate-700 dark:group-hover:text-slate-400 transition-colors">
                    {{ $challenge->name }}
                </h4>
                
                <!-- Status Badge -->
                @if($challenge->isArchived())
                    <span class="badge-challenge-archived flex-shrink-0">📁 Archived</span>
                @elseif($challenge->completed_at)
                    <span class="badge-completed flex-shrink-0">✓ Completed</span>
                @elseif($challenge->is_active)
                    <span class="badge-challenge-active flex-shrink-0">🏃 Active</span>
                @elseif($challenge->started_at)
                    <span class="badge-challenge-paused flex-shrink-0">⏸️ Paused</span>
                @else
                    <span class="badge-challenge-draft flex-shrink-0">📝 Draft</span>
                @endif
            </div>
            
            <!-- Description -->
            @if($challenge->description)
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-3">
                    {{ Str::limit($challenge->description, 100) }}
                </p>
            @endif
            
            <!-- Stats Row -->
            <div class="flex items-center gap-4 text-xs text-gray-500 dark:text-gray-400">
                <span class="flex items-center gap-1">
                    📅 {{ $challenge->days_duration }} {{ Str::plural('day', $challenge->days_duration) }}
                </span>
                @if($challenge->started_at)
                    <span class="flex items-center gap-1 font-medium">
                        ✓ {{ $challenge->getCompletedDaysCount() }} / {{ $challenge->days_duration }}
                    </span>
                @endif
                <span>{{ $challenge->goals->count() }} {{ Str::plural('goal', $challenge->goals->count()) }}</span>
            </div>
        </div>
        
        <!-- Arrow -->
        <div class="flex-shrink-0">
            <svg class="w-5 h-5 text-gray-400 group-hover:text-slate-600 dark:group-hover:text-slate-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </div>
    </div>
</a>
