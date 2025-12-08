# CSS Component Classes - Usage Guide

## Purpose

This document provides quick reference examples for using the reusable CSS classes in Challenge Checker. These classes minimize repetitive Tailwind utility classes and ensure consistency across the application.

---

## When to Use CSS Classes vs. Tailwind

### Use CSS Classes When:
- ✅ The pattern appears 3+ times across the app
- ✅ The styling has semantic meaning (e.g., "badge-completed", "page-header")
- ✅ You want dark mode handled automatically
- ✅ The pattern might need global style updates

### Use Tailwind Classes When:
- ✅ The styling is unique to one component
- ✅ You need precise spacing/sizing adjustments
- ✅ You're prototyping and exploring designs
- ✅ The pattern is too simple to warrant a class

---

## Common Patterns & Examples

### 1. Challenge/Habit Status Badges

**Before (Tailwind utilities):**
```blade
<span class="px-3 py-1 text-sm font-bold rounded-full bg-green-500 text-white">
    ✓ Completed
</span>
<span class="px-3 py-1 text-sm font-bold rounded-full bg-orange-100 dark:bg-orange-900/20 text-orange-800 dark:text-orange-400">
    🏃 Active
</span>
```

**After (CSS classes):**
```blade
<span class="badge-completed">✓ Completed</span>
<span class="badge-challenge-active">🏃 Active</span>
<span class="badge-challenge-paused">⏸️ Paused</span>
<span class="badge-challenge-draft">Draft</span>
<span class="badge-challenge-archived">📁 Archived</span>
```

**Status Badge Priority (use highest matching state):**
1. Archived (permanent state)
2. Completed (final state for challenges)
3. Active (currently running)
4. Paused (temporarily stopped)
5. Draft (not started - challenges only)

### 2. Page Headers

**Before:**
```blade
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center space-y-4 sm:space-y-0">
    <div class="flex items-center space-x-3">
        <div class="bg-gradient-to-r from-blue-500 to-purple-500 p-2 rounded-lg flex-shrink-0">
            <svg class="w-6 h-6 text-white">...</svg>
        </div>
        <h2 class="font-bold text-xl sm:text-2xl text-gray-800 dark:text-gray-100 leading-tight">
            My Challenges
        </h2>
    </div>
</div>
```

**After:**
```blade
<div class="page-header">
    <div class="page-header-content">
        <div class="page-header-icon gradient-blue-purple">
            <svg class="w-6 h-6 text-white">...</svg>
        </div>
        <h2 class="page-header-title">My Challenges</h2>
    </div>
</div>
```

### 3. Section Headers

**Before:**
```blade
<h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
    Statistics
</h3>
<h4 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-3">
    Completed Goals
</h4>
```

**After:**
```blade
<h3 class="section-header">Statistics</h3>
<h4 class="section-header-sm">Completed Goals</h4>
```

### 4. Empty States

**Before:**
```blade
<div class="text-center py-12">
    <div class="text-6xl mb-4">📅</div>
    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">
        No challenges yet
    </h3>
    <p class="text-gray-600 dark:text-gray-400 mb-6">
        Create your first challenge to get started
    </p>
    <div class="mt-6">
        <x-app-button href="/challenges/create">Create Challenge</x-app-button>
    </div>
</div>
```

**After:**
```blade
<div class="empty-state">
    <div class="empty-state-icon">📅</div>
    <h3 class="empty-state-title">No challenges yet</h3>
    <p class="empty-state-message">Create your first challenge to get started</p>
    <div class="empty-state-action">
        <x-app-button href="/challenges/create">Create Challenge</x-app-button>
    </div>
</div>
```

### 5. Links

**Before:**
```blade
<a href="/challenge/1" class="text-blue-600 hover:text-blue-500 font-medium whitespace-nowrap">
    View →
</a>

<a href="/settings" class="inline-flex items-center space-x-2 text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 transition-colors duration-150">
    <svg class="w-4 h-4">...</svg>
    <span>Settings</span>
</a>
```

**After:**
```blade
<a href="/challenge/1" class="link-arrow">View</a>

<a href="/settings" class="link-with-icon">
    <svg class="w-4 h-4">...</svg>
    <span>Settings</span>
</a>
```

### 6. App Layout & Modals

**Before (Body wrapper - 9 classes):**
```blade
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50 dark:from-gray-900 dark:to-gray-800 pb-16 sm:pb-0 flex flex-col">
    <!-- Content -->
</div>
```

