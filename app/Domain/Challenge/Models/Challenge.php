<?php

namespace App\Domain\Challenge\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Domain\User\Models\User;
use App\Domain\Activity\Models\Activity;

class Challenge extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'days_duration',
        'started_at',
        'completed_at',
        'is_active',
        'is_public',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
        'is_active' => 'boolean',
        'is_public' => 'boolean',
    ];

    protected $appends = [
        'end_date',
    ];

    /**
     * Get the user that owns the challenge.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the goals for the challenge.
     */
    public function goals(): HasMany
    {
        return $this->hasMany(Goal::class);
    }

    /**
     * Get the daily progress entries for the challenge.
     */
    public function dailyProgress(): HasMany
    {
        return $this->hasMany(DailyProgress::class);
    }

    /**
     * Get the activities for the challenge.
     */
    public function activities(): HasMany
    {
        return $this->hasMany(Activity::class);
    }

    /**
     * Check if the challenge is active.
     */
    public function isActive(): bool
    {
        return $this->is_active && $this->started_at && !$this->completed_at;
    }

    /**
     * Start the challenge.
     */
    public function start(): void
    {
        $this->update([
            'started_at' => now(),
            'is_active' => true,
        ]);
    }

    /**
     * Pause the challenge.
     */
    public function pause(): void
    {
        $this->update([
            'is_active' => false,
        ]);
    }

    /**
     * Resume the challenge.
     */
    public function resume(): void
    {
        $this->update([
            'is_active' => true,
        ]);
    }

    /**
     * Complete the challenge.
     */
    public function complete(): void
    {
        $this->update([
            'completed_at' => now(),
            'is_active' => false,
        ]);
    }

    /**
     * Check if the challenge is paused (started but not active).
     */
    public function isPaused(): bool
    {
        return $this->started_at && !$this->is_active && !$this->completed_at;
    }

    /**
     * Check if the challenge is not started yet.
     */
    public function isNotStarted(): bool
    {
        return !$this->started_at;
    }

    /**
     * Check if the challenge is completed.
     */
    public function isCompleted(): bool
    {
        return $this->completed_at !== null;
    }

    /**
     * Check if the challenge duration has expired.
     */
    public function hasExpired(): bool
    {
        if (!$this->started_at || $this->completed_at) {
            return false;
        }

        $endDate = $this->started_at->copy()->addDays($this->days_duration);
        return now()->greaterThan($endDate);
    }

    /**
     * Get the calculated end date of the challenge.
     */
    public function getEndDateAttribute()
    {
        if (!$this->started_at) {
            return null;
        }

        return $this->started_at->copy()->addDays($this->days_duration);
    }

    /**
     * Auto-complete the challenge if duration has expired.
     */
    public function checkAndAutoComplete(): bool
    {
        if ($this->hasExpired() && !$this->completed_at) {
            $this->complete();
            return true;
        }

        return false;
    }

    /**
     * Get a human-readable status.
     */
    public function getStatusAttribute(): string
    {
        if ($this->isCompleted()) {
            return 'completed';
        }
        
        if ($this->isPaused()) {
            return 'paused';
        }
        
        if ($this->isActive()) {
            return 'active';
        }
        
        return 'draft';
    }

    /**
     * Get the progress percentage for the challenge.
     */
    public function getProgressPercentage(): float
    {
        if (!$this->started_at || $this->goals->isEmpty()) {
            return 0;
        }

        $totalGoalDays = $this->goals->count() * $this->days_duration;
        $completedGoalDays = $this->dailyProgress()->whereNotNull('completed_at')->count();

        return $totalGoalDays > 0 ? ($completedGoalDays / $totalGoalDays) * 100 : 0;
    }

    /**
     * Get the current day number of the challenge.
     */
    public function getCurrentDay(): int
    {
        if (!$this->started_at) {
            return 0;
        }

        if ($this->completed_at) {
            return $this->days_duration;
        }

        $currentDay = now()->diffInDays($this->started_at) + 1;
        
        return min($currentDay, $this->days_duration);
    }

    /**
     * Get the count of completed days (days where all goals were completed).
     */
    public function getCompletedDaysCount(): int
    {
        if (!$this->started_at) {
            return 0;
        }

        // Get all unique dates where progress was recorded
        $dates = $this->dailyProgress()
            ->whereNotNull('completed_at')
            ->select('date')
            ->distinct()
            ->pluck('date');

        $goalsCount = $this->goals->count();
        $completedDays = 0;

        // For each date, check if all goals were completed
        foreach ($dates as $date) {
            $completedGoalsOnDate = $this->dailyProgress()
                ->where('date', $date)
                ->whereNotNull('completed_at')
                ->count();

            if ($completedGoalsOnDate === $goalsCount) {
                $completedDays++;
            }
        }

        return $completedDays;
    }
}
