<div data-goal-count="{{ $habitGoals->count() }}" style="display: none;"></div>
@if($habitGoals->count() > 0)
    <div class="grid grid-cols-1 gap-3">
        @foreach($habitGoals as $goal)
            <x-goal-card
                x-data="goalCompletion()"
                data-goal-id="{{ $goal['goal_id'] }}"
                data-date="{{ now()->format('Y-m-d') }}"
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
        <div class="text-6xl mb-4">📋</div>
        <h3 class="empty-state-title">No Habit Goals</h3>
        <p class="empty-state-text">
            Create a habit to track daily goals
        </p>
        <div class="empty-state-action">
            <a href="{{ route('habits.create') }}" class="btn btn-primary">
                Create Habit
            </a>
        </div>
    </div>
@endif
