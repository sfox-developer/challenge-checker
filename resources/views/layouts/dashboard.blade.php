<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="{{ auth()->check() && auth()->user()->getThemePreference() === 'dark' ? 'dark' : 'light' }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/scss/app.scss', 'resources/js/app.js'])
        
        <!-- Dark Mode Script - Must run before page renders -->
        <script>
            // Initialize theme immediately to prevent flash
            (function() {
                const theme = document.documentElement.dataset.theme || 'light';
                if (theme === 'dark') {
                    document.documentElement.classList.add('dark');
                } else {
                    document.documentElement.classList.remove('dark');
                }
            })();
        </script>
    </head>
    <body class="page" x-data="{ ...themeManager() }">
        @include('components.layout.navigation')

        <!-- Page Heading -->
        @isset($header)
            <header class="header">
                <div class="container py-6">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <!-- Page Content -->
        <main class="flex-1 flex flex-col">
            {{ $slot }}
        </main>

        <!-- Footer -->
        <x-layout.footer />

        <!-- Desktop FAB for Quick Goal Completion (Hidden on Mobile and Challenge Detail Page) -->
        @if(!request()->routeIs('challenges.show'))
            <button @click="$dispatch('open-modal', 'quick-complete')" class="fab group">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                </svg>
                <span class="fab-tooltip">
                    Quick Complete
                </span>
            </button>

            <!-- Quick Complete Modal -->
            <x-modals.quick-complete />
        @endif

        <!-- Flash Messages Data for Toast System -->
        @if(session()->has('success') || session()->has('error') || session()->has('info') || session()->has('warning'))
        <div id="flash-messages" 
             data-message="{{ session('success') ?? session('error') ?? session('info') ?? session('warning') }}"
             data-type="@if(session()->has('success'))success @elseif(session()->has('error'))error @elseif(session()->has('info'))info @else warning @endif"
             style="display: none;">
        </div>
        @endif
    </body>
</html>
