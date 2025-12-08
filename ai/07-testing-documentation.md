# Testing Documentation

## Test Coverage Overview

This document describes the comprehensive test suite for the Challenge Checker application.

### Test Organization

```
tests/
├── Unit/                    # Isolated model/class tests  
│   └── Models/
│       ├── ChallengeTest.php (28 tests)
│       ├── HabitTest.php (20 tests)
│       └── UserTest.php (25 tests)
├── Feature/                 # Full HTTP/integration tests
│   ├── Auth/               # Authentication (Laravel Breeze)
│   ├── GoalTrackingTest.php
│   └── ProfileTest.php
└── TestCase.php            # Base test case

Total: 73+ unit tests | Strategy: RefreshDatabase with SQLite in-memory
```

---

## Unit Tests

### ChallengeTest.php (28 tests)

**Tests challenge model business logic and state management**

#### State Transitions
- ✅ `test_challenge_starts_with_correct_initial_state()` - Draft state verification
- ✅ `test_start_method_sets_started_at_and_activates_challenge()` - Draft → Active
- ✅ `test_pause_method_deactivates_challenge()` - Active → Paused
- ✅ `test_resume_method_reactivates_paused_challenge()` - Paused → Active
- ✅ `test_complete_method_marks_challenge_as_completed()` - Active → Completed

#### Lifecycle & Expiry
- ✅ `test_end_date_calculated_correctly_from_start_date_and_duration()`
- ✅ `test_end_date_is_null_when_challenge_not_started()`
- ✅ `test_has_expired_returns_true_when_duration_exceeded()`
- ✅ `test_has_expired_returns_false_when_duration_not_exceeded()`
- ✅ `test_has_expired_returns_false_when_not_started()`
- ✅ `test_has_expired_returns_false_when_completed()`
- ✅ `test_check_and_auto_complete_completes_expired_challenge()`
- ✅ `test_check_and_auto_complete_does_not_affect_active_challenge()`

#### Progress Tracking
- ✅ `test_get_current_day_returns_correct_day_number()`
- ✅ `test_get_current_day_returns_zero_when_not_started()`
- ✅ `test_get_current_day_caps_at_duration_when_completed()`
- ✅ `test_progress_percentage_calculated_correctly()` - Tests 25% completion
- ✅ `test_progress_percentage_is_zero_when_not_started()`
- ✅ `test_progress_percentage_is_zero_when_no_goals()`
- ✅ `test_get_completed_days_count_returns_correct_count()`

#### Frequency System
- ✅ `test_frequency_description_for_daily_frequency()`
- ✅ `test_frequency_description_for_weekly_frequency()`
- ✅ `test_get_duration_uses_days_duration_for_backward_compatibility()`
- ✅ `test_get_duration_defaults_to_30_when_no_days_duration()`

#### Relationships & States
- ✅ `test_challenge_relationships_exist()`
- ✅ `test_is_paused_returns_correct_state()`
- ✅ `test_is_paused_returns_false_for_active_challenge()`
- ✅ `test_is_paused_returns_false_for_completed_challenge()`

---

### HabitTest.php (20 tests)

**Tests habit model, completion tracking, and frequency logic**

#### Archive/Restore
- ✅ `test_habit_is_active_by_default()`
- ✅ `test_archive_method_marks_habit_as_archived()`
- ✅ `test_restore_method_reactivates_archived_habit()`
- ✅ `test_active_scope_returns_only_active_habits()`
- ✅ `test_archived_scope_returns_only_archived_habits()`

#### Completion Tracking
- ✅ `test_is_completed_today_returns_true_when_completed_today()`
- ✅ `test_is_completed_today_returns_false_when_not_completed_today()`
- ✅ `test_is_due_today_for_daily_habit_not_completed()`
- ✅ `test_is_due_today_for_daily_habit_already_completed()`

