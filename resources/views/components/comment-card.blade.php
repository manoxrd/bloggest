@props(['href', 'comment', 'toPost' => null])


{{-- <div class="flex flex-col gap-4 w-full">

  <div class="flex justify-between">

    @if ($toPost)
      <a class="text-gray-700 text-xs underline" href="{{ $href }}">Go to Post</a>
    @endif

  </div>

  <div class="flex items-center gap-2 font-inter">

    <img class="rounded-full w-13 aspect-square object-cover" src="{{ $comment->user->profile_photo_url }}" alt="">
    <span class="font-medium">{{ $comment->user->name }}</span>
    <i class="fa-solid fa-circle text-third text-[6px]"></i>
    <span class="text-2xs text-third">{{ $comment->created_at ? $comment->created_at->diffForHumans() : ' ' }}</span>

  </div>

  <p class="text-sm">{{ clean($comment->text) }}</p>
</div>
 --}}


<div id="{{ $comment->id }}" class="view-comment flex flex-col gap-2 w-full">
  <div class="flex flex-col gap-3">

    @if ($toPost)
      <a class="text-gray-700 text-xs underline" href="{{ $href }}">Go to Post: {{ $comment->post->title }}</a>
    @endif

    <div class="flex items-center gap-2 font-inter">
      <img class="rounded-full w-13 aspect-square object-cover" src="{{ $comment->user->profile_photo_url }}"
        alt="">
      <span class="font-medium">{{ $comment->user->name }}</span>
      <i class="fa-solid fa-circle text-third text-[6px]"></i>
      <span
        class="text-2xs text-third">{{ $comment->created_at ? $comment->created_at->diffForHumans() : '2 days ago ' }}</span>
    </div>

    <div class="comment-text-container">
      <p class="comment-text text-sm lg:text-base">{{ $comment->text }}</p>
    </div>

  </div>

  <div class="flex justify-end gap-1 edit-delete-container border-t-2 border-t-third">

    @can('update', [$comment, $comment->post->id])
      <button class="edit-button text-third">
        <i class="fa-regular fa-pen-to-square"></i>
      </button>
    @endcan

    @can('delete', [$comment, $comment->post->id])
      <form action="/comment" method="POST" class="delete-comment">

        <label for="delete-comment" class="text-secondary">
          <i class="fa-regular fa-trash-can"></i>
        </label>
        <input id="delete-comment" type="submit" class="sr-only" />

      </form>
    @endcan

  </div>
</div>
