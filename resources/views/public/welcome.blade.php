<x-public-layout>
    <x-slot name="title">Challenge Checker - Track Your Daily Goals</x-slot>

    <!-- Hero Section - Extreme Whitespace -->
    <div class="section">
        <div class="container text-center">
            <h1>
                The calendar you need to meet
            </h1>
            
            <p class="subtitle mb-4">
                Build better habits and achieve your goals with our simple yet powerful challenge tracking system.
            </p>

            <!-- CTA Buttons - Larger Sizing -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center pt-4">
                @auth
                    <a href="{{ route('feed.index') }}" class="btn btn-primary btn-lg">
                        Go to Feed
                    </a>
                @else
                    <a href="{{ route('register') }}" class="btn btn-primary btn-lg">
                        Get Started
                    </a>
                    
                    <a href="{{ route('login') }}" class="btn btn-secondary btn-lg">
                        Sign In
                    </a>
                @endauth
            </div>

            <!-- Features Grid - Generous Spacing -->
            <div class="features">
            <!-- Feature 1 -->
            <div class="feature">
                <div class="icon flex items-center justify-center mx-auto">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                    </svg>
                </div>
                <h3 class="h3">Daily Goal Tracking</h3>
                <p class="text-body">Set specific daily goals and track your progress with our intuitive interface.</p>
            </div>

            <!-- Feature 2 -->
            <div class="feature">
                <div class="icon flex items-center justify-center mx-auto">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h3 class="h3">Challenge Management</h3>
                <p class="text-body">Create custom challenges with multiple goals and flexible duration settings.</p>
            </div>

            <!-- Feature 3 -->
            <div class="feature">
                <div class="icon flex items-center justify-center mx-auto">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z" />
                    </svg>
                </div>
                <h3 class="h3">Progress Analytics</h3>
                <p class="text-body">Visualize your achievements and stay motivated with detailed progress reports.</p>
            </div>
            </div>
        </div>
    </div>
</x-public-layout>
