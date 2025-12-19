<x-dashboard-layout>
    <x-slot name="title">{{ $user->name }}</x-slot>

    <x-dashboard.page-header 
        eyebrow="Community"
        :title="$user->name"
        description="Profile and activity" />

    <div class="pb-12 md:pb-20" 
         x-data="followManager(
             {{ $isFollowing ? 'true' : 'false' }},
             {{ $user->followers_count }},
             {{ $user->id }}
         )">
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
                        <button @click="toggleFollow()"
                                :disabled="isLoading"
                                :class="isFollowing ? 'btn btn-secondary' : 'btn btn-primary'"
                                class="w-full sm:w-auto sm:min-w-[120px] transition-all duration-200 relative"
                                :style="isLoading ? 'cursor: wait;' : ''">
                            <span class="flex items-center justify-center gap-2"
                                  :class="isLoading ? 'opacity-70' : ''">
                                <svg x-show="isLoading" 
                                     x-transition:enter="transition ease-out duration-150"
                                     x-transition:enter-start="opacity-0 scale-50"
                                     x-transition:enter-end="opacity-100 scale-100"
                                     class="animate-spin h-4 w-4" 
                                     xmlns="http://www.w3.org/2000/svg" 
                                     fill="none" 
                                     viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <span x-text="isFollowing ? 'Following' : 'Follow'"></span>
                            </span>
                        </button>
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
                        <div class="text-3xl font-bold text-slate-700 dark:text-slate-400" x-text="followersCount"></div>
                        <div class="text-sm text-gray-600 dark:text-gray-400 mt-1" x-text="followersCount === 1 ? 'Follower' : 'Followers'"></div>
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
