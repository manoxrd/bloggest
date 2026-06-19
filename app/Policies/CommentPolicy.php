<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CommentPolicy
{
  public function create(User $user)
  {
    return true;
  }

  public function update(User $user, Comment $comment, $post_id)
  {
    if ($user->id == $comment->user_id && (int)$post_id === $comment->post_id) {
      return Response::allow();
    }

    return Response::deny("Sorry you don't own this comment");
  }

  public function delete(User $user, Comment $comment, $post_id): bool
  {
    if ($user->id == $comment->user_id && (int)$post_id === $comment->post_id) {
      return true;
    } elseif ($user->id === $comment->post->user_id) {
      return true;
    }
    

    return false;
  }
}
