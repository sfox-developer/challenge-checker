<?php

namespace App\Policies;

use App\Domain\User\Models\User;
use App\Domain\Goal\Models\Goal;
use Illuminate\Auth\Access\Response;

class GoalPolicyLibraryPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Goal $goalLibrary): bool
    {
        return $goalLibrary->user_id === $user->id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Goal $goalLibrary): bool
    {
        return $goalLibrary->user_id === $user->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Goal $goalLibrary): bool
    {
        return $goalLibrary->user_id === $user->id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Goal $goalLibrary): bool
    {
        return $goalLibrary->user_id === $user->id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Goal $goalLibrary): bool
    {
        return $goalLibrary->user_id === $user->id;
    }
}
