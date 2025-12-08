<?php

namespace App\Domain\Goal\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Domain\User\Models\User;
use App\Domain\Challenge\Models\Goal;

class GoalLibrary extends Model
{
    use HasFactory;

    protected $table = 'goals_library';

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
     * Get all challenge goals that reference this library goal.
     */
    public function challengeGoals(): HasMany
    {
        return $this->hasMany(Goal::class, 'goal_library_id');
    }

    /**
     * Get all habits that use this goal.
     */
    public function habits(): HasMany
    {
        return $this->hasMany(\App\Domain\Habit\Models\Habit::class, 'goal_library_id');
    }

    /**
     * Get usage count (how many times this goal is used).
     */
    public function getUsageCountAttribute(): int
    {
        return $this->challengeGoals()->count() + $this->habits()->count();
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
}
