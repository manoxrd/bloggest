<?php

namespace App\Listeners;

use App\Events\ShowPost;
use App\Models\View;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ViewsHandling
{
  /**
   * Create the event listener.
   */
  public function __construct() {}

  /**
   * Handle the event.
   */
  public function handle(ShowPost $event): void
  {
    if (!$event->user) return;
    $user = $event->user;
    $post = $event->post;

    $isViewExists = View::where('user_id', $user->id)->where('post_id', $post->id)->exists();
    if ($isViewExists) return;

    $post->views()->create([
      'user_id' => $user->id
    ]);
    $post->views_count++;
    $user->views_count++;

    $post->save();
    $user->save();
  }
}
