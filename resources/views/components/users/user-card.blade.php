@props(['user', 'index' => 0])

<div class="animate animate-hidden-fade-up-sm"
     x-data="{}"
     x-intersect="setTimeout(() => $el.classList.remove('animate-hidden-fade-up-sm'), {{ $index * 100 }})">
    <a href="{{ route('users.show', $user) }}" class="user-list-item group">
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
                                {{ $user->followers_count }} {{ Str::plural('follower', $user->followers_count) }}
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
                    <div class="user-list-action">
                        @if(auth()->user()->isFollowing($user))
                            <form action="{{ route('social.unfollow', $user) }}" method="POST" onclick="event.stopPropagation();">
                                @csrf
                                <x-ui.app-button variant="secondary" type="submit" size="sm">
                                    Following
                                </x-ui.app-button>
                            </form>
                        @else
                            <form action="{{ route('social.follow', $user) }}" method="POST" onclick="event.stopPropagation();">
                                @csrf
                                <x-ui.app-button variant="primary" type="submit" size="sm">
                                    Follow
                                </x-ui.app-button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </a>
</div>
