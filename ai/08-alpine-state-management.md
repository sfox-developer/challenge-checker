# Alpine.js State Management Guide

**Last Updated:** December 19, 2025  
**Purpose:** Comprehensive guide to Alpine.js global stores for reactive state management

---

## 🎯 Overview

**Alpine.js Stores** provide centralized reactive state management across components, similar to Vuex/Pinia (Vue) or Redux (React). This enables components to share state without prop drilling or complex event systems.

**When to Use Stores:**
- ✅ State needs to be shared across multiple components
- ✅ State changes frequently and needs instant UI updates
- ✅ Avoiding prop drilling through many component levels
- ✅ Need single source of truth for critical data

**When NOT to Use Stores:**
- ❌ State is only used in one component (use `x-data` instead)
- ❌ State is simple and doesn't change (use props)
- ❌ Data needs to persist across page loads (use localStorage or server)

---

## 📁 Architecture

### Folder Structure

```
resources/js/
├── stores/
│   ├── index.js              # Store registry
│   └── userDiscovery.js      # User discovery store
├── components/
│   └── follow.js             # Components that use stores
└── app.js                    # Alpine initialization
```

### File Organization Pattern

**1. Store Module** (`stores/storeName.js`)
```javascript
export function registerStoreNameStore(Alpine) {
    Alpine.store('storeName', {
        // State properties
        property: initialValue,
        
        // Methods to update state
        updateProperty(newValue) {
            this.property = newValue;
        }
    });
}
```

**2. Store Registry** (`stores/index.js`)
```javascript
import { registerStoreNameStore } from './storeName.js';

export function registerStores(Alpine) {
    registerStoreNameStore(Alpine);
    // Add more stores here
}
```

**3. App Initialization** (`app.js`)
```javascript
import { registerStores } from './stores/index.js';

Alpine.plugin(intersect);
// ... other plugins

registerStores(Alpine); // Before Alpine.start()
Alpine.start();
```

---

## 🔧 Implementation Guide

### Creating a New Store

**Step 1: Create Store Module**

```javascript
// resources/js/stores/myFeature.js

/**
 * My Feature Store
 * 
 * Description of what this store manages
 * 
 * @module stores/myFeature
 */
export function registerMyFeatureStore(Alpine) {
    Alpine.store('myFeature', {
        // State
        count: 0,
        items: [],
        isLoading: false,
        
        // Initialization (optional)
        init(initialData) {
            this.items = initialData;
        },
        
        // Mutations
        increment() {
            this.count++;
        },
        
        addItem(item) {
            this.items.push(item);
        },
        
        setLoading(state) {
            this.isLoading = state;
        }
    });
}
```

**Step 2: Register in Index**

```javascript
// resources/js/stores/index.js

import { registerMyFeatureStore } from './myFeature.js';

export function registerStores(Alpine) {
    registerUserDiscoveryStore(Alpine);
    registerMyFeatureStore(Alpine); // Add your store
}
```

**Step 3: Use in Components**

```javascript
// In JavaScript component
export function createMyComponent() {
    return {
        init() {
            // Access store
            window.Alpine.store('myFeature').increment();
        }
    }
}
```

```blade
{{-- In Blade template --}}
<div x-data="{}">
    {{-- Read from store --}}
    <span x-text="$store.myFeature.count"></span>
    
    {{-- Update store --}}
    <button @click="$store.myFeature.increment()">
        Increment
    </button>
    
    {{-- Reactive binding --}}
    <div x-show="$store.myFeature.isLoading">
        Loading...
    </div>
</div>
```

---

## 📚 Example: User Discovery Store

### Use Case
Track following count across discover page. When user follows/unfollows:
- User card updates instantly (optimistic)
- Filter tab count updates reactively
- No page refresh needed

### Store Implementation

```javascript
// resources/js/stores/userDiscovery.js

export function registerUserDiscoveryStore(Alpine) {
    Alpine.store('userDiscovery', {
        followingCount: 0,
        
        init(followingCount) {
            this.followingCount = followingCount;
        },
        
        incrementFollowing() {
            this.followingCount++;
        },
        
        decrementFollowing() {
            this.followingCount--;
        }
    });
}
```

### Component Integration

```javascript
// resources/js/components/follow.js

// Update store when follow succeeds
if (data.isFollowing) {
    window.Alpine.store('userDiscovery').incrementFollowing();
} else {
    window.Alpine.store('userDiscovery').decrementFollowing();
}
```

### Template Usage

```blade
{{-- Initialize store with server data --}}
<div x-data="{
    init() {
        $store.userDiscovery.init({{ $followingCount }});
    }
}">
    {{-- Reactive count display --}}
    <span x-text="$store.userDiscovery.followingCount"></span>
    
    {{-- Reactive disabled state --}}
    <button :disabled="$store.userDiscovery.followingCount === 0">
        Following
    </button>
</div>
```

