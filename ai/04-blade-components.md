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
- `eyebrow` (optional) - Context label above title (e.g., "Your Collection", "Danger Zone")
- `title` (optional) - Modal title displayed in header
- `maxWidth` (optional) - Modal width: sm, md (default), lg, xl, 2xl
- `showClose` (optional) - Show close button (default: true)

**Design Features:**
- **Top Accent Bar** - 2px slate-colored bar at top for visual anchor
- **Eyebrow Label** - Optional context label using accent color
- **Centered Layout** - Title and eyebrow centered for clean, modern look
- **Improved Close Button** - Absolute positioned top-right with hover effect
- **No Borders** - No header or footer borders for cleaner, minimal design
- **Centered Footer** - Buttons centered (matches header alignment)
- **Subtle Footer Background** - Light gray background for visual separation
- **Responsive Buttons** - Stack vertically on mobile, horizontal on desktop
- **Full-width Mobile Buttons** - Better touch targets on small screens

**SCSS Classes Used:**
- `.modal-wrapper` - Container with z-index management
- `.modal-backdrop` - Backdrop with blur effect
- `.modal-content` - Modal container with dark mode support
- `.modal-accent` - Top 2px accent bar (slate color)
- `.modal-header` - Centered header section
- `.modal-eyebrow` - Eyebrow label styling
- `.modal-title` - Title styling
- `.modal-body` - Content wrapper (auto-applied)
- `.modal-footer` - Action buttons footer
- `.modal-close-button` - Improved close button styling

**Usage:**
```blade
<!-- Trigger -->
<button @click="$dispatch('open-modal', 'delete-challenge')">
    Delete Challenge
</button>

<!-- Simple Modal with Eyebrow -->
<x-ui.modal 
    name="delete-challenge" 
    eyebrow="Danger Zone"
    title="Delete Challenge?" 
    maxWidth="md"
>
    <p class="text-body">This action cannot be undone.</p>
    
    <div class="modal-footer">
        <button class="btn-secondary" @click="$dispatch('close-modal', 'delete-challenge')">
            Cancel
        </button>
        <button class="btn-danger">Delete</button>
    </div>
</x-ui.modal>

<!-- Form Modal with Eyebrow and Validation -->
<x-ui.modal 
    name="edit-goal" 
    eyebrow="Your Collection"
    title="Edit Goal" 
    :show="$errors->any()" 
    maxWidth="lg"
>
    <form method="POST" action="{{ route('goals.update', $goal) }}">
        @csrf
        @method('PUT')
        
        <div class="space-y-4">
            <x-forms.form-input name="name" label="Goal Name" :value="$goal->name" required />
            <x-forms.form-textarea name="description" label="Description" :value="$goal->description" />
        </div>
        
        <div class="modal-footer">
            <button type="button" class="btn-secondary" @click="$dispatch('close-modal', 'edit-goal')">
                Cancel
            </button>
            <button type="submit" class="btn-primary">Save Changes</button>
        </div>
    </form>
</x-ui.modal>
```

**Alpine.js Events:**
- `open-modal` - Opens modal by name: `@click="$dispatch('open-modal', 'modal-name')"`
- `close-modal` - Closes modal by name: `@click="$dispatch('close-modal', 'modal-name')"`
- `close` - Closes current modal: `@click="$dispatch('close')"`
- Escape key automatically closes modal

**Features:**
- Full dark mode support via SCSS classes
- Backdrop blur effect
- Focus management (optional `focusable` attribute)
- Keyboard navigation (Tab, Shift+Tab, Escape)
- Prevents body scroll when open
- Smooth animations (fade + scale)
- Auto-shows on validation errors with `:show="$errors->any()"`

**Architecture:**
- Alpine.js logic extracted to `resources/js/components/modal.js`
- Uses `modalData()` component for focus management
- Styling consolidated in `resources/scss/components/_modals.scss`
- Follows Single Responsibility Principle
- Clean separation: JavaScript for behavior, SCSS for styling, Blade for structure

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

**Purpose:** Displays a statistic card with a value and label. Uses gradient accent bars for visual emphasis.

**Props:**
- `label` (required) - Stat label text
- `value` (required) - Stat value (number or string)
- `variant` (optional) - Visual variant, default: `null`
  - `'top'` - Adds 3px gradient accent bar at top
  - `null` - Plain card without accent

**Slots:**
- `suffix` (optional) - Text appended to value (e.g., "%")

