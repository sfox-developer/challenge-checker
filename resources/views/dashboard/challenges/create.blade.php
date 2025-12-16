<x-dashboard-layout>
    <x-slot name="title">Create New Challenge</x-slot>

    <x-dashboard.page-header 
        eyebrow="New Challenge"
        title="Create Challenge"
        description="Set up your new time-bound challenge" />

    <div class="pb-12 md:pb-20">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="card">
                <form action="{{ route('challenges.store') }}" method="POST" id="challenge-form" x-data="{ ...challengeForm(), ...habitForm() }">
                        @csrf
                        
                        <!-- Challenge Name -->
                        <x-forms.form-input
                            name="name"
                            label="Challenge Name"
                            icon='<path fill-rule="evenodd" d="M10 2L3 7v11a1 1 0 001 1h3a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1h3a1 1 0 001-1V7l-7-5z" clip-rule="evenodd"></path>'
                            iconColor="blue"
                            placeholder="e.g., 30-Day Fitness Challenge"
                            required />

                        <!-- Description -->
                        <x-forms.form-textarea
                            name="description"
                            label="Description"
                            icon='<path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"></path>'
                            iconColor="purple"
                            placeholder="Describe what this challenge is about..."
                            optional
                            rows="3" />

                        <!-- Frequency Selection -->
                        <x-forms.frequency-selector />

                        <!-- Duration (optional - for challenges with end date) -->
                        <div class="mb-6">
                            <label for="days_duration" class="form-label form-label-icon">
                                <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                </svg>
                                <span>Duration (Days) <span class="text-optional">(Optional - leave blank for ongoing)</span></span>
                            </label>
                            <div class="relative">
                                <input type="number" name="days_duration" id="days_duration" value="{{ old('days_duration', '') }}" 
                                       min="1" max="365"
                                       class="app-input pr-16" placeholder="30">
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

                        <!-- Public Checkbox -->
                        <x-forms.form-checkbox
                            name="is_public"
                            label="Make this challenge public"
                            description="Other users will be able to see this challenge in their feed"
                            icon='<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>'
                            :checked="old('is_public', false)"
                            class="mb-8" />

                        <!-- Goals Section -->
                        <div class="mb-6">
                            <div class="flex justify-between items-center mb-4">
                                <label class="form-label form-label-icon">
                                    <svg class="w-4 h-4 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span>Goals</span>
                                </label>
                                <div class="flex space-x-2">
                                    <a href="{{ route('goals.index') }}" class="text-sm text-slate-700 dark:text-slate-400 hover:underline flex items-center space-x-1">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M5 4a1 1 0 00-2 0v7.268a2 2 0 000 3.464V16a1 1 0 102 0v-1.268a2 2 0 000-3.464V4zM11 4a1 1 0 10-2 0v1.268a2 2 0 000 3.464V16a1 1 0 102 0V8.732a2 2 0 000-3.464V4zM16 3a1 1 0 011 1v7.268a2 2 0 010 3.464V16a1 1 0 11-2 0v-1.268a2 2 0 010-3.464V4a1 1 0 011-1z"/>
                                        </svg>
                                        <span>Manage Library</span>
                                    </a>
                                </div>
                            </div>

                            <!-- Select from Library -->
                            @if($goalsLibrary->count() > 0)
                            <div class="info-box info-box-primary">
                                <div class="text-sm font-semibold text-gray-800 dark:text-gray-100 mb-3">Select from Your Library:</div>
                                <div class="space-y-2 max-h-64 overflow-y-auto">
                                    @foreach($goalsLibrary as $goal)
                                        <label class="flex items-start p-3 bg-white dark:bg-gray-800 rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                            <input type="checkbox" 
                                                   name="goal_library_ids[]" 
                                                   value="{{ $goal->id }}"
                                                   class="mt-1 rounded border-gray-300 text-slate-700 focus:ring-slate-500">
                                            <div class="ml-3 flex-1">
                                                <div class="flex items-center space-x-2">
                                                    @if($goal->icon)
                                                        <span class="text-xl">{{ $goal->icon }}</span>
                                                    @endif
                                                    <span class="font-semibold text-gray-900 dark:text-white">{{ $goal->name }}</span>
                                                </div>
                                                @if($goal->description)
                                                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ $goal->description }}</p>
                                                @endif
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                            @endif

                            <!-- Add New Goals -->
                            <div>
                                <button type="button" 
                                        @click="addNewGoal()"
                                        class="w-full py-3 px-4 border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg text-gray-600 dark:text-gray-400 hover:border-green-500 hover:text-green-600 dark:hover:text-green-400 transition-colors flex items-center justify-center space-x-2">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"/>
                                    </svg>
                                    <span class="font-medium">Add New Goal (will be saved to library)</span>
                                </button>
                            </div>

                            <!-- New Goals Container -->
                            <div x-show="newGoals.length > 0" class="mt-4 space-y-3">
                                <template x-for="(goal, index) in newGoals" :key="index">
                                    <div class="info-box info-box-success" style="border: 2px solid; border-color: rgb(34 197 94 / 0.3);">
                                        <div class="flex justify-between items-start mb-3">
                                            <div class="font-semibold text-gray-900 dark:text-white">New Goal</div>
                                            <button type="button" 
                                                    @click="removeNewGoal(index)"
                                                    class="text-red-600 hover:text-red-700">
                                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                                </svg>
                                            </button>
                                        </div>
                                        <div class="space-y-3">
                                            <input type="text" 
                                                   :name="`new_goals[${index}][name]`"
                                                   x-model="goal.name"
                                                   class="app-input text-sm" 
                                                   placeholder="Goal name"
                                                   required>
                                            <div class="grid grid-cols-2 gap-3">
                                                <div x-data="{ showPicker: false, emojis: ['🎯', '🏆', '⭐', '✨', '🌟', '💫', '❤️', '💪', '🏃', '🧘', '🍎', '🥗', '📚', '📖', '✏️', '📝', '⚡', '💼', '🧠', '💤', '🌱', '🌿', '☕', '💧', '👥', '🤝', '🎨', '🎭', '🎵', '🎪', '🌈', '🌸', '🌺', '🔥', '💎', '🎁', '⚽', '🏀', '🏋️', '🚴', '🏊', '⛰️', '🥑', '🥤', '🍵', '🌮', '🍇', '🍓'] }" class="relative">
                                                    <div class="relative">
                                                        <input type="text" 
                                                               :name="`new_goals[${index}][icon]`"
                                                               x-model="goal.icon"
                                                               class="app-input text-sm pr-12" 
                                                               placeholder="🎯"
                                                               maxlength="2">
                                                        <button 
                                                            type="button"
                                                            @click="showPicker = !showPicker"
                                                            class="absolute right-2 top-1/2 -translate-y-1/2 px-2 py-1 text-2xl hover:scale-110 transition-transform duration-200 rounded"
                                                            :class="{ 'ring-2 ring-blue-500': showPicker }"
                                                            title="Choose emoji">
                                                            <span x-text="goal.icon || '🎯'"></span>
                                                        </button>
                                                    </div>
                                                    <!-- Emoji Picker Popover -->
                                                    <div 
                                                        x-show="showPicker"
                                                        @click.outside="showPicker = false"
                                                        x-transition:enter="transition ease-out duration-100"
                                                        x-transition:enter-start="opacity-0 scale-95"
                                                        x-transition:enter-end="opacity-100 scale-100"
                                                        x-transition:leave="transition ease-in duration-75"
                                                        x-transition:leave-start="opacity-100 scale-100"
                                                        x-transition:leave-end="opacity-0 scale-95"
                                                        class="absolute left-0 right-0 sm:left-auto sm:right-0 mt-2 w-full sm:w-72 bg-white dark:bg-gray-800 rounded-lg shadow-xl border border-gray-200 dark:border-gray-700 z-50 p-4"
                                                        style="display: none;"
                                                        @click.stop>
                                                        <div class="mb-3 flex justify-between items-center">
                                                            <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300">Choose Emoji</h4>
                                                            <button 
                                                                type="button"
                                                                @click="goal.icon = ''; showPicker = false"
                                                                class="text-xs text-gray-500 dark:text-gray-400 hover:text-red-600 dark:hover:text-red-400">
                                                                Clear
                                                            </button>
                                                        </div>
                                                        <div class="grid grid-cols-6 sm:grid-cols-8 gap-2 max-h-60 overflow-y-auto">
                                                            <template x-for="(emoji, emojiIndex) in emojis" :key="emojiIndex">
                                                                <button 
                                                                    type="button"
                                                                    @click="goal.icon = emoji; showPicker = false"
                                                                    class="text-2xl hover:bg-gray-100 dark:hover:bg-gray-700 rounded p-2 transition-colors duration-150"
                                                                    x-text="emoji">
                                                                </button>
                                                            </template>
                                                        </div>
                                                        <div class="mt-3 pt-3 border-t border-gray-200 dark:border-gray-700">
                                                            <p class="text-xs text-gray-500 dark:text-gray-400 text-center">
                                                                Or type any emoji directly in the field
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <select :name="`new_goals[${index}][category_id]`" 
                                                        x-model="goal.category_id"
                                                        class="app-input text-sm">
                                                    <option value="">Category</option>
                                                    @foreach($categories as $cat)
                                                        <option value="{{ $cat->id }}">{{ $cat->icon }} {{ $cat->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <textarea :name="`new_goals[${index}][description]`"
                                                      x-model="goal.description"
                                                      rows="2" 
                                                      class="app-input text-sm" 
                                                      placeholder="Description (optional)"></textarea>
                                        </div>
                                    </div>
                                </template>
                            </div>

                            @error('goal_library_ids')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex justify-between space-x-4 pt-6 border-t border-gray-200 dark:border-gray-700">
                            <x-ui.app-button variant="secondary" href="{{ route('challenges.index') }}">
                                <x-slot name="icon">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                </x-slot>
                                Cancel
                            </x-ui.app-button>
                            <x-ui.app-button variant="primary" type="submit">
                                <x-slot name="icon">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                </x-slot>
                                Create Challenge
                            </x-ui.app-button>
                        </div>
                </form>
            </div>
        </div>
    </div>

</x-dashboard-layout>
