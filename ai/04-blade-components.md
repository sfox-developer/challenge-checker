# Blade Components & Alpine.js

**Last Updated:** December 13, 2025  
**Purpose:** Component system, layouts, and frontend interactivity patterns

---

## 🎯 Component Philosophy

Challenge Checker uses **Blade components** for reusable UI elements and **Alpine.js** for lightweight interactivity.

### Key Principles
1. **Component-Based** - Reusable, self-contained UI elements
2. **Props for Customization** - Pass data via attributes
3. **Slot-Based Content** - Flexible content insertion
4. **Domain Organization** - Components grouped by feature area
5. **Progressive Enhancement** - Works without JavaScript when possible

---

## 📁 Component Structure

```
resources/views/components/
├── layout/                     # Layout components
│   ├── navigation.blade.php   # Main navigation (authenticated)
│   ├── footer.blade.php       # Site footer
│   ├── bottom-nav.blade.php   # Mobile bottom navigation
│   └── theme-toggle.blade.php # Dark mode toggle
│
├── ui/                         # Generic UI components
│   ├── modal.blade.php        # Modal dialog
│   ├── dropdown.blade.php     # Dropdown menu
│   ├── dropdown-link.blade.php # Dropdown menu item
│   ├── page-header.blade.php  # Page header with icon
│   ├── stat-card.blade.php    # Statistics card
│   └── app-button.blade.php   # Styled button/link
│
├── forms/                      # Form components
│   ├── form-field.blade.php   # Field wrapper (label + input + error)
│   ├── form-input.blade.php   # Text input
│   ├── form-textarea.blade.php # Textarea
│   ├── form-select.blade.php  # Select dropdown
│   ├── form-checkbox.blade.php # Checkbox
│   └── form-radio.blade.php   # Radio button
│
├── challenges/                 # Challenge-specific components
│   ├── goal-card.blade.php    # Goal display card
│   ├── progress-bar.blade.php # Progress indicator
│   └── daily-checklist.blade.php # Daily goal checklist
│
├── habits/                     # Habit-specific components
│   ├── completion-calendar.blade.php # Calendar view
│   └── streak-display.blade.php # Streak indicator
│
├── goals/                      # Goal library components
│   ├── goal-icon.blade.php    # Goal icon display
│   └── goal-search.blade.php  # Search/filter component
│
└── social/                     # Social feature components
    ├── activity-card.blade.php # Activity feed item
    ├── user-avatar.blade.php  # User avatar
    └── follow-button.blade.php # Follow/unfollow button
```

---

## 🏗 Layout Components

### x-dashboard-layout (Authenticated Layout)

**Location:** `resources/views/layouts/dashboard.blade.php`

**Usage:**
```blade
<x-dashboard-layout>
    <x-slot name="title">Page Title</x-slot>
    
    <!-- Page content goes here -->
    <div class="section">
        <div class="container">
            <h1 class="h1">Welcome</h1>
        </div>
    </div>
</x-dashboard-layout>
```

**Features:**
- Main navigation (desktop)
- Bottom navigation (mobile)
- Theme toggle
- Toast notifications
- Alpine.js initialization

---

### x-public-layout (Public & Auth Layout)

**Location:** `resources/views/layouts/public.blade.php`

**Usage:**
```blade
<x-public-layout>
    <x-slot name="title">Landing Page Title</x-slot>
    
    <!-- Public page content -->
</x-public-layout>
```

**Features:**
- Public navigation (minimal with login/register links)
- Footer with links
- Theme toggle
- Used for public pages (welcome, legal) AND authentication pages (login, register)
- No authentication required

---

### x-layout.navigation (Main Navigation)

**Component:** `resources/views/components/layout/navigation.blade.php`

**Features:**
- Desktop horizontal menu
- Mobile hamburger menu
- Active state highlighting
- User profile dropdown
- Notification indicator

