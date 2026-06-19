@props(['href'])

<a href="{{ $href }}" {{ $attributes->merge(['class' => 'z-10 border-black border-1 font-adril text-black text-xs min-w-fit px-2.5 py-1 rounded-full lg:text-sm ']) }}>
 {{ $slot }}
</a>
