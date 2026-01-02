<?php

namespace App\Domain\Goal\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Domain\User\Models\User;
use App\Domain\Challenge\Models\Challenge;
use App\Domain\Challenge\Models\ChallengeGoal;
use App\Domain\Goal\Models\GoalCompletion;

class Goal extends Model
{
    use HasFactory;

    protected $table = 'goals';

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'category_id',
        'icon',
    ];

    /**
     * Get the user that owns the goal.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the category for this goal.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get all challenges that use this goal.
     */
    public function challenges(): BelongsToMany
    {
        return $this->belongsToMany(Challenge::class, 'challenge_goals', 'goal_id', 'challenge_id')
            ->using(ChallengeGoal::class)
            ->withPivot('order');
    }

    /**
     * Get all habits that use this goal.
     */
    public function habits(): HasMany
    {
        return $this->hasMany(\App\Domain\Habit\Models\Habit::class, 'goal_id');
    }

    /**
     * Get all completions for this goal.
     */
    public function completions(): HasMany
    {
        return $this->hasMany(GoalCompletion::class, 'goal_id');
    }

    /**
     * Get usage count (how many times this goal is used).
     */
    public function getUsageCountAttribute(): int
    {
        return $this->challenges()->count() + $this->habits()->count();
    }

    /**
     * Scope to search goals by name.
     */
    public function scopeSearch($query, string $search)
    {
        return $query->where('name', 'like', "%{$search}%")
            ->orWhere('description', 'like', "%{$search}%");
    }

    /**
     * Scope to filter by category.
     */
    public function scopeByCategory($query, $categoryId)
    {
        if ($categoryId) {
            return $query->where('category_id', $categoryId);
        }
        return $query;
    }

    /**
     * Check if this goal is completed for a specific date and user.
     * Optionally filter by source (challenge or habit).
     */
    public function isCompletedForDate(string $date, int $userId, ?string $sourceType = null, ?int $sourceId = null): bool
    {
        $query = $this->completions()
            ->where('user_id', $userId)
            ->where('date', $date)
            ->whereNotNull('completed_at');
        
        if ($sourceType) {
            $query->where('source_type', $sourceType);
        }
        
        if ($sourceId) {
            $query->where('source_id', $sourceId);
        }
        
        return $query->exists();
    }

    /**
     * Check if this goal is completed for a specific date within a challenge context.
     */
    public function isCompletedForChallenge(int $challengeId, string $date, int $userId): bool
    {
        return $this->isCompletedForDate($date, $userId, 'challenge', $challengeId);
    }

    /**
     * Check if this goal is completed for a specific date within a habit context.
     */
    public function isCompletedForHabit(int $habitId, string $date, int $userId): bool
    {
        return $this->isCompletedForDate($date, $userId, 'habit', $habitId);
    }
}
