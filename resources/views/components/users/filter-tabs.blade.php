@props(['allCount', 'followingCount'])

<div class="tab-header animate animate-hidden-fade-up"
     x-data="{
         init() {
             // Initialize global store with server-side count
             if ($store.userDiscovery) {
                 $store.userDiscovery.init({{ $followingCount }});
             }
         }
     }"
     x-intersect="setTimeout(() => $el.classList.remove('animate-hidden-fade-up'), 600)">
    <nav class="tab-nav">
        <button @click="activeFilter = 'all'" :class="activeFilter === 'all' ? 'tab-button active' : 'tab-button'" @if($allCount === 0) disabled @endif>
            All Users
            <span class="tab-count-badge" :class="activeFilter === 'all' ? 'active' : 'inactive'">
                {{ $allCount }}
            </span>
        </button>
        <button @click="activeFilter = 'following'" :class="activeFilter === 'following' ? 'tab-button active' : 'tab-button'" :disabled="$store.userDiscovery.followingCount === 0">
            Following
            <span class="tab-count-badge" :class="activeFilter === 'following' ? 'active' : 'inactive'">
                <span x-text="$store.userDiscovery.followingCount"></span>
            </span>
        </button>
    </nav>
</div>
