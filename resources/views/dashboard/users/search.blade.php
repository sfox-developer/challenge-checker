<x-dashboard-layout>
    <x-slot name="header">
        <x-ui.page-header :title="$query ? 'Search Users' : 'Discover Users'">
            <x-slot name="icon">
                <svg class="w-6 h-6 text-slate-700 dark:text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </x-slot>
        </x-ui.page-header>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Search Form -->
            <div class="card mb-6">
                <form method="GET" action="{{ route('users.search') }}" class="space-y-4">
                    <div>
                        <label for="query" class="block text-sm font-medium text-gray-800 dark:text-gray-100 mb-2">Find users by name or email</label>
                        <div class="flex gap-2">
                            <input 
                                type="text" 
                                name="query" 
                                id="query" 
                                value="{{ old('query', $query) }}" 
                                placeholder="Enter at least 2 characters..."
                                class="flex-1 rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 shadow-sm focus:border-slate-600 focus:ring-slate-500"
                                autofocus>
                            <x-ui.app-button variant="secondary" type="submit">
                                Search
                            </x-ui.app-button>
                        </div>
                        @if($query)
                            <div class="mt-2">
                                <a href="{{ route('users.search') }}" class="text-sm text-slate-700 dark:text-slate-400 hover:text-slate-600">
                                        ← Back to discovery
                                </a>
                            </div>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Results Header -->
            @if(!$query)
                <div class="mb-6 text-center">
                    <h3 class="h3 mb-2">
                        ✨ Discover Active Users
                    </h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        Connect with users who have been active recently
                    </p>
                </div>
            @endif

            <!-- Search Results / Discovery -->
            @if($query || $users->isNotEmpty())
                <div class="space-y-4">
                    @forelse($users as $user)
                        <div class="card card-hover">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-4">
                                    <div class="flex-shrink-0">
                                        <img src="{{ $user->getAvatarUrl() }}" alt="{{ $user->name }}" class="h-14 w-14 rounded-full ring-2 ring-white shadow-sm">
                                    </div>
                                    <div>
                                        <a href="{{ route('users.show', $user) }}" class="h3 hover:text-slate-700 dark:hover:text-slate-400">
                                            {{ $user->name }}
                                        </a>
                                        <div class="flex items-center space-x-4 mt-1 text-sm text-gray-600 dark:text-gray-400">
                                            <span>{{ $user->followers_count }} {{ Str::plural('follower', $user->followers_count) }}</span>
                                            <span>{{ $user->following_count }} following</span>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    @if(auth()->user()->isFollowing($user))
                                        <form action="{{ route('social.unfollow', $user) }}" method="POST">
                                            @csrf
                                            <x-ui.app-button variant="secondary" type="submit">
                                                Following
                                            </x-ui.app-button>
                                        </form>
                                    @else
                                        <form action="{{ route('social.follow', $user) }}" method="POST">
                                            @csrf
                                            <x-ui.app-button variant="secondary" type="submit">
                                                Follow
                                            </x-ui.app-button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="empty-state-card">
                            <div class="empty-state-icon">
                                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                            <h3 class="empty-state-title">No users found</h3>
                            <p class="empty-state-text">Try searching with a different term.</p>
                        </div>
                    @endforelse
                </div>
            @else
                <div class="empty-state-card">
                    <div class="empty-state-icon">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <h3 class="empty-state-title">Start searching</h3>
                    <p class="empty-state-text">Enter a name or email to find other users.</p>
                </div>
            @endif
        </div>
    </div>
</x-dashboard-layout>
