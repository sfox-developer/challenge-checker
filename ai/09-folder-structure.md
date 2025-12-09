# Folder Structure - Views & SCSS Organization

**Last Updated:** December 9, 2025  
**Phase:** Minimalistic UI Redesign - Final Structure

---

## Overview

The Challenge Checker application follows a **context-based organization** pattern for both views and SCSS files. This structure aligns with Domain-Driven Design principles and improves maintainability by grouping related files together.

### Key Principles

1. **Context-Based Organization** - Files grouped by user context (Public → Auth → Dashboard → Admin)
2. **Component Modularity** - Reusable components organized by domain
3. **Clear Separation** - Distinct folders for different concerns
4. **Scalability** - Easy to add new features without structural changes
5. **Laravel Conventions** - Follows Laravel's component namespace feature

---

## Views Folder Structure

```
resources/views/
├── public/                          # Public-facing pages (unauthenticated)
│   ├── welcome.blade.php           # Landing page
│   ├── changelog.blade.php         # Product changelog
│   ├── privacy-policy.blade.php    # Privacy policy
│   ├── terms-of-service.blade.php  # Terms of service
│   └── imprint.blade.php           # Legal imprint
│
├── auth/                            # Authentication pages
│   ├── login.blade.php             # Login form
│   ├── register.blade.php          # Registration form
│   ├── forgot-password.blade.php   # Password reset request
│   ├── reset-password.blade.php    # Password reset form
│   ├── confirm-password.blade.php  # Password confirmation
│   └── verify-email.blade.php      # Email verification
│
├── dashboard/                       # Authenticated user area
│   ├── challenges/                 # Challenge management
│   │   ├── index.blade.php        # List challenges
│   │   ├── create.blade.php       # Create challenge
│   │   ├── edit.blade.php         # Edit challenge
│   │   └── show.blade.php         # View challenge details
│   ├── habits/                     # Habit tracking
│   │   ├── index.blade.php        # List habits
│   │   ├── create.blade.php       # Create habit
│   │   ├── edit.blade.php         # Edit habit
│   │   ├── show.blade.php         # View habit details
│   │   └── today.blade.php        # Today's habits
│   ├── goals/                      # Goals library
│   │   ├── index.blade.php        # List goals
│   │   └── show.blade.php         # View goal details
│   ├── feed/                       # Activity feed
│   │   └── index.blade.php        # Social feed
│   ├── profile/                    # User profile
│   │   ├── edit.blade.php         # Edit profile
│   │   ├── menu.blade.php         # Profile menu
│   │   └── partials/              # Profile sub-components
│   │       ├── delete-user-form.blade.php
│   │       ├── update-password-form.blade.php
│   │       └── update-profile-information-form.blade.php
│   ├── users/                      # User interactions
│   │   ├── search.blade.php       # Search users
│   │   └── show.blade.php         # View user profile
│   └── partials/                   # Dashboard-wide partials
│       ├── quick-goals.blade.php   # Quick goals modal
│       └── quick-habits.blade.php  # Quick habits widget
│
├── admin/                           # Admin panel (admin-only)
│   ├── dashboard.blade.php         # Admin dashboard
│   ├── user-details.blade.php      # View user details
│   ├── challenge-details.blade.php # View challenge details
│   ├── categories/                 # Category management
│   │   ├── index.blade.php
│   │   ├── create.blade.php
│   │   └── edit.blade.php
│   └── changelogs/                 # Changelog management
│       ├── index.blade.php
│       ├── create.blade.php
│       └── edit.blade.php
│
├── components/                      # Blade components
│   ├── layout/                     # Layout components
│   │   ├── navigation.blade.php   # Main navigation
│   │   ├── footer.blade.php       # Footer
│   │   ├── bottom-nav.blade.php   # Mobile bottom navigation
│   │   └── theme-toggle.blade.php # Theme switcher
│   ├── ui/                         # Generic UI components
│   │   ├── modal.blade.php        # Modal dialogs
│   │   ├── dropdown.blade.php     # Dropdown menus
│   │   ├── dropdown-link.blade.php
│   │   ├── page-header.blade.php  # Page headers
│   │   ├── stat-card.blade.php    # Statistics cards
│   │   └── app-button.blade.php   # Styled buttons
│   ├── forms/                      # Form components
│   │   ├── form-field.blade.php   # Field wrapper
│   │   ├── form-input.blade.php   # Input field
│   │   ├── form-textarea.blade.php
│   │   ├── form-select.blade.php
│   │   ├── form-checkbox.blade.php
│   │   ├── form-actions.blade.php # Form action buttons
│   │   ├── input-label.blade.php
│   │   ├── input-error.blade.php
│   │   ├── text-input.blade.php
│   │   ├── emoji-picker.blade.php
│   │   ├── frequency-selector.blade.php
│   │   └── habit-frequency-form.blade.php
│   ├── challenges/                 # Challenge-specific components
│   │   ├── challenge-card.blade.php
│   │   └── challenge-list-item.blade.php
│   ├── habits/                     # Habit-specific components
│   │   └── habit-list-item.blade.php
│   ├── goals/                      # Goal-specific components
│   │   ├── goal-list.blade.php
│   │   ├── goals-info-list.blade.php
│   │   └── goals-tracker.blade.php
│   ├── social/                     # Social-specific components
│   │   ├── activity-card.blade.php
│   │   └── user-content-tabs.blade.php
│   └── shared/                     # Utility components
│       ├── application-logo.blade.php
│       ├── auth-session-status.blade.php
│       ├── nav-link.blade.php
│       └── responsive-nav-link.blade.php
│
├── layouts/                         # Layout templates
│   ├── app.blade.php               # Authenticated layout
│   ├── public.blade.php            # Public pages layout
│   └── guest.blade.php             # Auth pages layout
│
└── errors/                          # Error pages
    ├── 403.blade.php               # Forbidden
    └── 404.blade.php               # Not found
```

