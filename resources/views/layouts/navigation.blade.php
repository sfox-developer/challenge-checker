<nav class="nav-main">
    <!-- Primary Navigation Menu -->
    <div class="nav-container">
        <div class="nav-wrapper">
            <div class="nav-left">
                <!-- Logo -->
                <div class="nav-logo">
                    <a href="{{ route('feed.index') }}" class="flex items-center space-x-2">
                        <span class="nav-logo-text">Challenge Checker</span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="nav-links-desktop">
                    <x-nav-link :href="route('feed.index')" :active="request()->routeIs('feed.*')">
                        {{ __('Feed') }}
                    </x-nav-link>
                    <x-nav-link :href="route('challenges.index')" :active="request()->routeIs('challenges.*')">
                        {{ __('Challenges') }}
                    </x-nav-link>
                    <x-nav-link :href="route('habits.index')" :active="request()->routeIs('habits.*')">
                        {{ __('Habits') }}
                    </x-nav-link>
                    <x-nav-link :href="route('goals.index')" :active="request()->routeIs('goals.*')">
                        {{ __('Goals') }}
                    </x-nav-link>
                    <x-nav-link :href="route('users.search')" :active="request()->routeIs('users.*')">
                        {{ __('Discover') }}
                    </x-nav-link>
                    @if(Auth::check() && Auth::user()->is_admin)
                        <div class="nav-admin-wrapper" x-data="{ open: false }">
                            <button @click="open = !open" 
                                    class="nav-admin-button {{ request()->routeIs('admin.*') ? 'active' : '' }}">
                                <span>{{ __('Admin') }}</span>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
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
                                 class="nav-dropdown"
                                 style="display: none;">
                                <a href="{{ route('admin.dashboard') }}" class="nav-dropdown-item">
                                    <svg fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11.707 4.707a1 1 0 00-1.414-1.414L10 9.586 8.707 8.293a1 1 0 00-1.414 0l-2 2a1 1 0 101.414 1.414L8 10.414l1.293 1.293a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    <span>Dashboard</span>
                                </a>
                                <a href="{{ route('admin.categories.index') }}" class="nav-dropdown-item">
                                    <svg fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"/>
                                    </svg>
                                    <span>Categories</span>
                                </a>
                                <a href="{{ route('admin.changelogs.index') }}" class="nav-dropdown-item">
                                    <svg fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                                    </svg>
                                    <span>Changelogs</span>
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Mobile Theme Toggle -->
            <div class="flex items-center sm:hidden">
                <x-theme-toggle size="w-6 h-6" />
            </div>

            <!-- Settings Dropdown -->
            <div class="nav-settings">
                <!-- Theme Toggle -->
                <x-theme-toggle />

                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="nav-user-trigger">
                            <img src="{{ Auth::check() ? Auth::user()->getAvatarUrl() : '' }}" alt="{{ Auth::check() ? Auth::user()->name : '' }}">
                            <div>{{ Auth::check() ? Auth::user()->name : '' }}</div>

                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        @if(Auth::check())
                            <x-dropdown-link :href="route('users.show', Auth::user())">
                                {{ __('My Profile') }}
                            </x-dropdown-link>
                        @endif
                        
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Settings') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
        </div>
    </div>
</nav>

<!-- Mobile Bottom Navigation -->
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
