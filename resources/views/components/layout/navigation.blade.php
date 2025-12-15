<nav class="nav">
    <div class="nav-container">
        <a href="{{ route('feed.index') }}" class="nav-brand">
            <span>Challenge Checker</span>
        </a>
        
        <div class="flex items-center gap-3">
            <!-- Desktop Navigation Links -->
            <div class="hidden md:flex items-center gap-1">
                <x-shared.nav-link :href="route('feed.index')" :active="request()->routeIs('feed.*')">
                    {{ __('Feed') }}
                </x-shared.nav-link>
                <x-shared.nav-link :href="route('challenges.index')" :active="request()->routeIs('challenges.*')">
                    {{ __('Challenges') }}
                </x-shared.nav-link>
                <x-shared.nav-link :href="route('habits.index')" :active="request()->routeIs('habits.*')">
                    {{ __('Habits') }}
                </x-shared.nav-link>
                <x-shared.nav-link :href="route('goals.index')" :active="request()->routeIs('goals.*')">
                    {{ __('Goals') }}
                </x-shared.nav-link>
                <x-shared.nav-link :href="route('users.search')" :active="request()->routeIs('users.*')">
                    {{ __('Discover') }}
                </x-shared.nav-link>
                @if(Auth::check() && Auth::user()->is_admin)
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" 
                                class="nav-link {{ request()->routeIs('admin.*') ? 'nav-link-active' : '' }} flex items-center gap-1">
                            <span>{{ __('Admin') }}</span>
                            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>

                        <!-- Admin Dropdown Menu -->
                        <div x-show="open" 
                             @click.away="open = false"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             class="absolute right-0 mt-2 w-48 rounded-lg bg-white dark:bg-gray-800 shadow-lg border border-gray-200 dark:border-gray-700 py-1 z-50"
                             style="display: none;">
                                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md transition-colors">
                                    <span>Dashboard</span>
                                </a>
                                <a href="{{ route('admin.categories.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md transition-colors">
                                    <span>Categories</span>
                                </a>
                                <a href="{{ route('admin.changelogs.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md transition-colors">
                                    <span>Changelogs</span>
                                </a>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Theme Toggle -->
            <button @click="toggleTheme()" 
                    class="theme-toggle"
                    title="Toggle theme"
                    x-data="themeManager()">
                <svg x-show="getThemeIcon() === 'sun'" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                <svg x-show="getThemeIcon() === 'moon'" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                </svg>
            </button>

            <!-- User Dropdown -->
            <x-ui.dropdown align="right" width="48">
                <x-slot name="trigger">
                    <button class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                        <img src="{{ Auth::check() ? Auth::user()->getAvatarUrl() : '' }}" alt="{{ Auth::check() ? Auth::user()->name : '' }}" class="w-8 h-8 rounded-full">
                        <span class="hidden md:block">{{ Auth::check() ? Auth::user()->name : '' }}</span>
                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </x-slot>

                <x-slot name="content">
                    @if(Auth::check())
                        <x-ui.dropdown-link :href="route('users.show', Auth::user())">
                            {{ __('My Profile') }}
                        </x-ui.dropdown-link>
                    @endif
                    
                    <x-ui.dropdown-link :href="route('profile.edit')">
                        {{ __('Settings') }}
                    </x-ui.dropdown-link>

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-ui.dropdown-link :href="route('logout')"
                                onclick="event.preventDefault();
                                            this.closest('form').submit();">
                            Log out
                        </x-ui.dropdown-link>
                    </form>
                </x-slot>
            </x-ui.dropdown>
        </div>
    </div>
</nav>

<!-- Mobile Bottom Navigation - TEMPORARILY HIDDEN -->
{{-- 
<nav class="bottom-nav">
    <div class="bottom-nav-grid">
        <!-- Feed -->
        <a href="{{ route('feed.index') }}" class="bottom-nav-item {{ request()->routeIs('feed.*') ? 'active' : '' }}">
            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                <path d="M2 5a2 2 0 012-2h7a2 2 0 012 2v4a2 2 0 01-2 2H9l-3 3v-3H4a2 2 0 01-2-2V5z"/>
                <path d="M15 7v2a4 4 0 01-4 4H9.828l-1.766 1.767c.28.149.599.233.938.233h2l3 3v-3h2a2 2 0 002-2V9a2 2 0 00-2-2h-1z"/>
            </svg>
            <span>Feed</span>
        </a>

        <!-- My Challenges -->
        <a href="{{ route('challenges.index') }}" class="bottom-nav-item {{ request()->routeIs('challenges.*') ? 'active' : '' }}">
            <svg fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
            </svg>
            <span>Challenges</span>
        </a>

        <!-- Quick Goals (Center, Prominent) - Hidden on Challenge Detail Page -->
        @if(!request()->routeIs('challenges.show'))
        <div class="bottom-nav-center">
            <button @click="$dispatch('open-goals')">
                <svg fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                </svg>
            </button>
        </div>
        @else
        <div class="bottom-nav-center disabled">
            <div class="button-wrapper">
                <svg fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                </svg>
            </div>
        </div>
        @endif

        <!-- My Habits -->
        <a href="{{ route('habits.index') }}" class="bottom-nav-item {{ request()->routeIs('habits.*') ? 'active' : '' }}">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
            </svg>
            <span>Habits</span>
        </a>

        <!-- Profile / Menu -->
        <a href="{{ route('profile.menu') }}" class="bottom-nav-item {{ request()->routeIs('profile.menu') ? 'active' : '' }}">
            <img src="{{ Auth::check() ? Auth::user()->getAvatarUrl() : '' }}" alt="{{ Auth::check() ? Auth::user()->name : '' }}">
            <span>Menu</span>
        </a>
    </div>
</nav>
--}}
