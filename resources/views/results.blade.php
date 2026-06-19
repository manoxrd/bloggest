<x-layout>
  <div class="flex justify-between">
    <h1>search for anything</h1>

    <form action="/search" method="GET">
      <x-form.input name="search" value="{{ $search }}" placeholder="Web Developer..." />
      <input type="submit" value="Search">
    </form>
  </div>

  <div>
    <h1>Your Search Results:</h1>
    @forelse ($posts as $post)
    <a href="{{ '/@' . $post->user->username . '/' . $post->slug }}">

      <div class="bg-amber-500 text-white">
        <img src="{{ $post->thumbnail_url }}" alt="">
        <h3>{{ $post->title }}</h3>
        <p class="text-red-500">by {{ $post->user->name }}</p>
        <p></p>
      </div>
    </a>
    @empty
      <h2>Sorry, No posts with that title</h2>
    @endforelse
  </div>
</x-layout>
