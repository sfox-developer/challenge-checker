<?php

namespace App\Domain\Challenge\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Goal extends Model
{
    use HasFactory;

    protected $fillable = [
        'challenge_id',
        'name',
        'description',
        'order',
    ];

    /**
     * Get the challenge that owns the goal.
     */
    public function challenge(): BelongsTo
    {
        return $this->belongsTo(Challenge::class);
    }

    /**
     * Get the daily progress entries for the goal.
     */
    public function dailyProgress(): HasMany
    {
        return $this->hasMany(DailyProgress::class);
    }

    /**
     * Check if the goal is completed for a specific date.
     */
    public function isCompletedForDate(string $date, int $userId): bool
    {
        return $this->dailyProgress()
            ->where('user_id', $userId)
            ->where('date', $date)
            ->whereNotNull('completed_at')
            ->exists();
    }

    /**
     * Mark the goal as completed for today.
     */
    public function markCompletedForToday(int $userId): DailyProgress
    {
        return $this->dailyProgress()->updateOrCreate([
            'user_id' => $userId,
            'challenge_id' => $this->challenge_id,
            'goal_id' => $this->id,
            'date' => now()->toDateString(),
        ], [
            'completed_at' => now(),
        ]);
    }
}
