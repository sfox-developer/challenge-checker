@props(['habit', 'adminView' => false])

<a href="{{ route('habits.show', $habit) }}" class="habit-list-item group">
    <div class="flex items-center gap-4">
        <!-- Icon -->
        <div class="flex-shrink-0 w-12 h-12 bg-slate-100 dark:bg-slate-900 rounded-lg flex items-center justify-center text-slate-700 dark:text-slate-400 text-2xl">
            {{ $habit->goal->icon ?? '✓' }}
        </div>
        
        <!-- Content -->
        <div class="flex-1 min-w-0">
            <div class="flex items-start justify-between gap-3 mb-2">
                <h4 class="h4 h4-card group-hover:text-slate-700 dark:group-hover:text-slate-400 transition-colors">
                    {{ $habit->goal->name }}
                </h4>
                
                <!-- Status Badge -->
                @if($habit->isArchived())
                    <span class="status-archived flex-shrink-0">Archived</span>
                @elseif($habit->isCompletedToday())
                    <span class="status-completed flex-shrink-0">Completed</span>
                @elseif($habit->is_active)
                    <span class="status-active flex-shrink-0">Active</span>
                @else
                    <span class="status-paused flex-shrink-0">Paused</span>
                @endif
            </div>
            
            <!-- Frequency -->
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-3">
                {{ $habit->getFrequencyDescription() }}
            </p>
            
            <!-- Stats Row -->
            <div class="flex items-center gap-4 text-xs text-gray-500 dark:text-gray-400">
                @if($habit->statistics && $habit->statistics->current_streak > 0)
                    <span class="flex items-center gap-1 font-medium">
                        🔥 {{ $habit->statistics->current_streak }} {{ Str::plural('day', $habit->statistics->current_streak) }} streak
                    </span>
                @endif
                @if($habit->statistics)
                    <span>{{ $habit->statistics->total_completions }} {{ Str::plural('completion', $habit->statistics->total_completions) }}</span>
                @endif
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
