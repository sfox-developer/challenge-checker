# Challenge Checker - Frontend Components & Patterns

## Frontend Architecture

### Technology Stack
- **Alpine.js** - Reactive JavaScript framework (lightweight alternative to Vue/React)
- **Tailwind CSS v3** - Utility-first CSS framework
- **Blade Components** - Laravel's component system
- **Vite** - Asset bundling and hot module replacement

### Component Organization
```
resources/
├── js/
│   ├── app.js                    # Entry point
│   ├── toast.js                  # Toast notification system
│   ├── components/               # Alpine.js components
│   │   ├── index.js             # Component registry
│   │   ├── theme.js             # Theme management
│   │   ├── modal.js             # Modal system
│   │   ├── activity.js          # Activity cards
│   │   ├── challenge.js         # Challenge forms
│   │   ├── habit.js             # Habit forms
│   │   ├── goals.js             # Goal management
│   │   ├── emojiPicker.js       # Emoji selection
│   │   └── habitToggle.js       # Habit completion
│   └── utils/
│       └── ui.js                # Utility functions
├── views/
│   ├── layouts/
│   │   ├── navigation.blade.php # Main navigation (desktop & mobile)
│   │   └── app.blade.php        # Main layout
│   └── components/              # Blade components
│       ├── activity-card.blade.php
│       ├── challenge-card.blade.php
│       ├── stat-card.blade.php
│       └── ...
└── scss/                        # Custom SCSS
    ├── app.scss                 # Main stylesheet
    ├── _toast.scss              # Toast notification styles
    └── components/              # SCSS Component Modules
        ├── _badges.scss         # Badge & pill components
        ├── _buttons.scss        # Button styles
        ├── _cards.scss          # Card components
        ├── _empty-states.scss   # Empty state & error page patterns
        ├── _forms.scss          # Form input styles
        ├── _headers.scss        # Header components
        ├── _layout.scss         # Layout & modal components
        ├── _links.scss          # Link styles
        ├── _list-items.scss     # List item patterns
        ├── _navigation.scss     # Navigation patterns
        ├── _todos.scss          # Todo/goal list styles
        └── _toast.scss          # Toast notifications
```

---

## CSS Component System

The Challenge Checker uses a modular SCSS architecture with reusable CSS classes to minimize repetitive Tailwind utility classes. All custom components are in `resources/scss/components/`.

### Design Philosophy

1. **Consistency** - Unified styling across similar UI elements
2. **Maintainability** - Change styles in one place instead of many templates
3. **Dark Mode** - All classes support dark mode out of the box
4. **Semantic Naming** - Class names describe purpose, not appearance
5. **Minimalism** - Clean 5-color system for reduced visual noise
6. **Pattern Consolidation** - Complex 15-20 class inline patterns replaced with 1-3 semantic classes

### Pattern Consolidation Results

The codebase has undergone extensive CSS refactoring to reduce inline Tailwind classes:

- **Stat Items**: 16-class patterns → 3 semantic classes (81% reduction)
- **Empty States**: 13-class patterns → 1-2 semantic classes (92% reduction)
- **Progress Bars**: 18-class patterns → 2 semantic classes (89% reduction)
- **Total Utilities Created**: 46+ reusable CSS classes
- **Files Updated**: 49 view files consolidated
- **Build Size**: ~200 kB (maintained despite new utilities due to Tailwind purging)

### Color System (5 Core Colors)

The design system uses a minimal color palette with clear semantic meanings:

| Color | Usage | Examples |
|-------|-------|----------|
| **Blue** | Primary interactions, links, active states | Buttons, checkboxes, active tabs |
| **Green** | Success, completions, positive actions | Completed items, habits, success messages |
| **Yellow** | Warnings, pending states, cautions | Paused badges, streak counters |
| **Red** | Errors, danger, destructive actions | Delete buttons, error messages, admin areas |
| **Gray** | Neutral, text, borders, disabled states | Text, dividers, disabled elements |

**Gradient Usage:**
- **Blue-Purple** (primary gradient) - Used only for navigation and brand elements
- **Solid Colors** - Preferred for buttons, badges, and most UI elements

### Available CSS Modules

#### 1. Badges (`_badges.scss`)
Status indicators, pills, and labels with semantic naming.

**Base Classes:**
```scss
.badge                    // Base badge (small, rounded-full)
.badge-sm                 // Extra small badge
.badge-md                 // Medium badge
.badge-lg                 // Large badge
```

**Color Variants:**
```scss
.badge-primary            // Blue - primary/active states
.badge-success            // Green - completed/success states
.badge-paused             // Yellow - paused/warning
.badge-draft              // Gray - draft/pending
.badge-archived           // Gray (muted) - archived items
.badge-info               // Blue - informational (alternative to primary)
.badge-danger             // Red - errors/destructive
```

**Semantic Classes (Challenge States):**
```scss
.badge-completed          // Completed challenges
.badge-challenge-active   // Active challenges (uses primary)
.badge-challenge-paused   // Paused challenges
.badge-challenge-draft    // Draft challenges
```

**Semantic Classes (Habit States):**
```scss
.badge-habit-active       // Active habits (uses primary)
.badge-habit-archived     // Archived habits
.badge-habit-completed-today  // Habits completed today
```

**Special Badges:**
```scss
.count-badge              // Count indicators (tabs, sections)
.count-badge-primary      // Primary count badge (blue)
.streak-badge             // Streak counter with 🔥 emoji (yellow)
.badge-accent             // Accent badge (solid blue for special items)
.numbered-badge           // Numbered badge (solid blue)
.tab-count-badge          // Tab count badge (dynamic active/inactive)
.tab-count-badge.active   // Active tab count
.tab-count-badge.inactive // Inactive tab count
```

**Usage Examples:**
```blade
<!-- Challenge status -->
<span class="badge-completed">✓ Completed</span>
<span class="badge-challenge-active">🏃 Active</span>
<span class="badge-challenge-paused">⏸️ Paused</span>

<!-- Habit status -->
<span class="badge-habit-active">Active</span>
<span class="badge-habit-completed-today">✓ Done Today</span>

<!-- Count badges in tabs -->
<span class="count-badge-primary">5</span>

<!-- Streak badge -->
<span class="streak-badge">7</span> <!-- Shows: 🔥 7 -->

<!-- Accent badges -->
<span class="badge-accent">🚀 Featured</span>

<!-- Numbered goal/item badge -->
<div class="numbered-badge">1</div>

<!-- Tab count badges with Alpine.js -->
<span class="tab-count-badge" :class="active ? 'active' : 'inactive'">12</span>
```

#### 2. Navigation (`_navigation.scss`)
Navigation bars, links, and mobile bottom nav patterns.

**Main Navigation:**
```scss
.nav-main                 // Main gradient navigation bar
.nav-container            // Navigation content container
.nav-wrapper              // Flex wrapper for nav sections
.nav-left                 // Left side navigation area
```

**Logo:**
```scss
.nav-logo                 // Logo container
.nav-logo-icon            // Logo icon wrapper (white circle)
.nav-logo-text            // Logo text
```

**Desktop Nav Links:**
```scss
.nav-links-desktop        // Desktop links container
.nav-link                 // Desktop navigation link
.nav-link.active          // Active navigation link
```

**Admin Dropdown:**
```scss
.nav-admin-wrapper        // Admin dropdown wrapper
.nav-admin-button         // Admin dropdown trigger
.nav-admin-button.active  // Active admin button
```

**User Menu & Settings:**
```scss
.nav-settings             // Settings area container
.nav-user-trigger         // User dropdown trigger button
```

**Mobile Bottom Navigation:**
```scss
.bottom-nav               // Fixed bottom navigation bar
.bottom-nav-grid          // 5-column grid layout
.bottom-nav-item          // Individual nav item
.bottom-nav-item.active   // Active nav item
.bottom-nav-center        // Special center button (Quick Goals)
.bottom-nav-center.disabled // Disabled state for center button
```

**Dropdown Menus:**
```scss
.nav-dropdown             // Dropdown menu container
.nav-dropdown-item        // Dropdown menu item
```

**Navigation Buttons:**
```scss
.nav-button               // Theme toggle, user menu trigger
.nav-button-mobile        // Mobile navigation button
```

**Usage Examples:**
```blade
<!-- Desktop navigation -->
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
                    <a href="/feed" class="nav-link active">Feed</a>
                    <a href="/challenges" class="nav-link">Challenges</a>
                </div>
            </div>
        </div>
    </div>
</nav>

<!-- Mobile bottom nav -->
<nav class="bottom-nav">
    <div class="bottom-nav-grid">
        <a href="/feed" class="bottom-nav-item active">
            <svg>...</svg>
            <span>Feed</span>
        </a>
        <div class="bottom-nav-center">
            <button @click="...">
                <svg>...</svg>
            </button>
        </div>
    </div>
</nav>
```

#### 3. Headers (`_headers.scss`)
Page headers, section headers, tab headers, and semantic heading classes.

**Semantic Heading Classes (Added December 9, 2025):**
Standardized heading classes to replace inline Tailwind utility combinations. Use these for all heading elements.

```scss
// H1 - Main page title
.h1                       // Standard H1 (text-2xl font-bold)

// H2 - Section headings
.h2                       // Standard H2 (text-xl font-semibold)
.h2-with-icon             // H2 with flex items-center for icons

// H3 - Subsection headings
.h3                       // Standard H3 (text-lg font-semibold)
.h3-muted                 // Muted H3 (slate colors)
.h3-medium                // Medium weight H3

// H4 - Card/component headings
.h4                       // Standard H4 (text-base font-semibold)
.h4-card                  // Card heading H4 (text-lg)
.h4-sm                    // Small H4 (text-sm)

// H5 - Small component headings
.h5                       // Standard H5 (text-sm font-semibold)
```

**Semantic Heading Usage Examples:**
```blade
<!-- Main page title -->
<h1 class="h1">Privacy Policy</h1>

<!-- Section heading -->
<h2 class="h2">Account Settings</h2>

<!-- Section heading with icon -->
<h2 class="h2 h2-with-icon mt-8 mb-4">
    <span class="w-2 h-8 bg-slate-200 dark:bg-slate-800 rounded mr-3"></span>
    Privacy & Security
</h2>

<!-- Subsection heading -->
<h3 class="h3">Personal Information</h3>

<!-- Muted subsection (slate colors) -->
<h3 class="h3 h3-muted mt-6 mb-3">Account Details</h3>

<!-- Card heading -->
<h4 class="h4 h4-card">Challenge Details</h4>

<!-- Card heading with hover effect -->
<h4 class="h4 h4-card group-hover:text-slate-700 dark:group-hover:text-slate-400 transition-colors">
    {{ $challenge->name }}
</h4>
```

