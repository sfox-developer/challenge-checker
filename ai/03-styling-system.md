# Styling System - SCSS + Tailwind

**Last Updated:** December 13, 2025  
**Purpose:** Complete guide to SCSS architecture and Tailwind patterns

---

## 🎯 Styling Philosophy

### Design Principles
1. **Minimalistic** - Single accent color (slate-700), clean aesthetics
2. **Consistent** - Reusable SCSS classes for repeated patterns
3. **Semantic** - Class names describe purpose, not appearance
4. **Progressive** - Dark mode support built-in
5. **Performant** - Tailwind JIT compilation for optimal bundle size

### When to Use What

**Use SCSS Classes When:**
- ✅ Pattern appears 3+ times across the app
- ✅ Styling has semantic meaning (e.g., `.badge-completed`, `.hero-title`)
- ✅ Dark mode handling needs to be centralized
- ✅ Pattern might need global style updates

**Use Tailwind Utilities When:**
- ✅ Styling is unique to one component
- ✅ Need precise spacing/sizing adjustments
- ✅ Prototyping and exploring designs
- ✅ Pattern is too simple to warrant a class (e.g., single utility)

---

## 📁 SCSS Architecture

### File Structure (SMACSS/ITCSS Pattern)

```
resources/scss/
├── app.scss                    # Main entry point
├── abstracts/                  # No CSS output
│   ├── _variables.scss        # Color palette, spacing
│   └── _mixins.scss           # Reusable mixins
├── base/                       # Global foundational styles
│   ├── _typography.scss       # h1, h2, text classes
│   └── _utilities.scss        # .section, .container
├── components/                 # Reusable component classes
│   ├── _accents.scss          # Decorative accents (eyebrows, badges, dividers)
│   ├── _animations.scss       # Scroll & immediate animations
│   ├── _badges.scss           # Status badges
│   ├── _buttons.scss          # Button variants
│   ├── _cards.scss            # Card patterns
│   ├── _changelog.scss        # Changelog styles
│   ├── _empty-states.scss     # Empty state patterns
│   ├── _forms.scss            # Form components
│   ├── _lists.scss            # List styles
│   ├── _modals.scss           # Modal styles
│   └── _nav.scss              # Navigation
├── pages/                      # Page-specific styles ONLY
│   └── _welcome.scss          # Landing page classes
└── vendors/                    # Third-party overrides
    └── _toast.scss            # Toast notifications
```

### Import Order (app.scss)

```scss
// 1. ABSTRACTS - Variables and mixins (no CSS output)
@use 'abstracts/variables';
@use 'abstracts/mixins';

// 2. BASE - Typography and utilities
@use 'base/typography';
@use 'base/utilities';

// 3. COMPONENTS - Reusable component classes
@use 'components/buttons';
@use 'components/nav';
@use 'components/cards';
@use 'components/forms';
@use 'components/badges';
@use 'components/modals';
@use 'components/empty-states';
@use 'components/changelog';

// 4. PAGES - Page-specific styles (add as needed)
@use 'pages/welcome';

// 5. VENDORS - Third-party overrides
@use 'vendors/toast';

// 6. TAILWIND - Framework (must use @import, not @use)
@import 'tailwindcss/base';
@import 'tailwindcss/components';
@import 'tailwindcss/utilities';

// 7. GLOBAL OVERRIDES
body {
    font-family: 'Inter', 'Figtree', ui-sans-serif, system-ui, sans-serif;
}
```

---

## 📝 Component Classes Reference

### Typography (`base/_typography.scss`)

**Headings:**
```scss
.h1 {
    @apply text-4xl md:text-5xl font-bold;
    @apply text-gray-900 dark:text-white;
}

.h2 {
    @apply text-2xl md:text-3xl font-bold;
    @apply text-gray-900 dark:text-white;
}

.h3 {
    @apply text-xl font-semibold;
    @apply text-gray-900 dark:text-white;
}
```

**Body Text:**
```scss
.text-body {
    @apply text-gray-700 dark:text-gray-300;
}

.text-muted {
    @apply text-gray-600 dark:text-gray-400;
}

.text-help {
    @apply text-sm text-gray-500 dark:text-gray-400;
}
```

**Links:**
```scss
.text-link {
    @apply text-slate-700 dark:text-slate-400;
    @apply hover:underline;
}

.link-muted {
    @apply text-gray-600 dark:text-gray-400;
    @apply hover:text-slate-700 dark:hover:text-slate-300;
}
```

