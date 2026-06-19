<x-layout>

  <div class="flex justify-center items-center rounded-3xl h-60 md:h-70 lg:h-80 bg-stone-200 mt-3 overflow-hidden relative">

    <button type="button"
      class="text-white bg-black/50 absolute top-5 right-5 py-1.5 w-7 rounded-full flex justify-center delete-thumbnail">
      <i class="fa-regular fa-trash-can opacity-100"></i>
    </button>

    <img id="thumbnail-img" class="w-full h-full object-cover object-center" src="{{ $post->thumbnail_url }}"
      alt="thumbnail-preview">

    <label for="thumbnail" class="hidden">
      <i class="fa-solid fa-circle-plus text-7xl text-gray-800"></i>
    </label>

  </div>


  <x-container>

    <form id="editPostForm" data-type="thumbnail" action="{{ route('post.update', $post->slug) }}" method="POST"
      enctype="multipart/form-data" class="flex flex-col gap-10">
      @csrf
      @method('PATCH')

      <x-form.input name="thumbnail" type="file" class="sr-only" />
      <x-form.input name="title" :value="$post->title" class="font-abril" label="Title" />
      <x-rich-text::input name="body" id="body" value="{{ clean($post->body) }}" label="Content" />



      <div>


        <span class="font-bold">Choose your post tags:</span>

        <div id="postTagsHolder" class="flex gap-3 my-5 mx-auto justify-center flex-wrap">
          @foreach ($tags as $tag)
            @php

              $post->tags->contains($tag->id) ? ($active = 'tag-button-active') : ($active = '');

            @endphp

            <button type="button"
              class="{{ $active }} tag-button px-4 py-1 rounded-2xl bg-primary text-body border-1 border-body font-semibold cursor-pointer text-xs"
              data-id="{{ $tag->id }}">
              {{ $tag->tag }}
            </button>
          @endforeach
        </div>

      </div>



      <div id="inputHolder" class="invisible absolute">

        @foreach ($post->tags as $tag)
          <input name="tags[]" id="tags[]" value="{{ $tag->id }}" type="hidden" />
        @endforeach

      </div>



      <div class="flex flex-col gap-4">
        <x-form.submit>Update</x-form.submit>
        <x-primary-btn href="{{ '/@' . $post->user->username . '/' . $post->slug }}" type="secondary" >Cancel</x-primary-btn>
      </div>

    </form>

  </x-container>

</x-layout>
