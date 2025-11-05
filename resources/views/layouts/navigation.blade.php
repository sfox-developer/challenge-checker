<nav class="bg-gradient-to-r from-blue-600 to-purple-600 shadow-lg">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('feed.index') }}" class="flex items-center space-x-2">
                        <div class="w-8 h-8 bg-white rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <span class="text-white font-bold text-lg">Challenge Checker</span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('feed.index')" :active="request()->routeIs('feed.*')">
                        {{ __('Feed') }}
                    </x-nav-link>
                    <x-nav-link :href="route('challenges.index')" :active="request()->routeIs('challenges.*')">
                        {{ __('My Challenges') }}
                    </x-nav-link>
                    <x-nav-link :href="route('users.search')" :active="request()->routeIs('users.*')">
                        {{ __('Discover') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-white border-opacity-20 text-sm leading-4 font-medium rounded-md text-white bg-white bg-opacity-10 hover:bg-opacity-20 focus:outline-none transition ease-in-out duration-150">
                            <img src="{{ Auth::user()->getAvatarUrl() }}" alt="{{ Auth::user()->name }}" class="h-8 w-8 rounded-full mr-2">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('users.show', Auth::user())">
                            {{ __('My Profile') }}
                        </x-dropdown-link>
                        
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
<nav class="sm:hidden fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 z-40">
    <div class="grid grid-cols-5 h-16">
        <!-- Feed -->
        <a href="{{ route('feed.index') }}" class="flex flex-col items-center justify-center space-y-1 {{ request()->routeIs('feed.*') ? 'text-blue-600' : 'text-gray-600' }} hover:text-blue-600 transition-colors duration-150">
            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                <path d="M2 5a2 2 0 012-2h7a2 2 0 012 2v4a2 2 0 01-2 2H9l-3 3v-3H4a2 2 0 01-2-2V5z"/>
                <path d="M15 7v2a4 4 0 01-4 4H9.828l-1.766 1.767c.28.149.599.233.938.233h2l3 3v-3h2a2 2 0 002-2V9a2 2 0 00-2-2h-1z"/>
            </svg>
            <span class="text-xs font-medium">Feed</span>
        </a>

        <!-- My Challenges -->
        <a href="{{ route('challenges.index') }}" class="flex flex-col items-center justify-center space-y-1 {{ request()->routeIs('challenges.*') ? 'text-blue-600' : 'text-gray-600' }} hover:text-blue-600 transition-colors duration-150">
            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
            </svg>
            <span class="text-xs font-medium">Challenges</span>
        </a>

        <!-- Quick Goals (Center, Prominent) - Hidden on Challenge Detail Page -->
        @if(!request()->routeIs('challenges.show'))
        <button @click="$dispatch('open-goals')" class="flex flex-col items-center justify-center -mt-6">
            <div class="bg-gradient-to-r from-blue-600 to-purple-600 rounded-full p-4 shadow-lg hover:shadow-xl transition-shadow duration-150">
                <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                </svg>
            </div>
        </button>
        @else
        <div class="flex flex-col items-center justify-center -mt-6">
            <div class="bg-gradient-to-r from-gray-400 to-gray-500 rounded-full p-4 shadow-lg opacity-50 cursor-not-allowed">
                <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                </svg>
            </div>
        </div>
        @endif

        <!-- Discover -->
        <a href="{{ route('users.search') }}" class="flex flex-col items-center justify-center space-y-1 {{ request()->routeIs('users.search') ? 'text-blue-600' : 'text-gray-600' }} hover:text-blue-600 transition-colors duration-150">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <span class="text-xs font-medium">Discover</span>
        </a>

        <!-- Profile / Menu -->
        <a href="{{ route('profile.menu') }}" class="flex flex-col items-center justify-center space-y-1 {{ request()->routeIs('profile.menu') ? 'text-blue-600' : 'text-gray-600' }} hover:text-blue-600 transition-colors duration-150">
            <img src="{{ Auth::user()->getAvatarUrl() }}" alt="{{ Auth::user()->name }}" class="w-6 h-6 rounded-full ring-2 {{ request()->routeIs('profile.menu') ? 'ring-blue-600' : 'ring-gray-300' }}">
            <span class="text-xs font-medium">Menu</span>
        </a>
    </div>
</nav>
