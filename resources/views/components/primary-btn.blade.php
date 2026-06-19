@props(['href', 'type' => 'primary', 'tag' => 'a'])

@php
  $style = ($type === 'primary') ? ' bg-secondary text-primary ' : ' bg-transparent text-black border-2 border-black ';

@endphp

<{{ $tag }} @if($tag === 'a') href="{{ $href }}" @endif {{ $attributes->merge(['class' => 'text-center px-6 py-1 uppercase rounded-btn font-bold text-base font-agdasima tracking-[5%] inset-shadow-btn shadow-btn lg:text-lg' . $style]) }}>
{{ $slot }}
</{{ $tag }}>