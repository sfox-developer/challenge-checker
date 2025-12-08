<x-app-layout>
    <x-slot name="header">
        <x-page-header title="My Challenges">
            <x-slot name="icon">
                <svg class="w-6 h-6 text-slate-700 dark:text-slate-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
            </x-slot>
            <x-slot name="action">
                <x-app-button variant="primary" href="{{ route('challenges.create') }}" class="w-full sm:w-auto">
                    <x-slot name="icon">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"></path>
                        </svg>
                    </x-slot>
                    <span class="hidden sm:inline">Create New Challenge</span>
                    <span class="sm:hidden">New Challenge</span>
                </x-app-button>
            </x-slot>
        </x-page-header>
    </x-slot>

    <div class="py-8" x-data="{ activeFilter: 'all' }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Challenge Statistics -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6 mb-8">
                <x-stat-card 
                    label="Total Challenges" 
                    :value="$totalChallenges">
                    <x-slot name="icon">
                        <svg class="w-5 h-5 md:w-6 md:h-6 text-slate-700 dark:text-slate-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2 6a2 2 0 012-2h5l2 2h5a2 2 0 012 2v6a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"></path>
                        </svg>
                    </x-slot>
                </x-stat-card>

                <x-stat-card 
                    label="Completed" 
                    :value="$challenges->where('completed_at', '!=', null)->count()">
                    <x-slot name="icon">
                        <svg class="w-5 h-5 md:w-6 md:h-6 text-slate-700 dark:text-slate-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                    </x-slot>
                </x-stat-card>

                <x-stat-card 
                    label="Active Challenges" 
                    :value="$activeChallenges">
                    <x-slot name="icon">
                        <svg class="w-5 h-5 md:w-6 md:h-6 text-slate-700 dark:text-slate-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.293l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13a1 1 0 102 0V9.414l1.293 1.293a1 1 0 001.414-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </x-slot>
                </x-stat-card>

                <x-stat-card 
                    label="Draft" 
                    :value="$challenges->where('started_at', null)->count()">
                    <x-slot name="icon">
                        <svg class="w-5 h-5 md:w-6 md:h-6 text-slate-700 dark:text-slate-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"></path>
                        </svg>
                    </x-slot>
                </x-stat-card>
            </div>

            <!-- Filter Tabs -->
            <div class="tab-header tab-header-purple">
                <nav class="tab-nav">
                    <button @click="activeFilter = 'all'" :class="activeFilter === 'all' ? 'tab-button active' : 'tab-button'">
                        All
                        <span class="tab-count-badge" :class="activeFilter === 'all' ? 'active' : 'inactive'">
                            {{ $allCount }}
                        </span>
                    </button>
                    <button @click="activeFilter = 'active'" :class="activeFilter === 'active' ? 'tab-button active' : 'tab-button'">
                        Active
                        <span class="tab-count-badge" :class="activeFilter === 'active' ? 'active' : 'inactive'">
                            {{ $activeCount }}
                        </span>
                    </button>
                    <button @click="activeFilter = 'paused'" :class="activeFilter === 'paused' ? 'tab-button active' : 'tab-button'">
                        Paused
                        <span class="tab-count-badge" :class="activeFilter === 'paused' ? 'active' : 'inactive'">
                            {{ $pausedCount }}
                        </span>
                    </button>
                    <button @click="activeFilter = 'completed'" :class="activeFilter === 'completed' ? 'tab-button active' : 'tab-button'">
                        Completed
                        <span class="tab-count-badge" :class="activeFilter === 'completed' ? 'active' : 'inactive'">
                            {{ $completedCount }}
                        </span>
                    </button>
                    <button @click="activeFilter = 'draft'" :class="activeFilter === 'draft' ? 'tab-button active' : 'tab-button'">
                        Draft
                        <span class="tab-count-badge" :class="activeFilter === 'draft' ? 'active' : 'inactive'">
                            {{ $draftCount }}
                        </span>
                    </button>
                    <button @click="activeFilter = 'archived'" :class="activeFilter === 'archived' ? 'tab-button active' : 'tab-button'">
                        Archived
                        <span class="tab-count-badge" :class="activeFilter === 'archived' ? 'active' : 'inactive'">
                            {{ $archivedCount }}
                        </span>
                    </button>
                </nav>
            </div>

            @if($challenges->isNotEmpty())
            <div class="space-y-3">
                @foreach($challenges as $challenge)
                    @php
                        $isArchived = $challenge->isArchived();
                        $isActive = $challenge->started_at && $challenge->is_active && !$challenge->completed_at && !$isArchived;
                        $isPaused = $challenge->started_at && !$challenge->is_active && !$challenge->completed_at && !$isArchived;
                        $isCompleted = $challenge->completed_at !== null && !$isArchived;
                        $isDraft = !$challenge->started_at && !$isArchived;
                    @endphp
                    <div 
                        x-show="activeFilter === 'all' || 
                                (activeFilter === 'archived' && {{ $isArchived ? 'true' : 'false' }}) || 
                                (activeFilter === 'active' && {{ $isActive ? 'true' : 'false' }}) || 
                                (activeFilter === 'paused' && {{ $isPaused ? 'true' : 'false' }}) || 
                                (activeFilter === 'completed' && {{ $isCompleted ? 'true' : 'false' }}) || 
                                (activeFilter === 'draft' && {{ $isDraft ? 'true' : 'false' }})"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 transform scale-95"
                        x-transition:enter-end="opacity-100 transform scale-100"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 transform scale-100"
                        x-transition:leave-end="opacity-0 transform scale-95">
                        
                        <x-challenge-list-item :challenge="$challenge" />
                    </div>
                @endforeach
            </div>
            @else
                <div class="card">
                    <div class="p-8 text-center">
                        <div class="empty-state-icon-lg">
                            <svg class="w-10 h-10 text-slate-700" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <h3 class="empty-state-title">Ready to Start Your Journey?</h3>
                        <p class="empty-state-text mb-8 max-w-md mx-auto">Create your first challenge and begin tracking your progress towards your goals!</p>
                        <div class="mt-8">
                            <x-app-button variant="primary" href="{{ route('challenges.create') }}" class="inline-flex">
                                <x-slot name="icon">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"></path>
                                    </svg>
                                </x-slot>
                                <span class="text-lg">Create Your First Challenge</span>
                            </x-app-button>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>