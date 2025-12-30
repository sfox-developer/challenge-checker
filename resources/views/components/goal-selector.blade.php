{{--
    Goal Selector Component
    
    A reusable component for selecting/creating goals with support for both single and multiple selections.
    
    Props:
    - goals: Array of available goals from library
    - allowMultiple: Boolean - whether to allow multiple goal selection (default: false)
    - maxSelections: Number - maximum number of goals allowed (default: unlimited for multiple, 1 for single)
    - selectedMessage: String - message to show when goals are selected
    - emptyMessage: String - message to show when no goals are selected
    
    Example usage:
    <x-goal-selector 
        :goals="$goalsLibrary" 
        :allow-multiple="true" 
        :max-selections="5"
        selected-message="Selected goals:"
        empty-message="No goals selected" />
--}}

@props([
    'goalsData' => [],
    'allowMultiple' => false,
    'fieldName' => 'goal_id',
    'maxSelections' => null,
    'selectedMessage' => 'Selected goal:',
    'emptyMessage' => 'No goal selected',
    'componentId' => 'goalSelector' . uniqid(),
    'categories' => []
])

@php
    // Convert string "false" to boolean false
    $allowMultiple = $allowMultiple === 'false' ? false : (bool) $allowMultiple;
    $maxSelections = $maxSelections ?? ($allowMultiple ? 999 : 1);
@endphp

