




@props(['href', 'post'])

{{-- 1. Ensure 'w-full' is here so it fills the wrapper we made above --}}
<div {{ $attributes->merge(['class' => 'relative flex flex-col w-full rounded-2xl shadow-post-card overflow-hidden bg-primary']) }}>
  <a href="{{ $href }}" class="absolute inset-0 z-20"></a>
  
  {{-- 2. Wrap the image in a div with a fixed height to prevent "big photo" issues --}}
  <div class="h-52 w-full overflow-hidden">
    <img src="{{ $post->thumbnail_url }}" alt=""
      class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105" loading="lazy">
  </div>

  <div class="text-white px-6 py-3 flex flex-col gap-3 overflow-hidden">
    {{-- Meta Info --}}
    <div class="font-inter text-body text-xs flex gap-2">
      <span>{{ $post->created_at->diffForHumans() }}</span>
      <span>|</span>
      <span>By. <a href="{{ '/@' . $post->user->username }}" class="relative z-30 hover:underline">{{ $post->user->name }}</a></span>
    </div>

    {{-- Title and Subtext --}}
    <div class="flex flex-col gap-0.5 lg:gap-2">
      <h3 class="text-xl font-abril leading-7 text-black tracking-wide truncate lg:text-2xl">{{ $post->title }}</h3>
      <div class="text-body text-sm line-clamp-2 truncate">{{ clean($post->body) }}</div>
    </div>

    {{-- Tags --}}
    <div class="flex gap-2 pointer-events-auto flex-wrap mt-3 relative z-30">
      @foreach ($post->tags as $tag)
        <x-tag href="/tags/{{ $tag->tag }}">{{ $tag->tag }}</x-tag>
      @endforeach
    </div>
  </div>
</div>