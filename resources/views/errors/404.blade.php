<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>404 - Page Not Found | {{ config('app.name', 'Challenge Checker') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/scss/app.scss', 'resources/js/app.js'])
        
        <!-- Dark Mode Script -->
        <script>
            (function() {
                const savedTheme = localStorage.getItem('theme');
                if (savedTheme === 'dark' || (!savedTheme && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                    document.documentElement.classList.add('dark');
                }
            })();
        </script>
    </head>
    <body class="font-sans antialiased">
        <div class="error-page-container">
            <div class="error-page-content">

                <!-- Icon -->
                <div class="error-page-icon-wrapper">
                    <div class="error-page-icon error-icon-404">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>

                <!-- Message -->
                <h1 class="error-page-title">
                    Page Not Found
                </h1>
                <p class="error-page-message">
                    Oops! The page you're looking for doesn't exist. It might have been moved or deleted.
                </p>

            <!-- Actions -->
            <div class="error-page-actions">
                <x-app-button variant="blue" href="{{ url()->previous() }}">
                    <x-slot name="icon">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                    </x-slot>
                    Go Back
                </x-app-button>
                
                <x-app-button variant="secondary" href="{{ route('feed.index') }}">
                    <x-slot name="icon">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                    </x-slot>
                    Home
                </x-app-button>
            </div>

                <!-- Helpful Links -->
                @auth
                    <div class="mt-12 pt-8  dark:border-gray-700">
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Looking for something? Try these:</p>
                        <div class="flex flex-wrap justify-center gap-4 text-sm">
                            <a href="{{ route('challenges.index') }}" class="text-slate-700 dark:text-slate-400 hover:underline transition-colors">Your Challenges</a>
                            <a href="{{ route('feed.index') }}" class="text-slate-700 dark:text-slate-400 hover:underline transition-colors">Activity Feed</a>
                            <a href="{{ route('profile.edit') }}" class="text-slate-700 dark:text-slate-400 hover:underline transition-colors">Profile Settings</a>
                        </div>
                    </div>
                @endauth
            </div>
        </div>
    </body>
</html>
