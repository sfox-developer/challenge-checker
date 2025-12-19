# Features & Business Logic

**Last Updated:** December 10, 2025  
**Purpose:** Domain models, workflows, routes, and business logic

---

## 🎯 Core Features Overview

### 1. Challenge System
Time-bound challenges with multiple goals and daily tracking.

### 2. Habit Tracking
Recurring habits with flexible frequency and streak tracking.

### 3. Goals Library
Personal library of reusable goals with categories.

### 4. Social Features
Follow users, activity feed, and public challenge visibility.

### 5. Social Authentication
Google and Facebook OAuth for one-click signup/login.

### 6. Admin Panel
User management, challenge oversight, and changelog system.

---

## 📊 Domain Models

### User Model

**Location:** `app/Domain/User/Models/User.php`

**Key Relationships:**
```php
challenges()       // HasMany - User's challenges
habits()          // HasMany - User's habits
goalsLibrary()    // HasMany - Goal library
activities()      // HasMany - Activity feed
following()       // BelongsToMany - Users followed
followers()       // BelongsToMany - Followers
```

**Social Methods:**
```php
isFollowing(User $user): bool
follow(User $user): void
unfollow(User $user): void
```

**Authentication Methods:**
```php
isSocialUser(): bool  // Check if user registered via social auth
```

**Attributes:**
- Social auth fields: `provider`, `provider_id`, `provider_token`, `provider_refresh_token`
- Avatar handling: `avatar_url` (from provider) falls back to local `avatar`

---

## 🔐 Social Authentication

**Supported Providers:**
- Google (primary)
- Facebook

**Features:**
- One-click signup/login
- Auto email verification for social users
- Avatar import from provider
- Account linking (email-based)
- Token refresh support
- Secure token storage

**User Experience:**
- Social buttons on login/register pages
- Trust signals (Secure, No spam, Free)
- Password strength indicator
- Account linking for existing emails
- Post-registration success view with onboarding guidance
- Redirect to dashboard via success page

**Security:**
- Rate limiting (10 attempts/minute)
- CSRF protection
- Provider whitelist validation
- Secure token storage (hidden from serialization)
- OAuth state parameter verification

**Controllers:** 
- `App\Http\Controllers\Auth\SocialAuthController` (OAuth)
- `App\Http\Controllers\Auth\RegisteredUserController` (Standard registration)

**Routes:**
```php
// Social auth
GET  /auth/{provider}/redirect  // Redirect to OAuth provider
GET  /auth/{provider}/callback  // Handle OAuth callback

// Standard registration
GET  /register                   // Show registration form
POST /register                   // Process registration
GET  /welcome                    // Dashboard welcome/onboarding view (auth required)
```

**Configuration:**
- Environment variables in `.env`
- Service configuration in `config/services.php`
- See `SOCIAL-AUTH-SETUP.md` for OAuth setup guide

---

### Challenge Model

**Location:** `app/Domain/Challenge/Models/Challenge.php`

**States (Priority Order):**
1. **Archived** - `archived_at` is set (permanent)
2. **Draft** - Not started (`started_at` null)
3. **Active** - Running (`is_active` true)
4. **Paused** - Temporarily stopped
5. **Completed** - Finished (`completed_at` set)

**Key Relationships:**
```php
user()           // BelongsTo - Owner
goals()          // HasMany - Challenge goals
dailyProgress()  // HasMany - Daily completions
```

**Lifecycle Methods:**
```php
start(): void      // Begin challenge
pause(): void      // Pause progress
resume(): void     // Continue challenge
complete(): void   // Mark as finished
archive(): void    // Archive challenge
restore(): void    // Restore from archive
```

**State Checks:**
```php
isArchived(): bool
isActive(): bool
isPaused(): bool
isCompleted(): bool
hasExpired(): bool
```

**Progress Methods:**
```php
getProgressPercentage(): float
getCurrentDay(): int
getCompletedDaysCount(): int
```

**Frequency System:**
- Daily (default)
- Weekly (N times per week)
- Monthly (N times per month)
- Yearly (N times per year)

---

### Goal Model

