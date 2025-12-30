{{--
    Shared Goal Select Modal
    
    Props:
    - goals: Array of goals from library
    - allowMultiple: Boolean - whether to allow multiple selections
    - componentId: String - ID of the parent component for Alpine.js functions
--}}

@props([
    'goals' => [],
    'allowMultiple' => false,
    'componentId' => 'goalSelector'
])

<!-- Goal Selection Modal -->
<template x-teleport="body">
    <div x-show="showGoalSelectModal" 
         x-cloak
         @keydown.escape.window="showGoalSelectModal && cancelGoalSelectModal()" 
         class="modal-wrapper">
    
    <!-- Backdrop -->
    <div x-show="showGoalSelectModal" 
         @click="cancelGoalSelectModal()"
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="modal-backdrop">
    </div>

    <!-- Modal Content -->
    <div @click.stop
         x-show="showGoalSelectModal"
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-4 scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
         x-transition:leave-end="opacity-0 translate-y-4 scale-95"
         class="modal-content max-w-2xl w-full max-h-[85vh] flex flex-col">

        <!-- Top Accent Bar -->
        <div class="modal-accent"></div>
        
        <!-- Close Button -->
        <button type="button" @click="cancelGoalSelectModal()" class="modal-close-button">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>

        <!-- Modal Header -->
        <div class="modal-header">
            <div class="modal-eyebrow">Goal Library</div>
            <h3 class="modal-title">Select {{ $allowMultiple ? 'Goals' : 'Goal' }}</h3>
            <p class="modal-description">Choose {{ $allowMultiple ? 'goals that align with your challenge' : 'a goal for your habit' }}</p>
        </div>

        <!-- Goals List (scrollable) -->
        <div class="modal-body flex-1 overflow-y-auto">
            <!-- Use Alpine.js template for dynamic goals list -->
            <template x-if="goals && goals.length > 0">
                <div class="goal-select-list">
                    <template x-for="goal in goals" :key="goal.id">
                        <label class="goal-select-clickable">
                            <x-goal-card>
                                <x-slot:icon>
                                    <div class="goal-display-card-icon" x-text="goal.icon || '🎯'"></div>
                                </x-slot:icon>
                                <x-slot:title>
                                    <h5 class="goal-display-card-title" x-text="goal.name"></h5>
                                </x-slot:title>
                                <template x-if="goal.description">
                                    <x-slot:subtitle>
                                        <p class="goal-display-card-description" x-text="goal.description"></p>
                                    </x-slot:subtitle>
                                </template>
                                <x-slot:rightAction>
                                    <template x-if="{{ $allowMultiple ? 'true' : 'false' }}">
                                        <input type="checkbox" 
                                               :checked="isGoalSelected(goal.id)"
                                               @change="toggleGoal(goal)"
                                               class="form-checkbox">
                                    </template>
                                    <template x-if="{{ $allowMultiple ? 'false' : 'true' }}">
                                        <input type="radio" 
                                               name="goal_selection"
                                               :checked="isGoalSelected(goal.id)"
                                               @change="selectGoal(goal)"
                                               class="form-radio">
                                    </template>
                                </x-slot:rightAction>
                            </x-goal-card>
                        </label>
                    </template>
                </div>
            </template>
            
            <!-- Empty state -->
            <template x-if="!goals || goals.length === 0">
                <div class="text-center py-12">
                    <div class="text-4xl mb-3">📚</div>
                    <p class="text-gray-600 dark:text-gray-400">No goals available in the library yet.</p>
                    <p class="text-sm text-gray-500 dark:text-gray-500 mt-1">Create a new goal to get started!</p>
                </div>
            </template>
        </div>

        <!-- Modal Footer -->
        <div class="modal-footer">
            @if($allowMultiple)
                <div class="flex justify-between items-center w-full">
                    <span class="goal-select-counter">
                        <span x-text="getSelectedCount()"></span>
                        <span x-text="getSelectedCount() === 1 ? 'goal' : 'goals'"></span>
                        selected
                    </span>
                    <div class="flex space-x-3">
                        <button @click="cancelGoalSelectModal()" 
                                type="button"
                                class="btn-secondary">
                            Cancel
                        </button>
                        <button @click="closeGoalSelectModal()" 
                                type="button"
                                class="btn-primary">
                            Done
                        </button>
                    </div>
                </div>
            @else
                <div class="flex justify-between items-center w-full">
                    <span class="goal-select-counter">
                        <span x-text="getSelectedCount()"></span>
                        <span x-text="getSelectedCount() === 1 ? 'goal' : 'goals'"></span>
                        selected
                    </span>
                    <div class="flex space-x-3">
                        <button @click="cancelGoalSelectModal()" 
                                type="button"
                                class="btn-secondary">
                            Cancel
                        </button>
                        <button @click="closeGoalSelectModal()" 
                                type="button"
                                class="btn-primary"
                                :disabled="getSelectedCount() === 0">
                            Done
                        </button>
                    </div>
                </div>
            @endif
        </div>
    </div>
    </div>
</template>