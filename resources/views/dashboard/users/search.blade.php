<x-dashboard-layout>
    <x-slot name="title">{{ $query ? 'Search Users' : 'Discover Users' }}</x-slot>

    <x-dashboard.page-header 
        eyebrow="Community"
        title="{{ $query ? 'Search Users' : 'Discover Users' }}"
        description="{{ $query ? 'Find users matching your search' : 'Stay connected with your network and discover new members who share your goals and interests.' }}" />

    <div x-data="{ activeFilter: 'all' }">
        
        {{-- Search Form - Full Width Sticky --}}
        <div class="search-sticky" 
             x-data="{ 
                 isStuck: false
             }"
             x-init="
                 const checkSticky = () => {
                     const rect = $el.getBoundingClientRect();
                     isStuck = rect.top <= 80;
                 };
                 window.addEventListener('scroll', checkSticky);
             "
             :class="{ 'is-stuck': isStuck }">
            <form method="GET" action="{{ route('users.search') }}" class="search-container">
                <div class="search-input-wrapper">
                    <input 
                        type="text" 
                        name="query" 
                        id="query" 
                        value="{{ old('query', $query) }}" 
                        placeholder="Search by name or email..."
                        class="search-input"
                        autofocus>
                    <button type="submit" class="search-button">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </button>
                </div>
                @if($query)
                    <div class="mt-3 text-center">
                        <a href="{{ route('users.search') }}" class="search-clear">
                            ← Clear search
                        </a>
                    </div>
                @endif
            </form>
        </div>

        {{-- Discovery / Search Section --}}
        <div class="section pt-0">
            <div class="container max-w-4xl">
                {{-- Filter Tabs (only show when not searching) --}}
                @if(!$query && ($users->isNotEmpty() || $followingUsers->isNotEmpty()))
                    <x-users.filter-tabs 
                        :allCount="$users->count()"
                        :followingCount="$followingUsers->count()" />
                @endif

                {{-- Users List --}}
                @if($users->isNotEmpty())
                    <div class="space-y-4 mt-8"
                         x-show="activeFilter === 'all'"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 transform scale-95"
                         x-transition:enter-end="opacity-100 transform scale-100">
                        @foreach($users as $index => $user)
                            <x-users.user-card :user="$user" :index="$index" />
                        @endforeach
                    </div>

                    {{-- Following List (filtered view) --}}
                    @if($followingUsers->isNotEmpty())
                        <div class="space-y-4 mt-8"
                             x-show="activeFilter === 'following'"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 transform scale-95"
                             x-transition:enter-end="opacity-100 transform scale-100">
                            @foreach($followingUsers as $index => $user)
                                <x-users.user-card :user="$user" :index="$index" />
                            @endforeach
                        </div>
                    @endif
                @else
                    <x-users.empty-state 
                        :hasQuery="!!$query"
                        :hasFollowing="$followingUsers->isNotEmpty()" />
                @endif
            </div>
        </div>

        {{-- Benefits Section --}}
        <x-users.benefits-section />

        {{-- FAQ Section --}}
        <x-users.faq-section />
    </div>
</x-dashboard-layout>