**Styling:**
- Base class: `.dashboard-stat-card` (defined in `_cards.scss`)
- Variant class: `.dashboard-stat-card-accent-top` (when variant="top")
- Value class: `.dashboard-stat-value` (5xl bold with gradient text)
- Label class: `.dashboard-stat-label` (sm uppercase with tracking)
- Gradient: Linear gradient #667eea → #764ba2 (light mode), #818cf8 → #a78bfa (dark mode)

**Usage:**
```blade
<!-- Basic stat card with top accent -->
<x-ui.stat-card 
    label="Active Challenges" 
    :value="$activeChallenges"
    variant="top" />

<!-- Stat card with suffix -->
<x-ui.stat-card 
    label="Success Rate" 
    :value="$successRate"
    variant="top">
    <x-slot name="suffix">%</x-slot>
</x-ui.stat-card>

<!-- Plain stat card without accent -->
<x-ui.stat-card 
    label="Total Users" 
    :value="$totalUsers" />
```

**Design Notes:**
- No icons (removed for cleaner, data-focused design)
- No hover effects (cards are non-interactive display elements)
- Top accent variant matches modal design language (consistent 2-3px gradient bars)
- Use within grid layouts: `grid grid-cols-2 md:grid-cols-4 gap-4`

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

All form components use the **`.form-input`** class for consistent styling across dashboard and auth forms.

### Design System

**Styling:** Defined in `resources/scss/components/_forms.scss`

**Key Features:**
- **Glassmorphic Design** - Backdrop blur with semi-transparent backgrounds
- **Rounded Corners** - 12px border-radius for modern look
- **Custom Focus States** - Accent color borders with subtle shadow
- **Dark Mode Support** - Complete styling for light and dark themes
- **Consistent Spacing** - 0.75rem padding for comfortable input
- **Custom Select Styling** - Styled dropdown arrows matching design system

**SCSS Classes:**
- `.form-input` - Applied to all input, textarea, and select elements
- `.form-label` - Label styling with proper hierarchy
- `.form-checkbox` - Custom checkbox styling with glassmorphic effect
- `.form-error` - Error message styling
- `.form-help` - Help text styling

---

### x-forms.form-input

**Component:** `resources/views/components/forms/form-input.blade.php`

**Props:**
- `label` (optional) - Field label text
- `name` (required) - Input name attribute
- `type` (optional) - Input type (default: 'text')
- `value` (optional) - Input value
- `placeholder` (optional) - Placeholder text
- `required` (optional) - Mark as required field
- `icon` (optional) - Icon to display next to label
- `iconColor` (optional) - Icon color class (default: 'blue')
- `optional` (optional) - Show "(Optional)" label
- `hint` (optional) - Help text below input
- `min` (optional) - Min value (for number inputs)
- `max` (optional) - Max value (for number inputs)

**Usage:**
```blade
<!-- Basic Input -->
<x-forms.form-input
    name="name"
    label="Goal Name"
    placeholder="e.g., Exercise, Read, Meditate"
    required />

<!-- Number Input with Range -->
<x-forms.form-input
    name="days_duration"
    label="Duration (Days)"
    type="number"
    placeholder="30"
    min="1"
    max="365"
    optional />
```

---

### x-forms.form-textarea

**Component:** `resources/views/components/forms/form-textarea.blade.php`

**Props:**
- `label` (optional) - Field label text
- `name` (required) - Textarea name attribute
- `value` (optional) - Textarea value
- `placeholder` (optional) - Placeholder text
- `rows` (optional) - Number of rows (default: 3)
- `required` (optional) - Mark as required field
- `icon` (optional) - Icon to display next to label
- `iconColor` (optional) - Icon color class (default: 'purple')
- `optional` (optional) - Show "(Optional)" label (default: true)
- `hint` (optional) - Help text below textarea

**Usage:**
```blade
<x-forms.form-textarea
    name="description"
    label="Description"
    placeholder="What is this goal about?"
    rows="3"
    optional />
```

---

### x-forms.form-select

**Component:** `resources/views/components/forms/form-select.blade.php`

**Props:**
- `label` (optional) - Field label text
- `name` (required) - Select name attribute
- `value` (optional) - Selected value
- `options` (optional) - Array of options
- `required` (optional) - Mark as required field
- `icon` (optional) - Icon to display next to label
- `iconColor` (optional) - Icon color class (default: 'blue')
- `optional` (optional) - Show "(Optional)" label
- `hint` (optional) - Help text below select
- `placeholder` (optional) - Placeholder option text (default: 'Select an option...')