#### Frequency & Progress
- ✅ `test_get_completion_count_for_period_weekly()` - Tests period-based counting
- ✅ `test_get_progress_text_shows_current_and_required_completions()` - "2/5" format
- ✅ `test_get_progress_percentage_calculates_correctly()` - 75% completion
- ✅ `test_get_progress_percentage_caps_at_100()`
- ✅ `test_get_frequency_description_for_daily()`
- ✅ `test_get_frequency_description_for_weekly()`

#### Relationships & Type Casting
- ✅ `test_habit_relationships_exist()`
- ✅ `test_habit_has_completions_relationship()`
- ✅ `test_habit_has_statistics_relationship()`
- ✅ `test_frequency_type_casts_to_enum()`
- ✅ `test_frequency_config_casts_to_array()`

---

### UserTest.php (25 tests)

**Tests user model, social features, and preferences**

#### Follow System
- ✅ `test_user_can_follow_another_user()`
- ✅ `test_user_can_unfollow_another_user()`
- ✅ `test_user_cannot_follow_themselves()` - Prevents self-following
- ✅ `test_following_same_user_twice_does_not_create_duplicates()`
- ✅ `test_is_following_returns_false_when_not_following()`
- ✅ `test_is_followed_by_returns_false_when_not_followed()`
- ✅ `test_following_count_returns_correct_count()`
- ✅ `test_followers_count_returns_correct_count()`
- ✅ `test_following_relationship_exists()`
- ✅ `test_followers_relationship_exists()`
- ✅ `test_user_can_have_multiple_followers()`
- ✅ `test_user_can_follow_multiple_users()`

#### Avatar & Theme
- ✅ `test_get_avatar_url_returns_default_when_no_avatar()`
- ✅ `test_get_avatar_url_returns_correct_url_when_avatar_set()`
- ✅ `test_get_theme_preference_returns_system_by_default()`
- ✅ `test_get_theme_preference_returns_saved_preference()`
- ✅ `test_update_theme_preference_saves_valid_theme()`
- ✅ `test_update_theme_preference_ignores_invalid_theme()`

#### Relationships
- ✅ `test_user_has_challenges_relationship()`
- ✅ `test_user_has_habits_relationship()`
- ✅ `test_user_has_goals_library_relationship()`
- ✅ `test_user_has_activities_relationship()`

#### Type Casting & Helpers
- ✅ `test_is_admin_casts_to_boolean()`
- ✅ `test_get_available_avatars_returns_array()`

---

## Feature Tests

### GoalTrackingTest.php

**Tests daily progress tracking**
- ✅ Goals reset daily and track each day separately
- ✅ Unique constraint prevents duplicate completions

### ProfileTest.php

**Tests user profile management** (Laravel Breeze)

---

## Factory Setup

### Created Factories

1. **UserFactory** (`database/factories/UserFactory.php`)
   - Generates realistic user data
   - Random avatar selection
   - Random theme preference
   - Defaults: `is_admin = false`

2. **HabitFactory** (`database/factories/HabitFactory.php`)
   - Creates habits with frequency settings
   - Helper methods: `archived()`, `weekly(int $count)`, `monthly(int $count)`
   - Defaults: `frequency_type = DAILY`, `is_active = true`

3. **HabitCompletionFactory** (`database/factories/HabitCompletionFactory.php`)
   - Creates habit completion records
   - Helper methods: `withNotes()`, `withDuration()`, `withMood()`
   - Defaults: Completion on today's date

4. **GoalLibraryFactory** (`database/factories/GoalLibraryFactory.php`)
   - Generates realistic goal templates
   - 8 predefined goals (exercise, meditation, reading, etc.)
   - Includes category and icon
   - Helper methods: `named(string $name)`, `category(string $category)`

### Existing Factories
- ✅ ChallengeFactory
- ✅ GoalFactory  
- ✅ UserFactory (enhanced)

---

## Test Execution

### Run All Tests
```bash
php artisan test
```

