<x-dashboard-layout>
    <div class="py-12">
        <div class="max-w-md mx-auto px-4">
            <!-- Profile Header -->
            <div class="card p-8 rounded-2xl mb-6">
                <div class="text-center">
                    <img src="{{ Auth::user()->getAvatarUrl() }}" alt="{{ Auth::user()->name }}" class="h-24 w-24 rounded-full mx-auto mb-4 ring-4 ring-white dark:ring-gray-700 shadow-lg">
                    <h2 class="h1">{{ Auth::user()->name }}</h2>
                    <p class="text-gray-600 dark:text-gray-400 mt-1">{{ Auth::user()->email }}</p>
                </div>
            </div>

            <!-- Menu Options -->
            <div class="space-y-3">
                <!-- My Profile -->
                <a href="{{ route('users.show', Auth::user()) }}" class="block card card-interactive">
                    <div class="p-5 flex items-center space-x-4">
                        <div class="bg-slate-100 dark:bg-slate-900 p-3 rounded-lg">
                            <svg class="w-6 h-6 text-slate-700 dark:text-slate-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="h3">My Profile</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">View your public profile</p>
                        </div>
                        <svg class="w-5 h-5 text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </div>
                </a>

                <!-- Goals Library -->
                <a href="{{ route('goals.index') }}" class="block card card-interactive">
                    <div class="p-5 flex items-center space-x-4">
                        <div class="bg-slate-100 dark:bg-slate-900 p-3 rounded-lg">
                            <svg class="w-6 h-6 text-slate-700 dark:text-slate-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                                <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="h3">Goals</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Manage your goals library</p>
                        </div>
                        <svg class="w-5 h-5 text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </div>
                </a>

                <!-- Discover -->
                <a href="{{ route('users.search') }}" class="block card card-interactive">
                    <div class="p-5 flex items-center space-x-4">
                        <div class="bg-slate-100 dark:bg-slate-900 p-3 rounded-lg">
                            <svg class="w-6 h-6 text-slate-700 dark:text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="h3">Discover</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Find and follow other users</p>
                        </div>
                        <svg class="w-5 h-5 text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </div>
                </a>

                <!-- Settings -->
                <a href="{{ route('profile.edit') }}" class="block card card-interactive">
                    <div class="p-5 flex items-center space-x-4">
                        <div class="bg-green-600 dark:bg-green-500 p-3 rounded-lg">
                            <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="h3">Settings</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Edit your profile & preferences</p>
                        </div>
                        <svg class="w-5 h-5 text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </div>
                </a>

                <!-- Theme Toggle -->
                <button @click="toggleTheme()" class="w-full block card card-interactive">
                    <div class="p-5 flex items-center space-x-4">
                        <div class="bg-yellow-600 dark:bg-yellow-500 p-3 rounded-lg">
                            <!-- Sun Icon (Light Mode) -->
                            <svg x-show="getThemeIcon() === 'sun'" class="w-6 h-6 text-white dark:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                            <!-- Moon Icon (Dark Mode) -->
                            <svg x-show="getThemeIcon() === 'moon'" class="w-6 h-6 text-white dark:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                            </svg>
                        </div>
                        <div class="flex-1 text-left">
                            <h3 class="h3">Theme</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400" x-text="theme === 'dark' ? 'Dark Mode' : 'Light Mode'"></p>
                        </div>
                        <svg class="w-5 h-5 text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </div>
                </button>

                <!-- Log Out -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full block card card-interactive">
                        <div class="p-5 flex items-center space-x-4">
                            <div class="bg-red-600 dark:bg-red-500 p-3 rounded-lg">
                                <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                            </div>
                            <div class="flex-1 text-left">
                                <h3 class="h3">Log out</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Sign out of your account</p>
                            </div>
                            <svg class="w-5 h-5 text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </div>
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-dashboard-layout>
