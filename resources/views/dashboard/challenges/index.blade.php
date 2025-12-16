<x-dashboard-layout>
    <x-slot name="title">My Challenges</x-slot>

    <x-dashboard.page-header 
        eyebrow="Your Goals"
        title="Challenges"
        description="Track your progress on time-bound challenges" />

    <div x-data="{ activeFilter: 'all' }">
        {{-- Stats Section --}}
        <x-challenges.stats-section 
            :totalChallenges="$totalChallenges" 
            :completedCount="$challenges->where('completed_at', '!=', null)->count()" />

        {{-- Hero Section --}}
        <x-challenges.hero-section :isEmpty="$challenges->isEmpty()" />

        {{-- Challenges List Section --}}
        <div class="section pt-0">
            <div class="container max-w-4xl">
                @if($challenges->isNotEmpty())
                    {{-- Create Challenge CTA --}}
                    <div class="flex justify-center mb-8 animate animate-hidden-fade-up"
                         x-data="{}"
                         x-intersect="setTimeout(() => $el.classList.remove('animate-hidden-fade-up'), 500)">
                        <x-ui.app-button variant="primary" href="{{ route('challenges.create') }}">
                            <x-slot name="icon">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"></path>
                                </svg>
                            </x-slot>
                            Create New Challenge
                        </x-ui.app-button>
                    </div>
                @endif

                {{-- Filter Tabs --}}
                <x-challenges.filter-tabs 
                    :allCount="$allCount"
                    :activeCount="$activeCount"
                    :pausedCount="$pausedCount"
                    :completedCount="$completedCount"
                    :draftCount="$draftCount"
                    :archivedCount="$archivedCount" />

                {{-- Challenge List or Empty State --}}
                @if($challenges->isNotEmpty())
                    <div class="space-y-4 mt-8">
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
                    <x-challenges.empty-state />
                @endif
            </div>
        </div>

        {{-- Benefits Section --}}
        <x-challenges.benefits-section />

        {{-- FAQ Section --}}
        <x-challenges.faq-section />
    </div>
</x-dashboard-layout>