**App Header (Layout):**
```scss
.app-header               // Main page header wrapper
.app-header-container     // Header content container
```

**Page Headers:**
```scss
.page-header              // Main page header container
.page-header-content      // Header content wrapper
.page-header-icon         // Icon container with gradient
.page-header-icon.gradient-primary    // Blue-purple gradient (default)
.page-header-icon.gradient-success    // Green gradient (positive pages)
.page-header-icon.gradient-danger     // Red gradient (admin/warnings)
.page-header-title        // Page title text
.page-header-subtitle     // Page subtitle text
.page-header-actions      // Action buttons container
```

**Section Headers:**
```scss
.section-header           // Standard section header (lg)
.section-header-sm        // Small section header (uppercase)
.section-header-md        // Medium section header
.section-header-with-icon // Section header with icon
.section-header-with-count // Section header with count badge
```

**Tab Headers:**
```scss
.tab-header               // Tab container
.tab-nav                  // Tab navigation
.tab-button               // Individual tab button
.tab-button.active        // Active tab
.tab-button-with-count    // Tab with count badge
```

**Tab Count Badges:**
```scss
.tab-count-badge          // Tab count badge (dynamic active/inactive)
.tab-count-badge.active   // Active tab count (blue background)
.tab-count-badge.inactive // Inactive tab count (gray background)
```

**Card Headers:**
```scss
.card-header              // Header within card
.card-title               // Card title
.card-subtitle            // Card subtitle
```

**Usage Examples:**
```blade
<!-- Page header with icon -->
<div class="page-header">
    <div class="page-header-content">
        <div class="page-header-icon gradient-blue-purple">
            <svg>...</svg>
        </div>
        <h2 class="page-header-title">My Challenges</h2>
    </div>
</div>

<!-- Section header -->
<h3 class="section-header">Statistics</h3>
<h4 class="section-header-sm">Completed Goals</h4>

<!-- Tabs with Alpine.js (client-side filtering) -->
<div class="tab-header">
    <nav class="tab-nav">
        <button @click="activeTab = 'challenges'" 
                :class="activeTab === 'challenges' ? 'tab-button active' : 'tab-button'">
            Challenges
            <span class="tab-count-badge" :class="activeTab === 'challenges' ? 'active' : 'inactive'">
                {{ $challengeCount }}
            </span>
        </button>
        <button @click="activeTab = 'habits'" 
                :class="activeTab === 'habits' ? 'tab-button active' : 'tab-button'">
            Habits
            <span class="tab-count-badge" :class="activeTab === 'habits' ? 'active' : 'inactive'">
                {{ $habitCount }}
            </span>
        </button>
    </nav>
</div>

<!-- Tabs with server-side filtering (using links) -->
<div class="tab-header">
    <nav class="tab-nav">
        <a href="?filter=active" 
           class="@if($filter === 'active') tab-button active @else tab-button @endif">
            Active
            <span class="tab-count-badge {{ $filter === 'active' ? 'active' : 'inactive' }}">
                {{ $activeCount }}
            </span>
        </a>
        <a href="?filter=all" 
           class="@if($filter === 'all') tab-button active @else tab-button @endif">
            All
            <span class="tab-count-badge {{ $filter === 'all' ? 'active' : 'inactive' }}">
                {{ $allCount }}
            </span>
        </a>
    </nav>
</div>
```

#### 4. Empty States (`_empty-states.scss`)
Empty state messages and placeholders.

**Container Classes:**
```scss
.empty-state              // Standard empty state
.empty-state-sm           // Small empty state
.empty-state-lg           // Large empty state
```

**Element Classes:**
```scss
.empty-state-icon         // Large emoji/icon
.empty-state-icon-sm      // Small icon
.empty-state-icon-lg      // Extra large icon
.empty-state-title        // Empty state title
.empty-state-title-sm     // Small title
.empty-state-message      // Empty state message
.empty-state-message-sm   // Small message
.empty-state-action       // Action button container
```

**Variants:**
```scss
.empty-state-card         // Empty state within card
.empty-state-page         // Full page empty state
```

**Error Page Components:**
```scss
.error-page-container     // Full-screen error page wrapper
.error-page-content       // Error content container
.error-page-icon-wrapper  // Icon wrapper
.error-page-icon          // Error icon circle
.error-page-icon.error-icon-404  // 404 error (blue/purple gradient)
.error-page-icon.error-icon-403  // 403 forbidden (red/pink gradient)
.error-page-icon.error-icon-500  // 500 error (orange/red gradient)
.error-page-title         // Error page title
.error-page-message       // Error page message
.error-page-actions       // Action buttons container
```

**Usage Examples:**
```blade
<!-- Card empty state -->
<div class="empty-state-card">
    <div class="empty-state-icon">📅</div>
    <h3 class="empty-state-title">No challenges yet</h3>
    <p class="empty-state-message">Create your first challenge to get started</p>
    <div class="empty-state-action">
        <x-app-button href="/challenges/create">Create Challenge</x-app-button>
    </div>
</div>

<!-- Error page (404) -->
<div class="error-page-container">
    <div class="error-page-content">
        <div class="error-page-icon-wrapper">
            <div class="error-page-icon error-icon-404">
                <svg><!-- icon --></svg>
            </div>
        </div>
        <h1 class="error-page-title">Page Not Found</h1>
        <p class="error-page-message">The page you're looking for doesn't exist.</p>
        <div class="error-page-actions">
            <x-app-button>Go Back</x-app-button>
        </div>
    </div>
</div>
```

#### 5. Links (`_links.scss`)
Styled links and interactive text elements.

**Base Links:**
```scss
.link                     // Standard blue link
.link-with-icon           // Link with inline icon
.link-subtle              // Gray subtle link
.link-danger              // Red danger link
.link-arrow               // Link with arrow (→)
```

**Action Links:**
```scss
.action-link              // Blue action link (inline)
.action-link-subtle       // Gray action link
```

**Interactive Links:**
```scss
.card-link                // Make entire card clickable
.list-item-link           // Interactive list item
```

**Usage Examples:**
```blade
<!-- Standard link -->
<a href="/goals" class="link">View all goals</a>

<!-- Link with icon -->
<a href="/settings" class="link-with-icon">
    <svg>...</svg>
    <span>Settings</span>
</a>

<!-- Arrow link -->
<a href="/challenge/1" class="link-arrow">View</a>

<!-- Card link -->
<a href="/habit/5" class="card-link">
    <div class="card">...</div>
</a>
```

#### 6. Layout (`_layout.scss`)
Application layout containers, modals, and floating elements.

**App Container:**
```scss
.app-container            // Main application wrapper with gradient background
```

**Floating Action Button (FAB):**
```scss
.fab                      // Fixed bottom-right action button
.fab-tooltip              // Tooltip that appears on hover
```

**Modal Components:**
```scss
.modal-overlay            // Fixed overlay container
.modal-backdrop           // Semi-transparent background
.modal-container          // Centers modal content
.modal-panel              // Modal content panel
.modal-header             // Modal header with gradient
.modal-header-title       // Header title wrapper
.modal-tabs               // Tab navigation in modal
.modal-tab                // Individual tab button
.modal-tab.active-blue    // Active tab (blue accent)
.modal-tab.active-teal    // Active tab (teal accent)
.modal-content            // Scrollable modal content area
```

**Usage Examples:**
```blade
<!-- App container -->
<div class="app-container">
    <!-- Page content -->
</div>

<!-- FAB button -->
<button class="fab">
    <svg>...</svg>
    <span class="fab-tooltip">Quick Complete</span>
</button>

<!-- Full-featured Alpine.js Modal (Quick Complete) -->
<div class="modal-overlay">
    <div class="modal-container">
        <div class="modal-backdrop" @click="close()"></div>
        <div class="modal-panel">
            <div class="modal-header">
                <div class="modal-header-title">
                    <h3>Modal Title</h3>
                    <button @click="close()">×</button>
                </div>
            </div>
            <div class="modal-tabs">
                <nav>
                    <button :class="tab === 'one' ? 'modal-tab active-blue' : 'modal-tab'">
                        Tab 1
                    </button>
                </nav>
            </div>
            <div class="modal-content">
                <!-- Content -->
            </div>
        </div>
    </div>
</div>

<!-- Simple Confirmation Modal (Archive/Complete/Delete) -->
<div id="modalId" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-gray-800">
        <div class="mt-3 text-center">
            <!-- Icon with colored background -->
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-yellow-100 dark:bg-yellow-900/30">
                <svg class="h-6 w-6 text-yellow-600 dark:text-yellow-400">...</svg>
            </div>
            
            <!-- Title -->
            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100 mt-4">
                Confirm Action?
            </h3>
            
            <!-- Description -->
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Description of what will happen
                </p>
            </div>
            
            <!-- Action buttons -->
            <div class="items-center px-4 py-3">
                <div class="flex space-x-3">
                    <x-app-button variant="modal-cancel" type="button" onclick="hideModalName()">
                        Cancel
                    </x-app-button>
                    <form method="POST" action="{{ route('action') }}" class="w-full">
                        @csrf
                        <x-app-button variant="modal-confirm" type="submit">
                            Confirm
                        </x-app-button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    window.showModalName = () => showModal('modalId');
    window.hideModalName = () => hideModal('modalId');
    
    document.addEventListener('DOMContentLoaded', () => {
        initModalListeners('modalId', hideModalName);
    });
</script>
```

**Modal Utilities** (`resources/js/components/modal.js`):
- `showModal(modalId)` - Shows modal and prevents body scroll
- `hideModal(modalId)` - Hides modal and restores body scroll  
- `initModalListeners(modalId, hideCallback)` - Sets up overlay click and escape key handlers

**Confirmation Modals in Application:**
1. **Challenge Complete** - `challenges/show.blade.php` - `completeModal`
2. **Challenge Archive** - `challenges/show.blade.php` - `archiveModal`
3. **Habit Archive** - `habits/show.blade.php` - `archiveModal`

**Button Variants for Modals:**
- `modal-cancel` - Gray cancel button
- `modal-confirm` - Slate confirmation button

**Icon Color Guidelines:**
- Yellow background (`bg-yellow-100 dark:bg-yellow-900/30`) - Warnings/caution
- Red background - Destructive actions
- Green background - Success confirmations
- Blue background - Informational

#### 7. List Items (`_list-items.scss`)
Reusable list item patterns for goals, challenges, and content lists.

