<x-layout>
  <x-container>

    <x-header :withWhite="false">

      <x-heading>Be Part of Our Blogging Family</x-heading>
      <x-paragraph>Sign up to share your stories, follow your favorite authors, and stay updated with the latest posts
      </x-paragraph>

    </x-header>

    <div class="flex flex-col mt-20 gap-10">

      <div class="flex flex-col gap-5"> 
        <x-auth.login-with company="google" href="https://google.com" />
        <x-auth.login-with :filled="true" company="facebook" href="https://facebook.com" />
      </div>

      <div class="flex justify-center items-center gap-3">
        <hr class="w-full border-body">
        <div class="text-lg font-abril text-body">OR</div>
        <hr class="w-full border-body">
      </div>

      <div>

        <form method="POST" action="/register" class="flex flex-col gap-8">
          @csrf

          <x-form.input name="name" placeholder="Full Name" />

          <div class="flex flex-col">
            <x-form.input name="headline" placeholder="Enter Your Headline" />
            <span class="text-sm italic text-gray-500">*Optional*</span>
          </div>

          <div class="flex flex-col gap-2">
            <span class="font-inter font-semibold">bio:</span>
            <x-rich-text::input id="bio" name="bio" toolbar="mini" />
          </div>
          <x-form.input name="username" placeholder="Username" />
          <x-form.input name="email" type="email" placeholder="Email" />
          <x-form.input name="password" type="password" placeholder="Password" />
          <x-form.input name="password_confirmation" type="password" placeholder="Password Confirmation" />

          <x-form.submit>Sign up</x-form.submit>
        </form>

      </div>

      <div class="flex flex-col justify-center text-center gap-1 mt-4">

        <p class="font-agdasima font-bold lg:text-lg">Already have an account?</p>
        <x-primary-btn class="w-full" type="secondary" href="{{ route('login') }}">Log In</x-primary-btn>

      </div>

    </div>

  </x-container>
</x-layout>