**Usage:** Automatically included in `x-dashboard-layout`

---

### x-layout.bottom-nav (Mobile Bottom Nav)

**Component:** `resources/views/components/layout/bottom-nav.blade.php`

**Features:**
- Fixed bottom navigation (mobile only)
- Icon-based menu items
- Active state highlighting
- Hidden on desktop (lg:hidden)

**Usage:** Automatically included in `x-dashboard-layout`

---

### x-layout.theme-toggle

**Component:** `resources/views/components/layout/theme-toggle.blade.php`

**Features:**
- Toggle between light/dark mode
- Saves preference to localStorage
- Updates `<html>` class

**Usage:**
```blade
<x-layout.theme-toggle />
```

---

## 🎨 UI Components

### x-ui.modal

**Component:** `resources/views/components/ui/modal.blade.php`

**Props:**
- `name` (required) - Unique modal identifier
- `maxWidth` (optional) - Modal width (sm, md, lg, xl, 2xl)

**Usage:**
```blade
<!-- Trigger -->
<button @click="$dispatch('open-modal', 'delete-challenge')">
    Delete Challenge
</button>

<!-- Modal -->
<x-ui.modal name="delete-challenge" maxWidth="md">
    <h3 class="h3">Delete Challenge?</h3>
    <p class="text-body mt-4">This action cannot be undone.</p>
    
    <div class="mt-6 flex gap-4">
        <button class="btn btn-danger">Delete</button>
        <button class="btn btn-secondary" @click="$dispatch('close-modal')">
            Cancel
        </button>
    </div>
</x-ui.modal>
```

**Alpine.js Events:**
- `open-modal` - Opens modal by name
- `close-modal` - Closes current modal

---

### x-ui.dropdown

**Component:** `resources/views/components/ui/dropdown.blade.php`

**Slots:**
- `trigger` - Dropdown trigger button
- Default slot - Dropdown content

**Usage:**
```blade
<x-ui.dropdown>
    <x-slot name="trigger">
        <button class="btn btn-secondary">
            Options
        </button>
    </x-slot>
    
    <x-ui.dropdown-link href="{{ route('challenges.edit', $challenge) }}">
        Edit
    </x-ui.dropdown-link>
    <x-ui.dropdown-link href="{{ route('challenges.destroy', $challenge) }}">
        Delete
    </x-ui.dropdown-link>
</x-ui.dropdown>
```

---

### x-ui.page-header

**Component:** `resources/views/components/ui/page-header.blade.php`

**Props:**
- `title` - Page title text
- `icon` (optional) - SVG icon markup

**Slots:**
- `actions` - Action buttons (right side)

**Usage:**
```blade
<x-ui.page-header title="My Challenges">
    <x-slot name="icon">
        <svg>...</svg>
    </x-slot>
    
    <x-slot name="actions">
        <a href="{{ route('challenges.create') }}" class="btn btn-primary">
            Create Challenge
        </a>
    </x-slot>
</x-ui.page-header>
```

---

### x-ui.stat-card

**Component:** `resources/views/components/ui/stat-card.blade.php`

**Props:**
- `label` - Stat label
- `value` - Stat value
- `icon` (optional) - SVG icon

**Usage:**
```blade
<x-ui.stat-card 
    label="Active Challenges" 
    value="{{ $activeChallenges }}"
>
    <x-slot name="icon">
        <svg>...</svg>
    </x-slot>
</x-ui.stat-card>
```

---

### x-ui.app-button

**Component:** `resources/views/components/ui/app-button.blade.php`

**Props:**
- `href` (optional) - Link URL (creates <a> tag)
- `type` (optional) - Button type (submit, button)
- `variant` (optional) - Button style (primary, secondary, danger)

**Usage:**
```blade
<!-- Link button -->
<x-ui.app-button href="{{ route('challenges.create') }}" variant="primary">
    Create Challenge
</x-ui.app-button>

<!-- Submit button -->
<x-ui.app-button type="submit" variant="primary">
    Save Changes
</x-ui.app-button>
```

