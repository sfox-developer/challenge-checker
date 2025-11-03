<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center space-x-3">
                <div class="bg-gradient-to-r from-blue-500 to-purple-500 p-2 rounded-lg">
                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h6a1 1 0 110 2H4a1 1 0 01-1-1zM3 16a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"/>
                    </svg>
                </div>
                <span>{{ __('Dashboard') }}</span>
            </h2>
            <a href="{{ route('challenges.create') }}" class="bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-semibold py-2 px-6 rounded-lg shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200 flex items-center space-x-2">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"></path>
                </svg>
                <span>Create Challenge</span>
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Active Challenges -->
            @if($activeChallenges->isNotEmpty())
            <div class="space-y-6">
                <div class="flex justify-between items-center">
                    <h3 class="text-2xl font-bold text-gray-900">Your Active Challenges</h3>
                    <a href="{{ route('challenges.index') }}" class="text-sm text-blue-600 hover:text-blue-500 font-medium">View all challenges →</a>
                </div>
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    @foreach($activeChallenges as $challenge)
                        <x-challenge-card 
                            :challenge="$challenge" 
                            :show-actions="true" 
                            :show-todays-goals="true" 
                            :compact="true" />

                        <!-- Completion Modal for each challenge -->
                        <div id="completeModal{{ $challenge->id }}" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
                            <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                                <div class="mt-3 text-center">
                                    <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-yellow-100">
                                        <svg class="h-6 w-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L4.268 13.5c-.77.833-.232 2.5 1.732 2.5z"/>
                                        </svg>
                                    </div>
                                    <h3 class="text-lg leading-6 font-medium text-gray-900 mt-4">Complete "{{ $challenge->name }}"?</h3>
                                    <div class="mt-2 px-7 py-3">
                                        <p class="text-sm text-gray-500">
                                            This will mark the challenge as complete and stop daily progress tracking.
                                        </p>
                                    </div>
                                    <div class="items-center px-4 py-3">
                                        <div class="flex space-x-3">
                                            <button onclick="hideCompleteModal{{ $challenge->id }}()" class="px-4 py-2 bg-gray-300 text-gray-800 text-base font-medium rounded-md w-full shadow-sm hover:bg-gray-400">
                                                Cancel
                                            </button>
                                            <form method="POST" action="{{ route('challenges.complete', $challenge) }}" class="w-full">
                                                @csrf
                                                <button type="submit" class="px-4 py-2 bg-blue-600 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-blue-700">
                                                    Complete Challenge
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

            @if($activeChallenges->isEmpty())
            <!-- Empty State -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-center">
                    <div class="mx-auto h-12 w-12 text-gray-400">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No challenges yet</h3>
                    <p class="mt-1 text-sm text-gray-500">Get started by creating your first challenge.</p>
                    <div class="mt-6">
                        <a href="{{ route('challenges.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Create Challenge
                        </a>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>

    <script>
        // Goal toggle functionality is now handled by goal-toggle.js

        // Modal functions for each challenge
        @foreach($activeChallenges as $challenge)
        function showCompleteModal{{ $challenge->id }}() {
            document.getElementById('completeModal{{ $challenge->id }}').classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }

        function hideCompleteModal{{ $challenge->id }}() {
            document.getElementById('completeModal{{ $challenge->id }}').classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }

        // Close modal when clicking outside
        document.getElementById('completeModal{{ $challenge->id }}').addEventListener('click', function(e) {
            if (e.target === this) {
                hideCompleteModal{{ $challenge->id }}();
            }
        });
        @endforeach

        // Close modals on Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                @foreach($activeChallenges as $challenge)
                hideCompleteModal{{ $challenge->id }}();
                @endforeach
            }
        });
    </script>
</x-app-layout>
