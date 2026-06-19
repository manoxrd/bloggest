<x-layout>

  <div id="post" data-post="{{ $post->id }}"
    class="flex justify-center items-center rounded-3xl h-60 md:h-70 lg:h-80 bg-stone-200 mt-3 overflow-hidden relative">
    <div class="absolute top-2 right-3 flex gap-1">

      @can('update', $post)
        <a class="text-white bg-black/50 w-7 h-7 items-center rounded-full flex justify-center"
          href="{{ route('post.edit', $post->slug) }}">
          <i class="fa-regular fa-pen-to-square"></i>
        </a>
      @endcan

      @can('delete', $post)
        <form method="POST" action="{{ route('post.destroy', $post->slug) }}"
          class="text-white bg-black/50 w-7 h-7 items-center rounded-full flex justify-center">
          @csrf
          @method('DELETE')

          <label for="delete-post">
            <i class="fa-regular fa-trash-can opacity-100"></i>
          </label>

          <input id="delete-post" class="text-white bg-red-800 px-4 py-2 sr-only" type="submit" value="Delete Post">
        </form>
      @endcan

    </div>

    <img id="thumbnail-img" class="w-full h-full object-cover object-center" src="{{ $post->thumbnail_url }}"
      alt="thumbnail-preview">
  </div>

  <x-container class="mt-5">

    <div class="flex flex-col gap-12">

      <div class="flex flex-col gap-6">

        <div class="flex gap-2 text-xs text-third">
          <span>
            {{ $reading_time . ' minetues read' }}
          </span>
          <span>|</span>
          <span>{{ $post->created_at->diffForHumans() }}</span>
        </div>

        <div class="flex flex-col gap-8">
          <span class="text-3xl font-abril">
            {{ $post->title }}
          </span>

          <div>
            {{ clean($post->body) }}
          </div>
        </div>

      </div>

      <a href="{{ '/@' . $post->user->username }}"
        class="flex gap-4 bg-secondary rounded-[20px] inset-shadow-[3px_3px_4px_0_rgba(255,255,255,0.30)] shadow-[2px_2px_4px_0_rgb(0,0,0)] p-5">
        <img class="rounded-full w-18 aspect-square object-cover" src="{{ $post->user->profile_photo_url }}"
          alt="">
        <div class="flex flex-col pt-3 text-primary">
          <span class="font-inter font-semibold text-lg lg:text-xl">{{ $post->user->name }}</span>
          <span class="font-abel lg:text-lg">{{ $post->user->headline }}</span>
        </div>
      </a>

      <div class="flex flex-col gap-3">
        <h3 class="font-abril text-2xl font-medium">Tags</h3>
        <div class="flex gap-2">
          @foreach ($post->tags as $tag)
            <x-tag href="/tags/{{ $tag->tag }}">{{ $tag->tag }}</x-tag>
          @endforeach
        </div>
      </div>

      <div class="flex flex-col gap-10">
        <h3 class="font-abril text-2xl font-medium">Comments</h3>

        <div class="flex flex-col">

          <form id="commentForm" action="/comment" method="post">
            @csrf

            <div class="flex gap-1 pb-1 border-b-2 border-b-third">
              <textarea name="text" id="text" class="resize-none field-sizing-content flex-1"
                placeholder="Leave a Comment..."></textarea>

              <label for="submit" class="ml-1">
                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="21" viewBox="0 0 26 21"
                  fill="none">
                  <path
                    d="M4.27754 10.3646L0.75 0.75C9.18829 2.80833 17.1456 6.05991 24.279 10.3646C17.146 14.6692 9.18914 17.9207 0.751292 19.9792L4.27754 10.3646ZM4.27754 10.3646H13.965"
                    stroke="#898989" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
              </label>
            </div>

            <input class="sr-only" id="submit" type="submit" value="submit">

            <p class="create-comment-error text-red-700"></p>
          </form>
        </div>

        <div class="comments flex flex-col gap-10 w-full">

          @forelse ($post->comments as $comment)
            <x-comment-card :href="'/@' . $comment->post->user->username . '/' . $comment->post->slug" :comment="$comment" />
          @empty
            <x-empty class="empty">No, Comments Found.</x-empty>
          @endforelse

        </div>

      </div>

      <div>
        <h3></h3>

      </div>

    </div>


  </x-container>



  <template class="create-comment-template">
    {{-- <div id="" class="view-comment flex justify-between mt-10 bg-amber-50">
      <div>

        <div class="flex justify-start m-1">
          <img class="mr-2 h-7 w-7 rounded-2xl" src="" alt="">
          <h4 class="user-name"></h4>
          <div class="text-gray-400 text-xs comment-time"></div>
        </div>

        <div class="comment-text-container">
          <p class="comment-text"></p>
        </div>

      </div>
      <div class="flex flex-col items-stretch edit-delete-container">
        <button class="edit-button bg-black text-white">Edit</button>
        <form action="/comment" method="POST" class="delete-comment">
          <input type="submit" class="delete-button bg-red-700 text-white" value="Delete" />
        </form>
      </div>
    </div> --}}





    <div id="" class="view-comment flex flex-col gap-2 w-full">
      <div class="flex flex-col gap-3">

        <div class="flex items-center gap-2 font-inter">
          <img class="rounded-full w-13 aspect-square object-cover" src="" alt="">
          <span class="font-medium user-name"></span>
          <i class="fa-solid fa-circle text-third text-[6px]"></i>
          <span class="text-2xs text-third comment-time"></span>
        </div>

        <div class="comment-text-container">
          <p class="comment-text text-sm"></p>
        </div>

      </div>

      <div class="flex justify-end gap-1 edit-delete-container border-t-2 border-t-third">

        <button class="edit-button text-third">
          <i class="fa-regular fa-pen-to-square"></i>
        </button>

        <form action="/comment" method="POST" class="delete-comment">

          <label for="delete-comment" class="text-secondary">
            <i class="fa-regular fa-trash-can"></i>
          </label>
          <input id="delete-comment" type="submit" class="sr-only" />

        </form>

      </div>
    </div>



  </template>

  <template class="edit-comment-template">
    <form action="/comment" class="edit-comment flex flex-col gap-1" method="POST">
      <textarea name="text" id="text" class="px-1 resize-none field-sizing-content border-third border-1 rounded-md"></textarea>

      <div class="flex justify-end gap-2">
        {{-- <input id="edit-comment" class="bg-blue-500 text-white" type="submit" value="submit"> --}}
        <x-form.submit class="!w-fit px-6">Update</x-form.submit>
        <x-primary-btn href="none" tag="button" type="button" class="cancel-button">Cancel</x-primary-btn>
      </div>

      <p class="update-comment-error text-red-700"></p>
    </form>
  </template>







  {{-- 

  <div id="post" data-post="{{ $post->id }}">
    <img src="{{ $post->thumbnail_url }}" alt="">

    <h1>{{ $post->title }}</h1>
    <p>{{ clean($post->body) }}</p>
  </div>

  <div class="flex justify-center gap-3">
    @foreach ($post->tags as $tag)
      <a href="/tags/{{ $tag->tag }}" class="bg-gray-200">{{ $tag->tag }}</a>
    @endforeach
  </div>

  <div class="like-container relative">
    @php

      $user = auth()->user();

      if ($post->likes()->firstWhere('user_id', $user?->id)) {
          $liked = 'liked';
          $unliked = 'invisible';
      } else {
          $liked = 'invisible';
          $unliked = '';
      }

    @endphp
    <i class="fa-regular fa-heart {{ $unliked }} text-base absolute top-0 left-0"></i>
    <i
      class="fa-solid fa-heart text-red-500 {{ $liked }} transition-[font-size, translate] absolute top-0 left-0 text-2xs translate-x-2 translate-y-1.5 delay-100 duration-250"></i>
  </div>

  <p>Likes:<span class="likes_count">{{ $post->likes_count }}</span></p>
  <p>Views: {{ $post->views_count }}</p>
  <a href="{{ '/@' . $post->user->username }}">
    <div class="bg-red-700 text-amber-100 inline-block px-5 py-2">
      <h4>{{ $post->user->name }}</h4>
      <p class="text-xs text-gray-300 italic">{{ $post->user->headline }}</p>
    </div>
  </a>


  <h3 class="mb-5">Comments:</h3>

  <form id="commentForm" action="/comment" method="post">
    @csrf
    <textarea name="text" id="text" class="resize-none field-sizing-content w-50" placeholder="Leave a Comment..."></textarea>
    <input type="submit" value="submit">
    <p class="create-comment-error text-red-700"></p>
  </form>

  <div class="comments max-w-2xs mx-auto">
    @foreach ($post->comments as $comment)
      <div id="{{ $comment->id }}" class="view-comment flex justify-between mt-10 bg-amber-50">
        <div>

          <div class="flex justify-start m-1">
            <img class="mr-2 h-7 w-7 rounded-2xl" src="{{ $comment->user->profile_photo_url }}" alt="">
            <h4>{{ $comment->user->name }}</h4>
            <div class="text-gray-400 text-xs">{{ $comment->created_at->diffForHumans() }}</div>
          </div>
          <div class="comment-text-container">

            <p class="comment-text">{{ $comment->text }}</p>
          </div>
        </div>
        <div class="flex flex-col items-stretch edit-delete-container">
          @can('update', [$comment, $post->id])
            <button class="edit-button bg-black text-white">Edit</button>
          @endcan

          @can('delete', [$comment, $post->id])
            <form action="/comment" method="POST" class="delete-comment">
              <input type="submit" class="delete-button bg-red-700 text-white" value="Delete" />
            </form>
          @endcan
        </div>
      </div>
    @endforeach

  </div>



















  <template class="create-comment-template">
    <div id="" class="view-comment flex justify-between mt-10 bg-amber-50">
      <div>

        <div class="flex justify-start m-1">
          <img class="mr-2 h-7 w-7 rounded-2xl" src="" alt="">
          <h4 class="user-name"></h4>
          <div class="text-gray-400 text-xs comment-time"></div>
        </div>

        <div class="comment-text-container">
          <p class="comment-text"></p>
        </div>

      </div>
      <div class="flex flex-col items-stretch edit-delete-container">
        <button class="edit-button bg-black text-white">Edit</button>
        <form action="/comment" method="POST" class="delete-comment">
          <input type="submit" class="delete-button bg-red-700 text-white" value="Delete" />
        </form>
      </div>
    </div>
  </template>

  <template class="edit-comment-template">
    <form action="/comment" class="edit-comment" method="POST">
      <textarea name="text" id="text" class="resize-none field-sizing-content w-50 bg-white"></textarea>
      <input class="bg-blue-500 text-white" type="submit" value="submit">
      <button type="button" class="cancel-button bg-black text-white">Cancel</button>
      <p class="update-comment-error text-red-700"></p>
    </form>
  </template> --}}
</x-layout>
