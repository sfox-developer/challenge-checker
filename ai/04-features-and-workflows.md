# Challenge Checker - Features & User Workflows

## Feature 1: Challenge Management

### Creating a Challenge

**User Flow:**
1. User navigates to `/challenges/create`
2. Fills in challenge form:
   - Name (required)
   - Description (optional)
   - Duration in days (required, e.g., 30, 60, 90)
   - Privacy setting (public/private)
3. Adds goals either:
   - From goals library (searchable dropdown)
   - Create new goal inline
4. Submits form
5. Redirected to challenge details page

**Backend Process:**
- Controller: `ChallengeController@store`
- Validates input
- Creates Challenge record (status: draft, `started_at` null)
- Creates related Goal records
- If new goals, optionally adds to goals library
- Returns to challenge show page

**Database Changes:**
- New record in `challenges` table
- New records in `goals` table
- Optionally new records in `goals_library`

### Starting a Challenge

**User Flow:**
1. From challenge detail page, click "Start Challenge"
2. Confirmation modal appears
3. Click confirm
4. Challenge status updates to "Active"
5. Daily goal tracker becomes available

**Backend Process:**
- Route: `POST /challenges/{challenge}/start`
- Controller: `ChallengeController@start`
- Updates challenge: `started_at = now()`, `is_active = true`
- Creates activity: `TYPE_CHALLENGE_STARTED`
- Initializes daily progress tracking

**State Change:**
- Draft → Active
- `started_at` set to current timestamp
- `is_active` = true

### Daily Goal Tracking

**User Flow:**
1. User views challenge detail page
2. Sees list of goals for today
3. Clicks checkbox next to goal to complete it
4. Goal marked complete with animation
5. Progress bar updates
6. If all goals complete for day, celebration animation

**Backend Process:**
- Route: `POST /goals/{goal}/toggle`
- Controller: `GoalController@toggle`
- Creates or updates `DailyProgress` record
- Sets `completed_at` timestamp
- Creates activity: `TYPE_GOAL_COMPLETED`
- If all goals for day complete, creates: `TYPE_DAY_COMPLETED`

**Database Changes:**
- Insert/update in `daily_progress` table
- New record in `activities` table

### Pausing a Challenge

**User Flow:**
1. From challenge detail, click "Pause Challenge"
2. Confirmation modal
3. Challenge marked as paused
4. Daily tracking disabled

**Backend Process:**
- Route: `POST /challenges/{challenge}/pause`
- Controller: `ChallengeController@pause`
- Updates: `is_active = false`
- Creates activity: `TYPE_CHALLENGE_PAUSED`

**State Change:**
- Active → Paused
- Time still counts (no duration extension)

### Resuming a Challenge

**User Flow:**
1. From paused challenge, click "Resume"
2. Challenge reactivates
3. Daily tracking re-enabled

**Backend Process:**
- Route: `POST /challenges/{challenge}/resume`
- Controller: `ChallengeController@resume`
- Updates: `is_active = true`
- Creates activity: `TYPE_CHALLENGE_RESUMED`

**State Change:**
- Paused → Active

### Completing a Challenge

**User Flow:**
- **Automatic**: When duration expires, auto-completes
- **Manual**: User clicks "Complete Challenge" button

**Backend Process:**
- Route: `POST /challenges/{challenge}/complete`
- Controller: `ChallengeController@complete`
- Updates: `completed_at = now()`, `is_active = false`
- Creates activity: `TYPE_CHALLENGE_COMPLETED`
- Shows completion stats

**State Change:**
- Active → Completed
- `completed_at` timestamp set

---

## Feature 2: Habit Tracking

### Creating a Habit

**User Flow:**
1. Navigate to `/habits/create`
2. Select goal from library or create new
3. Configure frequency:
   - Type: Daily, Weekly, Monthly, Yearly
   - Count: How many times per period
   - Optional: Specific days (for weekly)
4. Set privacy (public/private checkbox)
5. Submit form

