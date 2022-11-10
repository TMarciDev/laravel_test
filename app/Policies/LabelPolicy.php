<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LabelPolicy
{
    use HandlesAuthorization;

    public function create(User $user)
    {
        return $user->is_admin;
    }
    public function edit(User $user)
    {
        return $user->is_admin;
    }
    public function delete(User $user)
    {
        return $user->is_admin;
    }
}
