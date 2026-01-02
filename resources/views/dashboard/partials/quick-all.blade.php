<div data-goal-count="{{ $allGoals->count() }}" style="display: none;"></div>
@if($allGoals->isNotEmpty())
    <div class="grid grid-cols-1 gap-3">
        @foreach($allGoals as $goal)
            <x-goal-card x-data="goalCompletion()"
                         data-goal-id="{{ $goal['goal_id'] }}"
                         data-date="{{ now()->format('Y-m-d') }}"
                         data-completed="{{ $goal['is_completed_today'] ? '1' : '0' }}"
                         @click="toggleCompletion()"
                         :class="isLoading ? 'cursor-wait' : 'cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700/30'"
                         class="transition-colors">
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
                        @if(!empty($goal['goal_description']))
                            {{ $goal['goal_description'] }}
                        @endif
                    </p>
                </x-slot:subtitle>
                
                <x-slot:rightAction>
                    <div class="completion-checkbox"
                         :class="isCompleted ? 'completion-checkbox--completed' : ''">
                        <!-- Completed state -->
                        <svg x-show="isCompleted && !isLoading"
                             class="completion-checkbox__icon completion-checkbox__icon--check"
                             fill="currentColor"
                             viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        <!-- Loading state -->
                        <svg x-show="isLoading"
                             class="completion-checkbox__icon completion-checkbox__icon--loading"
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
    <div class="empty-state">
        <div class="empty-state-icon">
            <svg class="w-16 h-16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
            </svg>
        </div>
        <h3 class="empty-state-title">No Goals Available</h3>
        <p class="empty-state-text">You don't have any active goals right now. Start by creating a challenge or habit.</p>
        <div class="empty-state-action space-x-3">
            <x-ui.app-button href="{{ route('challenges.create') }}" variant="primary">
                <x-slot name="icon">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"/>
                    </svg>
                </x-slot>
                Create Challenge
            </x-ui.app-button>
            <x-ui.app-button href="{{ route('habits.create') }}" variant="secondary">
                <x-slot name="icon">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                        <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm9.707 5.707a1 1 0 00-1.414-1.414L9 12.586l-1.293-1.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                </x-slot>
                Create Habit
            </x-ui.app-button>
        </div>
    </div>
@endif
