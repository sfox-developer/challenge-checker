{{-- Quick Complete Modal Component --}}
<div
    x-data="modalData('quick-complete', false, false)"
    x-on:open-modal.window="if ($event.detail === 'quick-complete') { show = true; $store.quickComplete.open(); }"
    x-on:close-modal.window="$event.detail === 'quick-complete' && (show = false)"
    x-on:close.stop="show = false"
    x-on:keydown.escape.window="show && (show = false)"
    x-on:keydown.tab.prevent="handleTab($event)"
    @refresh-quick-goals.window="$store.quickComplete.refreshContent()"
    x-show="show"
    class="modal-wrapper"
    style="display: none;"
>
    {{-- Backdrop --}}
    <div
        x-show="show"
        x-on:click="show = false"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="modal-backdrop"
    ></div>

    {{-- Modal Content --}}
    <div
        x-show="show"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4 scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
        x-transition:leave-end="opacity-0 translate-y-4 scale-95"
        class="modal-content max-w-2xl w-full"
    >
        {{-- Top Accent Bar --}}
        <div class="modal-accent"></div>

        {{-- Close Button --}}
        <button type="button" @click="show = false" class="modal-close-button">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>

        {{-- Header --}}
        <div class="modal-header">
            <div class="modal-eyebrow">Quick Actions</div>
            <h3 class="modal-title">Complete Goals</h3>
        </div>

        <div class="modal-body">
            {{-- Tabs --}}
            <div class="tab-header">
                <nav class="tab-nav">
                    <button @click="$store.quickComplete.switchTab('all')" 
                            :class="$store.quickComplete.activeTab === 'all' ? 'tab-button active' : 'tab-button'">
                        All
                        <span class="tab-count-badge" 
                              :class="$store.quickComplete.activeTab === 'all' ? 'active' : 'inactive'"
                              x-text="$store.quickComplete.allCount"></span>
                    </button>
                    <button @click="$store.quickComplete.switchTab('challenges')" 
                            :class="$store.quickComplete.activeTab === 'challenges' ? 'tab-button active' : 'tab-button'">
                        Challenges
                        <span class="tab-count-badge" 
                              :class="$store.quickComplete.activeTab === 'challenges' ? 'active' : 'inactive'"
                              x-text="$store.quickComplete.challengesCount"></span>
                    </button>
                    <button @click="$store.quickComplete.switchTab('habits')" 
                            :class="$store.quickComplete.activeTab === 'habits' ? 'tab-button active' : 'tab-button'">
                        Habits
                        <span class="tab-count-badge" 
                              :class="$store.quickComplete.activeTab === 'habits' ? 'active' : 'inactive'"
                              x-text="$store.quickComplete.habitsCount"></span>
                    </button>
                </nav>
            </div>

            {{-- Content --}}
            <div class="mt-6" style="max-height: 60vh; overflow-y: auto;">
                <div x-show="$store.quickComplete.activeTab === 'all'" 
                     x-ref="allTab"></div>
                <div x-show="$store.quickComplete.activeTab === 'challenges'" 
                     x-ref="challengesTab"></div>
                <div x-show="$store.quickComplete.activeTab === 'habits'" 
                     x-ref="habitsTab"></div>
            </div>
        </div>

        {{-- Footer --}}
        <div class="modal-footer">
            <button type="button" 
                    @click="show = false" 
                    class="btn-secondary">
                Close
            </button>
        </div>
    </div>
</div>