**Usage Example:**
```blade
<h1 class="h1">Page Title</h1>
<h2 class="h2">Section Heading</h2>
<p class="text-body">Body content goes here.</p>
<p class="text-help">Helper text for the user.</p>
<a href="#" class="text-link">Learn more</a>
```

---

### Utilities (`base/_utilities.scss`)

**Layout Containers:**
```scss
.section {
    @apply py-12 md:py-20;  // Vertical section spacing
}

.container {
    @apply max-w-7xl mx-auto px-6;  // Horizontal content constraint
}
```

**Usage Example:**
```blade
<div class="section">
    <div class="container">
        <!-- Content constrained to max-width with padding -->
    </div>
</div>
```

---

### Shadow System

**Design Philosophy:**  
Unified two-tier shadow system provides consistent depth hierarchy across all card-like elements. Shadows are subtle in light mode and stronger in dark mode for proper visibility.

**Tier 1 - Base State:**  
Subtle elevation for resting state of cards and list items.

```scss
// Light mode
box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);

// Dark mode
box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
```

**Tier 2 - Interactive State:**  
Enhanced elevation for hover states and prominent elements (hero sections, featured content).

```scss
// Light mode
box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);

// Dark mode
box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
```

**Application Examples:**

```scss
// Base card component
.card {
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    
    .dark & {
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
    }
}

// Interactive card with hover
.card-link {
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    transition: box-shadow 300ms;
    
    .dark & {
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
    }
    
    &:hover {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        
        .dark & {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        }
    }
}

// Prominent hero elements (no hover needed)
.hero-image {
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    
    .dark & {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
    }
}
```

**Where Applied:**
- `.card` and `.card-link` (components/_cards.scss)
- `.challenge-list-item` (components/_challenges.scss)
- `.habit-list-item` (components/_habits.scss)
- `.feature-card` on welcome page (pages/_welcome.scss)
- `.hero-image` and `.hero-video-container` (pages/_welcome.scss)
- `.dashboard-stat-icon` (reduced intensity for icon backgrounds)

**Exceptions:**
- **Modals and dropdowns**: Keep heavier shadows (e.g., `shadow-2xl`) to emphasize overlay depth
- **Tabs**: No shadow - uses border and background for differentiation
- **Flat UI elements**: Buttons, badges, inputs use borders/backgrounds instead

**Transition Timing:**  
Always use `duration-300` for shadow transitions to match border and color changes:

```scss
transition: box-shadow 300ms, border-color 300ms, color 300ms;
// or with Tailwind
@apply transition-all duration-300;
```

**Design Rationale:**
1. **Two tiers only** - Prevents shadow proliferation and maintains clear hierarchy
2. **Subtle by default** - Modern UIs favor minimalism; depth should enhance, not dominate
3. **Stronger in dark mode** - Compensates for reduced contrast in dark backgrounds
4. **Consistent spread** - Same values everywhere make the system predictable and maintainable

---

### Animations (`components/_animations.scss`)

**Two-class system for scroll/load animations:**

1. **Base class** (always present): `.animate` - defines transition properties
2. **State class** (removed to trigger): `.animate-hidden-*` - defines initial hidden state

**Available animation states:**
```scss
.animate-hidden-fade-up-sm    // Small upward movement (1rem)
.animate-hidden-fade-up       // Larger upward movement (2rem)
.animate-hidden-scale-up      // Scale from 95%
.animate-hidden-slide-left    // Slide from left (-1.25rem)
.animate-hidden-slide-right   // Slide from right (2rem)
.animate-hidden-fade          // Simple fade (no movement)
```

**Stagger delays:**
```scss
.animate-delay-100    // 100ms delay
.animate-delay-200    // 200ms delay
.animate-delay-300    // 300ms delay
.animate-delay-400    // 400ms delay
```

**Usage with Alpine.js:**
```blade
<!-- Immediate animation (page load) -->
<h1 class="hero-title animate animate-hidden-fade-up-sm" 
    x-data="{}" 
    x-init="setTimeout(() => { $el.classList.remove('animate-hidden-fade-up-sm') }, 100)">
    Hero Title
</h1>

<!-- Scroll-triggered animation -->
<div class="feature-card animate animate-hidden-fade-up" 
     x-data="{}" 
     x-intersect="$el.classList.remove('animate-hidden-fade-up')">
    Content fades in when scrolled into view
</div>

<!-- With stagger delay -->
<div class="feature-card animate animate-hidden-fade-up animate-delay-200" 
     x-data="{}" 
     x-intersect="$el.classList.remove('animate-hidden-fade-up')">
    Delayed by 200ms
</div>
```

