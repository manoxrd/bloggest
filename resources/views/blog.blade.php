<x-layout>
  <x-container>

    <x-header class="py-2" :withWhite="false">
      <x-heading>Stories That Inspire.</x-heading>
      <x-paragraph>Discover new perspectives, learn from experiences, or search for topics that matter to
        you.</x-paragraph>

      <form action="/search" method="GET" class="h-10 flex justify-center w-full">
        <x-buttoned-input class="w-full" name="search" :value="$search ?? ''">Search</x-buttoned-input>
      </form>
    </x-header>

    <div>



      <section id="posts" class="flex flex-col my-20 items-center gap-17">

        @if (isset($search))
          <div class="flex flex-col gap-6 w-full">

            <x-sub-heading>Search Results for "{{ $search }}"</x-sub-heading>

            <div class="flex flex-wrap justify-center md:justify-start -mx-4 lg:-mx-2 gap-y-16">
              @forelse ($posts as $post)
                <div class="w-full md:w-1/2 lg:w-1/2 px-4 lg:px-2 flex justify-center">
                  <x-post-card :post="$post" href="{{ '/@' . $post->user->username . '/' . $post->slug }}" />
                </div>
              @empty
                <x-empty>Sorry, There is no posts with the same results.</x-empty>
              @endforelse

            </div>
          </div>
        @else
          <div class="flex flex-col gap-6 w-full">
            <x-sub-heading>Recent Posts</x-sub-heading>

            <div class="flex flex-wrap justify-center md:justify-start -mx-4 lg:-mx-2 gap-y-16">
              @foreach ($posts as $post)
                <div class="w-full md:w-1/2 lg:w-1/2 px-4 lg:px-2 flex justify-center">
                  <x-post-card :post="$post" href="{{ '/@' . $post->user->username . '/' . $post->slug }}" />
                </div>
              @endforeach
            </div>

          </div>

          <div>{{ $posts->links() }}</div>

        @endif


      </section>


    </div>


  </x-container>
</x-layout>