**Backend Process:**
- Controller: `HabitController@store`
- Creates Habit record (with `is_public` flag)
- Creates HabitStatistic record (initialized to 0s)
- Optionally creates GoalLibrary entry
- Creates activity: `TYPE_HABIT_CREATED`

**Privacy Behavior:**
- Public habits (`is_public = true`): Visible on user profiles
- Private habits (`is_public = false`): Only visible to owner
- Default: Private
- Admin view shows all habits regardless of privacy setting

**Frequency Examples:**
- Daily meditation: type=daily, count=1
- Gym 3x/week: type=weekly, count=3
- Monthly review: type=monthly, count=1

### Completing a Habit

**User Flow:**
1. From habits list or today view, click habit
2. Modal opens with optional fields:
   - Notes (text)
   - Duration (minutes)
   - Mood (happy/neutral/tired/etc)
3. Click "Mark Complete"
4. Success animation
5. Streak counter updates

**Backend Process:**
- Route: `POST /habits/{habit}/complete`
- Controller: `HabitController@complete`
- Creates HabitCompletion record
- Updates HabitStatistic:
  - Increment `total_completions`
  - Update streak logic
  - Set `last_completed_at`
- Creates activity: `TYPE_HABIT_COMPLETED`
- If streak milestone, creates: `TYPE_HABIT_STREAK`

**Streak Logic:**
```
If today follows last_completed_at:
  current_streak++
  if current_streak > best_streak:
    best_streak = current_streak
Else if gap > 1 day:
  current_streak = 1
  streak_start_date = today
```

### Viewing Habit Progress

**User Flow:**
1. Navigate to `/habits/{habit}`
2. See statistics:
   - Current streak
   - Best streak
   - Total completions
   - Completion calendar
   - Frequency progress (e.g., "2 of 3 this week")

**Data Sources:**
- HabitStatistic for streaks
- HabitCompletion for calendar
- Calculated: progress toward frequency goal

### Archiving a Habit

**User Flow:**
1. From habit detail, click "Archive"
2. Habit moves to archived section
3. No longer appears in active list
4. Statistics preserved

**Backend Process:**
- Route: `POST /habits/{habit}/archive`
- Controller: `HabitController@archive`
- Updates: `archived_at = now()`, `is_active = false`
- Does NOT create activity (private action)

**Restoring:**
- Similar flow, clears `archived_at`

---

## Feature 3: Goals Library

### Purpose
Central repository of reusable goals that can be:
- Added to challenges
- Used as basis for habits
- Organized by categories
- Shared across multiple challenges

### Managing Goals Library

**Creating a Goal:**
1. Navigate to `/goals`
2. Click "Add New Goal"
3. Fill in:
   - Name (required)
   - Description (optional)
   - Category (optional)
   - Icon (optional)
4. Save

**Backend:**
- Route: `POST /goals`
- Controller: `GoalLibraryController@store`
- Creates GoalLibrary record

**Using a Library Goal:**
- When creating challenge: search and select from library
- When creating habit: select from library
- Goal data is snapshot at creation time
- Link to library preserved for updates

**Editing a Library Goal:**
- Changes affect:
  - Future usage (new challenges/habits)
  - Display name in linked goals (if using dynamic attribute)
- Does NOT retroactively change snapshot data

---

## Feature 4: Social Feed

### Activity Feed

**User Flow:**
1. Navigate to `/feed` (default authenticated landing page)
2. See chronological feed of:
   - Own activities
   - Activities from followed users
   - Only public challenges shown
3. Can like activities
4. Click activity to view details

**Feed Algorithm:**
```sql
WHERE (user_id = current_user 
   OR user_id IN (following_ids))
  AND (challenge.is_public = true 
   OR user_id = current_user)
ORDER BY created_at DESC
```

**Activity Types Shown:**
- Challenge started/completed/paused/resumed
- Goals/days completed
- Habits completed
- Habit streak milestones

### Following Users