**After:**
```blade
<div class="app-container">
    <!-- Content -->
</div>
```

**Before (Floating Action Button - 13+ classes):**
```blade
<button class="hidden sm:flex fixed bottom-8 right-8 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white rounded-full p-4 shadow-2xl hover:shadow-2xl transform hover:scale-110 transition-all duration-200 z-50 items-center justify-center group">
    <svg class="w-6 h-6">...</svg>
    <span class="absolute right-full mr-3 px-3 py-1 bg-gray-900 text-white text-sm rounded-lg whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity duration-200">
        Quick Complete
    </span>
</button>
```

**After:**
```blade
<button class="fab">
    <svg class="w-6 h-6">...</svg>
    <span class="fab-tooltip">Quick Complete</span>
</button>
```

**Before (Modal - 40+ classes total):**
```blade
<div class="fixed inset-0 z-50 overflow-y-auto" x-show="showModal">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20">
        <div class="fixed inset-0 transition-opacity bg-gray-500 dark:bg-gray-900 bg-opacity-75 dark:bg-opacity-75" @click="showModal = false"></div>
        
        <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-gradient-to-r from-blue-600 to-purple-600 px-6 py-4">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-white">Quick Complete</h3>
                    <button @click="showModal = false" class="text-white hover:text-gray-200">×</button>
                </div>
            </div>
            
            <div class="border-b border-gray-200 dark:border-gray-700">
                <nav class="flex space-x-4 px-6">
                    <button :class="activeTab === 'goals' ? 'border-b-2 border-blue-500 text-blue-600 dark:text-blue-400 py-3 px-1 font-medium' : 'border-b-2 border-transparent text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-600 py-3 px-1'">
                        Goals
                    </button>
                </nav>
            </div>
            
            <div class="px-6 py-4 max-h-96 overflow-y-auto bg-white dark:bg-gray-800">
                <!-- Content -->
            </div>
        </div>
    </div>
</div>
```

**After:**
```blade
<div class="modal-overlay" x-show="showModal">
    <div class="modal-container">
        <div class="modal-backdrop" @click="showModal = false"></div>
        
        <div class="modal-panel">
            <div class="modal-header">
                <div class="modal-header-title">
                    <h3>Quick Complete</h3>
                    <button @click="showModal = false">×</button>
                </div>
            </div>
            
            <div class="modal-tabs">
                <nav>
                    <button :class="activeTab === 'goals' ? 'modal-tab active-blue' : 'modal-tab'">
                        Goals
                    </button>
                </nav>
            </div>
            
            <div class="modal-content">
                <!-- Content -->
            </div>
        </div>
    </div>
</div>
```

### 7. Mobile Bottom Navigation

**Before:**
```blade
<nav class="fixed bottom-0 left-0 right-0 z-40 bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 shadow-lg">
    <div class="grid grid-cols-5 h-16">
        <a href="/feed" class="flex flex-col items-center justify-center space-y-1 text-blue-600">
            <svg class="w-6 h-6">...</svg>
            <span class="text-xs font-medium">Feed</span>
        </a>
    </div>
</nav>
```

**After:**
```blade
<nav class="bottom-nav">
    <div class="bottom-nav-grid">
        <a href="/feed" class="bottom-nav-item active">
            <svg>...</svg>
            <span>Feed</span>
        </a>
    </div>
</nav>
```

### 7. Tabs

**Before:**
```blade
<div class="border-b border-gray-200 dark:border-gray-700">
    <nav class="flex">
        <button class="w-1/2 py-4 px-1 text-center border-b-2 border-blue-500 text-blue-600 dark:text-blue-400 font-medium text-sm">
            Challenges
        </button>
        <button class="w-1/2 py-4 px-1 text-center border-b-2 border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-100 font-medium text-sm">
            Habits
        </button>
    </nav>
</div>
```

**After:**
```blade
<div class="tab-header">
    <nav class="tab-nav">
        <button class="tab-button active">Challenges</button>
        <button class="tab-button">Habits</button>
    </nav>
</div>
```

---

## Migration Guide

### Step 1: Identify Patterns
Look for repeated Tailwind utility combinations in your views:
- Multiple instances of the same color/size combinations
- Consistent spacing/sizing patterns
- Repeated dark mode variants

### Step 2: Choose the Right Class
Consult the class reference in `06-frontend-components.md` to find the appropriate CSS class.

