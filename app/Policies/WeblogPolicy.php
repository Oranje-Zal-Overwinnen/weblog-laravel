<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Weblog;

class WeblogPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Weblog $weblog): bool
    {
        return $weblog->isVisibleTo($user);
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Weblog $weblog): bool
    {
        return $user->id === $weblog->user_id;
    }

    public function delete(User $user, Weblog $weblog): bool
    {
        return $user->id === $weblog->user_id;
    }
}
