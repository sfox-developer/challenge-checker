# Public Pages - Reference Blueprint

**Last Updated:** December 10, 2025  
**Status:** ✅ COMPLETE - Use as Gold Standard  
**Purpose:** Completed public pages serve as the reference implementation for all future development

---

## 🎯 Purpose

These completed pages serve as the **GOLD STANDARD** for:
- ✅ SCSS class usage patterns
- ✅ Blade component integration
- ✅ Alpine.js scroll animations
- ✅ Responsive design implementation
- ✅ Dark mode support
- ✅ Semantic HTML structure
- ✅ Typography hierarchy

**When building new pages (dashboard/admin), reference these patterns.**

---

## 📁 Completed Pages

### 1. welcome.blade.php - Landing Page ✅
**Purpose:** Marketing/conversion-focused landing page

**Location:** `resources/views/public/welcome.blade.php`

**Sections:**
1. Hero (text + CTA)
2. Visual Showcase (video/image container)
3. Features Grid (4 cards)
4. How It Works (3 steps)
5. Benefits (split layout with visual)
6. Stats (social proof)
7. Final CTA

---

### 2. privacy-policy.blade.php - Legal Content ✅
**Purpose:** Privacy policy with standard legal sections

**Location:** `resources/views/public/privacy-policy.blade.php`

**Sections:** 11 policy sections with h2 headings

---

### 3. terms-of-service.blade.php - Legal Content ✅
**Purpose:** Terms of service agreement

**Location:** `resources/views/public/terms-of-service.blade.php`

**Sections:** 16 terms sections with h2 headings

---

### 4. imprint.blade.php - Legal Content ✅
**Purpose:** Legal imprint information

**Location:** `resources/views/public/imprint.blade.php`

**Sections:** 7 legal sections with h2 headings

---

### 5. changelog.blade.php - Dynamic Content ✅
**Purpose:** Product changelog with version history

**Location:** `resources/views/public/changelog.blade.php`

**Features:** Dynamic list, empty state, pagination

---

## 🏗 Pattern Analysis

### Layout Pattern (All Pages)

```blade
<x-public-layout>
    <x-slot name="title">Page Title - {{ config('app.name') }}</x-slot>
    
    <!-- Content sections -->
    <div class="section">
        <div class="container">
            <!-- Page content -->
        </div>
    </div>
</x-public-layout>
```

**Key Classes:**
- `.section` - Vertical spacing (py-12 md:py-20)
- `.container` - Horizontal constraint (max-w-7xl mx-auto px-6)

**For text-heavy pages:**
- Add `max-w-3xl` to container for optimal reading width

---

### Typography Pattern

```blade
<!-- Page header -->
<h1 class="h1">Main Page Title</h1>
<p class="subtitle mb-10">Last updated: December 5, 2025</p>

<!-- Section headings -->
<h2 class="h2">Section Title</h2>
<h3 class="text-xl font-semibold">Subsection</h3>

<!-- Body content -->
<p class="text-body">Regular paragraph text.</p>
<p class="text-help">Helper/secondary text.</p>

<!-- Links -->
<a href="#" class="text-link">Learn more</a>
```

**Typography Classes Used:**
- `.h1` - Page title (5xl-7xl, bold)
- `.h2` - Section heading (3xl-4xl, bold)
- `.subtitle` - Page subtitle (xl, muted)
- `.text-body` - Regular text (gray-700/gray-300)
- `.text-help` - Small helper text (sm, gray-500/gray-400)
- `.text-link` - Links (slate-700/slate-400, hover underline)

---

### Animation Pattern (Scroll-Triggered)

**Setup Required:**
```javascript
// resources/js/app.js
import Alpine from 'alpinejs';
import intersect from '@alpinejs/intersect';

Alpine.plugin(intersect);
Alpine.start();
```

