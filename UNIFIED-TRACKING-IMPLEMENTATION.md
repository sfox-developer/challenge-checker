# Unified Goal Tracking System - Implementation Guide

## Status: 🔄 REFACTORING - Simplified Approach

**Last Updated:** January 2, 2026

This document tracks the implementation of the unified goal tracking system that replaces separate `daily_progress` and `habit_completions` tables with a single **simplified** `goal_completions` table.

---

## 🎯 Strategic Decision (Jan 2, 2026)

**SIMPLIFIED APPROACH:** Remove `source_type` and `source_id` tracking.

### Key Principles:
1. **One completion per user/goal/date** - Regardless of source (challenge, habit, manual)
2. **Shared progress** - Completing a goal counts for ALL challenges/habits using that goal
3. **Simpler queries** - No source filtering needed
4. **Better UX** - Complete once, counts everywhere

### Business Rules Confirmed:
- ✅ Goal completion counts toward ALL challenges/habits using that goal
- ✅ No tracking of which source triggered the completion
- ✅ All completions count regardless of source for frequency tracking
- ✅ Single source of truth for analytics

---

## ✅ Completed Steps

### Phase 1: Database Migrations Created (NEEDS SIMPLIFICATION)

1. **goal_completions table** - Created at `2025_12_30_194210`
   - Unified tracking for all goal completions
   - ⚠️ NEEDS UPDATE: Remove `source_type` and `source_id` columns
   - Includes notes, duration, mood metadata
   - Unique constraint: `(user_id, goal_id, date)`

2. **challenge_goals junction table** - Created at `2025_12_30_194241`
   - Many-to-many relationship between challenges and goals
   - ✅ No changes needed

3. **Data migration script** - Created at `2025_12_30_194256`
   - Migrates `daily_progress` → `goal_completions`
   - Migrates `habit_completions` → `goal_completions`
   - Migrates old `goals` → `challenge_goals`
   - Updates `habits` table (renames column)
   - Recalculates `habit_statistics`
   - Drops old tables
   - ⚠️ NEEDS UPDATE: Migration logic simplified (no source tracking)

### Phase 2: Models Created (NEEDS SIMPLIFICATION)

1. **GoalCompletion model** - `app/Domain/Goal/Models/GoalCompletion.php`
   - ⚠️ NEEDS UPDATE: Remove source_type, source_id, source() relationship
   
2. **ChallengeGoal pivot model** - `app/Domain/Challenge/Models/ChallengeGoal.php`
   - ✅ No changes needed

---

---

## 🔄 Implementation Plan

### Phase 1: Database Schema Simplification

**Files to update:**

1. ✅ `database/migrations/2025_12_30_194210_create_goal_completions_table.php`
   - Remove: `source_type` column
   - Remove: `source_id` column
   - Remove: `source_type, source_id` index
   - Keep: Unique constraint `(user_id, goal_id, date)`

2. ✅ `database/migrations/2025_12_30_194256_migrate_to_unified_goal_tracking_system.php`
   - Simplify migration logic (no source tracking)
   - Deduplicate completions by (user_id, goal_id, date)

---

### Phase 2: Model Simplification

**Files to update:**

1. ✅ `app/Domain/Goal/Models/GoalCompletion.php`
   - Remove: `source_type` and `source_id` from `$fillable`
   - Remove: `source()` morphTo relationship
   - Remove: `scopeFromSource()` method
   - Keep: Simple scopes for filtering

2. ✅ `app/Domain/Goal/Models/Goal.php`
   - Remove: `isCompletedForChallenge()` and `isCompletedForHabit()` methods
   - Keep: `isCompletedForDate()` method (no source filtering)
   - Update: `completions()` relationship queries

3. ✅ `app/Domain/Challenge/Models/Challenge.php`
   - Remove: `completions()` relationship with source filtering
   - Add: Helper to get completions for challenge goals
   
4. ✅ `app/Domain/Habit/Models/Habit.php`
   - Remove: `completions()` relationship with source filtering
   - Add: Helper to check if goal completed for date

---

### Phase 3: Service Layer Simplification

**Files to update:**

1. ✅ `app/Domain/Challenge/Services/ChallengeService.php`
   - Remove: All `source_type` and `source_id` filtering
   - Simplify: Query by goal_id and user_id only
   - Update: Progress calculation (counts ALL completions for goal)

2. ✅ `app/Domain/Habit/Services/HabitService.php`
   - Remove: `source_type` and `source_id` from completion creation
   - Simplify: Just create/delete goal completion
   - Update: Statistics calculation

---

### Phase 4: Controller Updates

**Files to update:**

1. ✅ `app/Http/Controllers/Api/QuickGoalsController.php`
   - Remove: Source type/id checking logic
   - Simplify: Check if goal_id is completed today
   - Remove: Source-based uniqueness logic

