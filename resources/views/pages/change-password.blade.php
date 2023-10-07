<x-layout>
  <div class="flex flex-col items-center justify-center">
    <div class="w-full p-6 bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md dark:bg-gray-800 dark:border-gray-700 sm:p-8">
      <h2 class="mb-1 text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
        Change Password
      </h2>
      <form class="mt-4 space-y-4 lg:mt-5 md:space-y-5" action="{{ route('changePassword') }}" method="POST">
        @csrf
        <x-textbox id="current_password" label="Current Password" name="current_password" value="{{ old('current_password') }}" error="{{ $errors->first('current_password') }}" />
        <x-textbox id="new_password" label="New Password" name="new_password" value="{{ old('new_password') }}" error="{{ $errors->first('new_password') }}" />
        <x-textbox id="confirm_new_password" label="Confirm New Password" name="confirm_new_password" value="{{ old('confirm_new_password') }}" error="{{ $errors->first('confirm_new_password') }}" />

        <button type="submit" class="w-full text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Change password</button>
      </form>
    </div>
  </div>
  </section>
</x-layout>