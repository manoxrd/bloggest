<x-layout>
  <h2>Show Posts that has this tag: {{ $tag }}</h2>

  <div>
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
      <h2>There is no posts with this tag name</h2>
    @endforelse
  </div>
</x-layout>
