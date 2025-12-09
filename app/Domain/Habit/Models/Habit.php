<?php

namespace App\Domain\Habit\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Domain\User\Models\User;
use App\Domain\Goal\Models\GoalLibrary;
use App\Domain\Habit\Enums\FrequencyType;
use App\Domain\Activity\Models\Activity;

class Habit extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'goal_library_id',
        'frequency_type',
        'frequency_count',
        'frequency_config',
        'is_active',
        'is_public',
        'archived_at',
    ];

    protected $casts = [
        'frequency_type' => FrequencyType::class,
        'frequency_count' => 'integer',
        'frequency_config' => 'array',
        'is_active' => 'boolean',
        'is_public' => 'boolean',
        'archived_at' => 'datetime',
    ];

    /**
     * Get the user that owns the habit.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the goal library entry this habit is based on.
     */
    public function goal(): BelongsTo
    {
        return $this->belongsTo(GoalLibrary::class, 'goal_library_id');
    }

    /**
     * Get all completions for this habit.
     */
    public function completions(): HasMany
    {
        return $this->hasMany(HabitCompletion::class);
    }

    /**
     * Get the statistics for this habit.
     */
    public function statistics(): HasOne
    {
        return $this->hasOne(HabitStatistic::class);
    }

    /**
     * Get the activities for this habit.
     */
    public function activities(): HasMany
    {
        return $this->hasMany(Activity::class);
    }

    /**
     * Scope to get only active (non-archived) habits.
     */
    public function scopeActive($query)
    {
        return $query->whereNull('archived_at')->where('is_active', true);
    }

    /**
     * Scope to get archived habits.
     */
    public function scopeArchived($query)
    {
        return $query->whereNotNull('archived_at');
    }

    /**
     * Check if habit is archived.
     */
    public function isArchived(): bool
    {
        return !is_null($this->archived_at);
    }

    /**
     * Archive this habit.
     */
    public function archive(): void
    {
        $this->update([
            'archived_at' => now(),
            'is_active' => false,
        ]);
    }

    /**
     * Restore an archived habit.
     */
    public function restore(): void
    {
        $this->update([
            'archived_at' => null,
            'is_active' => true,
        ]);
    }

    /**
     * Get completion count for current period.
     */
    public function getCompletionCountForPeriod(\DateTime $date = null): int
    {
        $date = $date ?? new \DateTime();
        $start = $this->frequency_type->periodStart($date);
        $end = $this->frequency_type->periodEnd($date);

        return $this->completions()
            ->whereBetween('date', [
                $start->format('Y-m-d'),
                $end->format('Y-m-d')
            ])
            ->count();
    }

    /**
     * Check if habit is completed for today.
     */
    public function isCompletedToday(): bool
    {
        return $this->completions()
            ->where('date', now()->toDateString())
            ->exists();
    }

    /**
     * Check if habit is due today based on frequency.
     */
    public function isDueToday(): bool
    {
        // For daily habits, always due
        if ($this->frequency_type === FrequencyType::DAILY) {
            return !$this->isCompletedToday();
        }

        // For other frequencies, it's due if not yet completed the required amount this period
        $completedThisPeriod = $this->getCompletionCountForPeriod();
        return $completedThisPeriod < $this->frequency_count;
    }

    /**
     * Get progress for current period (e.g., "2/3" for weekly).
     */
    public function getProgressText(): string
    {
        $completed = $this->getCompletionCountForPeriod();
        $required = $this->frequency_count;

        return "{$completed}/{$required}";
    }

    /**
     * Get progress percentage for current period.
     */
    public function getProgressPercentage(): int
    {
        $completed = $this->getCompletionCountForPeriod();
        $required = $this->frequency_count;

        if ($required === 0) {
            return 0;
        }

        return min(100, (int) round(($completed / $required) * 100));
    }

    /**
     * Get human-readable frequency description.
     */
    public function getFrequencyDescription(): string
    {
        return $this->frequency_type->description($this->frequency_count);
    }

    /**
     * Get the goal name from the library.
     */
    public function getGoalNameAttribute(): string
    {
        return $this->goal->name ?? 'Unknown Goal';
    }
}
