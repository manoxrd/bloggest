@props(['href', 'company', 'filled' => false])

@php
  $filled ? $bgBody = 'bg-third !text-primary' : $bgBody = "";
@endphp

<a href="{{ $href }}" {{ $attributes->merge(['class' => 'text-third flex justify-center gap-3 items-center py-1 border-third border-3 rounded-md md:py-2   ' . $bgBody]) }}>
  <i class="fa-brands fa-{{ $company }}"></i>
  <p class="font-inter font-semibold">Continue with {{ $company }}</p>
</a>