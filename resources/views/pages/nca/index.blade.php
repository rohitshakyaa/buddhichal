<x-layout>
  <div class="flex justify-between items-center">
    <h1 class="dark:text-white text-2xl font-bold">Nepal Chess Association Members</h1>
    <div class="mt-2">
      <a class="button button-default button-md" href="{{ route('ncaCreate') }}">Add NCA Member</a>
    </div>
  </div>
  <section class="mt-5">
    <div id="nca-member-table"></div>
  </section>

</x-layout>