### Step 3: Replace Utilities
Replace the Tailwind utilities with the CSS class:
```blade
<!-- Before -->
<span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400">
    Completed
</span>

<!-- After -->
<span class="badge-success">Completed</span>
```

### Step 4: Test Dark Mode
Verify the component works in both light and dark mode. All CSS classes include dark mode support.

---

## Quick Reference

### Badge Classes
```blade
.badge-completed          <!-- Green success badge -->
.badge-challenge-active   <!-- Orange active badge -->
.badge-challenge-paused   <!-- Yellow paused badge -->
.badge-habit-active       <!-- Teal habit badge -->
.count-badge              <!-- Gray count indicator -->
.streak-badge             <!-- Orange with fire emoji -->
```

### Header Classes
```blade
.page-header              <!-- Main page header -->
.page-header-title        <!-- Large title -->
.section-header           <!-- Section heading -->
.section-header-sm        <!-- Small uppercase heading -->
.tab-button.active        <!-- Active tab -->
```

### Navigation Classes
```blade
.nav-main                 <!-- Main navigation bar -->
.nav-link.active          <!-- Active nav link -->
.bottom-nav               <!-- Mobile bottom bar -->
.bottom-nav-item.active   <!-- Active bottom nav item -->
```

### Empty State Classes
```blade
.empty-state              <!-- Empty state container -->
.empty-state-icon         <!-- Large emoji/icon -->
.empty-state-title        <!-- Empty state title -->
.empty-state-message      <!-- Empty state description -->
```

### Link Classes
```blade
.link                     <!-- Standard link -->
.link-with-icon           <!-- Link with icon -->
.link-arrow               <!-- Link with arrow -->
.link-subtle              <!-- Gray subtle link -->
```

### Existing Classes
```blade
.card                     <!-- Base card -->
.btn-primary              <!-- Primary button -->
.app-input                <!-- Form input -->
.todo-item                <!-- Todo list item -->
```

---

## Best Practices

### ✅ DO:
- Use semantic class names that describe purpose
- Combine CSS classes with Tailwind for fine-tuning
- Update SCSS modules for global style changes
- Document new patterns in `06-frontend-components.md`

### ❌ DON'T:
- Override CSS classes with `!important` in Tailwind
- Mix similar patterns (use either CSS class OR Tailwind, not both)
- Create CSS classes for one-off styling
- Forget to test dark mode

### Example of Good Combination:
```blade
<!-- CSS class for semantics + Tailwind for specific spacing -->
<span class="badge-completed mt-2 mr-4">✓ Done</span>
```

---

## Navigation Structure Pattern

**Before (desktop nav - complex inline classes):**
```blade
<nav class="bg-gradient-to-r from-blue-600 to-purple-600 shadow-lg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="/" class="flex items-center space-x-2">
                        <div class="w-8 h-8 bg-white rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-600">...</svg>
                        </div>
                        <span class="text-white font-bold text-lg">App Name</span>
                    </a>
                </div>
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <!-- Nav links -->
                </div>
            </div>
        </div>
    </div>
</nav>
```

**After (with navigation classes):**
```blade
<nav class="nav-main">
    <div class="nav-container">
        <div class="nav-wrapper">
            <div class="nav-left">
                <div class="nav-logo">
                    <a href="/">
                        <div class="nav-logo-icon">
                            <svg>...</svg>
                        </div>
                        <span class="nav-logo-text">App Name</span>
                    </a>
                </div>
                <div class="nav-links-desktop">
                    <!-- Nav links -->
                </div>
            </div>
        </div>
    </div>
</nav>
```

**Before (mobile bottom nav):**
```blade
<nav class="sm:hidden fixed bottom-0 left-0 right-0 bg-white dark:bg-gray-900 border-t border-gray-200 dark:border-gray-800 z-40">
    <div class="grid grid-cols-5 h-16">
        <a href="/feed" class="flex flex-col items-center justify-center space-y-1 text-blue-600 hover:text-blue-600 transition-colors duration-150">
            <svg class="w-6 h-6">...</svg>
            <span class="text-xs font-medium">Feed</span>
        </a>
        <!-- Quick Goals Button -->
        <button class="flex flex-col items-center justify-center -mt-6">
            <div class="bg-gradient-to-r from-blue-600 to-purple-600 rounded-full p-4 shadow-lg hover:shadow-xl transition-shadow duration-150">
                <svg class="w-8 h-8 text-white">...</svg>
            </div>
        </button>
    </div>
</nav>
```

