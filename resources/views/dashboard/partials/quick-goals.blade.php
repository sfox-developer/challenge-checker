@if($activeChallenges->isNotEmpty())
    <div class="space-y-6">
        @foreach($activeChallenges as $challenge)
            <div>
                <h4 class="font-bold text-lg text-gray-800 dark:text-gray-100 mb-3 px-2">{{ $challenge->name }}</h4>
                <x-goals.goals-tracker 
                    :challenge="$challenge" 
                    :goals="$challenge->goals" />
            </div>
        @endforeach
    </div>
@else
    <div class="empty-state">
        <div class="empty-state-icon">
            <svg class="w-16 h-16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
        </div>
        <h3 class="empty-state-title">No active challenges</h3>
        <p class="empty-state-message">You don't have any active challenges right now.</p>
        <div class="empty-state-action">
            <x-ui.app-button href="{{ route('challenges.create') }}">
                <x-slot name="icon">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"></path>
                    </svg>
                </x-slot>
                Create Your First Challenge
            </x-ui.app-button>
        </div>
@endif
