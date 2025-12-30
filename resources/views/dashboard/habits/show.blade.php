<x-dashboard-layout>
    <x-slot name="title">{{ $habit->goal->name }}</x-slot>

    <x-dashboard.page-header 
        eyebrow="Habit"
        :title="$habit->goal->name"
        :description="$habit->goal->description" />

    <!-- Action Buttons -->
    @can('update', $habit)
    <div class="pb-6">
        <div class="container">
            <div class="flex justify-center">
                <div class="flex space-x-2">
                    @if(!$habit->archived_at)
                        <x-ui.app-button variant="secondary" href="{{ route('habits.index') }}">
                            <x-slot name="icon">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"/>
                                </svg>
                            </x-slot>
                            Back
                        </x-ui.app-button>
                        
                        <x-ui.app-button variant="secondary" href="{{ route('habits.edit', $habit) }}">
                            <x-slot name="icon">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                                </svg>
                            </x-slot>
                            Edit
                        </x-ui.app-button>
                        
                        <x-ui.app-button variant="secondary" type="button" x-data="" @click="$dispatch('open-modal', 'archive-habit')">
                            <x-slot name="icon">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M4 3a2 2 0 100 4h12a2 2 0 100-4H4z"/>
                                    <path fill-rule="evenodd" d="M3 8h14v7a2 2 0 01-2 2H5a2 2 0 01-2-2V8zm5 3a1 1 0 011-1h2a1 1 0 110 2H9a1 1 0 01-1-1z" clip-rule="evenodd"/>
                                </svg>
                            </x-slot>
                            Archive
                        </x-ui.app-button>
                        
                        <x-ui.app-button variant="secondary" type="button" x-data="" @click="$dispatch('open-modal', 'delete-habit')">
                            <x-slot name="icon">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                            </x-slot>
                            Delete
                        </x-ui.app-button>
                    @else
                        <form action="{{ route('habits.restore', $habit) }}" method="POST" class="inline">
                            @csrf
                            <x-ui.app-button variant="success" type="submit">
                                <x-slot name="icon">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd"/>
                                    </svg>
                                </x-slot>
                                Restore
                            </x-ui.app-button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endcan

    <div class="section">
        <div class="container max-w-4xl">
            <div class="space-y-6">
            
            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <x-ui.stat-card 
                    variant="top"
                    label="Current Streak" 
                    :value="($habit->statistics?->current_streak ?? 0) . ' ' . $habit->frequency_type->periodLabel()" />

                <x-ui.stat-card 
                    variant="top"
                    label="Best Streak" 
                    :value="$habit->statistics?->best_streak ?? 0" />

                <x-ui.stat-card 
                    variant="top"
                    label="Total Completions" 
                    :value="$habit->statistics?->total_completions ?? 0" />

                <x-ui.stat-card 
                    variant="top"
                    label="This Month" 
                    :value="$monthlyStats['completions'] . ' / ' . $monthlyStats['expected']" />
            </div>

            <!-- Habit Details and Calendar Side by Side -->
            <div class="grid lg:grid-cols-2 gap-6">
                <!-- Habit Info -->
                <div class="card">
                    <h3 class="h3 mb-6">Details</h3>
                    
                    <div class="space-y-4">
                        <div class="flex items-center justify-between py-2 border-b border-gray-100 dark:border-gray-700">
                            <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                </svg>
                                <span>Frequency</span>
                            </div>
                            <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ $habit->frequency_count }} time{{ $habit->frequency_count > 1 ? 's' : '' }} per {{ $habit->frequency_type->label() }}</span>
                        </div>
                        
                        @if($habit->goal->category)
                        <div class="flex items-center justify-between py-2 border-b border-gray-100 dark:border-gray-700">
                            <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"/>
                                </svg>
                                <span>Category</span>
                            </div>
                            <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ $habit->goal->category->icon }} {{ $habit->goal->category->name }}</span>
                        </div>
                        @endif
                        
                        @if($habit->statistics?->last_completed_at)
                        <div class="flex items-center justify-between py-2 border-b border-gray-100 dark:border-gray-700">
                            <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span>Last Completed</span>
                            </div>
                            <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ $habit->statistics->last_completed_at->diffForHumans() }}</span>
                        </div>
                        @endif
                        
                        @if($habit->statistics?->streak_start_date)
                        <div class="flex items-center justify-between py-2">
                            <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                                </svg>
                                <span>Streak Started</span>
                            </div>
                            <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ $habit->statistics->streak_start_date->format('M d, Y') }}</span>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Completion Calendar -->
                <x-completion-calendar 
                    :calendar="$calendar"
                    :year="$year"
                    :month="$month"
                    alpineComponent="habitCalendar" />
            </div>

            <!-- Habit Goal Section -->
            @if($habit->goal)
                <div class="card">
                    <h3 class="h3 mb-6">Habit Goal</h3>
                    <x-goal-card>
                        <x-slot:icon>
                            <div class="goal-display-card-icon">{{ $habit->goal->icon ?? '🎯' }}</div>
                        </x-slot:icon>
                        <x-slot:title>
                            <h5 class="goal-display-card-title">{{ $habit->goal->name }}</h5>
                        </x-slot:title>
                        @if($habit->goal->description)
                            <x-slot:subtitle>
                                <p class="goal-display-card-description">{{ $habit->goal->description }}</p>
                            </x-slot:subtitle>
                        @endif
                    </x-goal-card>
                </div>
            @endif
            </div>
        </div>
    </div>

    <!-- Archive Confirmation Modal -->
    <x-ui.modal 
        name="archive-habit"
        eyebrow="Archive Habit" 
        title="Are you sure?"
        maxWidth="md">
        <div class="space-y-4">
            <p class="text-sm text-gray-600 dark:text-gray-400">
                This habit will be hidden from your active list and won't appear in quick complete. You can restore it later if needed.
            </p>
        </div>

        <div class="modal-footer">
            <button type="button" 
                    @click="$dispatch('close-modal', 'archive-habit')"
                    class="btn-secondary">
                Cancel
            </button>
            <form method="POST" action="{{ route('habits.archive', $habit) }}" class="inline">
                @csrf
                <button type="submit" class="btn-primary">
                    Archive Habit
                </button>
            </form>
        </div>
    </x-ui.modal>

    <!-- Delete Confirmation Modal -->
    <x-ui.modal 
        name="delete-habit"
        eyebrow="Delete Habit" 
        title="Are you sure?"
        maxWidth="md">
        <div class="space-y-4">
            <p class="text-sm text-gray-600 dark:text-gray-400">
                All completion history and statistics will be permanently deleted. This action cannot be undone.
            </p>
        </div>

        <div class="modal-footer">
            <button type="button" 
                    @click="$dispatch('close-modal', 'delete-habit')"
                    class="btn-secondary">
                Cancel
            </button>
            <form method="POST" action="{{ route('habits.destroy', $habit) }}" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-primary bg-red-600 hover:bg-red-700 focus:ring-red-500">
                    Delete Habit
                </button>
            </form>
        </div>
    </x-ui.modal>

    <!-- Day Details Modal -->
    <div x-data="habitDayModal('{{ \Carbon\Carbon::create($year, $month, 1)->format('F') }}', '{{ $year }}', {{ $habit->id }}, '{{ route('habits.updateCompletion', $habit) }}')" 
         @set-day-data.window="dayData = $event.detail">
        <x-ui.modal 
            name="day-details-modal"
            eyebrow="Completion Details" 
            x-bind:title="dayData && dayData.day ? monthName + ' ' + dayData.day + ', ' + year : 'Completion Details'"
            maxWidth="md">
            <template x-if="dayData">
                <div class="daily-goals-list">
                    <!-- Edit Mode: Toggle completion -->
                    <template x-if="editMode">
                        <label class="goal-select-clickable">
                            <x-goal-card>
                                <x-slot:icon>
                                    <div class="goal-display-card-icon">
                                        <span>{{ $habit->goal->icon ?? '🎯' }}</span>
                                    </div>
                                </x-slot:icon>
                                <x-slot:title>
                                    <div class="daily-goals-title">{{ $habit->goal->name }}</div>
                                </x-slot:title>
                                <x-slot:rightAction>
                                    <input 
                                        type="checkbox" 
                                        class="form-checkbox"
                                        :checked="editedCompletion"
                                        @change="toggleCompletion()">
                                </x-slot:rightAction>
                            </x-goal-card>
                        </label>
                    </template>
                    
                    <!-- View Mode: Show completion status -->
                    <template x-if="!editMode">
                        <x-goal-card>
                            <x-slot:icon>
                                <div class="goal-display-card-icon">
                                    <span>{{ $habit->goal->icon ?? '🎯' }}</span>
                                </div>
                            </x-slot:icon>
                            <x-slot:title>
                                <div class="daily-goals-title">{{ $habit->goal->name }}</div>
                            </x-slot:title>
                            <x-slot:subtitle>
                                <template x-if="dayData.is_completed && dayData.completion?.completed_at">
                                    <div class="daily-goals-timestamp">
                                        Completed at <span x-text="new Date(dayData.completion.completed_at).toLocaleTimeString('en-US', { hour: 'numeric', minute: '2-digit' })"></span>
                                    </div>
                                </template>
                                <template x-if="dayData.completion?.notes">
                                    <div class="daily-goals-timestamp" x-text="dayData.completion.notes"></div>
                                </template>
                            </x-slot:subtitle>
                            <x-slot:rightAction>
                                <div class="daily-goals-status-icon" :class="dayData.is_completed ? 'daily-goals-status-icon--completed' : 'daily-goals-status-icon--incomplete'">
                                    <template x-if="dayData.is_completed">
                                        <svg fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                    </template>
                                    <template x-if="!dayData.is_completed">
                                        <svg fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                        </svg>
                                    </template>
                                </div>
                            </x-slot:rightAction>
                        </x-goal-card>
                    </template>
                    
                    <!-- Additional details shown in view mode -->
                    <template x-if="!editMode && dayData.is_completed && dayData.completion && (dayData.completion.duration_minutes || dayData.completion.mood)">
                        <div class="text-sm text-gray-600 dark:text-gray-400 space-y-1 px-4 pb-2">
                            <template x-if="dayData.completion.duration_minutes">
                                <div>Duration: <span class="font-semibold" x-text="dayData.completion.duration_minutes + ' minutes'"></span></div>
                            </template>
                            <template x-if="dayData.completion.mood">
                                <div>Mood: <span class="font-semibold capitalize" x-text="dayData.completion.mood"></span></div>
                            </template>
                        </div>
                    </template>
                </div>
            </template>

            <div class="modal-footer">
                @can('update', $habit)
                    <!-- Edit Mode Buttons -->
                    <template x-if="editMode">
                        <div class="flex gap-2 w-full">
                            <button type="button" 
                                    @click="editMode = false"
                                    class="btn-secondary flex-1">
                                Cancel
                            </button>
                            <button type="button" 
                                    @click="saveChanges()"
                                    class="btn-primary flex-1">
                                Save Changes
                            </button>
                        </div>
                    </template>
                    <!-- View Mode Buttons -->
                    <template x-if="!editMode">
                        <div class="flex gap-2 w-full">
                            <button type="button" 
                                    @click="$dispatch('close-modal', 'day-details-modal')"
                                    class="btn-secondary flex-1">
                                Close
                            </button>
                            <button type="button" 
                                    @click="initEditMode(); editMode = true"
                                    class="btn-primary flex-1">
                                Edit
                            </button>
                        </div>
                    </template>
                @else
                    <button type="button" 
                            @click="$dispatch('close-modal', 'day-details-modal')"
                            class="btn-secondary">
                        Close
                    </button>
                @endcan
            </div>
        </x-ui.modal>
    </div>
</x-dashboard-layout>