**Goal Info List:**
```scss
.goal-info-item           // Goal list item container
.goal-info-content        // Goal content wrapper
.goal-info-title          // Goal title
.goal-info-description    // Goal description text
```

**Challenge Stats:**
```scss
.challenge-stat-item      // Small stat item (duration, progress)
```

**Usage Examples:**
```blade
<!-- Goal info list item -->
<div class="goal-info-item">
    <div class="numbered-badge">1</div>
    <div class="goal-info-content">
        <h4 class="goal-info-title">🏃 Run 5K</h4>
        <p class="goal-info-description">Complete a 5 kilometer run</p>
    </div>
</div>

<!-- Challenge stats -->
<div class="challenge-stat-item">
    <svg><!-- calendar icon --></svg>
    <span>30 days</span>
</div>
```

#### 8. Existing Modules

**Cards (`_cards.scss`):**
```scss
.card                     // Base card component
.card-no-padding          // Card without padding
.card-hover               // Card with hover effect
.card-interactive         // Interactive card (clickable)
.card-link                // Card as clickable link with hover border
```

**Buttons (`_buttons.scss`):**

**Design Note (December 9, 2025):** All outlined button variants now use box-shadow instead of borders for a cleaner, more minimalistic appearance. Box-shadows are created using Tailwind arbitrary values to match border colors exactly.

```scss
// Outlined Buttons (use box-shadow, not borders)
.btn-primary              // Primary ghost button (1px shadow)
.btn-secondary            // Secondary outlined button (1px shadow)
.btn-modal-cancel         // Modal cancel button (1px shadow)

// Solid Buttons (no borders or shadows)
.btn-primary-solid        // Solid slate button for critical CTAs
.btn-success              // Solid green success button
.btn-success-sm           // Small success button
.btn-danger               // Red danger button (soft background)
.btn-accent               // Solid slate accent button
.btn-modal-confirm        // Modal confirm button (solid slate)

// Action Buttons (small colored buttons for cards/lists)
.btn-action-sm            // Small green action button
.btn-action-pause         // Small yellow pause button
.btn-action-complete      // Small blue complete button
```

**Box-Shadow Implementation:**
```scss
// Example: Primary button with 1px shadow ring
.btn-primary {
    @apply shadow-[0_0_0_1px_rgba(209,213,219,1)] dark:shadow-[0_0_0_1px_rgba(75,85,99,1)];
    @apply hover:shadow-[0_0_0_1px_rgba(156,163,175,1)] dark:hover:shadow-[0_0_0_1px_rgba(107,114,128,1)];
    // ... other styles
}
```

**Usage:**
```blade
<!-- Primary outlined button (box-shadow) -->
<x-app-button variant="primary" href="/challenges/create">
    Create Challenge
</x-app-button>

<!-- Secondary button (box-shadow) -->
<x-app-button variant="secondary" type="button">
    Cancel
</x-app-button>

<!-- Solid primary button (no shadow) -->
<x-app-button variant="primary-solid" type="submit">
    Save Changes
</x-app-button>

<!-- Modal buttons -->
<x-app-button variant="modal-cancel" onclick="hideModal()">Cancel</x-app-button>
<x-app-button variant="modal-confirm" type="submit">Confirm</x-app-button>
```

**Forms (`_forms.scss`):**
```scss
// Form Inputs
.app-input                // Standard form input
.app-textarea             // Multi-line textarea
.app-select               // Select dropdown

// Form Labels
.form-label               // Standard form label
.form-label-icon          // Label with icon support

// Info Boxes
.info-box                 // Base info/alert box
.info-box-primary         // Blue info box
.info-box-success         // Green info box
.info-box-warning         // Yellow info box
.info-box-danger          // Red info box
.info-box-bordered        // Add left border accent

// Text Helpers
.text-hint                // Extra small gray text (hints)
.text-muted               // Small gray text (muted)
.text-optional            // Optional field indicator
```

**Layout & Utilities (`_layout.scss`):**
```scss
// Stat Items & Info Rows
.stat-item                // Info row with gray background (replaces 16-class inline pattern)
.stat-label               // Label section with icon spacing
.stat-value               // Bold value text

// Section Headers
.section-header-row       // Header with actions container
.section-title            // Section title text
.section-actions          // Action buttons container

// Empty States
.empty-state              // Base empty state container (text-center py-8)
.empty-state-icon         // Standard icon (16x16, gray background)
.empty-state-icon-lg      // Large icon with blue-purple gradient (20x20)
.empty-state-icon-muted   // Gray gradient icon (20x20)
.empty-state-title        // Empty state heading (2xl, bold)
.empty-state-text         // Empty state description (lg)

// Progress Bars
.progress-container       // Progress bar background
.progress-bar             // Standard progress bar
.progress-bar-gradient    // Gradient progress bar (blue-cyan)

// Grid Layouts
.grid-2-cols              // 2 column grid (gap-4)
.grid-2-cols-responsive   // 1→2 columns responsive
.grid-3-cols-responsive   // 1→2→3 columns responsive
.grid-4-cols-responsive   // 2→4 columns responsive

// Dividers
.divider-top              // Top border with pt-6
.divider-top-sm           // Top border with pt-3
.divider-top-md           // Top border with pt-4
.divider-bottom           // Bottom border with pb-6

// Button Groups
.btn-group                // Flex with space-x-3
.btn-group-end            // Flex end with space-x-3
```

**Usage Examples - Stat Items:**
```blade
<!-- Before: 16 classes -->
<div class="flex items-center justify-between text-sm bg-gray-50 dark:bg-gray-700/50 rounded-lg p-3">
    <div class="flex items-center space-x-2 text-gray-600 dark:text-gray-400">
        <svg>...</svg>
        <span>Frequency:</span>
    </div>
    <span class="font-semibold text-gray-900 dark:text-white">Daily</span>
</div>

<!-- After: 3 classes -->
<div class="stat-item">
    <div class="stat-label">
        <svg>...</svg>
        <span>Frequency:</span>
    </div>
    <span class="stat-value">Daily</span>
</div>
```

**Usage Examples - Empty States:**
```blade
<!-- Empty state with icon -->
<div class="empty-state">
    <div class="empty-state-icon">
        <svg>...</svg>
    </div>
    <h3 class="empty-state-title">No challenges yet</h3>
    <p class="empty-state-text">Create your first challenge to get started</p>
</div>

<!-- Large branded empty state -->
<div class="empty-state-icon-lg">
    <svg>...</svg>
</div>
<h3 class="empty-state-title">Ready to Start Your Journey?</h3>
<p class="empty-state-text">Create your first challenge!</p>
```

**Usage Examples - Progress Bars:**
```blade
<!-- Before: 18 classes -->
<div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
    <div class="bg-gradient-to-r from-blue-500 to-cyan-500 h-2 rounded-full transition-all duration-300"
         style="width: 75%"></div>
</div>

<!-- After: 2 classes -->
<div class="progress-container">
    <div class="progress-bar-gradient" style="width: 75%"></div>
</div>

<!-- Solid color progress bar -->
<div class="progress-container">
    <div class="progress-bar bg-teal-500" style="width: 85%"></div>
</div>
```

**Usage Examples - Grids:**
```blade
<!-- 3-column responsive grid -->
<div class="grid-3-cols-responsive">
    <div class="card">Challenge 1</div>
    <div class="card">Challenge 2</div>
    <div class="card">Challenge 3</div>
</div>

<!-- 4-column responsive stats grid -->
<div class="grid-4-cols-responsive">
    <x-stat-card title="Total" value="42" />
    <x-stat-card title="Active" value="12" />
    <x-stat-card title="Completed" value="28" />
    <x-stat-card title="Paused" value="2" />
</div>
```

**Usage Examples - Dividers & Button Groups:**
```blade
<!-- Form actions with divider -->
<div class="divider-top">
    <div class="btn-group-end">
        <button class="btn-secondary">Cancel</button>
        <button class="btn-primary">Save</button>
    </div>
</div>

<!-- Section divider -->
<div class="divider-top-md">
    <h3 class="section-title">Next Section</h3>
</div>
```
.text-optional            // Optional field indicator
```

**Todos (`_todos.scss`):**
```scss
.todo-container           // Todo list container
.todo-section             // Todo section with header
.todo-item                // Individual todo item
.todo-checkbox            // Todo checkbox
.todo-content             // Todo text content
.todo-status              // Status badge container
.status-badge             // Status indicator
```

---

## Navigation Structure

### Desktop Navigation
**File:** `resources/views/layouts/navigation.blade.php`

**Primary Navigation Links:**
- Feed - Activity feed from followed users
- Challenges - User's challenges list
- Habits - User's habits list
- Goals - Goals library management
- Discover - User search and discovery
- Admin - Admin dashboard (visible only to admins)

**User Dropdown Menu:**
- My Profile - View public profile
- Settings - Edit profile & preferences
- Log Out - Sign out

**Features:**
- Theme toggle button (sun/moon icon)
- Active route highlighting
- Alpine.js theme manager integration
- Responsive design

### Mobile Navigation
**File:** `resources/views/layouts/navigation.blade.php`

**Bottom Navigation Bar (5 items):**
1. **Feed** - Activity feed icon
2. **Challenges** - Challenge badge icon
3. **Quick Goals** - Center prominent button (quick goal completion)
   - Disabled on challenge detail pages
   - Gradient background, elevated design
4. **Habits** - Clipboard checklist icon
5. **Menu** - User avatar, opens menu page

**Profile Menu Page** (`resources/views/profile/menu.blade.php`):
- My Profile - View public profile
- Goals - Goals library management
- Discover - Find and follow users
- Settings - Edit profile & preferences
- Theme Toggle - Switch between light/dark mode
- Log Out - Sign out

**Mobile Navigation Design:**
- Fixed bottom bar (z-index: 40)
- Icon + label for each item
- Active state highlighting (blue)
- Grid layout (5 columns)
- Dark mode support

**User Flow:**
- Primary actions (Feed, Challenges, Habits) are in bottom nav for quick access
- Secondary features (Goals, Discover) are in the Menu page
- Quick Goals button for fast goal completion from anywhere

---

## Alpine.js Components

### Component Registration Pattern

**File:** `resources/js/components/index.js`

All Alpine components are registered globally via `window` object:
```javascript
window.themeManager = createThemeManager;
window.habitForm = createHabitForm;
window.challengeForm = createChallengeForm;
```

**Usage in Blade:**
```blade
<div x-data="themeManager()">
    <!-- Component content -->
