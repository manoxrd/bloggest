<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
  public function __invoke(Tag $tag)
  {
    $posts = $tag->posts()->with('user')->get();
    
    return view('byTag', [
      'posts' => $posts,
      'tag' => $tag->tag
    ]);
  }
}
