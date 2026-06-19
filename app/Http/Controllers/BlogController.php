<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class BlogController extends Controller
{
  public function index(Request $request)
  {
    $posts = Post::latest()->with(['user', 'tags' => function ($query) {
      $query->limit(5);
    }])->withRichText('body')->paginate(6, ['*'], 'page');

    return view('blog', [
      'posts' => $posts
    ]);
  }
}
