# Challenge Checker - Routing & Controllers

## Route Organization

Routes are defined in `routes/web.php` with the following structure:
- Public routes (welcome page)
- Authenticated routes (wrapped in `auth` middleware)
- Admin routes (additional admin check)

---

## Public Routes

### Welcome Page
```php
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('feed.index');
    }
    return view('welcome');
});
```
- Unauthenticated: Show welcome/landing page
- Authenticated: Redirect to feed

### Authentication Routes
```php
require __DIR__.'/auth.php';
```
- Handled by Laravel Breeze
- Routes: `/login`, `/register`, `/logout`, `/password/reset`, etc.

---

## Authenticated Routes

All routes below are wrapped in `Route::middleware('auth')->group()`:

### Profile Routes
```php
Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
Route::get('/profile/menu', [ProfileController::class, 'menu'])->name('profile.menu');
Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
Route::post('/profile/theme', [ProfileController::class, 'updateTheme'])->name('profile.updateTheme');
```

**ProfileController Methods:**
- `edit()` - Show profile edit form
- `menu()` - Profile dropdown menu content (AJAX)
- `update()` - Update profile information
- `destroy()` - Delete user account
- `updateTheme()` - Save theme preference (light/dark)

### Feed Routes
```php
Route::get('/feed', [FeedController::class, 'index'])->name('feed.index');
Route::post('/feed/{activity}/like', [FeedController::class, 'toggleLike'])->name('feed.toggleLike');
Route::get('/feed/{activity}/likes', [FeedController::class, 'getLikes'])->name('feed.getLikes');
```

**FeedController Methods:**
- `index()` - Display activity feed
  - Loads activities from followed users + own
  - Filters by public challenges
  - Eager loads: user, challenge, goal, habit, likes
  - Paginated results
- `toggleLike(Activity $activity)` - Like/unlike an activity
  - Creates or deletes ActivityLike record
  - Returns JSON with updated like count
- `getLikes(Activity $activity)` - Get list of users who liked
  - Returns JSON array of user names

### Social Routes
```php
Route::post('/users/{user}/follow', [SocialController::class, 'follow'])->name('social.follow');
Route::post('/users/{user}/unfollow', [SocialController::class, 'unfollow'])->name('social.unfollow');
```

**SocialController Methods:**
- `follow(User $user)` - Follow a user
  - Prevents self-following
  - Creates UserFollow record
  - Returns JSON success
- `unfollow(User $user)` - Unfollow a user
  - Deletes UserFollow record
  - Returns JSON success

### User Routes
```php
Route::get('/users/search', [UserController::class, 'search'])->name('users.search');
Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
```

**UserController Methods:**
- `search()` - Search for users by name/email
  - Query parameter: `q`
  - Returns JSON array of users
- `show(User $user)` - Display user profile
  - Shows public challenges only (unless viewing own profile)
  - Shows user activities
  - Shows follower/following counts
  - Eager loads relationships

### Challenge Routes
```php
Route::resource('challenges', ChallengeController::class);
Route::post('/challenges/{challenge}/start', [ChallengeController::class, 'start'])->name('challenges.start');
Route::post('/challenges/{challenge}/pause', [ChallengeController::class, 'pause'])->name('challenges.pause');
Route::post('/challenges/{challenge}/resume', [ChallengeController::class, 'resume'])->name('challenges.resume');
Route::post('/challenges/{challenge}/complete', [ChallengeController::class, 'complete'])->name('challenges.complete');
```

**ChallengeController Methods:**

**Resource Methods:**
- `index()` - List user's challenges
  - Scoped to current user
  - Eager loads: goals, dailyProgress
- `create()` - Show challenge creation form
  - Loads user's goals library for selection
- `store()` - Save new challenge
  - Validates input
  - Creates Challenge record
  - Creates Goal records
  - Redirects to show page
- `show(Challenge $challenge)` - Display challenge details
  - Authorization via ChallengePolicy
  - Eager loads: goals.dailyProgress, user, activities
  - Calculates progress stats
- `edit(Challenge $challenge)` - Show edit form
  - Authorization via policy
