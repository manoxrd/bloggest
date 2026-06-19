<?php
namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class LikeController extends Controller
{
  public function store(string $user, Post $post, Request $request)
  {
    $user = $request->user();
    if (!$user) return;

    $like = $user->likes()->firstOrCreate([
      'post_id' => $post->id
    ]);

    if($like->wasRecentlyCreated) {
      $post->increment('likes_count');
    }

    return [
      'likes_count' => $post->fresh()->likes_count
    ];
  }

  public function destroy(string $user, Post $post, Request $request)
  {
    $user = $request->user();
    if (!$user) return;

    $deleted = $user->likes()->where('post_id', $post->id)->delete();

    if ($deleted > 0) {
        $post->decrement('likes_count');
    }

    return [
      'likes_count' => $post->fresh()->likes_count
    ];
  }
}
