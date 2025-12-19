@props(['user', 'index' => 0])

<div class="animate animate-hidden-fade-up-sm"
     x-data="followManager(
         {{ auth()->user()->isFollowing($user) ? 'true' : 'false' }},
         {{ $user->followers_count }},
         {{ $user->id }}
     )"
     x-intersect="setTimeout(() => $el.classList.remove('animate-hidden-fade-up-sm'), {{ $index * 100 }})">
    <div class="user-list-item group" @click="window.location.href = '{{ route('users.show', $user) }}'">
        <div class="user-list-content">
            <!-- Avatar -->
            <div class="user-list-avatar">
                <img src="{{ $user->getAvatarUrl() ?? asset('avatars/default.png') }}" 
                     alt="{{ $user->name }}">
            </div>

            <!-- User Info -->
            <div class="user-list-info">
                <div class="user-list-header">
                    <div class="user-list-details">
                        <h3 class="user-list-name">
                            {{ $user->name }}
                        </h3>
                        
                        <!-- Stats Row -->
                        <div class="user-list-stats">
                            <span class="flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                <span x-text="followersCount"></span> <span x-text="followersCount === 1 ? 'follower' : 'followers'"></span>
                            </span>
                            <span>{{ $user->following_count }} following</span>
                        </div>

                        <!-- Activity Stats -->
                        @if($user->challenges_count > 0 || $user->habits_count > 0 || $user->goals_count > 0)
                            <div class="user-list-activity">
                                @if($user->challenges_count > 0)
                                    <span class="flex items-center gap-1">
                                        <span>🏆</span>
                                        <span>{{ $user->challenges_count }}</span>
                                    </span>
                                @endif
                                @if($user->habits_count > 0)
                                    <span class="flex items-center gap-1">
                                        <span>✓</span>
                                        <span>{{ $user->habits_count }}</span>
                                    </span>
                                @endif
                                @if($user->goals_count > 0)
                                    <span class="flex items-center gap-1">
                                        <span>🎯</span>
                                        <span>{{ $user->goals_count }}</span>
                                    </span>
                                @endif
                            </div>
                        @endif

                        <!-- Recent Activity Indicator -->
                        @if($user->recent_activity)
                            <div class="user-list-recent">
                                <span class="pulse-dot"></span>
                                Active recently
                            </div>
                        @endif
                    </div>

                    <!-- Follow Button -->
                    <div class="user-list-action" @click.stop>
                        <button @click="toggleFollow()"
                                :disabled="isLoading"
                                :class="isFollowing ? 'btn btn-secondary btn-sm' : 'btn btn-primary btn-sm'"
                                class="transition-all duration-200 min-w-[100px] relative"
                                :style="isLoading ? 'cursor: wait;' : ''">
                            <span class="flex items-center justify-center gap-1.5"
                                  :class="isLoading ? 'opacity-70' : ''">
                                <svg x-show="isLoading" 
                                     x-transition:enter="transition ease-out duration-150"
                                     x-transition:enter-start="opacity-0 scale-50"
                                     x-transition:enter-end="opacity-100 scale-100"
                                     class="animate-spin h-3.5 w-3.5" 
                                     xmlns="http://www.w3.org/2000/svg" 
                                     fill="none" 
                                     viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <span x-text="isFollowing ? 'Following' : 'Follow'"></span>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