<div x-data="{{ $componentId }}()" x-init="init()">
    <!-- Goal Selection Buttons -->
    <div class="mb-6">
        <label class="block text-sm font-bold text-gray-800 dark:text-gray-100 mb-3 flex items-center space-x-2">
            <span>What do you want to track? <span class="text-red-500">*</span></span>
        </label>

        <!-- Modal Action Buttons -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-4">
            <button type="button" 
                    @click="openGoalSelectModal()"
                    class="btn-secondary flex items-center justify-center space-x-2 px-4 py-3">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"/>
                </svg>
                <span class="font-medium">Select from Library</span>
                @if($allowMultiple)
                <span x-show="hasGoals() && (selectedGoalIds.length > 0)" 
                      class="ml-auto w-6 h-6 rounded-full bg-green-600 text-white flex items-center justify-center">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                    </svg>
                </span>
                @else
                <span x-show="hasGoals() && selectedGoalSources === 'library'" 
                      class="ml-auto w-6 h-6 rounded-full bg-green-600 text-white flex items-center justify-center">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                    </svg>
                </span>
                @endif
            </button>
            
            <button type="button" 
                    @click="openGoalCreateModal()"
                    :disabled="!canSelectMore()"
                    class="btn-secondary flex items-center justify-center space-x-2 px-4 py-3">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"/>
                </svg>
                <span class="font-medium">Create New Goal</span>
                @if($allowMultiple)
                <span x-show="hasGoals() && (newGoals.length > 0)" 
                      class="ml-auto w-6 h-6 rounded-full bg-green-600 text-white flex items-center justify-center">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                    </svg>
                </span>
                @else
                <span x-show="hasGoals() && (selectedGoalSources === 'new' || newGoal.name)" 
                      class="ml-auto w-6 h-6 rounded-full bg-green-600 text-white flex items-center justify-center">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                    </svg>
                </span>
                @endif
            </button>
        </div>

        <!-- Selected Goals Display -->
        <div x-show="getPermanentSelectedCount() > 0" x-transition class="mt-4">
            @if($allowMultiple)
                <!-- Multiple Selection Display -->
                <h6 class="text-sm font-semibold text-gray-800 dark:text-gray-100 mb-3">
                    <span x-text="getPermanentSelectedCount() === 1 ? '{{ $selectedMessage }}' : '{{ rtrim($selectedMessage, ':') }}s:'"></span>
                    @if($maxSelections <= 999)
                        <span class="text-gray-500 dark:text-gray-400 font-normal">
                            (<span x-text="getPermanentSelectedCount()"></span>/{{ $maxSelections }})
                        </span>
                    @endif
                </h6>
                
                <!-- Selected Goals Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-4">
                    <!-- Selected Library Goals -->
                    <template x-for="goalId in selectedGoalIds" :key="'library-' + goalId">
                        <x-goal-card>
                        <x-slot:icon>
                            <div class="goal-display-card-icon" x-text="getGoalIconById(goalId)"></div>
                        </x-slot:icon>
                        <x-slot:title>
                            <h5 class="goal-display-card-title" x-text="getGoalNameById(goalId)"></h5>
                        </x-slot:title>
                        <x-slot:subtitle>
                            <p class="goal-display-card-description" x-show="getGoalDescriptionById(goalId)" x-text="getGoalDescriptionById(goalId)"></p>
                        </x-slot:subtitle>
                        <x-slot:rightAction>
                            <button type="button" @click="removeGoal(goalId)" class="goal-display-card-remove-btn">
                                <svg fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                </svg>
                            </button>
                        </x-slot:rightAction>
                    </x-goal-card>
                </template>

                <!-- Selected New Goals -->
                <template x-for="goal in newGoals" :key="'new-' + goal.tempId">
                    <x-goal-card>
                        <x-slot:icon>
                            <div class="goal-display-card-icon" x-text="goal.icon || '🎯'"></div>
                        </x-slot:icon>
                        <x-slot:title>
                            <h5 class="goal-display-card-title" x-text="goal.name"></h5>
                        </x-slot:title>
                        <x-slot:subtitle>
                            <p class="goal-display-card-description" x-show="goal.description" x-text="goal.description"></p>
                        </x-slot:subtitle>
                        <x-slot:rightAction>
                            <button type="button" @click="removeGoal(goal.tempId, true)" class="goal-display-card-remove-btn">
                                <svg fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                </svg>
                            </button>
                        </x-slot:rightAction>
                    </x-goal-card>
                </template>
                </div>
            @else
                <!-- Single Selection Display -->
                <h6 class="text-sm font-semibold text-gray-800 dark:text-gray-100 mb-3">
                    {{ $selectedMessage }}
                    <span class="text-gray-500 dark:text-gray-400 font-normal">(1/1)</span>
                </h6>
                
                <!-- Selected Goal Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-4">
                    <!-- Selected Library Goal -->
                    <template x-if="selectedGoalSources === 'library'">
                        <x-goal-card>
                        <x-slot:icon>
                            <div class="goal-display-card-icon" x-text="getGoalIconById(selectedGoalIds)"></div>
                        </x-slot:icon>
                        <x-slot:title>
                            <h5 class="goal-display-card-title" x-text="getGoalNameById(selectedGoalIds)"></h5>
                        </x-slot:title>
                        <x-slot:subtitle>
                            <p class="goal-display-card-description" x-show="getGoalDescriptionById(selectedGoalIds)" x-text="getGoalDescriptionById(selectedGoalIds)"></p>
                        </x-slot:subtitle>
                        <x-slot:rightAction>
                            <button type="button" @click="removeGoal(selectedGoalIds)" class="goal-display-card-remove-btn">
                                <svg fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                </svg>
                            </button>
                        </x-slot:rightAction>
                    </x-goal-card>
                </template>

                <!-- Selected New Goal -->
                <template x-if="selectedGoalSources === 'new' || (newGoal.name && newGoal.name.trim())">
                    <x-goal-card>
                        <x-slot:icon>
                            <div class="goal-display-card-icon" x-text="newGoal.icon || '🎯'"></div>
                        </x-slot:icon>
                        <x-slot:title>
                            <h5 class="goal-display-card-title" x-text="newGoal.name"></h5>
                        </x-slot:title>
                        <x-slot:subtitle>
                            <p class="goal-display-card-description" x-show="newGoal.description" x-text="newGoal.description"></p>
                        </x-slot:subtitle>
                        <x-slot:rightAction>
                            <button type="button" @click="removeGoal(null, true)" class="goal-display-card-remove-btn">
                                <svg fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                </svg>
                            </button>
                        </x-slot:rightAction>
                    </x-goal-card>
                </template>
                </div>
            @endif
        </div>

        <!-- Empty State -->
        <div x-show="!hasGoals()" class="text-center py-8 text-gray-500 dark:text-gray-400 border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg">
            <svg class="w-12 h-12 mx-auto mb-3 text-gray-300 dark:text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"/>
            </svg>
            <p class="font-medium">{{ $emptyMessage }}</p>
            <p class="text-sm mt-1">Select from library or create a new goal</p>
        </div>

        <!-- Hidden inputs for form submission -->
        @if($allowMultiple)
            <!-- Multiple selection hidden inputs -->
            <template x-for="(goalId, index) in selectedGoalIds" :key="'input-library-' + goalId">
                <input type="hidden" :name="'goal_library_ids[]'" :value="goalId">
            </template>
            <template x-for="(goal, index) in newGoals" :key="'input-new-' + goal.tempId">
                <div>
                    <input type="hidden" :name="'new_goals[' + index + '][name]'" :value="goal.name">
                    <input type="hidden" :name="'new_goals[' + index + '][icon]'" :value="goal.icon">
                    <input type="hidden" :name="'new_goals[' + index + '][category_id]'" :value="goal.category_id">
                    <input type="hidden" :name="'new_goals[' + index + '][description]'" :value="goal.description">
                </div>
            </template>
        @else
            <!-- Single selection hidden inputs -->
            <input type="hidden" name="goal_library_id" :value="selectedGoalSources === 'library' ? selectedGoalIds : ''">
            <template x-if="selectedGoalSources === 'new' || (newGoal.name && newGoal.name.trim())">
                <div>
                    <input type="hidden" name="new_goal_name" :value="newGoal.name">
                    <input type="hidden" name="new_goal_icon" :value="newGoal.icon">
                    <input type="hidden" name="new_goal_category_id" :value="newGoal.category_id">
                    <input type="hidden" name="new_goal_description" :value="newGoal.description">
                </div>
            </template>
        @endif
    </div>

    <!-- Goal Selection Modal -->
    <x-goal-select-modal 
        :goals="$goalsData" 
        :allow-multiple="$allowMultiple"
        :component-id="$componentId" />

    <!-- Goal Creation Modal -->
    <x-goal-create-modal 
        :categories="$categories ?? []"
        :component-id="$componentId" />

    <script>
        // Initialize the goal selector component
        window.{{ $componentId }} = () => {
            return window.createGoalSelector({
                allowMultiple: {{ $allowMultiple ? 'true' : 'false' }},
                maxSelections: {{ $maxSelections ?: 1 }}
            });
        };
    </script>
</div>