---

## 🎨 Best Practices

### 1. Store Naming
- Use camelCase for store names: `userDiscovery`, `notificationCenter`
- Name should describe the domain/feature it manages
- Keep names concise but descriptive

### 2. State Design
- Keep state flat when possible
- Use arrays for lists, objects for complex entities
- Initialize with sensible defaults
- Document what each property represents

### 3. Mutation Methods
- Name methods as actions: `increment()`, `addItem()`, `setLoading()`
- Methods should be synchronous
- Handle async operations in components, update store with results
- Keep mutation logic simple and focused

### 4. Initialization
- Provide `init()` method if store needs server data
- Call from component that mounts first (usually filter tabs, header, etc.)
- Initialize only once per page load
- Consider race conditions if multiple components initialize

### 5. Type Safety (Documentation)
```javascript
/**
 * @typedef {Object} UserDiscoveryState
 * @property {number} followingCount - Count of users being followed
 */

/**
 * @param {number} followingCount - Initial following count
 */
init(followingCount) {
    this.followingCount = followingCount;
}
```

---

## 🔄 Store vs Component State

### Use Alpine.store() When:
- Multiple components need same state
- State updates from different places
- Centralized logic for state changes
- Need reactive updates across component boundaries

### Use x-data When:
- State is local to one component
- No other components need access
- State is simple and ephemeral
- Component is self-contained

### Example Comparison

**Component State (Local):**
```blade
<div x-data="{ isOpen: false }">
    <button @click="isOpen = !isOpen">Toggle</button>
    <div x-show="isOpen">Content</div>
</div>
```

**Global Store (Shared):**
```blade
<div x-data="{}">
    <button @click="$store.sidebar.toggle()">Toggle Sidebar</button>
</div>

<!-- Somewhere else in the app -->
<aside x-show="$store.sidebar.isOpen">
    Sidebar content
</aside>
```

---

## 🚨 Common Pitfalls

### 1. Forgetting to Initialize
```javascript
// ❌ Wrong - store not initialized
<span x-text="$store.myStore.count"></span>

// ✅ Correct - initialize first
<div x-data="{ init() { $store.myStore.init(0); } }">
    <span x-text="$store.myStore.count"></span>
</div>
```

### 2. Mutating State Directly from Template
```blade
{{-- ❌ Wrong - complex logic in template --}}
<button @click="$store.items.count++; $store.items.updated = true;">

{{-- ✅ Correct - use store method --}}
<button @click="$store.items.increment()">
```

### 3. Async Operations in Store
```javascript
// ❌ Wrong - async in store
Alpine.store('data', {
    async fetchData() {
        const response = await fetch('/api/data');
        this.data = await response.json();
    }
});

// ✅ Correct - async in component, update store with results
export function createMyComponent() {
    return {
        async fetchData() {
            const response = await fetch('/api/data');
            const data = await response.json();
            window.Alpine.store('data').setData(data);
        }
    }
}
```

### 4. Over-using Stores
```javascript
// ❌ Wrong - everything in store
Alpine.store('pageState', {
    modalOpen: false,      // Could be local
    searchQuery: '',       // Could be local
    userFollowingCount: 0  // ✓ This should be in store
});

// ✅ Correct - only shared state in store
Alpine.store('userDiscovery', {
    followingCount: 0
});
```

---

## 🧪 Testing Stores

### Manual Testing Checklist
- [ ] Store initializes with correct default values
- [ ] `init()` method updates state correctly
- [ ] Mutation methods update state as expected
- [ ] Multiple components react to store changes
- [ ] Store persists across component re-renders
- [ ] No race conditions with concurrent updates

### Browser Console Testing
```javascript
// Access store in console
Alpine.store('userDiscovery')

// Check state
Alpine.store('userDiscovery').followingCount

// Trigger mutation
Alpine.store('userDiscovery').incrementFollowing()

// Verify update
Alpine.store('userDiscovery').followingCount // Should increment
```

---

## 📖 Further Reading

- **Alpine.js Stores Documentation**: https://alpinejs.dev/globals/alpine-store
- **State Management Patterns**: Similar to Vuex (Vue) and Redux (React)
- **Project Architecture**: See `ai/01-architecture.md` for folder structure
- **Component Integration**: See `ai/04-blade-components.md` for usage examples

---

## 🎓 Summary

**Alpine.js stores provide:**
- ✅ Centralized reactive state management
- ✅ Component communication without events
- ✅ Single source of truth
- ✅ Instant UI updates across boundaries

**Key Principles:**
1. One store per feature/domain
2. Keep stores in `resources/js/stores/`
3. Register before `Alpine.start()`
4. Initialize with server data where needed
5. Use for shared state only

**Pattern:** Store → Component → Template
```
Store (State) → Component (Logic) → Template (UI)
     ↑                                     ↓
     └──────────── Reactive Updates ──────┘
```
