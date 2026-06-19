<x-layout>

  <div class="h-60 w-full bg-white absolute -z-20 top-0 right-0"> <!-- Increased height here -->
    <div class="h-full w-full absolute top-0 right-0 -z-10 bg-repeat"
      style="background-image: url(/images/hideout.svg); background-size: 40px 40px;">
    </div>
    <div class="h-full w-full bg-primary border-none rounded-4xl mt-40 shadow-[0_-4px_6px_-2px_rgba(0,0,0,0.25)]">
    </div>
  </div>

  <x-container class="mt-30">

    <div class="flex flex-col gap-10">

      <div class="font-inter flex flex-col gap-1">

        <div class="flex justify-between">

          <div class="flex flex-col gap-1">
            <div class="bg-primary -mt-23 rounded-full p-2 w-fit shadow-[0_-4px_6px_-2px_rgba(0,0,0,0.25)]">
              <img class="rounded-full w-36.5 aspect-square object-cover" src="{{ $user->profile_photo_url }}"
                alt="">
            </div>


          </div>

          <div class="flex pr-1 gap-2 font-bold text-xs md:text-sm md:gap-3 mt-2">

            @can('update', App\Models\User::class)
              <a href="/profile/edit" class="text-third uppercase">
                <i class="fa-regular fa-pen-to-square"></i>
                <span>Edit</span>
              </a>
            @endcan

            @can('delete', App\Models\User::class)
              <form action="/profile/destroy" method="POST">
                @csrf
                @method('DELETE')

                <button class="text-secondary uppercase">
                  <i class="fa-regular fa-trash-can"></i>
                  <span>Delete</span>
                </button>

              </form>
            @endcan

          </div>

        </div>

        <div class="flex flex-col gap-2">

          <div class="flex flex-col font-inter font-bold">
            <h2 class="text-2xl">{{ $user->name }}</h2>
            <p class="text-third text-sm">{{ '@' . $user->username }}</p>
          </div>

          <hr class="border-third">

          <div>
            <span class="text-third text-sm">ROLE:</span>
            <h3 class="tracking-wide">{{ $user->headline }}</h3>
          </div>

          <hr class="border-third">

          <div>
            <span class="text-third text-sm">ABOUT:</span>

            <div class="text-sm tracking-wide">
              {{ clean($user->bio) }}
            </div>
          </div>

        </div>

      </div>

      @php
        $type = request()->query('type');

      @endphp

      <div
        class="profile-nav flex -mx-2 font-inter font-semibold text-sm text-third shadow-[0px_2px_3px_rgba(0,0,0,.25)] w-screen relative left-1/2 right-1/2 -ml-[50vw] -mr-[50vw]">
        <button class="{{ $type !== 'comments' ? 'pn-active' : '' }} flex-1 py-4 pn-posts">Posts</button>
        <button class="{{ $type === 'comments' ? 'pn-active' : '' }} flex-1 py-4 pn-comments">Comments</button>
      </div>

      <div id="posts"
        class="flex flex-wrap justify-center md:justify-start -mx-4 lg:-mx-2 gap-y-16 {{ $type === 'comments' ? 'hidden' : '' }}">
        @forelse ($posts as $post)
          <div class="w-full md:w-1/2 lg:w-1/2 px-4 lg:px-2 flex justify-center">
            <x-post-card :href="route('post.show', ['user' => $post->user, 'post' => $post])" :post="$post" />
          </div>
        @empty
          <x-empty>No, Posts Found.</x-empty>
        @endforelse

        <div>{{ $posts->links() }}</div>
      </div>

      <div id="comments" class="flex flex-col items-center my-7 {{ $type !== 'comments' ? 'hidden' : '' }}">
        <div class="flex flex-col gap-15 w-full">

          @forelse ($comments as $comment)
            <x-comment-card :href="'/@' . $comment->post->user->username . '/' . $comment->post->slug" :comment="$comment" :toPost="true" />
          @empty
            <x-empty>No, Comments Found.</x-empty>
          @endforelse
        </div>

        <div class="mt-9">
          {{ $comments->links() }}
        </div>

      </div>

    </div>
  </x-container>

</x-layout>
