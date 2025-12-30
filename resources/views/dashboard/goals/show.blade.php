<x-dashboard-layout>
    <x-slot name="title">{{ $goal->name }}</x-slot>

    <x-dashboard.page-header 
        eyebrow="Goal Library"
        :title="($goal->icon ?? '🎯') . ' ' . $goal->name"
        :description="$goal->description ?: 'Goal details and usage'" />

    <!-- Action Buttons -->
    <div class="pb-6">
        <div class="container">
            <div class="flex justify-center">
                <div class="flex space-x-2">
                    <x-ui.app-button variant="secondary" href="{{ route('goals.index') }}">
                        <x-slot name="icon">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"/>
                            </svg>
                        </x-slot>
                        Back
                    </x-ui.app-button>
                    
                    <x-ui.app-button variant="secondary" type="button" x-data="" @click="$dispatch('open-modal', 'edit-goal-{{ $goal->id }}')">
                        <x-slot name="icon">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                            </svg>
                        </x-slot>
                        Edit
                    </x-ui.app-button>
                    
                    <x-ui.app-button 
                        variant="secondary" 
                        type="button" 
                        x-data="" 
                        class="{{ ($challenges->count() > 0 || $habits->count() > 0) ? 'opacity-50' : '' }}"
                        @click="$dispatch('open-modal', '{{ ($challenges->count() > 0 || $habits->count() > 0) ? 'cannot-delete-goal-' . $goal->id : 'delete-goal-' . $goal->id }}')">
                        <x-slot name="icon">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                        </x-slot>
                        Delete
                    </x-ui.app-button>
            </div>
        </div>
    </div>

    <div class="section">
        <div class="container max-w-4xl">
            <div class="space-y-6">
            <!-- Statistics Cards -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <x-ui.stat-card label="Total Completions" :value="$stats['total_completions']" variant="top" />
                
                <x-ui.stat-card label="Avg Success Rate" :value="$stats['success_rate']" variant="top">
                    <x-slot name="suffix">%</x-slot>
                </x-ui.stat-card>
                
                <x-ui.stat-card label="Active Challenges" :value="$stats['active_challenges']" variant="top" />
                
                <x-ui.stat-card label="Active Habits" :value="$stats['active_habits']" variant="top" />
            </div>

            <!-- Timeline Info -->
            @if($stats['first_used'] || $stats['last_active'])
                <div class="card">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @if($stats['first_used'])
                            <div>
                                <div class="text-sm text-gray-600 dark:text-gray-400 mb-1">First Used</div>
                                <div class="h3">
                                    {{ \Carbon\Carbon::parse($stats['first_used'])->format('M d, Y') }}
                                    <span class="text-sm text-gray-500 dark:text-gray-400">
                                        ({{ \Carbon\Carbon::parse($stats['first_used'])->diffForHumans() }})
                                    </span>
                                </div>
                            </div>
                        @endif

                        @if($stats['last_active'])
                            <div>
                                <div class="text-sm text-gray-600 dark:text-gray-400 mb-1">Last Active</div>
                                <div class="h3">
                                    {{ \Carbon\Carbon::parse($stats['last_active'])->format('M d, Y') }}
                                    <span class="text-sm text-gray-500 dark:text-gray-400">
                                        ({{ \Carbon\Carbon::parse($stats['last_active'])->diffForHumans() }})
                                    </span>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Completion Calendar -->
            @if($stats['total_completions'] > 0)
                <x-completion-calendar 
                    :calendar="$calendar"
                    :year="$year"
                    :month="$month"
                    alpineComponent="goalCalendar" />
            @endif

            <!-- Tabs -->
            <div x-data="{ activeTab: 'challenges' }">
                <!-- Tab Navigation -->
                <div class="tab-header">
                    <nav class="tab-nav">
                        <button @click="activeTab = 'challenges'" 
                                :class="activeTab === 'challenges' ? 'tab-button active' : 'tab-button'">
                            Challenges
                            <span class="tab-count-badge" :class="activeTab === 'challenges' ? 'active' : 'inactive'">
                                {{ $challenges->count() }}
                            </span>
                        </button>
                        <button @click="activeTab = 'habits'" 
                                :class="activeTab === 'habits' ? 'tab-button active' : 'tab-button'">
                            Habits
                            <span class="tab-count-badge" :class="activeTab === 'habits' ? 'active' : 'inactive'">
                                {{ $habits->count() }}
                            </span>
                        </button>
                    </nav>
                </div>

            <!-- Challenges Tab -->
            <div x-show="activeTab === 'challenges'">
                @if($challenges->count() > 0)
                    <div class="space-y-4">
                        @foreach($challenges as $challenge)
                            <x-challenges.challenge-list-item :challenge="$challenge" />
                        @endforeach
                    </div>
                @else
                    <div class="empty-state-card">
                        <div class="empty-state-icon">
                            <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                        <h3 class="empty-state-title">
                            No challenges yet
                        </h3>
                        <p class="empty-state-message">
                            This goal hasn't been used in any challenges
                        </p>
                    </div>
                @endif
            </div>

            <!-- Habits Tab -->
            <div x-show="activeTab === 'habits'" style="display: none;">
                @if($habits->count() > 0)
                    <div class="space-y-3">
                        @foreach($habits as $habit)
                            <x-habits.habit-list-item :habit="$habit" />
                        @endforeach
                    </div>
                @else
                    <div class="empty-state-card">
                        <div class="empty-state-icon">
                            <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="empty-state-title">
                            No habits yet
                        </h3>
                        <p class="empty-state-message">
                            This goal hasn't been used in any habits
                        </p>
                    </div>
                @endif
            </div>
            </div>

            <!-- Empty State - When both are empty -->
            @if($challenges->count() === 0 && $habits->count() === 0)
                <div class="empty-state-card">
                    <div class="empty-state-icon">
                        <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <h3 class="empty-state-title">
                        This goal hasn't been used yet
                    </h3>
                    <p class="empty-state-message">
                        Start using "{{ $goal->name }}" by adding it to a challenge or habit
                    </p>
                    <div class="empty-state-action">
                        <div class="flex flex-col sm:flex-row gap-3 justify-center">
                            <x-ui.app-button href="{{ route('challenges.create') }}">
                                <x-slot name="icon">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"/>
                                    </svg>
                                </x-slot>
                                Create Challenge
                            </x-ui.app-button>
                            <x-ui.app-button variant="secondary" href="{{ route('habits.create') }}">
                                <x-slot name="icon">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"/>
                                    </svg>
                                </x-slot>
                                Create Habit
                            </x-ui.app-button>
                        </div>
                    </div>
                </div>
            @endif
            </div>
        </div>
    </div>

    <!-- Edit Goal Modal -->
    <x-ui.modal 
        name="edit-goal-{{ $goal->id }}"
        eyebrow="Your Collection" 
        title="Edit Goal"
        maxWidth="lg"
    >
        <form method="POST" action="{{ route('goals.update', $goal) }}">
            @csrf
            @method('PUT')

            <div class="space-y-4">
                <x-forms.form-input
                    name="name"
                    label="Goal Name"
                    placeholder="e.g., Exercise, Read, Meditate"
                    :value="$goal->name"
                    required />

                <div class="grid grid-cols-2 gap-3">
                    <x-forms.emoji-picker 
                        :id="'edit-icon-' . $goal->id"
                        name="icon" 
                        :value="$goal->icon"
                        label="Icon (emoji)"
                        placeholder="🎯" />
                    
                    <x-forms.form-select
                        name="category_id"
                        label="Category"
                        :value="$goal->category_id"
                        placeholder="None">
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ $goal->category_id == $cat->id ? 'selected' : '' }}>
                                {{ $cat->icon }} {{ $cat->name }}
                            </option>
                        @endforeach
                    </x-forms.form-select>
                </div>

                <x-forms.form-textarea
                    name="description"
                    label="Description"
                    placeholder="What is this goal about?"
                    :value="$goal->description"
                    rows="3"
                    optional />
            </div>

            <div class="modal-footer">
                <button type="button" 
                        @click="$dispatch('close-modal', 'edit-goal-{{ $goal->id }}')" 
                        class="btn-secondary">
                    Cancel
                </button>
                <button type="submit" class="btn-primary">
                    Update Goal
                </button>
            </div>
        </form>
    </x-ui.modal>