**After:**
```blade
<nav class="bottom-nav">
    <div class="bottom-nav-grid">
        <a href="/feed" class="bottom-nav-item active">
            <svg>...</svg>
            <span>Feed</span>
        </a>
        <!-- Quick Goals Button -->
        <div class="bottom-nav-center">
            <button @click="openGoals()">
                <svg>...</svg>
            </button>
        </div>
    </div>
</nav>
```

**Admin Dropdown & User Menu:**
```blade
<!-- Before -->
<div class="hidden sm:flex sm:items-center sm:ms-6" x-data="{ open: false }">
    <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white hover:text-gray-200 focus:outline-none transition ease-in-out duration-150">
        Admin
        <svg class="ms-2 -me-0.5 h-4 w-4">...</svg>
    </button>
</div>

<!-- After -->
<div class="nav-admin-wrapper" x-data="{ open: false }">
    <button class="nav-admin-button {{ request()->routeIs('admin.*') ? 'active' : '' }}">
        Admin
        <svg>...</svg>
    </button>
</div>
```

---

## Modal Structure Pattern

**Before (without modal classes):**
```blade
<x-modal name="create-item">
    <div class="p-6">
        <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Create Item</h2>
        
        <form action="..." method="POST">
            <!-- Form content -->
            
            <div class="flex justify-end space-x-3 mt-6">
                <button type="button" @click="$dispatch('close-modal', 'create-item')" class="btn-secondary">
                    Cancel
                </button>
                <button type="submit" class="btn-primary">
                    Create
                </button>
            </div>
        </form>
    </div>
</x-modal>
```

**After (with modal classes):**
```blade
<x-modal name="create-item">
    <!-- Header with gradient -->
    <div class="modal-header">
        <div class="modal-header-title">
            <h3>Create Item</h3>
            <button type="button" 
                    @click="$dispatch('close-modal', 'create-item')" 
                    class="text-white hover:text-gray-200 text-2xl font-bold leading-none">
                &times;
            </button>
        </div>
    </div>
    
    <!-- Scrollable content -->
    <div class="modal-content">
        <form action="..." method="POST">
            <!-- Form content -->
            
            <div class="flex justify-end gap-3 mt-6">
                <button type="button" @click="$dispatch('close-modal', 'create-item')" class="btn-secondary">
                    Cancel
                </button>
                <button type="submit" class="btn-primary">
                    Create
                </button>
            </div>
        </form>
    </div>
</x-modal>
```

**With Tabs:**
```blade
<x-modal name="quick-complete">
    <div class="modal-header">
        <div class="modal-header-title">
            <h3>Quick Complete</h3>
            <button type="button" @click="..." class="text-white hover:text-gray-200 text-2xl font-bold leading-none">&times;</button>
        </div>
    </div>
    
    <div class="modal-tabs">
        <nav>
            <button :class="tab === 'goals' ? 'modal-tab active-blue' : 'modal-tab'" @click="tab = 'goals'">
                Goals
            </button>
            <button :class="tab === 'habits' ? 'modal-tab active-teal' : 'modal-tab'" @click="tab = 'habits'">
                Habits
            </button>
        </nav>
    </div>
    
    <div class="modal-content">
        <div x-show="tab === 'goals'">
            <!-- Goals content -->
        </div>
        <div x-show="tab === 'habits'">
            <!-- Habits content -->
        </div>
    </div>
</x-modal>
```

**Danger/Delete Modal:**
```blade
<x-modal name="confirm-delete">
    <!-- Red gradient for destructive actions -->
    <div class="bg-gradient-to-r from-red-600 to-pink-600 px-6 py-4">
        <div class="modal-header-title">
            <h3 class="text-lg font-semibold text-white">Confirm Deletion</h3>
            <button type="button" @click="..." class="text-white hover:text-gray-200 text-2xl font-bold leading-none">&times;</button>
        </div>
    </div>
    
    <div class="px-6 py-4">
        <!-- Modal content -->
    </div>
</x-modal>
```

---

### 10. Goal List Items

**Before:**
```blade
<div class="flex items-start gap-4 p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
    <div class="flex-shrink-0 w-8 h-8 bg-gradient-to-br from-blue-500 to-purple-500 rounded-full flex items-center justify-center text-white text-sm font-bold">
        1
    </div>
    <div class="flex-1 min-w-0">
        <h4 class="font-semibold text-gray-900 dark:text-white">🏃 Run 5K</h4>
        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Complete a 5 kilometer run</p>
    </div>
</div>
```

