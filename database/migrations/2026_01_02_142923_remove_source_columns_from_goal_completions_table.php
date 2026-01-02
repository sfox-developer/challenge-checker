<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First, remove duplicates - keep only the first completion for each user/goal/date
        DB::statement("
            DELETE gc1 FROM goal_completions gc1
            INNER JOIN goal_completions gc2 
            WHERE gc1.id > gc2.id 
            AND gc1.user_id = gc2.user_id 
            AND gc1.goal_id = gc2.goal_id 
            AND gc1.date = gc2.date
        ");
        
        Schema::table('goal_completions', function (Blueprint $table) {
            // Drop the columns
            $table->dropColumn(['source_type', 'source_id']);
            
            // Add unique constraint on user_id, goal_id, date
            $table->unique(['user_id', 'goal_id', 'date'], 'unique_user_goal_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('goal_completions', function (Blueprint $table) {
            // Remove the unique constraint
            $table->dropUnique('unique_user_goal_date');
            
            // Re-add the columns
            $table->enum('source_type', ['challenge', 'habit', 'manual'])->default('manual')->after('completed_at');
            $table->unsignedBigInteger('source_id')->nullable()->after('source_type');
        });
    }
};