**Why this approach:**
- Base `.animate` class stays on element, maintaining transition properties
- Removing state class (`.animate-hidden-*`) triggers the animation
- Transition remains active throughout element's lifecycle
- Works with Alpine.js `x-intersect` for scroll animations
- Works with `x-init` + setTimeout for immediate/staggered page load animations

**Properties:**
- Duration: 700ms
- Easing: cubic-bezier(0, 0, 0.2, 1) (ease-out)
- Transition: opacity and transform properties

---

### Badges (`components/_badges.scss`)

**Challenge Status:**
```scss
.badge-challenge-active    // 🏃 Active - Orange
.badge-challenge-completed // ✓ Completed - Green
.badge-challenge-paused    // ⏸️ Paused - Gray
.badge-challenge-draft     // 📝 Draft - Blue
.badge-challenge-archived  // 📁 Archived - Gray
```

**Habit Status:**
```scss
.badge-habit-active        // Active - Orange
.badge-habit-archived      // Archived - Gray
```

**Other Badges:**
```scss
.badge-frequency           // Progress info (e.g., "2 of 3 this week")
.badge-info-count          // Usage count (e.g., "3 challenges")
.badge-category            // Goal category (e.g., "🏃 Fitness")
.badge-admin               // Admin role badge
```

**Tab Count Badge:**
```scss
.tab-count-badge           // Base badge for tab counts
.tab-count-badge.active    // Active tab count
.tab-count-badge.inactive  // Inactive tab count
```

**Usage Example:**
```blade
<!-- Challenge status -->
<span class="badge-challenge-active">🏃 Active</span>
<span class="badge-challenge-completed">✓ Completed</span>

<!-- Habit status -->
<span class="badge-habit-active">Active</span>

<!-- Progress info -->
<span class="badge-frequency">2 of 3 this week</span>

<!-- Category -->
<span class="badge-category">🏃 Fitness</span>

<!-- Tab count (with Alpine.js) -->
<span class="tab-count-badge" :class="activeTab === 'challenges' ? 'active' : 'inactive'">
    {{ $count }}
</span>
```

---

### Buttons (`components/_buttons.scss`)

**Standard Buttons:**
```scss
.btn               // Base button class
.btn-primary       // Primary action (slate-700 bg, white text)
.btn-secondary     // Secondary action (transparent, bordered)
.btn-danger        // Destructive action (red)
```

**Large Buttons (CTAs):**
```scss
.btn-lg            // Large size modifier
.btn-large         // Alternative large button class
.btn-large-primary // Large primary CTA
.btn-large-secondary // Large secondary CTA
```

**Icon Buttons:**
```scss
.btn-icon          // Icon-only button (square, centered icon)
```

**Usage Example:**
```blade
<!-- Standard buttons -->
<button class="btn btn-primary">Save Challenge</button>
<button class="btn btn-secondary">Cancel</button>
<button class="btn btn-danger">Delete</button>

<!-- Large CTAs -->
<a href="{{ route('register') }}" class="btn btn-primary btn-lg">
    Get Started Free
</a>

<!-- Icon button -->
<button class="btn-icon">
    <svg>...</svg>
</button>
```

**Note:** Buttons now use box-shadows instead of borders for a more minimalistic appearance.

---

### Cards (`components/_cards.scss`)

**Base Card:**
```scss
.card              // Base card container with glassmorphism effect
.card-link         // Clickable card with hover states
.card-header       // Card header section
.card-body         // Card main content
.card-footer       // Card footer section
```

**Dashboard Cards:**
```scss
.dashboard-stat-card              // Statistics display card
.dashboard-stat-card-accent-top   // Stat card with top gradient accent bar
```

**Dashboard Layouts:**
```scss
.dashboard-grid-stats    // 2 to 4 column responsive grid for stat cards (equal heights)
.dashboard-grid-cards    // 1 to 3 column responsive grid for cards
.dashboard-grid-3-cols   // 3 column responsive grid for goals/items
```

