<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="is-logged-in" content="{{ auth()->check() ? '1' : '0' }}">
  <title>Bloggest</title>

  @vite(['resources/css/app.css'])
  @vite(['resources/js/app.js'])
  <x-rich-text::styles />
  @stack('scripts')

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Abel&family=Abril+Fatface&family=Agdasima:wght@400;700&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
    rel="stylesheet">

</head>

<body class="bg-primary min-h-screen">

  @php
    $path = request()->path();
    $isHome = url()->current() === url('/');
    $isSearch = request()->is('search');
    $isBlog = request()->is('blog');
    $isCreate = request()->routeIs('post.create');
    $isProfile = auth()->check() && $path === '@' . auth()->user()->username;
    $isRegister = request()->routeIs('register');
    $profileUrl = auth()->check() ? url('/@' . auth()->user()->username) : route('login');
    $createPostUrl = auth()->check() ? route('post.create') : route('login');
  @endphp

  {{-- Fixed bottom nav must not be a flex child of the column layout (breaks position:fixed on iOS / some mobile browsers). --}}
  <div class="flex min-h-screen flex-col">
    <main class="container md:max-w-3xl lg:max-w-4xl mx-auto px-2 pt-3 pb-24 md:pb-3 flex-grow">

      <nav class="flex justify-between items-center relative">
        <a class="font-inter text-xl font-black" href="/">Bloggest</a>


        <div class="flex items-center gap-x-3">

          @auth
            @php

              $user = auth()->user();
            @endphp

            <a href="/{{ '@' . $user->username }}">
              <img src="{{ $user->profile_photo_url }}" alt="profile image" class="rounded-full h-8 " />
            </a>

          @endauth

          <div>

            <button type="button" class="dropdownMenu cursor-pointer">
              <span class="open">
                <i class="fa-solid fa-bars text-black text-2xl"></i>
              </span>

              <span class="close hidden">
                <i class="fa-solid fa-close text-black text-2xl"></i>
              </span>

            </button>
          </div>
        </div>

        <div
          class="menu absolute top-8 right-0 bg-primary rounded-2xl flex flex-col gap-y-3 font-semibold font-inter justify-start overflow-hidden z-50 hidden">
          @auth

            <a href="{{ route('post.create') }}"
              class="pl-3 pr-16 py-2 hover:bg-econdary hover:tex-primary border-transparent border-l-4 hover:border-black transition-all duration-500">Create
              Post</a>
          @endauth
          <a href="/blog"
            class="pl-3 pr-16 py-2 hover:bg-econdary hover:tex-primary border-transparent border-l-4 hover:border-black transition-all duration-500">Blog</a>
          <a href="/contact"
            class="pl-3 pr-16 py-2 hover:bg-econdary hover:tex-primary border-transparent border-l-4 hover:border-black transition-all duration-500">Contact</a>
          <a href="/about"
            class="pl-3 pr-16 py-2 hover:bg-econdary hover:tex-primary border-transparent border-l-4 hover:border-black transition-all duration-500">About</a>
        </div>
      </nav>



      {{ $slot }}
    </main>


    <footer class="bg-gradient-to-b from-primary from-19% to-22% to-body h-80 md:h-auto w-full pt-28 text-primary">
      <div class="md:max-w-3xl lg:max-w-4xl mx-auto  px-2 flex flex-col justify-between">

        <div class="flex justify-between mb-5">
          <a class="font-inter text-xl font-black" href="/">Bloggest</a>
          <div class="flex justify-between items-center gap-2">
            <i class="fa-brands fa-x-twitter"></i>
            <i class="fa-brands fa-square-facebook"></i>
            <i class="fa-brands fa-instagram"></i>
          </div>
        </div>

        <div class="font-abel">

          <div class="border-white border-b-1 pb-3 text-base">
            <ul class="flex justify-center gap-4">
              <li>Home</li>
              <li>Search</li>
              <li>Contact</li>
              <li>About us</li>
            </ul>
          </div>

          <div class="py-4 text-xs text-center">
            © 2025 Bloggest. All rights reserved.
          </div>
        </div>
      </div>
    </footer>



  </div>

  <nav class="fixed inset-x-0 bottom-0 z-[60] bg-primary md:hidden rounded-t-2xl shadow-[0px_-1px_5px_rgba(0,0,0,0.1)]"
    aria-label="Mobile">
    <div class="mx-auto flex max-w-lg items-end justify-around px-1">
      <a href="{{ url('/') }}"
        class="flex min-w-[3.25rem] flex-col items-center gap-0.5 rounded-lg px-1 font-inter text-2xs transition-colors {{ $isHome ? 'text-black' : 'text-body hover:text-black' }}"
        @if ($isHome) aria-current="page" @endif>
        <i class="fa-solid fa-house text-lg" aria-hidden="true"></i>
        <span>Home</span>
      </a>

      <a href="{{ route('blog') }}"
        class="flex min-w-[3.25rem] flex-col items-center gap-0.5 rounded-lg px-1 py-1 font-inter text-2xs transition-colors {{ $isBlog ? 'text-black' : 'text-body hover:text-black' }}"
        @if ($isBlog) aria-current="page" @endif>
        <i class="fa-solid fa-newspaper text-lg" aria-hidden="true"></i>
        <span>Blog</span>
      </a>

      <a href="{{ $createPostUrl }}"
        class="relative -top-3 mb-0.5 flex h-14 w-14 shrink-0 items-center justify-center rounded-full bg-secondary text-primary shadow-[0_6px_16px_rgba(0,0,0,0.35)] transition-transform active:scale-95"
        aria-label="{{ auth()->check() ? 'Create a new post' : 'Log in to create a post' }}"
        @if ($isCreate) aria-current="page" @endif>
        <i class="fa-solid fa-plus text-xl" aria-hidden="true"></i>
      </a>


      @auth
        <a href="{{ $profileUrl }}"
          class="flex min-w-[3.25rem] flex-col items-center gap-0.5 rounded-lg px-1 py-1 font-inter text-2xs transition-colors {{ $isProfile ? 'text-black' : 'text-body hover:text-black' }}"
          @if ($isProfile) aria-current="page" @endif>
          <i class="fa-solid fa-user text-lg" aria-hidden="true"></i>
          <span>Profile</span>
        </a>
      @endauth

      @guest
        <a href="{{ route('register') }}"
          class="flex min-w-[3.25rem] flex-col items-center gap-0.5 rounded-lg px-1 py-1 font-inter text-2xs transition-colors {{ $isRegister ? 'text-black' : 'text-body hover:text-black' }}"
          @if ($isRegister) aria-current="page" @endif>
          <i class="fa-solid fa-user text-lg" aria-hidden="true"></i>
          <span>Register</span>
        </a>
      @endguest

      <a href="{{ url('/support') }}"
        class="flex min-w-[3.25rem] flex-col items-center gap-0.5 rounded-lg px-1 py-1 font-inter text-2xs transition-colors {{ $isSearch ? 'text-black' : 'text-body hover:text-black' }}"
        @if ($isSearch) aria-current="page" @endif>
        <i class="fa-solid fa-message text-lg" aria-hidden="true"></i>
        <span>Support</span>
      </a>

    </div>
  </nav>
</body>


</html>
