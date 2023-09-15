<?php

namespace App\Policies;

use App\Models\Format;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class FormatPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // admin or editor only can see formats
        return $user->role == 'admin' || $user->role == 'editor';
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Format $format)
    {
        // admin or editor only can see formats
        return $user->role == 'admin' || $user->role == 'editor';
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user)
    {
        return $user->role === 'admin'
        ? Response::allow()
        : Response::denyWithStatus(403);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Format $format)
    {
        // admin or editor only can see formats
        return $user->role == 'admin' || $user->role == 'editor';
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Format $format)
    {
        // admin or editor only can see formats
        return $user->role == 'admin' || $user->role == 'editor';
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Format $format)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Format $format)
    {
        //
    }
}
