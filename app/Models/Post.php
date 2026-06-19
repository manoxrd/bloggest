<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Tonysm\RichTextLaravel\Models\Traits\HasRichText;

class Post extends Model
{
  /** @use HasFactory<\Database\Factories\PostFactory> */
  use HasFactory;
  use HasRichText;
  
  protected $richTextAttributes = [
    'body',
  ];

  protected $fillable = [
    'title',
    'slug',
    'body',
    'thumbnail',
  ];

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function tags()
  {
    return $this->belongsToMany(Tag::class);
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

  protected function thumbnailUrl(): Attribute
  {
    return Attribute::get(
      fn() => $this->thumbnail
        ? Storage::disk('public')->url($this->thumbnail)
        : ''
    );
  }
}
