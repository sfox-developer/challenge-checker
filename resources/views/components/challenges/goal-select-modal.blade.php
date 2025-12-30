@props(['goals'])

<!-- Goal Selection Modal -->
<div x-show="showGoalSelectModal" 
     x-cloak
     @keydown.escape.window="showGoalSelectModal && closeGoalSelectModal()"
     class="modal-wrapper">
    
    {{-- Backdrop --}}
    <div x-show="showGoalSelectModal"
         @click="closeGoalSelectModal()"
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="modal-backdrop"></div>
    
    {{-- Modal Content --}}
    <div @click.stop 
         x-show="showGoalSelectModal"
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-4 scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
         x-transition:leave-end="opacity-0 translate-y-4 scale-95"
         class="modal-content max-w-2xl w-full max-h-[85vh] flex flex-col">
            
            {{-- Top Accent Bar --}}
            <div class="modal-accent"></div>
            
            {{-- Close Button --}}
            <button type="button" @click="closeGoalSelectModal()" class="modal-close-button">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
            
            {{-- Modal Header --}}
            <div class="modal-header">
                <div class="modal-eyebrow">Goal Library</div>
                <h3 class="modal-title">Select Goals</h3>
                <p class="modal-description">Choose goals that align with your challenge</p>
            </div>
            
            {{-- Goals List (scrollable) --}}
            <div class="modal-body flex-1 overflow-y-auto">
                @if($goals->count() > 0)
                    <div class="goal-select-list">
                        @foreach($goals as $goal)
                            <label class="goal-select-clickable">
                                <x-goal-card>
                                    <x-slot:icon>
                                        <div class="goal-display-card-icon">{{ $goal->icon ?? '🎯' }}</div>
                                    </x-slot:icon>
                                    <x-slot:title>
                                        <h5 class="goal-display-card-title">{{ $goal->name }}</h5>
                                    </x-slot:title>
                                    @if($goal->description)
                                        <x-slot:subtitle>
                                            <p class="goal-display-card-description">{{ $goal->description }}</p>
                                        </x-slot:subtitle>
                                    @endif
                                    <x-slot:rightAction>
                                        <input type="checkbox" 
                                               :checked="isGoalSelected({{ $goal->id }})"
                                               @change="toggleGoal({{ $goal->id }})"
                                               class="form-checkbox">
                                    </x-slot:rightAction>
                                </x-goal-card>
                            </label>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <div class="text-4xl mb-3">📚</div>
                        <p class="text-gray-600 dark:text-gray-400">No goals available in the library yet.</p>
                        <p class="text-sm text-gray-500 dark:text-gray-500 mt-1">Create a new goal to get started!</p>
                    </div>
                @endif
            </div>
            
            {{-- Modal Footer --}}
            <div class="modal-footer">
                <div class="flex justify-between items-center w-full">
                    <span class="goal-select-counter">
                        <span x-text="selectedGoalIds.length"></span>
                        <span x-text="selectedGoalIds.length === 1 ? 'goal' : 'goals'"></span>
                        selected
                    </span>
                    <button @click="closeGoalSelectModal()" 
                            type="button"
                            class="btn-primary">
                        Done
                    </button>
                </div>
            </div>
        </div>
</div>