**User Flow:**
1. Search for user (`/users/search`)
2. View user profile (`/users/{user}`)
3. Click "Follow" button
4. User's public activities appear in feed
5. Can unfollow anytime

**Backend:**
- Route: `POST /users/{user}/follow`
- Controller: `SocialController@follow`
- Creates UserFollow record
- Business rule: cannot follow yourself

**User Profile View:**
- Shows user's public challenges
- Shows user's activities
- Shows follower/following counts
- Shows follow button (if not self)

### Liking Activities

**User Flow:**
1. See activity in feed
2. Click heart icon
3. Icon fills/animates
4. Like count increments
5. Click again to unlike

**Backend:**
- Route: `POST /feed/{activity}/like`
- Controller: `FeedController@toggleLike`
- Creates or deletes ActivityLike record
- Returns updated like count

---

## Feature 5: Admin Panel

### Accessing Admin Panel

**Requirements:**
- User must have `is_admin = true`
- Middleware checks on all admin routes

**Dashboard:**
- Route: `/admin`
- Shows:
  - Total users
  - Total challenges
  - Total habits
  - Recent users
  - System stats

### Viewing User Details (Admin)

**User Flow:**
1. From admin dashboard, click user
2. Navigate to `/admin/user/{user}`
3. See comprehensive user details:
   - Profile information
   - All challenges (including private)
   - All habits
   - Activities
4. Can delete user

**Key Difference from Public Profile:**
- Admin sees ALL challenges (private + public)
- Uses `adminView` prop in components
- Different routing for challenge details

### Viewing Challenge Details (Admin)

**User Flow:**
1. From admin user view, click a challenge
2. Navigate to `/admin/challenge/{challenge}`
3. See detailed challenge view:
   - Owner information
   - Full challenge data
   - All goals with completion stats
   - Activity history

**Authorization:**
- ChallengePolicy allows admins to view all challenges
- Override in `view()` method: `if ($user->is_admin) return true;`

### Deleting Users (Admin)

**User Flow:**
1. From admin user detail page
2. Click "Delete User"
3. Confirmation modal with warning
4. Confirm deletion
5. Cascade deletes all user data

**Backend:**
- Route: `DELETE /admin/user/{user}`
- Controller: `AdminController@deleteUser`
- Foreign key cascades handle:
  - All challenges
  - All goals
  - All habits
  - All activities
  - All follows

---

## Feature 6: Theme Management

### Dark Mode Support

**User Flow:**
1. Click theme toggle (sun/moon icon)
2. Theme switches instantly
3. Preference saved to database
4. Persists across sessions

**Technical Implementation:**
- Alpine.js component: `themeManager`
- Stores preference in `users.theme_preference`
- Applies `dark` class to `<html>` element
- Tailwind dark mode uses class strategy
- Server-side initial render based on saved preference

**Default Behavior:**
- New users: light mode
- Respects user's saved preference on login

---

## Common User Journeys

### Journey 1: New User Creates First Challenge
1. Register/Login
2. Redirected to feed (empty)
3. Click "Create Challenge" from navigation
4. Fill in 30-day challenge with 3 goals
5. Submit and view challenge
6. Click "Start Challenge"
7. Begin daily tracking

### Journey 2: Daily Routine Check-in
1. Login → redirected to feed
2. Click "Today" quick link
3. See today's goals from active challenges
4. Check off completed goals
5. See progress update
6. View habits to complete today
7. Mark habit complete with notes

### Journey 3: Social Engagement
1. Login → feed shows friend activity
2. See friend completed a challenge
3. Like the activity
4. Click through to friend's profile
5. View their public challenges
6. Get inspired, create similar challenge
7. Start own challenge

### Journey 4: Habit Building
1. Navigate to Goals Library
2. Create goal "Meditate for 10 minutes"
3. Create habit based on goal
4. Set frequency: Daily
5. Complete habit each day
6. Watch streak grow
7. Achieve 30-day streak milestone