</div>
```

### Key Alpine Components

#### 1. themeManager
**File:** `resources/js/components/theme.js`

**Purpose:** Manage dark/light theme toggle and persistence

**State:**
- `theme` - Current theme ('light' or 'dark')

**Methods:**
- `init()` - Apply initial theme
- `toggleTheme()` - Switch between light/dark
- `applyTheme()` - Add/remove 'dark' class on html
- `saveThemePreference()` - POST to `/profile/theme`
- `isDark()` - Check if dark mode
- `getThemeIcon()` - Return sun/moon icon

**Usage:**
```blade
<button x-data="themeManager()" @click="toggleTheme()">
    <span x-show="!isDark()">🌙</span>
    <span x-show="isDark()">☀️</span>
</button>
```

#### 2. Modal System
**File:** `resources/js/components/modal.js`

**Functions:**
- `showModal(modalId)` - Show modal by ID
- `hideModal(modalId)` - Hide modal by ID
- `createQuickGoalsModal()` - Quick goals completion modal

**Modal Pattern:**
```blade
<div id="myModal" class="hidden fixed inset-0 z-50">
    <div class="modal-content">
        <!-- Content -->
        <button onclick="hideModal('myModal')">Close</button>
    </div>
</div>

<button onclick="showModal('myModal')">Open</button>
```

#### 3. habitForm
**File:** `resources/js/components/habit.js`

**Purpose:** Manage habit creation/edit forms with frequency configuration

**State:**
- `frequencyType` - daily/weekly/monthly/yearly
- `frequencyCount` - Number of times per period
- `selectedDays` - Array of selected weekdays (for weekly)
- `goalId` - Selected goal from library
- `goalName` - Custom goal name
- `useLibrary` - Toggle between library/custom goal

**Methods:**
- `init()` - Initialize form state
- `updateFrequency()` - Recalculate based on type change
- `toggleDay(day)` - Toggle weekday selection
- `validateForm()` - Client-side validation

**Usage:**
```blade
<form x-data="habitForm()" @submit="validateForm()">
    <select x-model="frequencyType" @change="updateFrequency()">
        <option value="daily">Daily</option>
        <option value="weekly">Weekly</option>
    </select>
</form>
```

#### 4. challengeForm
**File:** `resources/js/components/challenge.js`

**Purpose:** Challenge creation form with dynamic goal management

**State:**
- `goals` - Array of goals
- `searchQuery` - Goal library search
- `searchResults` - Library search results
- `showLibrary` - Toggle library view

**Methods:**
- `addGoal()` - Add new goal to list
- `removeGoal(index)` - Remove goal from list
- `searchLibrary()` - AJAX search goals library
- `selectFromLibrary(goal)` - Add library goal to challenge

#### 5. activityCard
**File:** `resources/js/components/activity.js`

**Purpose:** Interactive activity card with like functionality

**State:**
- `liked` - Is activity liked by current user
- `likeCount` - Number of likes
- `loading` - AJAX loading state

**Methods:**
- `toggleLike()` - Like/unlike activity
- `showLikers()` - Show modal with list of users who liked

#### 5. emojiPicker
**File:** `resources/js/components/emojiPicker.js`

**Purpose:** Provide user-friendly emoji selection for icon inputs

**State:**
- `inputId` - ID of the associated input field
- `showPicker` - Boolean, picker popover visibility
- `commonEmojis` - Array of frequently used emojis

**Methods:**
- `init()` - Set up click-outside listener
- `togglePicker()` - Show/hide picker popover
- `selectEmoji(emoji)` - Set selected emoji in input
- `clearEmoji()` - Clear the input value
- `buttonText` - Computed property showing current emoji or default

**Usage:**
```blade
<div x-data="emojiPicker('myInput')">
    <input type="text" id="myInput" />
    <button @click="togglePicker()" x-text="buttonText"></button>
</div>
```

**Blade Component:**
```blade
<x-emoji-picker 
    id="goal-icon"
    name="icon" 
    :value="$goal->icon"
    label="Icon (emoji)" />
```

**Inline Pattern (for Alpine.js loops):**
When using emoji picker within an Alpine.js `x-for` loop (e.g., challenge form's dynamic goal creation), use the inline pattern since the Blade component requires unique IDs:

```blade
<div x-data="{ showPicker: false, emojis: ['🎯', '🏆', '⭐', ...] }" class="relative">
    <div class="relative">
        <input type="text" 
               x-model="goal.icon"
               class="app-input pr-12" 
               placeholder="🎯"
               maxlength="2">
        <button 
            type="button"
            @click="showPicker = !showPicker"
            class="absolute right-2 top-1/2 -translate-y-1/2 text-2xl">
            <span x-text="goal.icon || '🎯'"></span>
        </button>
    </div>
    <div x-show="showPicker" @click.outside="showPicker = false" 
         class="absolute mt-2 w-72 bg-white dark:bg-gray-800 rounded-lg shadow-xl z-50 p-4">
        <div class="grid grid-cols-8 gap-2">
            <template x-for="emoji in emojis">
                <button @click="goal.icon = emoji; showPicker = false" 
                        x-text="emoji"></button>
            </template>
        </div>
    </div>
</div>
```

This pattern is used in `resources/views/challenges/create.blade.php` for dynamic goal creation.

---

## Blade Components

### Component Naming Convention
- Kebab-case file names: `stat-card.blade.php`
- Usage with `x-` prefix: `<x-stat-card />`

### Key Blade Components

#### x-app-button
**File:** `resources/views/components/app-button.blade.php`

**Props:**
- `type` - button/submit (default: button)
- `variant` - primary/secondary/danger
- `size` - sm/md/lg

**Usage:**
```blade
<x-app-button variant="primary" size="lg">
    Click Me
</x-app-button>
```

#### x-stat-card
**File:** `resources/views/components/stat-card.blade.php`

**Props:**
- `label` - Card title
- `value` - Main value to display
- `icon` - Optional icon name
- `color` - Color variant

**Usage:**
```blade
<x-stat-card 
    label="Total Challenges" 
    :value="$challengeCount"
    icon="trophy"
    color="blue" />
```

#### x-challenge-card
**File:** `resources/views/components/challenge-card.blade.php`

**Props:**
- `challenge` - Challenge model instance
- `showProgress` - Boolean to show progress bar

**Features:**
- Shows challenge status badge
- Progress bar
- Click to view details
- Responsive layout

#### x-challenge-list-item
**File:** `resources/views/components/challenge-list-item.blade.php`

**Props:**
- `challenge` - Challenge model
- `adminView` - Boolean for admin context (default: false)

**Features:**
- **Full card clickability** - Entire card is an `<a>` tag with `card-link` class
- **No icon display** - Unlike habits, challenges don't display icons (challenges don't have their own icons and displaying one goal's icon would be arbitrary for multi-goal challenges)
- **Hover effects** - Title and arrow change color on hover via `group` utilities
- **Inline badge** - Status badge positioned with title for better hierarchy
- **Emoji-based stats** - Uses emojis (📅 ✓) instead of SVG icons for better scannability
- **Routes to admin or public view** based on `adminView` prop
- **Clean, consistent layout** - All cards have identical structure

**Layout Structure:**
```blade
<a href="..." class="card card-link group">
    <div class="flex items-center gap-4">
        <!-- Content area with title, badge, description, stats -->
        <!-- Chevron arrow (hover effect) -->
    </div>
</a>
```

**Stats Display:**
- Duration: 📅 emoji + day count
- Progress: ✓ emoji + completed/total (if started)
- Goal count: X goals

**Badge Types:**
- Archived: 📁 Archived
- Completed: ✓ Completed
- Active: 🏃 Active
- Paused: ⏸️ Paused
- Draft: 📝 Draft

**Design Note:**
Challenges do not display icons because:
1. Challenges don't have icon properties in the data model
2. Each challenge contains multiple goals with potentially different icons
3. Displaying one goal's icon would be arbitrary and misleading
4. Status badge emojis provide sufficient visual differentiation

#### x-habit-list-item
**File:** `resources/views/components/habit-list-item.blade.php`  
**Created:** December 9, 2025

**Props:**
- `habit` - Habit model instance
- `adminView` - Boolean for admin context (default: false)

**Features:**
- **Full card clickability** - Entire card is an `<a>` tag with `card-link` class
- **Icon display** - Shows goal icon (habits are based on single goals from library)
- **Hover effects** - Title and arrow change color on hover via `group` utilities
- **Inline badge** - Status badge positioned with title for better hierarchy
- **Stats display** - Current streak with fire emoji 🔥 and total completions
- **Routes to habit detail page**
- **Clean, consistent layout** - Matches challenge-list-item pattern

**Layout Structure:**
```blade
<a href="{{ route('habits.show', $habit) }}" class="card card-link group">
    <div class="flex items-center gap-4">
        <!-- Icon (w-12 h-12, slate background) -->
        <!-- Content area with title, badge, frequency, stats -->
        <!-- Chevron arrow (hover effect) -->
    </div>
</a>
```

**Stats Display:**
- Streak: 🔥 emoji + days count (if > 0)
- Completions: Total count

**Badge Types:**
- Archived: 📁 Archived
- Done Today: ✓ Done Today
- Active: 🏃 Active
- Paused: ⏸️ Paused

**Usage:**
```blade
<!-- In habits index page -->
<x-habit-list-item :habit="$habit" />

<!-- In goal detail page (habits tab) -->
<x-habit-list-item :habit="$habit" />

<!-- In user profile (habits tab) -->
<x-habit-list-item :habit="$habit" />

<!-- In admin context -->
<x-habit-list-item :habit="$habit" :adminView="true" />
```

**Design Rationale:**
- Unlike challenges, habits display goal icons because each habit is based on a single goal from the library
- Creates clear visual differentiation from challenges
- Provides quick recognition of habit type via icon

#### x-activity-card
**File:** `resources/views/components/activity-card.blade.php`

**Props:**
- `activity` - Activity model instance

**Features:**
- Different layouts per activity type
- Like button with count
- Timestamps (relative time)
- User avatar and name
- Alpine.js integration for likes

#### x-user-content-tabs
**File:** `resources/views/components/user-content-tabs.blade.php`

**Props:**
- `user` - User model
- `challenges` - Challenge collection (paginated)
- `habits` - Habit collection (paginated) - **Added December 9, 2025**
- `activities` - Activity collection (paginated)
- `defaultTab` - 'activity', 'challenges', or 'habits' (default: 'activity')
- `adminView` - Boolean for admin context

**Features:**
- Alpine.js tab switching with `activeTab` state
- **3 tabs:** Activity, Challenges, Habits (Habits added December 9, 2025)
- Tab count badges with active/inactive styling
- Lazy loading content (hidden tabs use `display: none`)
- Separate pagination for each tab (activities_page, challenges_page, habits_page)
- Passes adminView to child components
- Empty states for each tab type

**Usage:**
```blade
<x-user-content-tabs 
    :user="$user" 
    :challenges="$publicChallenges"
    :habits="$publicHabits"
    :activities="$activities"
    defaultTab="activity" />