---

## 📝 Form Components

### x-forms.form-field

**Component:** `resources/views/components/forms/form-field.blade.php`

**Props:**
- `label` - Field label
- `name` - Input name
- `type` (optional) - Input type (text, email, password, etc.)
- `required` (optional) - Required field
- `help` (optional) - Help text

**Usage:**
```blade
<x-forms.form-field 
    label="Challenge Name" 
    name="name" 
    type="text"
    required
    help="Enter a descriptive name for your challenge"
/>
```

---

### x-forms.form-textarea

**Component:** `resources/views/components/forms/form-textarea.blade.php`

**Props:**
- `label` - Field label
- `name` - Textarea name
- `rows` (optional) - Number of rows
- `required` (optional) - Required field

**Usage:**
```blade
<x-forms.form-textarea 
    label="Description" 
    name="description"
    rows="5"
/>
```

---

### x-forms.form-select

**Component:** `resources/views/components/forms/form-select.blade.php`

**Props:**
- `label` - Field label
- `name` - Select name
- `options` - Array of options
- `required` (optional) - Required field

**Usage:**
```blade
<x-forms.form-select 
    label="Duration" 
    name="days_duration"
    :options="[
        30 => '30 days',
        60 => '60 days',
        90 => '90 days'
    ]"
    required
/>
```

---

## 🎯 Domain-Specific Components

### x-challenges.goal-card

**Purpose:** Display a goal within a challenge

**Props:**
- `goal` - Goal model instance
- `completed` (optional) - Completion status

**Usage:**
```blade
@foreach($challenge->goals as $goal)
    <x-challenges.goal-card 
        :goal="$goal"
        :completed="$goal->isCompletedToday()"
    />
@endforeach
```

---

### x-challenges.progress-bar

**Purpose:** Visual progress indicator

**Props:**
- `percentage` - Progress percentage (0-100)
- `label` (optional) - Progress label

**Usage:**
```blade
<x-challenges.progress-bar 
    :percentage="$challenge->completionPercentage()"
    label="{{ $challenge->completedGoalsCount() }} / {{ $challenge->totalGoalsCount() }}"
/>
```

---

### x-social.activity-card

**Purpose:** Display activity feed item

**Props:**
- `activity` - Activity model instance

**Usage:**
```blade
@foreach($activities as $activity)
    <x-social.activity-card :activity="$activity" />
@endforeach
```

---

### x-social.follow-button

**Purpose:** Follow/unfollow user button

**Props:**
- `user` - User model instance

**Usage:**
```blade
<x-social.follow-button :user="$user" />
```

---

## ⚡ Alpine.js Integration

### Alpine.js Setup

**Installation:**
```bash
npm install alpinejs @alpinejs/intersect
```

**Configuration (resources/js/app.js):**
```javascript
import Alpine from 'alpinejs';
import intersect from '@alpinejs/intersect';

window.Alpine = Alpine;

Alpine.plugin(intersect);

Alpine.start();
```

---

### Common Alpine.js Patterns

**1. Dropdown Toggle:**
```blade
<div x-data="{ open: false }" class="relative">
    <button @click="open = !open" class="btn btn-secondary">
        Options
    </button>
    
    <div x-show="open" 
         @click.away="open = false"
         class="absolute right-0 mt-2">
        <!-- Dropdown content -->
    </div>
</div>
```

**2. Modal:**
```blade
<div x-data="{ show: false }" 
     @open-modal.window="show = ($event.detail === 'modal-name')"
     @close-modal.window="show = false"
     x-show="show">
    <!-- Modal content -->
</div>
```

