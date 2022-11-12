<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Comment;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentPolicy
{
    use HandlesAuthorization;

    public function update(User $user)
    {
        //return true;
        error_log(Comment::get()[0]);
        error_log("\n\nNextComment\n\n");

        //return $comment->author_id === $user->id || $user->is_admin;
        return true;//$comment->author_id === $user->id;
    }
    public function delete(User $user, Comment $comment)
    {
        return $comment->author_id === $user->id || $user->is_admin;
    }
}
