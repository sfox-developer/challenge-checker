<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * This migration:
     * 1. Migrates daily_progress -> goal_completions
     * 2. Migrates habit_completions -> goal_completions
     * 3. Migrates old goals table -> challenge_goals junction
     * 4. Updates habit references
     * 5. Recalculates habit statistics
     * 6. Drops old tables
     */
    public function up(): void
    {
        // Step 1: Migrate daily_progress to goal_completions (if table exists)
        if (Schema::hasTable('daily_progress')) {
            DB::statement("
                INSERT IGNORE INTO goal_completions (user_id, goal_id, date, completed_at, source_type, source_id, created_at, updated_at)
                SELECT 
                    dp.user_id,
                    g.goal_library_id,
                    dp.date,
                    COALESCE(dp.completed_at, dp.created_at),
                    'challenge',
                    dp.challenge_id,
                    dp.created_at,
                    dp.updated_at
                FROM daily_progress dp
                INNER JOIN goals g ON dp.goal_id = g.id
                WHERE g.goal_library_id IS NOT NULL
            ");
        }

        // Step 2: Migrate habit_completions to goal_completions (if table exists)
        if (Schema::hasTable('habit_completions')) {
            DB::statement("
                INSERT IGNORE INTO goal_completions (user_id, goal_id, date, completed_at, source_type, source_id, notes, duration_minutes, mood, created_at, updated_at)
                SELECT 
                    hc.user_id,
                    h.goal_id,
                    hc.date,
                    hc.completed_at,
                    'habit',
                    hc.habit_id,
                    hc.notes,
                    hc.duration_minutes,
                    hc.mood,
                    hc.created_at,
                    hc.updated_at
                FROM habit_completions hc
                INNER JOIN habits h ON hc.habit_id = h.id
                WHERE h.goal_id IS NOT NULL
            ");
        }

        // Step 3: Migrate old goals table to challenge_goals junction
        if (Schema::hasTable('goals') && Schema::hasColumn('goals', 'goal_library_id')) {
            DB::statement("
                INSERT IGNORE INTO challenge_goals (challenge_id, goal_id, `order`, created_at, updated_at)
                SELECT 
                    g.challenge_id,
                    g.goal_library_id,
                    g.`order`,
                    g.created_at,
                    g.updated_at
                FROM goals g
                WHERE g.goal_library_id IS NOT NULL
            ");
        }

        // Step 4: [SKIPPED - habits.goal_id already exists, no rename needed]

        // Step 5: [SKIPPED - habit_statistics.goal_id already exists]

        // Populate goal_id in habit_statistics (update from habits)
        DB::statement("
            UPDATE habit_statistics hs
            INNER JOIN habits h ON hs.habit_id = h.id
            SET hs.goal_id = h.goal_id
        ");

        // Step 6: Recalculate habit statistics based on unified goal_completions
        DB::statement("
            UPDATE habit_statistics hs
            SET 
                total_completions = (
                    SELECT COUNT(*)
                    FROM goal_completions gc
                    WHERE gc.goal_id = hs.goal_id
                    AND gc.user_id = (SELECT user_id FROM habits WHERE id = hs.habit_id)
                ),
                last_completed_at = (
                    SELECT MAX(completed_at)
                    FROM goal_completions gc
                    WHERE gc.goal_id = hs.goal_id
                    AND gc.user_id = (SELECT user_id FROM habits WHERE id = hs.habit_id)
                )
        ");

        // Calculate streaks (simplified - just reset them, let application recalculate on next access)
        DB::statement("
            UPDATE habit_statistics
            SET current_streak = 0, streak_start_date = NULL
        ");

        // Step 7: Update activities to reference goal_id from goals_library
        if (Schema::hasTable('activities') && Schema::hasColumn('activities', 'goal_id')) {
            // Add temporary column
            if (!Schema::hasColumn('activities', 'goal_library_id')) {
                Schema::table('activities', function (Blueprint $table) {
                    $table->foreignId('goal_library_id')->after('goal_id')->nullable()->constrained('goals_library')->cascadeOnDelete();
                });
            }

            // Populate goal_library_id in activities (if goals table still exists)
            if (Schema::hasTable('goals') && Schema::hasColumn('goals', 'goal_library_id')) {
                DB::statement("
                    UPDATE activities a
                    INNER JOIN goals g ON a.goal_id = g.id
                    SET a.goal_library_id = g.goal_library_id
                    WHERE g.goal_library_id IS NOT NULL
                ");
            }

            // Step 8: Update activities foreign key (must be done before dropping goals table)
            Schema::table('activities', function (Blueprint $table) {
                $table->dropForeign(['goal_id']);
                $table->dropColumn('goal_id');
                $table->renameColumn('goal_library_id', 'goal_id');
            });
        }

        // Step 9: Drop old tables (after foreign keys are cleaned up)
        Schema::dropIfExists('daily_progress');
        Schema::dropIfExists('habit_completions');
        Schema::dropIfExists('goals');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // This migration is not easily reversible due to data consolidation
        // Would require recreating old tables and splitting unified data
        throw new \Exception('This migration cannot be reversed. Please restore from backup if needed.');
    }
};