- `update(Challenge $challenge)` - Update challenge
  - Validates input
  - Updates challenge
  - Syncs goals
- `destroy(Challenge $challenge)` - Delete challenge
  - Authorization via policy
  - Cascade deletes goals and progress

**Action Methods:**
- `start(Challenge $challenge)` - Start challenge
  - Sets started_at, is_active
  - Creates activity
- `pause(Challenge $challenge)` - Pause challenge
  - Sets is_active = false
  - Creates activity
- `resume(Challenge $challenge)` - Resume challenge
  - Sets is_active = true
  - Creates activity
- `complete(Challenge $challenge)` - Complete challenge
  - Sets completed_at
  - Creates activity

**Authorization:**
All methods use `ChallengePolicy` for authorization.

### Goal Routes
```php
Route::post('/goals/{goal}/toggle', [GoalController::class, 'toggle'])->name('goals.toggle');
```

**GoalController Methods:**
- `toggle(Goal $goal)` - Toggle goal completion for today
  - Checks if already completed today
  - If completed: deletes daily_progress record
  - If not completed: creates daily_progress record with completed_at
  - Creates activity (goal_completed or day_completed)
  - Returns JSON with updated state

### Habit Routes
```php
Route::get('/habits/today', [HabitController::class, 'today'])->name('habits.today');
Route::resource('habits', HabitController::class);
Route::post('/habits/{habit}/toggle', [HabitController::class, 'toggle'])->name('habits.toggle');
Route::post('/habits/{habit}/complete', [HabitController::class, 'complete'])->name('habits.complete');
Route::post('/habits/{habit}/archive', [HabitController::class, 'archive'])->name('habits.archive');
Route::post('/habits/{habit}/restore', [HabitController::class, 'restore'])->name('habits.restore');
```

**HabitController Methods:**

**Special Routes:**
- `today()` - Show today's habits and goals
  - Active habits for current user
  - Today's completion status
  - Quick completion interface

**Resource Methods:**
- `index()` - List user's habits
  - Active habits by default
  - Option to show archived
  - Eager loads: goal, statistics
- `create()` - Show habit creation form
  - Loads goals library
- `store()` - Save new habit
  - Validates input
  - Creates Habit record
  - Creates HabitStatistic record
  - Creates activity
- `show(Habit $habit)` - Display habit details
  - Shows completion calendar
  - Shows statistics
  - Shows frequency progress
- `edit(Habit $habit)` - Show edit form
- `update(Habit $habit)` - Update habit
- `destroy(Habit $habit)` - Delete habit

**Action Methods:**
- `toggle(Habit $habit)` - Quick toggle completion for today
  - If completed: delete today's completion
  - If not: create completion
  - Updates statistics
- `complete(Habit $habit)` - Complete with additional data
  - Request data: notes, duration, mood
  - Creates HabitCompletion with metadata
  - Updates statistics
  - Creates activity
- `archive(Habit $habit)` - Archive habit
  - Sets archived_at
  - Sets is_active = false
- `restore(Habit $habit)` - Restore archived habit
  - Clears archived_at
  - Sets is_active = true

### Goal Library Routes
```php
Route::get('/goals', [GoalLibraryController::class, 'index'])->name('goals.index');
Route::get('/goals/{goal}', [GoalLibraryController::class, 'show'])->name('goals.show');
Route::post('/goals', [GoalLibraryController::class, 'store'])->name('goals.store');
Route::put('/goals/{goal}', [GoalLibraryController::class, 'update'])->name('goals.update');
Route::delete('/goals/{goal}', [GoalLibraryController::class, 'destroy'])->name('goals.destroy');
Route::get('/api/goals/search', [GoalLibraryController::class, 'search'])->name('goals.search');
```

**GoalLibraryController Methods:**
- `index()` - List user's goals library
  - Optional category filter
  - Search functionality
- `show(GoalLibrary $goal)` - Show goal details
  - Shows usage count
  - Shows where used
- `store()` - Create new library goal
  - Validates input
  - Creates GoalLibrary record
- `update(GoalLibrary $goal)` - Update library goal
  - Updates record
  - Note: doesn't retroactively update linked goals
