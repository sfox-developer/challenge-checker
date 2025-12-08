<x-app-layout>
    <x-slot name="header">
        <x-page-header 
            title="Habits" 
            gradient="success">
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
            <div class="tab-header tab-header-teal">
                <nav class="tab-nav">
                    <a href="{{ route('habits.index', ['filter' => 'active']) }}" 
                       class="@if($filter === 'active') tab-button active @else tab-button @endif">
                        Active
                    </a>
                    <a href="{{ route('habits.index', ['filter' => 'all']) }}" 
                       class="@if($filter === 'all') tab-button active @else tab-button @endif">
                        All
                    </a>
                    <a href="{{ route('habits.index', ['filter' => 'archived']) }}" 
                       class="@if($filter === 'archived') tab-button active @else tab-button @endif">
                        Archived
                    </a>
                </nav>
            </div>

            <!-- Habits List -->
            @if($habits->isEmpty())
                <div class="empty-state-card">
                    <div class="empty-state-icon">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                    <h3 class="empty-state-title">No habits found</h3>
                    <p class="empty-state-message">Get started by creating a new habit.</p>
                    <div class="empty-state-action">
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
                <div class="space-y-3">
                    @foreach($habits as $habit)
                        <a href="{{ route('habits.show', $habit) }}" class="card card-link group">
                            <div class="flex items-center gap-4">
                                <!-- Icon -->
                                <div class="flex-shrink-0 w-12 h-12 bg-green-500 rounded-lg flex items-center justify-center text-white text-2xl">
                                    {{ $habit->goal->icon ?? '✓' }}
                                </div>
                                
                                <!-- Content -->
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-start justify-between gap-3 mb-2">
                                        <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100 group-hover:text-teal-600 dark:group-hover:text-teal-400 transition-colors">
                                            {{ $habit->goal_name }}
                                        </h4>
                                        
                                        <!-- Status Badge -->
                                        @if($habit->isCompletedToday())
                                            <span class="flex-shrink-0 inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-teal-100 text-teal-800 dark:bg-teal-900 dark:text-teal-200">
                                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                                </svg>
                                                Done
                                            </span>
                                        @endif
                                    </div>
                                    
                                    <!-- Frequency -->
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-3">
                                        {{ $habit->getFrequencyDescription() }}
                                    </p>
                                    
                                    <!-- Stats Row -->
                                    <div class="flex items-center gap-4 text-xs text-gray-500 dark:text-gray-400">
                                        @if($habit->statistics && $habit->statistics->current_streak > 0)
                                            <span class="flex items-center gap-1 font-medium">
                                                🔥 {{ $habit->statistics->current_streak }} streak
                                            </span>
                                        @endif
                                        @if($habit->statistics)
                                            <span>{{ $habit->statistics->total_completions }} completions</span>
                                        @endif
                                    </div>
                                </div>
                                
                                <!-- Arrow -->
                                <div class="flex-shrink-0">
                                    <svg class="w-5 h-5 text-gray-400 group-hover:text-teal-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>


</x-app-layout>
