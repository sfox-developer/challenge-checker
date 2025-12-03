<x-app-layout>
    <x-slot name="header">
        <x-page-header :title="$user->name">
            <x-slot name="icon">
                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                </svg>
            </x-slot>
        </x-page-header>
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
                            <h3 class="text-xl sm:text-2xl font-bold text-gray-800 dark:text-gray-100 dark:text-gray-100">{{ $user->name }}</h3>
                            <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400 truncate">{{ $user->email }}</p>
                        </div>
                    </div>
                        
                    <!-- Action Button -->
                    @if(auth()->id() === $user->id)
                        <x-app-button variant="blue" href="{{ route('profile.edit') }}" class="w-full sm:w-auto">
                            <x-slot name="icon">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </x-slot>
                            Edit Profile
                        </x-app-button>
                    @else
                        <div class="w-full sm:w-auto">
                            @if($isFollowing)
                                <form action="{{ route('social.unfollow', $user) }}" method="POST">
                                    @csrf
                                    <x-app-button variant="secondary" type="submit" class="w-full sm:w-auto">
                                        Following
                                    </x-app-button>
                                </form>
                            @else
                                <form action="{{ route('social.follow', $user) }}" method="POST">
                                    @csrf
                                    <x-app-button variant="blue" type="submit" class="w-full sm:w-auto">
                                        Follow
                                    </x-app-button>
                                </form>
                            @endif
                        </div>
                    @endif
                </div>

                <!-- Stats -->
                <div class="grid grid-cols-3 gap-4 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <div class="text-center">
                        <div class="text-3xl font-bold text-blue-600">{{ $user->challenges_count }}</div>
                        <div class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ Str::plural('Challenge', $user->challenges_count) }}</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-purple-600">{{ $user->followers_count }}</div>
                        <div class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ Str::plural('Follower', $user->followers_count) }}</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-pink-600">{{ $user->following_count }}</div>
                        <div class="text-sm text-gray-600 dark:text-gray-400 mt-1">Following</div>
                    </div>
                </div>
            </div>

            <!-- Tabs -->
            <div x-data="{ activeTab: 'activity' }">
                <!-- Tab Navigation -->
                <div class="card card-no-padding mb-4">
                    <nav class="flex -mb-px">
                        <button @click="activeTab = 'activity'" 
                                :class="activeTab === 'activity' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:text-gray-100 hover:border-gray-300 dark:border-gray-600'"
                                class="w-1/2 py-4 px-1 text-center border-b-2 font-medium text-sm transition-colors duration-150">
                            Recent Activity
                            <span class="ml-2 px-2 py-1 text-xs rounded-full" :class="activeTab === 'activity' ? 'bg-blue-100 text-blue-600' : 'bg-gray-100 text-gray-600 dark:text-gray-400'">
                                {{ $activities->total() }}
                            </span>
                        </button>
                        <button @click="activeTab = 'challenges'" 
                                :class="activeTab === 'challenges' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:text-gray-100 hover:border-gray-300 dark:border-gray-600'"
                                class="w-1/2 py-4 px-1 text-center border-b-2 font-medium text-sm transition-colors duration-150">
                            Public Challenges
                            <span class="ml-2 px-2 py-1 text-xs rounded-full" :class="activeTab === 'challenges' ? 'bg-blue-100 text-blue-600' : 'bg-gray-100 text-gray-600 dark:text-gray-400'">
                                {{ $publicChallenges->total() }}
                            </span>
                        </button>
                    </nav>
                </div>

                <!-- Recent Activity Tab -->
                <div x-show="activeTab === 'activity'" class="space-y-4">
                    @forelse($activities as $activity)
                        <x-activity-card :activity="$activity" />
                    @empty
                        <div class="p-12 text-center">
                            <div class="mx-auto w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                <svg class="w-8 h-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-800 dark:text-gray-100 dark:text-gray-100 mb-2">No activities yet</h3>
                            <p class="text-gray-600 dark:text-gray-400">{{ $user->name }} hasn't logged any activities yet.</p>
                        </div>
                    @endforelse

                    <!-- Pagination -->
                    @if($activities->hasPages())
                        <div class="mt-6">
                            {{ $activities->links('pagination::tailwind', ['pageName' => 'activities_page']) }}
                        </div>
                    @endif
                </div>

                <!-- Public Challenges Tab -->
                <div x-show="activeTab === 'challenges'" class="space-y-4" style="display: none;">
                    @forelse($publicChallenges as $challenge)
                        <x-challenge-list-item :challenge="$challenge" />
                    @empty
                        <div class="p-12 text-center">
                            <div class="mx-auto w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                <svg class="w-8 h-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-800 dark:text-gray-100 dark:text-gray-100 mb-2">No public challenges</h3>
                            <p class="text-gray-600 dark:text-gray-400">{{ $user->name }} hasn't shared any public challenges yet.</p>
                        </div>
                    @endforelse

                    <!-- Pagination -->
                    @if($publicChallenges->hasPages())
                        <div class="mt-6">
                            {{ $publicChallenges->links('pagination::tailwind', ['pageName' => 'challenges_page']) }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