**Immediate Animations (Hero/Header):**
```blade
<h1 class="h1 opacity-0 translate-y-8 transition-all duration-700 ease-out"
    x-data="{}"
    x-init="setTimeout(() => { $el.classList.remove('opacity-0', 'translate-y-8') }, 100)">
    Page Title
</h1>

<p class="subtitle opacity-0 translate-y-8 transition-all duration-700 ease-out"
   x-data="{}"
   x-init="setTimeout(() => { $el.classList.remove('opacity-0', 'translate-y-8') }, 200)">
    Subtitle text
</p>
```

**Scroll-Triggered Animations (Sections):**
```blade
<section class="opacity-0 translate-y-8 transition-all duration-700 ease-out"
         x-data="{}"
         x-intersect="$el.classList.remove('opacity-0', 'translate-y-8')">
    <h2 class="h2">Section Title</h2>
    <!-- Content -->
</section>
```

**Staggered Animations (Multiple Items):**
```blade
<!-- Features grid with stagger -->
<div class="feature-card opacity-0 translate-y-8 transition-all duration-700 ease-out"
     x-data="{}"
     x-intersect="setTimeout(() => $el.classList.remove('opacity-0', 'translate-y-8'), 0)">
    Feature 1
</div>

<div class="feature-card opacity-0 translate-y-8 transition-all duration-700 ease-out"
     x-data="{}"
     x-intersect="setTimeout(() => $el.classList.remove('opacity-0', 'translate-y-8'), 100)">
    Feature 2
</div>

<div class="feature-card opacity-0 translate-y-8 transition-all duration-700 ease-out"
     x-data="{}"
     x-intersect="setTimeout(() => $el.classList.remove('opacity-0', 'translate-y-8'), 200)">
    Feature 3
</div>
```

**Dynamic List Stagger:**
```blade
@forelse($changelogs as $index => $changelog)
    <article class="changelog-item opacity-0 translate-y-8 transition-all duration-700 ease-out"
             x-data="{}"
             x-intersect="setTimeout(() => $el.classList.remove('opacity-0', 'translate-y-8'), {{ $index % 3 * 100 }})">
        <!-- Content -->
    </article>
@empty
    <!-- Empty state -->
@endforelse
```

**Animation Classes:**
- `opacity-0` - Initial hidden state
- `translate-y-8` - Move down (sections)
- `translate-y-4` - Slight move (hero)
- `translate-x-8` - Move right (visuals)
- `translate-x-[-20px]` - Move left (benefit items)
- `scale-95` - Slightly scaled down
- `transition-all` - Animate all properties
- `duration-700` - 700ms animation
- `ease-out` - Easing function

**Delay Pattern:**
- Immediate: 0ms, 100ms, 200ms, 300ms
- Scroll sections: 0ms default
- Staggered items: 0ms, 100ms, 200ms, 300ms
- Long lists: Use modulo `{{ $index % 3 * 100 }}`

---

### Landing Page Specific Patterns

**Hero Section:**
```blade
<div class="hero">
    <div class="container">
        <h1 class="hero-title">Turn Goals Into Habits</h1>
        <p class="hero-subtitle">Track daily challenges...</p>
        
        <div class="hero-cta">
            <a href="{{ route('register') }}" class="btn btn-primary btn-lg">
                Start Free Today
            </a>
            <a href="{{ route('login') }}" class="btn btn-secondary btn-lg">
                Sign In
            </a>
        </div>
    </div>
</div>
```

**SCSS Classes (pages/_welcome.scss):**
- `.hero` - Hero container (pt-16 pb-12)
- `.hero-title` - Gradient text title
- `.hero-subtitle` - Large subtitle
- `.hero-cta` - CTA button container

**Features Grid:**
```blade
<div class="section features">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Everything You Need</h2>
            <p class="section-subtitle">Powerful features...</p>
        </div>
        
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">
                    <svg>...</svg>
                </div>
                <h3 class="feature-title">Feature Name</h3>
                <p class="feature-description">Description...</p>
            </div>
            <!-- More cards -->
        </div>
    </div>
</div>
```

**SCSS Classes:**
- `.features-grid` - 4-column responsive grid
- `.feature-card` - Card container with hover effect
- `.feature-icon` - Icon container (slate background)
- `.feature-title` - Card title
- `.feature-description` - Card text

