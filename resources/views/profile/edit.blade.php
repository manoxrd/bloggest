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

      <form id="editProfile" data-type="avatar" method="POST" action="/profile/edit" enctype="multipart/form-data"
        class="font-inter flex flex-col gap-5">
        @csrf
        @method('PATCH')

        <div class="flex justify-between">

          <div
            class="flex flex-col gap-1 relative bg-primary -mt-23 rounded-full p-2 w-fit shadow-[0_-4px_6px_-2px_rgba(0,0,0,0.25)]">

            <button type="button"
              class="text-white bg-black/50 absolute top-4 right-4 py-1.5 w-7 rounded-full flex justify-center  delete-avatar">
              <i class="fa-regular fa-trash-can opacity-100"></i>
            </button>
            <img id="avatar-img" class="rounded-full w-36.5 aspect-square object-cover"
              src="{{ $user->profile_photo_url }}" alt="">

            <label for="avatar"
              class="hidden bg-black/50 flex justify-center items-center h-36.5 w-36.5 rounded-full">
              <i class="fa-solid fa-plus text-white text-3xl"></i>
            </label>
          </div>

          <x-form.input name="avatar" type="file" value="{{ $user->avatar }}" />

        </div>

        <div class="flex flex-col gap-13">

          <div class="flex flex-col gap-4 font-bold">
            <x-form.input name="name" value="{{ $user->name }}" class="text-2xl" />

            <x-form.input name="username" value="{{ $user->username }}" class="" />

            <x-form.input name="headline" value="{{ $user->headline }}" class="tracking-wide" />
          </div>

          {{-- <div class="text-sm text-third tracking-wide"> --}}
          <x-rich-text::input id="bio" name="bio" class="block w-full" toolbar="mini" :value="clean($user->bio?->toEditorHtml())"
            autocomplete="off" />
          {{-- {{ clean($user->bio) }} --}}
          {{-- </div> --}}

        </div>


        <x-form.submit>Update</x-form.submit>


        <x-primary-btn href="{{ '/@' . $user->username }}" type="secondary"
          class="w-full text-center">Cancel</x-primary-btn>

      </form>


    </div>
  </x-container>

</x-layout>
