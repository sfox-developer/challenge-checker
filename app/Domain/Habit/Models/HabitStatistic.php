<?php

namespace App\Domain\Habit\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HabitStatistic extends Model
{
    use HasFactory;

    protected $fillable = [
        'habit_id',
        'current_streak',
        'best_streak',
        'total_completions',
        'last_completed_at',
        'streak_start_date',
    ];

    protected $casts = [
        'current_streak' => 'integer',
        'best_streak' => 'integer',
        'total_completions' => 'integer',
        'last_completed_at' => 'datetime',
        'streak_start_date' => 'date',
    ];

    /**
     * Get the habit these statistics belong to.
     */
    public function habit(): BelongsTo
    {
        return $this->belongsTo(Habit::class);
    }

    /**
     * Increment total completions.
     */
    public function incrementCompletions(): void
    {
        $this->increment('total_completions');
        $this->update(['last_completed_at' => now()]);
    }

    /**
     * Update streak data.
     */
    public function updateStreak(int $newStreak, ?\DateTime $streakStartDate = null): void
    {
        $this->current_streak = $newStreak;
        
        if ($newStreak > $this->best_streak) {
            $this->best_streak = $newStreak;
        }

        if ($streakStartDate) {
            $this->streak_start_date = $streakStartDate;
        }

        $this->save();
    }

    /**
     * Reset current streak to zero.
     */
    public function resetStreak(): void
    {
        $this->update([
            'current_streak' => 0,
            'streak_start_date' => null,
        ]);
    }

    /**
     * Check if there's an active streak.
     */
    public function hasActiveStreak(): bool
    {
        return $this->current_streak > 0;
    }

    /**
     * Get streak description.
     */
    public function getStreakDescription(): string
    {
        if ($this->current_streak === 0) {
            return 'No active streak';
        }

        $days = $this->current_streak;
        $unit = $days === 1 ? 'day' : 'days';

        return "{$days} {$unit}";
    }

    /**
     * Get completion rate as percentage (total vs expected based on habit age).
     */
    public function getCompletionRate(): float
    {
        $habit = $this->habit;
        
        if (!$habit) {
            return 0;
        }

        // Calculate expected completions based on habit creation date and frequency
        $createdAt = $habit->created_at;
        $daysSinceCreation = $createdAt->diffInDays(now());

        if ($daysSinceCreation === 0) {
            return 0;
        }

        // Calculate expected completions based on frequency
        $expectedCompletions = match($habit->frequency_type->value) {
            'daily' => $daysSinceCreation * $habit->frequency_count,
            'weekly' => ceil($daysSinceCreation / 7) * $habit->frequency_count,
            'monthly' => ceil($daysSinceCreation / 30) * $habit->frequency_count,
            'yearly' => ceil($daysSinceCreation / 365) * $habit->frequency_count,
            default => 1,
        };

        if ($expectedCompletions === 0) {
            return 0;
        }

        return min(100, ($this->total_completions / $expectedCompletions) * 100);
    }
}
