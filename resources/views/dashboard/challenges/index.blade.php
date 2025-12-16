<x-dashboard-layout>
    <x-slot name="title">My Challenges</x-slot>

    <x-dashboard.page-header 
        eyebrow="Your Goals"
        title="Challenges"
        description="Track your progress on time-bound challenges" />

    <!-- Content -->
    <div class="pb-12 md:pb-20" x-data="{ activeFilter: 'all' }">
        <div class="container space-y-6">
            <!-- Challenge Statistics -->
            <div class="dashboard-grid-stats">
                <div class="animate animate-hidden-fade-up-sm"
                     x-data="{}"
                     x-intersect="setTimeout(() => $el.classList.remove('animate-hidden-fade-up-sm'), 100)">
                    <x-ui.stat-card 
                        variant="top"
                        label="Total Challenges" 
                        :value="$totalChallenges" />
                </div>

                <div class="animate animate-hidden-fade-up-sm"
                     x-data="{}"
                     x-intersect="setTimeout(() => $el.classList.remove('animate-hidden-fade-up-sm'), 200)">
                    <x-ui.stat-card 
                        variant="top"
                        label="Completed" 
                        :value="$challenges->where('completed_at', '!=', null)->count()" />
                </div>

                <div class="animate animate-hidden-fade-up-sm"
                     x-data="{}"
                     x-intersect="setTimeout(() => $el.classList.remove('animate-hidden-fade-up-sm'), 300)">
                    <x-ui.stat-card 
                        variant="top"
                        label="Active Challenges" 
                        :value="$activeChallenges" />
                </div>

                <div class="animate animate-hidden-fade-up-sm"
                     x-data="{}"
                     x-intersect="setTimeout(() => $el.classList.remove('animate-hidden-fade-up-sm'), 400)">
                    <x-ui.stat-card 
                        variant="top"
                        label="Draft" 
                        :value="$challenges->where('started_at', null)->count()" />
                </div>
            </div>

            <!-- Create Challenge CTA -->
            <div class="flex justify-center animate animate-hidden-fade-up"
                 x-data="{}"
                 x-intersect="setTimeout(() => $el.classList.remove('animate-hidden-fade-up'), 500)">
                <x-ui.app-button variant="primary" href="{{ route('challenges.create') }}">
                    <x-slot name="icon">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"></path>
                        </svg>
                    </x-slot>
                    Create New Challenge
                </x-ui.app-button>
            </div>

            <!-- Filter Tabs -->
            <div class="tab-header tab-header-purple animate animate-hidden-fade-up"
                 x-data="{}"
                 x-intersect="setTimeout(() => $el.classList.remove('animate-hidden-fade-up'), 600)">
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
            <div class="space-y-4" x-data="{}">
                @foreach($challenges as $index => $challenge)
                    @php
                        $isArchived = $challenge->isArchived();
                        $isActive = $challenge->started_at && $challenge->is_active && !$challenge->completed_at && !$isArchived;
                        $isPaused = $challenge->started_at && !$challenge->is_active && !$challenge->completed_at && !$isArchived;
                        $isCompleted = $challenge->completed_at !== null && !$isArchived;
                        $isDraft = !$challenge->started_at && !$isArchived;
                    @endphp
                    <div class="animate animate-hidden-fade-up-sm"
                         x-intersect="setTimeout(() => $el.classList.remove('animate-hidden-fade-up-sm'), {{ $index * 100 }})"
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
                        
                        <x-challenges.challenge-list-item :challenge="$challenge" />
                    </div>
                @endforeach
            </div>
            @else
                <div class="empty-state-card animate animate-hidden-scale-up"
                     x-data="{}"
                     x-intersect="$el.classList.remove('animate-hidden-scale-up')">
                    <div class="empty-state-icon">
                        <svg fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <h3 class="empty-state-title">Ready to Start Your Journey?</h3>
                    <p class="empty-state-text">Create your first challenge and begin tracking your progress towards your goals!</p>
                    <div class="empty-state-cta">
                        <x-ui.app-button variant="primary" href="{{ route('challenges.create') }}" class="inline-flex">
                            <x-slot name="icon">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"></path>
                                </svg>
                            </x-slot>
                            Create Your First Challenge
                        </x-ui.app-button>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-dashboard-layout>