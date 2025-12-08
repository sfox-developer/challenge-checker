<x-app-layout>
    <x-slot name="header">
        <x-page-header :title="$goal->name" gradient="primary">
            <x-slot name="icon">
                <span class="text-4xl">{{ $goal->icon ?? '🎯' }}</span>
            </x-slot>
            <x-slot name="action">
                <div class="flex gap-2">
                    <x-app-button variant="secondary" @click="$dispatch('open-modal', 'edit-goal-{{ $goal->id }}')">
                        <x-slot name="icon">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                            </svg>
                        </x-slot>
                        Edit Goal
                    </x-app-button>
                    
                    <a href="{{ route('goals.index') }}" class="btn-secondary">
                        Back to Library
                    </a>
                </div>
            </x-slot>
        </x-page-header>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Goal Info Card -->
            <div class="card">
                <div class="flex items-start gap-4 mb-4">
                    <div class="text-5xl">{{ $goal->icon ?? '🎯' }}</div>
                    <div class="flex-1">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">{{ $goal->name }}</h2>
                        
                        @if($goal->description)
                            <p class="text-gray-600 dark:text-gray-400 mb-3">{{ $goal->description }}</p>
                        @endif

                        <div class="flex flex-wrap items-center gap-2">
                            @if($goal->category)
                                <span class="badge-primary">
                                    {{ $goal->category->icon }} {{ $goal->category->name }}
                                </span>
                            @endif

                            <span class="count-badge">
                                {{ $challenges->count() }} Challenge{{ $challenges->count() !== 1 ? 's' : '' }}
                            </span>

                            <span class="count-badge-primary">
                                {{ $habits->count() }} Habit{{ $habits->count() !== 1 ? 's' : '' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="card">
                    <div class="text-sm text-gray-600 dark:text-gray-400 mb-1">Total Completions</div>
                    <div class="text-3xl font-bold text-gray-900 dark:text-white">{{ $stats['total_completions'] }}</div>
                </div>

                <div class="card">
                    <div class="text-sm text-gray-600 dark:text-gray-400 mb-1">Avg Success Rate</div>
                    <div class="text-3xl font-bold text-gray-900 dark:text-white">{{ $stats['success_rate'] }}%</div>
                </div>

                <div class="card">
                    <div class="text-sm text-gray-600 dark:text-gray-400 mb-1">Active Challenges</div>
                    <div class="text-3xl font-bold text-slate-700 dark:text-slate-400">{{ $stats['active_challenges'] }}</div>
                </div>

                <div class="card">
                    <div class="text-sm text-gray-600 dark:text-gray-400 mb-1">Active Habits</div>
                    <div class="text-3xl font-bold text-slate-700 dark:text-slate-400">{{ $stats['active_habits'] }}</div>
                </div>
            </div>

            <!-- Timeline Info -->
            @if($stats['first_used'] || $stats['last_active'])
                <div class="card">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @if($stats['first_used'])
                            <div>
                                <div class="text-sm text-gray-600 dark:text-gray-400 mb-1">First Used</div>
                                <div class="text-lg font-semibold text-gray-900 dark:text-white">
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
                                <div class="text-lg font-semibold text-gray-900 dark:text-white">
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

            <!-- Tabs -->
            <div x-data="{ activeTab: 'challenges' }">
                <!-- Tab Navigation -->
                <div class="card card-no-padding mb-4">
                    <nav class="flex -mb-px">
                        <button @click="activeTab = 'challenges'" 
                                :class="activeTab === 'challenges' ? 'border-slate-600 text-slate-700 dark:text-slate-400' : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-100 hover:border-gray-300 dark:hover:border-gray-600'"
                                class="w-1/2 py-4 px-1 text-center border-b-2 font-medium text-sm transition-colors duration-150">
                            Challenges
                            <span class="tab-count-badge" :class="activeTab === 'challenges' ? 'active' : 'inactive'">
                                {{ $challenges->count() }}
                            </span>
                        </button>
                        <button @click="activeTab = 'habits'" 
                                :class="activeTab === 'habits' ? 'border-teal-500 text-slate-700 dark:text-slate-400' : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-100 hover:border-gray-300 dark:hover:border-gray-600'"
                                class="w-1/2 py-4 px-1 text-center border-b-2 font-medium text-sm transition-colors duration-150">
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
                            <x-challenge-list-item :challenge="$challenge" />
                        @endforeach
                    </div>
                @else
                    <div class="card text-center py-12">
                        <div class="text-6xl mb-4">📅</div>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">
                            No challenges yet
                        </h3>
                        <p class="text-gray-600 dark:text-gray-400">
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
                            <a href="{{ route('habits.show', $habit) }}" 
                               class="block p-4 rounded-lg border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                <div class="flex items-start justify-between gap-4">
                                    <div class="flex-1 min-w-0">
                                        <h4 class="font-semibold text-gray-900 dark:text-white mb-1">{{ $habit->title }}</h4>
                                        
                                        @if($habit->description)
                                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">
                                                {{ Str::limit($habit->description, 100) }}
                                            </p>
                                        @endif

                                        <div class="flex flex-wrap items-center gap-2 text-sm">
                                            <!-- Status Badge -->
                                            @if($habit->is_archived)
                                                <span class="badge-habit-archived">Archived</span>
                                            @else
                                                <span class="badge-habit-active">Active</span>
                                            @endif

                                            <span class="text-gray-600 dark:text-gray-400">
                                                {{ $habit->getFrequencyDescription() }}
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Streak -->
                                    @if(!$habit->is_archived && $habit->statistics)
                                        <div class="text-right">
                                            <div class="text-2xl font-bold text-slate-700 dark:text-slate-400">
                                                {{ $habit->statistics->current_streak }}
                                            </div>
                                            <div class="text-xs text-gray-600 dark:text-gray-400">Day Streak</div>
                                        </div>
                                    @endif
                                </div>
                            </a>
                        @endforeach
                    </div>
                @else
                    <div class="card text-center py-12">
                        <div class="text-6xl mb-4">✅</div>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">
                            No habits yet
                        </h3>
                        <p class="text-gray-600 dark:text-gray-400">
                            This goal hasn't been used in any habits
                        </p>
                    </div>
                @endif
            </div>
            </div>

            <!-- Empty State - When both are empty -->
            @if($challenges->count() === 0 && $habits->count() === 0)
                <div class="card text-center py-12">
                    <div class="text-6xl mb-4">{{ $goal->icon ?? '🎯' }}</div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">
                        This goal hasn't been used yet
                    </h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-6">
                        Start using "{{ $goal->name }}" by adding it to a challenge or habit
                    </p>
                </div>
            @endif

        </div>
    </div>

    <!-- Edit Goal Modal -->
    <x-modal name="edit-goal-{{ $goal->id }}" maxWidth="2xl">
        <div class="modal-header">
            <div class="modal-header-title">
                <h3>Edit Goal</h3>
                <button type="button" @click="$dispatch('close-modal', 'edit-goal-{{ $goal->id }}')" class="text-white hover:text-gray-200 text-2xl font-bold leading-none">&times;</button>
            </div>
        </div>
        
        <div class="modal-content">
            <form method="POST" action="{{ route('goals.update', $goal) }}">
                @csrf
                @method('PUT')

            <x-form-input
                name="name"
                label="Goal Name *"
                :value="$goal->name"
                required
                class="mb-4" />

            <x-form-textarea
                name="description"
                label="Description"
                :value="$goal->description"
                rows="3"
                optional
                class="mb-4" />

            <div class="grid grid-cols-2 gap-4 mb-4">
                <x-form-select
                    name="category_id"
                    label="Category"
                    :value="$goal->category_id"
                    placeholder="None">
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ $goal->category_id == $cat->id ? 'selected' : '' }}>
                            {{ $cat->icon }} {{ $cat->name }}
                        </option>
                    @endforeach
                </x-form-select>

                <div>
                    <x-emoji-picker 
                        :id="'edit-icon-' . $goal->id"
                        name="icon" 
                        :value="$goal->icon"
                        label="Icon (emoji)"
                        placeholder="🎯" />
                </div>
            </div>

                <div class="mt-6 flex justify-end gap-3">
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
        </div>
        </form>
    </x-modal>
</x-app-layout>
