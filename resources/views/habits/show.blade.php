<x-app-layout>
    <x-slot name="header">
        <x-page-header :title="$habit->goal->name" gradient="success">
            <x-slot name="icon">
                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                    <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/>
                </svg>
            </x-slot>
            <x-slot name="action">
                <div class="flex space-x-2">
                    @if(!$habit->archived_at)
                        <x-app-button variant="secondary" href="{{ route('habits.index') }}">
                            <x-slot name="icon">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"/>
                                </svg>
                            </x-slot>
                            Back
                        </x-app-button>
                        
                        <x-app-button variant="secondary" href="{{ route('habits.edit', $habit) }}">
                            <x-slot name="icon">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                                </svg>
                            </x-slot>
                            Edit
                        </x-app-button>
                        
                        <x-app-button variant="secondary" type="button" onclick="showArchiveModal()">
                            <x-slot name="icon">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M4 3a2 2 0 100 4h12a2 2 0 100-4H4z"/>
                                    <path fill-rule="evenodd" d="M3 8h14v7a2 2 0 01-2 2H5a2 2 0 01-2-2V8zm5 3a1 1 0 011-1h2a1 1 0 110 2H9a1 1 0 01-1-1z" clip-rule="evenodd"/>
                                </svg>
                            </x-slot>
                            Archive
                        </x-app-button>
                    @else
                        <form action="{{ route('habits.restore', $habit) }}" method="POST" class="inline">
                            @csrf
                            <x-app-button variant="success" type="submit">
                                <x-slot name="icon">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd"/>
                                    </svg>
                                </x-slot>
                                Restore
                            </x-app-button>
                        </form>
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

            <!-- Habit Details and Calendar Side by Side -->
            <div class="grid lg:grid-cols-2 gap-6">
                <!-- Habit Info -->
                <div class="card">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">Details</h3>
                        <span class="badge-frequency">
                            {{ $habit->getProgressText() }}
                        </span>
                    </div>
                    
                    @if($habit->goal->description)
                        <p class="text-sm text-gray-700 dark:text-gray-100 mb-4 leading-relaxed">{{ $habit->goal->description }}</p>
                    @endif
                    
                    <div class="space-y-3">
                        <div class="stat-item">
                            <div class="stat-label">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                </svg>
                                <span>Frequency:</span>
                            </div>
                            <span class="stat-value">{{ $habit->frequency_count }} time{{ $habit->frequency_count > 1 ? 's' : '' }} per {{ $habit->frequency_type->label() }}</span>
                        </div>
                        
                        @if($habit->goal->category)
                        <div class="stat-item">
                            <div class="stat-label">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"/>
                                </svg>
                                <span>Category:</span>
                            </div>
                            <span class="stat-value">{{ $habit->goal->category->icon }} {{ $habit->goal->category->name }}</span>
                        </div>
                        @endif
                        
                        @if($habit->statistics?->last_completed_at)
                        <div class="stat-item">
                            <div class="stat-label">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span>Last Completed:</span>
                            </div>
                            <span class="stat-value">{{ $habit->statistics->last_completed_at->diffForHumans() }}</span>
                        </div>
                        @endif
                        
                        @if($habit->statistics?->streak_start_date)
                        <div class="stat-item">
                            <div class="stat-label">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                                </svg>
                                <span>Streak Started:</span>
                            </div>
                            <span class="stat-value">{{ $habit->statistics->streak_start_date->format('M d, Y') }}</span>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Calendar -->
                <div class="card">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">Completion Calendar</h3>
                        <div class="flex items-center space-x-1">
                            <a href="?year={{ $year }}&month={{ $month - 1 < 1 ? 12 : $month - 1 }}{{ $month - 1 < 1 ? '&year=' . ($year - 1) : '' }}" 
                               class="p-1 rounded hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                <svg class="w-4 h-4 text-gray-600 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </a>
                            <div class="text-sm font-semibold text-gray-900 dark:text-white min-w-[80px] text-center">
                                {{ \Carbon\Carbon::create($year, $month, 1)->format('M Y') }}
                            </div>
                            <a href="?year={{ $year }}&month={{ $month + 1 > 12 ? 1 : $month + 1 }}{{ $month + 1 > 12 ? '&year=' . ($year + 1) : '' }}" 
                               class="p-1 rounded hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
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
                        @foreach($calendar as $day)
                            <div class="aspect-square">
                                @if($day['day'])
                                    <div class="w-full h-full rounded flex items-center justify-center text-xs font-medium
                                        {{ $day['is_completed'] ? 'bg-slate-700 dark:bg-slate-600 text-white' : '' }}
                                        {{ $day['is_today'] ? 'ring-2 ring-teal-500 text-gray-900 dark:text-gray-100' : '' }}
                                        {{ !$day['is_completed'] && !$day['is_today'] ? 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300' : '' }}">
                                        {{ $day['day'] }}
                                    </div>
                                @else
                                    <div class="w-full h-full"></div>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    <!-- Legend -->
                    <div class="flex items-center justify-center gap-4 mt-4 pt-3 border-t border-gray-200 dark:border-gray-700">
                        <div class="flex items-center gap-1.5">
                            <div class="w-3 h-3 rounded bg-slate-700 dark:bg-slate-600"></div>
                            <span class="text-xs text-gray-600 dark:text-gray-400">Completed</span>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <div class="w-3 h-3 rounded ring-2 ring-teal-500"></div>
                            <span class="text-xs text-gray-600 dark:text-gray-400">Today</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Archive Confirmation Modal -->
    <div id="archiveModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-gray-800">
            <div class="mt-3 text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-yellow-100 dark:bg-yellow-900">
                    <svg class="h-6 w-6 text-yellow-600 dark:text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100 mt-4">Archive Habit?</h3>
                <div class="mt-2 px-7 py-3">
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        This habit will be hidden from your active list and won't appear in quick complete. You can restore it later if needed.
                    </p>
                </div>
                <div class="items-center px-4 py-3">
                    <div class="flex space-x-3">
                        <x-app-button variant="modal-cancel" type="button" onclick="hideArchiveModal()">
                            Cancel
                        </x-app-button>
                        <form method="POST" action="{{ route('habits.archive', $habit) }}" class="w-full">
                            @csrf
                            <x-app-button variant="modal-confirm" type="submit">
                                Archive Habit
                            </x-app-button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Modal functions are now global
        window.showArchiveModal = () => showModal('archiveModal');
        window.hideArchiveModal = () => hideModal('archiveModal');
        
        // Initialize modal listeners
        document.addEventListener('DOMContentLoaded', () => {
            initModalListeners('archiveModal', hideArchiveModal);
        });
    </script>
</x-app-layout>
