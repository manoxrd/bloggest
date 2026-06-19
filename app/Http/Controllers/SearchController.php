<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class SearchController extends Controller
{
  public function __invoke(Request $request)
  {

    $validated = $request->validate([
      'search' => ['required']
    ]);

    $search = trim($validated['search']);

    $results = Post::when($search, function ($query) use ($search) {

      return $query->where('title', 'LIKE', $search . '%');
    })
      ->with(['tags', 'user'])
      ->get();


    return view('blog', [
      'posts' => $results,
      'search' => $request->search,
    ]);
  }
}
