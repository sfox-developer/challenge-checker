<nav class="nav">
    <div class="nav-container">
        <a href="{{ route('feed.index') }}" class="nav-brand">
            <span>Challenge Checker</span>
        </a>
        
        <div class="flex items-center gap-3">
            <x-shared.authenticated-nav />
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
