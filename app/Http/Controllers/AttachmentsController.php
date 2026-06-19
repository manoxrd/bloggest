<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AttachmentsController extends Controller
{
  public function store(Request $request)
  {
    $request->validate(['attachment' => ['required', 'file']]);

    $path = $request->file('attachment')->store('attachments/tmp', 'public');

    return [
      'attachment_url' => Storage::disk('public')->url($path)
    ];
  }

  public function destroy(Request $request)
  {
    $validated = $request->validate(['attachment_url' => ['url']]);

    $attachment_url = Str::afterLast($validated['attachment_url'], '/');

    $attachment_url = '/attachments/' . $attachment_url;

    $fileExists = Storage::disk('public')->exists($attachment_url);

    return
      [
        'file_exists' => $fileExists,
        'attachment_url' => $attachment_url
      ];
  }
}
