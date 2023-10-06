<x-layout>
  <div class="flex justify-between items-center">
    <h1 class="dark:text-white text-2xl font-bold">Products</h1>
    <div class="mt-2">
      <a class="button button-default button-md" href="{{ route('productCreate') }}">Add Product</a>
    </div>
  </div>
  <section class="mt-5">
    <div id="product-table"></div>
  </section>

</x-layout>