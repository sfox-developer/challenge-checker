# Challenge Checker - Domain Models

## Model Organization

Models are organized by domain in `app/Domain/{Domain}/Models/`:
- `App\Domain\User\Models\User`
- `App\Domain\Challenge\Models\Challenge`
- `App\Domain\Challenge\Models\Goal`
- `App\Domain\Challenge\Models\DailyProgress`
- `App\Domain\Habit\Models\Habit`
- `App\Domain\Habit\Models\HabitCompletion`
- `App\Domain\Habit\Models\HabitStatistic`
- `App\Domain\Goal\Models\GoalLibrary`
- `App\Domain\Activity\Models\Activity`
- `App\Domain\Activity\Models\ActivityLike`
- `App\Domain\Social\Models\UserFollow`

---

## User Model

**Location:** `app/Domain/User/Models/User.php`

**Extends:** `Illuminate\Foundation\Auth\User as Authenticatable`

**Traits:** `HasFactory`, `Notifiable`

### Fillable Attributes
- `name`, `email`, `password`, `is_admin`, `avatar`, `theme_preference`

### Casts
- `email_verified_at` → datetime
- `password` → hashed
- `is_admin` → boolean

### Relationships

**One-to-Many:**
```php
challenges(): HasMany          // User's challenges
habits(): HasMany             // User's habits
goalsLibrary(): HasMany       // User's goal library
activities(): HasMany         // User's activities
```

**Many-to-Many (Self-referencing):**
```php
following(): BelongsToMany    // Users this user follows
followers(): BelongsToMany    // Users following this user
```

### Key Methods

**Social Methods:**
```php
isFollowing(User $user): bool       // Check if following another user
isFollowedBy(User $user): bool      // Check if followed by another user
follow(User $user): void            // Follow a user
unfollow(User $user): void          // Unfollow a user
```

**Helper Methods:**
```php
getFollowingCountAttribute(): int   // Count of users following
getFollowersCountAttribute(): int   // Count of followers
```

---

## Challenge Model

**Location:** `app/Domain/Challenge/Models/Challenge.php`

**Extends:** `Illuminate\Database\Eloquent\Model`

**Traits:** `HasFactory`

### Fillable Attributes
- `user_id`, `name`, `description`, `days_duration`
- `started_at`, `completed_at`, `is_active`, `is_public`

### Casts
- `started_at` → datetime
- `completed_at` → datetime
- `is_active` → boolean
- `is_public` → boolean

### Appends
- `end_date` - Calculated end date based on start + duration

### Relationships

```php
user(): BelongsTo              // Owner of the challenge
goals(): HasMany               // Challenge goals
dailyProgress(): HasMany       // Daily progress entries
activities(): HasMany          // Related activities
```

### State Methods

**Lifecycle:**
```php
start(): void                  // Start the challenge (sets started_at, is_active=true)
pause(): void                  // Pause challenge (is_active=false)
resume(): void                 // Resume challenge (is_active=true)
complete(): void               // Complete challenge (sets completed_at, is_active=false)
```

**State Checks:**
```php
isActive(): bool               // Started, active, not completed
isPaused(): bool               // Started, not active, not completed
isNotStarted(): bool           // Not started yet
isCompleted(): bool            // Has completed_at
hasExpired(): bool             // Duration exceeded
```

### Calculated Attributes

```php
getEndDateAttribute()          // start + days_duration
getStatusAttribute(): string   // 'draft', 'active', 'paused', 'completed'
```

### Progress Methods

```php
getProgressPercentage(): float      // Overall completion %
getCurrentDay(): int                // Current day number (1-based)
getCompletedDaysCount(): int        // Days with all goals completed
checkAndAutoComplete(): bool        // Auto-complete if expired
```

---

## Goal Model

**Location:** `app/Domain/Challenge/Models/Goal.php`

**Extends:** `Illuminate\Database\Eloquent\Model`

**Traits:** `HasFactory`

### Fillable Attributes
- `challenge_id`, `goal_library_id`, `name`, `description`, `order`

### Relationships

```php
challenge(): BelongsTo         // Parent challenge
library(): BelongsTo           // Source from goals library (nullable)
dailyProgress(): HasMany       // Daily completion records
```

### Key Methods