**Usage:**
```blade
<x-forms.form-select
    name="category_id"
    label="Category"
    placeholder="None">
    @foreach($categories as $cat)
        <option value="{{ $cat->id }}">
            {{ $cat->icon }} {{ $cat->name }}
        </option>
    @endforeach
</x-forms.form-select>
```

---

### x-forms.form-checkbox

**Component:** `resources/views/components/forms/form-checkbox.blade.php`

**Props:**
- `label` (required) - Checkbox label text
- `name` (required) - Checkbox name attribute
- `value` (optional) - Checkbox value (default: '1')
- `checked` (optional) - Initial checked state
- `description` (optional) - Description text below label
- `icon` (optional) - Icon to display next to label
- `iconColor` (optional) - Icon color class (default: 'blue')

**Usage:**
```blade
<x-forms.form-checkbox
    name="is_public"
    label="Make this public"
    description="Anyone can view this challenge" />
```

---

### x-forms.emoji-picker

**Component:** `resources/views/components/forms/emoji-picker.blade.php`

**Props:**
- `id` (optional) - Input ID (auto-generated if not provided)
- `name` (optional) - Input name (default: 'icon')
- `value` (optional) - Initial emoji value
- `placeholder` (optional) - Placeholder emoji (default: '🎯')
- `label` (optional) - Field label (default: 'Icon (emoji)')
- `maxlength` (optional) - Max characters (default: '2')
- `disabled` (optional) - Disable input
- `required` (optional) - Mark as required field

**Usage:**
```blade
<x-forms.emoji-picker 
    name="icon" 
    :value="$goal->icon"
    label="Icon (emoji)"
    placeholder="🎯" />
```

---

### x-forms.form-field

**Component:** `resources/views/components/forms/form-field.blade.php`

**Purpose:** Wrapper component for labels, hints, and errors. Used internally by other form components.

**Props:**
- `label` (optional) - Field label
- `name` (required) - Input name for error handling
- `icon` (optional) - Icon to display next to label
- `iconColor` (optional) - Icon color class
- `optional` (optional) - Show "(Optional)" label
- `hint` (optional) - Help text

**Usage (Direct):**
```blade
<x-forms.form-field 
    label="Custom Field" 
    name="custom_field"
    hint="This is a custom input">
    
    <!-- Your custom input here -->
    <input type="text" name="custom_field" class="form-input">
</x-forms.form-field>
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
```

**6. Multi-Step Form (Progressive Disclosure - External Component):**

**Best Practice:** Extract complex Alpine.js logic to separate JavaScript files.

```javascript
// resources/js/components/registration-form.js
export default (initialData = {}) => ({
    step: initialData.hasErrors ? 3 : 1,
    email: initialData.email || '',
    emailValid: Boolean(initialData.email),
    
    validateEmail() {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        this.emailValid = emailRegex.test(this.email);
        return this.emailValid;
    },
    
    goToStep2() {
        if (this.validateEmail()) {
            this.step = 2;
            this.$nextTick(() => {
                document.getElementById('name')?.focus();
            });
        }
    }
});

// Register in resources/js/components/index.js
import registrationForm from './registration-form.js';
window.registrationForm = registrationForm;
```

**Usage in Blade:**
```blade
<div x-data="registrationForm({ 
        email: '{{ old('email') }}',
        hasErrors: {{ $errors->any() ? 'true' : 'false' }}
     })">
    
    <!-- Header - Only step 1 -->
    <div x-show="step === 1">
        <h1>Create your account</h1>
    </div>
    
    <!-- Progress - Steps 2-3 -->
    <div x-show="step > 1">
        <div :class="step >= 1 ? 'active' : ''">1</div>
        <div :class="step >= 2 ? 'active' : ''">2</div>
    </div>
    
    <!-- Step 1: Email -->
    <div x-show="step === 1">
        <input x-model="email" @input="validateEmail()" />
        <button @click="goToStep2" :disabled="!emailValid">
            Continue
        </button>
    </div>
    
    <!-- Step 2: Name -->
    <div x-show="step === 2">
        <input id="name" x-model="name" />
        <button @click="step = 1">Back</button>
    </div>
</div>
```

**Key Features:**
- **Extreme focus** - Hide ALL unnecessary elements per step
- **No animations** - Use `x-show` without `x-transition` for instant changes
- **External JavaScript** - Complex logic in separate file for maintainability
- **Progressive disclosure** - Each step shows minimal UI
- **Auto-focus** - Use `$nextTick()` for proper focus management
- **Laravel integration** - Handles validation errors gracefully
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
