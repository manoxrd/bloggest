<x-layout>

  <div class="flex justify-center items-center rounded-3xl h-60 md:h-70 lg:h-80 bg-stone-200 mt-3 overflow-hidden relative">

    <button type="button" class="text-white bg-black/50 absolute top-5 right-5 py-1.5 w-7 rounded-full flex justify-center invisible delete-thumbnail">
      <i class="fa-regular fa-trash-can opacity-100"></i>
    </button>
    

    <img id="thumbnail-img" class="w-full h-full object-cover object-center hidden"
      src="" alt="thumbnail-preview">

    <label for="thumbnail">
      <i class="fa-solid fa-circle-plus text-7xl text-gray-800"></i>
    </label>
  </div>

  <x-container>


    <form id="createPostForm" data-type="thumbnail" action="{{ route('post.store') }}" method="POST" enctype="multipart/form-data"
      class="flex flex-col gap-10">
      @csrf

      <x-form.input name="thumbnail" type="file" class="sr-only" />
      <x-form.input name="title" label="Title" placeholder="Web Development..." class="font-abril" />
      <x-rich-text::input name="body" id="body" :value="old('body')" label="Content" />

      <hr>
      <div>


        <span class="font-bold">Choose your post tags:</span>

        <div id="postTagsHolder" class="flex gap-3 my-5 mx-auto justify-center flex-wrap">
          @foreach ($tags as $tag)
            <button type="button"
              class="tag-button px-4 py-1 rounded-2xl bg-primary text-body border-1 border-body font-semibold cursor-pointer text-xs"
              data-id="{{ $tag->id }}">
              {{ $tag->tag }}
            </button>
          @endforeach
        </div>

      </div>

      <div id="inputHolder" class="invisible absolute"></div>


      <x-form.submit>Publish</x-form.submit>
    </form>

  </x-container>
</x-layout>