**Completion Tracking:**
```php
isCompletedForDate(string $date, int $userId): bool
  // Check if goal completed on specific date
  
markCompletedForToday(int $userId): DailyProgress
  // Mark goal as completed for today (updateOrCreate pattern)
```

**Dynamic Attributes:**
```php
getCurrentNameAttribute(): string
  // Returns library name if linked, otherwise stored name
  
getCurrentDescriptionAttribute(): ?string
  // Returns library description if linked, otherwise stored description
  
getIconAttribute(): ?string
  // Returns icon from library if linked
```

---

## DailyProgress Model

**Location:** `app/Domain/Challenge/Models/DailyProgress.php`

**Extends:** `Illuminate\Database\Eloquent\Model`

### Fillable Attributes
- `user_id`, `challenge_id`, `goal_id`, `date`, `completed_at`

### Casts
- `date` → date
- `completed_at` → datetime

### Relationships

```php
user(): BelongsTo
challenge(): BelongsTo
goal(): BelongsTo
```

### Database Constraints
- Unique: `(user_id, challenge_id, goal_id, date)`
- Prevents duplicate completions for same goal on same day

---

## Habit Model

**Location:** `app/Domain/Habit/Models/Habit.php`

**Extends:** `Illuminate\Database\Eloquent\Model`

**Traits:** `HasFactory`

### Fillable Attributes
- `user_id`, `goal_library_id`, `frequency_type`, `frequency_count`
- `frequency_config`, `is_active`, `archived_at`

### Casts
- `frequency_type` → `FrequencyType` enum (daily/weekly/monthly/yearly)
- `frequency_count` → integer
- `frequency_config` → array (JSON)
- `is_active` → boolean
- `archived_at` → datetime

### Relationships

```php
user(): BelongsTo              // Owner
goal(): BelongsTo              // Based on goal library
completions(): HasMany         // Completion records
statistics(): HasOne           // Aggregated stats
activities(): HasMany          // Related activities
```

### Scopes

```php
scopeActive($query)            // Only active (non-archived) habits
scopeArchived($query)          // Only archived habits
```

### State Methods

```php
isArchived(): bool             // Check if archived
archive(): void                // Archive habit (sets archived_at, is_active=false)
restore(): void                // Restore habit (clears archived_at, is_active=true)
```

### Frequency Methods

```php
getCompletionCountForPeriod(\DateTime $date = null): int
  // Count completions in current period based on frequency_type
  
isCompletedToday(): bool
  // Check if completed today
  
isOnTrack(\DateTime $date = null): bool
  // Check if meeting frequency goal
  
getRemainingCompletionsForPeriod(\DateTime $date = null): int
  // How many more completions needed this period
```

---

## HabitCompletion Model

**Location:** `app/Domain/Habit/Models/HabitCompletion.php`

**Extends:** `Illuminate\Database\Eloquent\Model`

### Fillable Attributes
- `habit_id`, `user_id`, `date`, `completed_at`
- `notes`, `duration_minutes`, `mood`, `metadata`

### Casts
- `date` → date
- `completed_at` → datetime
- `metadata` → array (JSON)

### Relationships

```php
habit(): BelongsTo
user(): BelongsTo
```

### Database Constraints
- Unique: `(habit_id, user_id, date)`
- One completion per habit per day

---

## HabitStatistic Model

**Location:** `app/Domain/Habit/Models/HabitStatistic.php`

**Extends:** `Illuminate\Database\Eloquent\Model`

### Fillable Attributes
- `habit_id`, `current_streak`, `best_streak`, `total_completions`
- `last_completed_at`, `streak_start_date`

### Casts
- `last_completed_at` → datetime
- `streak_start_date` → date

### Relationships

```php
habit(): BelongsTo             // One-to-one with habit
```

### Update Methods

```php
incrementStreak(): void        // Increment current streak
resetStreak(): void            // Reset current streak to 0
updateBestStreak(): void       // Update best_streak if current > best
incrementCompletions(): void   // Increment total_completions
```

---

## Category Model

**Location:** `app/Domain/Goal/Models/Category.php`

**Extends:** `Illuminate\Database\Eloquent\Model`

**Traits:** `HasFactory`

### Table Name
- `categories`

