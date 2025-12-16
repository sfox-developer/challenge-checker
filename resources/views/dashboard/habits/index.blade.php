<x-dashboard-layout>
    <x-slot name="title">Habits</x-slot>

    <x-dashboard.page-header 
        eyebrow="Daily Tracking"
        title="Habits"
        description="Build lasting habits with flexible frequency tracking" />

    <!-- Content -->
    <div class="pb-12 md:pb-20">
        <div class="container space-y-6">
            
            <!-- Statistics -->
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4 md:gap-6">
                <div class="opacity-0 translate-y-8 transition-all duration-700 ease-out"
                     x-data="{}"
                     x-init="setTimeout(() => { $el.classList.remove('opacity-0', 'translate-y-8') }, 100)">
                    <x-ui.stat-card 
                        label="Total Habits" 
                        :value="$totalHabits"
                        variant="top" />
                </div>

                <div class="opacity-0 translate-y-8 transition-all duration-700 ease-out"
                     x-data="{}"
                     x-init="setTimeout(() => { $el.classList.remove('opacity-0', 'translate-y-8') }, 200)">
                    <x-ui.stat-card 
                        label="Completed Today" 
                        :value="$completedToday"
                        variant="top" />
                </div>

                <div class="opacity-0 translate-y-8 transition-all duration-700 ease-out"
                     x-data="{}"
                     x-init="setTimeout(() => { $el.classList.remove('opacity-0', 'translate-y-8') }, 300)">
                    <x-ui.stat-card 
                        label="Active Streaks" 
                        :value="$currentStreaks"
                        variant="top" />
                </div>
            </div>

            <!-- Create Habit CTA -->
            <div class="flex justify-center opacity-0 translate-y-8 transition-all duration-700 ease-out"
                 x-data="{}"
                 x-intersect="$el.classList.remove('opacity-0', 'translate-y-8')">
                <x-ui.app-button variant="primary" href="{{ route('habits.create') }}">
                    <x-slot name="icon">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"></path>
                        </svg>
                    </x-slot>
                    Create New Habit
                </x-ui.app-button>
            </div>

            <!-- Filter Tabs -->
            <div class="tab-header tab-header-teal opacity-0 translate-y-8 transition-all duration-700 ease-out"
                 x-data="{}"
                 x-intersect="$el.classList.remove('opacity-0', 'translate-y-8')">
                <nav class="tab-nav">
                    <a href="{{ route('habits.index', ['filter' => 'active']) }}" 
                       class="@if($filter === 'active') tab-button active @else tab-button @endif">
                        Active
                        <span class="tab-count-badge {{ $filter === 'active' ? 'active' : 'inactive' }}">
                            {{ $activeCount }}
                        </span>
                    </a>
                    <a href="{{ route('habits.index', ['filter' => 'all']) }}" 
                       class="@if($filter === 'all') tab-button active @else tab-button @endif">
                        All
                        <span class="tab-count-badge {{ $filter === 'all' ? 'active' : 'inactive' }}">
                            {{ $allCount }}
                        </span>
                    </a>
                    <a href="{{ route('habits.index', ['filter' => 'archived']) }}" 
                       class="@if($filter === 'archived') tab-button active @else tab-button @endif">
                        Archived
                        <span class="tab-count-badge {{ $filter === 'archived' ? 'active' : 'inactive' }}">
                            {{ $archivedCount }}
                        </span>
                    </a>
                </nav>
            </div>

            <!-- Habits List -->
            @if($habits->isEmpty())
                <div class="empty-state-card opacity-0 translate-y-8 transition-all duration-700 ease-out"
                     x-data="{}"
                     x-intersect="$el.classList.remove('opacity-0', 'translate-y-8')">
                    <div class="empty-state-icon">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                    <h3 class="empty-state-title">No habits found</h3>
                    <p class="empty-state-text">Get started by creating a new habit.</p>
                    <div class="empty-state-cta">
                        <x-ui.app-button variant="primary" href="{{ route('habits.create') }}">
                            <x-slot name="icon">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"/>
                                </svg>
                            </x-slot>
                            Create Your First Habit
                        </x-ui.app-button>
                    </div>
                </div>
            @else
                <div class="habit-card-list">
                    @foreach($habits as $index => $habit)
                        <div class="opacity-0 translate-y-8 transition-all duration-700 ease-out"
                             x-data="{}"
                             x-intersect="setTimeout(() => $el.classList.remove('opacity-0', 'translate-y-8'), {{ $index % 5 * 100 }})">
                            <x-habits.habit-list-item :habit="$habit" />
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>


</x-dashboard-layout>
