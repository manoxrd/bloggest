@props(['name', 'type' => 'text', 'value' => old($name), 'label' => ''])

<div>
  @if ($type === 'password')
    @php
      $passwordClasses = ' password-input ';
    @endphp

    <div class="relative password-container">
  @endif

  @if ($label)
    <label for="{{ $name }}" class="font-semibold font-inter">{{ $label }}</label>
  @endif

  <input
    {{ $attributes->merge(['class' => $type !== 'file' ? 'outline-primary border-third border-3 rounded-md py-1 px-2 w-full' . ($passwordClasses ?? ' ') : 'sr-only']) }}
    type="{{ $type }}" name="{{ $name }}" id="{{ $name }}"
    value="{{ $type !== 'password'  && $type !== 'file' ? $value : '' }}">



  @if ($type === 'password')
    <button type="button" class="showPassword absolute top-1.5 right-3 z-50">
      <i class="fa-solid fa-eye text-third showPassword-icon"></i>
    </button>

</div>
@endif

@error($name)
  <p class="text-red-900 text-sm">{{ $message }}</p>
@enderror
</div>
