<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center space-x-3">
            <div class="bg-gradient-to-r from-blue-500 to-purple-500 p-2 rounded-lg">
                <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
            <span>{{ __('Search Users') }}</span>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Search Form -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <form method="GET" action="{{ route('users.search') }}" class="space-y-4">
                        <div>
                            <label for="query" class="block text-sm font-medium text-gray-700 mb-2">Find users by name or email</label>
                            <div class="flex gap-2">
                                <input 
                                    type="text" 
                                    name="query" 
                                    id="query" 
                                    value="{{ old('query', $query) }}" 
                                    placeholder="Enter at least 2 characters..."
                                    class="flex-1 rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                    autofocus>
                                <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition-colors duration-200">
                                    Search
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Search Results -->
            @if($query)
                <div class="space-y-4">
                    @forelse($users as $user)
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition-shadow duration-200">
                            <div class="p-6">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-4">
                                        <div class="flex-shrink-0">
                                            <img src="{{ $user->getAvatarUrl() }}" alt="{{ $user->name }}" class="h-14 w-14 rounded-full ring-2 ring-white shadow-sm">
                                        </div>
                                        <div>
                                            <a href="{{ route('users.show', $user) }}" class="text-lg font-semibold text-gray-900 hover:text-blue-600">
                                                {{ $user->name }}
                                            </a>
                                            <div class="flex items-center space-x-4 mt-1 text-sm text-gray-600">
                                                <span>{{ $user->followers_count }} {{ Str::plural('follower', $user->followers_count) }}</span>
                                                <span>{{ $user->following_count }} following</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        @if(auth()->user()->isFollowing($user))
                                            <form action="{{ route('social.unfollow', $user) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="px-4 py-2 border border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition-colors duration-200">
                                                    Following
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route('social.follow', $user) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition-colors duration-200">
                                                    Follow
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-12 text-center">
                                <div class="mx-auto w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">No users found</h3>
                                <p class="text-gray-600">Try searching with a different term.</p>
                            </div>
                        </div>
                    @endforelse
                </div>
            @else
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-12 text-center">
                        <div class="mx-auto w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                            <svg class="w-8 h-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Start searching</h3>
                        <p class="text-gray-600">Enter a name or email to find other users.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
