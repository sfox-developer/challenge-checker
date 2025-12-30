@props([
    'calendar',
    'year',
    'month',
    'alpineComponent',
    'modalName' => 'day-details-modal',
    'title' => 'Completion Calendar',
    'showPartial' => false,
])

<div class="card" x-data="{{ $alpineComponent }}({{ json_encode($calendar) }})">
    <div class="flex items-center justify-between mb-6">
        <h3 class="h3">{{ $title }}</h3>
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
                        $hasPartialCompletion = $showPartial && isset($day['completed_count']) && isset($day['total_count']) && $day['completed_count'] > 0 && !$day['is_completed'];
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
                        
                        // Build tooltip
                        $tooltip = '';
                        if (isset($day['completed_count']) && isset($day['total_count'])) {
                            $tooltip = "{$day['completed_count']} / {$day['total_count']} goals completed";
                        } elseif (isset($day['completed_count'])) {
                            $tooltip = "{$day['completed_count']} completion(s)";
                        }
                    @endphp
                    <button 
                        type="button"
                        @click="selectDay({{ $index }}); $dispatch('open-modal', '{{ $modalName }}'); $dispatch('set-day-data', getSelectedDayData())"
                        class="{{ $classes }}"
                        @if($tooltip)title="{{ $tooltip }}"@endif>
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
            <span class="calendar-legend-label">{{ $showPartial ? 'All Complete' : 'Completed' }}</span>
        </div>
        @if($showPartial)
            <div class="calendar-legend-item">
                <div class="calendar-legend-dot dot-partial"></div>
                <span class="calendar-legend-label">Partial</span>
            </div>
        @endif
        <div class="calendar-legend-item">
            <div class="calendar-legend-dot dot-today"></div>
            <span class="calendar-legend-label">Today</span>
        </div>
    </div>
</div>
