<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class RegisterUserController extends Controller
{
  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    return view('auth.register');
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $attributes = $request->validate([
      'name' => ['required', 'max:255'],
      'headline' => ['nullable', 'max:30'],
      'username' => ['required', 'min:4', 'alpha_dash', 'unique:users,username'],
      'email' => ['required', 'email', 'unique:users,email'],
      'password' => ['required', Password::min(7)->letters()->uncompromised(), 'confirmed'],
      'bio' => ['nullable', 'string']
    ], ['username.alpha_dash' => 'The username must not contain any spaces']);

    $user = User::create($attributes);

    Auth::login($user);

    return redirect('/');
  }
}
