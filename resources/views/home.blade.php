<x-layout>

  <x-container>


    <div>

      <x-header>
        @guest
        <x-heading>Every Story Matters. Add Yours.</x-heading>
        <x-paragraph>A platform built for thinkers, creators, and storytellers. Share what matters to you — one post at
          a
          time.
        </x-paragraph>
        <x-primary-btn href="{{ route('register') }}">Start Writing</x-primary-btn>
        @endguest
        
        @auth
        <x-heading>Ready to share your story?.</x-heading>
        <x-paragraph>Your dashboard is looking a little quiet. Start your journey by creating your very first post and let the world hear what you have to say.
        </x-paragraph>
          <x-primary-btn href="{{ route('post.create') }}">Create My First Post</x-primary-btn>
        @endauth

      </x-header>

      <div
        class="bg-white bg-repeat absolute top-0 right-0 w-full h-139 -z-10 [clip-path:polygon(0%_0%,_0%_100%,_100%_38.9%,_100%_0%)] overflow-hidden"
        style="background-image: url(/images/hideout.svg); background-size: 40px 40px;">
      </div>
    </div>


    <section id="posts" class="flex flex-col items-center gap-17">
      <div class="flex flex-col gap-6 w-full">
        <x-sub-heading>Featured Posts</x-sub-heading>

        {{-- The Parent Container --}}
        <div class="flex flex-wrap justify-center md:justify-start -mx-4 lg:-mx-2 gap-y-16">
          @foreach ($posts as $post)
            {{-- The "Column" Wrapper: Controls the 2-column logic --}}
            <div class="w-full md:w-1/2 lg:w-1/2 px-4 lg:px-2 flex justify-center">
              <x-post-card class="md:max-w-[500px] w-full" :post="$post"
                href="{{ '/@' . $post->user->username . '/' . $post->slug }}" />
            </div>
          @endforeach
        </div>
      </div>

      <x-primary-btn href="/blog">Explore More</x-primary-btn>
    </section>


  </x-container>


  <section id="newsletter" style="background-image: url('images/newsletter_image.svg');"
    class="bg-cover bg-top mt-36 py-20">
    <div class="flex flex-col items-center gap-10 md:px-30 text-center">

      <div class="flex flex-col gap-2 items-center">
        <h2 class="text-3xl font-abril">Join Our Newsletter</h2>
        <x-paragraph>Get the latest stories and updates every week.</x-paragraph>
      </div>

      <form method="POST" action="/newsletter" class="h-10 md:w-full flex">
        <x-buttoned-input name="newsletter-email">Send</x-buttoned-input>
      </form>

    </div>
  </section>
  {{-- 
  @auth
    <div class="flex justify-between">
      <h1>search for anything</h1>

      <form action="/search" method="GET">
        <x-form.input name="search" placeholder="Web Developer..." />
        <input type="submit" value="Search">
      </form>

      <a href="/blog/create">Create a New Post</a>
    </div>

    @foreach ($posts as $post)
      <a href="{{ '/@' . $post->user->username . '/' . $post->slug }}">

        <div class="bg-amber-500 text-white">
          <img src="{{ $post->thumbnail_url }}" alt="">
          <h3>{{ $post->title }}</h3>
          <p class="text-red-500">by {{ $post->user->name }}</p>
          <p></p>
        </div>
      </a>
    @endforeach


    <form action="/logout" method="POST">
      @csrf
      @method('DELETE')

      <input type="submit" value="Logout" class="bg-red-900 text-white py-4 px-6">

    </form>
  @endauth --}}

</x-layout>
