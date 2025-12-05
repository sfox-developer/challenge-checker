# Challenge Checker - Overview & Tech Stack

## Project Purpose

Challenge Checker is a personal goal-tracking and habit-building web application that helps users create time-bound challenges, track daily progress, build recurring habits, and share their achievements with a social community.

**Core Concept:**
- Users create **Challenges** (time-bound, e.g., "30-day fitness challenge")
- Each challenge contains multiple **Goals** (daily tasks like "drink water", "exercise")
- Users track daily completion of goals
- Users can also create standalone **Habits** with flexible frequency tracking
- Social features allow following friends and viewing their activity feed
- Admin panel for user and challenge management

---

## Technology Stack

### Backend Framework
- **Laravel 10+** - PHP framework following MVC architecture
- **PHP 8.2+** - Modern PHP with typed properties and enums
- **PostgreSQL** - Relational database with proper foreign key constraints

### Frontend Stack
- **Blade Templates** - Laravel's templating engine
- **Alpine.js** - Lightweight reactive JavaScript framework
- **Tailwind CSS v3** - Utility-first CSS framework with JIT compiler
- **Vite** - Modern build tool for asset bundling
- **SCSS** - CSS preprocessing for custom styles

### Authentication & Authorization
- **Laravel Breeze** - Simple authentication scaffolding
- **Policies** - Authorization logic for resource access
- Custom admin role system (`is_admin` flag on users)

### Development Tools
- **Composer** - PHP dependency management
- **npm** - JavaScript package management
- **Laravel Mix/Vite** - Asset compilation
- **Git** - Version control

---

## Architecture Pattern

**Domain-Driven Design (DDD)** structure:
```
app/
├── Application/Services/     # Application services
├── Domain/                   # Domain models by context
│   ├── Activity/            # Activity feed domain
│   ├── Challenge/           # Challenge management
│   ├── Goal/                # Goal library
│   ├── Habit/               # Habit tracking
│   ├── Social/              # Social features
│   └── User/                # User management
├── Http/Controllers/        # HTTP request handlers
├── Infrastructure/          # External services
└── Policies/               # Authorization policies
```

**Key Architectural Principles:**
1. **Single Responsibility** - Each model/controller has one clear purpose
2. **Domain Separation** - Business logic organized by domain contexts
3. **Repository Pattern** - Data access abstraction (Infrastructure layer)
4. **Policy-Based Authorization** - Centralized permission logic
5. **Component-Based UI** - Reusable Blade components

---

## Key Features Overview

### 1. Challenge System
- Create time-bound challenges (e.g., 30 days, 60 days)
- Add goals from library or create new ones
- Track daily progress per goal
- Challenge lifecycle: draft → active → paused → completed
- Public/private visibility

### 2. Habit Tracking
- Create recurring habits based on goals library
- Flexible frequency: daily, weekly, monthly, yearly
- Streak tracking and statistics
- Completion notes and mood tracking
- Archive/restore functionality

### 3. Goals Library
- Personal library of reusable goals
- Categories and icons
- Used across challenges and habits
- Search and filter capabilities

### 4. Social Features
- Follow/unfollow users
- Activity feed showing friend activities
- Like activities
- Public challenge visibility
- User profiles

### 5. Admin Panel
- View all users and their details
- View any challenge (including private)
- Delete users
- Monitor system usage

---

## Development Conventions

### Naming Conventions
- **Models**: Singular, PascalCase (e.g., `Challenge`, `Goal`)
- **Tables**: Plural, snake_case (e.g., `challenges`, `goals`)
- **Controllers**: Singular + "Controller" (e.g., `ChallengeController`)
- **Routes**: Resource-based, plural (e.g., `/challenges`, `/habits`)
- **Blade Components**: kebab-case with `x-` prefix (e.g., `x-stat-card`)
- **Alpine Components**: camelCase (e.g., `themeManager`, `habitForm`)

### File Organization
- Domain models in `app/Domain/{Domain}/Models/`
- Controllers in `app/Http/Controllers/`
- Blade views in `resources/views/`
- Components in `resources/views/components/`
- JavaScript in `resources/js/` organized by domain
- Migrations timestamped and descriptive

### Code Style
- Follow PSR-12 coding standards for PHP
- Use type hints for method parameters and return types
- Eloquent relationships explicitly defined
- Eager loading to prevent N+1 queries
- Form requests for validation

---

## Environment & Configuration

### Required Environment Variables
```env
APP_NAME="Challenge Checker"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=challenge_checker
DB_USERNAME=postgres
DB_PASSWORD=secret
```

### Key Configuration Files
- `config/app.php` - Application settings
- `config/database.php` - Database connections
- `config/auth.php` - Authentication configuration
- `vite.config.js` - Asset bundling
- `tailwind.config.js` - Tailwind CSS customization
- `postcss.config.js` - PostCSS plugins

---

## Asset Pipeline

### Vite Configuration
- Entry point: `resources/js/app.js`
- SCSS compilation from `resources/scss/`
- Hot module replacement in development
- Production builds with minification

### Tailwind Configuration
- Dark mode: class strategy
- Custom colors and gradients
- Safelist for dynamic classes
- JIT compiler for optimal bundle size

### Alpine.js Integration
- Global components registered in `resources/js/components/index.js`
- Component-based architecture
- Reactive state management
- Modal and form handling
