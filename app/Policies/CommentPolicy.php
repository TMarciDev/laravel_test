<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentPolicy
{
    use HandlesAuthorization;

    public function create(User $user)
    {
        return Auth::check();
    }

    public function update(User $user, Comment $comment)
    {
        return $comment->author_id === $user->id || $user->is_admin;
    }
    public function delete(User $user, Comment $comment)
    {
        return $comment->author_id === $user->id || $user->is_admin;
    }
}
