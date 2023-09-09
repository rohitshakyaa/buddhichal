<x-login-layout>
  <h1 class="text-center text-xl font-bold dark:text-white uppercase mb-3">LOGIN</h1>

  <form method="POST" action="/admin/login">
    @csrf
    <div class="mb-6">
      <label for="email" class="form-label">Email</label>
      <input type="email" name="email" id="email" placeholder="name@email.com" class="text-input @error('email') text-input-error @enderror">
      @error('email')
      <p class="error-text">{{ $message }}</p>
      @enderror
    </div>
    <div class="mb-6">
      <label for="password" class="form-label">
        Password
      </label>
      <input type="password" name="password" id="password" placeholder="*****" class="text-input @error('password') text-input-error @enderror">
      @error('password')
      <p class="error-text">{{ $message }}</p>
      @enderror
    </div>
    <div class="flex items-start mb-6">
      <div class="flex items-center h-5">
        <input id="remember" name="remember" type="checkbox" class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-blue-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800">
      </div>
      <label for="remember" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300 cursor-pointer">
        Remember Me
      </label>
    </div>
    <x-alert />
    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
      Login
    </button>
  </form>
</x-login-layout>