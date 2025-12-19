@props(['allCount', 'followingCount'])

<div class="tab-header animate animate-hidden-fade-up"
     x-data="{}"
     x-intersect="setTimeout(() => $el.classList.remove('animate-hidden-fade-up'), 600)">
    <nav class="tab-nav">
        <button @click="activeFilter = 'all'" :class="activeFilter === 'all' ? 'tab-button active' : 'tab-button'" @if($allCount === 0) disabled @endif>
            All Users
            <span class="tab-count-badge" :class="activeFilter === 'all' ? 'active' : 'inactive'">
                {{ $allCount }}
            </span>
        </button>
        <button @click="activeFilter = 'following'" :class="activeFilter === 'following' ? 'tab-button active' : 'tab-button'" @if($followingCount === 0) disabled @endif>
            Following
            <span class="tab-count-badge" :class="activeFilter === 'following' ? 'active' : 'inactive'">
                {{ $followingCount }}
            </span>
        </button>
    </nav>
</div>
