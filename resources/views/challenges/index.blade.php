<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center space-y-4 sm:space-y-0">
            <div class="flex items-center space-x-3">
                <div class="bg-gradient-to-r from-purple-500 to-pink-500 p-2 rounded-lg">
                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <h2 class="font-bold text-xl sm:text-2xl text-gray-800 leading-tight">
                    {{ __('My Challenges') }}
                </h2>
            </div>
            <a href="{{ route('challenges.create') }}" class="w-full sm:w-auto bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-semibold py-2 px-4 rounded-lg shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200 flex items-center justify-center space-x-2">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"></path>
                </svg>
                <span class="hidden sm:inline">Create New Challenge</span>
                <span class="sm:hidden">New Challenge</span>
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Challenge Statistics -->
    <!-- Overview Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6 mb-8">
        <!-- Total Challenges -->
        <div class="bg-white overflow-hidden shadow-lg rounded-lg hover:shadow-xl transition-shadow duration-300">
            <div class="p-4 md:p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="bg-gradient-to-r from-blue-500 to-indigo-500 p-2 md:p-3 rounded-lg">
                            <svg class="w-5 h-5 md:w-6 md:h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2 6a2 2 0 012-2h5l2 2h5a2 2 0 012 2v6a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-3 md:ml-4 min-w-0">
                        <div class="text-xs md:text-sm font-medium text-gray-500 truncate">
                            Total Challenges
                        </div>
                        <div class="text-xl md:text-2xl font-bold text-gray-900">
                            {{ $totalChallenges }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Completed Challenges -->
        <div class="bg-white overflow-hidden shadow-lg rounded-lg hover:shadow-xl transition-shadow duration-300">
            <div class="p-4 md:p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="bg-gradient-to-r from-green-500 to-green-600 p-2 md:p-3 rounded-lg">
                            <svg class="w-5 h-5 md:w-6 md:h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-3 md:ml-4 min-w-0">
                        <div class="text-xs md:text-sm font-medium text-gray-500 truncate">
                            Completed
                        </div>
                        <div class="text-xl md:text-2xl font-bold text-gray-900">
                            {{ $challenges->where('completed_at', '!=', null)->count() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Active Challenges -->
        <div class="bg-white overflow-hidden shadow-lg rounded-lg hover:shadow-xl transition-shadow duration-300">
            <div class="p-4 md:p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="bg-gradient-to-r from-yellow-400 to-orange-500 p-2 md:p-3 rounded-lg">
                            <svg class="w-5 h-5 md:w-6 md:h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.293l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13a1 1 0 102 0V9.414l1.293 1.293a1 1 0 001.414-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-3 md:ml-4 min-w-0">
                        <div class="text-xs md:text-sm font-medium text-gray-500 truncate">
                            Active Challenges
                        </div>
                        <div class="text-xl md:text-2xl font-bold text-gray-900">
                            {{ $activeChallenges }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Draft Challenges -->
        <div class="bg-white overflow-hidden shadow-lg rounded-lg hover:shadow-xl transition-shadow duration-300">
            <div class="p-4 md:p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="bg-gradient-to-r from-gray-500 to-gray-600 p-2 md:p-3 rounded-lg">
                            <svg class="w-5 h-5 md:w-6 md:h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-3 md:ml-4 min-w-0">
                        <div class="text-xs md:text-sm font-medium text-gray-500 truncate">
                            Draft
                        </div>
                        <div class="text-xl md:text-2xl font-bold text-gray-900">
                            {{ $challenges->where('started_at', null)->count() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

            @if($challenges->isNotEmpty())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($challenges as $challenge)
                    <div class="bg-gradient-to-br from-white to-gray-50 overflow-hidden shadow-xl rounded-2xl border border-gray-200 hover:shadow-2xl transition-all duration-300 transform hover:scale-[1.02]">
                        <div class="p-4 sm:p-6">
                            <div class="flex flex-col sm:flex-row justify-between items-start mb-4 space-y-2 sm:space-y-0">
                                <h3 class="text-lg sm:text-xl font-bold text-gray-900 pr-2">{{ $challenge->name }}</h3>
                                @if($challenge->completed_at)
                                    <span class="px-3 py-1 text-xs sm:text-sm font-bold rounded-full shadow-md bg-gradient-to-r from-green-400 to-green-500 text-white whitespace-nowrap">
                                        ✓ Completed
                                    </span>
                                @elseif($challenge->started_at && $challenge->is_active)
                                    <span class="px-3 py-1 text-xs sm:text-sm font-bold rounded-full shadow-md bg-gradient-to-r from-yellow-400 to-orange-500 text-white whitespace-nowrap">
                                        🏃 Active
                                    </span>
                                @elseif($challenge->started_at && !$challenge->is_active)
                                    <span class="px-3 py-1 text-xs sm:text-sm font-bold rounded-full shadow-md bg-gradient-to-r from-purple-400 to-indigo-500 text-white whitespace-nowrap">
                                        ⏸️ Paused
                                    </span>
                                @else
                                    <span class="px-3 py-1 text-xs sm:text-sm font-bold rounded-full shadow-md bg-gradient-to-r from-gray-400 to-gray-500 text-white whitespace-nowrap">
                                        📝 Draft
                                    </span>
                                @endif
                            </div>
                            
                            @if($challenge->description)
                                <p class="text-sm text-gray-700 mb-4 leading-relaxed">{{ Str::limit($challenge->description, 100) }}</p>
                            @endif
                            
                            <div class="space-y-3 mb-6">
                                <div class="flex items-center justify-between text-sm bg-gray-50 rounded-lg p-3">
                                    <div class="flex items-center space-x-2 text-gray-600">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span>Duration:</span>
                                    </div>
                                    <span class="font-semibold text-gray-900">{{ $challenge->days_duration }} days</span>
                                </div>
                                <div class="flex items-center justify-between text-sm bg-gray-50 rounded-lg p-3">
                                    <div class="flex items-center space-x-2 text-gray-600">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span>Goals:</span>
                                    </div>
                                    <span class="font-semibold text-gray-900">{{ $challenge->goals->count() }}</span>
                                </div>
                                @if($challenge->started_at)
                                    <div class="flex items-center justify-between text-sm bg-gray-50 rounded-lg p-3">
                                        <div class="flex items-center space-x-2 text-gray-600">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                            </svg>
                                            <span>Started:</span>
                                        </div>
                                        <span class="font-semibold text-gray-900">{{ $challenge->started_at->format('M j, Y') }}</span>
                                    </div>
                                @endif
                                <div class="flex items-center justify-between text-sm bg-gray-50 rounded-lg p-3">
                                    <div class="flex items-center space-x-2 text-gray-600">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span>End Date:</span>
                                    </div>
                                    <span class="font-semibold text-gray-900">
                                        @if($challenge->started_at)
                                            {{ $challenge->started_at->addDays($challenge->days_duration - 1)->format('M j, Y') }}
                                        @else
                                            -
                                        @endif
                                    </span>
                                </div>
                                <div class="flex items-center justify-between text-sm bg-gray-50 rounded-lg p-3">
                                    <div class="flex items-center space-x-2 text-gray-600">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span>Completed:</span>
                                    </div>
                                    <span class="font-semibold text-gray-900">
                                        @if($challenge->completed_at)
                                            {{ $challenge->completed_at->format('M j, Y') }}
                                        @else
                                            -
                                        @endif
                                    </span>
                                </div>
                                @if($challenge->is_active && !$challenge->completed_at)
                                    <div class="bg-gradient-to-r from-blue-50 to-purple-50 rounded-lg p-3">
                                        <div class="flex justify-between text-sm mb-2">
                                            <span class="text-gray-700 font-medium">Progress</span>
                                            <span class="font-bold text-blue-600">{{ number_format($challenge->getProgressPercentage(), 1) }}%</span>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-3 shadow-inner">
                                            <div class="bg-gradient-to-r from-blue-500 to-purple-500 h-3 rounded-full shadow-sm transition-all duration-500" style="width: {{ $challenge->getProgressPercentage() }}%"></div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            
                            <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-2">
                                <a href="{{ route('challenges.show', $challenge) }}" class="flex-1 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white text-sm font-semibold py-2.5 px-4 rounded-lg text-center shadow-md hover:shadow-lg transform hover:scale-105 transition-all duration-200 flex items-center justify-center space-x-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                                        <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span>View</span>
                                </a>
                                
                                @if(!$challenge->started_at && !$challenge->completed_at)
                                    <form action="{{ route('challenges.start', $challenge) }}" method="POST" class="flex-1">
                                        @csrf
                                        <button type="submit" class="w-full bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white text-sm font-semibold py-2.5 px-4 rounded-lg shadow-md hover:shadow-lg transform hover:scale-105 transition-all duration-200 flex items-center justify-center space-x-1">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"></path>
                                            </svg>
                                            <span>Start</span>
                                        </button>
                                    </form>
                                @elseif($challenge->started_at && !$challenge->is_active && !$challenge->completed_at)
                                    <form action="{{ route('challenges.resume', $challenge) }}" method="POST" class="flex-1">
                                        @csrf
                                        <button type="submit" class="w-full bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white text-sm font-semibold py-2.5 px-4 rounded-lg shadow-md hover:shadow-lg transform hover:scale-105 transition-all duration-200 flex items-center justify-center space-x-1">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"></path>
                                            </svg>
                                            <span>Resume</span>
                                        </button>
                                    </form>
                                @endif
                                
                                @if(!$challenge->is_active && !$challenge->completed_at)
                                    <a href="{{ route('challenges.edit', $challenge) }}?back={{ urlencode(route('challenges.index')) }}" class="bg-white hover:bg-gray-50 text-gray-700 border border-gray-300 text-sm font-semibold py-2.5 px-3 sm:px-4 rounded-lg shadow-sm hover:shadow-md transform hover:scale-105 transition-all duration-200 flex items-center justify-center">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                                        </svg>
                                        <span class="ml-1 sm:hidden">Edit</span>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            @else
                <div class="bg-gradient-to-br from-white to-gray-50 overflow-hidden shadow-xl rounded-2xl border border-gray-200">
                    <div class="p-12 text-center">
                        <div class="bg-gradient-to-r from-blue-100 to-purple-100 rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-6">
                            <svg class="w-10 h-10 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Ready to Start Your Journey?</h3>
                        <p class="mt-2 text-lg text-gray-600 mb-8 max-w-md mx-auto">Create your first challenge and begin tracking your progress towards your goals!</p>
                        <div class="mt-8">
                            <a href="{{ route('challenges.create') }}" class="bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-bold py-4 px-8 rounded-lg shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200 inline-flex items-center space-x-3">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-lg">Create Your First Challenge</span>
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>