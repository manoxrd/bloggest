@props(['withWhite' => true])

<div {{ $attributes->merge(['class' => 'flex flex-col gap-6.5 my-40 text-center relative items-center ']) }}>
  {{ $slot }}
  
  @if ($withWhite)

  {{-- <div class="bg-white blur-xl w-full h-full absolute -z-4"></div>   --}}
  @endif
</div>