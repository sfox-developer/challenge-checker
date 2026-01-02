<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * This creates a unified goal completion tracking table that replaces
     * both daily_progress and habit_completions tables.
     */
    public function up(): void
    {
        Schema::create('goal_completions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('goal_id')->constrained('goals')->cascadeOnDelete();
            $table->date('date'); // Completion date
            $table->timestamp('completed_at'); // Exact timestamp
            
            // Additional metadata
            $table->text('notes')->nullable();
            $table->integer('duration_minutes')->nullable();
            $table->string('mood')->nullable();
            $table->json('metadata')->nullable();
            
            $table->timestamps();
            
            // One completion per user per goal per date (regardless of source)
            $table->unique(['user_id', 'goal_id', 'date'], 'unique_user_goal_date');
            
            // Indexes for common queries
            $table->index(['user_id', 'date']);
            $table->index(['goal_id', 'date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('goal_completions');
    }
};
