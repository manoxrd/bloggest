<?php

namespace App\Http\Controllers;

use App\Events\ShowPost;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $posts = Post::limit(6)->with(['user', 'tags' => function($query) {
      $query->limit(5);
    }])->withRichText('body')->get();

    return view('home', [
      'posts' => $posts
    ]);
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    Gate::authorize('create', Post::class);

    $tags = Tag::select('id', 'tag')->get();

    return view('post.create', [
      'tags' => $tags
    ]);
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    Gate::authorize('create', Post::class);

    $validated = $request->validate([
      'thumbnail' => ['required', 'image'],
      'title' => ['required', 'max:255'],
      'body' => ['required'],
      'attachments.*' => ['nullable', 'image'],
      'tags.*' => ['nullable']
    ]);

    $body = $validated['body'];

    preg_match_all('/(?:src|url)="([^"]*\/attachments\/tmp\/([^">\s]+))"/', $body, $matches);

    $fullUrls = $matches[1] ?? [];
    $filenames = $matches[2] ?? [];

    foreach ($filenames as $index => $filename) {
      $oldPath = "attachments/tmp/{$filename}";
      $newPath = "attachments/{$filename}";

      if (Storage::disk('public')->exists($oldPath)) {
        Storage::disk('public')->move($oldPath, $newPath);

        $newUrl = url(Storage::url($newPath));
        $body = str_replace($fullUrls[$index], $newUrl, $body);
      }
    }

    $slug = Str::slug($validated['title'], '-');

    $sameTitle = DB::table('posts')->where('slug', "=", $slug . "-1")->exists();
    if ($sameTitle) {
      $num = 1;

      while (DB::table('posts')->where('slug', "=", $slug . '-' . $num)->exists()) {
        $num++;
      }
      $slug .= "-{$num}";
    } else {
      $slug .= '-1';
    }





    $validated['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');

    $post = $request->user()->posts()->create([
      'thumbnail' => $validated['thumbnail'],
      'title' => $validated['title'],
      'body' => $body,
      'slug' => $slug
    ]);



    if (isset($validated['tags'])) {
      $post->tags()->attach($validated['tags']);
    }


    return redirect('/');
  }

  /**
   * Display the specified resource.
   */
  public function show(User $user, Post $post)
  {

    $post->load(['user', 'tags', 'comments.user', 'comments.post', 'comments' => function ($query) {
      $query->orderBy('created_at', 'desc');
    }]);

    ShowPost::dispatch($user, $post);

    $content = $post->body;
    $words = Str::wordCount(strip_tags($content));
    $minetues = ceil($words / 130);
    
    return view('post.show', [
      'post' => $post,
      'reading_time' => $minetues,
    ]);
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Post $post)
  {
    Gate::authorize('update', $post);


    $post->load(['richTextBody', 'tags']);

    $tags = Tag::get();

    return view('post.edit', [
      'post' => $post,
      'tags' => $tags
    ]);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, Post $post)
  {
    Gate::authorize('update', $post);

    $validated = $request->validate([
      'thumbnail' => ['nullable', 'image'],
      'title' => ['required', 'max:255'],
      'body' => ['required'],
    ]);

    $body = $validated['body'];

    preg_match_all('/(?:src|url)="([^"]*\/attachments\/tmp\/([^">\s]+))"/', $body, $matches);

    $fullUrls = $matches[1] ?? [];
    $filenames = $matches[2] ?? [];

    foreach ($filenames as $index => $filename) {
      $oldPath = "attachments/tmp/{$filename}";
      $newPath = "attachments/{$filename}";

      if (Storage::disk('public')->exists($oldPath)) {
        Storage::disk('public')->move($oldPath, $newPath);

        $newUrl = url(Storage::url($newPath));
        $body = str_replace($fullUrls[$index], $newUrl, $body);
        $validated['body'] = $body;
      }
    }

    $attachments = $request->attachments ?? [];
    foreach ($attachments as $key => $value) {

      if (Storage::disk('public')->exists($value)) {
        Storage::disk('public')->delete($value);
      }
    }


    if ($request->hasFile('thumbnail')) {
      Storage::disk('public')->delete($post->thumbnail);
      $validated['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
    }


    $post->update($validated);

    if (isset($request->tags)) {
      $post->tags()->sync($request->tags);
    } else {
      $post->tags()->detach();
    }

    return redirect('/');
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Post $post)
  {
    Gate::authorize('delete', $post);

    foreach ($post->body->attachments() as $attachment) {
      if ($attachment->attachable) {
        $attachment_url = Str::afterLast($attachment->attachable->url, 'storage/');
        Storage::disk('public')->delete($attachment_url);
      }
    }

    Storage::disk('public')->delete($post->thumbnail);

    $post->body->delete();
    $post->delete();

    return redirect('/');
  }
}
