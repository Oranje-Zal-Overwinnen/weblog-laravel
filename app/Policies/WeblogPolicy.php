<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Weblog;

class WeblogPolicy
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
    public function view(User $user, Weblog $weblog): bool
    {
        return $weblog->isVisibleTo($user);
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
    public function update(User $user, Weblog $weblog): bool
    {
        return $user->id === $weblog->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Weblog $weblog): bool
    {
        return $user->id === $weblog->user_id;
    }
}
