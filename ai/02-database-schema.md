# Challenge Checker - Database Schema

## Database Overview
- **Engine**: PostgreSQL
- **Migrations**: Located in `database/migrations/`
- **Foreign Keys**: Cascade deletes for data integrity
- **Indexes**: Strategic indexes on frequently queried columns

---

## Core Tables

### users
Primary user accounts table.

**Columns:**
- `id` - Primary key
- `name` - User's display name
- `email` - Unique email address
- `email_verified_at` - Email verification timestamp
- `password` - Hashed password (nullable for social-only accounts)
- `is_admin` - Boolean flag for admin privileges
- `avatar` - Avatar filename (stored in `public/avatars/`)
- `avatar_url` - Avatar URL from social provider
- `theme_preference` - User's theme choice (light/dark)
- `remember_token` - Remember me token
- `created_at`, `updated_at` - Timestamps

**Social Authentication Fields:**
- `provider` - OAuth provider (google, facebook)
- `provider_id` - Unique user ID from provider
- `provider_token` - Access token from provider (max 500 chars)
- `provider_refresh_token` - Refresh token for long-lived sessions (max 500 chars)
- `provider_token_expires_at` - Token expiration timestamp

**Constraints:**
- Unique: `(provider, provider_id)` - One provider account per user
- Index: `provider` - Fast lookups by provider type

**Relationships:**
- Has many: challenges, habits, goals_library, activities
- Many-to-many: followers/following (via user_follows)

---

## Challenge Domain

### challenges
Time-bound challenges created by users.

**Columns:**
- `id` - Primary key
- `user_id` - Foreign key to users (cascade delete)
- `name` - Challenge title
- `description` - Optional challenge description
- `days_duration` - Total days for the challenge (required, 1-365)
- `frequency_type` - Enum: daily, weekly, monthly, yearly (default: daily)
- `frequency_count` - Integer 1-7, how many times per period (default: 1)
- `frequency_config` - JSON, reserved for future use (currently null)
- `started_at` - When challenge was started (nullable)
- `completed_at` - When challenge was completed (nullable)
- `archived_at` - When challenge was archived (nullable)
- `is_active` - Boolean, currently active
- `is_public` - Boolean, visible to other users
- `created_at`, `updated_at` - Timestamps

**Indexes:**
- `user_id`, `created_at` for efficient user challenge queries
- `is_public` for public challenge filtering
- `archived_at` for filtering archived challenges

**States:**
- Archived: `archived_at` is set (highest priority - immutable state)
- Draft: `started_at` is null, `archived_at` is null
- Active: `started_at` is set, `is_active` true, `completed_at` null, `archived_at` is null
- Paused: `started_at` is set, `is_active` false, `completed_at` null, `archived_at` is null
- Completed: `completed_at` is set, `archived_at` is null

**Frequency System:**
Challenges support flexible frequency tracking:
- Daily: Track completion every day (frequency_count always 1)
- Weekly: Track N times per week (e.g., 3 times/week)
- Monthly: Track N times per month (e.g., 4 times/month)
- Yearly: Track N times per year (e.g., 12 times/year)

### goals
Individual goals within a challenge.

**Columns:**
- `id` - Primary key
- `challenge_id` - Foreign key to challenges (cascade delete)
- `goal_library_id` - Foreign key to goals_library (nullable, set null on delete)
- `name` - Goal name (snapshot from library or custom)
- `description` - Optional description
- `order` - Display order within challenge (default 0)
- `created_at`, `updated_at` - Timestamps

**Note:** Goals store a snapshot of the library goal at creation time. If linked to library, they can optionally display current library values.

### daily_progress
Daily completion tracking for goals.

**Columns:**
- `id` - Primary key
- `user_id` - Foreign key to users (cascade delete)
- `challenge_id` - Foreign key to challenges (cascade delete)
- `goal_id` - Foreign key to goals (cascade delete)
- `date` - Date of completion (DATE type)
- `completed_at` - Timestamp when marked complete (nullable)
- `created_at`, `updated_at` - Timestamps