**Location:** `app/Domain/Challenge/Models/Goal.php`

**Relationships:**
```php
challenge()        // BelongsTo - Parent challenge
library()          // BelongsTo - Goal library source
dailyProgress()    // HasMany - Completion records
```

**Methods:**
```php
isCompletedForDate(string $date, int $userId): bool
markCompletedForToday(int $userId): DailyProgress
```

---

### DailyProgress Model

**Location:** `app/Domain/Challenge/Models/DailyProgress.php`

**Purpose:** Track daily goal completions

**Unique Constraint:** `user_id`, `challenge_id`, `goal_id`, `date`

**Relationships:**
```php
user()           // BelongsTo
challenge()      // BelongsTo
goal()           // BelongsTo
```

---

### Habit Model

**Location:** `app/Domain/Habit/Models/Habit.php`

**States:**
- **Active** - Currently tracked
- **Archived** - Archived

**Relationships:**
```php
user()              // BelongsTo - Owner
goalLibrary()       // BelongsTo - Source goal
completions()       // HasMany - Completion records
statistic()         // HasOne - Statistics
```

**Frequency Types:**
```php
FrequencyType::DAILY    // Every day
FrequencyType::WEEKLY   // N times per week
FrequencyType::MONTHLY  // N times per month
FrequencyType::YEARLY   // N times per year
```

**Methods:**
```php
archive(): void
restore(): void
isCompletedToday(): bool
calculateCurrentStreak(): int
calculateLongestStreak(): int
calculateTotalCompletions(): int
updateStatistics(): void
```

---

### GoalLibrary Model

**Location:** `app/Domain/Goal/Models/GoalLibrary.php`

**Purpose:** Reusable goals for challenges and habits

**Relationships:**
```php
user()           // BelongsTo - Owner
category()       // BelongsTo - Category
challenges()     // HasMany - Challenges using this goal
habits()         // HasMany - Habits using this goal
```

**Attributes:**
- `name` - Goal name
- `description` - Goal description
- `icon` - Emoji or icon
- `category_id` - Category

---

### Activity Model

**Location:** `app/Domain/Activity/Models/Activity.php`

**Types:**
- Challenge created
- Challenge completed
- Habit milestone
- Goal library item added

**Relationships:**
```php
user()          // BelongsTo - Activity owner
subject()       // MorphTo - Related entity
likes()         // HasMany - Activity likes
```

**Scopes:**
```php
scopePublic()   // Only public activities
scopeForFeed()  // Feed-relevant activities
```

---

## 🔄 Workflows

### Challenge Workflow

1. **Create Challenge (Draft State)**
   - User creates challenge with name, description, duration
   - Add goals from library or create new ones
   - Set privacy (public/private)
   - State: Draft

2. **Start Challenge**
   - Call `$challenge->start()`
   - Sets `started_at`, `is_active = true`
   - Creates activity feed entry
   - State: Active

3. **Daily Progress Tracking**
   - User marks goals complete each day
   - Creates `DailyProgress` records
   - Updates challenge progress percentage

4. **Pause/Resume**
   - Call `$challenge->pause()` or `$challenge->resume()`
   - Toggles `is_active` flag
   - No data loss

5. **Complete Challenge**
   - Call `$challenge->complete()`
   - Sets `completed_at`, `is_active = false`
   - Creates completion activity
   - State: Completed

6. **Archive Challenge**
   - Call `$challenge->archive()`
   - Sets `archived_at`
   - State: Archived (final, immutable)

---

### Habit Workflow

1. **Create Habit**
   - User creates habit from goal library
   - Sets frequency (daily/weekly/monthly/yearly)
   - Sets frequency count (e.g., 3x per week)
   - State: Active

2. **Complete Habit**
   - User marks habit complete for day
   - Creates `HabitCompletion` record
   - Updates statistics (streak, total completions)

3. **Streak Tracking**
   - Current streak calculated automatically
   - Longest streak tracked
   - Missing days break streak

4. **Archive Habit**
   - Call `$habit->archive()`
   - Sets `archived_at`
   - Statistics preserved

