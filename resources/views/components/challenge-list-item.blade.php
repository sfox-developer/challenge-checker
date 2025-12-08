@props(['challenge', 'adminView' => false])

<a href="{{ $adminView ? route('admin.challenge', $challenge) : route('challenges.show', $challenge) }}" 
   class="card card-link group">
    <div class="flex items-center gap-4">
        <!-- Content -->
        <div class="flex-1 min-w-0">
            <!-- Header with Badge -->
            <div class="flex items-start justify-between gap-3 mb-2">
                <h4 class="h4 h4-card group-hover:text-slate-700 dark:group-hover:text-slate-400 transition-colors">
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
                <div class="challenge-stat-item">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <span>{{ $challenge->days_duration }} {{ Str::plural('day', $challenge->days_duration) }}</span>
                </div>
                @if($challenge->started_at)
                    <div class="challenge-stat-item">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="font-medium">{{ $challenge->getCompletedDaysCount() }} / {{ $challenge->days_duration }}</span>
                    </div>
                @endif
                <div class="challenge-stat-item">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M5 4a1 1 0 00-2 0v7.268a2 2 0 000 3.464V16a1 1 0 102 0v-1.268a2 2 0 000-3.464V4zM11 4a1 1 0 10-2 0v1.268a2 2 0 000 3.464V16a1 1 0 102 0V8.732a2 2 0 000-3.464V4zM16 3a1 1 0 011 1v7.268a2 2 0 010 3.464V16a1 1 0 11-2 0v-1.268a2 2 0 010-3.464V4a1 1 0 011-1z"/>
                    </svg>
                    <span>{{ $challenge->goals->count() }} {{ Str::plural('goal', $challenge->goals->count()) }}</span>
                </div>
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
