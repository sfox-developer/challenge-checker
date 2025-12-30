<?php

namespace App\Domain\Goal\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Domain\User\Models\User;
use App\Domain\Challenge\Models\Challenge;
use App\Domain\Habit\Models\Habit;

class GoalCompletion extends Model
{
    protected $fillable = [
        'user_id',
        'goal_id',
        'date',
        'completed_at',
        'source_type',
        'source_id',
        'notes',
        'duration_minutes',
        'mood',
        'metadata',
    ];

    protected $casts = [
        'date' => 'date',
        'completed_at' => 'datetime',
        'metadata' => 'array',
    ];

    /**
     * Get the user who completed the goal
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the goal that was completed
     */
    public function goal(): BelongsTo
    {
        return $this->belongsTo(GoalLibrary::class, 'goal_id');
    }

    /**
     * Get the source (challenge or habit) that triggered this completion
     */
    public function source()
    {
        if ($this->source_type === 'challenge') {
            return $this->belongsTo(Challenge::class, 'source_id');
        }
        
        if ($this->source_type === 'habit') {
            return $this->belongsTo(Habit::class, 'source_id');
        }
        
        return null;
    }

    /**
     * Scope: Filter by user
     */
    public function scopeForUser($query, int $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope: Filter by goal
     */
    public function scopeForGoal($query, int $goalId)
    {
        return $query->where('goal_id', $goalId);
    }

    /**
     * Scope: Filter by date range
     */
    public function scopeBetweenDates($query, $startDate, $endDate)
    {
        return $query->whereBetween('date', [$startDate, $endDate]);
    }

    /**
     * Scope: Filter by source type
     */
    public function scopeFromSource($query, string $sourceType)
    {
        return $query->where('source_type', $sourceType);
    }
}
