<?php

namespace App\Models;

use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use PhpParser\NodeVisitor\CommentAnnotatingVisitor;
use Tonysm\RichTextLaravel\Models\Traits\HasRichText;

class User extends Authenticatable
{
  /** @use HasFactory<UserFactory> */
  use HasFactory, Notifiable;
  use HasRichText;


  protected $richTextAttributes = [
    'bio',
    'body'
  ];

  protected $fillable = [
    'name',
    'username',
    'email',
    'headline',
    'bio',
    'password',
    'avatar'
  ];

  protected $hidden = [
    'password',
    'remember_token',
  ];

  public function posts()
  {
    return $this->hasMany(Post::class);
  }

  public function likes()
  {
    return $this->hasMany(Like::class);
  }

  public function views()
  {
    return $this->hasMany(View::class);
  }

  public function comments()
  {
    return $this->hasMany(Comment::class);
  }

  protected function profilePhotoUrl(): Attribute
  {
    return Attribute::get(
      fn() => $this->avatar
        ? Storage::disk('public')->url($this->avatar)
        : 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&color=7F9CF5&background=EBF4FF'
    );
  }

  /**
   * Get the attributes that should be cast.
   *
   * @return array<string, string>
   */
  protected function casts(): array
  {
    return [
      'email_verified_at' => 'datetime',
      'password' => 'hashed',
    ];
  }
}
