<x-layout>

  <x-container class="my-20">

    <form method="POST" action="{{ route('password.update') }}" class="flex flex-col gap-8">
      @csrf
      @method('PATCH')
      <input type="hidden" autocomplete="off" name="token" value="{{ $token }}">

  
      <x-form.input name="email" type="email" placeholder="Email" />
  
      <x-form.input name="password" type="password" placeholder="Password" />
      <x-form.input name="password_confirmation" type="password" placeholder="Password Confirmation" />
  
      <x-form.submit>Submit</x-form.submit>
    </form>

  </x-container>

</x-layout>