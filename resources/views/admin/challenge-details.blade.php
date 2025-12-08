<x-app-layout>
    <x-slot name="header">
        <x-page-header :title="$challenge->name">
            <x-slot name="icon">
                <svg class="w-6 h-6 text-slate-700 dark:text-slate-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
            </x-slot>
            <x-slot name="action">
                <x-app-button variant="secondary" href="{{ route('admin.user', $challenge->user) }}">
                    <x-slot name="icon">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"/>
                        </svg>
                    </x-slot>
                    Back to User
                </x-app-button>
            </x-slot>
        </x-page-header>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Owner Information -->
            <div class="card">
                <h3 class="h3 mb-4">Challenge Owner</h3>
                <div class="flex items-center space-x-4">
                    <img src="{{ $challenge->user->getAvatarUrl() }}" alt="{{ $challenge->user->name }}" 
                         class="h-12 w-12 rounded-full ring-2 ring-white dark:ring-gray-700 shadow">
                    <div>
                        <a href="{{ route('admin.user', $challenge->user) }}" 
                           class="text-lg font-semibold text-slate-700 dark:text-slate-400 hover:underline">
                            {{ $challenge->user->name }}
                        </a>
                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ $challenge->user->email }}</p>
                    </div>
                </div>
            </div>

            <!-- Challenge Status & Metadata -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Status Card -->
                <div class="card">
                    <h3 class="h3 mb-4">Status</h3>
                    <div class="space-y-3">
                        <div>
                            <span class="text-sm text-gray-600 dark:text-gray-400">Current Status:</span>
                            <div class="mt-1">
                                @if($challenge->isArchived())
                                    <span class="badge-challenge-archived">📁 Archived</span>
                                @elseif($challenge->completed_at)
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
                        
                        <div>
                            <span class="text-sm text-gray-600 dark:text-gray-400">Visibility:</span>
                            <div class="mt-1">
                                @if($challenge->is_public)
                                    <span class="badge-info">🌐 Public</span>
                                @else
                                    <span class="badge-draft">🔒 Private</span>
                                @endif
                            </div>
                        </div>

                        @if($challenge->started_at && $challenge->is_active && !$challenge->completed_at)
                            <div class="pt-3 border-t border-gray-200 dark:border-gray-700">
                                <span class="text-sm text-gray-600 dark:text-gray-400 mb-2 block">Progress</span>
                                <div class="flex items-center justify-between text-sm mb-2">
                                    <span class="text-gray-700 dark:text-gray-300">{{ number_format($challenge->getProgressPercentage(), 1) }}%</span>
                                    <span class="text-gray-500 dark:text-gray-400">{{ $challenge->getCurrentDay() }} / {{ $challenge->days_duration }} days</span>
                                </div>
                                <div class="progress-container">
                                    <div class="progress-bar bg-slate-700 dark:bg-slate-600" 
                                         style="width: {{ $challenge->getProgressPercentage() }}%"></div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Metadata Card -->
                <div class="card">
                    <h3 class="h3 mb-4">Details</h3>
                    <div class="space-y-3">
                        <div>
                            <span class="text-sm text-gray-600 dark:text-gray-400">Duration:</span>
                            <p class="text-gray-900 dark:text-gray-100 font-medium">{{ $challenge->days_duration }} days</p>
                        </div>
                        <div>
                            <span class="text-sm text-gray-600 dark:text-gray-400">Created:</span>
                            <p class="text-gray-900 dark:text-gray-100 font-medium">{{ $challenge->created_at->format('F j, Y') }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $challenge->created_at->diffForHumans() }}</p>
                        </div>
                        @if($challenge->started_at)
                            <div>
                                <span class="text-sm text-gray-600 dark:text-gray-400">Started:</span>
                                <p class="text-gray-900 dark:text-gray-100 font-medium">{{ $challenge->started_at->format('F j, Y') }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ $challenge->started_at->diffForHumans() }}</p>
                            </div>
                        @endif
                        @if($challenge->completed_at)
                            <div>
                                <span class="text-sm text-gray-600 dark:text-gray-400">Completed:</span>
                                <p class="text-gray-900 dark:text-gray-100 font-medium">{{ $challenge->completed_at->format('F j, Y') }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ $challenge->completed_at->diffForHumans() }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Description -->
            @if($challenge->description)
                <div class="card">
                    <h3 class="h3 mb-3">Description</h3>
                    <p class="text-gray-700 dark:text-gray-300 whitespace-pre-wrap">{{ $challenge->description }}</p>
                </div>
            @endif

            <!-- Goals -->
            @if($challenge->goals->isNotEmpty())
                <div class="card">
                    <h3 class="h3 mb-4">
                        Goals ({{ $challenge->goals->count() }})
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($challenge->goals as $goal)
                            <div class="bg-gray-50 dark:bg-gray-800 p-4 rounded-lg border border-gray-200 dark:border-gray-700">
                                <div class="flex items-start justify-between mb-3">
                                    <div class="flex-1">
                                        <h4 class="font-semibold text-gray-900 dark:text-gray-100">{{ $goal->name }}</h4>
                                        @if($goal->description)
                                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ $goal->description }}</p>
                                        @endif
                                    </div>
                                    @if($challenge->started_at)
                                        @php
                                            $isCompleted = $goal->isCompletedForDate(today()->toDateString(), $challenge->user_id);
                                        @endphp
                                        <span class="text-xs px-2 py-1 rounded-full shrink-0 ml-2 {{ $isCompleted ? 'bg-green-100 dark:bg-green-900/20 text-green-800 dark:text-green-400' : 'bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400' }}">
                                            {{ $isCompleted ? 'Done Today' : 'Pending' }}
                                        </span>
                                    @endif
                                </div>

                                @if($goal->dailyProgress->isNotEmpty())
                                    <div class="mt-3 pt-3 border-t border-gray-200 dark:border-gray-700">
                                        <div class="flex items-center justify-between text-sm">
                                            <span class="text-gray-600 dark:text-gray-400">Total Progress:</span>
                                            <span class="font-semibold text-gray-900 dark:text-gray-100">
                                                {{ $goal->dailyProgress->where('completed', true)->count() }} / {{ $goal->dailyProgress->count() }} days
                                            </span>
                                        </div>
                                        <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-1.5 mt-2">
                                            @php
                                                $progressPercentage = $goal->dailyProgress->count() > 0 
                                                    ? ($goal->dailyProgress->where('completed', true)->count() / $goal->dailyProgress->count() * 100) 
                                                    : 0;
                                            @endphp
                                            <div class="bg-slate-600 h-1.5 rounded-full" style="width: {{ $progressPercentage }}%"></div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="card">
                    <div class="empty-state">
                        <div class="empty-state-icon">
                            <svg class="w-8 h-8 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <h4 class="h3 mb-2">No Goals</h4>
                        <p class="text-gray-600 dark:text-gray-400">This challenge doesn't have any goals yet.</p>
                    </div>
                </div>
            @endif

            <!-- Activity Statistics -->
            @if($challenge->started_at)
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <x-stat-card 
                        label="Current Day" 
                        :value="$challenge->getCurrentDay()" 
                        <x-slot name="icon">
                            <svg class="w-5 h-5 md:w-6 md:h-6 text-slate-700 dark:text-slate-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                            </svg>
                        </x-slot>
                    </x-stat-card>

                    <x-stat-card 
                        label="Completed Tasks" 
                        :value="$challenge->goals->sum(fn($goal) => $goal->dailyProgress->where('completed', true)->count())" 
                        <x-slot name="icon">
                            <svg class="w-5 h-5 md:w-6 md:h-6 text-slate-700 dark:text-slate-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </x-slot>
                    </x-stat-card>

                    <x-stat-card 
                        label="Total Days" 
                        :value="$challenge->days_duration" 
                        <x-slot name="icon">
                            <svg class="w-5 h-5 md:w-6 md:h-6 text-slate-700 dark:text-slate-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                            </svg>
                        </x-slot>
                    </x-stat-card>

                    <x-stat-card 
                        label="Goals" 
                        :value="$challenge->goals->count()" 
                        <x-slot name="icon">
                            <svg class="w-5 h-5 md:w-6 md:h-6 text-slate-700 dark:text-slate-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                                <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/>
                            </svg>
                        </x-slot>
                    </x-stat-card>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
