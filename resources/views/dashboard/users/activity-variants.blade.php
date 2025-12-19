<x-dashboard-layout>
    <x-slot name="title">User Activity Variants</x-slot>

    <x-dashboard.page-header 
        eyebrow="Design System"
        title="User Card Activity Variants"
        description="Static mockups showing different approaches to displaying user activity stats in user cards. Choose one to implement dynamically." />

    <div class="section">
        <div class="container max-w-6xl">
            
            {{-- Variant 1: Compact Icon Row (Current Enhanced) --}}
            <div class="mb-12">
                <h2 class="text-xl font-bold mb-2 text-gray-900 dark:text-white">Variant 1: Compact Icon Row</h2>
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-6">Single horizontal row with emoji icons and counts. Minimal space usage.</p>
                
                <div class="user-list-item">
                    <div class="user-list-content">
                        <!-- Avatar -->
                        <div class="user-list-avatar">
                            <img src="{{ asset('avatars/user-11.svg') }}" alt="John Doe">
                        </div>

                        <!-- User Info -->
                        <div class="user-list-info">
                            <div class="user-list-header">
                                <div class="user-list-details">
                                    <h3 class="user-list-name">John Doe</h3>
                                    
                                    <!-- Stats Row -->
                                    <div class="user-list-stats">
                                        <span class="flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                            </svg>
                                            <span>42 followers</span>
                                        </span>
                                        <span>28 following</span>
                                    </div>

                                    <!-- Activity Stats - Compact Row -->
                                    <div class="user-list-activity">
                                        <span class="flex items-center gap-1">
                                            <span>🏆</span>
                                            <span>5</span>
                                        </span>
                                        <span class="flex items-center gap-1">
                                            <span>✓</span>
                                            <span>12</span>
                                        </span>
                                        <span class="flex items-center gap-1">
                                            <span>🎯</span>
                                            <span>8</span>
                                        </span>
                                    </div>

                                    <!-- Recent Activity Indicator -->
                                    <div class="user-list-recent">
                                        <span class="pulse-dot"></span>
                                        Active recently
                                    </div>
                                </div>

                                <!-- Follow Button -->
                                <div class="user-list-action">
                                    <button class="btn btn-primary btn-sm min-w-[100px]">Follow</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Variant 2: Labeled Stats Grid --}}
            <div class="mb-12">
                <h2 class="text-xl font-bold mb-2 text-gray-900 dark:text-white">Variant 2: Labeled Stats Grid</h2>
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-6">Explicitly labeled metrics in a clean grid. More readable but takes more space.</p>
                
                <div class="user-list-item">
                    <div class="user-list-content">
                        <!-- Avatar -->
                        <div class="user-list-avatar">
                            <img src="{{ asset('avatars/pet-7.svg') }}" alt="Jane Smith">
                        </div>

                        <!-- User Info -->
                        <div class="user-list-info">
                            <div class="user-list-header">
                                <div class="user-list-details">
                                    <h3 class="user-list-name">Jane Smith</h3>
                                    
                                    <!-- Stats Row -->
                                    <div class="user-list-stats">
                                        <span class="flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                            </svg>
                                            <span>156 followers</span>
                                        </span>
                                        <span>93 following</span>
                                    </div>

                                    <!-- Activity Stats - Labeled Grid -->
                                    <div class="grid grid-cols-3 gap-3 mt-3">
                                        <div class="text-center">
                                            <div class="text-lg font-semibold text-gray-900 dark:text-white">8</div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">Challenges</div>
                                        </div>
                                        <div class="text-center">
                                            <div class="text-lg font-semibold text-gray-900 dark:text-white">23</div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">Habits</div>
                                        </div>
                                        <div class="text-center">
                                            <div class="text-lg font-semibold text-gray-900 dark:text-white">15</div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">Goals</div>
                                        </div>
                                    </div>

                                    <!-- Recent Activity Indicator -->
                                    <div class="mt-2 text-xs text-green-600 dark:text-green-400 flex items-center gap-1">
                                        <span class="pulse-dot inline-block w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                                        Active recently
                                    </div>
                                </div>

                                <!-- Follow Button -->
                                <div class="user-list-action">
                                    <button class="btn btn-secondary btn-sm min-w-[100px]">Following</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Variant 3: Progress Dots --}}
            <div class="mb-12">
                <h2 class="text-xl font-bold mb-2 text-gray-900 dark:text-white">Variant 3: Progress Dots</h2>
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-6">Visual dot indicators showing activity level. Minimal text, more visual.</p>
                
                <div class="user-list-item">
                    <div class="user-list-content">
                        <!-- Avatar -->
                        <div class="user-list-avatar">
                            <img src="{{ asset('avatars/user-13.svg') }}" alt="Mike Johnson">
                        </div>

                        <!-- User Info -->
                        <div class="user-list-info">
                            <div class="user-list-header">
                                <div class="user-list-details">
                                    <h3 class="user-list-name">Mike Johnson</h3>
                                    
                                    <!-- Stats Row -->
                                    <div class="user-list-stats">
                                        <span class="flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                            </svg>
                                            <span>87 followers</span>
                                        </span>
                                        <span>64 following</span>
                                    </div>

                                    <!-- Activity Stats - Progress Dots -->
                                    <div class="flex items-center gap-4 mt-3">
                                        <div class="flex items-center gap-1.5">
                                            <span class="text-xs text-gray-600 dark:text-gray-400">🏆</span>
                                            <div class="flex gap-0.5">
                                                <div class="w-1.5 h-1.5 rounded-full bg-slate-700 dark:bg-slate-400"></div>
                                                <div class="w-1.5 h-1.5 rounded-full bg-slate-700 dark:bg-slate-400"></div>
                                                <div class="w-1.5 h-1.5 rounded-full bg-slate-700 dark:bg-slate-400"></div>
                                                <div class="w-1.5 h-1.5 rounded-full bg-gray-300 dark:bg-gray-600"></div>
                                                <div class="w-1.5 h-1.5 rounded-full bg-gray-300 dark:bg-gray-600"></div>
                                            </div>
                                            <span class="text-xs font-medium text-gray-900 dark:text-white">3</span>
                                        </div>
                                        <div class="flex items-center gap-1.5">
                                            <span class="text-xs text-gray-600 dark:text-gray-400">✓</span>
                                            <div class="flex gap-0.5">
                                                <div class="w-1.5 h-1.5 rounded-full bg-slate-700 dark:bg-slate-400"></div>
                                                <div class="w-1.5 h-1.5 rounded-full bg-slate-700 dark:bg-slate-400"></div>
                                                <div class="w-1.5 h-1.5 rounded-full bg-slate-700 dark:bg-slate-400"></div>
                                                <div class="w-1.5 h-1.5 rounded-full bg-slate-700 dark:bg-slate-400"></div>
                                                <div class="w-1.5 h-1.5 rounded-full bg-slate-700 dark:bg-slate-400"></div>
                                            </div>
                                            <span class="text-xs font-medium text-gray-900 dark:text-white">7</span>
                                        </div>
                                        <div class="flex items-center gap-1.5">
                                            <span class="text-xs text-gray-600 dark:text-gray-400">🎯</span>
                                            <div class="flex gap-0.5">
                                                <div class="w-1.5 h-1.5 rounded-full bg-slate-700 dark:bg-slate-400"></div>
                                                <div class="w-1.5 h-1.5 rounded-full bg-slate-700 dark:bg-slate-400"></div>
                                                <div class="w-1.5 h-1.5 rounded-full bg-gray-300 dark:bg-gray-600"></div>
                                                <div class="w-1.5 h-1.5 rounded-full bg-gray-300 dark:bg-gray-600"></div>
                                                <div class="w-1.5 h-1.5 rounded-full bg-gray-300 dark:bg-gray-600"></div>
                                            </div>
                                            <span class="text-xs font-medium text-gray-900 dark:text-white">2</span>
                                        </div>
                                    </div>

                                    <!-- Recent Activity Indicator -->
                                    <div class="mt-2 text-xs text-green-600 dark:text-green-400 flex items-center gap-1">
                                        <span class="pulse-dot inline-block w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                                        Active recently
                                    </div>
                                </div>

                                <!-- Follow Button -->
                                <div class="user-list-action">
                                    <button class="btn btn-primary btn-sm min-w-[100px]">Follow</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Variant 4: Badge Style --}}
            <div class="mb-12">
                <h2 class="text-xl font-bold mb-2 text-gray-900 dark:text-white">Variant 4: Badge Style</h2>
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-6">Achievement-style badges with subtle backgrounds. More visual weight.</p>
                
                <div class="user-list-item">
                    <div class="user-list-content">
                        <!-- Avatar -->
                        <div class="user-list-avatar">
                            <img src="{{ asset('avatars/pet-9.svg') }}" alt="Sarah Williams">
                        </div>

                        <!-- User Info -->
                        <div class="user-list-info">
                            <div class="user-list-header">
                                <div class="user-list-details">
                                    <h3 class="user-list-name">Sarah Williams</h3>
                                    
                                    <!-- Stats Row -->
                                    <div class="user-list-stats">
                                        <span class="flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                            </svg>
                                            <span>203 followers</span>
                                        </span>
                                        <span>112 following</span>
                                    </div>

                                    <!-- Activity Stats - Badge Style -->
                                    <div class="flex flex-wrap gap-2 mt-3">
                                        <div class="flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800">
                                            <span class="text-sm">🏆</span>
                                            <span class="text-xs font-semibold text-amber-800 dark:text-amber-300">12</span>
                                        </div>
                                        <div class="flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800">
                                            <span class="text-sm">✓</span>
                                            <span class="text-xs font-semibold text-emerald-800 dark:text-emerald-300">28</span>
                                        </div>
                                        <div class="flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800">
                                            <span class="text-sm">🎯</span>
                                            <span class="text-xs font-semibold text-blue-800 dark:text-blue-300">19</span>
                                        </div>
                                    </div>

                                    <!-- Recent Activity Indicator -->
                                    <div class="mt-2 text-xs text-green-600 dark:text-green-400 flex items-center gap-1">
                                        <span class="pulse-dot inline-block w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                                        Active recently
                                    </div>
                                </div>

                                <!-- Follow Button -->
                                <div class="user-list-action">
                                    <button class="btn btn-primary btn-sm min-w-[100px]">Follow</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Variant 5: Inline Progress Bars --}}
            <div class="mb-12">
                <h2 class="text-xl font-bold mb-2 text-gray-900 dark:text-white">Variant 5: Mini Progress Bars</h2>
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-6">Tiny progress bars showing activity intensity. Compact and data-rich.</p>
                
                <div class="user-list-item">
                    <div class="user-list-content">
                        <!-- Avatar -->
                        <div class="user-list-avatar">
                            <img src="{{ asset('avatars/user-14.svg') }}" alt="Chris Brown">
                        </div>

                        <!-- User Info -->
                        <div class="user-list-info">
                            <div class="user-list-header">
                                <div class="user-list-details">
                                    <h3 class="user-list-name">Chris Brown</h3>
                                    
                                    <!-- Stats Row -->
                                    <div class="user-list-stats">
                                        <span class="flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                            </svg>
                                            <span>135 followers</span>
                                        </span>
                                        <span>78 following</span>
                                    </div>

                                    <!-- Activity Stats - Mini Progress Bars -->
                                    <div class="space-y-1.5 mt-3">
                                        <div class="flex items-center gap-2">
                                            <span class="text-xs text-gray-600 dark:text-gray-400 w-4">🏆</span>
                                            <div class="flex-1 h-1.5 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                                                <div class="h-full bg-gradient-to-r from-slate-600 to-slate-700 dark:from-slate-400 dark:to-slate-500" style="width: 60%"></div>
                                            </div>
                                            <span class="text-xs font-medium text-gray-900 dark:text-white w-6 text-right">6</span>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <span class="text-xs text-gray-600 dark:text-gray-400 w-4">✓</span>
                                            <div class="flex-1 h-1.5 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                                                <div class="h-full bg-gradient-to-r from-slate-600 to-slate-700 dark:from-slate-400 dark:to-slate-500" style="width: 90%"></div>
                                            </div>
                                            <span class="text-xs font-medium text-gray-900 dark:text-white w-6 text-right">18</span>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <span class="text-xs text-gray-600 dark:text-gray-400 w-4">🎯</span>
                                            <div class="flex-1 h-1.5 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                                                <div class="h-full bg-gradient-to-r from-slate-600 to-slate-700 dark:from-slate-400 dark:to-slate-500" style="width: 40%"></div>
                                            </div>
                                            <span class="text-xs font-medium text-gray-900 dark:text-white w-6 text-right">8</span>
                                        </div>
                                    </div>

                                    <!-- Recent Activity Indicator -->
                                    <div class="mt-2 text-xs text-green-600 dark:text-green-400 flex items-center gap-1">
                                        <span class="pulse-dot inline-block w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                                        Active recently
                                    </div>
                                </div>

                                <!-- Follow Button -->
                                <div class="user-list-action">
                                    <button class="btn btn-primary btn-sm min-w-[100px]">Follow</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Decision Guide --}}
            <div class="mt-16 p-6 rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700">
                <h3 class="text-lg font-bold mb-4 text-gray-900 dark:text-white">Decision Guide</h3>
                <div class="space-y-3 text-sm text-gray-600 dark:text-gray-300">
                    <p><strong>Variant 1 (Compact Icon Row):</strong> Best for minimal, scannable lists. Lowest visual weight.</p>
                    <p><strong>Variant 2 (Labeled Grid):</strong> Best for clarity and readability. Good when space isn't constrained.</p>
                    <p><strong>Variant 3 (Progress Dots):</strong> Best for visual engagement. Shows activity level at a glance.</p>
                    <p><strong>Variant 4 (Badge Style):</strong> Best for gamification feel. Highest visual weight, most colorful.</p>
                    <p><strong>Variant 5 (Mini Progress Bars):</strong> Best for data visualization. Shows relative activity intensity.</p>
                </div>
            </div>

        </div>
    </div>
</x-dashboard-layout>