**List Item Components:**
```scss
.challenge-list-item    // Challenge list item (components/_challenges.scss)
.habit-list-item        // Habit list item (components/_habits.scss)
.challenge-stat-item    // Inline stat item (icon + text)
```

**Features:**
- Gradient accent bars (4px on left for list items, 3px on top for stat cards)
- Glassmorphism effect with backdrop blur
- Hover states with smooth transitions
- Dark mode support with different shadows/backgrounds
- Consistent gradient: #667eea → #764ba2 (light), #818cf8 → #a78bfa (dark)
- Challenge and habit styles in separate component files for better organization

**Usage Examples:**
```blade
<!-- Basic card -->
<div class="card">
    <div class="card-header">
        <h3>Card Title</h3>
    </div>
    <div class="card-body">
        <p>Card content goes here.</p>
    </div>
</div>

<!-- Challenge list item (used in x-challenges.challenge-list-item component) -->
<a href="..." class="challenge-list-item group">
    <!-- Has automatic left gradient accent bar -->
    <div class="flex items-center gap-4">
        <div class="flex-1">
            <h4>Challenge Name</h4>
            <div class="flex gap-4">
                <div class="challenge-stat-item">
                    <svg>...</svg>
                    <span>30 days</span>
                </div>
            </div>
        </div>
    </div>
</a>

<!-- Habit list item (used in x-habits.habit-list-item component) -->
<a href="..." class="habit-list-item group">
    <!-- Has automatic left gradient accent bar -->
    <div class="flex items-center gap-4">
        <div class="icon">...</div>
        <div class="flex-1">
            <h4>Habit Name</h4>
        </div>
    </div>
</a>
```

**Design Notes:**
- List items have 4px gradient accent on left that expands to 5px on hover
- Accent bar matches modal/stat-card/tab design language
- All use same gradient for consistency across application

---

### Forms (`components/_forms.scss`)

**Form Elements:**
```scss
.form-field        // Form field wrapper
.form-label        // Form label
.form-input        // Text input
.form-textarea     // Textarea
.form-select       // Select dropdown
.form-checkbox     // Checkbox input
.form-radio        // Radio input
.form-error        // Error message
.form-help         // Help text
```

**Usage Example:**
```blade
<div class="form-field">
    <label class="form-label">Challenge Name</label>
    <input type="text" class="form-input" name="name">
    <p class="form-help">Enter a descriptive name for your challenge.</p>
</div>
```

---

### Tabs (`components/_tabs.scss`)

Navigation tabs for filtering and switching between content views.

**Classes:**
```scss
.tab-header           // Tab container with border and background
.tab-nav              // Flex wrapper for tab buttons
.tab-button           // Individual tab button
.tab-button.active    // Active tab state with gradient accent
.tab-count-badge      // Count badge inside tabs
```

**Features:**
- Gradient accent bar on active tab (matches modal/stat-card design)
- Responsive wrapping for mobile
- Smooth transitions
- Support for count badges
- Dark mode support

**Usage Example:**
```blade
<!-- With Alpine.js for client-side filtering -->
<div class="tab-header animate animate-hidden-fade-up"
     x-data="{}"
     x-intersect="setTimeout(() => $el.classList.remove('animate-hidden-fade-up'), 600)">
    <nav class="tab-nav">
        <button @click="activeFilter = 'all'" 
                :class="activeFilter === 'all' ? 'tab-button active' : 'tab-button'">
            All
            <span class="tab-count-badge" :class="activeFilter === 'all' ? 'active' : 'inactive'">
                {{ $allCount }}
            </span>
        </button>
        <button @click="activeFilter = 'active'" 
                :class="activeFilter === 'active' ? 'tab-button active' : 'tab-button'">
            Active
            <span class="tab-count-badge" :class="activeFilter === 'active' ? 'active' : 'inactive'">
                {{ $activeCount }}
            </span>
        </button>
    </nav>
</div>

<!-- With links for server-side filtering -->
<div class="tab-header">
    <nav class="tab-nav">
        <a href="{{ route('habits.index', ['filter' => 'active']) }}" 
           class="@if($filter === 'active') tab-button active @else tab-button @endif">
            Active
            <span class="tab-count-badge {{ $filter === 'active' ? 'active' : 'inactive' }}">
                {{ $activeCount }}
            </span>
        </a>
        <a href="{{ route('habits.index', ['filter' => 'all']) }}" 
           class="@if($filter === 'all') tab-button active @else tab-button @endif">
            All
            <span class="tab-count-badge {{ $filter === 'all' ? 'active' : 'inactive' }}">
                {{ $allCount }}
            </span>
        </a>
    </nav>
</div>
```

