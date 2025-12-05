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
    └── _toast.scss              # Toast notification styles
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
- Routes to admin or public view based on context
- Shows privacy indicator
- Shows progress
- Shows status badge

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
- `challenges` - Challenge collection
- `activities` - Activity collection
- `defaultTab` - 'challenges' or 'activities'
- `adminView` - Boolean for admin context

**Features:**
- Alpine.js tab switching
- Lazy loading content
- Passes adminView to child components

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
- `id` - Unique modal identifier
- `title` - Modal title
- `size` - sm/md/lg/xl

**Usage:**
```blade
<x-modal id="confirmModal" title="Confirm Action" size="md">
    <p>Are you sure?</p>
    <x-slot name="footer">
        <x-app-button @click="hideModal('confirmModal')">
            Cancel
        </x-app-button>
    </x-slot>
</x-modal>
```

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

## Performance Optimizations

1. **Lazy loading** - Images and heavy components
2. **Code splitting** - Vite chunks JavaScript
3. **CSS purging** - Tailwind removes unused classes
4. **Asset versioning** - Cache busting
5. **Minimal Alpine** - Lightweight framework (~15KB)
6. **Eager loading** - Prevent N+1 queries in Blade