### Fillable Attributes
- `name`, `slug`, `icon`, `color`, `description`, `order`, `is_active`

### Casts
- `is_active` → boolean
- `order` → integer

### Relationships

```php
goalsLibrary(): HasMany        // Goals in this category
```

### Scopes

```php
scopeActive($query)
  // Only active categories (is_active = true)
  
scopeOrdered($query)
  // Order by 'order' column ascending
```

### Computed Attributes

```php
getGoalsCountAttribute(): int
  // Count of goals in this category
```

---

## GoalLibrary Model

**Location:** `app/Domain/Goal/Models/GoalLibrary.php`

**Extends:** `Illuminate\Database\Eloquent\Model`

**Traits:** `HasFactory`

### Table Name
- `goals_library` (specified explicitly)

### Fillable Attributes
- `user_id`, `name`, `description`, `category_id`, `icon`

### Relationships

```php
user(): BelongsTo              // Owner
category(): BelongsTo          // Category relationship (nullable)
challengeGoals(): HasMany      // Goals referencing this library entry
habits(): HasMany              // Habits using this goal
```

### Scopes

```php
scopeSearch($query, string $search)
  // Search by name or description
  
scopeByCategory($query, ?int $categoryId)
  // Filter by category_id
```

### Computed Attributes

```php
getUsageCountAttribute(): int
  // Total usage in challenges + habits
```

---

## Activity Model

**Location:** `app/Domain/Activity/Models/Activity.php`

**Extends:** `Illuminate\Database\Eloquent\Model`

**Traits:** `HasFactory`

### Fillable Attributes
- `user_id`, `challenge_id`, `goal_id`, `habit_id`, `type`, `data`

### Casts
- `data` → array (JSON)
- `created_at` → datetime

### Activity Type Constants

```php
const TYPE_GOAL_COMPLETED = 'goal_completed';
const TYPE_DAY_COMPLETED = 'day_completed';
const TYPE_CHALLENGE_STARTED = 'challenge_started';
const TYPE_CHALLENGE_COMPLETED = 'challenge_completed';
const TYPE_CHALLENGE_PAUSED = 'challenge_paused';
const TYPE_CHALLENGE_RESUMED = 'challenge_resumed';
const TYPE_HABIT_COMPLETED = 'habit_completed';
const TYPE_HABIT_STREAK = 'habit_streak';
const TYPE_HABIT_CREATED = 'habit_created';
```

### Relationships

```php
user(): BelongsTo              // Activity owner
challenge(): BelongsTo         // Related challenge (nullable)
goal(): BelongsTo              // Related goal (nullable)
habit(): BelongsTo             // Related habit (nullable)
likes(): HasMany               // Activity likes
```

### Social Methods

```php
isLikedBy(User $user): bool    // Check if user liked this activity
likesCount(): int              // Count of likes
```

### Scopes

```php
scopePublic($query, User $user)
  // Only public activities or user's own activities
  
scopeForFeed($query, User $user)
  // Activities for user's feed (following + own)
```

---

## ActivityLike Model

**Location:** `app/Domain/Activity/Models/ActivityLike.php`

**Extends:** `Illuminate\Database\Eloquent\Model`

### Fillable Attributes
- `user_id`, `activity_id`

### Relationships

```php
user(): BelongsTo
activity(): BelongsTo
```

### Database Constraints
- Unique: `(user_id, activity_id)`
- User can only like an activity once

---

## Model Patterns & Best Practices

### Eager Loading
Always eager load relationships to prevent N+1 queries:
```php
Challenge::with('user', 'goals.dailyProgress')->get();
Habit::with('goal', 'statistics')->get();
Activity::with('user', 'challenge', 'likes')->get();
```

### Soft Deletes
Not currently used. Instead, habits use `archived_at` for soft archiving.

### Factories
All main models have factories in `database/factories/`:
- `UserFactory`
- `ChallengeFactory`
- `GoalFactory`

### Model Events
Models can use observers for side effects:
- Creating an activity when challenge starts
- Updating habit statistics on completion
- Cascade updates to related records

### Accessors & Mutators
Use modern Laravel attribute casting and accessor methods:
```php
// Accessor
public function getStatusAttribute(): string

// Appends
protected $appends = ['end_date'];
```
