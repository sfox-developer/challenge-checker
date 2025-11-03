<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.dashboard') }}" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"></path>
                    </svg>
                </a>
                <div class="bg-gradient-to-r from-blue-500 to-purple-500 p-2 rounded-lg">
                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="font-bold text-2xl text-gray-800 leading-tight">{{ $user->name }}</h2>
                    <p class="text-sm text-gray-600">{{ $user->email }}</p>
                </div>
            </div>
            @if($user->is_admin)
                <span class="px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                    Admin User
                </span>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <!-- User Stats -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">User Statistics</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div class="text-center p-4 bg-blue-50 rounded-lg">
                            <div class="text-2xl font-bold text-blue-600">{{ $user->challenges->count() }}</div>
                            <div class="text-sm text-gray-600">Total Challenges</div>
                        </div>
                        <div class="text-center p-4 bg-orange-50 rounded-lg">
                            <div class="text-2xl font-bold text-orange-600">{{ $user->challenges->where('started_at', '!=', null)->where('completed_at', null)->where('is_active', true)->count() }}</div>
                            <div class="text-sm text-gray-600">Active</div>
                        </div>
                        <div class="text-center p-4 bg-green-50 rounded-lg">
                            <div class="text-2xl font-bold text-green-600">{{ $user->challenges->where('completed_at', '!=', null)->count() }}</div>
                            <div class="text-sm text-gray-600">Completed</div>
                        </div>
                        <div class="text-center p-4 bg-purple-50 rounded-lg">
                            <div class="text-2xl font-bold text-purple-600">{{ $user->challenges->where('started_at', '!=', null)->where('is_active', false)->where('completed_at', null)->count() }}</div>
                            <div class="text-sm text-gray-600">Paused</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Challenges List -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Challenges</h3>
                    
                    @if($user->challenges->isNotEmpty())
                        <div class="space-y-4">
                            @foreach($user->challenges as $challenge)
                                <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition-colors">
                                    <div class="flex justify-between items-start mb-3">
                                        <div class="flex-1">
                                            <h4 class="font-semibold text-lg text-gray-900">{{ $challenge->name }}</h4>
                                            @if($challenge->description)
                                                <p class="text-sm text-gray-600 mt-1">{{ $challenge->description }}</p>
                                            @endif
                                        </div>
                                        @if($challenge->completed_at)
                                            <span class="px-3 py-1 text-xs font-bold rounded-full bg-green-100 text-green-800">
                                                ✓ Completed
                                            </span>
                                        @elseif($challenge->started_at && $challenge->is_active)
                                            <span class="px-3 py-1 text-xs font-bold rounded-full bg-orange-100 text-orange-800">
                                                🏃 Active
                                            </span>
                                        @elseif($challenge->started_at && !$challenge->is_active)
                                            <span class="px-3 py-1 text-xs font-bold rounded-full bg-purple-100 text-purple-800">
                                                ⏸️ Paused
                                            </span>
                                        @else
                                            <span class="px-3 py-1 text-xs font-bold rounded-full bg-gray-100 text-gray-800">
                                                📝 Draft
                                            </span>
                                        @endif
                                    </div>

                                    <!-- Challenge Info -->
                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm mb-4">
                                        <div>
                                            <span class="text-gray-500">Duration:</span>
                                            <span class="font-semibold ml-1">{{ $challenge->days_duration }} days</span>
                                        </div>
                                        <div>
                                            <span class="text-gray-500">Created:</span>
                                            <span class="font-semibold ml-1">{{ $challenge->created_at->format('M j, Y') }}</span>
                                        </div>
                                        <div>
                                            <span class="text-gray-500">Started:</span>
                                            <span class="font-semibold ml-1">{{ $challenge->started_at ? $challenge->started_at->format('M j, Y') : '-' }}</span>
                                        </div>
                                        <div>
                                            <span class="text-gray-500">Completed:</span>
                                            <span class="font-semibold ml-1">{{ $challenge->completed_at ? $challenge->completed_at->format('M j, Y') : '-' }}</span>
                                        </div>
                                    </div>

                                    <!-- Progress Bar (for active challenges) -->
                                    @if($challenge->is_active && !$challenge->completed_at)
                                        <div class="mb-4">
                                            <div class="flex justify-between text-sm mb-2">
                                                <span class="text-gray-600">Progress</span>
                                                <span class="font-semibold text-blue-600">{{ number_format($challenge->getProgressPercentage(), 1) }}%</span>
                                            </div>
                                            <div class="w-full bg-gray-200 rounded-full h-2">
                                                <div class="bg-gradient-to-r from-blue-500 to-purple-500 h-2 rounded-full transition-all duration-500" style="width: {{ $challenge->getProgressPercentage() }}%"></div>
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Goals -->
                                    @if($challenge->goals->isNotEmpty())
                                        <div>
                                            <h5 class="font-medium text-gray-900 mb-2">Goals ({{ $challenge->goals->count() }})</h5>
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                                @foreach($challenge->goals as $goal)
                                                    <div class="bg-gray-50 p-3 rounded-lg">
                                                        <div class="flex items-center justify-between mb-2">
                                                            <span class="font-medium text-sm">{{ $goal->name }}</span>
                                                            @if($challenge->started_at)
                                                                @php
                                                                    $isCompleted = $goal->isCompletedForDate(today()->toDateString(), $user->id);
                                                                @endphp
                                                                <span class="text-xs px-2 py-1 rounded-full {{ $isCompleted ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-600' }}">
                                                                    {{ $isCompleted ? 'Done Today' : 'Pending' }}
                                                                </span>
                                                            @endif
                                                        </div>
                                                        @if($goal->dailyProgress->isNotEmpty())
                                                            <div class="text-xs text-gray-500">
                                                                Total completed days: {{ $goal->dailyProgress->where('completed', true)->count() }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <div class="bg-gray-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <h4 class="text-lg font-semibold text-gray-900 mb-2">No Challenges</h4>
                            <p class="text-gray-600">This user hasn't created any challenges yet.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>