**Design Notes:**
- Active tab has 3px gradient accent bar at bottom
- Gradient matches modal accent (purple: #667eea → #764ba2)
- No color variants needed - single gradient design for consistency
- Count badges change style based on active state
- Works with both `<button>` (Alpine.js) and `<a>` (links) elements

---

### Lists (`components/_lists.scss`)

```scss
.list-styled          // Standard list with spacing
.list-styled-ordered  // Ordered list variant
.list-styled-compact  // Compact version with less spacing
```

**Usage Example:**
```blade
<ul class="list-styled">
    <li><strong>First item:</strong> Description here</li>
    <li><strong>Second item:</strong> Another description</li>
    <li>Regular list item</li>
</ul>

<!-- For ordered lists -->
<ol class="list-styled-ordered">
    <li>Step one</li>
    <li>Step two</li>
</ol>

<!-- Compact version for UI elements -->
<ul class="list-styled-compact">
    <li>Error message one</li>
    <li>Error message two</li>
</ul>
```

---

### Accents (`components/_accents.scss`)

Decorative elements that add visual interest and polish to landing pages.

```scss
.eyebrow                  // Small label above headings
.lottie-underline         // Animated Lottie underline wrapper
.lottie-underline-animation // Lottie animation container
.accent-badge             // Pill-shaped badge (neutral)
.accent-badge-primary     // Primary colored badge
.accent-badge-success     // Success/green badge
.accent-circle            // Decorative background circle
.accent-circle-sm         // Small circle (16-24px)
.accent-circle-lg         // Large circle (32-48px)
.accent-dots              // Dot pattern background
.step-number-enhanced     // Gradient number badge
.icon-accent              // Icon with subtle glow
.section-divider          // Horizontal divider with dot
.text-highlight           // Highlighted text with background
```

**Usage Examples:**
```blade
<!-- Eyebrow text -->
<div class="eyebrow text-center">Features</div>
<h2>Main Heading</h2>

<!-- Lottie animated underline (static) -->
<h2>Transform Your <span class="lottie-underline">Habits<span class="lottie-underline-animation" 
    x-lottie="{ path: '/animations/line.json', loop: false, autoplay: true, stretch: true }"></span></span></h2>

<!-- Lottie animated underline (scroll-based) -->
<h2>Everything You Need to <span class="lottie-underline">Succeed<span class="lottie-underline-animation" 
    x-lottie="{ path: '/animations/line.json', loop: false, autoplay: false, stretch: true, scrollProgress: true }"></span></span></h2>

<!-- Badges -->
<span class="accent-badge">New</span>
<span class="accent-badge-success">✓ 100% Free</span>

<!-- Enhanced step numbers -->
<div class="step-number-enhanced">1</div>

<!-- Section divider -->
<div class="section-divider"></div>

<!-- Text highlight -->
<p>This is <span class="text-highlight">important</span> text.</p>
```

**Design Principles:**
- Use eyebrows sparingly (1-2 per page)
- Lottie underlines for key words in headings (static or scroll-based)
- Badges for status or promotional messages
- Enhanced numbers for step-by-step sections
- Section dividers between major content blocks

---

### Empty States (`components/_empty-states.scss`)

```scss
.empty-state       // Container
.empty-state-icon  // Large icon (emoji or SVG)
.empty-state-title // Heading
.empty-state-text  // Description
.empty-state-cta   // Call-to-action button
```

**Usage Example:**
```blade
<div class="empty-state">
    <div class="empty-state-icon">📅</div>
    <h3 class="empty-state-title">No challenges yet</h3>
    <p class="empty-state-text">
        Create your first challenge to get started
    </p>
    <div class="empty-state-cta">
        <a href="{{ route('challenges.create') }}" class="btn btn-primary">
            Create Challenge
        </a>
    </div>
</div>
```

---

### Page Headers

**Standard Page Header:**
```scss
.page-header         // Container
.page-header-content // Content wrapper
.page-header-icon    // Icon container
.page-header-title   // Page title
.page-header-actions // Action buttons
```

**Usage Example:**
```blade
<div class="page-header">
    <div class="page-header-content">
        <div class="page-header-icon">
            <svg>...</svg>
        </div>
        <h2 class="page-header-title">My Challenges</h2>
    </div>
    <div class="page-header-actions">
        <a href="{{ route('challenges.create') }}" class="btn btn-primary">
            Create Challenge
        </a>
    </div>
</div>
```

---

### Section Headers

```scss
.section-header    // Large section heading
.section-header-sm // Small section heading (uppercase)
```

**Usage Example:**
```blade
<h3 class="section-header">Statistics</h3>
<h4 class="section-header-sm">Completed Goals</h4>
```

---

## 🎨 Color System

### Palette

```scss
// Primary Accent
$accent: slate-700;
$accent-dark: slate-400;

// Backgrounds
$bg-light: white;
$bg-dark: gray-800;
$bg-secondary-light: gray-50;
$bg-secondary-dark: gray-900;

// Text
$text-light: gray-900;
$text-dark: white;
$text-muted-light: gray-600;
$text-muted-dark: gray-400;

// Borders
$border-light: gray-200;
$border-dark: gray-700;

// Status Colors
$success: green-500;
$warning: orange-500;
$error: red-500;
```

### Usage in SCSS

```scss
// Light mode
background-color: theme('colors.slate.700');

// Dark mode (Tailwind approach)
@apply bg-slate-700 dark:bg-slate-400;
```

---

## 📱 Responsive Design Patterns

### Mobile-First Approach

```scss
// Base styles (mobile)
.component {
    @apply text-sm p-4;
}

// Tablet and up
@screen md {
    .component {
        @apply text-base p-6;
    }
}

// Desktop and up
@screen lg {
    .component {
        @apply text-lg p-8;
    }
}
```

### Common Responsive Patterns

**Grid Layouts:**
```blade
<!-- 1 column mobile, 2 tablet, 4 desktop -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
    <!-- Cards -->
</div>
```

**Flex Direction:**
```blade
<!-- Stack mobile, row tablet+ -->
<div class="flex flex-col md:flex-row gap-4">
    <!-- Items -->
</div>
```

**Text Sizing:**
```blade
<h1 class="text-3xl md:text-4xl lg:text-5xl">Heading</h1>
```

**Spacing:**
```blade
<div class="py-8 md:py-12 lg:py-16">Content</div>
```

---

## 🌙 Dark Mode

### Tailwind Dark Mode

Challenge Checker uses **class-based dark mode** (not media query).

**Configuration (tailwind.config.js):**
```js
module.exports = {
    darkMode: 'class',
    // ...
}
```

**Usage in HTML:**
```blade
<!-- Light mode: white bg, dark text -->
<!-- Dark mode: dark bg, light text -->
<div class="bg-white dark:bg-gray-800 text-gray-900 dark:text-white">
    Content
</div>
```

### Dark Mode Patterns

**Backgrounds:**
```blade
bg-white dark:bg-gray-800           <!-- Primary bg -->
bg-gray-50 dark:bg-gray-900         <!-- Secondary bg -->
bg-slate-100 dark:bg-slate-900      <!-- Accent bg -->
```

**Text:**
```blade
text-gray-900 dark:text-white       <!-- Body text -->
text-gray-600 dark:text-gray-400    <!-- Muted text -->
text-slate-700 dark:text-slate-400  <!-- Accent text -->
```

**Borders:**
```blade
border-gray-200 dark:border-gray-700
```

**In SCSS:**
```scss
.component {
    @apply bg-white dark:bg-gray-800;
    @apply text-gray-900 dark:text-white;
    @apply border-gray-200 dark:border-gray-700;
}
```

---

## ✨ Animation Patterns

### Alpine.js Animations (Scroll-Triggered)

**Required:** Alpine.js Intersect plugin (installed via npm)

**Immediate Animations (Hero Elements):**
```blade
<h1 class="opacity-0 translate-y-4 transition-all duration-700 ease-out"
    x-data="{}"
    x-init="setTimeout(() => { $el.classList.remove('opacity-0', 'translate-y-4') }, 100)">
    Hero Title
</h1>
```

**Scroll-Triggered Animations:**
```blade
<div class="opacity-0 translate-y-8 transition-all duration-700 ease-out"
     x-data="{}"
     x-intersect="$el.classList.remove('opacity-0', 'translate-y-8')">
    Content fades in when scrolled into view
</div>
```

**Staggered Animations (Lists):**
```blade
@foreach($items as $index => $item)
    <div class="opacity-0 translate-y-8 transition-all duration-700 ease-out"
         x-data="{}"
         x-intersect="setTimeout(() => $el.classList.remove('opacity-0', 'translate-y-8'), {{ $index % 3 * 100 }})">
        {{ $item->name }}
    </div>
@endforeach
```

**Animation Utilities:**
```scss
// Initial state
opacity-0           // Hidden
translate-y-8       // Moved down
translate-y-4       // Slightly down (hero)
scale-95            // Slightly scaled down

// Transition
transition-all      // Animate all properties
duration-700        // 700ms duration
ease-out            // Easing function
```

**Stagger Delays:**
- 0ms, 100ms, 200ms, 300ms for sequential items
- Use modulo for long lists: `{{ $index % 3 * 100 }}`

---

## 🎯 Best Practices

### 1. Class Naming
- Use **kebab-case** for all SCSS classes
- Be **semantic** (describe purpose, not appearance)
- Prefix with **context** when needed (`.badge-challenge-active`, `.page-header`)

### 2. Component Organization
- Keep components **small and focused**
- Group related classes in **one file**
- Use `@apply` for Tailwind utilities in SCSS

### 3. Avoiding Duplication
- If a pattern appears **3+ times**, create a class
- Document new classes in this guide
- Update relevant component files

### 4. Tailwind Usage
- Use utilities for **one-off styling**
- Combine utilities for **prototyping**
- Extract to SCSS class when **pattern is established**

### 5. Dark Mode
- Always include **dark mode variants**
- Test both modes before deployment
- Use Tailwind's `dark:` prefix consistently

### 6. Performance
- Tailwind JIT compiles **only used classes**
- Avoid custom CSS when Tailwind provides utilities
- Purge unused styles in production

---

## 📚 Quick Reference

### Most Common Classes

**Typography:**
- `.h1`, `.h2`, `.h3` - Headings
- `.text-body`, `.text-muted`, `.text-help` - Body text
- `.text-link` - Links

**Layout:**
- `.section` - Vertical spacing (py-12 md:py-20)
- `.container` - Horizontal constraint (max-w-7xl)

**Components:**
- `.btn .btn-primary` - Primary button
- `.card` - Card container
- `.badge-challenge-active` - Status badge
- `.empty-state` - Empty state pattern
- `.page-header` - Page header

**Forms:**
- `.form-field` - Field wrapper
- `.form-label` - Label
- `.form-input` - Input field

### Common Tailwind Patterns

**Spacing:**
```blade
space-y-4 space-y-6 space-y-8    <!-- Vertical spacing -->
gap-4 gap-6 gap-8                 <!-- Grid/flex gap -->
p-4 p-6 p-8                       <!-- Padding -->
m-4 m-6 m-8                       <!-- Margin -->
```

**Sizing:**
```blade
w-full w-1/2 w-1/3               <!-- Width -->
h-full h-screen                   <!-- Height -->
max-w-7xl max-w-3xl              <!-- Max width -->
```

**Flexbox:**
```blade
flex items-center justify-between
flex-col md:flex-row
```

**Grid:**
```blade
grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4
```

**Text:**
```blade
text-sm text-base text-lg text-xl
font-normal font-semibold font-bold
text-center text-left text-right
```

---

## � Toast Notifications

**System:** Custom toast notification system matching project's frosted glass aesthetic  
**Location:** `resources/js/toast.js` + `resources/scss/vendors/_toast.scss`

### Toast Design

Toasts follow the project's card styling with:
- **Frosted glass effect** - Semi-transparent background with backdrop blur
- **Bottom-right positioning** - Above FAB on desktop (6px from edges), above bottom nav on mobile (20px from bottom)
- **Subtle shadows** - Tier 1 shadow system for consistency
- **Smooth animations** - 300ms slide-in from right with ease-out timing
- **Icon indicators** - Colored circular icons with symbols for each variant

### Toast Variants

```javascript
// Success toast - green accent with checkmark
showToast('Profile updated successfully!', 'success');

// Error toast - red accent with X mark
showToast('Failed to save changes', 'error');

// Info toast - blue accent with info icon
showToast('New features available', 'info');

// Warning toast - yellow accent with warning symbol
showToast('Please verify your email', 'warning');
```

### Styling Details

```scss
.toast {
    // Position: Bottom-right, above FAB/bottom nav
    @apply bottom-20 right-6 md:bottom-6 md:right-6;
    
    // Frosted glass matching card styling
    background-color: var(--color-bg-card);
    backdrop-filter: blur(10px);
    @apply border border-gray-200 dark:border-gray-700;
    
    // Subtle shadow (Tier 1)
    @apply shadow-lg;
    
    // Smooth transitions
    @apply transition-all duration-300 ease-out;
}

// Variants with colored borders and icon badges
.toast--success {
    @apply border-green-300 dark:border-green-700;
    &::before { /* Green checkmark badge */ }
}

.toast--error {
    @apply border-red-300 dark:border-red-700;
    &::before { /* Red X badge */ }
}
```

### Usage Patterns

**Manual Toast:**
```javascript
// In any JavaScript code
window.showToast('Action completed!', 'success');
```

**With AJAX (automatic):**
```javascript
// Component automatically shows toast from server response
const data = await response.json();
showToast(data.message, 'success'); // or 'error'
```

**Laravel Flash Messages (automatic):**
```php
// Controller - automatically displayed as toast
return redirect()->back()->with('success', 'Challenge created!');
return redirect()->back()->with('error', 'Invalid data');
return redirect()->back()->with('info', 'Remember to save');
return redirect()->back()->with('warning', 'Action requires confirmation');
```

### Design Rationale

1. **Bottom-right placement** - Non-intrusive, doesn't cover content, consistent with FAB positioning
2. **Frosted glass effect** - Maintains visual hierarchy, doesn't feel like a jarring overlay
3. **Icon + border color** - Quick visual scanning without reading, accessible
4. **Auto-dismiss (3s)** - User doesn't need to manually close, reduces interaction overhead
5. **Slide animation** - Smooth entry/exit, feels polished and intentional

---

## 🔍 Finding the Right Class

**Question:** "How do I style a challenge status badge?"  
**Answer:** Use `.badge-challenge-active`, `.badge-challenge-completed`, etc.

**Question:** "How do I create a page header?"  
**Answer:** Use `.page-header`, `.page-header-content`, `.page-header-title`

**Question:** "How do I add vertical spacing to a section?"  
**Answer:** Use `.section` class (provides py-12 md:py-20)

**Question:** "How do I create a card?"  
**Answer:** Use `.card`, `.card-header`, `.card-body`, `.card-footer`

**Question:** "How do I style a primary button?"  
**Answer:** Use `.btn .btn-primary`

**Question:** "How do I show a toast notification?"  
**Answer:** Use `showToast(message, type)` where type is 'success', 'error', 'info', or 'warning'

**Question:** "How do I add a Lottie animation?"  
**Answer:** Use `.lottie-container` and `.lottie-animation` with Alpine.js `x-lottie` directive

---

## 🎬 Lottie Animations

**Integration:** Lottie-web with Alpine.js directive  
**Assets Location:** `public/animations/`  
**Helper Module:** `resources/js/lottie.js`

### Lottie Classes

Located in `pages/_welcome.scss` (page-specific):

```scss
.lottie-container {
    @apply relative z-10;
    @apply flex justify-center items-center;
    @apply mb-8;
}

.lottie-animation {
    @apply w-32 h-32 md:w-40 md:h-40;
    // Animation renders at natural size, container constrains it
}
```

### Usage Example

```blade
<!-- Basic Lottie animation -->
<div class="lottie-container">
    <div class="lottie-animation" 
         x-lottie="{ path: '/animations/loader-cat.json', loop: true, autoplay: true }">
    </div>
</div>

<!-- With scroll animation -->
<div class="lottie-container animate animate-hidden-fade-up" 
     x-data="{}" 
     x-intersect="$el.classList.remove('animate-hidden-fade-up')">
    <div class="lottie-animation" 
         x-lottie="{ path: '/animations/loader-cat.json' }">
    </div>
</div>
```

### File Organization

- Store JSON files in `public/animations/`
- Use kebab-case naming: `loader-cat.json`, `success-animation.json`
- Reference with absolute paths: `/animations/filename.json`

---

For page-specific examples and complete implementation patterns, see **06-public-pages-blueprint.md**.
