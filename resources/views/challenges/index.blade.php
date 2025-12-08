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
                    </button>
                    <button @click="activeFilter = 'active'" :class="activeFilter === 'active' ? 'tab-button active' : 'tab-button'">
                        Active
                    </button>
                    <button @click="activeFilter = 'paused'" :class="activeFilter === 'paused' ? 'tab-button active' : 'tab-button'">
                        Paused
                    </button>
                    <button @click="activeFilter = 'completed'" :class="activeFilter === 'completed' ? 'tab-button active' : 'tab-button'">
                        Completed
                    </button>
                    <button @click="activeFilter = 'draft'" :class="activeFilter === 'draft' ? 'tab-button active' : 'tab-button'">
                        Draft
                    </button>
                    <button @click="activeFilter = 'archived'" :class="activeFilter === 'archived' ? 'tab-button active' : 'tab-button'">
                        Archived
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
                        
                        <a href="{{ route('challenges.show', $challenge) }}" class="card card-link group">
                            <div class="flex items-center gap-4">
                                <!-- Icon -->
                                <div class="flex-shrink-0 w-12 h-12 bg-slate-100 dark:bg-slate-900 rounded-lg flex items-center justify-center text-slate-700 dark:text-slate-400 text-2xl">
                                    @if($challenge->completed_at)
                                        ✓
                                    @elseif($challenge->is_active)
                                        🏃
                                    @elseif($challenge->started_at)
                                        ⏸️
                                    @else
                                        📝
                                    @endif
                                </div>
                                
                                <!-- Content -->
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-start justify-between gap-3 mb-2">
                                        <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100 group-hover:text-slate-700 dark:group-hover:text-slate-400 transition-colors">
                                            {{ $challenge->name }}
                                        </h4>
                                        
                                        <!-- Status Badge -->
                                        @if($challenge->isArchived())
                                            <span class="badge-challenge-archived flex-shrink-0">📁 Archived</span>
                                        @elseif($challenge->completed_at)
                                            <span class="badge-completed flex-shrink-0">✓ Completed</span>
                                        @elseif($challenge->is_active)
                                            <span class="badge-challenge-active flex-shrink-0">Active</span>
                                        @elseif($challenge->started_at)
                                            <span class="badge-challenge-paused flex-shrink-0">Paused</span>
                                        @else
                                            <span class="badge-challenge-draft flex-shrink-0">Draft</span>
                                        @endif
                                    </div>
                                    
                                    <!-- Description -->
                                    @if($challenge->description)
                                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-3">
                                            {{ Str::limit($challenge->description, 100) }}
                                        </p>
                                    @endif
                                    
                                    <!-- Stats Row -->
                                    <div class="flex flex-wrap items-center gap-3 text-xs text-gray-500 dark:text-gray-400">
                                        <span class="flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                            </svg>
                                            {{ $challenge->getFrequencyDescription() }}
                                        </span>
                                        @if($challenge->days_duration)
                                            <span class="flex items-center gap-1">
                                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                                </svg>
                                                {{ $challenge->days_duration }} days
                                            </span>
                                        @endif
                                        <span class="flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                                            </svg>
                                            {{ $challenge->goals->count() }} {{ Str::plural('goal', $challenge->goals->count()) }}
                                        </span>
                                        @if($isActive)
                                            <span class="flex items-center gap-1 font-medium text-slate-700 dark:text-slate-400">
                                                {{ number_format($challenge->getProgressPercentage(), 0) }}% complete
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                
                                <!-- Arrow -->
                                <div class="flex-shrink-0">
                                    <svg class="w-5 h-5 text-gray-400 group-hover:text-slate-600 dark:group-hover:text-slate-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </div>
                            </div>
                        </a>
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