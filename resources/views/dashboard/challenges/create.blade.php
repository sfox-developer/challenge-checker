<x-dashboard-layout>
    <x-slot name="title">Create New Challenge</x-slot>

    <x-dashboard.page-header 
        eyebrow="New Challenge"
        title="Create Challenge"
        description="Set up your new time-bound challenge" />

    {{-- Main Create Form Section --}}
    <div class="section pt-0" x-data="challengeCreateForm()" x-id="['challenge-form']">
        <div class="container max-w-4xl">
            <div class="step-form">
                {{-- Top Accent Bar --}}
                <div class="modal-accent"></div>
                
                <div class="step-form-content">
                    <form action="{{ route('challenges.store') }}" method="POST" :id="$id('challenge-form')">
                            @csrf
                        
                        {{-- Step Progress Indicator --}}
                        <div class="step-progress">
                            <div class="step-progress-track">
                                {{-- Step 1 --}}
                                <div class="step-progress-circle-wrapper">
                                    <div class="step-progress-circle"
                                         :class="{
                                            'completed': 1 < step,
                                            'active': 1 === step,
                                            'inactive': 1 > step
                                         }">
                                        <svg x-show="1 < step" class="w-5 h-5 sm:w-5 sm:h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                        <span x-show="1 >= step">1</span>
                                    </div>
                                    <div class="step-progress-label" :class="1 === step ? 'active' : 'inactive'">
                                        Basic Info
                                    </div>
                                </div>
                                
                                {{-- Connector 1-2 --}}
                                <div class="step-progress-connector" :class="1 < step ? 'completed' : 'inactive'"></div>
                                
                                {{-- Step 2 --}}
                                <div class="step-progress-circle-wrapper">
                                    <div class="step-progress-circle"
                                         :class="{
                                            'completed': 2 < step,
                                            'active': 2 === step,
                                            'inactive': 2 > step
                                         }">
                                        <svg x-show="2 < step" class="w-5 h-5 sm:w-5 sm:h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                        <span x-show="2 >= step">2</span>
                                    </div>
                                    <div class="step-progress-label" :class="2 === step ? 'active' : 'inactive'">
                                        Schedule
                                    </div>
                                </div>
                                
                                {{-- Connector 2-3 --}}
                                <div class="step-progress-connector" :class="2 < step ? 'completed' : 'inactive'"></div>
                                
                                {{-- Step 3 --}}
                                <div class="step-progress-circle-wrapper">
                                    <div class="step-progress-circle"
                                         :class="{
                                            'completed': 3 < step,
                                            'active': 3 === step,
                                            'inactive': 3 > step
                                         }">
                                        <svg x-show="3 < step" class="w-5 h-5 sm:w-5 sm:h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                        <span x-show="3 >= step">3</span>
                                    </div>
                                    <div class="step-progress-label" :class="3 === step ? 'active' : 'inactive'">
                                        Goals
                                    </div>
                                </div>
                            </div>
                            
                            {{-- Mobile: Current Step Label --}}
                            <div class="step-progress-mobile-label">
                                <span x-text="'Step ' + step + ': ' + (step === 1 ? 'Basic Info' : step === 2 ? 'Schedule' : 'Goals')"></span>
                            </div>
                        </div>
                        
                        {{-- Basic Information Section --}}
                        <div x-show="step === 1" x-cloak>
                            {{-- Header --}}
                            <div class="modal-header">
                                <div class="modal-eyebrow">STEP 1 OF 3</div>
                                <h3 class="modal-title">Basic Information</h3>
                            </div>
                            
                            {{-- Body --}}
                            <div class="modal-body">
                                
                                <!-- Challenge Name -->
                                <x-forms.form-input
                                    name="name"
                                    label="Challenge Name"
                                    placeholder="e.g., 30-Day Fitness Challenge"
                                    x-model="name"
                                    required />

                                <!-- Description -->
                                <x-forms.form-textarea
                                    name="description"
                                    label="Description"
                                    placeholder="Describe what this challenge is about..."
                                    x-model="description"
                                    optional
                                    rows="3" />

                                <!-- Public Checkbox -->
                                <x-forms.form-checkbox
                                    name="is_public"
                                    label="Make this challenge public"
                                    description="Other users will be able to see this challenge in their feed"
                                    x-model="is_public"
                                    :checked="old('is_public', true)" />
                            </div>

                            {{-- Footer --}}
                            <div class="modal-footer">
                                <button 
                                    type="button" 
                                    @click="nextStep()" 
                                    :disabled="!name.trim()"
                                    class="btn-primary">
                                    Next
                                    <svg class="w-4 h-4 ml-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        {{-- Schedule & Tracking Section --}}
                        <div x-show="step === 2" x-cloak>
                            {{-- Header --}}
                            <div class="modal-header">
                                <div class="modal-eyebrow">STEP 2 OF 3</div>
                                <h3 class="modal-title">Schedule & Tracking</h3>
                            </div>
                            
                            {{-- Body --}}
                            <div class="modal-body">
                                
                                <!-- Frequency Selection -->
                                <x-forms.frequency-selector />

                                <!-- Duration -->
                                <div class="mb-6">
                                <label for="days_duration" class="form-label">
                                    <span>Duration (Days) <span class="form-label-required">*</span></span>
                                </label>
                                <div class="relative">
                                    <input type="number" name="days_duration" id="days_duration" 
                                           x-model="days_duration"
                                           value="{{ old('days_duration', '') }}" 
                                           min="1" max="365"
                                           class="form-input pr-16" 
                                           placeholder="30"
                                           required>
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                        <span class="text-gray-500 text-sm">days</span>
                                    </div>
                                </div>
                                @error('days_duration')
                                    <p class="mt-2 text-sm text-red-600 flex items-center space-x-1">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span>{{ $message }}</span>
                                    </p>
                                @enderror
                            </div>
                            </div>

                            {{-- Footer --}}
                            <div class="modal-footer">
                                <button type="button" @click="prevStep()" class="btn-secondary">
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"/>
                                    </svg>
                                    Back
                                </button>
                                <button 
                                    type="button" 
                                    @click="nextStep()" 
                                    :disabled="!days_duration || days_duration < 1 || days_duration > 365"
                                    class="btn-primary">
                                    Next
                                    <svg class="w-4 h-4 ml-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        {{-- Goals Section (Step 3) --}}
                        <div x-show="step === 3" x-cloak>
                            {{-- Header --}}
                            <div class="modal-header">
                                <div class="modal-eyebrow">STEP 3 OF 3</div>
                                <h3 class="modal-title">Goals <span class="form-label-required">*</span></h3>
                            </div>
                            
                            {{-- Body --}}
                            <div class="modal-body">
                                
                                <!-- Modal Action Buttons -->
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-6">
                                    <button type="button" 
                                            @click="openGoalSelectModal()"
                                            class="flex items-center justify-center space-x-2 px-4 py-3 rounded-lg border-2 border-slate-300 dark:border-slate-600 text-slate-700 dark:text-slate-300 hover:border-slate-500 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"/>
                                        </svg>
                                        <span class="font-medium">Select from Library</span>
                                        <span x-show="selectedGoalIds.length > 0" 
                                              class="ml-auto px-2 py-0.5 text-xs font-semibold rounded-full bg-slate-700 text-white" 
                                              x-text="selectedGoalIds.length"></span>
                                    </button>
                                    
                                    <button type="button" 
                                            @click="openGoalCreateModal()"
                                            class="flex items-center justify-center space-x-2 px-4 py-3 rounded-lg border-2 border-green-300 dark:border-green-600 text-green-700 dark:text-green-400 hover:border-green-500 hover:bg-green-50 dark:hover:bg-green-900/20 transition-colors">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"/>
                                        </svg>
                                        <span class="font-medium">Create New Goal</span>
                                        <span x-show="newGoals.length > 0" 
                                              class="ml-auto px-2 py-0.5 text-xs font-semibold rounded-full bg-green-600 text-white" 
                                              x-text="newGoals.length"></span>
                                    </button>
                                </div>

                                <!-- Selected Goals Display -->
                                <div x-show="selectedGoalIds.length > 0 || newGoals.length > 0" class="space-y-3">
                                    <!-- Library Goals -->
                                    <div x-show="selectedGoalIds.length > 0">
                                        <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">From Library:</h4>
                                        <div class="flex flex-wrap gap-2">
                                            <template x-for="goalId in selectedGoalIds" :key="goalId">
                                                <div class="inline-flex items-center space-x-2 px-3 py-2 bg-slate-100 dark:bg-slate-800 rounded-lg border border-slate-300 dark:border-slate-600">
                                                    <span class="text-sm font-medium text-gray-900 dark:text-white" 
                                                          x-text="getGoalNameById(goalId)"></span>
                                                    <button type="button" 
                                                            @click="toggleGoal(goalId)"
                                                            class="text-gray-500 hover:text-red-600 dark:hover:text-red-400">
                                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </template>
                                        </div>
                                    </div>

                                    <!-- New Goals -->
                                    <div x-show="newGoals.length > 0">
                                        <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">New Goals:</h4>
                                        <div class="flex flex-wrap gap-2">
                                            <template x-for="(goal, index) in newGoals" :key="index">
                                                <div class="inline-flex items-center space-x-2 px-3 py-2 bg-green-100 dark:bg-green-900/30 rounded-lg border border-green-300 dark:border-green-600">
                                                    <span x-show="goal.icon" class="text-lg" x-text="goal.icon"></span>
                                                    <span class="text-sm font-medium text-gray-900 dark:text-white" x-text="goal.name"></span>
                                                    <button type="button" 
                                                            @click="removeNewGoal(index)"
                                                            class="text-gray-500 hover:text-red-600 dark:hover:text-red-400">
                                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </template>
                                        </div>
                                    </div>
                                </div>

                                <!-- Empty State -->
                                <div x-show="selectedGoalIds.length === 0 && newGoals.length === 0" 
                                     class="text-center py-8 text-gray-500 dark:text-gray-400">
                                    <svg class="w-12 h-12 mx-auto mb-3 text-gray-300 dark:text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"/>
                                    </svg>
                                    <p class="text-sm font-medium">No goals selected yet</p>
                                    <p class="text-xs mt-1">Please select from your library or create new goals to continue</p>
                                </div>

                                @error('goals')
                                    <div class="mt-4 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg">
                                        <div class="flex items-center space-x-2 text-red-600 dark:text-red-400">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                            </svg>
                                            <span class="text-sm font-medium">{{ $message }}</span>
                                        </div>
                                    </div>
                                @enderror

                                <!-- Hidden inputs for form submission -->
                                <template x-for="goalId in selectedGoalIds" :key="'input-' + goalId">
                                    <input type="hidden" name="goal_library_ids[]" :value="goalId">
                                </template>
                                
                                <template x-for="(goal, index) in newGoals" :key="'new-' + index">
                                    <div>
                                        <input type="hidden" :name="`new_goals[${index}][name]`" :value="goal.name">
                                        <input type="hidden" :name="`new_goals[${index}][icon]`" :value="goal.icon">
                                        <input type="hidden" :name="`new_goals[${index}][category_id]`" :value="goal.category_id">
                                        <input type="hidden" :name="`new_goals[${index}][description]`" :value="goal.description">
                                    </div>
                                </template>
                            </div>
                            
                            {{-- Footer --}}
                            <div class="modal-footer">
                                <button type="button" @click="prevStep()" class="btn-secondary">
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"/>
                                    </svg>
                                    Back
                                </button>
                                <button 
                                    type="submit" 
                                    :disabled="selectedGoalIds.length === 0 && newGoals.length === 0"
                                    class="btn-primary">
                                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                    Create Challenge
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        {{-- Goal Selection & Creation Modals (outside card container for proper backdrop) --}}
        <x-challenges.goal-select-modal :goals="$goalsLibrary" />
        <x-challenges.goal-create-modal :categories="$categories" />
    </div>

    {{-- Tips & Best Practices Section (Bottom) --}}
    <x-challenges.tips-section />

</x-dashboard-layout>
