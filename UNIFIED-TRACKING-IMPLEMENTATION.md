# Unified Goal Tracking System - Implementation Guide

## Status: ⚠️ IN PROGRESS

This document tracks the implementation of the unified goal tracking system that replaces separate `daily_progress` and `habit_completions` tables with a single `goal_completions` table.

---

## ✅ Completed Steps

### Phase 1: Database Migrations Created

1. **goal_completions table** - Created at `2025_12_30_194210`
   - Unified tracking for all goal completions
   - Supports challenge, habit, and manual tracking
   - Includes notes, duration, mood metadata

2. **challenge_goals junction table** - Created at `2025_12_30_194241`
   - Many-to-many relationship between challenges and goals
   - Replaces old `goals` table

3. **Data migration script** - Created at `2025_12_30_194256`
   - Migrates `daily_progress` → `goal_completions`
   - Migrates `habit_completions` → `goal_completions`
   - Migrates old `goals` → `challenge_goals`
   - Updates `habits` table (renames column)
   - Recalculates `habit_statistics`
   - Drops old tables

### Phase 2: Models Created

1. **GoalCompletion model** - `app/Domain/Goal/Models/GoalCompletion.php`
2. **ChallengeGoal pivot model** - `app/Domain/Challenge/Models/ChallengeGoal.php`

---

## 🔄 Remaining Work

### Phase 3: Update Existing Models

**Files to modify:**

1. `app/Domain/Challenge/Models/Challenge.php`
   - Replace `goals()` HasMany with BelongsToMany
   - Replace `dailyProgress()` with `completions()` through goal_completions
   - Update all methods that reference old structure

2. `app/Domain/Challenge/Models/Goal.php`
   - **DELETE THIS FILE** (replaced by challenge_goals pivot)

3. `app/Domain/Challenge/Models/DailyProgress.php`
   - **DELETE THIS FILE** (replaced by GoalCompletion)

4. `app/Domain/Habit/Models/Habit.php`
   - Update `goalLibrary()` relationship name to `goal()`
   - Update `completions()` to use GoalCompletion
   - Update streak calculation methods

5. `app/Domain/Habit/Models/HabitCompletion.php`
   - **DELETE THIS FILE** (replaced by GoalCompletion)

6. `app/Domain/Habit/Models/HabitStatistic.php`
   - Add `goal()` relationship
   - Update recalculation methods to use goal_completions

7. `app/Domain/Goal/Models/GoalLibrary.php`
   - Add `completions()` relationship
   - Add `challenges()` relationship through challenge_goals
   - Add helper methods for stats

8. `app/Domain/Activity/Models/Activity.php`
   - Update `goal()` relationship to reference goals
   - Remove old goal_id reference

9. `app/Domain/User/Models/User.php`
   - Add `goalCompletions()` relationship
   - Update stats methods

### Phase 4: Update Controllers

**Files to modify:**

1. `app/Http/Controllers/ChallengeController.php`
   - Update create/update to handle challenge_goals pivot
   - Update tracking logic to use goal_completions

2. `app/Http/Controllers/HabitController.php`
   - Update completion tracking to use goal_completions
   - Update streak calculations

3. `app/Http/Controllers/DashboardController.php`
   - Update queries to use new structure

4. `app/Http/Controllers/ActivityController.php`
   - Update activity creation logic

### Phase 5: Update Views & Components

**Files to check:**

1. Challenge tracking views
2. Habit tracking views
3. Dashboard widgets
4. Activity feed components
5. Statistics displays

### Phase 6: Update Factories & Seeders

1. `database/factories/ChallengeFactory.php`
2. `database/factories/HabitFactory.php`
3. `database/factories/HabitCompletionFactory.php` - DELETE
4. `database/seeders/*` - Update any seeders

### Phase 7: Testing & Verification

1. Run migrations on test database
2. Verify data integrity
3. Test challenge tracking
4. Test habit tracking
5. Test streak calculations
6. Test activity feed
7. Test statistics

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

## Key Architectural Changes

### Before:
- Challenges have `goals` (separate table)
- Challenges have `daily_progress` (completion tracking)
- Habits have `habit_completions` (completion tracking)
- Progress is separate between challenges and habits

### After:
- Challenges have `goals` through `challenge_goals` (junction table)
- ALL completions tracked in `goal_completions`
- Habits track completions in `goal_completions`
- Shared progress across challenges and habits for the same goal

### Benefits:
- ✅ Unified tracking reduces duplicate effort
- ✅ Shared progress across features
- ✅ Simplified queries
- ✅ Single source of truth
- ✅ Better statistics and streaks

---

## Next Steps

1. ✅ Create migrations [DONE]
2. ✅ Create new models [DONE]
3. ⏳ Update existing models [IN PROGRESS]
4. ⏳ Update controllers
5. ⏳ Update views
6. ⏳ Test thoroughly
7. ⏳ Update documentation

**Current Status:** Models created, need to update existing model relationships and methods.

**Blocker:** Large number of files to update. Recommend completing in smaller batches to avoid token limits.
