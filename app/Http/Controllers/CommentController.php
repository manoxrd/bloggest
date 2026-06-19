<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CommentController extends Controller
{
  public function store(string $user, Post $post, Request $request)
  {
    Gate::authorize('create', Comment::class);
    $user = $request->user();

    $validated = $request->validate([
      'text' => ['required', 'string', 'max:1000']
    ]);

    if ($user->comments()->where('post_id', $post->id)->count() >= 5) {
      return response()->json([
        'message' => "You've reached the maximum comments count in one post",
      ], 422);
    }

    $comment = $user->comments()->create([
      'text' => $validated['text'],
      'post_id' => $post->id
    ]);

    return response()->json([
      'id' => $comment->id,
      'text' => $comment->text,
      'name' => $user->name,
      'profilePhoto' => $user->profile_photo_url,
      'createDate' => 'Just Now',
    ]);
  }

  public function update(string $user, Post $post, Comment $comment, Request $request)
  {
    $validated = $request->validate([
      'text' => ['required', 'string', 'max:1000'],
    ]);

    if (! $comment) {
      return response()->json([
        'message' => "This comment doesn't exists",
      ], 404);
    }

    Gate::authorize('update', [$comment, $post->id]);

    $comment->update($validated);

    return response()->json([
      'text' => $comment->text,
    ]);
  }

  public function destroy(string $user, Post $post, Comment $comment, Request $request)
  {
    if (! $comment) {
      return response()->json([
        'message' => "This comment doesn't exists",
      ], 404);
    }

    Gate::authorize('delete', [$comment, $post->id]);

    $comment->delete();

    return response()->json();
  }
}