---

## Component Usage (Dot Notation)

Laravel's component namespace feature allows organized components using dot notation:

### Layout Components
```blade
<x-layout.footer />
<x-layout.bottom-nav />
<x-layout.theme-toggle />
```

### UI Components
```blade
<x-ui.modal>...</x-ui.modal>
<x-ui.dropdown>...</x-ui.dropdown>
<x-ui.page-header title="Dashboard" />
<x-ui.stat-card label="Challenges" value="5" />
```

### Form Components
```blade
<x-forms.input-label for="name" value="Name" />
<x-forms.text-input id="name" name="name" />
<x-forms.input-error :messages="$errors->get('name')" />
<x-forms.form-select name="status" :options="$statuses" />
<x-forms.emoji-picker />
```

### Domain Components
```blade
<x-challenges.challenge-card :challenge="$challenge" />
<x-habits.habit-list-item :habit="$habit" />
<x-goals.goals-tracker :goals="$goals" />
<x-social.activity-card :activity="$activity" />
```

### Shared Components
```blade
<x-shared.application-logo />
<x-shared.nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
    Dashboard
</x-shared.nav-link>
```

---

## SCSS Folder Structure

```
resources/scss/
├── app.scss                         # Main entry point
│
├── abstracts/                       # Variables, mixins, functions
│   ├── _variables.scss             # SCSS variables & CSS custom properties
│   └── _mixins.scss                # Reusable SCSS mixins
│
├── base/                            # Foundation styles
│   ├── _typography.scss            # Font configurations
│   └── _utilities.scss             # Custom utility classes
│
├── layouts/                         # Layout-specific styles
│   ├── _public.scss                # Public pages (welcome, changelog, etc.)
│   ├── _auth.scss                  # Auth pages (login, register)
│   ├── _dashboard.scss             # Dashboard layout (challenges, habits)
│   └── _admin.scss                 # Admin panel layout
│
├── components/                      # Component-specific styles
│   └── common/                     # Shared across contexts
│       ├── _icons.scss             # Icon wrapper components (NEW)
│       ├── _badges.scss            # Status badges
│       ├── _buttons.scss           # Button styles (includes large CTAs)
│       ├── _cards.scss             # Card components
│       ├── _forms.scss             # Form inputs
│       ├── _navigation.scss        # Navigation patterns
│       ├── _headers.scss           # Page headers
│       ├── _empty-states.scss      # Empty states
│       ├── _links.scss             # Link styles
│       ├── _modals.scss            # Modal dialogs
│       ├── _list-items.scss        # List item patterns
│       └── _todos.scss             # Todo/goal list styles
│
├── pages/                           # Page-specific styles (if needed)
│   # Add page-specific overrides here
│
└── vendors/                         # Third-party overrides
    └── _toast.scss                 # Toast notification system
```

### SCSS Import Order (app.scss)

```scss
// 1. ABSTRACTS - No CSS output
@use 'abstracts/variables';
@use 'abstracts/mixins';

// 2. BASE - Typography and utilities
@use 'base/typography';  // Global typography classes (h1, h2, text-body, etc.)
@use 'base/utilities';

// 3. LAYOUTS - Context-specific
@use 'layouts/public';      // Public pages (welcome, changelog, etc.)
@use 'layouts/auth';        // Authentication pages (login, register)
@use 'layouts/dashboard';   // Dashboard/authenticated area
@use 'layouts/admin';       // Admin panel

// 4. COMPONENTS - Reusable UI
@use 'components/common/icons';   // Global icon wrappers (NEW)
@use 'components/common/badges';
@use 'components/common/buttons';  // Includes large CTA buttons
@use 'components/common/cards';
@use 'components/common/forms';
// ... etc

// 5. PAGES - Page-specific (if needed)

// 6. VENDORS - Third-party
@use 'vendors/toast';

// 7. TAILWIND - Framework (must come after @use)
@import 'tailwindcss/base';
@import 'tailwindcss/components';
@import 'tailwindcss/utilities';

// 8. GLOBAL STYLES
body {
    font-family: 'Inter', sans-serif;
}
```

