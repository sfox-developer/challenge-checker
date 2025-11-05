<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-3">
            <div class="bg-gradient-to-r from-green-500 to-teal-500 p-2 rounded-lg">
                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"></path>
                </svg>
            </div>
            <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                {{ __('Create New Challenge') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gradient-to-br from-white to-gray-50 overflow-hidden shadow-xl rounded-2xl border border-gray-200">
                <div class="p-8">
                    <form action="{{ route('challenges.store') }}" method="POST" id="challenge-form">
                        @csrf
                        
                        <!-- Challenge Name -->
                        <div class="mb-6">
                            <label for="name" class="block text-sm font-bold text-gray-800 mb-2 flex items-center space-x-2">
                                <svg class="w-4 h-4 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 2L3 7v11a1 1 0 001 1h3a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1h3a1 1 0 001-1V7l-7-5z" clip-rule="evenodd"></path>
                                </svg>
                                <span>Challenge Name</span>
                            </label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" 
                                   class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition-all duration-200" 
                                   placeholder="e.g., 30-Day Fitness Challenge" required>
                            @error('name')
                                <p class="mt-2 text-sm text-red-600 flex items-center space-x-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span>{{ $message }}</span>
                                </p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="mb-6">
                            <label for="description" class="block text-sm font-bold text-gray-800 mb-2 flex items-center space-x-2">
                                <svg class="w-4 h-4 text-purple-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"></path>
                                </svg>
                                <span>Description</span>
                                <span class="text-xs text-gray-500 font-normal">(Optional)</span>
                            </label>
                            <textarea name="description" id="description" rows="3" 
                                      class="w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-2 focus:ring-purple-500 focus:ring-opacity-50 transition-all duration-200" 
                                      placeholder="Describe what this challenge is about...">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="mt-2 text-sm text-red-600 flex items-center space-x-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span>{{ $message }}</span>
                                </p>
                            @enderror
                        </div>

                        <!-- Duration -->
                        <div class="mb-6">
                            <label for="days_duration" class="block text-sm font-bold text-gray-800 mb-2 flex items-center space-x-2">
                                <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                </svg>
                                <span>Duration (Days)</span>
                            </label>
                            <div class="relative">
                                <input type="number" name="days_duration" id="days_duration" value="{{ old('days_duration', 30) }}" 
                                       min="1" max="365"
                                       class="w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-2 focus:ring-green-500 focus:ring-opacity-50 transition-all duration-200 pr-16" required>
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
                        <div class="mb-6">
                            <div class="flex items-start">
                                <div class="flex items-center h-5">
                                    <input type="checkbox" name="is_public" id="is_public" value="1" {{ old('is_public') ? 'checked' : '' }}
                                           class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition-all duration-200">
                                </div>
                                <div class="ml-3">
                                    <label for="is_public" class="text-sm font-bold text-gray-800 flex items-center space-x-2">
                                        <svg class="w-4 h-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <span>Make this challenge public</span>
                                    </label>
                                    <p class="text-xs text-gray-500 mt-1">Other users will be able to see this challenge in their feed</p>
                                </div>
                            </div>
                        </div>

                        <!-- Goals Section -->
                        <div class="mb-8">
                            <div class="flex justify-between items-center mb-4">
                                <label class="block text-sm font-bold text-gray-800 flex items-center space-x-2">
                                    <svg class="w-4 h-4 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span>Goals</span>
                                </label>
                                <button type="button" onclick="addGoal()" class="bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white text-sm font-semibold py-2 px-4 rounded-lg shadow-md hover:shadow-lg transform hover:scale-105 transition-all duration-200 flex items-center space-x-2">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span>Add Goal</span>
                                </button>
                            </div>
                            
                            <div id="goals-container">
                                <!-- Goals will be added dynamically -->
                            </div>
                            
                            @error('goals')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex justify-between space-x-4 pt-6 border-t border-gray-200">
                            <a href="{{ route('challenges.index') }}" class="bg-white hover:bg-gray-50 text-gray-700 border border-gray-300 font-semibold py-3 px-6 rounded-lg shadow-sm hover:shadow-md transform hover:scale-105 transition-all duration-200 flex items-center space-x-2">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"></path>
                                </svg>
                                <span>Cancel</span>
                            </a>
                            <button type="submit" class="bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-bold py-3 px-8 rounded-lg shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200 flex items-center space-x-2">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                <span>Create Challenge</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        let goalCount = 0;

        function addGoal() {
            const container = document.getElementById('goals-container');
            const goalDiv = document.createElement('div');
            goalDiv.className = 'goal-item mb-6 p-6 border-2 border-dashed border-gray-300 rounded-xl bg-gradient-to-br from-gray-50 to-white hover:border-blue-400 transition-all duration-200';
            goalDiv.innerHTML = `
                <div class="flex justify-between items-center mb-4">
                    <div class="flex items-center space-x-2">
                        <div class="bg-gradient-to-r from-blue-500 to-purple-500 text-white w-6 h-6 rounded-full flex items-center justify-center text-sm font-bold">
                            ${goalCount + 1}
                        </div>
                        <h4 class="text-lg font-bold text-gray-800">Goal ${goalCount + 1}</h4>
                    </div>
                    <button type="button" onclick="removeGoal(this)" class="bg-red-100 hover:bg-red-200 text-red-600 hover:text-red-700 p-2 rounded-lg transition-all duration-200 flex items-center space-x-1">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-sm">Remove</span>
                    </button>
                </div>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2 flex items-center space-x-2">
                            <svg class="w-4 h-4 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <span>Goal Name</span>
                        </label>
                        <input type="text" name="goals[${goalCount}][name]" 
                               class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition-all duration-200" 
                               placeholder="e.g., Exercise for 30 minutes" required>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2 flex items-center space-x-2">
                            <svg class="w-4 h-4 text-purple-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"></path>
                            </svg>
                            <span>Description</span>
                            <span class="text-xs text-gray-500 font-normal">(Optional)</span>
                        </label>
                        <input type="text" name="goals[${goalCount}][description]" 
                               class="w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-2 focus:ring-purple-500 focus:ring-opacity-50 transition-all duration-200" 
                               placeholder="Additional details about this goal">
                    </div>
                </div>
            `;
            container.appendChild(goalDiv);
            goalCount++;
            updateGoalNumbers();
        }

        function removeGoal(button) {
            button.closest('.goal-item').remove();
            updateGoalNumbers();
        }

        function updateGoalNumbers() {
            const goalItems = document.querySelectorAll('.goal-item');
            goalItems.forEach((item, index) => {
                const title = item.querySelector('h4');
                title.textContent = `Goal ${index + 1}`;
                
                // Update input names to maintain proper indexing
                const nameInput = item.querySelector('input[name*="[name]"]');
                const descInput = item.querySelector('input[name*="[description]"]');
                
                nameInput.name = `goals[${index}][name]`;
                descInput.name = `goals[${index}][description]`;
            });
        }

        // Add initial goal on page load
        document.addEventListener('DOMContentLoaded', function() {
            addGoal();
        });

        // Add validation before form submission
        document.getElementById('challenge-form').addEventListener('submit', function(e) {
            const goalItems = document.querySelectorAll('.goal-item');
            if (goalItems.length === 0) {
                e.preventDefault();
                alert('Please add at least one goal to your challenge.');
                return false;
            }
        });
    </script>
</x-app-layout>