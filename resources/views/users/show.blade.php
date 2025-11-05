<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center space-x-3">
            <div class="bg-gradient-to-r from-blue-500 to-purple-500 p-2 rounded-lg">
                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                </svg>
            </div>
            <span>{{ $user->name }}</span>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Profile Info -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Profile Header with Avatar and Name -->
                    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-6">
                        <div class="flex items-center space-x-4">
                            <img src="{{ $user->getAvatarUrl() }}" alt="{{ $user->name }}" class="h-20 w-20 sm:h-24 sm:w-24 rounded-full ring-4 ring-white shadow-lg flex-shrink-0">
                            <div class="min-w-0">
                                <h3 class="text-xl sm:text-2xl font-bold text-gray-900">{{ $user->name }}</h3>
                                <p class="text-sm sm:text-base text-gray-600 truncate">{{ $user->email }}</p>
                            </div>
                        </div>
                        
                        <!-- Action Button -->
                        @if(auth()->id() === $user->id)
                            <a href="{{ route('profile.edit') }}" class="w-full sm:w-auto px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition-colors duration-200 flex items-center justify-center space-x-2">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                <span>Edit Profile</span>
                            </a>
                        @else
                            <div class="w-full sm:w-auto">
                                @if($isFollowing)
                                    <form action="{{ route('social.unfollow', $user) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="w-full sm:w-auto px-6 py-2 border border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition-colors duration-200">
                                            Following
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('social.follow', $user) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="w-full sm:w-auto px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition-colors duration-200">
                                            Follow
                                        </button>
                                    </form>
                                @endif
                            </div>
                        @endif
                    </div>

                    <!-- Stats -->
                    <div class="grid grid-cols-3 gap-4 pt-6 border-t border-gray-200">
                        <div class="text-center">
                            <div class="text-3xl font-bold text-blue-600">{{ $user->challenges_count }}</div>
                            <div class="text-sm text-gray-600 mt-1">{{ Str::plural('Challenge', $user->challenges_count) }}</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-purple-600">{{ $user->followers_count }}</div>
                            <div class="text-sm text-gray-600 mt-1">{{ Str::plural('Follower', $user->followers_count) }}</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-pink-600">{{ $user->following_count }}</div>
                            <div class="text-sm text-gray-600 mt-1">Following</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabs -->
            <div x-data="{ activeTab: 'activity' }">
                <!-- Tab Navigation -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-4">
                    <nav class="flex -mb-px">
                        <button @click="activeTab = 'activity'" 
                                :class="activeTab === 'activity' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                class="w-1/2 py-4 px-1 text-center border-b-2 font-medium text-sm transition-colors duration-150">
                            Recent Activity
                            <span class="ml-2 px-2 py-1 text-xs rounded-full" :class="activeTab === 'activity' ? 'bg-blue-100 text-blue-600' : 'bg-gray-100 text-gray-600'">
                                {{ $activities->total() }}
                            </span>
                        </button>
                        <button @click="activeTab = 'challenges'" 
                                :class="activeTab === 'challenges' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                class="w-1/2 py-4 px-1 text-center border-b-2 font-medium text-sm transition-colors duration-150">
                            Public Challenges
                            <span class="ml-2 px-2 py-1 text-xs rounded-full" :class="activeTab === 'challenges' ? 'bg-blue-100 text-blue-600' : 'bg-gray-100 text-gray-600'">
                                {{ $publicChallenges->total() }}
                            </span>
                        </button>
                    </nav>
                </div>

                <!-- Tab Content -->
                <div>
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
                                <h3 class="text-lg font-medium text-gray-900 mb-2">No activities yet</h3>
                                <p class="text-gray-600">{{ $user->name }} hasn't logged any activities yet.</p>
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
                            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition-shadow duration-200">
                                <div class="p-6">
                                    <!-- Challenge Header -->
                                    <div class="flex items-start justify-between mb-4">
                                        <div class="flex-1">
                                            <h4 class="text-lg font-semibold text-gray-900 mb-2">{{ $challenge->name }}</h4>
                                            @if($challenge->description)
                                                <p class="text-gray-700 mb-3">{{ Str::limit($challenge->description, 150) }}</p>
                                            @endif
                                        </div>
                                        <a href="{{ route('challenges.show', $challenge) }}" class="ml-4 text-blue-600 hover:text-blue-500 font-medium whitespace-nowrap">
                                            View →
                                        </a>
                                    </div>

                                    <!-- Challenge Stats -->
                                    <div class="flex flex-wrap items-center gap-3 pt-4 border-t border-gray-100">
                                        <div class="flex items-center space-x-1 text-sm text-gray-600">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                            <span>{{ $challenge->days_duration }} {{ Str::plural('day', $challenge->days_duration) }}</span>
                                        </div>
                                        @if($challenge->started_at)
                                            <div class="flex items-center space-x-1 text-sm text-gray-600">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                                <span>{{ $challenge->getCompletedDaysCount() }} / {{ $challenge->days_duration }} completed</span>
                                            </div>
                                        @endif
                                        @if($challenge->completed_at)
                                            <span class="px-2 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded-full">✓ Completed</span>
                                        @elseif($challenge->is_active)
                                            <span class="px-2 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded-full">Active</span>
                                        @elseif($challenge->started_at)
                                            <span class="px-2 py-1 bg-yellow-100 text-yellow-800 text-xs font-semibold rounded-full">Paused</span>
                                        @else
                                            <span class="px-2 py-1 bg-gray-100 text-gray-800 text-xs font-semibold rounded-full">Not Started</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="p-12 text-center">
                                <div class="mx-auto w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">No public challenges</h3>
                                <p class="text-gray-600">{{ $user->name }} hasn't shared any public challenges yet.</p>
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
    </div>
</x-app-layout>
