<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('goal_completions', function (Blueprint $table) {
            // Drop the old unique constraint that doesn't include source
            $table->dropUnique('unique_user_goal_date');
            
            // Add new unique constraint including source_type and source_id
            // This allows the same goal to be completed in different sources (challenge, habit, etc.)
            $table->unique(
                ['user_id', 'goal_id', 'date', 'source_type', 'source_id'],
                'unique_user_goal_date_source'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('goal_completions', function (Blueprint $table) {
            // Drop the source-specific unique constraint
            $table->dropUnique('unique_user_goal_date_source');
            
            // Restore the original unique constraint
            $table->unique(
                ['user_id', 'goal_id', 'date'],
                'unique_user_goal_date'
            );
        });
    }
};
