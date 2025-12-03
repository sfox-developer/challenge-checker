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
        Schema::create('habit_completions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('habit_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->date('date'); // For grouping and filtering
            $table->timestamp('completed_at');
            $table->text('notes')->nullable();
            $table->integer('duration_minutes')->nullable();
            $table->string('mood')->nullable(); // happy, neutral, tired, etc.
            $table->json('metadata')->nullable(); // Flexible for future features
            $table->timestamps();
            
            // Prevent duplicate completions per day for same habit
            $table->unique(['habit_id', 'user_id', 'date']);
            $table->index(['habit_id', 'date']);
            $table->index(['user_id', 'date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('habit_completions');
    }
};
