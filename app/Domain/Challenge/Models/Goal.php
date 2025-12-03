<?php

namespace App\Domain\Challenge\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Domain\Goal\Models\GoalLibrary;

class Goal extends Model
{
    use HasFactory;

    protected $fillable = [
        'challenge_id',
        'goal_library_id',
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
     * Get the library goal this is based on.
     */
    public function library(): BelongsTo
    {
        return $this->belongsTo(GoalLibrary::class, 'goal_library_id');
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

    /**
     * Get the current name from the library if available, otherwise use stored name.
     */
    public function getCurrentNameAttribute(): string
    {
        return $this->library?->name ?? $this->name;
    }

    /**
     * Get the current description from the library if available, otherwise use stored description.
     */
    public function getCurrentDescriptionAttribute(): ?string
    {
        return $this->library?->description ?? $this->description;
    }

    /**
     * Get the icon from the library.
     */
    public function getIconAttribute(): ?string
    {
        return $this->library?->icon;
    }
}