**Note:** `@use` rules must come before `@import` rules in SCSS.

---

## Controller View Paths

Controllers reference views using the new folder structure:

### Public Pages
```php
return view('public.welcome');
return view('public.changelog', compact('changelogs'));
```

### Dashboard Pages
```php
return view('dashboard.challenges.index', compact('challenges'));
return view('dashboard.habits.show', compact('habit'));
return view('dashboard.feed.index', compact('activities'));
return view('dashboard.profile.edit');
```

### Admin Pages
```php
return view('admin.dashboard', compact('users'));
return view('admin.user-details', compact('user'));
```

### Partials
```php
return view('dashboard.partials.quick-goals', compact('activeChallenges'));
```

---

## Migration Summary

### What Changed

**Views:**
- All public pages moved to `public/` folder
- Dashboard pages organized by domain (`challenges/`, `habits/`, `goals/`, etc.)
- Components organized by context and purpose
- Component references use dot notation (`x-forms.input-label`)

**SCSS:**
- Modular architecture following SMACSS/ITCSS principles
- Clear separation: abstracts → base → layouts → components → vendors
- Layout files renamed and organized (`_public.scss`, `_dashboard.scss`, `_admin.scss`)
- Common components grouped in `components/common/`

**Controllers:**
- All view paths updated to match new structure
- Dashboard views prefixed with `dashboard.`
- Public views prefixed with `public.`

### Benefits

1. **Improved Organization** - Related files grouped together
2. **Better Scalability** - Easy to add new domains/features
3. **Clear Context** - Folder names indicate user context
4. **Maintainability** - Find files faster, understand relationships
5. **Team Collaboration** - Consistent structure for all developers
6. **Reduced Conflicts** - Less chance of merge conflicts with organized folders

---

## Adding New Features

### Adding a New Dashboard Page

1. Create view file in appropriate domain folder:
   ```
   resources/views/dashboard/{domain}/{page}.blade.php
   ```

2. Reference in controller:
   ```php
   return view('dashboard.{domain}.{page}');
   ```

### Adding a New Component

1. Create component in appropriate folder:
   ```
   resources/views/components/{context}/{component}.blade.php
   ```

2. Use with dot notation:
   ```blade
   <x-{context}.{component} />
   ```

### Adding Domain-Specific SCSS

1. Create folder in `resources/scss/components/`:
   ```
   resources/scss/components/{domain}/
   ```

2. Add SCSS files:
   ```scss
   // resources/scss/components/{domain}/_component-name.scss
   ```

3. Import in `app.scss`:
   ```scss
   @use 'components/{domain}/component-name';
   ```

---

## Best Practices

### Views
- ✅ Use dot notation for nested components
- ✅ Group related views by context (public, auth, dashboard, admin)
- ✅ Keep partials close to where they're used
- ✅ Reuse components when possible
- ❌ Don't create deeply nested folder structures (max 3 levels)
- ❌ Don't mix contexts (dashboard components in public folder)

### SCSS
- ✅ Use `@use` for module imports (better than `@import`)
- ✅ Keep `@use` rules before `@import` rules
- ✅ Group related styles in the same file
- ✅ Use abstracts for variables and mixins (no output)
- ✅ Follow the import order (abstracts → base → layouts → components)
- ❌ Don't create circular dependencies
- ❌ Don't use `@import` for SCSS modules (deprecated)

### Components
- ✅ Create components for reusable patterns (3+ uses)
- ✅ Use semantic naming (describes purpose, not appearance)
- ✅ Organize by domain when domain-specific
- ✅ Keep components small and focused
- ❌ Don't create components for one-off patterns
- ❌ Don't mix multiple concerns in one component

---

## Troubleshooting

### Component Not Found

**Error:** `View [x-forms.input-label] not found`

**Solution:** Verify component exists at `resources/views/components/forms/input-label.blade.php`

### SCSS Import Error

**Error:** `@use rules must be written before any other rules`

**Solution:** Move all `@use` statements before `@import` statements in `app.scss`

### View Not Found

**Error:** `View [dashboard.challenges.index] not found`

**Solution:** Verify file exists at `resources/views/dashboard/challenges/index.blade.php`

---

## References

- [Laravel Blade Components](https://laravel.com/docs/10.x/blade#components)
- [SMACSS Architecture](http://smacss.com/)
- [ITCSS Methodology](https://www.xfive.co/blog/itcss-scalable-maintainable-css-architecture/)
- [SCSS @use vs @import](https://sass-lang.com/documentation/at-rules/use)
