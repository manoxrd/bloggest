<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
  public function show(User $user)
  {
    $user->load(['likes', 'views']);

    $posts = $user->posts()->with(['tags', 'richTextBody'])->paginate(6, ['*'], 'posts');
    $comments = $user->comments()->with(['post.user'])->paginate(5, ['*'], 'comments');

    $posts->appends(['type' => 'posts']);
    $comments->appends(['type' => 'comments']);

    return view('profile.show', compact('user', 'posts', 'comments'));
  }

  public function edit(Request $request)
  {
    Gate::authorize('update', User::class);

    $user = $request->user();
    return view('profile.edit', [
      'user' => $user
    ]);
  }

  public function update(Request $request)
  {
    Gate::authorize('update', User::class);
    
    $validatedAttributes = $request->validate([
      'avatar' => ['nullable', 'image:allow_svg'],
      'name' => ['required', 'max:255'],
      'headline' => ['nullable', 'max:30'],
      'username' => ['required', 'min:4', 'alpha_dash', Rule::unique('users')->ignore($request->user()->id)],
      'bio' => ['nullable', 'string']
    ], ['username.alpha_dash' => 'The username must not contain any spaces']);
    
    $user = $request->user();

    if ($request->delete_photo && $user->avatar) {
      Storage::disk('public')->delete($user->avatar);
      $user->avatar = null;
    }

    if ($request->hasFile('avatar')) {

      if ($validatedAttributes['avatar'] && $user->avatar) {
        Storage::disk('public')->delete($user->avatar);
      }

      $validatedAttributes['avatar'] = $request->avatar->store('profiles', 'public');
    }


    if (! $validatedAttributes['bio']) {
      $validatedAttributes['bio'] = " ";
    }

    $user->update($validatedAttributes);

    return redirect("/@{$user->username}");
  }

  public function destroy(Request $request)
  {
    Gate::authorize('delete', User::class);

    $user = $request->user();

    if ($user->avatar) {
      Storage::disk('public')->delete($user->avatar);
    }


    Auth::logout();
    $user->delete();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect("/");
  }
}
