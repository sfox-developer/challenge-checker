<?php

namespace App\Domain\Activity\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Domain\User\Models\User;
use App\Domain\Challenge\Models\Challenge;
use App\Domain\Challenge\Models\Goal;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'challenge_id',
        'goal_id',
        'type',
        'data',
    ];

    protected $casts = [
        'data' => 'array',
        'created_at' => 'datetime',
    ];

    // Activity types
    const TYPE_GOAL_COMPLETED = 'goal_completed';
    const TYPE_DAY_COMPLETED = 'day_completed';
    const TYPE_CHALLENGE_STARTED = 'challenge_started';
    const TYPE_CHALLENGE_COMPLETED = 'challenge_completed';
    const TYPE_CHALLENGE_PAUSED = 'challenge_paused';
    const TYPE_CHALLENGE_RESUMED = 'challenge_resumed';

    /**
     * Get the user that owns the activity.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the challenge associated with the activity.
     */
    public function challenge(): BelongsTo
    {
        return $this->belongsTo(Challenge::class);
    }

    /**
     * Get the goal associated with the activity.
     */
    public function goal(): BelongsTo
    {
        return $this->belongsTo(Goal::class);
    }

    /**
     * Get the likes for the activity.
     */
    public function likes(): HasMany
    {
        return $this->hasMany(ActivityLike::class);
    }

    /**
     * Check if a user has liked this activity.
     */
    public function isLikedBy(User $user): bool
    {
        return $this->likes()->where('user_id', $user->id)->exists();
    }

    /**
     * Get the likes count for this activity.
     */
    public function likesCount(): int
    {
        return $this->likes()->count();
    }

    /**
     * Scope to get only public activities (from public challenges or own activities).
     */
    public function scopePublic($query)
    {
        return $query->whereHas('challenge', function ($q) {
            $q->where('is_public', true);
        });
    }

    /**
     * Scope to get activities for a user's feed (own + followed users' public activities).
     */
    public function scopeFeed($query, User $user)
    {
        return $query->where(function ($q) use ($user) {
            // Own activities
            $q->where('user_id', $user->id)
                // Or public activities from followed users
                ->orWhere(function ($subQ) use ($user) {
                    $subQ->whereIn('user_id', $user->following()->pluck('following_id'))
                        ->whereHas('challenge', function ($challengeQ) {
                            $challengeQ->where('is_public', true);
                        });
                });
        })->with(['user', 'challenge', 'goal', 'likes'])
          ->latest();
    }

    /**
     * Get a human-readable description of the activity.
     */
    public function getDescription(): string
    {
        $challengeName = $this->challenge ? "<strong>{$this->challenge->name}</strong>" : "a challenge";
        $goalName = $this->goal ? "<strong>{$this->goal->name}</strong>" : "a goal";
        
        return match($this->type) {
            self::TYPE_GOAL_COMPLETED => "completed the goal {$goalName} in {$challengeName}",
            self::TYPE_DAY_COMPLETED => "completed all daily goals for {$challengeName} 🎉",
            self::TYPE_CHALLENGE_STARTED => "started the challenge {$challengeName}",
            self::TYPE_CHALLENGE_COMPLETED => "successfully completed {$challengeName}! 🏆",
            self::TYPE_CHALLENGE_PAUSED => "paused {$challengeName}",
            self::TYPE_CHALLENGE_RESUMED => "resumed {$challengeName} - back on track!",
            default => "performed an activity",
        };
    }

    /**
     * Get the icon for the activity type.
     */
    public function getIcon(): string
    {
        return match($this->type) {
            self::TYPE_GOAL_COMPLETED => '✓',
            self::TYPE_DAY_COMPLETED => '🎯',
            self::TYPE_CHALLENGE_STARTED => '🚀',
            self::TYPE_CHALLENGE_COMPLETED => '🏆',
            self::TYPE_CHALLENGE_PAUSED => '⏸️',
            self::TYPE_CHALLENGE_RESUMED => '▶️',
            default => '📌',
        };
    }

    /**
     * Get the color class for the activity type.
     */
    public function getColorClass(): string
    {
        return match($this->type) {
            self::TYPE_GOAL_COMPLETED => 'bg-green-100 text-green-800',
            self::TYPE_DAY_COMPLETED => 'bg-blue-100 text-blue-800',
            self::TYPE_CHALLENGE_STARTED => 'bg-purple-100 text-purple-800',
            self::TYPE_CHALLENGE_COMPLETED => 'bg-yellow-100 text-yellow-800',
            self::TYPE_CHALLENGE_PAUSED => 'bg-orange-100 text-orange-800',
            self::TYPE_CHALLENGE_RESUMED => 'bg-indigo-100 text-indigo-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }
}