- `destroy(GoalLibrary $goal)` - Delete library goal
  - Sets goal_library_id to null in linked records
  - Deletes record
- `search()` - AJAX search endpoint
  - Query parameter: `q`
  - Returns JSON array for autocomplete

### API Routes (within auth middleware)
```php
Route::get('/api/quick-goals', [QuickGoalsController::class, 'index']);
Route::get('/api/quick-habits', [HabitController::class, 'quickHabits']);
```

**API Endpoints:**
- `/api/quick-goals` - Get goals for quick completion modal
  - Returns today's incomplete goals
  - Used for quick-complete feature
- `/api/quick-habits` - Get habits for quick completion
  - Returns active habits
  - Shows today's completion status

### Admin Routes
```php
Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin.dashboard');
Route::get('/admin/user/{user}', [AdminController::class, 'showUser'])->name('admin.user');
Route::delete('/admin/user/{user}', [AdminController::class, 'deleteUser'])->name('admin.user.delete');
Route::get('/admin/challenge/{challenge}', [AdminController::class, 'showChallenge'])->name('admin.challenge');
```

**Additional Middleware:**
All admin routes include a check: `if (!auth()->user()->is_admin) abort(403);`

**AdminController Methods:**
- `dashboard()` - Admin dashboard
  - System statistics
  - Recent users
  - Total counts
- `showUser(User $user)` - Admin user detail view
  - Shows ALL user data (including private)
  - Can delete user
- `deleteUser(User $user)` - Delete a user
  - Confirmation required
  - Cascade deletes all related data
- `showChallenge(Challenge $challenge)` - Admin challenge view
  - Shows full challenge details
  - Shows owner information
  - Different layout than public view

---

## Authorization Policies

### ChallengePolicy
**Location:** `app/Policies/ChallengePolicy.php`

**Methods:**
- `view(User $user, Challenge $challenge): bool`
  - Admins: can view all
  - Owners: can view own
  - Others: can view if public
- `update(User $user, Challenge $challenge): bool`
  - Only owner can update
- `delete(User $user, Challenge $challenge): bool`
  - Only owner can delete
- `create(User $user): bool`
  - All authenticated users can create

### Applying Policies
```php
// In controller
$this->authorize('view', $challenge);
$this->authorize('update', $challenge);

// In Blade
@can('update', $challenge)
    <button>Edit</button>
@endcan
```

---

## Route Model Binding

Laravel automatically resolves models from route parameters:

```php
Route::get('/challenges/{challenge}', [ChallengeController::class, 'show']);

// In controller:
public function show(Challenge $challenge)
{
    // $challenge is automatically loaded from database
}
```

**Scoping:**
Some routes may want to scope by current user:
```php
Route::scopeBindings()->group(function () {
    // Bindings scoped to authenticated user
});
```

---

## Middleware Stack

**Global Middleware:**
- Web middleware group (sessions, CSRF, cookies)
- Encrypt cookies
- Start session

**Route Middleware:**
- `auth` - Require authentication
- `verified` - Require email verification (if enabled)
- Custom admin check (inline in routes)

**Example Full Stack:**
```
Request
  → Web Middleware
    → CSRF Protection
    → Session Start
    → Auth Middleware
      → Admin Check
        → Controller Method
```

---

## API Response Patterns

### JSON Responses
```php
// Success
return response()->json([
    'success' => true,
    'message' => 'Action completed',
    'data' => $data
]);

// Error
return response()->json([
    'success' => false,
    'message' => 'Error message'
], 422);
```

### Redirect Responses
```php
// With success message
return redirect()
    ->route('challenges.show', $challenge)
    ->with('success', 'Challenge started!');

// With error
return back()
    ->withErrors(['error' => 'Something went wrong'])
    ->withInput();
```

---

## Request Validation

**Form Requests:**
Located in `app/Http/Requests/`

**Inline Validation:**
```php
$validated = $request->validate([
    'name' => 'required|string|max:255',
    'description' => 'nullable|string',
    'days_duration' => 'required|integer|min:1|max:365',
]);
```

**Custom Validation Rules:**
- Frequency validation for habits
- Date range validation for challenges
- Privacy setting validation