**Unique Constraint:**
- Composite unique: `(user_id, challenge_id, goal_id, date)`
- Prevents duplicate entries for same goal on same day

**Indexes:**
- Unique constraint serves as composite index
- Efficient queries for daily progress lookups

---

## Habit Domain

### habits
Recurring habit tracking.

**Columns:**
- `id` - Primary key
- `user_id` - Foreign key to users (cascade delete)
- `goal_library_id` - Foreign key to goals_library (cascade delete)
- `frequency_type` - Enum: daily, weekly, monthly, yearly
- `frequency_count` - How many times per period (e.g., 3 times weekly)
- `frequency_config` - JSON, reserved for future use (currently null)
- `is_active` - Boolean, currently active
- `archived_at` - Timestamp when archived (nullable)
- `created_at`, `updated_at` - Timestamps

**Frequency Examples:**
- Daily: `frequency_type='daily'`, `frequency_count=1`
- 3x per week: `frequency_type='weekly'`, `frequency_count=3`
- Monthly: `frequency_type='monthly'`, `frequency_count=1`

### habit_completions
Individual habit completion records.

**Columns:**
- `id` - Primary key
- `habit_id` - Foreign key to habits (cascade delete)
- `user_id` - Foreign key to users (cascade delete)
- `date` - Completion date (DATE type)
- `completed_at` - Timestamp of completion
- `notes` - Optional text notes
- `duration_minutes` - Optional duration tracking
- `mood` - Optional mood (happy, neutral, tired, etc.)
- `metadata` - JSON for flexible future features
- `created_at`, `updated_at` - Timestamps

**Unique Constraint:**
- Composite unique: `(habit_id, user_id, date)`
- One completion per habit per day

**Indexes:**
- `(habit_id, date)` - Habit completion history
- `(user_id, date)` - User's daily completions

### habit_statistics
Aggregate statistics per habit.

**Columns:**
- `id` - Primary key
- `habit_id` - Foreign key to habits (unique, cascade delete)
- `current_streak` - Current consecutive days (default 0)
- `best_streak` - Best streak ever (default 0)
- `total_completions` - Total times completed (default 0)
- `last_completed_at` - Most recent completion timestamp (nullable)
- `streak_start_date` - When current streak started (nullable)
- `created_at`, `updated_at` - Timestamps

**Index:**
- `current_streak` for leaderboard queries

---

## Goal Library

### categories
Central category management table for organizing goals.

**Columns:**
- `id` - Primary key
- `name` - Category name (e.g., "Health", "Fitness")
- `slug` - URL-friendly identifier (auto-generated from name)
- `icon` - Emoji icon for visual representation (nullable)
- `color` - Color identifier for UI theming (nullable)
- `description` - Description of the category (nullable)
- `order` - Display order (default 0, lower numbers first)
- `is_active` - Boolean flag for active categories (default true)
- `created_at`, `updated_at` - Timestamps

**Indexes:**
- `order` - For efficient ordered queries
- `is_active` - For filtering active categories
- Unique: `slug` - Ensures unique identifiers

**Scopes:**
- `active()` - Filter only active categories
- `ordered()` - Order by `order` ASC

**Usage:**
- Referenced by `goals_library.category_id`
- Admin CRUD interface for management

### goals_library
Reusable goal templates.

**Columns:**
- `id` - Primary key
- `user_id` - Foreign key to users (cascade delete)
- `name` - Goal name
- `description` - Optional description
- `category_id` - Foreign key to categories (nullable, set null on delete)
- `icon` - Optional icon identifier (nullable, deprecated - use category icon)
- `created_at`, `updated_at` - Timestamps

**Index:**
- Composite: `(user_id, name)` for fast searches
- `category_id` - For filtering by category

