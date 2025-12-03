<?php

namespace App\Domain\Habit\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Domain\User\Models\User;

class HabitCompletion extends Model
{
    use HasFactory;

    protected $fillable = [
        'habit_id',
        'user_id',
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
        'duration_minutes' => 'integer',
        'metadata' => 'array',
    ];

    /**
     * Get the habit this completion belongs to.
     */
    public function habit(): BelongsTo
    {
        return $this->belongsTo(Habit::class);
    }

    /**
     * Get the user that owns this completion.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check if this completion has notes.
     */
    public function hasNotes(): bool
    {
        return !empty($this->notes);
    }

    /**
     * Check if this completion has duration tracked.
     */
    public function hasDuration(): bool
    {
        return !is_null($this->duration_minutes) && $this->duration_minutes > 0;
    }

    /**
     * Get formatted duration.
     */
    public function getFormattedDuration(): ?string
    {
        if (!$this->hasDuration()) {
            return null;
        }

        $hours = floor($this->duration_minutes / 60);
        $minutes = $this->duration_minutes % 60;

        if ($hours > 0) {
            return $minutes > 0 
                ? "{$hours}h {$minutes}m" 
                : "{$hours}h";
        }

        return "{$minutes}m";
    }

    /**
     * Get mood emoji.
     */
    public function getMoodEmoji(): ?string
    {
        return match($this->mood) {
            'exhausted' => '😫',
            'tired' => '😴',
            'neutral' => '😐',
            'good' => '😊',
            'happy' => '😁',
            'amazing' => '🤩',
            default => null,
        };
    }

    /**
     * Scope to get completions for a specific date range.
     */
    public function scopeBetweenDates($query, string $startDate, string $endDate)
    {
        return $query->whereBetween('date', [$startDate, $endDate]);
    }

    /**
     * Scope to get completions for a specific month.
     */
    public function scopeForMonth($query, int $year, int $month)
    {
        $startDate = sprintf('%04d-%02d-01', $year, $month);
        $endDate = date('Y-m-t', strtotime($startDate));
        
        return $query->whereBetween('date', [$startDate, $endDate]);
    }

    /**
     * Scope to get recent completions with notes.
     */
    public function scopeWithNotes($query)
    {
        return $query->whereNotNull('notes')->where('notes', '!=', '');
    }
}