```

**Implementation Notes:**
- Each tab maintains its own pagination state via named pagination (`pageName`)
- Challenges tab uses `x-challenge-list-item` component
- Habits tab uses `x-habit-list-item` component (new)
- Activities tab uses `x-activity-card` component
- All tabs support both countable arrays and paginated collections
- Uses CSS component classes for consistency
- Pagination support for both tabs

**Empty States:**
- Activity tab: Uses `empty-state-card` CSS class with proper icon (archive box)
- Challenges tab: Uses `empty-state-card` CSS class with proper icon (clipboard)
- Consistent styling following minimalistic design patterns

**Child Components:**
- `x-activity-card` - For individual activity items
- `x-challenge-list-item` - For individual challenge items

**Tab Navigation:**
- Uses `.tab-header` and `.tab-nav` CSS classes
- Tab buttons with `.tab-button` and `.active` states
- Count badges with `.tab-count-badge` (active/inactive)

#### x-page-header
**File:** `resources/views/components/page-header.blade.php`

**Props:**
- `title` - Page title
- `subtitle` - Optional subtitle
- `actions` - Optional action buttons slot

**Usage:**
```blade
<x-page-header title="My Challenges">
    <x-slot name="actions">
        <x-app-button href="{{ route('challenges.create') }}">
            New Challenge
        </x-app-button>
    </x-slot>
</x-page-header>
```

#### x-goal-list
**File:** `resources/views/components/goal-list.blade.php`

**Props:**
- `goals` - Collection of goals
- `challenge` - Parent challenge
- `date` - Date for completion check

**Features:**
- Checkbox for each goal
- AJAX toggle completion
- Progress calculation
- Animated completion

#### x-modal
**File:** `resources/views/components/modal.blade.php`

**Props:**
- `name` - Unique modal identifier
- `show` - Boolean, initial visibility state
- `maxWidth` - sm/md/lg/xl/2xl (default: '2xl')
- `focusable` - Boolean, auto-focus first element

**Standard Modal Structure:**

All modals should follow this structure using the layout CSS classes:

```blade
<x-modal name="modal-name" :show="$errors->any()">
    <!-- Header with gradient background -->
    <div class="modal-header">
        <div class="modal-header-title">
            <h3>Modal Title</h3>
            <button type="button" 
                    @click="$dispatch('close-modal', 'modal-name')" 
                    class="text-white hover:text-gray-200 text-2xl font-bold leading-none">
                &times;
            </button>
        </div>
    </div>
    
    <!-- Optional: Tabs (if needed) -->
    <div class="modal-tabs">
        <nav>
            <button :class="tab === 'one' ? 'modal-tab active-blue' : 'modal-tab'">
                Tab 1
            </button>
            <button :class="tab === 'two' ? 'modal-tab active-teal' : 'modal-tab'">
                Tab 2
            </button>
        </nav>
    </div>
    
    <!-- Content area (scrollable if needed) -->
    <div class="modal-content">
        <form action="..." method="POST">
            @csrf
            
            <!-- Form fields -->
            
            <!-- Footer with actions -->
            <div class="flex justify-end gap-3 mt-6">
                <button type="button" 
                        @click="$dispatch('close-modal', 'modal-name')"
                        class="btn-secondary">
                    Cancel
                </button>
                <button type="submit" class="btn-primary">
                    Submit
                </button>
            </div>
        </form>
    </div>
</x-modal>
```

**Header Gradient Variants:**

For specific modal types, you can customize the header gradient:

```blade
<!-- Default: Blue to Purple (for general modals) -->
<div class="modal-header">

<!-- Danger: Red to Pink (for delete/destructive actions) -->
<div class="bg-gradient-to-r from-red-600 to-pink-600 px-6 py-4">
    <div class="modal-header-title">
        <h3 class="text-lg font-semibold text-white">Delete Confirmation</h3>
        <button type="button" @click="..." class="text-white hover:text-gray-200 text-2xl font-bold leading-none">&times;</button>
    </div>
</div>

<!-- Success: Green to Teal (for success confirmations) -->
<div class="bg-gradient-to-r from-green-600 to-teal-600 px-6 py-4">
    <div class="modal-header-title">
        <h3 class="text-lg font-semibold text-white">Success</h3>
        <button type="button" @click="..." class="text-white hover:text-gray-200 text-2xl font-bold leading-none">&times;</button>
    </div>
</div>
```

**Available Modal CSS Classes:**
- `.modal-header` - Header with blue/purple gradient
- `.modal-header-title` - Title and close button container
- `.modal-tabs` - Tab navigation container
- `.modal-tab` - Individual tab button
- `.modal-tab.active-blue` - Active tab with blue accent
- `.modal-tab.active-teal` - Active tab with teal accent
- `.modal-content` - Scrollable content area with padding

**Opening/Closing Modals:**
```javascript
// Open modal
$dispatch('open-modal', 'modal-name')

// Close modal
$dispatch('close-modal', 'modal-name')

// Or use Alpine shorthand
@click="$dispatch('close')"
```

**Examples in Codebase:**
- Goal creation: `resources/views/goals/index.blade.php`
- Goal editing: `resources/views/goals/show.blade.php`
- Delete account: `resources/views/profile/partials/delete-user-form.blade.php`
- Quick complete (FAB): `resources/views/layouts/app.blade.php`

#### x-emoji-picker
**File:** `resources/views/components/emoji-picker.blade.php`

**Props:**
- `id` - Input field ID (auto-generated if not provided)
- `name` - Form field name (default: 'icon')
- `value` - Current emoji value
- `placeholder` - Placeholder emoji (default: '🎯')
- `label` - Label text (default: 'Icon (emoji)')
- `maxlength` - Maximum characters (default: '2')
- `disabled` - Boolean, disable the input
- `required` - Boolean, mark as required

**Features:**
- Text input for direct emoji entry
- Picker button showing current emoji (defaults to 🎯 when empty)
- Popover with grid of common emojis (56 emojis)
- Categorized emojis: goals, health, learning, productivity, etc.
- Click-outside to close
- Clear button to remove emoji
- Full dark mode support
- Alpine.js powered interactions

**Usage:**
```blade
<x-emoji-picker 
    id="goal-icon"
    name="icon" 
    :value="$goal->icon"
    placeholder="🎯"
    label="Icon (emoji)"
    required />
```

**Used in:**
- Goals library create/edit modals (`resources/views/goals/index.blade.php`)
- Habit creation form (`resources/views/habits/create.blade.php`)
- Category management (`resources/views/admin/categories/`)

**Alpine.js Component:** `emojiPicker(inputId)` in `resources/js/components/emojiPicker.js`

---

## Form Components

Form components provide reusable, consistent form field patterns across the application. They eliminate code duplication in create and edit forms while maintaining consistent styling, validation display, and dark mode support.

### x-form-field
**File:** `resources/views/components/form-field.blade.php`

**Purpose:** Base wrapper component for form fields with label, icon, error handling

**Props:**
- `label` - Field label text (optional)
- `name` - Field name for error lookup (optional)
- `icon` - SVG path string for label icon (optional)
- `iconColor` - Icon color variant (default: 'blue')
- `optional` - Show "(Optional)" text (default: false)
- `hint` - Helper text below field (optional)
- `error` - Manual error message override (optional)

**Slot:** Field input element

**Features:**
- Auto-displays validation errors from `$errors->first($name)`
- Consistent label styling with icon support
- Error icon and message display
- Optional/required indicator
- Helper hint text
- Dark mode support

**Usage:**
```blade
<x-form-field 
    label="Email Address" 
    name="email"
    icon='<path d="..."/>'
    iconColor="purple"
    hint="We'll never share your email">
    <input type="email" name="email" class="app-input" />
</x-form-field>
```

### x-form-input
**File:** `resources/views/components/form-input.blade.php`

**Purpose:** Text/number input field with label and validation

**Props:**
- `label` - Field label (optional)
- `name` - Input name attribute
- `type` - Input type (default: 'text')
- `value` - Field value (optional)
- `placeholder` - Placeholder text (optional)
- `required` - Mark as required (default: false)
- `icon` - SVG path for label icon (optional)
- `iconColor` - Icon color (default: 'blue')
- `optional` - Show optional indicator (default: false)
- `hint` - Helper text (optional)
- `min` - Min value for number inputs (optional)
- `max` - Max value for number inputs (optional)

**Features:**
- Wraps `x-form-field` component
- `old()` value persistence on validation errors
- Consistent `app-input` styling
- All HTML5 input types supported

**Usage:**
```blade
<x-form-input
    name="challenge_name"
    label="Challenge Name"
    icon='<path d="..."/>'
    iconColor="blue"
    placeholder="e.g., 30-Day Fitness"
    required />

<x-form-input
    name="duration"
    type="number"
    label="Duration (Days)"
    :value="30"
    min="1"
    max="365"
    required />
```

### x-form-textarea
**File:** `resources/views/components/form-textarea.blade.php`

**Purpose:** Multiline textarea field with label and validation

**Props:**
- `label` - Field label (optional)
- `name` - Textarea name attribute
- `value` - Field value (optional)
- `placeholder` - Placeholder text (optional)
- `rows` - Number of rows (default: 3)
- `required` - Mark as required (default: false)
- `icon` - SVG path for label icon (optional)
- `iconColor` - Icon color (default: 'purple')
- `optional` - Show optional indicator (default: true)
- `hint` - Helper text (optional)

**Features:**
- Wraps `x-form-field` component
- `old()` value persistence
- Consistent styling with inputs
- Auto-resizing via CSS

**Usage:**
```blade
<x-form-textarea
    name="description"
    label="Description"
    placeholder="Describe your goal..."
    rows="4"
    optional />
