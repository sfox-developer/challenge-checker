<!-- Desktop Navigation Links -->
<div class="hidden md:flex items-center gap-1">
    <x-shared.nav-link :href="route('feed.index')" :active="request()->routeIs('feed.*')">
        Feed
    </x-shared.nav-link>
    <x-shared.nav-link :href="route('challenges.index')" :active="request()->routeIs('challenges.*')">
        Challenges
    </x-shared.nav-link>
    <x-shared.nav-link :href="route('habits.index')" :active="request()->routeIs('habits.*')">
        Habits
    </x-shared.nav-link>
    <x-shared.nav-link :href="route('goals.index')" :active="request()->routeIs('goals.*')">
        Goals
    </x-shared.nav-link>
    <x-shared.nav-link :href="route('users.search')" :active="request()->routeIs('users.*')">
        Discover
    </x-shared.nav-link>
    @if(Auth::check() && Auth::user()->is_admin)
        <div class="relative" x-data="{ open: false }">
            <button @click="open = !open" 
                    class="nav-link {{ request()->routeIs('admin.*') ? 'nav-link-active' : '' }} flex items-center gap-1">
                <span>Admin</span>
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
                My profile
            </x-ui.dropdown-link>
        @endif
        
        <x-ui.dropdown-link :href="route('profile.edit')">
            Settings
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