**Visual Showcase:**
```blade
<div class="section">
    <div class="hero-visual">
        <div class="hero-video-container">
            <video class="hero-video" autoplay loop muted>
                <source src="/videos/demo.mp4">
            </video>
        </div>
    </div>
</div>
```

**SCSS Classes:**
- `.hero-visual` - Visual container
- `.hero-video-container` - Video wrapper with border/shadow
- `.hero-video` - Responsive video element

**Stats Section:**
```blade
<div class="section stats">
    <div class="container">
        <div class="stats-grid">
            <div class="stat-item">
                <div class="stat-value">10,000+</div>
                <div class="stat-label">Goals Completed</div>
            </div>
            <!-- More stats -->
        </div>
    </div>
</div>
```

**SCSS Classes:**
- `.stats` - Dark background section (slate-700)
- `.stats-grid` - 4-column grid
- `.stat-item` - Stat container
- `.stat-value` - Large number (white)
- `.stat-label` - Label text (slate-300)

---

### Legal Pages Pattern (Privacy, Terms, Imprint)

**Structure:**
```blade
<x-public-layout>
    <x-slot name="title">Page Title - {{ config('app.name') }}</x-slot>
    
    <div class="section">
        <div class="container max-w-3xl">
            
            <!-- Header with animations -->
            <h1 class="h1 opacity-0 translate-y-8 transition-all duration-700 ease-out"
                x-data="{}"
                x-init="setTimeout(() => { $el.classList.remove('opacity-0', 'translate-y-8') }, 100)">
                Privacy Policy
            </h1>
            
            <p class="subtitle mb-10 opacity-0 translate-y-8 transition-all duration-700 ease-out"
               x-data="{}"
               x-init="setTimeout(() => { $el.classList.remove('opacity-0', 'translate-y-8') }, 200)">
                Last updated: December 5, 2025
            </p>

            <!-- Sections with scroll animations -->
            <div class="space-y-10">
                <section class="opacity-0 translate-y-8 transition-all duration-700 ease-out"
                         x-data="{}"
                         x-intersect="$el.classList.remove('opacity-0', 'translate-y-8')">
                    <h2 class="h2">Section Title</h2>
                    <div>
                        <p>Content...</p>
                        <ul class="list-disc list-inside space-y-2 ml-4">
                            <li>List item</li>
                        </ul>
                    </div>
                </section>
                
                <!-- More sections -->
            </div>
        </div>
    </div>
</x-public-layout>
```

**Key Patterns:**
- `max-w-3xl` on container for optimal reading width
- `space-y-10` between sections
- Each `<section>` has scroll animation
- Lists use Tailwind utilities: `list-disc list-inside space-y-2 ml-4`
- Links use `.text-link` class

---

### Changelog Page Pattern

**Structure:**
```blade
<div class="section">
    <div class="container max-w-3xl">
        <h1 class="opacity-0 translate-y-8 transition-all duration-700 ease-out"
            x-data="{}"
            x-init="setTimeout(() => { $el.classList.remove('opacity-0', 'translate-y-8') }, 100)">
            Changelog
        </h1>
        
        <p class="subtitle mb-10 opacity-0 translate-y-8 transition-all duration-700 ease-out"
           x-data="{}"
           x-init="setTimeout(() => { $el.classList.remove('opacity-0', 'translate-y-8') }, 200)">
            Latest updates and new features
        </p>

        <div class="changelog-list">
            @forelse($changelogs as $index => $changelog)
                <article class="changelog-item opacity-0 translate-y-8 transition-all duration-700 ease-out"
                         x-data="{}"
                         x-intersect="setTimeout(() => $el.classList.remove('opacity-0', 'translate-y-8'), {{ $index % 3 * 100 }})">
                    <header class="changelog-header">
                        <h2 class="changelog-version-number">{{ $changelog->version }}</h2>
                        <h3 class="changelog-title">{{ $changelog->title }}</h3>
                    </header>
                    
                    <div class="changelog-changes">
                        <!-- Change items -->
                    </div>
                </article>
            @empty
                <div class="changelog-empty">
                    <svg>...</svg>
                    <h3>No changelogs yet</h3>
                    <p class="text-help">Check back later!</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
```