```

### x-form-select
**File:** `resources/views/components/form-select.blade.php`

**Purpose:** Dropdown select field with label and validation

**Props:**
- `label` - Field label (optional)
- `name` - Select name attribute
- `value` - Selected value (optional)
- `options` - Associative array of value => label (optional)
- `required` - Mark as required (default: false)
- `icon` - SVG path for label icon (optional)
- `iconColor` - Icon color (default: 'blue')
- `optional` - Show optional indicator (default: false)
- `hint` - Helper text (optional)
- `placeholder` - Default empty option text (default: 'Select an option...')

**Slot:** Option elements (if not using `options` prop)

**Features:**
- Wraps `x-form-field` component
- `old()` value persistence
- Auto-selects based on value
- Supports both slot and prop-based options
- Empty placeholder option

**Usage with slot:**
```blade
<x-form-select
    name="category_id"
    label="Category"
    placeholder="Choose a category">
    @foreach($categories as $cat)
        <option value="{{ $cat->id }}">
            {{ $cat->icon }} {{ $cat->name }}
        </option>
    @endforeach
</x-form-select>
```

**Usage with options prop:**
```blade
<x-form-select
    name="color"
    label="Color"
    :value="old('color', $category->color)"
    :options="[
        'red' => 'Red',
        'blue' => 'Blue',
        'green' => 'Green',
    ]" />
```

### x-form-checkbox
**File:** `resources/views/components/form-checkbox.blade.php`

**Purpose:** Checkbox field with label and description

**Props:**
- `label` - Checkbox label text
- `name` - Checkbox name attribute
- `value` - Checkbox value (default: '1')
- `checked` - Checked state (default: false)
- `description` - Helper text below label (optional)
- `icon` - SVG path for label icon (optional)
- `iconColor` - Icon color (default: 'blue')

**Features:**
- `old()` state persistence
- Consistent checkbox styling
- Label click to toggle
- Optional description text
- Icon support in label
- Dark mode support

**Usage:**
```blade
<x-form-checkbox
    name="is_public"
    label="Make this public"
    description="Everyone can see this content"
    :checked="true" />

<x-form-checkbox
    name="is_active"
    label="Active"
    icon='<path d="..."/>'
    iconColor="green"
    :checked="$category->is_active" />
```

### x-form-actions
**File:** `resources/views/components/form-actions.blade.php`

**Purpose:** Standardized form submit/cancel button group

**Props:**
- `cancelRoute` - URL for cancel button (optional)
- `cancelText` - Cancel button text (default: 'Cancel')
- `submitText` - Submit button text (default: 'Submit')
- `submitIcon` - Custom SVG for submit button (optional)
- `submitVariant` - Submit button variant (default: 'primary')
- `reverse` - Reverse button order (default: false)

**Slot:** Custom button content (overrides default buttons)

**Features:**
- Consistent border-top separator
- Default checkmark icon for submit
- Back arrow icon for cancel
- Flexible button ordering
- Integrates with `x-app-button` component
- Customizable via slot

**Usage (default buttons):**
```blade
<x-form-actions
    :cancelRoute="route('challenges.index')"
    cancelText="Back"
    submitText="Create Challenge"
    submitVariant="primary" />
```

**Usage (reversed order):**
```blade
<x-form-actions
    :cancelRoute="route('goals.index')"
    submitText="Update Goal"
    submitVariant="gradient-purple"
    reverse />
```

**Usage (custom buttons via slot):**
```blade
<x-form-actions>
    <button type="button" class="btn-secondary">
        Cancel
    </button>
    <button type="submit" class="btn-danger">
        Delete
    </button>
    <button type="submit" class="btn-primary" name="action" value="save">
        Save
    </button>
</x-form-actions>
```

### Form Component Benefits

1. **Consistency** - All forms use same styling and structure
2. **DRY Principle** - No duplicated label/error/icon markup
3. **Validation** - Auto-displays Laravel validation errors
4. **Accessibility** - Proper label associations and ARIA attributes
5. **Dark Mode** - All components support dark mode out of the box
6. **Maintainability** - Change styling in one place affects all forms
7. **Developer Experience** - Simple props interface, less boilerplate

---

## Frequency Selection Components

### x-frequency-selector
**File:** `resources/views/components/frequency-selector.blade.php`

**Purpose:** Shared frequency selection UI for both habits and challenges

**Props:**
- `frequencyType` (string, default: 'daily') - Current frequency type
- `frequencyCount` (integer, default: 1) - How many times per period
- `selectedDays` (array, default: []) - Selected weekdays for weekly frequency

**Features:**
- Visual radio button grid for frequency type (daily/weekly/monthly/yearly)
- Dynamic count selector (1-7) that hides for daily
- Weekly day selector with checkboxes
- Responsive design with Tailwind CSS
- Dark mode support
- Integrates with Alpine.js `habitForm()` component

**Usage in Habit Forms:**
```blade
<form x-data="habitForm('{{ $habit->frequency_type->value }}', {{ $habit->frequency_count }})">
    <x-frequency-selector 
        :frequency-type="$habit->frequency_type->value"
        :frequency-count="$habit->frequency_count"
        :selected-days="$habit->frequency_config['days'] ?? []"
    />
</form>
```

**Usage in Challenge Forms:**
```blade
<form x-data="{ ...challengeForm(), ...habitForm() }">
    <x-frequency-selector />
</form>
```

### x-habit-frequency-form
**File:** `resources/views/components/habit-frequency-form.blade.php`

**Purpose:** Wrapper component that delegates to `x-frequency-selector` for backward compatibility

**Props:**
- Same as `x-frequency-selector`

**Implementation:**
```blade
<x-frequency-selector 
    :frequency-type="$frequencyType"
    :frequency-count="$frequencyCount"
    :selected-days="$selectedDays"
/>
```

**Usage:**
```blade
<x-habit-frequency-form />  <!-- Uses defaults -->
<x-habit-frequency-form 
    :frequency-type="'weekly'"
    :frequency-count="3"
    :selected-days="[1,3,5]"  <!-- Mon, Wed, Fri -->
/>
```

### Alpine.js habitForm Component
**File:** `resources/js/components/habit.js`

**Purpose:** Reactive state management for frequency selection

**Exported Functions:**
- `createHabitForm(initialFrequencyType, initialFrequencyCount)` - Base form manager
- `createHabitFormWithGoalToggle(hasGoalsInLibrary)` - For create view
- `createHabitEditForm(frequencyType, frequencyCount)` - For edit view

**State:**
```javascript
{
    frequencyType: 'daily',      // Current selection
    frequencyCount: 1,           // Times per period
    frequencyPeriod: computed    // 'day', 'week', 'month', 'year'
}
```

**Methods:**
```javascript
init() {
    // Auto-set frequency_count to 1 for daily habits
    this.$watch('frequencyType', value => {
        if (value === 'daily') {
            this.frequencyCount = 1;
        }
    });
}
```

**Usage in Blade:**
```blade
<div x-data="habitForm('weekly', 3)">
    <p x-text="frequencyType"></p>      <!-- 'weekly' -->
    <p x-text="frequencyPeriod"></p>    <!-- 'week' -->
    <p x-text="frequencyCount"></p>     <!-- 3 -->
</div>
```

### Frequency System Architecture

**Shared Between Habits & Challenges:**
- Both use `FrequencyType` enum (daily/weekly/monthly/yearly)
- Both store `frequency_count` (1-7)
- Both use `frequency_config` JSON for additional settings
- Both use the same UI component (`x-frequency-selector`)
- Both use the same Alpine.js logic (`habitForm()`)

**Database Fields:**
```php
// habits table
frequency_type: enum('daily', 'weekly', 'monthly', 'yearly')
frequency_count: integer (1-7)
frequency_config: json  // e.g., {"days": [1,3,5]}

// challenges table (same structure)
frequency_type: enum('daily', 'weekly', 'monthly', 'yearly')
frequency_count: integer (1-7)
frequency_config: json
```

**Model Methods:**
```php
// Both Habit and Challenge models use FrequencyType enum
$habit->getFrequencyDescription();     // "3 times per week"
$challenge->getFrequencyDescription(); // "Daily"
```

---

### Form Component Usage Patterns

**Goal Forms** (modals in `/goals/index.blade.php`):
```blade
<form action="{{ route('goals.store') }}" method="POST">
    @csrf
    
    <x-form-input
        name="name"
        label="Goal Name"
        placeholder="e.g., Exercise"
        required />

    <x-form-select
        name="category_id"
        label="Category"
        placeholder="None">
        @foreach($categories as $cat)
            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
        @endforeach
    </x-form-select>

    <x-form-textarea
        name="description"
        label="Description"
        optional />
</form>
```

**Category Forms** (`/admin/categories/create.blade.php`):
```blade
<form action="{{ route('admin.categories.store') }}" method="POST">
    @csrf
    
    <x-form-input
        name="name"
        label="Category Name *"
        hint="Slug will be auto-generated"
        required />

    <x-form-checkbox
        name="is_active"
        label="Active (visible to users)"
        :checked="true" />

    <x-form-actions
        :cancelRoute="route('admin.categories.index')"
        submitText="Create Category" />
</form>
```

**Challenge Forms** (`/challenges/create.blade.php`):
```blade
<form action="{{ route('challenges.store') }}" method="POST" x-data="{ ...challengeForm(), ...habitForm() }">
    @csrf
    
    <x-form-input
        name="name"
        label="Challenge Name"
        icon='<path d="..."/>'
        iconColor="blue"
        required />

    <x-form-textarea
        name="description"
        label="Description"
        icon='<path d="..."/>'
        iconColor="purple"
        optional />
    
    <!-- Frequency Selection (shared component with habits) -->
    <x-frequency-selector />

    <x-form-checkbox
        name="is_public"
        label="Make this challenge public"
        description="Other users will see this"
        icon='<path d="..."/>' />
</form>
```

---

## Utility Functions

### File: `resources/js/utils/ui.js`

**Functions:**
- `showToast(message, type, duration)` - Show toast notification
  - Types: 'success', 'error', 'info', 'warning'
  - Duration: milliseconds (default: 3000)
- `showError(message)` - Show error toast
- `showSuccess(message)` - Show success toast
- `getCsrfToken()` - Get CSRF token from meta tag
- `createHeaders(extra)` - Create fetch headers with CSRF
- `post(url, data)` - Helper for POST requests

**Usage:**
```javascript
import { showSuccess, post } from '../utils/ui.js';

async function saveData() {
    const response = await post('/api/save', { data: 'value' });
    if (response.ok) {
        showSuccess('Saved!');
    }
}
```

### Toast Notification System

**Files:**
- JavaScript: `resources/js/toast.js`
- Styles: `resources/scss/_toast.scss`
- Layout Integration: `resources/views/layouts/app.blade.php`

**Automatic Flash Message Display:**
Flash messages from Laravel are automatically converted to toast notifications. The layout checks for session flash messages and passes them via data attributes to the JavaScript toast system.

```html
<!-- In app.blade.php -->
<div id="flash-messages" 
     data-message="{{ session('success') }}"
     data-type="success">
