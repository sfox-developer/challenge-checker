<?php

namespace App\Domain\Admin\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Changelog extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'version',
        'title',
        'description',
        'changes',
        'release_date',
        'is_published',
        'is_major',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'release_date' => 'date',
        'is_published' => 'boolean',
        'is_major' => 'boolean',
    ];

    /**
     * Scope to get only published changelogs.
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    /**
     * Scope to order by release date descending.
     */
    public function scopeLatest($query)
    {
        return $query->orderBy('release_date', 'desc');
    }

    /**
     * Scope to get major releases only.
     */
    public function scopeMajor($query)
    {
        return $query->where('is_major', true);
    }
}
