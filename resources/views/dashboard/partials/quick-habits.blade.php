@if($todaysHabits->isNotEmpty())
    <div class="space-y-3">
        @foreach($todaysHabits as $habit)
            @php
                $isCompleted = $habit->isCompletedToday();
                $progress = $habit->getCompletionCountForPeriod();
                $target = $habit->frequency_count;
            @endphp
            
            <div class="p-4 rounded-lg border-2 transition-all duration-200
                {{ $isCompleted ? 'bg-blue-50 dark:bg-blue-900/20 border-slate-600' : 'bg-white dark:bg-gray-700 border-gray-200 dark:border-gray-600 hover:border-blue-300 dark:hover:border-blue-700' }}"
                 data-habit-id="{{ $habit->id }}">
                <div class="flex items-start gap-3">
                    <!-- Checkbox -->
                    <button type="button" 
                            onclick="toggleHabit({{ $habit->id }}, '{{ date('Y-m-d') }}', this)"
                            class="flex-shrink-0 mt-0.5">
                        <div class="w-6 h-6 rounded-md border-2 transition-all duration-200 flex items-center justify-center
                            {{ $isCompleted ? 'bg-slate-600 border-slate-600' : 'border-gray-300 dark:border-gray-500 hover:border-slate-600' }}">
                            @if($isCompleted)
                                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            @endif
                        </div>
                    </button>

                    <!-- Content -->
                    <div class="flex-1 min-w-0">
                        <div class="flex items-start justify-between gap-2">
                            <div class="flex-1">
                                <h5 class="font-semibold text-gray-900 dark:text-white mb-1">
                                    {{ $habit->goal->icon ?? '✓' }} {{ $habit->goal_name }}
                                </h5>
                                @if($habit->description)
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">{{ Str::limit($habit->description, 80) }}</p>
                                @endif
                            </div>

                            <!-- Streak badge -->
                            @if($habit->statistics && $habit->statistics->current_streak > 0)
                                <span class="streak-badge flex-shrink-0">
                                    {{ $habit->statistics->current_streak }}
                                </span>
                            @endif
                        </div>

                        <!-- Progress for frequency > 1 -->
                        @if($target > 1)
                            <div class="mt-2" data-progress-container>
                                <div class="flex items-center justify-between text-xs text-gray-600 dark:text-gray-400 mb-1">
                                    <span>{{ $habit->getFrequencyDescription() }}</span>
                                    <span class="font-semibold {{ $progress >= $target ? 'text-slate-700 dark:text-slate-400' : '' }}" data-progress-text>
                                        {{ $progress }}/{{ $target }}
                                    </span>
                                </div>
                                <div class="w-full bg-gray-200 dark:bg-gray-600 rounded-full h-1.5">
                                    <div class="bg-slate-600 h-1.5 rounded-full transition-all duration-300" 
                                         data-progress-bar
                                         style="width: {{ min(100, ($progress / $target) * 100) }}%">
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@else
    <div class="empty-state">
        <div class="empty-state-icon">
            <svg class="w-16 h-16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
            </svg>
        </div>
        <h3 class="empty-state-title">No habits due today</h3>
        <p class="empty-state-message">You're all caught up! 🎉</p>
        <div class="empty-state-action">
            <x-ui.app-button href="{{ route('habits.create') }}">
                <x-slot name="icon">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"/>
                    </svg>
                </x-slot>
                Create Your First Habit
            </x-ui.app-button>
        </div>
@endif
