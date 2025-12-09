# Architecture & Project Structure

**Last Updated:** December 10, 2025  
**Purpose:** Core technical architecture and folder organization

---

## 🎯 Project Purpose

Challenge Checker is a personal goal-tracking and habit-building web application that helps users:
- Create **time-bound challenges** (30, 60, 90 days)
- Track **daily progress** on multiple goals
- Build **recurring habits** with flexible frequency
- Share achievements with a **social community**

---

## 🛠 Tech Stack

### Backend
- **Laravel 10+** - PHP framework (MVC architecture)
- **PHP 8.2+** - Modern PHP with typed properties
- **PostgreSQL** - Relational database with foreign key constraints

### Frontend
- **Blade Templates** - Laravel's templating engine
- **Alpine.js** - Lightweight reactive JavaScript (with Intersect plugin)
- **Tailwind CSS v3** - Utility-first CSS framework with JIT compiler
- **SCSS** - CSS preprocessing for component classes
- **Vite** - Modern build tool for asset bundling

### Authentication & Authorization
- **Laravel Breeze** - Authentication scaffolding
- **Policies** - Resource authorization
- **Admin System** - `is_admin` flag on users table

### Development Tools
- **Composer** - PHP dependency management
- **npm** - JavaScript package management
- **Git** - Version control

---

## 📁 Folder Structure

### Views Organization (`resources/views/`)

```
resources/views/
├── public/                          # Public-facing pages (unauthenticated)
│   ├── welcome.blade.php           # Landing page ✅ COMPLETE
│   ├── changelog.blade.php         # Product changelog ✅ COMPLETE
│   ├── privacy-policy.blade.php    # Privacy policy ✅ COMPLETE
│   ├── terms-of-service.blade.php  # Terms of service ✅ COMPLETE
│   └── imprint.blade.php           # Legal imprint ✅ COMPLETE
│
├── auth/                            # Authentication pages ✅ COMPLETE
│   ├── login.blade.php
│   ├── register.blade.php
│   ├── forgot-password.blade.php
│   ├── reset-password.blade.php
│   ├── confirm-password.blade.php
│   └── verify-email.blade.php
│
├── dashboard/                       # Authenticated user area 🚧 IN PROGRESS
│   ├── challenges/
│   │   ├── index.blade.php
│   │   ├── create.blade.php
│   │   ├── edit.blade.php
│   │   └── show.blade.php
│   ├── habits/
│   │   ├── index.blade.php
│   │   ├── create.blade.php
│   │   ├── edit.blade.php
│   │   ├── show.blade.php
│   │   └── today.blade.php
│   ├── goals/
│   │   ├── index.blade.php
│   │   └── show.blade.php
│   ├── feed/
│   │   └── index.blade.php
│   ├── profile/
│   │   ├── edit.blade.php
│   │   ├── menu.blade.php
│   │   └── partials/
│   ├── users/
│   │   ├── search.blade.php
│   │   └── show.blade.php
│   └── partials/
│
├── admin/                           # Admin panel 🚧 IN PROGRESS
│   ├── dashboard.blade.php
│   ├── user-details.blade.php
│   ├── challenge-details.blade.php
│   ├── categories/
│   └── changelogs/
│
└── components/                      # Blade components ✅ COMPLETE
    ├── layout/                     # Layout components
    │   ├── navigation.blade.php
    │   ├── footer.blade.php
    │   ├── bottom-nav.blade.php
    │   └── theme-toggle.blade.php
    ├── ui/                         # Generic UI components
    │   ├── modal.blade.php
    │   ├── dropdown.blade.php
    │   ├── page-header.blade.php
    │   ├── stat-card.blade.php
    │   └── app-button.blade.php
    ├── forms/                      # Form components
    ├── challenges/                 # Challenge-specific components
    ├── habits/                     # Habit-specific components
    ├── goals/                      # Goal-specific components
    └── social/                     # Social feature components
```

**Component Naming Convention:**
- Use dot notation: `<x-ui.modal>`, `<x-challenges.goal-card>`
- Organized by domain/context
- Reusable across multiple pages

---

### SCSS Organization (`resources/scss/`)

```
resources/scss/
├── app.scss                        # Main entry point
├── abstracts/                      # Variables, mixins (no CSS output)
│   ├── _variables.scss
│   └── _mixins.scss
├── base/                           # Global foundational styles
│   ├── _typography.scss           # h1, h2, text-body, etc. ✅ COMPLETE
│   └── _utilities.scss            # .section, .container ✅ COMPLETE
├── components/                     # Reusable component classes
│   ├── _badges.scss               # Status, frequency badges ✅ COMPLETE
│   ├── _buttons.scss              # Button variants ✅ COMPLETE
│   ├── _cards.scss                # Card patterns ✅ COMPLETE
│   ├── _changelog.scss            # Changelog components ✅ COMPLETE
│   ├── _empty-states.scss         # Empty state patterns ✅ COMPLETE
│   ├── _forms.scss                # Form components ✅ COMPLETE
│   ├── _modals.scss               # Modal styles ✅ COMPLETE
│   └── _nav.scss                  # Navigation styles ✅ COMPLETE
├── pages/                          # Page-specific styles
│   └── _welcome.scss              # Landing page only ✅ COMPLETE
└── vendors/                        # Third-party overrides
    └── _toast.scss                # Toast notifications ✅ COMPLETE
```

**SCSS Architecture Pattern:** SMACSS/ITCSS
- **Abstracts** - Variables only, no output
- **Base** - Global typography and utilities
- **Components** - Reusable classes (3+ uses)
- **Pages** - Page-specific classes only
- **Vendors** - Third-party library overrides