</div>
```

**JavaScript Implementation:**
```javascript
// Auto-initializes on DOM ready
export function showToast(message, type = 'success', duration = 3000) {
    // Creates and displays toast notification
}

// Globally available
window.showToast = showToast;
```

**Toast Types & Styling:**
- `success` - Green background (#10b981)
- `error` - Red background (#ef4444)
- `info` - Blue background (#3b82f6)
- `warning` - Yellow background (#f59e0b)

**Toast Behavior:**
- Position: Bottom-right on desktop, bottom-left on mobile (above nav bar)
- Duration: 3 seconds auto-dismiss
- Animation: Smooth fade-in/fade-out with CSS transitions
- Z-index: 9999 (appears above all other elements)
- Responsive: Adjusts position for mobile navigation

**Controller Usage:**
```php
return redirect()->route('resource.show', $resource)
    ->with('success', 'Resource updated successfully!');
```

**Manual JavaScript Usage:**
```javascript
// In browser console or custom scripts
showToast('Your message here', 'success');
showToast('Error occurred', 'error');
showToast('Information', 'info');
showToast('Warning message', 'warning');
```

---

## Footer Component

**File:** `resources/views/components/footer.blade.php`

**Purpose:**
Provides consistent footer across all authenticated pages with useful links and copyright information.

**Location:**
- Included in `resources/views/layouts/app.blade.php`
- Positioned after main content, before FAB and Quick Complete modal
- Responsive design with mobile-optimized layout

**Content:**
- Copyright notice with dynamic year and app name
- Changelog link (route: `changelog`)
- Privacy Policy link (placeholder)
- Terms of Service link (placeholder)

**Styling:**
- Top border to separate from content
- Dark mode support
- Centered on mobile, flex layout on desktop
- Link hover effects with color transitions

**Usage in Layout:**
```blade
<!-- Page Content -->
<main>
    {{ $slot }}
</main>

