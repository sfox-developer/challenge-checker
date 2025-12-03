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
        Schema::create('habit_statistics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('habit_id')->unique()->constrained()->onDelete('cascade');
            $table->integer('current_streak')->default(0);
            $table->integer('best_streak')->default(0);
            $table->integer('total_completions')->default(0);
            $table->timestamp('last_completed_at')->nullable();
            $table->date('streak_start_date')->nullable();
            $table->timestamps();
            
            $table->index('current_streak');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('habit_statistics');
    }
};
