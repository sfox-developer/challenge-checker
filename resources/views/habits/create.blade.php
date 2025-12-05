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
                <form action="{{ route('habits.store') }}" method="POST" id="habit-form" x-data="habitForm()">
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
                                            ({{ ucfirst($goal->category) }})
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
                                        <input type="text" 
                                               name="new_goal_icon" 
                                               id="new_goal_icon" 
                                               class="app-input" 
                                               placeholder="Icon (emoji)"
                                               maxlength="2"
                                               :disabled="useExisting"
                                               value="{{ old('new_goal_icon') }}">
                                    </div>
                                    <div>
                                        <select name="new_goal_category" id="new_goal_category" class="app-input" :disabled="useExisting">
                                            <option value="">Category (optional)</option>
                                            <option value="health">Health</option>
                                            <option value="fitness">Fitness</option>
                                            <option value="learning">Learning</option>
                                            <option value="productivity">Productivity</option>
                                            <option value="mindfulness">Mindfulness</option>
                                            <option value="social">Social</option>
                                            <option value="other">Other</option>
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

                    <!-- Frequency Type -->
                    <div class="mb-6">
                        <label for="frequency_type" class="block text-sm font-bold text-gray-800 dark:text-gray-100 mb-2 flex items-center space-x-2">
                            <svg class="w-4 h-4 text-cyan-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                            </svg>
                            <span>How often?</span>
                        </label>
                        
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                            <label class="cursor-pointer">
                                <input type="radio" name="frequency_type" value="daily" x-model="frequencyType" class="sr-only peer" checked>
                                <div class="p-4 text-center rounded-lg border-2 border-gray-300 dark:border-gray-600 peer-checked:border-teal-500 peer-checked:bg-teal-50 dark:peer-checked:bg-teal-900/20 transition-all duration-200">
                                    <div class="text-2xl mb-1">📅</div>
                                    <div class="text-sm font-semibold">Daily</div>
                                </div>
                            </label>
                            
                            <label class="cursor-pointer">
                                <input type="radio" name="frequency_type" value="weekly" x-model="frequencyType" class="sr-only peer">
                                <div class="p-4 text-center rounded-lg border-2 border-gray-300 dark:border-gray-600 peer-checked:border-teal-500 peer-checked:bg-teal-50 dark:peer-checked:bg-teal-900/20 transition-all duration-200">
                                    <div class="text-2xl mb-1">📆</div>
                                    <div class="text-sm font-semibold">Weekly</div>
                                </div>
                            </label>
                            
                            <label class="cursor-pointer">
                                <input type="radio" name="frequency_type" value="monthly" x-model="frequencyType" class="sr-only peer">
                                <div class="p-4 text-center rounded-lg border-2 border-gray-300 dark:border-gray-600 peer-checked:border-teal-500 peer-checked:bg-teal-50 dark:peer-checked:bg-teal-900/20 transition-all duration-200">
                                    <div class="text-2xl mb-1">🗓️</div>
                                    <div class="text-sm font-semibold">Monthly</div>
                                </div>
                            </label>
                            
                            <label class="cursor-pointer">
                                <input type="radio" name="frequency_type" value="yearly" x-model="frequencyType" class="sr-only peer">
                                <div class="p-4 text-center rounded-lg border-2 border-gray-300 dark:border-gray-600 peer-checked:border-teal-500 peer-checked:bg-teal-50 dark:peer-checked:bg-teal-900/20 transition-all duration-200">
                                    <div class="text-2xl mb-1">📖</div>
                                    <div class="text-sm font-semibold">Yearly</div>
                                </div>
                            </label>
                        </div>
                        @error('frequency_type')
                            <p class="mt-2 text-sm text-red-600 flex items-center space-x-1">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                <span>{{ $message }}</span>
                            </p>
                        @enderror
                    </div>

                    <!-- Frequency Count -->
                    <div class="mb-6">
                        <label for="frequency_count" class="block text-sm font-bold text-gray-800 dark:text-gray-100 mb-2 flex items-center space-x-2">
                            <svg class="w-4 h-4 text-purple-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                            </svg>
                            <span>How many times per <span x-text="frequencyType"></span>?</span>
                        </label>
                        
                        <div class="grid grid-cols-7 gap-2">
                            <template x-for="i in 7" :key="i">
                                <label class="cursor-pointer">
                                    <input type="radio" name="frequency_count" :value="i" x-model="frequencyCount" class="sr-only peer" :checked="i === 1">
                                    <div class="aspect-square flex items-center justify-center rounded-lg border-2 border-gray-300 dark:border-gray-600 peer-checked:border-teal-500 peer-checked:bg-teal-500 peer-checked:text-white font-bold text-lg transition-all duration-200" x-text="i"></div>
                                </label>
                            </template>
                        </div>
                        
                        <div class="mt-3">
                            <p class="text-sm text-gray-600 dark:text-gray-400 text-center" x-show="frequencyCount > 0">
                                <span class="font-semibold text-teal-600 dark:text-teal-400" x-text="frequencyCount"></span>
                                time<span x-show="frequencyCount > 1">s</span> per 
                                <span x-text="frequencyType"></span>
                            </p>
                        </div>
                        
                        @error('frequency_count')
                            <p class="mt-2 text-sm text-red-600 flex items-center space-x-1">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                <span>{{ $message }}</span>
                            </p>
                        @enderror
                    </div>

                    <!-- Weekly frequency config -->
                    <div x-show="frequencyType === 'weekly'" x-transition class="mb-6">
                        <label class="block text-sm font-bold text-gray-800 dark:text-gray-100 mb-2 flex items-center space-x-2">
                            <svg class="w-4 h-4 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                            </svg>
                            <span>On which days? <span class="text-xs text-gray-500 font-normal">(Optional - leave blank for any days)</span></span>
                        </label>
                        
                        <div class="grid grid-cols-7 gap-2">
                            <template x-for="(day, index) in ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']" :key="index">
                                <label class="cursor-pointer">
                                    <input type="checkbox" name="weekly_days[]" :value="index + 1" class="sr-only peer">
                                    <div class="aspect-square flex items-center justify-center rounded-lg border-2 border-gray-300 dark:border-gray-600 peer-checked:border-blue-500 peer-checked:bg-blue-500 peer-checked:text-white font-semibold text-xs transition-all duration-200" x-text="day"></div>
                                </label>
                            </template>
                        </div>
                    </div>

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

    <script>
        function habitForm() {
            return {
                useExisting: {{ count($goalsLibrary) > 0 ? 'true' : 'false' }},
                selectedGoalId: '',
                frequencyType: 'daily',
                frequencyCount: 1
            }
        }
    </script>
</x-app-layout>