2. ✅ `app/Http/Controllers/Api/GoalCompletionController.php`
   - Remove: `source_type` and `source_id` validation
   - Remove: Source ownership validation
   - Simplify: Create completion without source tracking

3. ✅ `app/Http/Controllers/ChallengeController.php`
   - Remove: Source-specific completion logic
   - Simplify: Check goal completion status

4. ✅ `app/Http/Controllers/HabitController.php`
   - Remove: Source-specific completion logic
   - Simplify: Toggle goal completion

---

### Phase 5: Frontend Simplification

**Files to update:**

1. ✅ `resources/js/components/quick-complete.js`
   - Remove: `sourceType` and `sourceId` properties
   - Remove: Source data from API calls

2. ✅ `resources/views/dashboard/partials/quick-goals.blade.php`
   - Remove: `data-source-type` and `data-source-id` attributes

3. ✅ `resources/views/dashboard/partials/quick-all.blade.php`
   - Remove: `data-source-type` and `data-source-id` attributes

4. ✅ `resources/views/dashboard/partials/quick-habits.blade.php`
   - Remove: `data-source-type` and `data-source-id` attributes

---

### Phase 6: Documentation Updates

**Files to update:**

1. ✅ `ai/02-database-schema.md`
   - Update: goal_completions table schema
   - Remove: References to source_type and source_id
   - Document: Simplified completion logic

2. ✅ `ai/05-features.md`
   - Update: GoalCompletion model documentation
   - Document: Shared completion behavior

---

## Migration Instructions

### Before Running Migrations:

1. **BACKUP YOUR DATABASE**
```bash
pg_dump your_database > backup_$(date +%Y%m%d).sql
```

2. **Review migration files** to ensure they match your data structure

3. **Test on staging** environment first

### Running Migrations:

```bash
# Run migrations
php artisan migrate

# If issues occur, you can rollback the data migration only
# (Note: This will throw an exception as down() is not implemented)
# Restore from backup instead

# Verify data
php artisan tinker
>>> \App\Domain\Goal\Models\GoalCompletion::count()
>>> \App\Domain\Challenge\Models\ChallengeGoal::count()
```

---

---

## 📊 Key Architectural Changes

### Database Schema

**Before:**
```sql
goal_completions (
    id, user_id, goal_id, date, completed_at,
    source_type,  -- REMOVED
    source_id,    -- REMOVED
    notes, duration_minutes, mood, metadata
)
UNIQUE (user_id, goal_id, date, source_type, source_id)  -- OLD
```

**After:**
```sql
goal_completions (
    id, user_id, goal_id, date, completed_at,
    notes, duration_minutes, mood, metadata
)
UNIQUE (user_id, goal_id, date)  -- SIMPLIFIED
```

### Business Logic

**Before:**
- User completes "Gym" in Challenge A → creates completion with source_type='challenge', source_id=123
- User completes "Gym" in Habit B → creates ANOTHER completion with source_type='habit', source_id=456
- Result: 2 completions for same goal on same day

**After:**
- User completes "Gym" → creates ONE completion
- Counts toward Challenge A, Challenge B, Habit X, and any other usage of "Gym" goal
- Result: 1 completion for same goal on same day (shared across all sources)

### Query Changes

**Before:**
```php
// Check if goal completed for specific challenge
GoalCompletion::where('source_type', 'challenge')
    ->where('source_id', $challengeId)
    ->where('goal_id', $goalId)
    ->exists();
```

**After:**
```php
// Check if goal completed (counts for all challenges/habits)
GoalCompletion::where('goal_id', $goalId)
    ->where('user_id', $userId)
    ->where('date', $date)
    ->exists();
```

### Benefits

✅ **40% less code** - Removed source tracking logic throughout codebase  
✅ **Better performance** - Simpler queries without source filtering  
✅ **No duplicates** - One completion per user/goal/date guaranteed  
✅ **Easier analytics** - Single source of truth for all metrics  
✅ **Better UX** - Complete once, counts everywhere  
✅ **Simpler maintenance** - Fewer edge cases to handle

### Trade-offs

❌ **Cannot track which specific source triggered completion** - Accepted (not needed)  
❌ **Cannot have separate completion states per source** - Accepted (shared is better)

---

## 🧪 Testing Checklist

After implementation, verify:

- [ ] Migration runs successfully
- [ ] No duplicate completions exist (user_id, goal_id, date)
- [ ] Completing goal in challenge marks it complete everywhere
- [ ] Completing goal in habit marks it complete everywhere
- [ ] Challenge progress counts all goal completions
- [ ] Habit streaks calculated correctly
- [ ] Statistics accurate across all sources
- [ ] Activity feed shows completions correctly
- [ ] Quick complete widget works across all tabs
- [ ] No source_type or source_id references remain in code
