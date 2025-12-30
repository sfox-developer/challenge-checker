<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Junction table for many-to-many relationship between challenges and goals.
     * Replaces the old 'goals' table which mixed challenge instances with library references.
     */
    public function up(): void
    {
        Schema::create('challenge_goals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('challenge_id')->constrained()->cascadeOnDelete();
            $table->foreignId('goal_id')->constrained('goals_library')->cascadeOnDelete();
            $table->integer('order')->default(0); // Display order within challenge
            $table->timestamps();
            
            // One goal per challenge (prevent duplicates)
            $table->unique(['challenge_id', 'goal_id']);
            
            // Index for queries
            $table->index('challenge_id');
            $table->index('goal_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('challenge_goals');
    }
};
