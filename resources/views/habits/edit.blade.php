<x-app-layout>
    <x-slot name="header">
        <x-page-header title="Edit Habit" gradient="from-teal-500 to-cyan-500">
            <x-slot name="icon">
                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                </svg>
            </x-slot>
        </x-page-header>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="card">
                <form action="{{ route('habits.update', $habit) }}" method="POST" x-data="editHabitForm()">
                    @csrf
                    @method('PUT')
                    
                    <!-- Current Goal Display -->
                    <div class="mb-6 p-4 bg-teal-50 dark:bg-teal-900/20 rounded-lg">
                        <div class="flex items-center space-x-3">
                            <div class="text-3xl">{{ $habit->goal->icon }}</div>
                            <div class="flex-1">
                                <div class="font-bold text-gray-900 dark:text-white">{{ $habit->goal_name }}</div>
                                @if($habit->goal->description)
                                    <div class="text-sm text-gray-600 dark:text-gray-400">{{ $habit->goal->description }}</div>
                                @endif
                            </div>
                            <button type="button" 
                                    @click="changeGoal = !changeGoal"
                                    class="text-sm text-teal-600 dark:text-teal-400 hover:underline">
                                Change Goal
                            </button>
                        </div>
                    </div>

                    <!-- Change Goal Section -->
                    <div x-show="changeGoal" x-transition class="mb-6 p-4 border-2 border-teal-200 dark:border-teal-700 rounded-lg">
                        <label class="block text-sm font-bold text-gray-800 dark:text-gray-100 mb-2">
                            Select Different Goal
                        </label>
                        <select name="goal_library_id" class="app-input">
                            <option value="{{ $habit->goal_library_id }}" selected>Keep current goal</option>
                            @foreach($goalsLibrary as $goal)
                                @if($goal->id !== $habit->goal_library_id)
                                    <option value="{{ $goal->id }}">
                                        {{ $goal->icon }} {{ $goal->name }}
                                        @if($goal->category)
                                            ({{ ucfirst($goal->category) }})
                                        @endif
                                    </option>
                                @endif
                            @endforeach
                        </select>
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
                                <input type="radio" name="frequency_type" value="daily" 
                                       x-model="frequencyType" 
                                       {{ $habit->frequency_type->value === 'daily' ? 'checked' : '' }}
                                       class="sr-only peer">
                                <div class="p-4 text-center rounded-lg border-2 border-gray-300 dark:border-gray-600 peer-checked:border-teal-500 peer-checked:bg-teal-50 dark:peer-checked:bg-teal-900/20 transition-all duration-200">
                                    <div class="text-2xl mb-1">📅</div>
                                    <div class="text-sm font-semibold">Daily</div>
                                </div>
                            </label>
                            
                            <label class="cursor-pointer">
                                <input type="radio" name="frequency_type" value="weekly" 
                                       x-model="frequencyType"
                                       {{ $habit->frequency_type->value === 'weekly' ? 'checked' : '' }}
                                       class="sr-only peer">
                                <div class="p-4 text-center rounded-lg border-2 border-gray-300 dark:border-gray-600 peer-checked:border-teal-500 peer-checked:bg-teal-50 dark:peer-checked:bg-teal-900/20 transition-all duration-200">
                                    <div class="text-2xl mb-1">📆</div>
                                    <div class="text-sm font-semibold">Weekly</div>
                                </div>
                            </label>
                            
                            <label class="cursor-pointer">
                                <input type="radio" name="frequency_type" value="monthly" 
                                       x-model="frequencyType"
                                       {{ $habit->frequency_type->value === 'monthly' ? 'checked' : '' }}
                                       class="sr-only peer">
                                <div class="p-4 text-center rounded-lg border-2 border-gray-300 dark:border-gray-600 peer-checked:border-teal-500 peer-checked:bg-teal-50 dark:peer-checked:bg-teal-900/20 transition-all duration-200">
                                    <div class="text-2xl mb-1">🗓️</div>
                                    <div class="text-sm font-semibold">Monthly</div>
                                </div>
                            </label>
                            
                            <label class="cursor-pointer">
                                <input type="radio" name="frequency_type" value="yearly" 
                                       x-model="frequencyType"
                                       {{ $habit->frequency_type->value === 'yearly' ? 'checked' : '' }}
                                       class="sr-only peer">
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
                                    <input type="radio" name="frequency_count" :value="i" 
                                           x-model="frequencyCount"
                                           :checked="i === {{ $habit->frequency_count }}"
                                           class="sr-only peer">
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
                            <span>On which days? <span class="text-xs text-gray-500 font-normal">(Optional)</span></span>
                        </label>
                        
                        <div class="grid grid-cols-7 gap-2">
                            @php
                                $selectedDays = $habit->frequency_config['days'] ?? [];
                            @endphp
                            <template x-for="(day, index) in ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']" :key="index">
                                <label class="cursor-pointer">
                                    <input type="checkbox" name="weekly_days[]" :value="index + 1" 
                                           class="sr-only peer"
                                           :checked="[{{ implode(',', $selectedDays) }}].includes(index + 1)">
                                    <div class="aspect-square flex items-center justify-center rounded-lg border-2 border-gray-300 dark:border-gray-600 peer-checked:border-blue-500 peer-checked:bg-blue-500 peer-checked:text-white font-semibold text-xs transition-all duration-200" x-text="day"></div>
                                </label>
                            </template>
                        </div>
                    </div>

                    <!-- Active Status -->
                    <div class="mb-6">
                        <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-800 rounded-lg">
                            <div>
                                <div class="font-bold text-gray-900 dark:text-white">Habit Status</div>
                                <div class="text-sm text-gray-600 dark:text-gray-400">
                                    {{ $habit->is_active ? 'Active and tracking' : 'Paused' }}
                                </div>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="is_active" value="1" 
                                       {{ $habit->is_active ? 'checked' : '' }}
                                       class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-teal-300 dark:peer-focus:ring-teal-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-teal-500"></div>
                            </label>
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex space-x-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <button type="submit" class="flex-1 btn-primary">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            Save Changes
                        </button>
                        <a href="{{ route('habits.show', $habit) }}" class="btn-secondary">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function editHabitForm() {
            return {
                changeGoal: false,
                frequencyType: '{{ $habit->frequency_type->value }}',
                frequencyCount: {{ $habit->frequency_count }}
            }
        }
    </script>
</x-app-layout>
