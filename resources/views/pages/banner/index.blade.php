<x-layout>
  <div class="flex justify-between items-center">
    <h1 class="dark:text-white text-2xl font-bold">Banners</h1>
    <div class="mt-2">
      <a class="button button-default button-md" href="{{ route('bannerCreate') }}">Add Banner</a>
    </div>
  </div>
  <section class="mt-5">
    <div id="banner-table"></div>
  </section>

</x-layout>