**Import Order in app.scss:**
```scss
// 1. Abstracts (no output)
@use 'abstracts/variables';
@use 'abstracts/mixins';

// 2. Base (typography, utilities)
@use 'base/typography';
@use 'base/utilities';

// 3. Components (reusable)
@use 'components/buttons';
// ... more components

// 4. Pages (specific)
@use 'pages/welcome';

// 5. Vendors (overrides)
@use 'vendors/toast';

// 6. Tailwind (must use @import)
@import 'tailwindcss/base';
@import 'tailwindcss/components';
@import 'tailwindcss/utilities';
```

---

### Controllers Organization (`app/Http/Controllers/`)

```
app/Http/Controllers/
├── Admin/                          # Admin-only controllers
│   ├── AdminController.php
│   ├── CategoryController.php
│   └── ChangelogController.php
├── Auth/                           # Authentication (Laravel Breeze)
├── ChallengeController.php         # Challenge CRUD
├── GoalController.php              # Goal library CRUD
├── GoalCompletionController.php    # Daily goal completions
├── HabitController.php             # Habit CRUD
├── HabitCompletionController.php   # Habit completions
├── FeedController.php              # Activity feed
├── UserController.php              # User profiles
├── FollowController.php            # Follow/unfollow
└── ActivityLikeController.php      # Activity likes
```

**Controller Patterns:**
- Resource controllers for CRUD operations
- Single-purpose controllers for specific actions
- Admin controllers in separate namespace
- Authorization via policies (checked in controller methods)

---

### Domain Models (`app/Domain/`)

```
app/Domain/
├── Activity/
│   ├── Activity.php               # Activity feed model
│   └── ActivityLike.php           # Activity likes
├── Admin/
│   ├── Category.php               # Goal categories
│   └── Changelog.php              # Product changelogs
├── Challenge/
│   ├── Challenge.php              # Time-bound challenges
│   ├── Goal.php                   # Challenge goals
│   └── DailyProgress.php          # Daily goal completions
├── Goal/
│   └── GoalLibrary.php            # Personal goal library
├── Habit/
│   ├── Habit.php                  # Recurring habits
│   └── HabitCompletion.php        # Habit completions
├── Social/
│   └── UserFollow.php             # User follow relationships
└── User/
    └── User.php                   # User model
```

**Domain-Driven Design:**
- Models organized by business domain
- Clear separation of concerns
- Each domain has its own namespace

---

## 🏗 Architectural Principles

### 1. Domain-Driven Design (DDD)
- Business logic organized by domain contexts
- Clear boundaries between domains
- Models contain domain-specific methods

### 2. Single Responsibility
- Each controller handles one resource
- Each model represents one concept
- Each component has one purpose

### 3. Policy-Based Authorization
- Centralized permission logic in `app/Policies/`
- Checked via `$this->authorize()` in controllers
- Blade directives: `@can`, `@cannot`

### 4. Component-Based UI
- Reusable Blade components
- Domain-specific component namespaces
- Props for customization

### 5. Progressive Enhancement
- Works without JavaScript (where possible)
- Alpine.js for interactivity
- Animations enhance but aren't required

---

## 🔑 Key Conventions

### Naming Conventions
- **Models:** Singular, PascalCase (`Challenge`, `GoalLibrary`)
- **Controllers:** Singular + "Controller" (`ChallengeController`)
- **Views:** Plural folder, singular file (`challenges/show.blade.php`)
- **Components:** Kebab-case (`goal-card.blade.php`)
- **SCSS Classes:** Kebab-case (`.feature-card`, `.btn-primary`)
- **Routes:** Plural resource names (`/challenges`, `/habits`)

### File Organization
- **Views:** Organized by user context (public → auth → dashboard → admin)
- **SCSS:** Organized by type (base → components → pages)
- **Controllers:** Organized by domain (flat except Admin/)
- **Models:** Organized by domain (nested by context)

### Routing Patterns
- Resource routes for CRUD: `Route::resource('challenges', ChallengeController::class)`
- Named routes: `route('challenges.show', $challenge)`
- Middleware: `auth`, `admin`, `verified`

---

## 🎨 Design System

### Color Palette
- **Primary Accent:** `slate-700` (dark mode: `slate-400`)
- **Backgrounds:** White/Gray-800
- **Text:** Gray-900/White (body), Gray-600/Gray-400 (muted)
- **Borders:** Gray-200/Gray-700
- **Success:** Green-500
- **Warning:** Orange-500
- **Error:** Red-500

### Typography Scale
- **h1:** 5xl-7xl, bold
- **h2:** 3xl-4xl, bold
- **h3:** xl, semibold
- **Body:** base, normal
- **Small:** sm, normal

### Spacing System
- **Section padding:** `py-12 md:py-20` (via `.section`)
- **Container:** `max-w-7xl mx-auto px-6`
- **Component spacing:** `space-y-4`, `gap-8`

### Responsive Breakpoints (Tailwind)
- **sm:** 640px
- **md:** 768px
- **lg:** 1024px
- **xl:** 1280px
- **2xl:** 1536px

---

## 🚀 Development Workflow

### Asset Compilation
```bash
# Development (watch mode)
npm run dev

# Production build
npm run build
```

### Database Migrations
```bash
# Run migrations
php artisan migrate

# Rollback
php artisan migrate:rollback

# Fresh install
php artisan migrate:fresh --seed
```

### Code Generation
```bash
# Create controller
php artisan make:controller NameController

# Create model
php artisan make:model Domain/Context/ModelName

# Create migration
php artisan make:migration create_table_name

# Create component
php artisan make:component ComponentName
```

---

## 📚 Next Steps

- Read `02-database.md` for database schema
- Read `03-styling-system.md` for SCSS patterns
- Read `04-blade-components.md` for component system
- Read `05-features.md` for business logic
- Read `06-public-pages-blueprint.md` for reference implementation
