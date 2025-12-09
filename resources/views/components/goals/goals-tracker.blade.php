@props(['challenge', 'goals'])

@php
    // Use challenge owner's ID for checking completion status
    $checkUserId = $challenge->user_id;
    
    $completedCount = 0;
    $totalGoals = $goals->count();
    
    foreach($goals as $goal) {
        if ($goal->isCompletedForDate(today()->toDateString(), $checkUserId)) {
            $completedCount++;
        }
    }
    
    $progressPercentage = $totalGoals > 0 ? round(($completedCount / $totalGoals) * 100) : 0;
    $allCompleted = $completedCount === $totalGoals && $totalGoals > 0;
@endphp

@if($goals->isNotEmpty())
    <div class="space-y-4" data-challenge-id="{{ $challenge->id }}">
        <!-- Progress Header -->
        <div class="rounded-lg p-4 border-2 transition-all duration-200 {{ $allCompleted ? 'bg-green-50 dark:bg-green-900/20 border-green-500' : 'bg-blue-50 dark:bg-blue-900/20 border-blue-200 dark:border-blue-800' }}">
            <div class="flex items-center justify-between mb-2">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 {{ $allCompleted ? 'text-green-500' : 'text-slate-600' }}" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span class="font-semibold text-gray-900 dark:text-white">Today's Progress</span>
                </div>
                <span class="text-xs font-semibold {{ $allCompleted ? 'text-green-600 dark:text-green-400' : 'text-slate-700 dark:text-slate-400' }}" data-progress-text>
                    {{ $completedCount }}/{{ $totalGoals }} completed
                </span>
            </div>
            
            <!-- Progress Bar -->
            <div class="bg-gray-200 dark:bg-gray-700 rounded-full h-1.5 overflow-hidden">
                <div class="bg-slate-700 dark:bg-slate-600 h-1.5 rounded-full transition-all duration-300" 
                     data-progress-bar
                     style="width: {{ $progressPercentage }}%">
                </div>
            </div>            @if($allCompleted)
                <div class="mt-2 flex items-center gap-2 text-sm font-medium text-green-600 dark:text-green-400">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                    Perfect! All goals completed! 🎉
                </div>
            @endif
        </div>

        <!-- Goals List -->
        <div class="space-y-2">
            @foreach($goals as $goal)
                @php
                    $isCompleted = $goal->isCompletedForDate(today()->toDateString(), $checkUserId);
                @endphp
                
                <div class="p-4 rounded-lg border-2 transition-all duration-200 
                    {{ $isCompleted ? 'bg-green-50 dark:bg-green-900/20 border-green-500' : 'bg-white dark:bg-gray-700 border-gray-200 dark:border-gray-600 hover:border-blue-300 dark:hover:border-blue-700' }}"
                     data-goal-id="{{ $goal->id }}">
                    <div class="flex items-start gap-3">
                        <!-- Checkbox -->
                        <button type="button" 
                                onclick="toggleGoalInstant({{ $goal->id }})"
                                class="flex-shrink-0 mt-0.5">
                            <div class="w-6 h-6 rounded-md border-2 transition-all duration-200 flex items-center justify-center
                                {{ $isCompleted ? 'bg-slate-700 dark:bg-slate-600 border-slate-700 dark:border-slate-600' : 'border-gray-300 dark:border-gray-500 hover:border-slate-600' }}">
                                @if($isCompleted)
                                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                @endif
                            </div>
                        </button>

                        <!-- Content -->
                        <div class="flex-1 min-w-0">
                            <h5 class="font-semibold text-gray-900 dark:text-white {{ $isCompleted ? 'line-through opacity-75' : '' }}">
                                @if($goal->icon)
                                    <span class="mr-2">{{ $goal->icon }}</span>
                                @endif
                                {{ $goal->name }}
                            </h5>
                            @if($goal->description)
                                <p class="text-sm {{ $isCompleted ? 'text-gray-500 dark:text-gray-500 line-through opacity-75' : 'text-gray-600 dark:text-gray-400' }} mt-1">
                                    {{ Str::limit($goal->description, 80) }}
                                </p>
                            @endif
                        </div>
                        
                        <!-- Completed Badge -->
                        @if($isCompleted)
                            <span class="flex-shrink-0 text-xs font-semibold text-green-600 dark:text-green-400">
                                ✓ Done
                            </span>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@else
    <div class="text-center py-8">
        <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
        </svg>
        <h3 class="text-lg font-medium text-gray-800 dark:text-gray-100 mb-2">No goals yet</h3>
        <p class="text-gray-600 dark:text-gray-400">Start by adding some goals to track!</p>
    </div>
@endif

