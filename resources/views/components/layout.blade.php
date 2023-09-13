<x-main-layout>
  <x-navbar />
  <x-sidebar />
  <div class="p-4 sm:ml-64 mt-14">
    <x-alert />
    {{ $slot }}
  </div>
</x-main-layout>