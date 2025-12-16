<x-dashboard-layout>
    <x-slot name="title">Habits</x-slot>

    <x-dashboard.page-header 
        eyebrow="Daily Tracking"
        title="Habits"
        description="Build lasting habits with flexible frequency tracking" />

    <div x-data="{ activeFilter: 'active' }">
        {{-- Stats Section --}}
        <x-habits.stats-section 
            :totalHabits="$totalHabits" 
            :completedToday="$completedToday"
            :currentStreaks="$currentStreaks" />

        {{-- Hero Section --}}
        <x-habits.hero-section :isEmpty="$habits->isEmpty()" />

        {{-- Habits List Section --}}
        <div class="section pt-0">
            <div class="container max-w-4xl">
                @if($habits->isNotEmpty())
                    {{-- Create Habit CTA --}}
                    <div class="flex justify-center mb-8 animate animate-hidden-fade-up"
                         x-data="{}"
                         x-intersect="setTimeout(() => $el.classList.remove('animate-hidden-fade-up'), 500)">
                        <x-ui.app-button variant="primary" href="{{ route('habits.create') }}">
                            <x-slot name="icon">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"></path>
                                </svg>
                            </x-slot>
                            Create New Habit
                        </x-ui.app-button>
                    </div>
                @endif

                {{-- Filter Tabs --}}
                <x-habits.filter-tabs 
                    :allCount="$allCount"
                    :activeCount="$activeCount"
                    :archivedCount="$archivedCount" />

                {{-- Habit List or Empty State --}}
                @if($habits->isNotEmpty())
                    <div class="space-y-4 mt-8">
                        @foreach($habits as $index => $habit)
                            @php
                                $isArchived = $habit->archived_at !== null;
                                $isActive = !$isArchived;
                            @endphp
                            <div class="animate animate-hidden-fade-up-sm"
                                 x-intersect="setTimeout(() => $el.classList.remove('animate-hidden-fade-up-sm'), {{ $index * 100 }})"
                                 x-show="activeFilter === 'all' || 
                                        (activeFilter === 'archived' && {{ $isArchived ? 'true' : 'false' }}) || 
                                        (activeFilter === 'active' && {{ $isActive ? 'true' : 'false' }})"
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 transform scale-95"
                                 x-transition:enter-end="opacity-100 transform scale-100"
                                 x-transition:leave="transition ease-in duration-150"
                                 x-transition:leave-start="opacity-100 transform scale-100"
                                 x-transition:leave-end="opacity-0 transform scale-95">
                                
                                <x-habits.habit-list-item :habit="$habit" />
                            </div>
                        @endforeach
                    </div>
                @else
                    <x-habits.empty-state />
                @endif
            </div>
        </div>

        {{-- Benefits Section --}}
        <x-habits.benefits-section />

        {{-- FAQ Section --}}
        <x-habits.faq-section />
    </div>
</x-dashboard-layout>
