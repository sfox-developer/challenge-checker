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
        <div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50 dark:from-gray-900 dark:to-gray-800 pb-16 sm:pb-0 flex flex-col" 
             x-data="{ 
                 ...quickGoalsModal(), 
                 ...themeManager() 
             }" 
             @open-goals.window="open()">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white dark:bg-gray-800 bg-opacity-80 dark:bg-opacity-80 backdrop-blur-sm shadow-sm">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
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
            <button @click="open()" class="hidden sm:flex fixed bottom-8 right-8 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white rounded-full p-4 shadow-2xl hover:shadow-3xl transform hover:scale-110 transition-all duration-200 z-50 items-center justify-center group">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                </svg>
                <span class="absolute right-full mr-3 bg-gray-900 text-white px-3 py-2 rounded-lg text-sm font-semibold whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none">
                    Quick Complete
                </span>
            </button>
            @endif

            <!-- Quick Complete Modal -->
            @if(!request()->routeIs('challenges.show'))
            <div x-show="isOpen" 
                 x-cloak
                 class="fixed inset-0 z-50 overflow-y-auto" 
                 style="display: none;">
                <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                    <!-- Background overlay -->
                    <div x-show="isOpen"
                         x-transition:enter="ease-out duration-300"
                         x-transition:enter-start="opacity-0"
                         x-transition:enter-end="opacity-100"
                         x-transition:leave="ease-in duration-200"
                         x-transition:leave-start="opacity-100"
                         x-transition:leave-end="opacity-0"
                         class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75"
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
                         class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                        
                        <!-- Header -->
                        <div class="bg-gradient-to-r from-blue-600 to-purple-600 px-6 py-4">
                            <div class="flex items-center justify-between">
                                <h3 class="text-xl font-bold text-white flex items-center space-x-2">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span>Quick Complete</span>
                                </h3>
                                <button @click="close()" class="text-white hover:text-gray-200 transition-colors">
                                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Tabs -->
                        <div class="border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50">
                            <nav class="flex -mb-px">
                                <button @click="switchTab('challenges')" 
                                        :class="activeTab === 'challenges' ? 'border-blue-500 text-blue-600 dark:text-blue-400' : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-600'"
                                        class="w-1/2 py-4 px-1 text-center border-b-2 font-medium text-sm transition-colors duration-150">
                                    <span class="flex items-center justify-center gap-2">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                                        </svg>
                                        Challenges
                                    </span>
                                </button>
                                <button @click="switchTab('habits')" 
                                        :class="activeTab === 'habits' ? 'border-teal-500 text-teal-600 dark:text-teal-400' : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-600'"
                                        class="w-1/2 py-4 px-1 text-center border-b-2 font-medium text-sm transition-colors duration-150">
                                    <span class="flex items-center justify-center gap-2">
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
                        <div class="px-6 py-4 max-h-96 overflow-y-auto bg-white dark:bg-gray-800">
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
