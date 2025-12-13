<x-dashboard-layout>
    <x-slot name="header">
        <x-ui.page-header :title="$user->name">
            <x-slot name="icon">
                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                </svg>
            </x-slot>
        </x-ui.page-header>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Profile Info -->
            <div class="card">
                <!-- Profile Header with Avatar and Name -->
                <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-6">
                    <div class="flex items-center space-x-4">
                        <img src="{{ $user->getAvatarUrl() }}" alt="{{ $user->name }}" class="h-20 w-20 sm:h-24 sm:w-24 rounded-full ring-4 ring-white shadow-lg flex-shrink-0">
                        <div class="min-w-0">
                            <h3 class="h2">{{ $user->name }}</h3>
                            <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400 truncate">{{ $user->email }}</p>
                        </div>
                    </div>
                        
                    <!-- Action Button -->
                    @if(Auth::id() === $user->id)
                        <x-ui.app-button variant="primary" href="{{ route('profile.edit') }}" class="w-full sm:w-auto">
                            <x-slot name="icon">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </x-slot>
                            Edit Profile
                        </x-ui.app-button>
                    @else
                        <div class="w-full sm:w-auto">
                            @if($isFollowing)
                                <form action="{{ route('social.unfollow', $user) }}" method="POST">
                                    @csrf
                                    <x-ui.app-button variant="secondary" type="submit" class="w-full sm:w-auto">
                                        Following
                                    </x-ui.app-button>
                                </form>
                            @else
                                <form action="{{ route('users.follow', $user) }}" method="POST">
                                    @csrf
                                    <x-ui.app-button variant="primary" type="submit" class="w-full sm:w-auto">
                                        Follow
                                    </x-ui.app-button>
                                </form>
                            @endif
                        </div>
                    @endif
                </div>

                <!-- Stats -->
                <div class="grid grid-cols-3 gap-4 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <div class="text-center">
                        <div class="text-3xl font-bold text-slate-700 dark:text-slate-400">{{ $user->challenges_count }}</div>
                        <div class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ Str::plural('Challenge', $user->challenges_count) }}</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-slate-700 dark:text-slate-400">{{ $user->habits_count }}</div>
                        <div class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ Str::plural('Habit', $user->habits_count) }}</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-slate-700 dark:text-slate-400">{{ $user->followers_count }}</div>
                        <div class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ Str::plural('Follower', $user->followers_count) }}</div>
                    </div>
                </div>
            </div>

            <!-- User Content Tabs -->
            <x-social.user-content-tabs 
                :user="$user" 
                :challenges="$publicChallenges"
                :habits="$publicHabits"
                :activities="$activities"
                defaultTab="activity" />
        </div>
    </div>
</x-dashboard-layout>