**3. Tab System:**
```blade
<div x-data="{ activeTab: 'challenges' }">
    <!-- Tabs -->
    <div class="flex gap-4">
        <button @click="activeTab = 'challenges'" 
                :class="activeTab === 'challenges' ? 'active' : ''">
            Challenges
        </button>
        <button @click="activeTab = 'habits'"
                :class="activeTab === 'habits' ? 'active' : ''">
            Habits
        </button>
    </div>
    
    <!-- Tab Panels -->
    <div x-show="activeTab === 'challenges'">
        <!-- Challenges content -->
    </div>
    <div x-show="activeTab === 'habits'">
        <!-- Habits content -->
    </div>
</div>
```

**4. Form Submission:**
```blade
<form x-data="{ submitting: false }" 
      @submit="submitting = true">
    <!-- Form fields -->
    
    <button type="submit" 
            :disabled="submitting"
            class="btn btn-primary">
        <span x-show="!submitting">Save</span>
        <span x-show="submitting">Saving...</span>
    </button>
</form>
```

**5. Scroll Animations (Intersect Plugin):**
```blade
<!-- Fade in on scroll -->
<div class="opacity-0 translate-y-8 transition-all duration-700 ease-out"
     x-data="{}"
     x-intersect="$el.classList.remove('opacity-0', 'translate-y-8')">
    Content fades in when scrolled into view
</div>

<!-- Immediate animation -->
<h1 class="opacity-0 translate-y-4 transition-all duration-700 ease-out"
    x-data="{}"
    x-init="setTimeout(() => { $el.classList.remove('opacity-0', 'translate-y-4') }, 100)">
    Hero Title
</h1>
```

**6. Toggle Visibility:**
```blade
<div x-data="{ expanded: false }">
    <button @click="expanded = !expanded">
        <span x-show="!expanded">Show more</span>
        <span x-show="expanded">Show less</span>
    </button>
    
    <div x-show="expanded" x-collapse>
        <!-- Expandable content -->
    </div>
</div>
```

---

### Alpine.js Directives Reference

**Data & State:**
- `x-data` - Define component data
- `x-init` - Run code on initialization
- `x-model` - Two-way data binding

**Rendering:**
- `x-show` - Toggle visibility (with CSS)
- `x-if` - Conditional rendering (DOM removal)
- `x-for` - Loop rendering

**Events:**
- `@click` - Click event
- `@submit` - Form submission
- `@input` - Input change
- `@click.away` - Click outside element
- `@keydown.escape` - Escape key press

**Attributes:**
- `:class` - Dynamic class binding
- `:disabled` - Dynamic disabled state
- `:href` - Dynamic link URL

**Special:**
- `x-intersect` - Trigger when element enters viewport
- `x-collapse` - Smooth collapse/expand animation
- `$dispatch` - Dispatch custom event
- `$event` - Access event object
- `$el` - Access current element

---

## 🎨 Component Best Practices

### 1. Props vs Slots

**Use Props for:**
- Simple data (strings, numbers, booleans)
- Model instances
- Arrays of options

**Use Slots for:**
- Complex HTML content
- Customizable sections
- Optional content areas

**Example:**
```blade
<!-- Props for simple data -->
<x-ui.stat-card label="Total" value="42" />

<!-- Slots for complex content -->
<x-ui.modal name="confirm">
    <h3>Are you sure?</h3>
    <p>This action cannot be undone.</p>
    <div class="flex gap-4">
        <button class="btn btn-danger">Delete</button>
        <button class="btn btn-secondary">Cancel</button>
    </div>
</x-ui.modal>
```

---

### 2. Component Naming

**Conventions:**
- Kebab-case for filenames: `goal-card.blade.php`
- Dot notation for usage: `<x-challenges.goal-card>`
- Descriptive names: `follow-button` not `btn-follow`

---

### 3. Component Organization

**Group by Domain:**
- Layout components → `layout/`
- Generic UI → `ui/`
- Forms → `forms/`
- Feature-specific → `challenges/`, `habits/`, etc.