**SCSS Classes (components/_changelog.scss):**
- `.changelog-list` - List container
- `.changelog-item` - Individual changelog entry
- `.changelog-header` - Entry header
- `.changelog-version-number` - Version number
- `.changelog-title` - Entry title
- `.changelog-changes` - Changes list
- `.changelog-empty` - Empty state

---

## 🎨 Design Principles

### 1. Spacing System
**Vertical Spacing:**
- Section padding: `py-12 md:py-20` (via `.section`)
- Between sections: automatic (each section has own padding)
- Within sections: `space-y-4`, `space-y-6`, `space-y-10`

**Horizontal Spacing:**
- Container: `max-w-7xl mx-auto px-6` (via `.container`)
- Text-heavy pages: Add `max-w-3xl` to container
- Grid gaps: `gap-8`, `gap-12`, `gap-16`

### 2. Typography Hierarchy
```
h1 (Page Title)      → .h1 (5xl-7xl, bold)
h2 (Section)         → .h2 (3xl-4xl, bold)
h3 (Subsection)      → .text-xl font-semibold
Body Text            → .text-body or default
Muted Text           → .text-muted, .text-help
Subtitle             → .subtitle (xl, muted)
```

### 3. Color Usage
**Light Mode:**
- Primary text: `text-gray-900`
- Muted text: `text-gray-600`
- Accent: `text-slate-700`
- Backgrounds: `bg-white`, `bg-gray-50`
- Borders: `border-gray-200`

**Dark Mode:**
- Primary text: `text-white`
- Muted text: `text-gray-400`
- Accent: `text-slate-400`
- Backgrounds: `bg-gray-800`, `bg-gray-900`
- Borders: `border-gray-700`

### 4. Responsive Breakpoints
**Mobile (default):**
- Single column layouts
- Smaller text sizes
- Stacked elements

**Tablet (md: 768px):**
- 2-column grids
- Larger text
- Horizontal navigation

**Desktop (lg: 1024px):**
- 3-4 column grids
- Largest text sizes
- Full layouts

**Common Patterns:**
```blade
grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4
text-3xl md:text-4xl lg:text-5xl
py-8 md:py-12 lg:py-16
flex-col md:flex-row
```

### 5. Dark Mode Implementation
**Always Include Dark Variants:**
```blade
bg-white dark:bg-gray-800
text-gray-900 dark:text-white
border-gray-200 dark:border-gray-700
```

**Test Both Modes:**
- Toggle theme using theme-toggle component
- Verify contrast ratios
- Check all states (hover, focus, active)

---

## ✅ Pattern Checklist

When creating new pages, use this checklist:

**Layout:**
- [ ] Uses `<x-app-layout>` or `<x-public-layout>`
- [ ] Uses `.section` for vertical spacing
- [ ] Uses `.container` for horizontal constraint
- [ ] Adds `max-w-3xl` for text-heavy pages

**Typography:**
- [ ] Uses `.h1`, `.h2` for headings
- [ ] Uses `.text-body`, `.text-muted` for body text
- [ ] Uses `.text-link` for links
- [ ] Proper heading hierarchy (h1 → h2 → h3)

**Animations:**
- [ ] Header elements use `x-init` with `setTimeout`
- [ ] Sections use `x-intersect` for scroll trigger
- [ ] Staggered delays for multiple items (0, 100, 200ms)
- [ ] Initial state: `opacity-0 translate-y-8`
- [ ] Transition: `transition-all duration-700 ease-out`

**Responsive:**
- [ ] Mobile-first approach (base styles for mobile)
- [ ] Uses `md:` breakpoint for tablet
- [ ] Uses `lg:` breakpoint for desktop
- [ ] Tests on all screen sizes

