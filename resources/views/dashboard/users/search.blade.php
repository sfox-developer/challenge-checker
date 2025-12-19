<x-dashboard-layout>
    <x-slot name="title">{{ $query ? 'Search Users' : 'Discover Users' }}</x-slot>

    <x-dashboard.page-header 
        eyebrow="Community"
        title="{{ $query ? 'Search Users' : 'Discover Users' }}"
        description="{{ $query ? 'Find users matching your search' : 'Stay connected with your network and discover new members who share your goals and interests.' }}" />

    <div x-data="{ activeFilter: 'all' }">
        
        {{-- Discovery / Search Section --}}
        <div class="section pt-0">
            <div class="container max-w-4xl">
                {{-- Search Form --}}
                <div class="card animate animate-hidden-fade-up mb-8"
                     x-data="{}"
                     x-intersect="setTimeout(() => $el.classList.remove('animate-hidden-fade-up'), 600)">
                    <form method="GET" action="{{ route('users.search') }}" class="space-y-4">
                        <div>
                            <label for="query" class="block text-sm font-medium text-gray-800 dark:text-gray-100 mb-2">
                                Find users by name or email
                            </label>
                            <div class="flex gap-2">
                                <input 
                                    type="text" 
                                    name="query" 
                                    id="query" 
                                    value="{{ old('query', $query) }}" 
                                    placeholder="Enter at least 2 characters..."
                                    class="flex-1 form-input"
                                    autofocus>
                                <x-ui.app-button variant="primary" type="submit">
                                    Search
                                </x-ui.app-button>
                            </div>
                            @if($query)
                                <div class="mt-2">
                                    <a href="{{ route('users.search') }}" 
                                       class="text-sm text-slate-700 dark:text-slate-400 hover:text-slate-600 dark:hover:text-slate-300">
                                        ← Back to discovery
                                    </a>
                                </div>
                            @endif
                        </div>
                    </form>
                </div>

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
