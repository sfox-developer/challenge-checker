<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>403 - Access Forbidden | {{ config('app.name', 'Challenge Checker') }}</title>

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
                    <div class="error-page-icon error-icon-403">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                </div>

                <!-- Message -->
                <h1 class="error-page-title">
                    Access Forbidden
                </h1>
                <p class="error-page-message">
                    Sorry, you don't have permission to access this resource. If you believe this is an error, please contact support.
                </p>

            <!-- Actions -->
            <div class="error-page-actions">
                <x-ui.app-button variant="blue" href="{{ url()->previous() }}">
                    <x-slot name="icon">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                    </x-slot>
                    Go Back
                </x-ui.app-button>
                
                <x-ui.app-button variant="secondary" href="{{ route('feed.index') }}">
                    <x-slot name="icon">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                    </x-slot>
                    Home
                </x-ui.app-button>
            </div>

                <!-- Additional Info -->
                @if(config('app.debug'))
                    <div class="mt-8 p-4 bg-white/50 dark:bg-gray-800/50 backdrop-blur-sm rounded-lg text-left">
                        <p class="text-xs text-gray-500 dark:text-gray-400 font-mono">
                            {{ $exception->getMessage() ?: 'This action is unauthorized.' }}
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </body>
</html>
