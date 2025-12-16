@props(['allCount', 'activeCount', 'pausedCount', 'completedCount', 'draftCount', 'archivedCount'])

<div class="tab-header animate animate-hidden-fade-up"
     x-data="{}"
     x-intersect="setTimeout(() => $el.classList.remove('animate-hidden-fade-up'), 600)">
    <nav class="tab-nav">
        <button @click="activeFilter = 'all'" :class="activeFilter === 'all' ? 'tab-button active' : 'tab-button'" :disabled="{{ $allCount === 0 }}">
            All
            <span class="tab-count-badge" :class="activeFilter === 'all' ? 'active' : 'inactive'">
                {{ $allCount }}
            </span>
        </button>
        <button @click="activeFilter = 'active'" :class="activeFilter === 'active' ? 'tab-button active' : 'tab-button'" :disabled="{{ $activeCount === 0 }}">
            Active
            <span class="tab-count-badge" :class="activeFilter === 'active' ? 'active' : 'inactive'">
                {{ $activeCount }}
            </span>
        </button>
        <button @click="activeFilter = 'paused'" :class="activeFilter === 'paused' ? 'tab-button active' : 'tab-button'" :disabled="{{ $pausedCount === 0 }}">
            Paused
            <span class="tab-count-badge" :class="activeFilter === 'paused' ? 'active' : 'inactive'">
                {{ $pausedCount }}
            </span>
        </button>
        <button @click="activeFilter = 'completed'" :class="activeFilter === 'completed' ? 'tab-button active' : 'tab-button'" :disabled="{{ $completedCount === 0 }}">
            Completed
            <span class="tab-count-badge" :class="activeFilter === 'completed' ? 'active' : 'inactive'">
                {{ $completedCount }}
            </span>
        </button>
        <button @click="activeFilter = 'draft'" :class="activeFilter === 'draft' ? 'tab-button active' : 'tab-button'" :disabled="{{ $draftCount === 0 }}">
            Draft
            <span class="tab-count-badge" :class="activeFilter === 'draft' ? 'active' : 'inactive'">
                {{ $draftCount }}
            </span>
        </button>
        <button @click="activeFilter = 'archived'" :class="activeFilter === 'archived' ? 'tab-button active' : 'tab-button'" :disabled="{{ $archivedCount === 0 }}">
            Archived
            <span class="tab-count-badge" :class="activeFilter === 'archived' ? 'active' : 'inactive'">
                {{ $archivedCount }}
            </span>
        </button>
    </nav>
</div>
