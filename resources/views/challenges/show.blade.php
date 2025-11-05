<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-3">
            <div class="bg-gradient-to-r from-blue-500 to-purple-500 p-2 rounded-lg">
                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
            </div>
            <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                {{ $challenge->name }}
            </h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Navigation and Actions -->
            <div class="mb-6 flex justify-between items-center">
                <!-- Back Button -->
                <div>
                    <a href="{{ session('challenge_back_url', route('challenges.index')) }}" class="inline-flex items-center space-x-2 text-gray-600 hover:text-gray-800 transition-colors duration-200">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="font-medium">{{ session('challenge_back_url') ? (str_contains(session('challenge_back_url'), 'challenges') && !str_contains(session('challenge_back_url'), 'challenges/') ? 'Back to Challenges' : 'Back') : 'Back to Challenges' }}</span>
                    </a>
                </div>

                <!-- Action Buttons - Only for owner -->
                @php
                    $isOwner = auth()->id() === $challenge->user_id;
                @endphp
                
                @if($isOwner)
                <div class="flex flex-wrap gap-3">
                    @if(!$challenge->started_at)
                        <!-- Not Started -->
                        <form method="POST" action="{{ route('challenges.start', $challenge) }}">
                            @csrf
                            <button type="submit" class="bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-bold py-2 px-4 rounded-lg shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200 flex items-center space-x-2">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"></path>
                                </svg>
                                <span>Start Challenge</span>
                            </button>
                        </form>
                    @elseif(!$challenge->completed_at)
                        <!-- Started but not completed -->
                        @if($challenge->is_active)
                            <!-- Active - show pause and complete buttons -->
                            <form method="POST" action="{{ route('challenges.pause', $challenge) }}">
                                @csrf
                                <button type="submit" class="bg-gradient-to-r from-purple-500 to-indigo-500 hover:from-purple-600 hover:to-indigo-600 text-white font-bold py-2 px-4 rounded-lg shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200 flex items-center space-x-2">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zM7 8a1 1 0 012 0v4a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v4a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span>Pause</span>
                                </button>
                            </form>
                            <button onclick="showCompleteModal()" class="bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-bold py-2 px-4 rounded-lg shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200 flex items-center space-x-2">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                <span>Mark Complete</span>
                            </button>
                        @else
                            <!-- Paused - show resume and complete buttons -->
                            <form method="POST" action="{{ route('challenges.resume', $challenge) }}">
                                @csrf
                                <button type="submit" class="bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-bold py-2 px-4 rounded-lg shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200 flex items-center space-x-2">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span>Resume</span>
                                </button>
                            </form>
                            <button onclick="showCompleteModal()" class="bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-bold py-2 px-4 rounded-lg shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200 flex items-center space-x-2">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                <span>Mark Complete</span>
                            </button>
                        @endif
                    @endif

                    @if(!$challenge->is_active && !$challenge->completed_at)
                        <a href="{{ route('challenges.edit', $challenge) }}?back={{ urlencode(request()->url()) }}" class="bg-gradient-to-r from-purple-500 to-purple-600 hover:from-purple-600 hover:to-purple-700 text-white font-bold py-2 px-4 rounded-lg shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200 flex items-center space-x-2">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                            </svg>
                            <span>Edit</span>
                        </a>
                    @endif
                </div>
                @endif
            </div>

            <!-- Success Message -->
            @if(session('success'))
                <div class="mb-6 bg-gradient-to-r from-green-50 to-green-100 border border-green-200 rounded-xl p-4 shadow-sm">
                    <div class="flex items-center space-x-3">
                        <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <p class="text-green-800 font-medium">{{ session('success') }}</p>
                    </div>
                </div>
            @endif
            <!-- Challenge Overview Card -->
            <div class="bg-gradient-to-br from-white to-gray-50 overflow-hidden shadow-xl rounded-2xl border border-gray-200 mb-8">
                <div class="p-8">
                    <div class="flex justify-between items-start mb-6">
                        <div class="flex-1">
                            <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $challenge->name }}</h1>
                            @if($challenge->description)
                                <p class="text-lg text-gray-700 leading-relaxed">{{ $challenge->description }}</p>
                            @endif
                        </div>
                        <div class="ml-6">
                            @if($challenge->completed_at)
                                <span class="bg-gradient-to-r from-green-400 to-green-500 text-white text-lg font-bold px-6 py-3 rounded-full shadow-md">
                                    ✓ Completed
                                </span>
                            @elseif($challenge->started_at && $challenge->is_active)
                                <span class="bg-gradient-to-r from-blue-400 to-blue-500 text-white text-lg font-bold px-6 py-3 rounded-full shadow-md">
                                    🏃 In Progress
                                </span>
                            @elseif($challenge->started_at && !$challenge->is_active)
                                <span class="bg-gradient-to-r from-yellow-400 to-orange-500 text-white text-lg font-bold px-6 py-3 rounded-full shadow-md">
                                    ⏸️ Paused
                                </span>
                            @else
                                <span class="bg-gradient-to-r from-gray-400 to-gray-500 text-white text-lg font-bold px-6 py-3 rounded-full shadow-md">
                                    📝 Ready to Start
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Challenge Stats -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        <div class="bg-gradient-to-r from-blue-50 to-purple-50 rounded-xl p-6 text-center">
                            <div class="text-3xl font-bold text-blue-600 mb-2">{{ $challenge->days_duration }}</div>
                            <div class="text-gray-700 font-medium">Total Days</div>
                        </div>
                        <div class="bg-gradient-to-r from-green-50 to-teal-50 rounded-xl p-6 text-center">
                            <div class="text-3xl font-bold text-green-600 mb-2">{{ $challenge->goals->count() }}</div>
                            <div class="text-gray-700 font-medium">Daily Goals</div>
                        </div>
                        @if($challenge->completed_at)
                            <div class="bg-gradient-to-r from-green-50 to-emerald-50 rounded-xl p-6 text-center">
                                <div class="text-3xl font-bold text-green-600 mb-2">{{ number_format($challenge->getProgressPercentage(), 1) }}%</div>
                                <div class="text-gray-700 font-medium">Completed</div>
                            </div>
                        @elseif($challenge->started_at && $challenge->is_active)
                            <div class="bg-gradient-to-r from-purple-50 to-pink-50 rounded-xl p-6 text-center">
                                <div class="text-3xl font-bold text-purple-600 mb-2">{{ number_format($challenge->getProgressPercentage(), 1) }}%</div>
                                <div class="text-gray-700 font-medium">Progress</div>
                            </div>
                        @elseif($challenge->started_at && !$challenge->is_active && !$challenge->completed_at)
                            <div class="bg-gradient-to-r from-yellow-50 to-orange-50 rounded-xl p-6 text-center">
                                <div class="text-3xl font-bold text-yellow-600 mb-2">Paused</div>
                                <div class="text-gray-700 font-medium">Status</div>
                            </div>
                        @else
                            <div class="bg-gradient-to-r from-gray-50 to-blue-50 rounded-xl p-6 text-center">
                                <div class="text-3xl font-bold text-blue-600 mb-2">Ready</div>
                                <div class="text-gray-700 font-medium">To Start</div>
                            </div>
                        @endif
                    </div>

                    @if($challenge->started_at && !$challenge->completed_at)
                        <!-- Progress Bar -->
                        <div class="mb-8">
                            <div class="flex justify-between text-sm text-gray-600 mb-3">
                                <span class="font-medium">Overall Progress</span>
                                <span class="font-bold">{{ number_format($challenge->getProgressPercentage(), 1) }}% Complete</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-4 shadow-inner">
                                <div class="bg-gradient-to-r {{ $challenge->is_active ? 'from-blue-500 to-purple-500' : 'from-gray-400 to-gray-500' }} h-4 rounded-full shadow-sm transition-all duration-500" 
                                     style="width: {{ $challenge->getProgressPercentage() }}%"></div>
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

                    <!-- Challenge Completion Results -->
                    @if($challenge->completed_at)
                        @php
                            $progress = $challenge->getProgressPercentage();
                            $completedDays = $challenge->dailyProgress()->whereNotNull('completed_at')->count();
                            $totalDays = $challenge->goals->count() * $challenge->days_duration;
                            $completedOn = $challenge->completed_at->format('M j, Y \a\t g:i A');
                        @endphp
                        
                        <div class="mb-8">
                            @if($progress >= 90)
                                <!-- Outstanding Achievement (90%+) -->
                                <div class="bg-gradient-to-br from-green-50 via-emerald-50 to-green-100 border-2 border-green-300 rounded-2xl p-8 shadow-lg">
                                    <div class="text-center">
                                        <div class="mx-auto w-20 h-20 bg-gradient-to-br from-green-500 to-emerald-600 rounded-full flex items-center justify-center mb-6 shadow-xl">
                                            <svg class="w-12 h-12 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                        <h3 class="text-3xl font-bold text-green-800 mb-3">🏆 Outstanding Achievement!</h3>
                                        <p class="text-xl text-green-700 mb-6 font-semibold">Challenge Mastered with Excellence</p>
                                        <div class="bg-white rounded-xl p-6 shadow-inner border border-green-200">
                                            <div class="grid grid-cols-2 gap-6">
                                                <div class="text-center">
                                                    <div class="text-4xl font-bold text-green-600">{{ number_format($progress, 1) }}%</div>
                                                    <div class="text-sm text-green-600 font-medium">Achievement Rate</div>
                                                </div>
                                                <div class="text-center">
                                                    <div class="text-4xl font-bold text-green-600">{{ $completedDays }}/{{ $totalDays }}</div>
                                                    <div class="text-sm text-green-600 font-medium">Days Completed</div>
                                                </div>
                                            </div>
                                        </div>
                                        <p class="text-green-700 mt-4 font-medium">You've demonstrated exceptional commitment and consistency. This level of dedication sets you apart! 🌟</p>
                                        <p class="text-sm text-green-600 mt-2">Completed on {{ $completedOn }}</p>
                                    </div>
                                </div>
                            @elseif($progress >= 75)
                                <!-- Great Success (75-89%) -->
                                <div class="bg-gradient-to-br from-blue-50 via-green-50 to-blue-100 border-2 border-blue-300 rounded-2xl p-8 shadow-lg">
                                    <div class="text-center">
                                        <div class="mx-auto w-20 h-20 bg-gradient-to-br from-blue-500 to-green-500 rounded-full flex items-center justify-center mb-6 shadow-xl">
                                            <svg class="w-12 h-12 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                        <h3 class="text-3xl font-bold text-blue-800 mb-3">🎉 Great Success!</h3>
                                        <p class="text-xl text-blue-700 mb-6 font-semibold">Challenge Completed Successfully</p>
                                        <div class="bg-white rounded-xl p-6 shadow-inner border border-blue-200">
                                            <div class="grid grid-cols-2 gap-6">
                                                <div class="text-center">
                                                    <div class="text-4xl font-bold text-blue-600">{{ number_format($progress, 1) }}%</div>
                                                    <div class="text-sm text-blue-600 font-medium">Achievement Rate</div>
                                                </div>
                                                <div class="text-center">
                                                    <div class="text-4xl font-bold text-blue-600">{{ $completedDays }}/{{ $totalDays }}</div>
                                                    <div class="text-sm text-blue-600 font-medium">Days Completed</div>
                                                </div>
                                            </div>
                                        </div>
                                        <p class="text-blue-700 mt-4 font-medium">You showed strong commitment and achieved excellent results. Well done! 💪</p>
                                        <p class="text-sm text-blue-600 mt-2">Completed on {{ $completedOn }}</p>
                                    </div>
                                </div>
                            @elseif($progress >= 50)
                                <!-- Solid Progress (50-74%) -->
                                <div class="bg-gradient-to-br from-yellow-50 via-orange-50 to-yellow-100 border-2 border-yellow-300 rounded-2xl p-8 shadow-lg">
                                    <div class="text-center">
                                        <div class="mx-auto w-20 h-20 bg-gradient-to-br from-yellow-500 to-orange-500 rounded-full flex items-center justify-center mb-6 shadow-xl">
                                            <svg class="w-12 h-12 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                        <h3 class="text-3xl font-bold text-yellow-800 mb-3">👍 Good Effort!</h3>
                                        <p class="text-xl text-yellow-700 mb-6 font-semibold">Solid Progress Made</p>
                                        <div class="bg-white rounded-xl p-6 shadow-inner border border-yellow-200">
                                            <div class="grid grid-cols-2 gap-6">
                                                <div class="text-center">
                                                    <div class="text-4xl font-bold text-yellow-600">{{ number_format($progress, 1) }}%</div>
                                                    <div class="text-sm text-yellow-600 font-medium">Achievement Rate</div>
                                                </div>
                                                <div class="text-center">
                                                    <div class="text-4xl font-bold text-yellow-600">{{ $completedDays }}/{{ $totalDays }}</div>
                                                    <div class="text-sm text-yellow-600 font-medium">Days Completed</div>
                                                </div>
                                            </div>
                                        </div>
                                        <p class="text-yellow-700 mt-4 font-medium">You made meaningful progress! Consider what worked well for your next challenge. 📈</p>
                                        <p class="text-sm text-yellow-600 mt-2">Completed on {{ $completedOn }}</p>
                                    </div>
                                </div>
                            @elseif($progress >= 25)
                                <!-- Room for Improvement (25-49%) -->
                                <div class="bg-gradient-to-br from-orange-50 via-red-50 to-orange-100 border-2 border-orange-300 rounded-2xl p-8 shadow-lg">
                                    <div class="text-center">
                                        <div class="mx-auto w-20 h-20 bg-gradient-to-br from-orange-500 to-red-500 rounded-full flex items-center justify-center mb-6 shadow-xl">
                                            <svg class="w-12 h-12 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                        <h3 class="text-3xl font-bold text-orange-800 mb-3">💪 Room for Growth</h3>
                                        <p class="text-xl text-orange-700 mb-6 font-semibold">Challenge Completed with Learning Opportunities</p>
                                        <div class="bg-white rounded-xl p-6 shadow-inner border border-orange-200">
                                            <div class="grid grid-cols-2 gap-6">
                                                <div class="text-center">
                                                    <div class="text-4xl font-bold text-orange-600">{{ number_format($progress, 1) }}%</div>
                                                    <div class="text-sm text-orange-600 font-medium">Achievement Rate</div>
                                                </div>
                                                <div class="text-center">
                                                    <div class="text-4xl font-bold text-orange-600">{{ $completedDays }}/{{ $totalDays }}</div>
                                                    <div class="text-sm text-orange-600 font-medium">Days Completed</div>
                                                </div>
                                            </div>
                                        </div>
                                        <p class="text-orange-700 mt-4 font-medium">Every challenge teaches us something. Use these insights to build stronger habits next time! 🎯</p>
                                        <p class="text-sm text-orange-600 mt-2">Completed on {{ $completedOn }}</p>
                                    </div>
                                </div>
                            @else
                                <!-- Early End (0-24%) -->
                                <div class="bg-gradient-to-br from-red-50 via-pink-50 to-red-100 border-2 border-red-300 rounded-2xl p-8 shadow-lg">
                                    <div class="text-center">
                                        <div class="mx-auto w-20 h-20 bg-gradient-to-br from-red-500 to-pink-500 rounded-full flex items-center justify-center mb-6 shadow-xl">
                                            <svg class="w-12 h-12 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M10 2L3 7v11a1 1 0 001 1h12a1 1 0 001-1V7l-7-5zM8 16H6v-2h2v2zm0-4H6v-2h2v2zm0-4H6V6h2v2zm6 8h-2v-2h2v2zm0-4h-2v-2h2v2zm0-4h-2V6h2v2z"></path>
                                            </svg>
                                        </div>
                                        <h3 class="text-3xl font-bold text-red-800 mb-3">🌱 New Beginning</h3>
                                        <p class="text-xl text-red-700 mb-6 font-semibold">Challenge Ended Early - But That's Part of Learning</p>
                                        <div class="bg-white rounded-xl p-6 shadow-inner border border-red-200">
                                            <div class="grid grid-cols-2 gap-6">
                                                <div class="text-center">
                                                    <div class="text-4xl font-bold text-red-600">{{ number_format($progress, 1) }}%</div>
                                                    <div class="text-sm text-red-600 font-medium">Achievement Rate</div>
                                                </div>
                                                <div class="text-center">
                                                    <div class="text-4xl font-bold text-red-600">{{ $completedDays }}/{{ $totalDays }}</div>
                                                    <div class="text-sm text-red-600 font-medium">Days Completed</div>
                                                </div>
                                            </div>
                                        </div>
                                        <p class="text-red-700 mt-4 font-medium">Starting is the hardest part - and you did that! Each attempt builds resilience for future success. 🌟</p>
                                        <p class="text-sm text-red-600 mt-2">Ended on {{ $completedOn }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif

                    <!-- Daily Goals Section -->
                    @if($challenge->goals->isNotEmpty() && !$challenge->completed_at)
                        <div class="pt-6 border-t border-gray-200">
                            <x-goal-list 
                                :challenge="$challenge" 
                                :goals="$challenge->goals" 
                                :compact="false" 
                                :show-todays-goals="true"
                                :is-owner="$isOwner" />
                        </div>
                    @endif

                    <!-- Daily Progress Statistics -->
                    @if($challenge->started_at)
                        <div class="pt-6 border-t border-gray-200">
                            <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center space-x-3">
                                <svg class="w-5 h-5 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11.707 4.707a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <span>Daily Progress History</span>
                            </h3>

                            @php
                                $startDate = $challenge->started_at->startOfDay();
                                $endDate = $challenge->completed_at ? $challenge->completed_at->startOfDay() : now()->startOfDay();
                                $daysPassed = $startDate->diffInDays($endDate) + 1;
                                
                                // Limit to show only up to 30 days to prevent overwhelming display
                                $displayDays = min($daysPassed, 30);
                                $showingPartial = $daysPassed > 30;
                            @endphp

                            <div class="bg-gray-50 rounded-lg p-4 mb-4">
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-center">
                                    <div>
                                        <div class="text-2xl font-bold text-blue-600">{{ $daysPassed }}</div>
                                        <div class="text-sm text-gray-600">{{ $daysPassed === 1 ? 'Day' : 'Days' }} Active</div>
                                    </div>
                                    <div>
                                        <div class="text-2xl font-bold text-green-600">
                                            @php
                                                $perfectDays = 0;
                                                for ($i = 0; $i < $daysPassed; $i++) {
                                                    $checkDate = $startDate->copy()->addDays($i);
                                                    $completedGoalsForDay = $challenge->dailyProgress()
                                                        ->where('user_id', $challenge->user_id)
                                                        ->where('date', $checkDate->toDateString())
                                                        ->whereNotNull('completed_at')
                                                        ->count();
                                                    
                                                    if ($completedGoalsForDay === $challenge->goals->count()) {
                                                        $perfectDays++;
                                                    }
                                                }
                                                echo $perfectDays;
                                            @endphp
                                        </div>
                                        <div class="text-sm text-gray-600">Perfect Days</div>
                                    </div>
                                    <div>
                                        <div class="text-2xl font-bold text-purple-600">
                                            {{ number_format(($perfectDays / max($daysPassed, 1)) * 100, 1) }}%
                                        </div>
                                        <div class="text-sm text-gray-600">Success Rate</div>
                                    </div>
                                </div>
                            </div>

                            @if($showingPartial)
                                <p class="text-sm text-gray-600 mb-4 text-center">
                                    <em>Showing last 30 days ({{ $daysPassed - 30 }} earlier days not displayed)</em>
                                </p>
                            @endif

                            <div class="grid grid-cols-7 gap-2 mb-4">
                                @for ($i = $showingPartial ? ($daysPassed - 30) : 0; $i < $daysPassed; $i++)
                                    @php
                                        $currentDate = $startDate->copy()->addDays($i);
                                        $isToday = $currentDate->isToday();
                                        $dayName = $currentDate->format('D');
                                        $dayNumber = $currentDate->format('j');
                                        $monthName = $currentDate->format('M');
                                        
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
                                            $bgColor = 'bg-green-500 text-white';
                                        } elseif ($completionPercentage > 0) {
                                            $bgColor = 'bg-yellow-400 text-gray-800';
                                        } else {
                                            $bgColor = 'bg-gray-200 text-gray-600';
                                        }
                                        
                                        if ($isToday) {
                                            $bgColor .= ' ring-2 ring-blue-500';
                                        }
                                    @endphp
                                    
                                    <div class="text-center">
                                        <div class="text-xs text-gray-600 mb-1">{{ $dayName }}</div>
                                        <div class="w-8 h-8 rounded-full {{ $bgColor }} flex items-center justify-center text-xs font-semibold mx-auto relative" title="{{ $currentDate->format('M j, Y') }}: {{ $completedGoalsForDay }}/{{ $totalGoals }} goals completed">
                                            {{ $dayNumber }}
                                            @if($isToday)
                                                <div class="absolute -bottom-1 w-1 h-1 bg-blue-500 rounded-full"></div>
                                            @endif
                                        </div>
                                        <div class="text-xs text-gray-500 mt-1">{{ $completedGoalsForDay }}/{{ $totalGoals }}</div>
                                    </div>
                                @endfor
                            </div>

                            <div class="flex items-center justify-center space-x-6 text-xs text-gray-600">
                                <div class="flex items-center space-x-2">
                                    <div class="w-3 h-3 rounded-full bg-green-500"></div>
                                    <span>All goals completed</span>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <div class="w-3 h-3 rounded-full bg-yellow-400"></div>
                                    <span>Some goals completed</span>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <div class="w-3 h-3 rounded-full bg-gray-200"></div>
                                    <span>No goals completed</span>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>


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
                <h3 class="text-lg leading-6 font-medium text-gray-900 mt-4">Complete Challenge?</h3>
                <div class="mt-2 px-7 py-3">
                    <p class="text-sm text-gray-500">
                        Are you sure you want to mark this challenge as complete? This action cannot be undone and will stop tracking your daily progress.
                    </p>
                </div>
                <div class="items-center px-4 py-3">
                    <div class="flex space-x-3">
                        <button onclick="hideCompleteModal()" class="px-4 py-2 bg-gray-300 text-gray-800 text-base font-medium rounded-md w-full shadow-sm hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-300">
                            Cancel
                        </button>
                        <form method="POST" action="{{ route('challenges.complete', $challenge) }}" class="w-full">
                            @csrf
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                Complete Challenge
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Goal toggle functionality is now handled by goal-toggle.js

        function showCompleteModal() {
            document.getElementById('completeModal').classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }

        function hideCompleteModal() {
            document.getElementById('completeModal').classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }

        // Close modal when clicking outside
        document.getElementById('completeModal').addEventListener('click', function(e) {
            if (e.target === this) {
                hideCompleteModal();
            }
        });

        // Close modal on Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                hideCompleteModal();
            }
        });
    </script>
</x-app-layout>