@props(['followingUsers'])

@if($followingUsers->isNotEmpty())
    <div class="section pt-0">
        <div class="container max-w-4xl">
            <div class="animate animate-hidden-fade-up"
                 x-data="{}"
                 x-intersect="setTimeout(() => $el.classList.remove('animate-hidden-fade-up'), 100)">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                            People You Follow
                        </h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                            Stay connected with your network
                        </p>
                    </div>
                    <a href="{{ route('users.search', ['filter' => 'following']) }}" 
                       class="text-sm text-slate-700 dark:text-slate-400 hover:text-slate-600 dark:hover:text-slate-300">
                        View all →
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($followingUsers as $index => $user)
                        <div class="card card-hover animate animate-hidden-fade-up-sm"
                             x-data="{}"
                             x-intersect="setTimeout(() => $el.classList.remove('animate-hidden-fade-up-sm'), {{ ($index + 1) * 100 }})">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3 flex-1 min-w-0">
                                    <div class="flex-shrink-0">
                                        <img src="{{ $user->getAvatarUrl() ?? asset('avatars/default.png') }}" 
                                             alt="{{ $user->name }}" 
                                             class="h-12 w-12 rounded-full ring-2 ring-white dark:ring-gray-800 shadow-sm">
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <a href="{{ route('users.show', $user) }}" 
                                           class="font-semibold text-gray-900 dark:text-white hover:text-slate-700 dark:hover:text-slate-400 block truncate">
                                            {{ $user->name }}
                                        </a>
                                        <div class="flex items-center gap-3 mt-0.5 text-xs text-gray-600 dark:text-gray-400">
                                            @if($user->challenges_count > 0)
                                                <span>🏆 {{ $user->challenges_count }} {{ Str::plural('challenge', $user->challenges_count) }}</span>
                                            @endif
                                            @if($user->habits_count > 0)
                                                <span>✓ {{ $user->habits_count }} {{ Str::plural('habit', $user->habits_count) }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="ml-2 flex-shrink-0">
                                    <a href="{{ route('users.show', $user) }}" 
                                       class="text-slate-700 dark:text-slate-400 hover:text-slate-600 dark:hover:text-slate-300">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endif