**After:**
```blade
<div class="goal-info-item">
    <div class="numbered-badge">1</div>
    <div class="goal-info-content">
        <h4 class="goal-info-title">🏃 Run 5K</h4>
        <p class="goal-info-description">Complete a 5 kilometer run</p>
    </div>
</div>
```

---

### 11. Challenge Stats

**Before:**
```blade
<div class="flex items-center space-x-1 text-sm text-gray-600 dark:text-gray-400">
    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <!-- icon -->
    </svg>
    <span>30 days</span>
</div>
```

**After:**
```blade
<div class="challenge-stat-item">
    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <!-- icon -->
    </svg>
    <span>30 days</span>
</div>
```

---

### 12. Error Pages

**Before:**
```blade
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50 dark:from-gray-900 dark:to-gray-800 flex items-center justify-center px-4 py-12">
    <div class="max-w-md w-full text-center">
        <div class="mb-6">
            <div class="mx-auto w-24 h-24 bg-gradient-to-br from-blue-100 to-purple-100 dark:from-blue-900/20 dark:to-purple-900/20 rounded-full flex items-center justify-center">
                <svg class="w-12 h-12 text-blue-600 dark:text-blue-400"><!-- icon --></svg>
            </div>
        </div>
        <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-4">Page Not Found</h1>
        <p class="text-lg text-gray-600 dark:text-gray-400 mb-8">The page doesn't exist.</p>
    </div>
</div>
```

**After:**
```blade
<div class="error-page-container">
    <div class="error-page-content">
        <div class="error-page-icon-wrapper">
            <div class="error-page-icon error-icon-404">
                <svg><!-- icon --></svg>
            </div>
        </div>
        <h1 class="error-page-title">Page Not Found</h1>
        <p class="error-page-message">The page doesn't exist.</p>
        <div class="error-page-actions">
            <x-app-button>Go Back</x-app-button>
        </div>
    </div>
</div>
```

---

### 13. Tab Count Badges (with Alpine.js)

**Before:**
```blade
<span class="ml-2 px-2 py-1 text-xs rounded-full" 
      :class="activeTab === 'activity' ? 'bg-blue-100 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400' : 'bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400'">
    {{ $count }}
</span>
```

**After:**
```blade
<span class="tab-count-badge" :class="activeTab === 'activity' ? 'active' : 'inactive'">
    {{ $count }}
</span>
```

---

### 14. Gradient Badges

**Before:**
```blade
<span class="px-3 py-1 text-xs font-semibold rounded-full bg-gradient-to-r from-purple-500 to-pink-500 text-white shadow-sm">
    🚀 Major Release
</span>
```

**After:**
```blade
<span class="badge-gradient-purple">🚀 Major Release</span>
```

---

## Adding New CSS Classes

If you need a new reusable pattern:

1. **Identify the pattern** - Appears 3+ times
2. **Choose the right module** - badges, headers, navigation, etc.
3. **Add to SCSS file** - Follow existing naming conventions
4. **Build CSS** - Run `npm run build`
5. **Document it** - Update `06-frontend-components.md`
6. **Test dark mode** - Verify in both themes

Example:
```scss
// In resources/scss/components/_badges.scss

.badge-warning {
    @apply bg-yellow-100 text-yellow-800 dark:bg-yellow-900/20 dark:text-yellow-400;
}
```

---

## Troubleshooting

### CSS class not working?
1. Check if you ran `npm run build` after creating the class
2. Verify the class exists in `public/build/assets/app-*.css`
3. Clear browser cache
4. Check for typos in class name

### Dark mode not working?
All CSS classes include dark mode variants. If dark mode isn't working:
1. Verify `dark:` variants are included in the SCSS
2. Check if `<html>` has `class="dark"` when in dark mode
3. Test the Alpine.js theme manager is working

### Class conflicts with Tailwind?
CSS classes use `@apply` which generates the same output as Tailwind utilities. They should not conflict. If you see unexpected styling:
1. Check if you're overriding with inline Tailwind classes
2. Verify no `!important` is being used
3. Inspect element in browser dev tools to see which styles are applied

---

## File Locations

- **SCSS Modules**: `resources/scss/components/`
- **Main SCSS**: `resources/scss/app.scss`
- **Compiled CSS**: `public/build/assets/app-*.css`
- **Documentation**: `ai/06-frontend-components.md`
- **This Guide**: `ai/08-css-classes-usage-guide.md`
