<div data-goal-count="{{ $challengeGoals->count() }}" style="display: none;"></div>
@if($challengeGoals->count() > 0)
    <div class="grid grid-cols-1 gap-3">
        @foreach($challengeGoals as $goal)
            <x-goal-card
                x-data="goalCompletion()"
                data-goal-id="{{ $goal['goal_id'] }}"
                data-date="{{ now()->format('Y-m-d') }}"
                data-source-type="{{ $goal['source_type'] }}"
                data-source-id="{{ $goal['source_id'] ?? '' }}"
                data-completed="{{ $goal['is_completed_today'] ? '1' : '0' }}"
                @click="toggleCompletion()"
                :class="isLoading ? 'cursor-wait' : 'cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700/30'"
                class="transition-colors"
            >
                <x-slot:icon>
                    <div class="goal-display-card-icon">🎯</div>
                </x-slot:icon>
                
                <x-slot:title>
                    <h5 class="goal-display-card-title" 
                        :class="isCompleted ? 'line-through opacity-75' : ''">
                        {{ $goal['goal_name'] }}
                    </h5>
                </x-slot:title>
                
                <x-slot:subtitle>
                    <p class="goal-display-card-description">
                        <span class="inline-flex items-center px-2 py-0.5 text-xs font-medium rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300">
                            Challenge
                        </span>
                        @if(!empty($goal['goal_description']))
                            <span class="ml-1">{{ $goal['goal_description'] }}</span>
                        @endif
                    </p>
                </x-slot:subtitle>
                
                <x-slot:rightAction>
                    <div class="flex-shrink-0 w-7 h-7 rounded-full border-2 flex items-center justify-center transition-all duration-200"
                         :class="isCompleted ? 'bg-green-600 border-green-600' : 'border-gray-300 dark:border-gray-500'">
                        <!-- Completed state -->
                        <svg x-show="isCompleted && !isLoading"
                             class="w-4 h-4 text-white"
                             fill="currentColor"
                             viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        <!-- Loading state -->
                        <svg x-show="isLoading"
                             class="animate-spin w-4 h-4 text-gray-400"
                             fill="none"
                             viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </div>
                </x-slot:rightAction>
            </x-goal-card>
        @endforeach
    </div>
@else
    <div class="text-center py-12">
        <div class="text-6xl mb-4">🎯</div>
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">No Challenge Goals</h3>
        <p class="text-gray-600 dark:text-gray-400 mb-4">
            Start a challenge to see goals here
        </p>
        <a href="{{ route('challenges.index') }}" 
           class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
            Browse Challenges
        </a>
    </div>
@endif