<!-- Cannot Delete Info Modal -->
    <x-ui.modal 
        name="cannot-delete-goal-{{ $goal->id }}"
        eyebrow="Cannot Delete" 
        title="Goal is in use"
        maxWidth="md">
        <div class="space-y-4">
            <p class="text-sm text-gray-600 dark:text-gray-400">
                This goal cannot be deleted because it is currently being used by:
            </p>
            
            <ul class="space-y-2 text-sm text-gray-600 dark:text-gray-400">
                @if($challenges->count() > 0)
                    <li class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span>{{ $challenges->count() }} challenge(s)</span>
                    </li>
                @endif
                @if($habits->count() > 0)
                    <li class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span>{{ $habits->count() }} habit(s)</span>
                    </li>
                @endif
            </ul>
            
            <p class="text-sm text-gray-600 dark:text-gray-400">
                Please remove this goal from all challenges and habits before deleting it.
            </p>
        </div>

        <div class="modal-footer">
            <button type="button" 
                    @click="$dispatch('close-modal', 'cannot-delete-goal-{{ $goal->id }}')" 
                    class="btn-primary">
                Got it
            </button>
        </div>
    </x-ui.modal>

    <!-- Delete Confirmation Modal -->
    <x-ui.modal 
        name="delete-goal-{{ $goal->id }}"
        eyebrow="Delete Goal" 
        title="Are you sure?"
        maxWidth="md">
        <div class="space-y-4">
            <p class="text-sm text-gray-600 dark:text-gray-400">
                This goal will be permanently deleted from your library. This action cannot be undone.
            </p>
        </div>

        <div class="modal-footer">
            <button type="button" 
                    @click="$dispatch('close-modal', 'delete-goal-{{ $goal->id }}')"
                    class="btn-secondary">
                Cancel
            </button>
            <form method="POST" action="{{ route('goals.destroy', $goal) }}" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-primary">
                    Delete Goal
                </button>
            </form>
        </div>
    </x-ui.modal>

    <!-- Day Details Modal -->
    <div x-data="goalDayModal('{{ \Carbon\Carbon::create($year, $month, 1)->format('F') }}', '{{ $year }}', {{ $goal->id }})" 
         @set-day-data.window="dayData = $event.detail">
        <x-ui.modal 
            name="day-details-modal"
            eyebrow="Completion Details" 
            x-bind:title="dayData && dayData.day ? monthName + ' ' + dayData.day + ', ' + year : 'Completion Details'"
            maxWidth="md">
            <template x-if="dayData">
                <div>
                    <template x-if="hasCompletions">
                        <div class="space-y-3">
                            <!-- Completions List -->
                            <div class="daily-goals-list">
                                <template x-for="(source, index) in completionSources" :key="index">
                                    <x-goal-card>
                                        <x-slot:icon>
                                            <div class="goal-display-card-icon">
                                                <span x-text="getSourceIcon(source.type)"></span>
                                            </div>
                                        </x-slot:icon>
                                        <x-slot:title>
                                            <div class="daily-goals-title">
                                                <span x-text="source.type === 'challenge' ? 'Challenge' : 'Habit'"></span>
                                                <template x-if="source.name">
                                                    <span>: <span x-text="source.name"></span></span>
                                                </template>
                                            </div>
                                        </x-slot:title>
                                        <x-slot:subtitle>
                                            <template x-if="source.completed_at">
                                                <div class="daily-goals-timestamp">
                                                    Completed at <span x-text="new Date(source.completed_at).toLocaleTimeString('en-US', { hour: 'numeric', minute: '2-digit' })"></span>
                                                </div>
                                            </template>
                                        </x-slot:subtitle>
                                        <x-slot:rightAction>
                                            <div class="daily-goals-status-icon daily-goals-status-icon--completed">
                                                <svg fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                                </svg>
                                            </div>
                                        </x-slot:rightAction>
                                    </x-goal-card>
                                </template>
                            </div>
                            
                            <!-- Summary -->
                            <div class="daily-goals-summary">
                                <div class="daily-goals-summary-text">
                                    <span class="daily-goals-summary-number" x-text="dayData.completed_count"></span>
                                    <span x-text="dayData.completed_count === 1 ? 'completion' : 'completions'"></span>
                                    from 
                                    <span x-text="completionSources.filter(s => s.type === 'challenge').length"></span> 
                                    <span x-text="completionSources.filter(s => s.type === 'challenge').length === 1 ? 'challenge' : 'challenges'"></span>
                                    and
                                    <span x-text="completionSources.filter(s => s.type === 'habit').length"></span>
                                    <span x-text="completionSources.filter(s => s.type === 'habit').length === 1 ? 'habit' : 'habits'"></span>
                                </div>
                            </div>
                        </div>
                    </template>
                    
                    <template x-if="!hasCompletions">
                        <div class="empty-state-card">
                            <div class="empty-state-icon">
                                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <h3 class="empty-state-title">
                                No completions
                            </h3>
                            <p class="empty-state-message">
                                This goal was not completed on this day
                            </p>
                        </div>
                    </template>
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
