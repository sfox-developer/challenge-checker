<x-app-layout>
    <x-slot name="header">
        <x-page-header title="Create New Habit" gradient="from-teal-500 to-cyan-500">
            <x-slot name="icon">
                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"/>
                </svg>
            </x-slot>
        </x-page-header>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="card">
                <form action="{{ route('habits.store') }}" method="POST" id="habit-form" x-data="habitFormWithGoalToggle({{ count($goalsLibrary) > 0 ? 'true' : 'false' }})">
                    @csrf
                    
                    <!-- Goal Selection or Creation -->
                    <div class="mb-6">
                        <label class="block text-sm font-bold text-gray-800 dark:text-gray-100 mb-3 flex items-center space-x-2">
                            <svg class="w-4 h-4 text-teal-500" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                                <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/>
                            </svg>
                            <span>What do you want to track?</span>
                        </label>

                        <!-- Toggle between existing and new goal -->
                        <div class="flex space-x-3 mb-4">
                            <button type="button" 
                                    @click="useExisting = true"
                                    :class="useExisting ? 'bg-teal-500 text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300'"
                                    class="flex-1 py-2 px-4 rounded-lg font-medium transition-colors duration-200">
                                Choose from Library
                            </button>
                            <button type="button" 
                                    @click="useExisting = false"
                                    :class="!useExisting ? 'bg-teal-500 text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300'"
                                    class="flex-1 py-2 px-4 rounded-lg font-medium transition-colors duration-200">
                                Create New Goal
                            </button>
                        </div>

                        <!-- Existing Goal Selection -->
                        <div x-show="useExisting" x-transition>
                            <select name="goal_library_id" id="goal_library_id" class="app-input" x-model="selectedGoalId" :disabled="!useExisting">
                                <option value="">Select a goal...</option>
                                @foreach($goalsLibrary as $goal)
                                    <option value="{{ $goal->id }}">
                                        {{ $goal->icon }} {{ $goal->name }}
                                        @if($goal->category)
                                            ({{ $goal->category->name }})
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                            @error('goal_library_id')
                                <p class="mt-2 text-sm text-red-600 flex items-center space-x-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    <span>{{ $message }}</span>
                                </p>
                            @enderror
                        </div>

                        <!-- New Goal Creation -->
                        <div x-show="!useExisting" x-transition>
                            <div class="space-y-4">
                                <div>
                                    <input type="text" 
                                           name="new_goal_name" 
                                           id="new_goal_name" 
                                           class="app-input" 
                                           placeholder="Goal name (e.g., Drink water, Exercise, Read)"
                                           :disabled="useExisting"
                                           value="{{ old('new_goal_name') }}">
                                    @error('new_goal_name')
                                        <p class="mt-2 text-sm text-red-600 flex items-center space-x-1">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                            </svg>
                                            <span>{{ $message }}</span>
                                        </p>
                                    @enderror
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <x-emoji-picker 
                                            id="new_goal_icon"
                                            name="new_goal_icon" 
                                            :value="old('new_goal_icon')"
                                            placeholder="Icon (emoji)"
                                            label=""
                                            x-bind:disabled="useExisting" />
                                    </div>
                                    <div>
                                        <select name="new_goal_category_id" id="new_goal_category_id" class="app-input" :disabled="useExisting">
                                            <option value="">Category (optional)</option>
                                            @foreach($categories as $cat)
                                                <option value="{{ $cat->id }}">
                                                    {{ $cat->icon }} {{ $cat->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div>
                                    <textarea name="new_goal_description" 
                                              id="new_goal_description" 
                                              rows="2" 
                                              class="app-input" 
                                              placeholder="Description (optional)"
                                              :disabled="useExisting">{{ old('new_goal_description') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <x-habit-frequency-form />

                    <!-- Submit Buttons -->
                    <div class="flex space-x-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <button type="submit" class="flex-1 btn-primary">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            Create Habit
                        </button>
                        <a href="{{ route('habits.index') }}" class="btn-secondary">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

</x-app-layout>
