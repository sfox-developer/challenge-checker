@props([
    'user',
    'challenges',
    'activities',
    'defaultTab' => 'activity',
    'adminView' => false
])

<div x-data="{ activeTab: '{{ $defaultTab }}' }">
    <!-- Tab Navigation -->
    <div class="tab-header">
        <nav class="tab-nav">
            <button @click="activeTab = 'activity'" 
                    :class="activeTab === 'activity' ? 'tab-button active' : 'tab-button'">
                Activity
                <span class="tab-count-badge" :class="activeTab === 'activity' ? 'active' : 'inactive'">
                    {{ $activities->total() }}
                </span>
            </button>
            <button @click="activeTab = 'challenges'" 
                    :class="activeTab === 'challenges' ? 'tab-button active' : 'tab-button'">
                Challenges
                <span class="tab-count-badge" :class="activeTab === 'challenges' ? 'active' : 'inactive'">
                    @if(is_countable($challenges))
                        {{ count($challenges) }}
                    @else
                        {{ $challenges->total() }}
                    @endif
                </span>
            </button>
        </nav>
    </div>

    <!-- Activity Tab -->
    <div x-show="activeTab === 'activity'" class="space-y-4" x-cloak>
        @forelse($activities as $activity)
            <x-activity-card :activity="$activity" />
        @empty
            <div class="empty-state-card">
                <div class="empty-state-icon">
                    <svg class="w-16 h-16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                    </svg>
                </div>
                <h3 class="empty-state-title">No activities yet</h3>
                <p class="empty-state-message">{{ $user->name }} hasn't logged any activities yet.</p>
            </div>
            </div>
        @endforelse

        <!-- Pagination -->
        @if($activities->hasPages())
            <div class="mt-6">
                {{ $activities->links('pagination::tailwind', ['pageName' => 'activities_page']) }}
            </div>
        @endif
    </div>

    <!-- Challenges Tab -->
    <div x-show="activeTab === 'challenges'" class="space-y-4" style="display: none;" x-cloak>
        @forelse($challenges as $challenge)
            <x-challenge-list-item :challenge="$challenge" :adminView="$adminView" />
        @empty
            <div class="card">
                <div class="text-center py-8">
                    <div class="bg-gray-100 dark:bg-gray-700 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-800 dark:text-gray-100 mb-2">No challenges</h3>
                    <p class="text-gray-600 dark:text-gray-400">{{ $user->name }} hasn't created any challenges yet.</p>
                </div>
            </div>
        @endforelse

        <!-- Pagination -->
        @if(method_exists($challenges, 'hasPages') && $challenges->hasPages())
            <div class="mt-6">
                {{ $challenges->links('pagination::tailwind', ['pageName' => 'challenges_page']) }}
            </div>
        @endif
    </div>
</div>
