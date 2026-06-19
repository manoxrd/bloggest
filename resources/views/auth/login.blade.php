<x-layout>


  <x-container>
    <x-header :withWhite="false">

      <x-heading>Welcome Back to Your Family</x-heading>
      <x-paragraph>Log in to continue reading, commenting, and sharing your favorite posts
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

        <form method="POST" action="/login" class="flex flex-col gap-8">
          @csrf
          
          <x-form.input name="email" type="email" placeholder="Email" />
          <x-form.input name="password" type="password" placeholder="Password" />

          <x-form.submit>Log In</x-form.submit>
        </form>

        <div class="flex justify-center">
          <a href="{{ route('password.request') }}" class="px-2 border-b-2 border-third text-third font-abel font-black text-center mt-3 text-sm lg:text-base">Forgot Your Password?
          </a>
        </div>

      </div>

      <div class="flex flex-col justify-center text-center gap-1 mt-4">

        <p class="font-agdasima font-bold lg:text-lg">You don't have an account?</p>
        <x-primary-btn class="w-full" type="secondary" href="{{ route('register') }}">Sign Up</x-primary-btn>

      </div>

    </div>

  </x-container>

</x-layout>
