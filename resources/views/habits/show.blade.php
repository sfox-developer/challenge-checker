<x-app-layout>
    <x-slot name="header">
        <x-page-header title="{{ $habit->goal->icon }} {{ $habit->goal_name }}" gradient="from-teal-500 to-cyan-500">
            <x-slot name="icon">
                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                    <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/>
                </svg>
            </x-slot>
            <x-slot name="action">
                <div class="flex space-x-2">
                    <x-app-button variant="secondary" href="{{ route('habits.edit', $habit) }}">
                        <x-slot name="icon">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                            </svg>
                        </x-slot>
                        Edit
                    </x-app-button>
                    <x-app-button variant="secondary" href="{{ route('habits.index') }}">
                        Back
                    </x-app-button>
                </div>
            </x-slot>
        </x-page-header>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <x-stat-card 
                    label="Current Streak" 
                    :value="$habit->statistics?->current_streak ?? 0" 
                    gradientFrom="orange-500" 
                    gradientTo="red-500">
                    <x-slot name="icon">
                        <svg class="w-5 h-5 md:w-6 md:h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05 6.981 6.981 0 003 11a7 7 0 1011.95-4.95c-.592-.591-.98-.985-1.348-1.467-.363-.476-.724-1.063-1.207-2.03zM12.12 15.12A3 3 0 017 13s.879.5 2.5.5c0-1 .5-4 1.25-4.5.5 1 .786 1.293 1.371 1.879A2.99 2.99 0 0113 13a2.99 2.99 0 01-.879 2.121z" clip-rule="evenodd"/>
                        </svg>
                    </x-slot>
                    <x-slot name="suffix">{{ $habit->frequency_type->periodLabel() }}</x-slot>
                </x-stat-card>

                <x-stat-card 
                    label="Best Streak" 
                    :value="$habit->statistics?->best_streak ?? 0" 
                    gradientFrom="yellow-500" 
                    gradientTo="orange-500">
                    <x-slot name="icon">
                        <svg class="w-5 h-5 md:w-6 md:h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                    </x-slot>
                </x-stat-card>

                <x-stat-card 
                    label="Total Completions" 
                    :value="$habit->statistics?->total_completions ?? 0" 
                    gradientFrom="green-500" 
                    gradientTo="emerald-500">
                    <x-slot name="icon">
                        <svg class="w-5 h-5 md:w-6 md:h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                    </x-slot>
                </x-stat-card>

                <x-stat-card 
                    label="This Month" 
                    :value="$monthlyStats['completions']" 
                    gradientFrom="blue-500" 
                    gradientTo="indigo-500">
                    <x-slot name="icon">
                        <svg class="w-5 h-5 md:w-6 md:h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                        </svg>
                    </x-slot>
                    <x-slot name="suffix">/ {{ $monthlyStats['expected'] }}</x-slot>
                </x-stat-card>
            </div>

            <!-- Habit Info -->
            <div class="card">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Habit Details</h3>
                    <span class="px-3 py-1 rounded-full text-sm font-medium bg-teal-100 dark:bg-teal-900 text-teal-800 dark:text-teal-200">
                        {{ $habit->getProgressText() }}
                    </span>
                </div>
                
                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">Frequency</div>
                        <div class="text-lg font-semibold text-gray-900 dark:text-white">
                            {{ $habit->frequency_count }} time{{ $habit->frequency_count > 1 ? 's' : '' }} per {{ $habit->frequency_type->label() }}
                        </div>
                    </div>
                    
                    @if($habit->goal->category)
                    <div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">Category</div>
                        <div class="text-lg font-semibold text-gray-900 dark:text-white capitalize">
                            {{ $habit->goal->category }}
                        </div>
                    </div>
                    @endif
                    
                    @if($habit->statistics?->last_completed_at)
                    <div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">Last Completed</div>
                        <div class="text-lg font-semibold text-gray-900 dark:text-white">
                            {{ $habit->statistics->last_completed_at->diffForHumans() }}
                        </div>
                    </div>
                    @endif
                    
                    @if($habit->statistics?->streak_start_date)
                    <div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">Current Streak Started</div>
                        <div class="text-lg font-semibold text-gray-900 dark:text-white">
                            {{ $habit->statistics->streak_start_date->format('M d, Y') }}
                        </div>
                    </div>
                    @endif
                </div>

                @if($habit->goal->description)
                <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                    <div class="text-sm text-gray-600 dark:text-gray-400">Description</div>
                    <div class="text-gray-900 dark:text-white">{{ $habit->goal->description }}</div>
                </div>
                @endif
            </div>

            <!-- Calendar -->
            <div class="card">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Completion Calendar</h3>
                    <div class="flex items-center space-x-2">
                        <a href="?year={{ $year }}&month={{ $month - 1 < 1 ? 12 : $month - 1 }}{{ $month - 1 < 1 ? '&year=' . ($year - 1) : '' }}" 
                           class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                            <svg class="w-5 h-5 text-gray-600 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                        </a>
                        <div class="text-lg font-semibold text-gray-900 dark:text-white">
                            {{ \Carbon\Carbon::create($year, $month, 1)->format('F Y') }}
                        </div>
                        <a href="?year={{ $year }}&month={{ $month + 1 > 12 ? 1 : $month + 1 }}{{ $month + 1 > 12 ? '&year=' . ($year + 1) : '' }}" 
                           class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                            <svg class="w-5 h-5 text-gray-600 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Calendar Grid -->
                <div class="grid grid-cols-7 gap-2">
                    <!-- Day headers -->
                    @foreach(['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'] as $day)
                        <div class="text-center text-xs font-semibold text-gray-600 dark:text-gray-400 py-2">
                            {{ $day }}
                        </div>
                    @endforeach

                    <!-- Calendar days -->
                    @foreach($calendar as $day)
                        <div class="aspect-square">
                            @if($day['day'])
                                <div class="w-full h-full rounded-lg flex items-center justify-center text-sm font-medium relative
                                    {{ $day['is_completed'] ? 'bg-green-500 text-white' : '' }}
                                    {{ $day['is_today'] ? 'ring-2 ring-teal-500' : '' }}
                                    {{ !$day['is_completed'] && !$day['is_today'] ? 'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-gray-100' : '' }}">
                                    {{ $day['day'] }}
                                    @if($day['is_completed'])
                                        <svg class="w-3 h-3 absolute top-1 right-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                    @endif
                                </div>
                            @else
                                <div class="w-full h-full"></div>
                            @endif
                        </div>
                    @endforeach
                </div>

                <!-- Legend -->
                <div class="flex items-center justify-center space-x-6 mt-6 pt-4 border-t border-gray-200 dark:border-gray-700">
                    <div class="flex items-center space-x-2">
                        <div class="w-4 h-4 rounded bg-green-500"></div>
                        <span class="text-sm text-gray-600 dark:text-gray-400">Completed</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <div class="w-4 h-4 rounded ring-2 ring-teal-500"></div>
                        <span class="text-sm text-gray-600 dark:text-gray-400">Today</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <div class="w-4 h-4 rounded bg-gray-100 dark:bg-gray-700"></div>
                        <span class="text-sm text-gray-600 dark:text-gray-400">Incomplete</span>
                    </div>
                </div>
            </div>

            <!-- Recent Notes -->
            @if($recentCompletions->count() > 0)
            <div class="card">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Recent Notes</h3>
                <div class="space-y-3">
                    @foreach($recentCompletions as $completion)
                        <div class="p-4 bg-gray-50 dark:bg-gray-800 rounded-lg">
                            <div class="flex items-start justify-between mb-2">
                                <div class="text-sm font-semibold text-gray-900 dark:text-white">
                                    {{ \Carbon\Carbon::parse($completion->date)->format('M d, Y') }}
                                </div>
                                <div class="flex items-center space-x-2 text-sm text-gray-600 dark:text-gray-400">
                                    @if($completion->mood)
                                        <span>{{ $completion->mood_emoji }}</span>
                                    @endif
                                    @if($completion->duration_minutes)
                                        <span>{{ $completion->formatted_duration }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="text-gray-700 dark:text-gray-300">{{ $completion->notes }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

        </div>
    </div>
</x-app-layout>
