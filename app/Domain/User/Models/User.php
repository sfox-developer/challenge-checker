<?php

namespace App\Domain\User\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Domain\Challenge\Models\Challenge;
use App\Domain\Activity\Models\Activity;
use App\Domain\Social\Models\UserFollow;
use App\Domain\Habit\Models\Habit;
use App\Domain\Goal\Models\GoalLibrary;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
        'avatar',
        'theme_preference',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean',
        ];
    }

    /**
     * Get the challenges for the user.
     */
    public function challenges(): HasMany
    {
        return $this->hasMany(Challenge::class);
    }

    /**
     * Get the habits for the user.
     */
    public function habits(): HasMany
    {
        return $this->hasMany(Habit::class);
    }

    /**
     * Get the goal library for the user.
     */
    public function goalsLibrary(): HasMany
    {
        return $this->hasMany(GoalLibrary::class);
    }

    /**
     * Get the activities for the user.
     */
    public function activities(): HasMany
    {
        return $this->hasMany(Activity::class);
    }

    /**
     * Get the users that this user is following.
     */
    public function following(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'user_follows',
            'follower_id',
            'following_id'
        )->withTimestamps();
    }

    /**
     * Get the users that are following this user.
     */
    public function followers(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'user_follows',
            'following_id',
            'follower_id'
        )->withTimestamps();
    }

    /**
     * Check if this user is following another user.
     */
    public function isFollowing(User $user): bool
    {
        return $this->following()->where('following_id', $user->id)->exists();
    }

    /**
     * Check if this user is followed by another user.
     */
    public function isFollowedBy(User $user): bool
    {
        return $this->followers()->where('follower_id', $user->id)->exists();
    }

    /**
     * Follow another user.
     */
    public function follow(User $user): void
    {
        if ($this->id !== $user->id && !$this->isFollowing($user)) {
            $this->following()->attach($user->id);
        }
    }

    /**
     * Unfollow a user.
     */
    public function unfollow(User $user): void
    {
        $this->following()->detach($user->id);
    }

    /**
     * Get count of users this user is following.
     */
    public function followingCount(): int
    {
        return $this->following()->count();
    }

    /**
     * Get count of users following this user.
     */
    public function followersCount(): int
    {
        return $this->followers()->count();
    }

    /**
     * Get available avatar options.
     */
    public static function getAvailableAvatars(): array
    {
        return [
            'pet-6' => 'Pet 6',
            'pet-7' => 'Pet 7',
            'pet-8' => 'Pet 8',
            'pet-9' => 'Pet 9',
            'pet-10' => 'Pet 10',
            'user-11' => 'User 11',
            'user-12' => 'User 12',
            'user-13' => 'User 13',
            'user-14' => 'User 14',
            'user-15' => 'User 15',
        ];
    }

    /**
     * Get the avatar URL.
     */
    public function getAvatarUrl(): string
    {
        if (!$this->avatar) {
            return asset('avatars/default.svg');
        }
        
        $avatarPath = public_path('avatars/' . $this->avatar . '.svg');
        
        if (!file_exists($avatarPath)) {
            return asset('avatars/default.svg');
        }
        
        return asset('avatars/' . $this->avatar . '.svg');
    }

    /**
     * @deprecated Use getAvatarUrl() instead
     */
    public function getAvatarEmoji(): string
    {
        return $this->getAvatarUrl();
    }

    /**
     * Get the user's theme preference.
     * Returns 'light', 'dark', or 'system'.
     */
    public function getThemePreference(): string
    {
        return $this->theme_preference ?? 'system';
    }

    /**
     * Update the user's theme preference.
     */
    public function updateThemePreference(string $theme): void
    {
        if (in_array($theme, ['light', 'dark', 'system'])) {
            $this->update(['theme_preference' => $theme]);
        }
    }
}
