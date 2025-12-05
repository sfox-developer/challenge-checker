@props([
    'user',
    'challenges',
    'activities',
    'defaultTab' => 'activity'
])

<div x-data="{ activeTab: '{{ $defaultTab }}' }">
    <!-- Tab Navigation -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm mb-4">
        <nav class="flex -mb-px border-b border-gray-200 dark:border-gray-700">
            <button @click="activeTab = 'activity'" 
                    :class="activeTab === 'activity' ? 'border-blue-500 text-blue-600 dark:text-blue-400' : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-600'"
                    class="w-1/2 py-4 px-1 text-center border-b-2 font-medium text-sm transition-colors duration-150">
                    Activity
                <span class="ml-2 px-2 py-1 text-xs rounded-full" :class="activeTab === 'activity' ? 'bg-blue-100 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400' : 'bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400'">
                    {{ $activities->total() }}
                </span>
            </button>
            <button @click="activeTab = 'challenges'" 
                    :class="activeTab === 'challenges' ? 'border-blue-500 text-blue-600 dark:text-blue-400' : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-600'"
                    class="w-1/2 py-4 px-1 text-center border-b-2 font-medium text-sm transition-colors duration-150">
                    Challenges
                <span class="ml-2 px-2 py-1 text-xs rounded-full" :class="activeTab === 'challenges' ? 'bg-blue-100 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400' : 'bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400'">
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
            <div class="card">
                <div class="text-center py-8">
                    <div class="bg-gray-100 dark:bg-gray-700 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-800 dark:text-gray-100 mb-2">No activities yet</h3>
                    <p class="text-gray-600 dark:text-gray-400">{{ $user->name }} hasn't logged any activities yet.</p>
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
            <x-challenge-list-item :challenge="$challenge" />
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