---

### Social Workflow

1. **Follow User**
   - Call `$user->follow($otherUser)`
   - Creates `UserFollow` record
   - Enables viewing public activities

2. **Activity Feed**
   - Shows activities from followed users
   - Filtered by public visibility
   - Ordered by recent first

3. **Like Activity**
   - Creates `ActivityLike` record
   - Unique constraint: user + activity

4. **User Discovery** ✅ COMPLETE (Dec 19, 2025)
   - Search users by name or email
   - Discover active community members
   - View followed users section
   - Filter between "All Users" and "Following"
   - See user stats (challenges, habits, goals)
   - Recent activity indicators

**Discovery Page Features:**
- Stats section (active users, following, followers)
- Hero section with Lottie animation
- Following section (quick access to 6 followed users)
- Search functionality (minimum 2 characters)
- Enhanced user cards with:
  * Public challenges count
  * Active habits count
  * Goals library count
  * Recent activity indicator (last 7 days)
- Filter tabs (All Users / Following)
- Benefits section explaining value of connections
- FAQ section covering common questions
- Scroll-triggered animations following blueprint

**Controller:** `app/Http/Controllers/UserController.php`

**Routes:**
```php
GET /users/search  // Discovery/search page (users.search)
GET /users/{user}  // User profile (users.show)
```

---

## 🛣 Routes & Controllers

### Challenge Routes

```php
Route::resource('challenges', ChallengeController::class)
    ->middleware(['auth', 'verified']);

Route::post('challenges/{challenge}/start', [ChallengeController::class, 'start'])
    ->name('challenges.start');
Route::post('challenges/{challenge}/pause', [ChallengeController::class, 'pause'])
    ->name('challenges.pause');
Route::post('challenges/{challenge}/resume', [ChallengeController::class, 'resume'])
    ->name('challenges.resume');
Route::post('challenges/{challenge}/complete', [ChallengeController::class, 'complete'])
    ->name('challenges.complete');
Route::post('challenges/{challenge}/archive', [ChallengeController::class, 'archive'])
    ->name('challenges.archive');
Route::post('challenges/{challenge}/restore', [ChallengeController::class, 'restore'])
    ->name('challenges.restore');
```

**Controller:** `app/Http/Controllers/ChallengeController.php`

**Authorization:** Via `ChallengePolicy`

**Challenge Index Page:**

The challenge index page (`challenges.index`) provides:

1. **Statistics Cards** (4-column grid, equal heights)
   - Total Challenges
   - Completed Challenges
   - Active Challenges
   - Draft Challenges

2. **Progress Insights Card** (displayed when challenges exist)
   - Total Goals: Count across all challenges
   - Goals Completed: All-time achievement count
   - Weekly Completion Rate: Last 7 days average percentage

3. **Tab Filters** (disabled when count is 0)
   - All, Active, Paused, Completed, Draft, Archived
   - Alpine.js client-side filtering
   - Count badges

4. **Challenge List** with animations
   - Status-based filtering via Alpine.js
   - Staggered fade-up animations

5. **Benefits & FAQ Section** (static content below listing)
   - 3 benefit cards: Clear Deadlines, Track Progress, Build Habits
   - 4 FAQ items about challenges

**Data Provided to View:**
```php
$challenges          // Collection of user's challenges
$totalChallenges     // Total count
$activeChallenges    // Active count
$allCount            // All challenges count
$activeCount         // Active filter count
$pausedCount         // Paused filter count
$completedCount      // Completed filter count
$draftCount          // Draft filter count
$archivedCount       // Archived filter count
$totalGoals          // Total goals across all challenges
$completedGoalsCount // All-time completed goals
$completionRate      // Weekly completion percentage (last 7 days)
```

---

### Habit Routes

```php
Route::resource('habits', HabitController::class)
    ->middleware(['auth', 'verified']);

Route::post('habits/{habit}/archive', [HabitController::class, 'archive'])
    ->name('habits.archive');
Route::post('habits/{habit}/restore', [HabitController::class, 'restore'])
    ->name('habits.restore');

Route::post('habits/{habit}/complete', [HabitCompletionController::class, 'store'])
    ->name('habits.complete');
Route::delete('habits/{habit}/complete', [HabitCompletionController::class, 'destroy'])
    ->name('habits.uncomplete');
```

