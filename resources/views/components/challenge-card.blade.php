@props(['challenge', 'showActions' => true, 'showTodaysGoals' => false, 'compact' => false])

@php
    $progress = $challenge->getProgressPercentage();
@endphp

<div class="card">
    <div class="p-6">
        <!-- Header -->
        <div class="flex justify-between items-start mb-4">
            <div class="flex-1">
                <h4 class="{{ $compact ? 'text-lg' : 'text-xl' }} font-bold text-gray-800 dark:text-gray-100 dark:text-gray-100">{{ $challenge->name }}</h4>
                @if($challenge->description && !$compact)
                    <p class="text-gray-600 text-sm mt-1">{{ Str::limit($challenge->description, 100) }}</p>
                @endif
            </div>
            <div class="ml-4">
                @if($challenge->completed_at)
                    <span class="badge-completed">✓ Completed</span>
                @elseif($challenge->started_at && $challenge->is_active)
                    <span class="badge-challenge-active">🏃 Active</span>
                @elseif($challenge->started_at && !$challenge->is_active)
                    <span class="badge-challenge-paused">⏸️ Paused</span>
                @else
                    <span class="badge-challenge-draft">📝 Draft</span>
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
                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-3 shadow-inner">
                    <div class="bg-gradient-to-r {{ $challenge->is_active ? 'from-blue-500 to-purple-500' : 'from-gray-400 to-gray-500' }} h-3 rounded-full shadow-sm transition-all duration-500" 
                         style="width: {{ $progress }}%"></div>
                </div>
                @if(!$challenge->is_active)
                    <p class="text-sm text-yellow-600 dark:text-yellow-400 mt-2 flex items-center">
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
            <div class="mb-4 p-3 bg-green-50 dark:bg-green-900/30 rounded-lg border border-green-200 dark:border-green-700">
                <div class="flex items-center space-x-2 text-green-700 dark:text-green-300">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-sm font-medium">Completed on {{ $challenge->completed_at->format('M j, Y') }}</span>
                </div>
            </div>
        @endif

        <!-- Goals List -->
        @if(!$challenge->completed_at)
            <x-goals-info-list :goals="$challenge->goals" />
        @endif
        
        <!-- Actions -->
        @if($showActions && !$challenge->completed_at && !$compact)
            <div class="flex justify-between items-center mt-6 pt-4 border-t border-gray-200 dark:border-gray-700">
                @if(!$challenge->started_at)
                    <!-- Not Started -->
                    <form method="POST" action="{{ route('challenges.start', $challenge) }}">
                        @csrf
                        <x-app-button variant="action-sm" type="submit">
                            ▶️ Start
                        </x-app-button>
                    </form>
                @elseif($challenge->is_active)
                    <!-- Active -->
                    <div class="flex space-x-2">
                        <form method="POST" action="{{ route('challenges.pause', $challenge) }}">
                            @csrf
                            <x-app-button variant="action-pause" type="submit">
                                ⏸️ Pause
                            </x-app-button>
                        </form>
                        <x-app-button variant="action-complete" type="button" onclick="showCompleteModal()">
                            ✅ Complete
                        </x-app-button>
                    </div>
                @else
                    <!-- Paused -->
                    <div class="flex space-x-2">
                        <form method="POST" action="{{ route('challenges.resume', $challenge) }}">
                            @csrf
                            <x-app-button variant="action-sm" type="submit">
                                ▶️ Resume
                            </x-app-button>
                        </form>
                        <x-app-button variant="action-complete" type="button" onclick="showCompleteModal()">
                            ✅ Complete
                        </x-app-button>
                    </div>
                @endif
                
                <a href="{{ route('challenges.show', $challenge) }}" class="text-blue-600 hover:text-blue-800 font-medium text-sm">
                    View Details →
                </a>
            </div>
        @elseif($compact)
            <!-- Compact mode - only show view link -->
            <div class="flex justify-end mt-4 pt-3 border-t border-gray-200 dark:border-gray-700">
                <a href="{{ route('challenges.show', $challenge) }}" class="text-blue-600 hover:text-blue-800 font-medium text-sm">
                    View Details →
                </a>
            </div>
        @endif
    </div>
</div>