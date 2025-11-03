@props(['challenge', 'showActions' => true, 'showTodaysGoals' => false, 'compact' => false])

@php
    $progress = $challenge->getProgressPercentage();
@endphp

<div class="bg-gradient-to-br from-white to-gray-50 overflow-hidden shadow-xl rounded-2xl border border-gray-200 hover:shadow-2xl transition-all duration-300 {{ $compact ? '' : 'transform hover:scale-[1.02]' }}">
    <div class="p-6">
        <!-- Header -->
        <div class="flex justify-between items-start mb-4">
            <div class="flex-1">
                <h4 class="{{ $compact ? 'text-lg' : 'text-xl' }} font-bold text-gray-900">{{ $challenge->name }}</h4>
                @if($challenge->description && !$compact)
                    <p class="text-gray-600 text-sm mt-1">{{ Str::limit($challenge->description, 100) }}</p>
                @endif
            </div>
            <div class="ml-4">
                @if($challenge->completed_at)
                    <span class="px-3 py-1 text-sm font-bold rounded-full shadow-md bg-gradient-to-r from-green-400 to-green-500 text-white">
                        ✓ Completed
                    </span>
                @elseif($challenge->started_at && $challenge->is_active)
                    <span class="px-3 py-1 text-sm font-bold rounded-full shadow-md bg-gradient-to-r from-blue-400 to-blue-500 text-white">
                        🏃 Active
                    </span>
                @elseif($challenge->started_at && !$challenge->is_active)
                    <span class="px-3 py-1 text-sm font-bold rounded-full shadow-md bg-gradient-to-r from-yellow-400 to-orange-500 text-white">
                        ⏸️ Paused
                    </span>
                @else
                    <span class="px-3 py-1 text-sm font-bold rounded-full shadow-md bg-gradient-to-r from-gray-400 to-gray-500 text-white">
                        📝 Draft
                    </span>
                @endif
            </div>
        </div>

        <!-- Progress Bar -->
        @if($challenge->started_at && !$challenge->completed_at)
            <div class="mb-4">
                <div class="flex justify-between text-sm text-gray-600 mb-2">
                    <span class="font-medium">Overall Progress</span>
                    <span class="font-bold">{{ number_format($progress, 1) }}% Complete</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-3 shadow-inner">
                    <div class="bg-gradient-to-r {{ $challenge->is_active ? 'from-blue-500 to-purple-500' : 'from-gray-400 to-gray-500' }} h-3 rounded-full shadow-sm transition-all duration-500" 
                         style="width: {{ $progress }}%"></div>
                </div>
                @if(!$challenge->is_active)
                    <p class="text-sm text-yellow-600 mt-2 flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zM7 8a1 1 0 012 0v4a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v4a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                        Challenge is currently paused
                    </p>
                @endif
            </div>
        @endif

        <!-- Completion Date Display -->
        @if($challenge->completed_at)
            <div class="mb-4 p-3 bg-green-50 rounded-lg border border-green-200">
                <div class="flex items-center space-x-2 text-green-700">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-sm font-medium">Completed on {{ $challenge->completed_at->format('M j, Y') }}</span>
                </div>
            </div>
        @endif

        <!-- Goals List -->
        @if(!$challenge->completed_at)
            <x-goal-list 
                :challenge="$challenge" 
                :goals="$challenge->goals" 
                :compact="$compact" 
                :show-todays-goals="$showTodaysGoals" />
        @endif
        
        <!-- Actions -->
        @if($showActions && !$challenge->completed_at && !$compact)
            <div class="flex justify-between items-center mt-6 pt-4 border-t border-gray-200">
                @if(!$challenge->started_at)
                    <!-- Not Started -->
                    <form method="POST" action="{{ route('challenges.start', $challenge) }}">
                        @csrf
                        <button type="submit" class="bg-green-100 hover:bg-green-200 text-green-800 px-3 py-1 rounded-lg text-sm font-medium transition-colors duration-200">
                            ▶️ Start
                        </button>
                    </form>
                @elseif($challenge->is_active)
                    <!-- Active -->
                    <div class="flex space-x-2">
                        <form method="POST" action="{{ route('challenges.pause', $challenge) }}">
                            @csrf
                            <button type="submit" class="bg-yellow-100 hover:bg-yellow-200 text-yellow-800 px-3 py-1 rounded-lg text-sm font-medium transition-colors duration-200">
                                ⏸️ Pause
                            </button>
                        </form>
                        <button onclick="showCompleteModal()" class="bg-blue-100 hover:bg-blue-200 text-blue-800 px-3 py-1 rounded-lg text-sm font-medium transition-colors duration-200">
                            ✅ Complete
                        </button>
                    </div>
                @else
                    <!-- Paused -->
                    <div class="flex space-x-2">
                        <form method="POST" action="{{ route('challenges.resume', $challenge) }}">
                            @csrf
                            <button type="submit" class="bg-green-100 hover:bg-green-200 text-green-800 px-3 py-1 rounded-lg text-sm font-medium transition-colors duration-200">
                                ▶️ Resume
                            </button>
                        </form>
                        <button onclick="showCompleteModal()" class="bg-blue-100 hover:bg-blue-200 text-blue-800 px-3 py-1 rounded-lg text-sm font-medium transition-colors duration-200">
                            ✅ Complete
                        </button>
                    </div>
                @endif
                
                <a href="{{ route('challenges.show', $challenge) }}" class="text-blue-600 hover:text-blue-800 font-medium text-sm">
                    View Details →
                </a>
            </div>
        @elseif($compact)
            <!-- Compact mode - only show view link -->
            <div class="flex justify-end mt-4 pt-3 border-t border-gray-200">
                <a href="{{ route('challenges.show', $challenge) }}" class="text-blue-600 hover:text-blue-800 font-medium text-sm">
                    View Details →
                </a>
            </div>
        @endif
    </div>
</div>