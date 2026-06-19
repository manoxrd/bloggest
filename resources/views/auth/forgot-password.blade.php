<x-layout>
  <x-container class="my-20">

        <form method="POST" action="{{ route('password.email') }}" class="flex flex-col gap-8">
          @csrf
          
          <x-form.input name="email" type="email" placeholder="Email" label="Enter your email to reset your password" />

          <x-form.submit>Send</x-form.submit>
        </form>

  </x-container>
</x-layout>








{{-- 
<x-layout>
  <form action="{{ route('password.email') }}" method="POST">
    @csrf

    <label for="email">Enter your email to reset your password</label>
    <x-form.input name="email" type="email" />

    <input type="submit" value="Submit">
  </form>
</x-layout> --}}