**Controllers:**
- `app/Http/Controllers/HabitController.php`
- `app/Http/Controllers/HabitCompletionController.php`

---

### Goal Completion Routes

```php
Route::post('goals/{goal}/complete', [GoalCompletionController::class, 'store'])
    ->name('goals.complete');
Route::delete('goals/{goal}/complete/{date}', [GoalCompletionController::class, 'destroy'])
    ->name('goals.uncomplete');
```

**Controller:** `app/Http/Controllers/GoalCompletionController.php`

---

### Social Routes

```php
Route::get('feed', [FeedController::class, 'index'])->name('feed.index');

Route::post('users/{user}/follow', [FollowController::class, 'store'])
    ->name('users.follow');
Route::delete('users/{user}/follow', [FollowController::class, 'destroy'])
    ->name('users.unfollow');

Route::post('activities/{activity}/like', [ActivityLikeController::class, 'store'])
    ->name('activities.like');
Route::delete('activities/{activity}/like', [ActivityLikeController::class, 'destroy'])
    ->name('activities.unlike');
```

---

### Admin Routes

```php
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');
    
    Route::resource('categories', CategoryController::class);
    Route::resource('changelogs', ChangelogController::class);
    
    Route::get('users/{user}', [AdminController::class, 'showUser'])
        ->name('admin.users.show');
    Route::get('challenges/{challenge}', [AdminController::class, 'showChallenge'])
        ->name('admin.challenges.show');
});
```

---

## 🔐 Authorization

### Policies

**ChallengePolicy:**
- `view` - Owner or public challenge
- `update` - Owner only
- `delete` - Owner only
- `start/pause/complete` - Owner only

**HabitPolicy:**
- `view` - Owner only
- `update` - Owner only
- `delete` - Owner only

**GoalLibraryPolicy:**
- `view` - Owner only
- `update` - Owner only
- `delete` - Owner only (if not in use)

### Middleware

- `auth` - Requires authentication
- `verified` - Requires email verification
- `admin` - Requires `is_admin = true`

---

## 🎨 Activity Feed System

### Activity Types

```php
'challenge_created'
'challenge_started'
'challenge_completed'
'habit_created'
'habit_streak_milestone'
'goal_library_created'
```

### Activity Creation

```php
Activity::create([
    'user_id' => $user->id,
    'type' => 'challenge_completed',
    'subject_type' => Challenge::class,
    'subject_id' => $challenge->id,
    'data' => [
        'challenge_name' => $challenge->name,
        'days_completed' => $challenge->getCompletedDaysCount(),
    ],
]);
```

### Feed Filtering

```php
$activities = Activity::query()
    ->whereIn('user_id', $followedUserIds)
    ->public()
    ->latest()
    ->with(['user', 'subject'])
    ->paginate(20);
```

---

## 📚 Quick Reference

### Model Locations
```
app/Domain/
├── User/Models/User.php
├── Challenge/Models/
│   ├── Challenge.php
│   ├── Goal.php
│   └── DailyProgress.php
├── Habit/Models/
│   ├── Habit.php
│   ├── HabitCompletion.php
│   └── HabitStatistic.php
├── Goal/Models/GoalLibrary.php
├── Activity/Models/
│   ├── Activity.php
│   └── ActivityLike.php
└── Social/Models/UserFollow.php
```

### Common Operations

**Create Challenge:**
```php
$challenge = Challenge::create([
    'user_id' => auth()->id(),
    'name' => 'My Challenge',
    'days_duration' => 30,
    'is_public' => true,
]);
```

**Mark Goal Complete:**
```php
$goal->markCompletedForToday(auth()->id());
```

**Follow User:**
```php
auth()->user()->follow($otherUser);
```

**Get Activity Feed:**
```php
$activities = Activity::forFeed(auth()->user())->paginate(20);
```

---

For database schema details, see **02-database.md**.
