<x-dashboard-layout>
    <x-slot name="title">Activity Feed</x-slot>

    <x-dashboard.page-header 
        eyebrow="Community"
        title="Feed"
        description="See what others are achieving in their challenges" />

    <!-- Content -->
    <div class="pb-12 md:pb-20 flex-1">
        <div class="max-w-4xl mx-auto px-6">
            <div class="space-y-4">
                @forelse($activities as $index => $activity)
                    <div class="animate animate-hidden-fade-up"
                         x-data="{}"
                         x-intersect="setTimeout(() => $el.classList.remove('animate-hidden-fade-up'), {{ ($index % 5) * 100 }})">
                        <x-social.activity-card :activity="$activity" />
                    </div>
                @empty
                    <div class="empty-state-card animate animate-hidden-fade-up"
                         x-data="{}"
                         x-init="setTimeout(() => { $el.classList.remove('animate-hidden-fade-up') }, 100)">
                        <div class="empty-state-icon">
                            <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                            </svg>
                        </div>
                        <h3 class="empty-state-title">No activities yet</h3>
                        <p class="empty-state-message">Follow other users to see their activities in your feed!</p>
                        <x-ui.app-button variant="primary" href="{{ route('users.search') }}">
                            <x-slot name="icon">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </x-slot>
                            Find Users
                        </x-ui.app-button>
                    </div>
                @endforelse

                <!-- Pagination -->
                @if($activities->hasPages())
                    <div class="mt-6 animate animate-hidden-fade"
                         x-data="{}"
                         x-intersect="$el.classList.remove('animate-hidden-fade')">
                        {{ $activities->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-dashboard-layout>