<!-- Footer -->
<x-footer />
```

---

## Changelog Pages

### Public Changelog View
**File:** `resources/views/changelog.blade.php`

**Purpose:**
Displays published changelog entries to all authenticated users.

**Features:**
- Shows version, title, release date, description, changes
- Major releases highlighted with purple badge
- Paginated list (10 per page)
- Ordered by release date (newest first)
- Empty state with icon and message

**Access:**
- Route: `/changelog`
- Available via footer link

### Admin Changelog Management
**Files:**
- Index: `resources/views/admin/changelogs/index.blade.php`
- Create: `resources/views/admin/changelogs/create.blade.php`
- Edit: `resources/views/admin/changelogs/edit.blade.php`

**Features:**
- CRUD operations for changelog entries
- Draft/Published status management
- Major release flagging
- Markdown support in changes field
- Version and release date tracking

**Admin Access:**
- Routes: `/admin/changelogs/*`
- Link in admin dashboard "Manage Changelogs" card

---

## Tailwind CSS Configuration

### File: `tailwind.config.js`

**Key Settings:**
- Dark mode: class strategy
- Content paths: Blade files, JS files
- Custom colors for brand
- Gradient support
- Safelist for dynamic classes

**Dark Mode:**
```javascript
darkMode: 'class', // Toggle via <html class="dark">
```

**Custom Gradients:**
```javascript
extend: {
    backgroundImage: {
        'gradient-radial': 'radial-gradient(var(--tw-gradient-stops))',
    }
}
```

**Safelisted Classes:**
Dynamic classes that shouldn't be purged:
```javascript
safelist: [
    'bg-blue-500',
    'bg-green-500',
    'text-red-600',
    // ... status colors
]
```

---

## SCSS Custom Styles

### File: `resources/scss/app.scss`

**Includes:**
- Base resets
- Custom component styles
- Animation keyframes
- Utility classes

**Custom Classes:**
- `.btn-primary`, `.btn-secondary` - Button styles
- `.card` - Card component base
- `.progress-ring` - Circular progress indicator
- `.fade-in`, `.slide-up` - Animations

---

## Frontend Patterns

### 1. Progressive Enhancement
- Forms work without JavaScript
- JavaScript enhances UX (AJAX, animations)
- Fallback to full page loads

### 2. Component Composition
```blade
<x-page-header title="Dashboard">
    <x-slot name="actions">
        <x-app-button variant="primary">
            New Challenge
        </x-app-button>
    </x-slot>
</x-page-header>

<div class="grid gap-4">
    <x-stat-card label="Total" :value="$count" />
    <x-stat-card label="Active" :value="$active" />
</div>
```

### 3. AJAX Form Submission
```javascript
async function submitForm(formData) {
    const response = await post('/endpoint', formData);
    if (response.ok) {
        showSuccess('Saved!');
        // Update UI without reload
    } else {
        showError('Failed');
    }
}
```

### 4. Real-time Updates
```blade
<div x-data="{ count: {{ $initialCount }} }">
    <span x-text="count"></span>
    <button @click="count++">Increment</button>
</div>
```

### 5. Conditional Rendering
```blade
<div x-show="isVisible" x-transition>
    Content
</div>

@if($challenge->isActive())
    <button>Pause</button>
@else
    <button>Resume</button>
@endif
```

---

## Asset Build Process

### Development
```bash
npm run dev
```
- Watches for file changes
- Hot module replacement
- Source maps enabled

### Production
```bash
npm run build
```
- Minification
- Tree shaking
- Asset versioning
- CSS purging (removes unused Tailwind classes)

### Vite Configuration
**File:** `vite.config.js`

```javascript
export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/scss/app.scss', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
});
```

---

## Accessibility Considerations

- **Semantic HTML** - Proper heading hierarchy
- **ARIA labels** - Screen reader support
- **Keyboard navigation** - Tab order, focus states
- **Color contrast** - WCAG AA compliance
- **Focus indicators** - Visible focus rings
- **Alt text** - Images have descriptions

---

## CSS Class Refactoring History

### December 2025 - Applied CSS Component Classes

**Objective:** Minimize repetitive Tailwind utility classes by applying the newly created CSS component classes throughout the application.

**Files Refactored:**

1. **Challenge Status Badges** (`badge-*` classes)
   - `resources/views/components/challenge-card.blade.php` - Challenge card status badges
   - `resources/views/admin/challenge-details.blade.php` - Admin challenge status and visibility badges
   - Reduced badge markup from 3-5 lines to 1 line
   - Example: `<span class="px-3 py-1 text-sm font-bold rounded-full bg-green-500 text-white">✓ Completed</span>` → `<span class="badge-completed">✓ Completed</span>`

2. **Tab Navigation** (`tab-header`, `tab-nav`, `tab-button` classes)
   - `resources/views/challenges/index.blade.php` - Challenge filter tabs
   - `resources/views/habits/index.blade.php` - Habit filter tabs
   - `resources/views/components/user-content-tabs.blade.php` - User profile tabs
   - Reduced tab markup from 10+ lines per tab to 2-3 lines
   - Consistent active states across all tab implementations

3. **Empty States** (`empty-state-*` classes)
   - `resources/views/habits/index.blade.php` - No habits message
   - `resources/views/partials/quick-goals.blade.php` - No active challenges
   - `resources/views/partials/quick-habits.blade.php` - No habits due today
   - `resources/views/components/user-content-tabs.blade.php` - No activities
   - Standardized empty state structure across all instances

4. **Navigation Dropdown** (`nav-dropdown`, `nav-dropdown-item` classes)
   - `resources/views/layouts/navigation.blade.php` - Admin menu dropdown
   - Simplified dropdown item markup from 5+ lines to 3 lines per item

5. **Count Badges** (`count-badge-*` classes)
   - `resources/views/goals/show.blade.php` - Challenge and habit count badges, category badges

**Impact:**
- **Code reduction:** Approximately 40-60% fewer lines in template markup for affected components
- **Maintainability:** Style changes now require editing 1 SCSS file instead of multiple Blade templates
- **Consistency:** All similar UI elements now use identical styling
- **Dark mode:** Automatic dark mode support through CSS classes eliminates need for dark: variants in templates

**Usage Guide:**
See `ai/08-css-classes-usage-guide.md` for comprehensive before/after examples and migration patterns.

### December 2025 - App Layout Refactoring

**Objective:** Remove complex generic class combinations from main application layout template and replace with semantic CSS classes.

**New Module:** `resources/scss/components/_layout.scss` (14 classes)

**Files Refactored:**
1. **App Layout** (`resources/views/layouts/app.blade.php`)
   - Body wrapper: 9 classes → 1 class (`app-container`)
   - FAB button: 13+ classes → 2 classes (`fab`, `fab-tooltip`)
   - Modal overlay: 5 classes → 1 class (`modal-overlay`)
   - Modal container: 8 classes → 1 class (`modal-container`)
   - Modal backdrop: 6 classes → 1 class (`modal-backdrop`)
   - Modal panel: 12 classes → 1 class (`modal-panel`)
   - Modal header: 4 classes → 2 classes (`modal-header`, `modal-header-title`)
   - Modal tabs: 10+ classes per tab → 2 classes (`modal-tabs`, `modal-tab` with color variants)
   - Modal content: 6 classes → 1 class (`modal-content`)

**Classes Created:**
- `.app-container` - Main application wrapper with gradient background
- `.fab` - Floating action button (bottom-right)
- `.fab-tooltip` - FAB tooltip on hover
- `.modal-overlay` - Fixed overlay container
- `.modal-backdrop` - Semi-transparent background
- `.modal-container` - Centers modal content
- `.modal-panel` - Modal content panel
- `.modal-header` - Modal header with gradient
- `.modal-header-title` - Header title wrapper
- `.modal-tabs` - Tab navigation in modal
- `.modal-tab` - Individual tab button
- `.modal-tab.active-blue` - Active tab (blue accent)
- `.modal-tab.active-teal` - Active tab (teal accent)
- `.modal-content` - Scrollable modal content area

**Impact:**
- **Code reduction:** Approximately 70-80% fewer classes in layout sections
- **Markup readability:** Semantic class names clarify purpose
- **Modal system:** Complete modal component system with consistent styling
- **FAB component:** Reusable floating action button pattern
- **Build size:** 169.28 kB (no significant increase)

### December 2025 - Navigation Refactoring

**Objective:** Simplify navigation.blade.php by replacing complex inline Tailwind classes with semantic CSS classes.

**Module Updated:** `resources/scss/components/_navigation.scss`

**Files Refactored:**
1. **Navigation Layout** (`resources/views/layouts/navigation.blade.php`)
   - Desktop nav structure: Multiple classes → CSS classes (nav-wrapper, nav-left, nav-links-desktop)
   - Logo: 7+ classes → 3 classes (nav-logo, nav-logo-icon, nav-logo-text)
   - Admin dropdown: 8+ classes → 2 classes (nav-admin-wrapper, nav-admin-button)
   - Theme toggle: 6+ classes → 1 class (nav-button, nav-button-mobile)
   - User menu: 8+ classes → 1 class (nav-user-trigger)
   - Mobile bottom nav: 5+ classes per item → 1-2 classes (bottom-nav-item, bottom-nav-center)

**Classes Created/Updated:**
- `.nav-wrapper` - Main nav flex container
- `.nav-left` - Left section wrapper
- `.nav-logo` - Logo container with link
- `.nav-logo-icon` - White circle icon wrapper
- `.nav-logo-text` - Logo text styling
- `.nav-links-desktop` - Desktop links area
- `.nav-admin-wrapper` - Admin dropdown container
- `.nav-admin-button` - Admin button with active state
- `.nav-settings` - Settings area container
- `.nav-user-trigger` - User dropdown trigger
- `.bottom-nav-center.disabled` - Disabled center button state
- Updated `.bottom-nav-item` - Avatar support with ring

**Impact:**
- **Code reduction:** Approximately 60-70% fewer inline classes
- **Consistency:** All navigation elements use semantic classes
- **Maintainability:** Navigation styling centralized in SCSS
- **Build size:** 194.51 kB (minimal increase for significant improvement)
- **Dark mode:** Automatic support through CSS classes

### December 2025 - Additional Components Refactoring

**Objective:** Continue CSS refactoring initiative by addressing remaining high-impact components with complex inline classes.

**New Module:** `resources/scss/components/_list-items.scss` (goal lists, challenge stats)

**Modules Updated:**
- `resources/scss/components/_badges.scss` - Added gradient and tab count badge variants
- `resources/scss/components/_empty-states.scss` - Added error page components

**Files Refactored:**
1. **Goal Info Lists** (`resources/views/components/goals-info-list.blade.php`)
   - Goal item container: 8+ classes → 1 class (`goal-info-item`)
   - Numbered badge: 7+ classes → 1 class (`numbered-badge`)
   - Content wrapper: 2 classes → 1 class (`goal-info-content`)
   - Title: 3 classes → 1 class (`goal-info-title`)
   - Description: 4 classes → 1 class (`goal-info-description`)

2. **Challenge List Items** (`resources/views/components/challenge-list-item.blade.php`)
   - Challenge stats: 5 classes → 1 class (`challenge-stat-item`)
   - Status badges: 10+ classes → 1 semantic class (`badge-completed`, `badge-challenge-active`, etc.)

3. **User Content Tabs** (`resources/views/components/user-content-tabs.blade.php`)
   - Tab count badges: 7+ dynamic classes → 2 classes with Alpine.js (`tab-count-badge active/inactive`)

4. **Error Pages** (`resources/views/errors/404.blade.php`, `403.blade.php`)
   - Container: 10+ classes → 1 class (`error-page-container`)
   - Content wrapper: 3 classes → 1 class (`error-page-content`)
   - Icon wrapper: 1 class → 1 class (`error-page-icon-wrapper`)
   - Icon circle: 7+ classes → 2 classes (`error-page-icon`, `error-icon-404/403`)
   - Title: 5 classes → 1 class (`error-page-title`)
   - Message: 4 classes → 1 class (`error-page-message`)
   - Actions: 5 classes → 1 class (`error-page-actions`)

5. **Changelog** (`resources/views/changelog.blade.php`)
   - Major release badge: 7+ classes → 1 class (`badge-gradient-purple`)

6. **Quick Habits** (`resources/views/partials/quick-habits.blade.php`)
   - Streak badge: 8+ classes → 1 class (`streak-badge`)

**Classes Created:**
- `.numbered-badge` - Blue-purple gradient number badge
- `.badge-gradient-purple` - Purple-pink gradient badge
- `.tab-count-badge` - Dynamic tab count with active/inactive states
- `.goal-info-item` - Goal list item container
- `.goal-info-content` - Goal content wrapper
- `.goal-info-title` - Goal title
- `.goal-info-description` - Goal description
- `.challenge-stat-item` - Challenge stat item (icon + text)
- `.error-page-container` - Full-screen error layout
- `.error-page-content` - Error content wrapper
- `.error-page-icon-wrapper` - Icon container
- `.error-page-icon` - Error icon circle with variants (404, 403, 500)
- `.error-page-title` - Error page heading
- `.error-page-message` - Error message text
- `.error-page-actions` - Action buttons container

**Impact:**
- **Code reduction:** 50-70% fewer inline classes across affected components
- **New patterns:** Established reusable patterns for list items, error pages, and dynamic badges
- **Build size:** 201.75 kB (gzipped: 22.05 kB) - minimal increase for comprehensive improvements
- **Consistency:** Error pages now share consistent styling patterns
- **Alpine.js integration:** Tab count badges work seamlessly with Alpine.js reactivity

### December 9, 2025 - Welcome Page Redesign

**Objective:** Create an appealing, conversion-focused homepage with compelling content that showcases the app's core value proposition and features.

**Module Updated:** `resources/scss/pages/_welcome.scss`

**Files Refactored:**
1. **Welcome Page** (`resources/views/public/welcome.blade.php`)
   - Complete redesign with 6 major sections
   - Hero section with gradient title and clear CTAs
   - Features grid showcasing 4 core features
   - "How It Works" 3-step process
   - Benefits section with visual placeholder
   - Social proof stats section
   - Final CTA section

**New SCSS Classes Created:**

**Hero Section:**
```scss
.hero                     // Hero container (pt-24, pb-32, text-center)
.hero-title               // Large gradient title (5xl-7xl, gradient text)
.hero-subtitle            // Hero subtitle (xl-2xl, muted)
.hero-cta                 // CTA buttons container (flex, gap)
```

**Features Section:**
```scss
.features                 // Features section wrapper (py-24)
.features-grid            // 4-column responsive grid
.feature-card             // Individual feature card with hover effect
.feature-icon             // Icon wrapper (14x14, rounded-2xl, slate bg)
.feature-title            // Feature title (lg, font-semibold)
.feature-description      // Feature description (sm, muted)
```

**How It Works Section:**
```scss
.how-it-works             // Section wrapper (py-24, bg-gray-50/900)
.steps-grid               // 3-column responsive grid
.step-card                // Individual step card
.step-number              // Numbered circle badge (slate-700)
.step-title               // Step title (xl, font-semibold)
.step-description         // Step description (muted)
```

**Benefits Section:**
```scss
.benefits                 // Benefits section wrapper (py-24)
.benefits-grid            // 2-column layout with visual
.benefit-content          // Content side container
.benefit-item             // Individual benefit item (flex, gap)
.benefit-icon             // Benefit icon wrapper (10x10, rounded-xl)
.benefit-text             // Benefit text container
.benefit-visual           // Visual placeholder container
.placeholder-image        // Image placeholder styling
```

**Stats Section:**
```scss
.stats                    // Stats section (py-16, slate bg)
.stats-grid               // 4-column stats grid
.stat-item                // Individual stat container
.stat-value               // Large stat number (4xl-5xl, bold, white)
.stat-label               // Stat label (slate-300, uppercase)
```

**Final CTA Section:**
```scss
.final-cta                // Final CTA wrapper (py-24, text-center)
.final-cta-title          // CTA title (4xl-5xl, bold)
.final-cta-subtitle       // CTA subtitle (xl, muted)
```

**General Section Classes:**
```scss
.section                  // Container with responsive padding
.section-header           // Section header wrapper (text-center, mb-4)
.section-title            // Section title (3xl-4xl, bold)
.section-subtitle         // Section subtitle (lg, muted, max-w-2xl)
```

**Content Highlights:**

**Hero:**
- Headline: "Turn Goals Into Habits. Habits Into Results."
- Value proposition focused on transformation and results
- Dual CTAs for auth/non-auth states

**4 Core Features:**
1. **Time-Bound Challenges** - 30/60/90-day challenges with deadlines
2. **Flexible Habit Tracking** - Daily/weekly/monthly with streak tracking
3. **Progress Analytics** - Visual stats and completion reports
4. **Social Accountability** - Follow friends, share progress, community

**3-Step Process:**
1. **Set Your Goals** - Create challenges or habits from library
2. **Track Daily Progress** - Check off goals, build streaks, add notes
3. **Celebrate Success** - Complete milestones, view analytics, share wins

**Benefits (Why It Works):**
- Clear Structure - Time-bound deadlines prevent "someday" goals
- Streak Power - Visual momentum building with progress saved
- Social Support - Community accountability and motivation
- Data-Driven Insights - Track what works with completion analytics

**Social Proof Stats:**
- 10,000+ Goals Completed
- 500+ Active Users
- 1,200+ Challenges Created
- 85% Success Rate

**Visual Placeholder:**
- Location: Benefits section, right side
- Content suggestion: Dashboard screenshot with active challenge, daily goals, progress bars, streak counter
- Responsive: Stacks on mobile, side-by-side on desktop

**Design Philosophy:**
- **Minimalistic** - Clean layout with ample whitespace
- **Conversion-focused** - Multiple CTAs (hero, final)
- **Benefit-driven** - Focus on transformation, not just features
- **Social proof** - Stats section builds trust
- **Visual hierarchy** - Large gradient titles, clear sections
- **Dark mode ready** - All classes support theme switching

**Impact:**
- **Conversion optimization** - Clear value prop and multiple CTAs
- **User education** - Explains what the app does and how it works
- **Visual appeal** - Professional, modern design with gradient accents
- **SEO-friendly** - Semantic HTML with descriptive headings
- **Placeholder system** - Easy for user to add custom images/GIFs
- **Build size** - 105.12 kB CSS (maintained through efficient SCSS)

**Usage Pattern:**
The welcome page now follows a proven SaaS landing page structure:
1. Hero (attention) → 2. Features (interest) → 3. How It Works (understanding) → 4. Benefits (desire) → 5. Social Proof (trust) → 6. Final CTA (action)

---

## Performance Optimizations

1. **Lazy loading** - Images and heavy components
2. **Code splitting** - Vite chunks JavaScript
3. **CSS purging** - Tailwind removes unused classes
4. **Asset versioning** - Cache busting
5. **Minimal Alpine** - Lightweight framework (~15KB)
6. **Eager loading** - Prevent N+1 queries in Blade
