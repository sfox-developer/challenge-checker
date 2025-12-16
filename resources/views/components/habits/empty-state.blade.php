<div class="empty-state-card animate animate-hidden-scale-up"
     x-data="{}"
     x-intersect="$el.classList.remove('animate-hidden-scale-up')">
    <div class="empty-state-icon">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
        </svg>
    </div>
    <h3 class="empty-state-title">Ready to Build Better Habits?</h3>
    <p class="empty-state-text">Start tracking your first habit with flexible frequency options and build lasting positive routines.</p>
    <div class="empty-state-cta">
        <x-ui.app-button variant="primary" href="{{ route('habits.create') }}">
            <x-slot name="icon">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"/>
                </svg>
            </x-slot>
            Create Your First Habit
        </x-ui.app-button>
    </div>
</div>
