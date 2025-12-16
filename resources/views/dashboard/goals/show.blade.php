<x-dashboard-layout>
    <x-slot name="title">{{ $goal->name }}</x-slot>

    <x-dashboard.page-header 
        eyebrow="Goal Library"
        :title="$goal->name"
        :description="$goal->category ? $goal->category->name : 'Goal details and usage'" />

    <div class="pb-12 md:pb-20">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Goal Info Card -->
            <div class="card">
                <div class="flex items-start gap-4 mb-4">
                    <div class="text-5xl">{{ $goal->icon ?? '🎯' }}</div>
                    <div class="flex-1">
                        <h2 class="h1 mb-2">{{ $goal->name }}</h2>
                        
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
                <x-ui.stat-card label="Total Completions" :value="$stats['total_completions']" />
                
                <x-ui.stat-card label="Avg Success Rate" :value="$stats['success_rate']">
                    <x-slot name="suffix">%</x-slot>
                </x-ui.stat-card>
                
                <x-ui.stat-card label="Active Challenges" :value="$stats['active_challenges']" />
                
                <x-ui.stat-card label="Active Habits" :value="$stats['active_habits']" />
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
                    <div class="card text-center py-12">
                        <div class="text-6xl mb-4">📅</div>
                        <h3 class="h2 mb-2">
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
                            <x-habits.habit-list-item :habit="$habit" />
                        @endforeach
                    </div>
                @else
                    <div class="card text-center py-12">
                        <div class="text-6xl mb-4">✅</div>
                        <h3 class="h2 mb-2">
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
                    <h3 class="h2 mb-2">
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
                    label="Goal Name *"
                    :value="$goal->name"
                    required />

                <x-forms.form-textarea
                    name="description"
                    label="Description"
                    :value="$goal->description"
                    rows="3"
                    optional />

                <div class="grid grid-cols-2 gap-4">
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

                    <x-forms.emoji-picker 
                        :id="'edit-icon-' . $goal->id"
                        name="icon" 
                        :value="$goal->icon"
                        label="Icon (emoji)"
                        placeholder="🎯" />
                </div>
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
</x-dashboard-layout>
