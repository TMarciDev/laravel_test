<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Comment;
use Illuminate\Auth\Access\HandlesAuthorization;

class LabelPolicy
{
    use HandlesAuthorization;

    public function update(User $user, Comment $comment)
    {
        return $comment->author_id == $user->id || $user->is_admin;
    }
    public function delete(User $user, Comment $comment)
    {
        return $comment->author_id == $user->id || $user->is_admin;
    }
}