**Keep Components Focused:**
- One responsibility per component
- Small, reusable pieces
- Composable components

---

### 4. Default Props

**Define Defaults:**
```php
@props([
    'variant' => 'primary',
    'size' => 'md',
    'disabled' => false,
])
```

**Usage:**
```blade
<!-- Uses defaults -->
<x-ui.app-button>Click me</x-ui.app-button>

<!-- Override defaults -->
<x-ui.app-button variant="secondary" size="lg">
    Large Button
</x-ui.app-button>
```

---

### 5. Accessibility

**Always Include:**
- ARIA labels for icon buttons
- Keyboard navigation support
- Focus states
- Screen reader text

**Example:**
```blade
<button class="btn-icon" aria-label="Delete challenge">
    <svg aria-hidden="true">...</svg>
</button>
```

---

## 📚 Quick Reference

### Most Used Components

**Layouts:**
- `<x-dashboard-layout>` - Authenticated dashboard/admin pages
- `<x-public-layout>` - Public pages and authentication pages

**UI:**
- `<x-ui.modal>` - Modal dialogs
- `<x-ui.dropdown>` - Dropdown menus
- `<x-ui.page-header>` - Page headers
- `<x-ui.app-button>` - Styled buttons

**Forms:**
- `<x-forms.form-field>` - Text input with label
- `<x-forms.form-textarea>` - Textarea
- `<x-forms.form-select>` - Select dropdown

### Most Used Alpine.js Patterns

**State Management:**
```blade
x-data="{ open: false }"
```

**Event Handling:**
```blade
@click="open = !open"
@click.away="open = false"
```

**Conditional Display:**
```blade
x-show="open"
x-if="condition"
```

**Dynamic Classes:**
```blade
:class="isActive ? 'active' : ''"
```

**Animations:**
```blade
x-intersect="$el.classList.remove('opacity-0', 'translate-y-8')"
```

**Lottie Animations:**
```blade
<div x-lottie="{ path: '/animations/loader-cat.json', loop: true, autoplay: true }"></div>
```

---

## 🎬 Lottie Animations

**Package:** `lottie-web`  
**Location:** `resources/js/lottie.js`  
**Assets:** `public/animations/`

### Usage

**Basic Animation:**
```blade
<div class="lottie-animation" 
     x-lottie="{ path: '/animations/loader-cat.json' }">
</div>
```

**With Options:**
```blade
<div class="lottie-animation"
     x-lottie="{
         path: '/animations/animation-name.json',
         loop: true,
         autoplay: true,
         renderer: 'svg'
     }">
</div>
```

**Interval Replay:**
```blade
<div class="lottie-animation"
     x-lottie="{
         path: '/animations/loader-cat.json',
         interval: 6000  // Replay every 6 seconds
     }">
</div>
```

**Scroll-Based Progress:**
```blade
<span class="lottie-underline">Word
    <span class="lottie-underline-animation" 
        x-lottie="{
            path: '/animations/line.json',
            loop: false,
            autoplay: false,
            stretch: true,
            scrollProgress: true  // Animate based on scroll position
        }">
    </span>
</span>
```

**Configuration Options:**
- `path` - Path to JSON file (required)
- `loop` - Boolean, loop animation (default: true unless interval is set)
- `autoplay` - Boolean, start automatically (default: true)
- `renderer` - 'svg', 'canvas', or 'html' (default: 'svg')
- `interval` - Number (ms), replay animation at interval (disables loop)
- `stretch` - Boolean, stretch SVG to fill container (sets preserveAspectRatio="none")
- `scrollProgress` - Boolean, animate based on element scroll position (disables autoplay)

**File Organization:**
- Store JSON files in `public/animations/`
- Use kebab-case naming: `loader-cat.json`, `success-checkmark.json`
- Reference with absolute path: `/animations/filename.json`

---

For complete implementation examples, see **06-public-pages-blueprint.md**.