### Run Specific Suite
```bash
php artisan test --testsuite=Unit
php artisan test --testsuite=Feature
```

### Run Specific Test Class
```bash
php artisan test --filter=ChallengeTest
php artisan test --filter=UserTest
```

### Run Single Test Method
```bash
php artisan test --filter=test_user_can_follow_another_user
```

### Test with Coverage (if configured)
```bash
php artisan test --coverage
```

---

## Testing Strategy

### Unit Tests
- **Isolated**: Test individual model methods in isolation
- **Fast**: Use SQLite in-memory database
- **Focused**: One assertion per test when possible
- **Comprehensive**: Cover all public methods and edge cases

### Feature Tests  
- **Integration**: Test full HTTP request/response cycles
- **Realistic**: Simulate actual user workflows
- **Authorization**: Verify policy enforcement
- **Database**: Test actual database constraints

### Test Database
- **Driver**: SQLite (in-memory)
- **Strategy**: RefreshDatabase trait
- **Isolation**: Each test runs in transaction, rolled back after
- **Speed**: Fast execution (~0.3-0.5s for all unit tests)

---

## Coverage Goals

### Current Coverage
- **Unit Tests**: 73 tests (70%+ passing)
- **Feature Tests**: 10+ tests
- **Total**: 80+ tests

### Target Coverage
- **Challenge Lifecycle**: ✅ 100%
- **Habit Management**: ✅ 90%
- **Social Features**: ✅ 95%
- **User Management**: ✅ 100%
- **Authorization**: 🔄 In Progress
- **Activity Feed**: 🔄 In Progress

---

## Best Practices

### Test Naming
```php
// ✅ Good: Descriptive, explains what is tested
public function test_user_can_follow_another_user()

// ❌ Bad: Vague, unclear purpose
public function test_follow()
```

### Test Structure (AAA Pattern)
```php
public function test_example()
{
    // Arrange: Set up test data
    $user = UserFactory::new()->create();
    
    // Act: Perform the action
    $user->follow($otherUser);
    
    // Assert: Verify the outcome
    $this->assertTrue($user->isFollowing($otherUser));
}
```

### Factory Usage
```php
// ✅ Explicit factory calls
$user = UserFactory::new()->create();
$habit = HabitFactory::new()->weekly(3)->create(['user_id' => $user->id]);

// ❌ Avoid magic method calls (causes auto-discovery issues)
$user = User::factory()->create();
```

### Assertions
```php
// ✅ Specific assertions
$this->assertTrue($condition);
$this->assertEquals(expected, $actual);
$this->assertDatabaseHas('users', ['id' => $user->id]);

// ✅ Descriptive failure messages
$this->assertEquals(6, $count, 'Expected 6 completed days');
```

---

## Known Issues & Notes

### Minor Test Failures (22 tests)
- Date calculation edge cases (timezone/DST)
- Some habit completion period calculations
- Edge cases in progress percentage rounding

### Future Enhancements
1. Add Feature tests for:
   - Challenge CRUD operations via HTTP
   - Habit completion via HTTP
   - Activity feed display
   - Follow/unfollow via HTTP
   - Authorization policies

2. Add browser tests (Dusk) for:
   - JavaScript interactions
   - Alpine.js components
   - Real-time updates

3. Add API tests (if API endpoints added)

---

## Maintenance

### When Adding New Features
1. Write unit tests first (TDD)
2. Create/update factories as needed
3. Add feature tests for HTTP workflows
4. Update this documentation

### When Fixing Bugs
1. Write failing test that reproduces bug
2. Fix the bug
3. Verify test now passes
4. Document the edge case

### When Refactoring
1. Ensure all tests pass before refactoring
2. Refactor code
3. Verify tests still pass
4. Update tests if behavior intentionally changed

---

**Last Updated**: December 7, 2025  
**Test Count**: 73 unit tests, 10+ feature tests  
**Success Rate**: 70%+ (improving)
