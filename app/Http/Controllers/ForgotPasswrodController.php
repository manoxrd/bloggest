<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password as RulesPassword;

class ForgotPasswrodController extends Controller
{
  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    return view('auth.forgot-password');
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request) {
    $request->validate([
      'email' => ['required', 'email']
    ]);

    $status = Password::sendResetLink(
        $request->only('email')
    );

     return $status === Password::ResetLinkSent
        ? back()->with(['status' => __($status)])
        : back()->withErrors(['email' => __($status)]);


  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Request $request, $token)
  {
    return view('auth.reset-password', ['token' => $token]);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request)
  {
    $request->validate([
      'token' => ['required'],
      'email' => ['required', 'email'],
      'password' => ['required', RulesPassword::min(7)->letters()->uncompromised(), 'confirmed']
    ]);
    

    $status = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function (User $user, string $password) {
            $user->forceFill([
                'password' => Hash::make($password)
            ])->setRememberToken(Str::random(60));
 
            $user->save();
 
            event(new PasswordReset($user));
        }
    );
 
    return $status === Password::PasswordReset
        ? redirect()->route('login')->with('status', __($status))
        : back()->withErrors(['email' => [__($status)]]);

  }
}
