<!-- Bottom Navigation -->
<nav class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 shadow-lg z-50 sm:hidden">
    <div class="grid grid-cols-4 h-16">
        <!-- Feed -->
        <a href="{{ route('feed.index') }}" class="flex flex-col items-center justify-center space-y-1 {{ request()->routeIs('feed.*') ? 'text-blue-600' : 'text-gray-600' }} hover:text-blue-600 transition-colors duration-200">
            <svg class="w-6 h-6" fill="{{ request()->routeIs('feed.*') ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            <span class="text-xs font-medium">Feed</span>
        </a>

        <!-- Challenges -->
        <a href="{{ route('challenges.index') }}" class="flex flex-col items-center justify-center space-y-1 {{ request()->routeIs('challenges.*') && !request()->routeIs('challenges.show') ? 'text-blue-600' : 'text-gray-600' }} hover:text-blue-600 transition-colors duration-200">
            <svg class="w-6 h-6" fill="{{ request()->routeIs('challenges.*') && !request()->routeIs('challenges.show') ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
            <span class="text-xs font-medium">Challenges</span>
        </a>

        <!-- Active (Dashboard) -->
        <a href="{{ route('dashboard') }}" class="flex flex-col items-center justify-center space-y-1 {{ request()->routeIs('dashboard') ? 'text-blue-600' : 'text-gray-600' }} hover:text-blue-600 transition-colors duration-200">
            <svg class="w-6 h-6" fill="{{ request()->routeIs('dashboard') ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
            </svg>
            <span class="text-xs font-medium">Active</span>
        </a>

        <!-- Profile -->
        <a href="{{ route('profile.edit') }}" class="flex flex-col items-center justify-center space-y-1 {{ request()->routeIs('profile.*') ? 'text-blue-600' : 'text-gray-600' }} hover:text-blue-600 transition-colors duration-200">
            <svg class="w-6 h-6" fill="{{ request()->routeIs('profile.*') ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
            <span class="text-xs font-medium">Profile</span>
        </a>
    </div>
</nav>

<!-- Spacer for bottom nav on mobile -->
<div class="h-16 sm:hidden"></div>
