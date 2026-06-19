{{-- @props(['value' => fale]) --}}

<input {{ $attributes->merge(['class' => 'py-1 uppercase w-full rounded-btn font-bold text-base font-agdasima tracking-[5%] inset-shadow-btn shadow-btn bg-secondary text-primary md:text-lg ']) }} type="submit" value="{{ $slot }}">



