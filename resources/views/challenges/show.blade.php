<x-app-layout>
    <x-slot name="header">
        <x-page-header :title="$challenge->name">
            <x-slot name="icon">
                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
            </x-slot>
            <x-slot name="action">
                <div class="flex space-x-2">
                    @if(!$challenge->completed_at)
                        <x-app-button variant="secondary" href="{{ route('challenges.index') }}">
                            <x-slot name="icon">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"/>
                                </svg>
                            </x-slot>
                            Back
                        </x-app-button>
                        
                        <x-app-button variant="secondary" href="{{ route('challenges.edit', $challenge) }}">
                            <x-slot name="icon">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                                </svg>
                            </x-slot>
                            Edit
                        </x-app-button>
                        
                        @if($challenge->started_at)
                            @if($challenge->is_active)
                                <form method="POST" action="{{ route('challenges.pause', $challenge) }}">
                                    @csrf
                                    <x-app-button variant="secondary" type="submit">
                                        <x-slot name="icon">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zM7 8a1 1 0 012 0v4a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v4a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                            </svg>
                                        </x-slot>
                                        Pause
                                    </x-app-button>
                                </form>
                            @else
                                <form method="POST" action="{{ route('challenges.resume', $challenge) }}">
                                    @csrf
                                    <x-app-button variant="secondary" type="submit">
                                        <x-slot name="icon">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"/>
                                            </svg>
                                        </x-slot>
                                        Resume
                                    </x-app-button>
                                </form>
                            @endif
                            
                            <x-app-button variant="secondary" type="button" onclick="showCompleteModal()">
                                <x-slot name="icon">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                </x-slot>
                                Complete
                            </x-app-button>
                        @else
                            <form method="POST" action="{{ route('challenges.start', $challenge) }}">
                                @csrf
                                <x-app-button variant="primary" type="submit">
                                    <x-slot name="icon">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"/>
                                        </svg>
                                    </x-slot>
                                    Start Challenge
                                </x-app-button>
                            </form>
                        @endif
                    @else
                        <x-app-button variant="secondary" href="{{ route('challenges.index') }}">
                            <x-slot name="icon">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"/>
                                </svg>
                            </x-slot>
                            Back
                        </x-app-button>
                    @endif
                </div>
            </x-slot>
        </x-page-header>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <x-stat-card 
                    label="Duration" 
                    :value="$challenge->getDuration()" 
                    gradientFrom="blue-500" 
                    gradientTo="indigo-500">
                    <x-slot name="icon">
                        <svg class="w-5 h-5 md:w-6 md:h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                        </svg>
                    </x-slot>
                    <x-slot name="suffix">days</x-slot>
                </x-stat-card>

                <x-stat-card 
                    label="Goals" 
                    :value="$challenge->goals->count()" 
                    gradientFrom="purple-500" 
                    gradientTo="pink-500">
                    <x-slot name="icon">
                        <svg class="w-5 h-5 md:w-6 md:h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm3 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1zm-3 4a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"/>
                        </svg>
                    </x-slot>
                </x-stat-card>

                <x-stat-card 
                    label="Progress" 
                    :value="number_format($challenge->getProgressPercentage(), 1)" 
                    gradientFrom="green-500" 
                    gradientTo="teal-500">
                    <x-slot name="icon">
                        <svg class="w-5 h-5 md:w-6 md:h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                    </x-slot>
                    <x-slot name="suffix">%</x-slot>
                </x-stat-card>

                <x-stat-card 
                    label="Completed" 
                    :value="$challenge->dailyProgress()->whereNotNull('completed_at')->count()" 
                    gradientFrom="green-500" 
                    gradientTo="teal-500">
                    <x-slot name="icon">
                        <svg class="w-5 h-5 md:w-6 md:h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05 6.981 6.981 0 003 11a7 7 0 1011.95-4.95c-.592-.591-.98-.985-1.348-1.467-.363-.476-.724-1.063-1.207-2.03zM12.12 15.12A3 3 0 017 13s.879.5 2.5.5c0-1 .5-4 1.25-4.5.5 1 .786 1.293 1.371 1.879A2.99 2.99 0 0113 13a2.99 2.99 0 01-.879 2.121z" clip-rule="evenodd"/>
                        </svg>
                    </x-slot>
                    <x-slot name="suffix">/ {{ $challenge->goals->count() * $challenge->getDuration() }}</x-slot>
                </x-stat-card>
            </div>

            <!-- Challenge Details and Progress Side by Side -->
            <div class="grid lg:grid-cols-2 gap-6">
                <!-- Challenge Details -->
                <div class="card">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">Details</h3>
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
                        <p class="text-sm text-gray-700 dark:text-gray-100 mb-4 leading-relaxed">{{ $challenge->description }}</p>
                    @endif
                    
                    <div class="space-y-3">
                        <div class="flex items-center justify-between text-sm bg-gray-50 dark:bg-gray-700/50 rounded-lg p-3">
                            <div class="flex items-center space-x-2 text-gray-600 dark:text-gray-400">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                </svg>
                                <span>Frequency:</span>
                            </div>
                            <span class="font-semibold text-gray-900 dark:text-white">{{ $challenge->getFrequencyDescription() }}</span>
                        </div>
                        
                        @if($challenge->days_duration)
                        <div class="flex items-center justify-between text-sm bg-gray-50 dark:bg-gray-700/50 rounded-lg p-3">
                            <div class="flex items-center space-x-2 text-gray-600 dark:text-gray-400">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                                </svg>
                                <span>Duration:</span>
                            </div>
                            <span class="font-semibold text-gray-900 dark:text-white">{{ $challenge->days_duration }} days</span>
                        </div>
                        @endif
                        
                        <div class="flex items-center justify-between text-sm bg-gray-50 dark:bg-gray-700/50 rounded-lg p-3">
                            <div class="flex items-center space-x-2 text-gray-600 dark:text-gray-400">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm3 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1zm-3 4a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"/>
                                </svg>
                                <span>Goals:</span>
                            </div>
                            <span class="font-semibold text-gray-900 dark:text-white">{{ $challenge->goals->count() }}</span>
                        </div>
                        
                        @if($challenge->started_at)
                        <div class="flex items-center justify-between text-sm bg-gray-50 dark:bg-gray-700/50 rounded-lg p-3">
                            <div class="flex items-center space-x-2 text-gray-600 dark:text-gray-400">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"/>
                                </svg>
                                <span>Started:</span>
                            </div>
                            <span class="font-semibold text-gray-900 dark:text-white">{{ $challenge->started_at->format('M d, Y') }}</span>
                        </div>
                        @endif
                        
                        @if($challenge->end_date)
                        <div class="flex items-center justify-between text-sm bg-gray-50 dark:bg-gray-700/50 rounded-lg p-3">
                            <div class="flex items-center space-x-2 text-gray-600 dark:text-gray-400">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                </svg>
                                <span>End Date:</span>
                            </div>
                            <span class="font-semibold text-gray-900 dark:text-white">{{ $challenge->end_date->format('M d, Y') }}</span>
                        </div>
                        @endif
                        
                        @if($challenge->completed_at)
                        <div class="flex items-center justify-between text-sm bg-gray-50 dark:bg-gray-700/50 rounded-lg p-3">
                            <div class="flex items-center space-x-2 text-gray-600 dark:text-gray-400">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span>Completed:</span>
                            </div>
                            <span class="font-semibold text-gray-900 dark:text-white">{{ $challenge->completed_at->diffForHumans() }}</span>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Progress Card -->
                <div class="card">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">Progress</h3>
                    </div>
                    
                    @if($challenge->started_at && !$challenge->completed_at)
                        <!-- Active Progress Bar -->
                        <div class="mb-6">
                            <div class="flex justify-between text-sm text-gray-600 dark:text-gray-400 mb-2">
                                <span class="font-medium">Overall Progress</span>
                                <span class="font-semibold">{{ number_format($challenge->getProgressPercentage(), 1) }}%</span>
                            </div>
                            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-1.5">
                                <div class="bg-teal-500 h-1.5 rounded-full transition-all duration-300" 
                                     style="width: {{ $challenge->getProgressPercentage() }}%"></div>
                            </div>
                            @if(!$challenge->is_active)
                                <p class="text-xs text-purple-600 dark:text-purple-400 mt-2 flex items-center">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zM7 8a1 1 0 012 0v4a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v4a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                    Challenge is paused
                                </p>
                            @endif
                        </div>
                    @endif

                    
                    @if($challenge->completed_at)
                        <!-- Completion Summary -->
                        <div class="bg-teal-50 dark:bg-teal-900/20 rounded-lg p-4 border border-teal-200 dark:border-teal-800">
                            <div class="flex items-start space-x-3">
                                <svg class="w-5 h-5 text-teal-600 dark:text-teal-400 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <div class="flex-1">
                                    <p class="text-sm font-semibold text-teal-900 dark:text-teal-100">Challenge Completed!</p>
                                    <p class="text-xs text-teal-700 dark:text-teal-300 mt-1">
                                        Finished {{ $challenge->completed_at->diffForHumans() }} on {{ $challenge->completed_at->format('M d, Y') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @elseif(!$challenge->started_at)
                        <!-- Not Started Yet -->
                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-4 border border-gray-200 dark:border-gray-600">
                            <div class="flex items-start space-x-3">
                                <svg class="w-5 h-5 text-gray-600 dark:text-gray-400 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                </svg>
                                <div class="flex-1">
                                    <p class="text-sm font-semibold text-gray-900 dark:text-gray-100">Ready to Start</p>
                                    <p class="text-xs text-gray-700 dark:text-gray-300 mt-1">
                                        This challenge hasn't been started yet. Start tracking your progress below!
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Daily Goals Section -->
            @if($challenge->goals->isNotEmpty())
                <div class="card">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">Challenge Goals</h3>
                        <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-200">
                            {{ $challenge->goals->count() }} {{ Str::plural('goal', $challenge->goals->count()) }}
                        </span>
                    </div>
                    <x-goals-info-list :goals="$challenge->goals" />
                </div>
            @endif

            <!-- Progress History -->
            @if($challenge->started_at)
                <div class="card">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">
                            @php
                                $periodName = match($challenge->frequency_type?->value ?? 'daily') {
                                    'daily' => 'Daily',
                                    'weekly' => 'Weekly',
                                    'monthly' => 'Monthly',
                                    'yearly' => 'Yearly',
                                    default => 'Daily'
                                };
                            @endphp
                            {{ $periodName }} Progress History
                        </h3>
                    </div>

                    @php
                        $startDate = $challenge->started_at->startOfDay();
                        $endDate = $challenge->completed_at ? $challenge->completed_at->startOfDay() : now()->startOfDay();
                        $daysPassed = $startDate->diffInDays($endDate) + 1;
                        $frequencyType = $challenge->frequency_type?->value ?? 'daily';
                        
                        // Calculate perfect periods based on frequency type
                        $perfectPeriods = 0;
                        $totalPeriods = 0;
                        
                        if ($frequencyType === 'daily') {
                            // Daily: Show individual days
                            $totalPeriods = $daysPassed;
                            for ($i = 0; $i < $daysPassed; $i++) {
                                $checkDate = $startDate->copy()->addDays($i);
                                $completedGoalsForDay = $challenge->dailyProgress()
                                    ->where('user_id', $challenge->user_id)
                                    ->where('date', $checkDate->toDateString())
                                    ->whereNotNull('completed_at')
                                    ->count();
                                
                                if ($completedGoalsForDay === $challenge->goals->count()) {
                                    $perfectPeriods++;
                                }
                            }
                            $periodLabel = $totalPeriods === 1 ? 'Day' : 'Days';
                            $displayDays = min($daysPassed, 30);
                            $showingPartial = $daysPassed > 30;
                        } else {
                            // Weekly/Monthly/Yearly: Calculate completed periods
                            $currentDate = $startDate->copy();
                            $frequencyEnum = $challenge->frequency_type;
                            $requiredCompletions = $challenge->frequency_count ?? 1;
                            
                            while ($currentDate->lte($endDate)) {
                                $periodStart = $frequencyEnum->periodStart($currentDate);
                                $periodEnd = $frequencyEnum->periodEnd($currentDate);
                                
                                // Count total completions in this period across all goals
                                $completionsInPeriod = $challenge->dailyProgress()
                                    ->where('user_id', $challenge->user_id)
                                    ->whereBetween('date', [$periodStart->format('Y-m-d'), $periodEnd->format('Y-m-d')])
                                    ->whereNotNull('completed_at')
                                    ->count();
                                
                                $expectedCompletions = $challenge->goals->count() * $requiredCompletions;
                                if ($completionsInPeriod >= $expectedCompletions) {
                                    $perfectPeriods++;
                                }
                                
                                $totalPeriods++;
                                
                                // Move to next period
                                $currentDate = match($frequencyType) {
                                    'weekly' => $currentDate->addWeek(),
                                    'monthly' => $currentDate->addMonth(),
                                    'yearly' => $currentDate->addYear(),
                                    default => $currentDate->addDay(),
                                };
                            }
                            
                            $periodLabel = match($frequencyType) {
                                'weekly' => $totalPeriods === 1 ? 'Week' : 'Weeks',
                                'monthly' => $totalPeriods === 1 ? 'Month' : 'Months',
                                'yearly' => $totalPeriods === 1 ? 'Year' : 'Years',
                                default => 'Periods'
                            };
                            $displayDays = min($totalPeriods, 12); // Show max 12 periods for non-daily
                            $showingPartial = $totalPeriods > 12;
                        }
                    @endphp

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                        <div class="text-center bg-gray-50 dark:bg-gray-700/50 rounded-lg p-4">
                            <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $totalPeriods }}</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">{{ $periodLabel }} Active</div>
                        </div>
                        <div class="text-center bg-gray-50 dark:bg-gray-700/50 rounded-lg p-4">
                            <div class="text-2xl font-bold text-teal-600 dark:text-teal-400">{{ $perfectPeriods }}</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">Perfect {{ $periodLabel }}</div>
                        </div>
                        <div class="text-center bg-gray-50 dark:bg-gray-700/50 rounded-lg p-4">
                            <div class="text-2xl font-bold text-purple-600 dark:text-purple-400">
                                {{ number_format(($perfectPeriods / max($totalPeriods, 1)) * 100, 1) }}%
                            </div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">Success Rate</div>
                        </div>
                    </div>

                    @if($showingPartial && $frequencyType === 'daily')
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4 text-center">
                            <em>Showing last 30 days ({{ $daysPassed - 30 }} earlier days not displayed)</em>
                        </p>
                    @elseif($showingPartial)
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4 text-center">
                            <em>Showing last 12 periods ({{ $totalPeriods - 12 }} earlier periods not displayed)</em>
                        </p>
                    @endif

                    @if($frequencyType === 'daily')
                        {{-- Daily view: Show calendar grid --}}
                        <div class="grid grid-cols-7 gap-2 mb-4">
                        @for ($i = $showingPartial ? ($daysPassed - 30) : 0; $i < $daysPassed; $i++)
                            @php
                                $currentDate = $startDate->copy()->addDays($i);
                                $isToday = $currentDate->isToday();
                                $dayName = $currentDate->format('D');
                                $dayNumber = $currentDate->format('j');
                                
                                // Get completed goals for this day for the challenge owner
                                $completedGoalsForDay = $challenge->dailyProgress()
                                    ->where('user_id', $challenge->user_id)
                                    ->where('date', $currentDate->toDateString())
                                    ->whereNotNull('completed_at')
                                    ->count();
                                
                                $totalGoals = $challenge->goals->count();
                                $completionPercentage = $totalGoals > 0 ? ($completedGoalsForDay / $totalGoals) * 100 : 0;
                                
                                // Determine styling based on completion
                                if ($completionPercentage === 100) {
                                    $bgColor = 'bg-teal-500 text-white';
                                } elseif ($completionPercentage > 0) {
                                    $bgColor = 'bg-yellow-400 text-gray-800 dark:text-gray-100';
                                } else {
                                    $bgColor = 'bg-gray-200 dark:bg-gray-600 text-gray-600 dark:text-gray-400';
                                }
                                
                                if ($isToday) {
                                    $bgColor .= ' ring-2 ring-blue-500';
                                }
                            @endphp
                            
                            <div class="text-center">
                                <div class="text-xs text-gray-600 dark:text-gray-400 mb-1">{{ $dayName }}</div>
                                <div class="w-8 h-8 rounded-full {{ $bgColor }} flex items-center justify-center text-xs font-semibold mx-auto relative" title="{{ $currentDate->format('M j, Y') }}: {{ $completedGoalsForDay }}/{{ $totalGoals }} goals completed">
                                    {{ $dayNumber }}
                                    @if($isToday)
                                        <div class="absolute -bottom-1 w-1 h-1 bg-blue-500 rounded-full"></div>
                                    @endif
                                </div>
                                <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $completedGoalsForDay }}/{{ $totalGoals }}</div>
                            </div>
                        @endfor
                        </div>
                    @else
                        {{-- Period view: Show progress bars for each period --}}
                        <div class="space-y-3 mb-4">
                            @php
                                $currentDate = $startDate->copy();
                                $frequencyEnum = $challenge->frequency_type;
                                $requiredCompletions = $challenge->frequency_count ?? 1;
                                $periodsToShow = [];
                                $periodIndex = 0;
                                
                                while ($currentDate->lte($endDate) && $periodIndex < ($showingPartial ? 12 : 999)) {
                                    $periodStart = $frequencyEnum->periodStart($currentDate);
                                    $periodEnd = $frequencyEnum->periodEnd($currentDate);
                                    $isCurrentPeriod = now()->between($periodStart, $periodEnd);
                                    
                                    // Count completions in this period
                                    $completionsInPeriod = $challenge->dailyProgress()
                                        ->where('user_id', $challenge->user_id)
                                        ->whereBetween('date', [$periodStart->format('Y-m-d'), $periodEnd->format('Y-m-d')])
                                        ->whereNotNull('completed_at')
                                        ->count();
                                    
                                    $expectedCompletions = $challenge->goals->count() * $requiredCompletions;
                                    $percentage = $expectedCompletions > 0 ? min(100, ($completionsInPeriod / $expectedCompletions) * 100) : 0;
                                    
                                    $periodsToShow[] = [
                                        'start' => $periodStart,
                                        'end' => $periodEnd,
                                        'completions' => $completionsInPeriod,
                                        'expected' => $expectedCompletions,
                                        'percentage' => $percentage,
                                        'isCurrentPeriod' => $isCurrentPeriod,
                                    ];
                                    
                                    $periodIndex++;
                                    
                                    // Move to next period
                                    $currentDate = match($frequencyType) {
                                        'weekly' => $currentDate->addWeek(),
                                        'monthly' => $currentDate->addMonth(),
                                        'yearly' => $currentDate->addYear(),
                                        default => $currentDate->addDay(),
                                    };
                                }
                                
                                // Show in reverse (most recent first)
                                $periodsToShow = array_reverse($periodsToShow);
                            @endphp
                            
                            @foreach($periodsToShow as $period)
                                <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-4 {{ $period['isCurrentPeriod'] ? 'ring-2 ring-blue-500' : '' }}">
                                    <div class="flex items-center justify-between mb-2">
                                        <div class="text-sm font-semibold text-gray-900 dark:text-white">
                                            {{ $period['start']->format('M j') }} - {{ $period['end']->format('M j, Y') }}
                                            @if($period['isCurrentPeriod'])
                                                <span class="ml-2 px-2 py-0.5 text-xs bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 rounded">Current</span>
                                            @endif
                                        </div>
                                        <div class="text-sm text-gray-600 dark:text-gray-400">
                                            {{ $period['completions'] }}/{{ $period['expected'] }}
                                        </div>
                                    </div>
                                    <div class="w-full bg-gray-200 dark:bg-gray-600 rounded-full h-2">
                                        <div class="h-2 rounded-full transition-all {{ $period['percentage'] >= 100 ? 'bg-teal-500' : 'bg-blue-500' }}" style="width: {{ $period['percentage'] }}%"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif                    @if($frequencyType === 'daily')
                    <div class="flex items-center justify-center space-x-6 text-xs text-gray-600 dark:text-gray-400">
                        <div class="flex items-center space-x-2">
                            <div class="w-3 h-3 rounded-full bg-teal-500"></div>
                            <span>All goals completed</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <div class="w-3 h-3 rounded-full bg-yellow-400"></div>
                            <span>Some goals completed</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <div class="w-3 h-3 rounded-full bg-gray-200 dark:bg-gray-600"></div>
                            <span>No goals completed</span>
                        </div>
                    </div>
                    @else
                    <div class="text-center text-xs text-gray-600 dark:text-gray-400">
                        <p>Progress bars show completion for each {{ strtolower($periodLabel) }}. Target: {{ $challenge->frequency_count ?? 1 }}x per {{ strtolower(rtrim($periodLabel, 's')) }} for each goal.</p>
                    </div>
                    @endif
                </div>
            @endif
        </div>
    </div>

    <!-- Completion Confirmation Modal -->
    <div id="completeModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-yellow-100">
                    <svg class="h-6 w-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L4.268 13.5c-.77.833-.232 2.5 1.732 2.5z"/>
                    </svg>
                </div>
                <h3 class="text-lg leading-6 font-medium text-gray-800 dark:text-gray-100 mt-4">Complete Challenge?</h3>
                <div class="mt-2 px-7 py-3">
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Are you sure you want to mark this challenge as complete? This action cannot be undone and will stop tracking your daily progress.
                    </p>
                </div>
                <div class="items-center px-4 py-3">
                    <div class="flex space-x-3">
                        <x-app-button variant="modal-cancel" type="button" onclick="hideCompleteModal()">
                            Cancel
                        </x-app-button>
                        <form method="POST" action="{{ route('challenges.complete', $challenge) }}" class="w-full">
                            @csrf
                            <x-app-button variant="modal-confirm" type="submit">
                                Complete Challenge
                            </x-app-button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Goal toggle functionality is now handled by goal-toggle.js
        // Modal functions are now global
        window.showCompleteModal = () => showModal('completeModal');
        window.hideCompleteModal = () => hideModal('completeModal');
        
        // Initialize modal listeners
        document.addEventListener('DOMContentLoaded', () => {
            initModalListeners('completeModal', hideCompleteModal);
        });
    </script>
</x-app-layout>
