<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="{{ auth()->user()->getThemePreference() === 'dark' ? 'dark' : 'light' }}">
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
    <body class="font-sans antialiased">
        <div class="app-container" 
             x-data="{ 
                 ...quickGoalsModal(), 
                 ...themeManager() 
             }" 
             @open-goals.window="open()">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="app-header">
                    <div class="app-header-container">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="flex-grow">
                {{ $slot }}
            </main>

            <!-- Footer -->
            <x-footer />

            <!-- Desktop FAB for Quick Goal Completion (Hidden on Mobile and Challenge Detail Page) -->
            @if(!request()->routeIs('challenges.show'))
            <button @click="open()" class="fab group">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                </svg>
                <span class="fab-tooltip">
                    Quick Complete
                </span>
            </button>
            @endif

            <!-- Quick Complete Modal -->
            @if(!request()->routeIs('challenges.show'))
            <div x-show="isOpen" 
                 x-cloak
                 class="modal-overlay" 
                 style="display: none;">
                <div class="modal-container">
                    <!-- Background overlay -->
                    <div x-show="isOpen"
                         x-transition:enter="ease-out duration-300"
                         x-transition:enter-start="opacity-0"
                         x-transition:enter-end="opacity-100"
                         x-transition:leave="ease-in duration-200"
                         x-transition:leave-start="opacity-100"
                         x-transition:leave-end="opacity-0"
                         class="modal-backdrop"
                         @click="close()"></div>

                    <!-- Center modal -->
                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

                    <!-- Modal panel -->
                    <div x-show="isOpen"
                         x-transition:enter="ease-out duration-300"
                         x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                         x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                         x-transition:leave="ease-in duration-200"
                         x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                         x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                         class="modal-panel">
                        
                        <!-- Header -->
                        <div class="modal-header">
                            <div class="modal-header-title">
                                <h3>
                                    <span>Quick Complete</span>
                                </h3>
                                <button @click="close()">
                                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Tabs -->
                        <div class="modal-tabs">
                            <nav>
                                <button @click="switchTab('challenges')" 
                                        :class="activeTab === 'challenges' ? 'modal-tab active-blue' : 'modal-tab'">
                                    <span>
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                                        </svg>
                                        Challenges
                                    </span>
                                </button>
                                <button @click="switchTab('habits')" 
                                        :class="activeTab === 'habits' ? 'modal-tab active-teal' : 'modal-tab'">
                                    <span>
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                                            <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm9.707 5.707a1 1 0 00-1.414-1.414L9 12.586l-1.293-1.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                        Habits
                                    </span>
                                </button>
                            </nav>
                        </div>

                        <!-- Content -->
                        <div class="modal-content">
                            <div x-show="activeTab === 'challenges'" x-html="challengesContent"></div>
                            <div x-show="activeTab === 'habits'" x-html="habitsContent" style="display: none;"></div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>

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
