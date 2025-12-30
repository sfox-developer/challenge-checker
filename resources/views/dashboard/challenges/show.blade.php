<x-dashboard-layout>
    <x-slot name="title">{{ $challenge->name }}</x-slot>

    <x-dashboard.page-header 
        eyebrow="Challenge"
        :title="$challenge->name"
        :description="$challenge->description" />

    {{-- Action Buttons Section --}}
    <div class="section pt-0">
        <div class="container max-w-4xl">
            <div class="card">
                <div class="flex flex-wrap justify-center gap-2">
                    @if(!$challenge->completed_at)
                        <x-ui.app-button variant="secondary" href="{{ route('challenges.index') }}">
                            <x-slot name="icon">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"/>
                                </svg>
                            </x-slot>
                            Back
                        </x-ui.app-button>
                        
                        <x-ui.app-button variant="secondary" href="{{ route('challenges.edit', $challenge) }}">
                            <x-slot name="icon">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                                </svg>
                            </x-slot>
                            Edit
                        </x-ui.app-button>
                        
                        @if($challenge->started_at)
                            @if($challenge->is_active)
                                <form method="POST" action="{{ route('challenges.pause', $challenge) }}">
                                    @csrf
                                    <x-ui.app-button variant="secondary" type="submit">
                                        <x-slot name="icon">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zM7 8a1 1 0 012 0v4a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v4a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                            </svg>
                                        </x-slot>
                                        Pause
                                    </x-ui.app-button>
                                </form>
                            @else
                                <form method="POST" action="{{ route('challenges.resume', $challenge) }}">
                                    @csrf
                                    <x-ui.app-button variant="secondary" type="submit">
                                        <x-slot name="icon">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"/>
                                            </svg>
                                        </x-slot>
                                        Resume
                                    </x-ui.app-button>
                                </form>
                            @endif
                            
                            <x-ui.app-button variant="secondary" type="button" @click="$dispatch('open-modal', 'complete-challenge')">
                                <x-slot name="icon">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                </x-slot>
                                Complete
                            </x-ui.app-button>
                        @else
                            <form method="POST" action="{{ route('challenges.start', $challenge) }}">
                                @csrf
                                <x-ui.app-button variant="primary" type="submit">
                                    <x-slot name="icon">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"/>
                                        </svg>
                                    </x-slot>
                                    Start Challenge
                                </x-ui.app-button>
                            </form>
                        @endif
                    @else
                        <x-ui.app-button variant="secondary" href="{{ route('challenges.index') }}">
                            <x-slot name="icon">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"/>
                                </svg>
                            </x-slot>
                            Back
                        </x-ui.app-button>
                        
                        @if(!$challenge->isArchived())
                            <x-ui.app-button variant="secondary" type="button" @click="$dispatch('open-modal', 'archive-challenge')">
                                <x-slot name="icon">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M4 3a2 2 0 100 4h12a2 2 0 100-4H4z"/>
                                        <path fill-rule="evenodd" d="M3 8h14v7a2 2 0 01-2 2H5a2 2 0 01-2-2V8zm5 3a1 1 0 011-1h2a1 1 0 110 2H9a1 1 0 01-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                </x-slot>
                                Archive
                            </x-ui.app-button>
                            
                            <x-ui.app-button variant="secondary" type="button" x-data="" @click="$dispatch('open-modal', 'delete-challenge')">
                                <x-slot name="icon">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                </x-slot>
                                Delete
                            </x-ui.app-button>
                        @else
                            <form method="POST" action="{{ route('challenges.restore', $challenge) }}">
                                @csrf
                                <x-ui.app-button variant="primary" type="submit">
                                    <x-slot name="icon">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd"/>
                                        </svg>
                                    </x-slot>
                                    Restore
                                </x-ui.app-button>
                            </form>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Statistics Section --}}
    <div class="section pt-0">
        <div class="container max-w-4xl">
            <div class="grid grid-cols-2 md:grid-cols-2 gap-4 md:gap-6">

                <x-ui.stat-card 
                    variant="top"
                    label="Progress" 
                    :value="number_format($challenge->getProgressPercentage(), 1) . '%'" />

                <x-ui.stat-card 
                    variant="top"
                    label="Completed" 
                    :value="$challenge->dailyProgress()->whereNotNull('completed_at')->count() . ' / ' . ($challenge->goals->count() * $challenge->getDuration())" />
            </div>
        </div>
    </div>

    {{-- Main Content Section --}}
    <div class="section pt-0">
        <div class="container max-w-4xl">
            <div class="space-y-6">

            <!-- Challenge Details and Progress Side by Side -->
            <div class="grid lg:grid-cols-2 gap-6">
                <!-- Challenge Details -->
                <div class="card">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="h3">Details</h3>
                        @if($challenge->isArchived())
                            <span class="status-archived">Archived</span>
                        @elseif($challenge->completed_at)
                            <span class="status-completed">Completed</span>
                        @elseif($challenge->is_active)
                            <span class="status-active">Active</span>
                        @elseif($challenge->started_at)
                            <span class="status-paused">Paused</span>
                        @else
                            <span class="status-draft">Draft</span>
                        @endif
                    </div>
                    
                    <div class="space-y-4">
                        <div class="flex items-center justify-between py-2 border-b border-gray-100 dark:border-gray-700">
                            <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                </svg>
                                <span>Frequency</span>
                            </div>
                            <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ $challenge->getFrequencyDescription() }}</span>
                        </div>
                        
                        @if($challenge->days_duration)
                        <div class="flex items-center justify-between py-2 border-b border-gray-100 dark:border-gray-700">
                            <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                                </svg>
                                <span>Duration</span>
                            </div>
                            <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ $challenge->days_duration }} days</span>
                        </div>
                        @endif
                        
                        <div class="flex items-center justify-between py-2 border-b border-gray-100 dark:border-gray-700">
                            <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm3 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1zm-3 4a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"/>
                                </svg>
                                <span>Goals</span>
                            </div>
                            <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ $challenge->goals->count() }}</span>
                        </div>
                        
                        @if($challenge->started_at)
                        <div class="flex items-center justify-between py-2 border-b border-gray-100 dark:border-gray-700">
                            <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"/>
                                </svg>
                                <span>Started</span>
                            </div>
                            <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ $challenge->started_at->format('M d, Y') }}</span>
                        </div>
                        @endif
                        
                        @if($challenge->end_date)
                        <div class="flex items-center justify-between py-2 border-b border-gray-100 dark:border-gray-700">
                            <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                </svg>
                                <span>End Date</span>
                            </div>
                            <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ $challenge->end_date->format('M d, Y') }}</span>
                        </div>
                        @endif
                        
                        @if($challenge->completed_at)
                        <div class="flex items-center justify-between py-2">
                            <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span>Completed</span>
                            </div>
                            <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ $challenge->completed_at->diffForHumans() }}</span>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Completion Calendar -->
                <div class="card" x-data="challengeCalendar({{ json_encode($calendar) }})">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="h3">Completion Calendar</h3>
                        <div class="flex items-center space-x-1">
                            <a href="?year={{ $year }}&month={{ $month - 1 < 1 ? 12 : $month - 1 }}{{ $month - 1 < 1 ? '&year=' . ($year - 1) : '' }}" 
                               class="calendar-nav-button">
                                <svg class="w-4 h-4 text-gray-600 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </a>
                            <div class="text-sm font-semibold text-gray-900 dark:text-white min-w-[80px] text-center">
                                {{ \Carbon\Carbon::create($year, $month, 1)->format('M Y') }}
                            </div>
                            <a href="?year={{ $year }}&month={{ $month + 1 > 12 ? 1 : $month + 1 }}{{ $month + 1 > 12 ? '&year=' . ($year + 1) : '' }}" 
                               class="calendar-nav-button">
                                <svg class="w-4 h-4 text-gray-600 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                    
                    <!-- Calendar Grid -->
                    <div class="grid grid-cols-7 gap-1 max-w-xs mx-auto">
                        <!-- Day headers -->
                        @foreach(['M', 'T', 'W', 'T', 'F', 'S', 'S'] as $day)
                            <div class="text-center text-xs font-medium text-gray-500 dark:text-gray-400 py-1">
                                {{ $day }}
                            </div>
                        @endforeach

                        <!-- Calendar days -->
                        @foreach($calendar as $index => $day)
                            <div class="aspect-square">
                                @if($day['day'])
                                    @php
                                        $hasPartialCompletion = $day['completed_count'] > 0 && !$day['is_completed'];
                                        $classes = 'calendar-day';
                                        if ($day['is_completed']) {
                                            $classes .= ' calendar-day-completed';
                                        } elseif ($hasPartialCompletion) {
                                            $classes .= ' calendar-day-partial';
                                        } else {
                                            $classes .= ' calendar-day-default';
                                        }
                                        if ($day['is_today']) {
                                            $classes .= ' calendar-day-today';
                                        }
                                    @endphp
                                    <button 
                                        type="button"
                                        @click="selectDay({{ $index }}); $dispatch('open-modal', 'day-details-modal'); $dispatch('set-day-data', getSelectedDayData())"
                                        class="{{ $classes }}"
                                        title="{{ $day['completed_count'] }} / {{ $day['total_count'] }} goals completed">
                                        {{ $day['day'] }}
                                    </button>
                                @else
                                    <div class="w-full h-full"></div>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    <!-- Legend -->
                    <div class="calendar-legend">
                        <div class="calendar-legend-item">
                            <div class="calendar-legend-dot dot-completed"></div>
                            <span class="calendar-legend-label">All Complete</span>
                        </div>
                        <div class="calendar-legend-item">
                            <div class="calendar-legend-dot dot-partial"></div>
                            <span class="calendar-legend-label">Partial</span>
                        </div>
                        <div class="calendar-legend-item">
                            <div class="calendar-legend-dot dot-today"></div>
                            <span class="calendar-legend-label">Today</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Challenge Goals Section -->
            @if($challenge->goals->isNotEmpty())
                <div class="card">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="h3">Challenge Goals</h3>
                        <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300">
                            {{ $challenge->goals->count() }} {{ Str::plural('goal', $challenge->goals->count()) }}
                        </span>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        @foreach($challenge->goals as $goal)
                            <x-goal-card>
                                <x-slot:icon>
                                    <div class="goal-display-card-icon">{{ $goal->library?->icon ?? '🎯' }}</div>
                                </x-slot:icon>
                                <x-slot:title>
                                    <h5 class="goal-display-card-title">{{ $goal->name }}</h5>
                                </x-slot:title>
                                @if($goal->description)
                                    <x-slot:subtitle>
                                        <p class="goal-display-card-description">{{ $goal->description }}</p>
                                    </x-slot:subtitle>
                                @endif
                            </x-goal-card>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Progress History -->
            @if($challenge->started_at)
                <div class="card">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="h3">
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
                        <x-ui.stat-card 
                            variant="top"
                            label="{{ $periodLabel }} Active" 
                            :value="$totalPeriods" />
                        
                        <x-ui.stat-card 
                            variant="top"
                            label="Perfect {{ $periodLabel }}" 
                            :value="$perfectPeriods" />
                        
                        <x-ui.stat-card 
                            variant="top"
                            label="Success Rate" 
                            :value="number_format(($perfectPeriods / max($totalPeriods, 1)) * 100, 1) . '%'" />
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
                                    $bgColor = 'bg-slate-700 dark:bg-slate-600 text-white';
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
                                        <div class="absolute -bottom-1 w-1 h-1 bg-slate-600 rounded-full"></div>
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
                                <div class="progress-period-card {{ $period['isCurrentPeriod'] ? 'current-period' : '' }}">
                                    <div class="progress-period-header">
                                        <div class="progress-period-date">
                                            {{ $period['start']->format('M j') }} - {{ $period['end']->format('M j, Y') }}
                                            @if($period['isCurrentPeriod'])
                                                <span class="progress-period-badge">Current</span>
                                            @endif
                                        </div>
                                        <div class="progress-period-count">
                                            {{ $period['completions'] }}/{{ $period['expected'] }}
                                        </div>
                                    </div>
                                    <div class="progress-container">
                                        <div class="progress-bar {{ $period['percentage'] >= 100 ? 'bg-slate-700 dark:bg-slate-600' : 'bg-slate-600' }}" style="width: {{ $period['percentage'] }}%"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif                    @if($frequencyType === 'daily')
                    <div class="flex items-center justify-center space-x-6 text-xs text-gray-600 dark:text-gray-400">
                        <div class="flex items-center space-x-2">
                            <div class="w-3 h-3 rounded-full bg-slate-700 dark:bg-slate-600"></div>
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
    </div>

    <!-- Completion Confirmation Modal -->
    <x-ui.modal 
        name="complete-challenge"
        eyebrow="Complete Challenge" 
        title="Are you sure?"
        maxWidth="md">
        <div class="space-y-4">
            <p class="text-sm text-gray-600 dark:text-gray-400">
                Are you sure you want to mark this challenge as complete? This action cannot be undone and will stop tracking your daily progress.
            </p>
        </div>

        <div class="modal-footer">
            <button type="button" 
                    @click="$dispatch('close-modal', 'complete-challenge')"
                    class="btn-secondary">
                Cancel
            </button>
            <form method="POST" action="{{ route('challenges.complete', $challenge) }}" class="inline">
                @csrf
                <button type="submit" class="btn-primary">
                    Complete Challenge
                </button>
            </form>
        </div>
    </x-ui.modal>

    <!-- Archive Confirmation Modal -->
    <x-ui.modal 
        name="archive-challenge"
        eyebrow="Archive Challenge" 
        title="Are you sure?"
        maxWidth="md">
        <div class="space-y-4">
            <p class="text-sm text-gray-600 dark:text-gray-400">
                This challenge will be hidden from your active list. You can restore it later if needed.
            </p>
        </div>

        <div class="modal-footer">
            <button type="button" 
                    @click="$dispatch('close-modal', 'archive-challenge')"
                    class="btn-secondary">
                Cancel
            </button>
            <form method="POST" action="{{ route('challenges.archive', $challenge) }}" class="inline">
                @csrf
                <button type="submit" class="btn-primary">
                    Archive Challenge
                </button>
            </form>
        </div>
    </x-ui.modal>

    <!-- Delete Confirmation Modal -->
    <x-ui.modal 
        name="delete-challenge"
        eyebrow="Delete Challenge" 
        title="Are you sure?"
        maxWidth="md">
        <div class="space-y-4">
            <p class="text-sm text-gray-600 dark:text-gray-400">
                All challenge data, goals, and completion history will be permanently deleted. This action cannot be undone.
            </p>
        </div>

        <div class="modal-footer">
            <button type="button" 
                    @click="$dispatch('close-modal', 'delete-challenge')"
                    class="btn-secondary">
                Cancel
            </button>
            <form method="POST" action="{{ route('challenges.destroy', $challenge) }}" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-primary">
                    Delete Challenge
                </button>
            </form>
        </div>
    </x-ui.modal>

    <!-- Day Details Modal -->
    <div x-data="{ dayData: null, monthName: '{{ \Carbon\Carbon::create($year, $month, 1)->format('F') }}', year: '{{ $year }}' }" 
         @set-day-data.window="dayData = $event.detail">
        <x-ui.modal 
            name="day-details-modal"
            eyebrow="Daily Goals" 
            x-bind:title="dayData && dayData.day ? monthName + ' ' + dayData.day + ', ' + year : 'Goal Details'"
            maxWidth="md">
            <template x-if="dayData && dayData.goals">
                <div class="daily-goals-list">
                    <template x-for="(goalCompletion, index) in dayData.goals" :key="index">
                        <x-goal-card>
                            <x-slot:icon>
                                <div class="goal-display-card-icon">
                                    <span x-text="goalCompletion.goal?.icon || '🎯'"></span>
                                </div>
                            </x-slot:icon>
                            <x-slot:title>
                                <div class="daily-goals-title" x-text="goalCompletion.goal?.name"></div>
                            </x-slot:title>
                            <x-slot:subtitle>
                                <template x-if="goalCompletion.is_completed && goalCompletion.completed_at">
                                    <div class="daily-goals-timestamp">
                                        Completed at <span x-text="new Date(goalCompletion.completed_at).toLocaleTimeString('en-US', { hour: 'numeric', minute: '2-digit' })"></span>
                                    </div>
                                </template>
                            </x-slot:subtitle>
                            <x-slot:rightAction>
                                <div class="daily-goals-status-icon" :class="goalCompletion.is_completed ? 'daily-goals-status-icon--completed' : 'daily-goals-status-icon--incomplete'">
                                    <template x-if="goalCompletion.is_completed">
                                        <svg fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                    </template>
                                    <template x-if="!goalCompletion.is_completed">
                                        <svg fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                        </svg>
                                    </template>
                                </div>
                            </x-slot:rightAction>
                        </x-goal-card>
                    </template>
                    
                    <div class="daily-goals-summary">
                        <div class="daily-goals-summary-text">
                            <span class="daily-goals-summary-number" x-text="dayData?.completed_count"></span> of <span class="daily-goals-summary-number" x-text="dayData?.total_count"></span> goals completed
                        </div>
                    </div>
                </div>
            </template>

            <div class="modal-footer">
                <button type="button" 
                        @click="$dispatch('close-modal', 'day-details-modal')"
                        class="btn-secondary">
                    Close
                </button>
            </div>
        </x-ui.modal>
    </div>
</x-dashboard-layout>
