<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Comment;
use Illuminate\Auth\Access\HandlesAuthorization;

class ItemPolicy
{
    use HandlesAuthorization;

    public function create(User $user)
    {
        return $user->is_admin;
    }

    public function update(User $user)
    {
        return $user->is_admin;
    }
    public function delete(User $user)
    {
        return $user->is_admin;
    }

}
