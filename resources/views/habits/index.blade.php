<x-app-layout>
    <x-slot name="header">
        <x-page-header title="My Habits" gradient="from-teal-500 to-cyan-500">
            <x-slot name="icon">
                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                    <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/>
                </svg>
            </x-slot>
            <x-slot name="action">
                <x-app-button variant="primary" href="{{ route('habits.create') }}" class="w-full sm:w-auto">
                    <x-slot name="icon">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"/>
                        </svg>
                    </x-slot>
                    <span class="hidden sm:inline">Create New Habit</span>
                    <span class="sm:hidden">New Habit</span>
                </x-app-button>
            </x-slot>
        </x-page-header>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Statistics -->
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4 md:gap-6">
                <x-stat-card 
                    label="Total Habits" 
                    :value="$totalHabits" 
                    gradientFrom="teal-500" 
                    gradientTo="cyan-500">
                    <x-slot name="icon">
                        <svg class="w-5 h-5 md:w-6 md:h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                            <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm9 4a1 1 0 102 0 1 1 0 00-2 0zm0 3a1 1 0 102 0 1 1 0 00-2 0zm0 3a1 1 0 102 0 1 1 0 00-2 0z" clip-rule="evenodd"/>
                        </svg>
                    </x-slot>
                </x-stat-card>

                <x-stat-card 
                    label="Completed Today" 
                    :value="$completedToday" 
                    gradientFrom="green-500" 
                    gradientTo="emerald-500">
                    <x-slot name="icon">
                        <svg class="w-5 h-5 md:w-6 md:h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                    </x-slot>
                </x-stat-card>

                <x-stat-card 
                    label="Active Streaks" 
                    :value="$currentStreaks" 
                    gradientFrom="orange-500" 
                    gradientTo="red-500">
                    <x-slot name="icon">
                        <svg class="w-5 h-5 md:w-6 md:h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05 6.981 6.981 0 003 11a7 7 0 1011.95-4.95c-.592-.591-.98-.985-1.348-1.467-.363-.476-.724-1.063-1.207-2.03zM12.12 15.12A3 3 0 017 13s.879.5 2.5.5c0-1 .5-4 1.25-4.5.5 1 .786 1.293 1.371 1.879A2.99 2.99 0 0113 13a2.99 2.99 0 01-.879 2.121z" clip-rule="evenodd"/>
                        </svg>
                    </x-slot>
                </x-stat-card>
            </div>

            <!-- Filter Tabs -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm">
                <div class="border-b border-gray-200 dark:border-gray-700">
                    <nav class="-mb-px flex space-x-8 px-6" aria-label="Tabs">
                        <a href="{{ route('habits.index', ['filter' => 'active']) }}" 
                           class="@if($filter === 'active') border-teal-500 text-teal-600 dark:text-teal-400 @else border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300 @endif whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                            Active
                        </a>
                        <a href="{{ route('habits.index', ['filter' => 'all']) }}" 
                           class="@if($filter === 'all') border-teal-500 text-teal-600 dark:text-teal-400 @else border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300 @endif whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                            All
                        </a>
                        <a href="{{ route('habits.index', ['filter' => 'archived']) }}" 
                           class="@if($filter === 'archived') border-teal-500 text-teal-600 dark:text-teal-400 @else border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300 @endif whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                            Archived
                        </a>
                    </nav>
                </div>
            </div>

            <!-- Habits List -->
            @if($habits->isEmpty())
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-12 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">No habits found</h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Get started by creating a new habit.</p>
                    <div class="mt-6">
                        <x-app-button variant="primary" href="{{ route('habits.create') }}">
                            <x-slot name="icon">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"/>
                                </svg>
                            </x-slot>
                            Create Your First Habit
                        </x-app-button>
                    </div>
                </div>
            @else
                @foreach($groupedHabits as $frequency => $frequencyHabits)
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm overflow-hidden">
                        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $frequency }} Habits</h3>
                        </div>
                        
                        <div class="divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($frequencyHabits as $habit)
                                <div class="p-6 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors" x-data="{ showNotes: false }">
                                    <div class="flex items-start justify-between">
                                        <div class="flex items-start space-x-4 flex-1">
                                            <!-- Toggle Checkbox -->
                                            <div class="flex-shrink-0 pt-1">
                                                <input 
                                                    type="checkbox" 
                                                    @if($habit->isCompletedToday()) checked @endif
                                                    class="w-5 h-5 rounded border-gray-300 text-teal-600 focus:ring-teal-500"
                                                    x-on:change="toggleHabit({{ $habit->id }})"
                                                >
                                            </div>
                                            
                                            <!-- Habit Info -->
                                            <div class="flex-1 min-w-0">
                                                <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                                    <a href="{{ route('habits.show', $habit) }}" class="hover:text-teal-600 dark:hover:text-teal-400">
                                                        {{ $habit->goal_name }}
                                                    </a>
                                                </h4>
                                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                                    {{ $habit->getFrequencyDescription() }}
                                                </p>
                                                
                                                <!-- Progress Bar for non-daily habits -->
                                                @if($habit->frequency_type->value !== 'daily')
                                                    <div class="mt-2">
                                                        <div class="flex items-center justify-between text-sm mb-1">
                                                            <span class="text-gray-600 dark:text-gray-400">{{ $habit->getProgressText() }}</span>
                                                            <span class="text-gray-600 dark:text-gray-400">{{ $habit->getProgressPercentage() }}%</span>
                                                        </div>
                                                        <div class="w-full bg-gray-200 dark:bg-gray-600 rounded-full h-2">
                                                            <div class="bg-teal-500 h-2 rounded-full transition-all" style="width: {{ $habit->getProgressPercentage() }}%"></div>
                                                        </div>
                                                    </div>
                                                @endif

                                                <!-- Statistics -->
                                                @if($habit->statistics)
                                                    <div class="flex items-center space-x-4 mt-3 text-sm">
                                                        @if($habit->statistics->current_streak > 0)
                                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200">
                                                                🔥 {{ $habit->statistics->current_streak }} day streak
                                                            </span>
                                                        @endif
                                                        <span class="text-gray-500 dark:text-gray-400">
                                                            {{ $habit->statistics->total_completions }} total completions
                                                        </span>
                                                    </div>
                                                @endif
                                            </div>

                                            <!-- Actions -->
                                            <div class="flex items-center space-x-2">
                                                <button 
                                                    @click="showNotes = !showNotes"
                                                    class="p-2 text-gray-400 hover:text-teal-600 dark:hover:text-teal-400 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors"
                                                    title="Add notes">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                                    </svg>
                                                </button>
                                                
                                                <a href="{{ route('habits.show', $habit) }}" 
                                                   class="p-2 text-gray-400 hover:text-teal-600 dark:hover:text-teal-400 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors"
                                                   title="View details">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                                    </svg>
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Notes Form (collapsible) -->
                                    <div x-show="showNotes" x-transition class="mt-4 pl-9">
                                        <form @submit.prevent="completeWithNotes({{ $habit->id }})" class="space-y-3">
                                            <div>
                                                <textarea 
                                                    name="notes" 
                                                    rows="2" 
                                                    class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:ring-teal-500 focus:border-teal-500"
                                                    placeholder="Add notes about this completion..."></textarea>
                                            </div>
                                            <div class="flex items-center space-x-4">
                                                <input 
                                                    type="number" 
                                                    name="duration_minutes" 
                                                    placeholder="Duration (min)" 
                                                    class="w-32 rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:ring-teal-500 focus:border-teal-500"
                                                >
                                                <select 
                                                    name="mood" 
                                                    class="rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:ring-teal-500 focus:border-teal-500">
                                                    <option value="">How did it feel?</option>
                                                    <option value="great">🤩 Great</option>
                                                    <option value="good">😊 Good</option>
                                                    <option value="neutral">😐 Neutral</option>
                                                    <option value="tired">😫 Tired</option>
                                                    <option value="struggling">😣 Struggling</option>
                                                </select>
                                                <button type="submit" class="px-4 py-2 bg-teal-600 text-white rounded-lg hover:bg-teal-700 transition-colors">
                                                    Save
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>

    @push('scripts')
    <script>
        function toggleHabit(habitId) {
            fetch(`/habits/${habitId}/toggle`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Optionally reload or update UI
                    window.location.reload();
                }
            })
            .catch(error => console.error('Error:', error));
        }

        function completeWithNotes(habitId) {
            const form = event.target;
            const formData = new FormData(form);
            
            fetch(`/habits/${habitId}/complete`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                },
                body: JSON.stringify(Object.fromEntries(formData)),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.reload();
                }
            })
            .catch(error => console.error('Error:', error));
        }
    </script>
    @endpush
</x-app-layout>
