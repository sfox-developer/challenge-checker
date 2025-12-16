@props(['search' => null, 'categoryId' => null])

<div class="empty-state-card animate animate-hidden-scale-up"
        x-data="{}"
        x-intersect="$el.classList.remove('animate-hidden-scale-up')">
    <div class="empty-state-icon">
        <svg fill="currentColor" viewBox="0 0 20 20">
            <path d="M5 4a1 1 0 00-2 0v7.268a2 2 0 000 3.464V16a1 1 0 102 0v-1.268a2 2 0 000-3.464V4zM11 4a1 1 0 10-2 0v1.268a2 2 0 000 3.464V16a1 1 0 102 0V8.732a2 2 0 000-3.464V4zM16 3a1 1 0 011 1v7.268a2 2 0 010 3.464V16a1 1 0 11-2 0v-1.268a2 2 0 010-3.464V4a1 1 0 011-1z"/>
        </svg>
    </div>
    <h3 class="empty-state-title">
        @if($search || $categoryId)
            No goals found
        @else
            Build Your Goal Library
        @endif
    </h3>
    <p class="empty-state-text">
        @if($search || $categoryId)
            Try adjusting your search or filters to find what you're looking for.
        @else
            Create reusable goals to quickly build challenges and habits with consistent tracking.
        @endif
    </p>
    @if(!$search && !$categoryId)
        <div class="empty-state-cta">
            <x-ui.app-button variant="primary" @click="$dispatch('open-modal', 'create-goal')">
                <x-slot name="icon">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"/>
                    </svg>
                </x-slot>
                Add Your First Goal
            </x-ui.app-button>
        </div>
    @endif
</div>
