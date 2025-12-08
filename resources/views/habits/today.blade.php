<x-app-layout>
    <x-slot name="header">
        <x-page-header title="Today's Habits" gradient="success">
            <x-slot name="icon">
                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                </svg>
            </x-slot>
            <x-slot name="action">
                <x-app-button variant="secondary" href="{{ route('habits.index') }}">
                    All Habits
                </x-app-button>
            </x-slot>
        </x-page-header>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Today's Date and Stats -->
            <div class="text-center mb-6">
                <div class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                    {{ now()->format('l, F j, Y') }}
                </div>
                <div class="text-lg text-gray-600 dark:text-gray-400">
                    @if($stats['completed'] === $stats['total_due'] && $stats['total_due'] > 0)
                        🎉 All done for today! Keep up the great work!
                    @elseif($stats['completed'] > 0)
                        You've completed {{ $stats['completed'] }} of {{ $stats['total_due'] }} habits today
                    @else
                        You have {{ $stats['total_due'] }} habit{{ $stats['total_due'] !== 1 ? 's' : '' }} to complete today
                    @endif
                </div>
            </div>

            <!-- Progress Bar -->
            @if($stats['total_due'] > 0)
            <div class="card">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">Today's Progress</span>
                    <span class="text-sm font-bold text-teal-600 dark:text-teal-400">
                        {{ $stats['completed'] }}/{{ $stats['total_due'] }}
                    </span>
                </div>
                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-4">
                    <div class="bg-gradient-to-r from-teal-500 to-cyan-500 h-4 rounded-full transition-all duration-500"
                         style="width: {{ $stats['total_due'] > 0 ? round(($stats['completed'] / $stats['total_due']) * 100) : 0 }}%">
                    </div>
                </div>
            </div>
            @endif

            <!-- Habits List -->
            @if($todaysHabits->count() > 0)
                <div class="space-y-4">
                    @foreach($todaysHabits as $habit)
                        <div class="card hover:shadow-lg transition-shadow duration-200" 
                             x-data="{ 
                                 showNotes: false, 
                                 notes: '', 
                                 duration: '', 
                                 mood: '',
                                 isCompleted: {{ $habit->isCompletedToday() ? 'true' : 'false' }}
                             }">
                            
                            <!-- Habit Header -->
                            <div class="flex items-start space-x-4">
                                <!-- Quick Toggle Checkbox -->
                                <div class="flex-shrink-0 mt-1">
                                    <label class="cursor-pointer">
                                        <input type="checkbox" 
                                               :checked="isCompleted"
                                               @change="toggleHabitToday($event, {{ $habit->id }})"
                                               class="w-6 h-6 rounded border-2 border-gray-300 text-teal-600 focus:ring-2 focus:ring-teal-500 transition-all duration-200">
                                    </label>
                                </div>

                                <!-- Habit Info -->
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-start justify-between">
                                        <div class="flex-1">
                                            <div class="flex items-center space-x-2 mb-1">
                                                <span class="text-2xl">{{ $habit->goal->icon }}</span>
                                                <h3 class="text-lg font-bold text-gray-900 dark:text-white"
                                                    :class="{ 'line-through text-gray-500': isCompleted }">
                                                    {{ $habit->goal_name }}
                                                </h3>
                                            </div>
                                            
                                            <div class="flex flex-wrap items-center gap-3 text-sm text-gray-600 dark:text-gray-400">
                                                <span class="flex items-center space-x-1">
                                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                                    </svg>
                                                    <span>{{ $habit->getProgressText() }}</span>
                                                </span>
                                                
                                                @if($habit->statistics?->current_streak > 0)
                                                <span class="flex items-center space-x-1 text-yellow-600 dark:text-yellow-400">
                                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05 6.981 6.981 0 003 11a7 7 0 1011.95-4.95c-.592-.591-.98-.985-1.348-1.467-.363-.476-.724-1.063-1.207-2.03zM12.12 15.12A3 3 0 017 13s.879.5 2.5.5c0-1 .5-4 1.25-4.5.5 1 .786 1.293 1.371 1.879A2.99 2.99 0 0113 13a2.99 2.99 0 01-.879 2.121z" clip-rule="evenodd"/>
                                                    </svg>
                                                    <span>{{ $habit->statistics->current_streak }} streak</span>
                                                </span>
                                                @endif
                                            </div>
                                        </div>

                                        <!-- Actions -->
                                        <div class="flex items-center space-x-2 ml-4">
                                            <button type="button" 
                                                    @click="showNotes = !showNotes"
                                                    class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors"
                                                    title="Add notes">
                                                <svg class="w-5 h-5 text-gray-600 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                                                </svg>
                                            </button>
                                            
                                            <a href="{{ route('habits.show', $habit) }}" 
                                               class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors"
                                               title="View details">
                                                <svg class="w-5 h-5 text-gray-600 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                                                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                                                </svg>
                                            </a>
                                        </div>
                                    </div>

                                    <!-- Progress Bar for multi-count habits -->
                                    @if($habit->frequency_count > 1)
                                    <div class="mt-3">
                                        <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                            <div class="bg-gradient-to-r from-teal-500 to-cyan-500 h-2 rounded-full transition-all duration-300"
                                                 style="width: {{ $habit->getProgressPercentage() }}%">
                                            </div>
                                        </div>
                                    </div>
                                    @endif

                                    <!-- Notes Form (Collapsible) -->
                                    <div x-show="showNotes" 
                                         x-transition:enter="transition ease-out duration-200"
                                         x-transition:enter-start="opacity-0 transform -translate-y-2"
                                         x-transition:enter-end="opacity-100 transform translate-y-0"
                                         class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                                        
                                        <form @submit.prevent="completeWithNotesToday({{ $habit->id }})"
                                              class="space-y-3">
                                            
                                            <div>
                                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">
                                                    Notes (Optional)
                                                </label>
                                                <textarea x-model="notes" 
                                                          rows="2" 
                                                          class="app-input text-sm"
                                                          placeholder="How did it go? Any thoughts?"></textarea>
                                            </div>

                                            <div class="grid grid-cols-2 gap-3">
                                                <div>
                                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">
                                                        Duration (minutes)
                                                    </label>
                                                    <input type="number" 
                                                           x-model="duration" 
                                                           min="1" 
                                                           class="app-input text-sm"
                                                           placeholder="30">
                                                </div>

                                                <div>
                                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">
                                                        How do you feel?
                                                    </label>
                                                    <select x-model="mood" class="app-input text-sm">
                                                        <option value="">Select mood...</option>
                                                        <option value="great">😄 Great</option>
                                                        <option value="good">🙂 Good</option>
                                                        <option value="okay">😐 Okay</option>
                                                        <option value="tired">😴 Tired</option>
                                                        <option value="struggling">😓 Struggling</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="flex justify-end space-x-2">
                                                <button type="button" 
                                                        @click="showNotes = false"
                                                        class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors">
                                                    Cancel
                                                </button>
                                                <button type="submit" 
                                                        class="px-4 py-2 text-sm font-medium text-white bg-gradient-to-r from-teal-500 to-cyan-500 hover:from-teal-600 hover:to-cyan-600 rounded-lg transition-colors">
                                                    Save & Complete
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- Empty State -->
                <div class="card text-center py-12">
                    <div class="text-6xl mb-4">🎯</div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">No habits due today</h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-6">
                        You're all caught up! Create a new habit to get started.
                    </p>
                    <x-app-button variant="primary" href="{{ route('habits.create') }}">
                        Create Your First Habit
                    </x-app-button>
                </div>
            @endif

        </div>
    </div>

    <script>
        // Habit toggle functions are now global and imported from habitToggle.js
        // Create wrapper functions that pass the current date
        window.toggleHabitToday = (event, habitId) => toggleHabit(event, habitId, '{{ now()->toDateString() }}');
        window.completeWithNotesToday = (habitId) => completeWithNotes(habitId, '{{ now()->toDateString() }}');
        // showToast is already global
    </script>
</x-app-layout>