**Usage:**
- Referenced by `goals.goal_library_id`
- Referenced by `habits.goal_library_id`
- Can track usage count via relationships

---

## Social Domain

### user_follows
User following relationships.

**Columns:**
- `id` - Primary key
- `follower_id` - Foreign key to users (who is following)
- `following_id` - Foreign key to users (who is being followed)
- `created_at`, `updated_at` - Timestamps

**Unique Constraint:**
- Composite unique: `(follower_id, following_id)`
- Prevents duplicate follows

**Index:**
- Composite: `(follower_id, following_id)`
- Efficient bidirectional queries

**Business Rule:**
- Users cannot follow themselves (enforced in application logic)

### activities
Activity feed events.

**Columns:**
- `id` - Primary key
- `user_id` - Foreign key to users (cascade delete)
- `challenge_id` - Foreign key to challenges (nullable, cascade delete)
- `goal_id` - Foreign key to goals (nullable, cascade delete)
- `habit_id` - Foreign key to habits (nullable, cascade delete)
- `type` - Activity type string
- `data` - JSON for additional context (nullable)
- `created_at`, `updated_at` - Timestamps

**Activity Types:**
- `goal_completed` - Goal completed for a day
- `day_completed` - All goals completed for a day
- `challenge_started` - Challenge was started
- `challenge_completed` - Challenge finished
- `challenge_paused` - Challenge paused
- `challenge_resumed` - Challenge resumed
- `habit_completed` - Habit completed
- `habit_streak` - Habit streak milestone
- `habit_created` - New habit created

**Indexes:**
- `(user_id, created_at)` - User timeline
- `created_at` - Global feed ordering

### activity_likes
Likes on activities.

**Columns:**
- `id` - Primary key
- `user_id` - Foreign key to users (cascade delete)
- `activity_id` - Foreign key to activities (cascade delete)
- `created_at`, `updated_at` - Timestamps

**Unique Constraint:**
- Composite unique: `(user_id, activity_id)`
- User can only like an activity once

---

## Admin Domain

### changelogs
Changelog entries managed by admins, displayed to users.

**Columns:**
- `id` - Primary key
- `version` - Version string (e.g., "v1.2.0") - varchar(50)
- `title` - Changelog title - varchar(255)
- `description` - Optional brief summary - text, nullable
- `changes` - Detailed list of changes - text
- `release_date` - Release date - date
- `is_published` - Boolean, whether visible to users (default: false)
- `is_major` - Boolean, marks major releases (default: false)
- `created_at`, `updated_at` - Timestamps

**Indexes:**
- `release_date` - For ordering by date
- `is_published` - For filtering published entries

**Relationships:**
- None (standalone table)

**Purpose:**
- Admin-managed changelog system
- Public view shows only published entries
- Supports major release highlighting

---

## Supporting Tables

### password_reset_tokens
Laravel's password reset tokens.

**Columns:**
- `email` - Primary key
- `token` - Reset token
- `created_at` - When token was created

### sessions
Laravel's session storage.

**Columns:**
- `id` - Session ID (primary)
- `user_id` - Foreign key to users (nullable, indexed)
- `ip_address` - Client IP
- `user_agent` - Browser user agent
- `payload` - Session data (long text)
- `last_activity` - Last activity timestamp (indexed)

### cache
Laravel's cache table (if using database driver).

### jobs
Laravel's queue jobs table (if using database queue).

---

## Migration Strategy

**Migration Naming:**
- Format: `YYYY_MM_DD_HHMMSS_description.php`
- Core tables created first
- Additive migrations for new features

**Rollback Safety:**
- All migrations have `down()` methods
- Foreign keys properly dropped in reverse order
- Indexes removed before columns

**Data Integrity:**
- Foreign key constraints with cascade deletes
- Unique constraints prevent duplicates
- Nullable fields where appropriate
- Default values for boolean flags