**Dark Mode:**
- [ ] All backgrounds have dark variants
- [ ] All text has dark variants
- [ ] All borders have dark variants
- [ ] Tested in both modes

**SCSS:**
- [ ] Uses existing SCSS classes (no inline Tailwind for common patterns)
- [ ] Creates new SCSS class if pattern repeats 3+ times
- [ ] Documents new classes in `03-styling-system.md`
- [ ] Organizes classes in appropriate file (base/components/pages)

**Accessibility:**
- [ ] Semantic HTML (nav, main, section, article)
- [ ] Proper heading hierarchy
- [ ] Alt text for images
- [ ] ARIA labels for icon buttons
- [ ] Keyboard navigation support

---

## 🚀 Usage for Dashboard/Admin Pages

**When building new dashboard or admin pages:**

1. **Reference welcome.blade.php for:**
   - Complex grid layouts
   - Card patterns
   - Section structure
   - Animation timing

2. **Reference legal pages for:**
   - Simple content layouts
   - Text-heavy pages
   - Section organization
   - List styling

3. **Reference changelog.blade.php for:**
   - Dynamic lists
   - Empty states
   - Pagination
   - Staggered list animations

4. **Copy exact patterns:**
   - Don't reinvent animations - use exact Alpine.js code
   - Don't create new spacing - use `.section`/`.container`
   - Don't create new typography - use `.h1`/`.h2`/etc.
   - Don't create new colors - use existing palette

5. **Maintain consistency:**
   - Same animation delays (100ms increments)
   - Same spacing scale
   - Same typography hierarchy
   - Same color palette
   - Same component patterns

---

## 📚 Quick Reference

### File Locations
```
resources/views/public/
├── welcome.blade.php           ← Landing page (most complex)
├── privacy-policy.blade.php    ← Legal content template
├── terms-of-service.blade.php  ← Legal content template
├── imprint.blade.php           ← Legal content template
└── changelog.blade.php         ← Dynamic list template
```

### SCSS Files
```
resources/scss/
├── base/
│   └── _typography.scss        ← h1, h2, text classes
├── components/
│   ├── _badges.scss
│   ├── _buttons.scss
│   ├── _cards.scss
│   └── _changelog.scss
└── pages/
    └── _welcome.scss           ← Landing page specific
```

### Most Used Classes

**Layout:**
- `.section` - py-12 md:py-20
- `.container` - max-w-7xl mx-auto px-6

**Typography:**
- `.h1` - Page title
- `.h2` - Section heading
- `.subtitle` - Subtitle text
- `.text-body` - Body text
- `.text-link` - Links

**Components:**
- `.btn .btn-primary` - Primary button
- `.btn-lg` - Large button
- `.feature-card` - Feature card
- `.stats-grid` - Stats layout

**Accents (Decorative Details):**
- `.eyebrow` - Small label above headings
- `.lottie-underline` + `.lottie-underline-animation` - Animated Lottie underline
- `.accent-badge` / `.accent-badge-success` - Pill badges
- `.step-number-enhanced` - Gradient step numbers
- `.section-divider` - Horizontal divider with dot
- `.text-highlight` - Highlighted text background

**Animation:**
- `.animate` + `.animate-hidden-fade-up` - Scroll-triggered fade up
- `.animate-delay-100/200/300/400` - Stagger delays
- `x-intersect="$el.classList.remove('animate-hidden-fade-up')"` - Trigger
- `x-init="setTimeout(() => { $el.classList.remove('...') }, 100)"` - Immediate

**Lottie Animations:**
- `.lottie-container` - Wrapper with centering
- `.lottie-animation` - Size constraints (w-32 h-32 md:w-40 md:h-40)
- `x-lottie="{ path: '/animations/file.json', loop: true }"` - Alpine directive
- `scrollProgress: true` - Animate based on scroll position
- `stretch: true` - Stretch SVG to fill container width
- `interval: 6000` - Replay animation every N milliseconds
- Assets in `public/animations/` with kebab-case naming

---

**These patterns are proven, tested, and production-ready. Use them as-is for consistency across the entire application.**
