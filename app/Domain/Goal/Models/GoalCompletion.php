<?php

namespace App\Domain\Goal\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
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
        return $this->belongsTo(Goal::class, 'goal_id');
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
}
