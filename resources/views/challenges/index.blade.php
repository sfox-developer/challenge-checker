<x-app-layout>
    <x-slot name="header">
        <x-page-header title="My Challenges" gradient="from-purple-500 to-pink-500">
            <x-slot name="icon">
                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
            </x-slot>
            <x-slot name="action">
                <x-app-button variant="primary" href="{{ route('challenges.create') }}" class="w-full sm:w-auto">
                    <x-slot name="icon">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"></path>
                        </svg>
                    </x-slot>
                    <span class="hidden sm:inline">Create New Challenge</span>
                    <span class="sm:hidden">New Challenge</span>
                </x-app-button>
            </x-slot>
        </x-page-header>
    </x-slot>

    <div class="py-8" x-data="{ activeFilter: 'all' }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Challenge Statistics -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6 mb-8">
                <x-stat-card 
                    label="Total Challenges" 
                    :value="$totalChallenges" 
                    gradientFrom="blue-500" 
                    gradientTo="indigo-500">
                    <x-slot name="icon">
                        <svg class="w-5 h-5 md:w-6 md:h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2 6a2 2 0 012-2h5l2 2h5a2 2 0 012 2v6a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"></path>
                        </svg>
                    </x-slot>
                </x-stat-card>

                <x-stat-card 
                    label="Completed" 
                    :value="$challenges->where('completed_at', '!=', null)->count()" 
                    gradientFrom="green-500" 
                    gradientTo="green-600">
                    <x-slot name="icon">
                        <svg class="w-5 h-5 md:w-6 md:h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                    </x-slot>
                </x-stat-card>

                <x-stat-card 
                    label="Active Challenges" 
                    :value="$activeChallenges" 
                    gradientFrom="yellow-400" 
                    gradientTo="orange-500">
                    <x-slot name="icon">
                        <svg class="w-5 h-5 md:w-6 md:h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.293l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13a1 1 0 102 0V9.414l1.293 1.293a1 1 0 001.414-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </x-slot>
                </x-stat-card>

                <x-stat-card 
                    label="Draft" 
                    :value="$challenges->where('started_at', null)->count()" 
                    gradientFrom="gray-500" 
                    gradientTo="gray-600">
                    <x-slot name="icon">
                        <svg class="w-5 h-5 md:w-6 md:h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"></path>
                        </svg>
                    </x-slot>
                </x-stat-card>
            </div>

            <!-- Filter Tabs -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm">
                <div class="border-b border-gray-200 dark:border-gray-700">
                    <nav class="-mb-px flex space-x-8 px-6" aria-label="Tabs">
                        <button @click="activeFilter = 'all'" :class="activeFilter === 'all' ? 'border-purple-500 text-purple-600 dark:text-purple-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300'" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                            All
                        </button>
                        <button @click="activeFilter = 'active'" :class="activeFilter === 'active' ? 'border-purple-500 text-purple-600 dark:text-purple-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300'" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                            Active
                        </button>
                        <button @click="activeFilter = 'paused'" :class="activeFilter === 'paused' ? 'border-purple-500 text-purple-600 dark:text-purple-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300'" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                            Paused
                        </button>
                        <button @click="activeFilter = 'completed'" :class="activeFilter === 'completed' ? 'border-purple-500 text-purple-600 dark:text-purple-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300'" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                            Completed
                        </button>
                        <button @click="activeFilter = 'draft'" :class="activeFilter === 'draft' ? 'border-purple-500 text-purple-600 dark:text-purple-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300'" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                            Draft
                        </button>
                    </nav>
                </div>
            </div>

            @if($challenges->isNotEmpty())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($challenges as $challenge)
                    @php
                        $isActive = $challenge->started_at && $challenge->is_active && !$challenge->completed_at;
                        $isPaused = $challenge->started_at && !$challenge->is_active && !$challenge->completed_at;
                        $isCompleted = $challenge->completed_at !== null;
                        $isDraft = !$challenge->started_at;
                    @endphp
                    <div 
                        x-show="activeFilter === 'all' || 
                                (activeFilter === 'active' && {{ $isActive ? 'true' : 'false' }}) || 
                                (activeFilter === 'paused' && {{ $isPaused ? 'true' : 'false' }}) || 
                                (activeFilter === 'completed' && {{ $isCompleted ? 'true' : 'false' }}) || 
                                (activeFilter === 'draft' && {{ $isDraft ? 'true' : 'false' }})"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 transform scale-95"
                        x-transition:enter-end="opacity-100 transform scale-100"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 transform scale-100"
                        x-transition:leave-end="opacity-0 transform scale-95"
                        class="card card-hover">
                        
                        <div class="flex flex-col sm:flex-row justify-between items-start mb-4 space-y-2 sm:space-y-0">
                            <h3 class="text-lg sm:text-xl font-bold text-gray-800 dark:text-gray-100 pr-2">{{ $challenge->name }}</h3>
                            @if($challenge->completed_at)
                                <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-teal-100 text-teal-800 dark:bg-teal-900 dark:text-teal-200 whitespace-nowrap">
                                    ✓ Completed
                                </span>
                            @elseif($challenge->started_at && $challenge->is_active)
                                <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 whitespace-nowrap">
                                    🏃 Active
                                </span>
                            @elseif($challenge->started_at && !$challenge->is_active)
                                <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200 whitespace-nowrap">
                                    ⏸️ Paused
                                </span>
                            @else
                                <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200 whitespace-nowrap">
                                    📝 Draft
                                </span>
                            @endif
                        </div>
                        
                        @if($challenge->description)
                            <p class="text-sm text-gray-700 dark:text-gray-100 mb-4 leading-relaxed">{{ Str::limit($challenge->description, 100) }}</p>
                        @endif
                        
                        <div class="space-y-3 mb-6">
                            <div class="flex items-center justify-between text-sm bg-gray-50 dark:bg-gray-700/50 rounded-lg p-3">
                                <div class="flex items-center space-x-2 text-gray-600 dark:text-gray-400">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span>Frequency:</span>
                                </div>
                                <span class="font-semibold text-gray-800 dark:text-gray-100">{{ $challenge->getFrequencyDescription() }}</span>
                            </div>
                            @if($challenge->days_duration)
                            <div class="flex items-center justify-between text-sm bg-gray-50 dark:bg-gray-700/50 rounded-lg p-3">
                                <div class="flex items-center space-x-2 text-gray-600 dark:text-gray-400">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span>Duration:</span>
                                </div>
                                <span class="font-semibold text-gray-800 dark:text-gray-100">{{ $challenge->days_duration }} days</span>
                            </div>
                            @endif
                            <div class="flex items-center justify-between text-sm bg-gray-50 dark:bg-gray-700/50 rounded-lg p-3">
                                <div class="flex items-center space-x-2 text-gray-600 dark:text-gray-400">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span>Goals:</span>
                                </div>
                                <span class="font-semibold text-gray-800 dark:text-gray-100">{{ $challenge->goals->count() }}</span>
                            </div>
                            @if($challenge->started_at)
                                <div class="flex items-center justify-between text-sm bg-gray-50 dark:bg-gray-700/50 rounded-lg p-3">
                                    <div class="flex items-center space-x-2 text-gray-600 dark:text-gray-400">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span>Started:</span>
                                    </div>
                                    <span class="font-semibold text-gray-800 dark:text-gray-100 dark:text-gray-100">{{ $challenge->started_at->format('M j, Y') }}</span>
                                </div>
                            @endif
                            <div class="flex items-center justify-between text-sm bg-gray-50 dark:bg-gray-700/50 rounded-lg p-3">
                                <div class="flex items-center space-x-2 text-gray-600 dark:text-gray-400">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span>End Date:</span>
                                </div>
                                <span class="font-semibold text-gray-800 dark:text-gray-100">
                                    @if($challenge->started_at && $challenge->days_duration)
                                        {{ $challenge->started_at->addDays($challenge->days_duration - 1)->format('M j, Y') }}
                                    @else
                                        -
                                    @endif
                                </span>
                            </div>
                            <div class="flex items-center justify-between text-sm bg-gray-50 dark:bg-gray-700/50 rounded-lg p-3">
                                <div class="flex items-center space-x-2 text-gray-600 dark:text-gray-400">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span>Completed:</span>
                                </div>
                                <span class="font-semibold text-gray-800 dark:text-gray-100 dark:text-gray-100">
                                    @if($challenge->completed_at)
                                        {{ $challenge->completed_at->format('M j, Y') }}
                                    @else
                                        -
                                    @endif
                                </span>
                            </div>
                            @if($challenge->is_active && !$challenge->completed_at)
                                <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-3">
                                    <div class="flex justify-between text-sm mb-2">
                                        <span class="text-gray-700 dark:text-gray-400 font-medium">Progress</span>
                                        <span class="font-semibold text-teal-600 dark:text-teal-400">{{ number_format($challenge->getProgressPercentage(), 1) }}%</span>
                                    </div>
                                    <div class="w-full bg-gray-200 dark:bg-gray-600 rounded-full h-1.5">
                                        <div class="bg-teal-500 h-1.5 rounded-full transition-all duration-300" style="width: {{ $challenge->getProgressPercentage() }}%"></div>
                                    </div>
                                </div>
                            @endif
                        </div>
                        
                        <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-2">
                            <x-app-button variant="primary" href="{{ route('challenges.show', $challenge) }}" class="flex-1">
                                <x-slot name="icon">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                                        <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path>
                                    </svg>
                                </x-slot>
                                View
                            </x-app-button>
                            
                            @if(!$challenge->started_at && !$challenge->completed_at)
                                <form action="{{ route('challenges.start', $challenge) }}" method="POST" class="flex-1">
                                    @csrf
                                    <x-app-button variant="success" size="sm" type="submit" class="w-full">
                                        <x-slot name="icon">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"></path>
                                            </svg>
                                        </x-slot>
                                        Start
                                    </x-app-button>
                                </form>
                            @elseif($challenge->started_at && !$challenge->is_active && !$challenge->completed_at)
                                <form action="{{ route('challenges.resume', $challenge) }}" method="POST" class="flex-1">
                                    @csrf
                                    <x-app-button variant="success" size="sm" type="submit" class="w-full">
                                        <x-slot name="icon">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"></path>
                                            </svg>
                                        </x-slot>
                                        Resume
                                    </x-app-button>
                                </form>
                            @endif
                            
                            @if(!$challenge->is_active && !$challenge->completed_at)
                                <x-app-button variant="secondary" href="{{ route('challenges.edit', $challenge) }}?back={{ urlencode(route('challenges.index')) }}">
                                    <x-slot name="icon">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                                        </svg>
                                    </x-slot>
                                    <span class="sm:hidden">Edit</span>
                                </x-app-button>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
            @else
                <div class="card">
                    <div class="p-8 text-center">
                        <div class="bg-gradient-to-r from-blue-100 dark:from-blue-900 to-purple-100 dark:to-purple-900 rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-6">
                            <svg class="w-10 h-10 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-4">Ready to Start Your Journey?</h3>
                        <p class="mt-2 text-lg text-gray-600 dark:text-gray-400 mb-8 max-w-md mx-auto">Create your first challenge and begin tracking your progress towards your goals!</p>
                        <div class="mt-8">
                            <x-app-button variant="primary" href="{{ route('challenges.create') }}" class="inline-flex">
                                <x-slot name="icon">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"></path>
                                    </svg>
                                </x-slot>
                                <span class="text-lg">Create Your First Challenge</span>
                            </x-app-button>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>