@props(['name', 'value' => ''])

<input name="{{ $name }}" id="{{ $name }}" value="{{ $value }}"
  class="rounded-br-none rounded-tr-none rounded-lg bg-[#D9D9D9] h-full focus:outline-none focus:border-3 focus:border-black px-2 md:w-full " />

<input
  class="rounded-bl-none rounded-tl-none rounded-lg px-5 bg-secondary text-primary uppercase font-bold text-base font-agdasima tracking-[5%] h-full"
  type="submit" value="{{ $slot }}">

@error($name)
  <p class="text-red-900 text-sm">{{ $message }}</p>
@enderror
