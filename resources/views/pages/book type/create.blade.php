<x-layout>
  <div class="flex gap-2 items-center">
    <a href="{{ route('bookTypeIndex') }}" title="Go Back">
      <i class="dark:text-white fa-solid fa-arrow-left-long fa-xl"></i>
    </a>
    <h1 class="dark:text-white text-2xl font-bold">Add Book type</h1>
  </div>
  <section class="mt-5">
    <form method="POST" action="{{ route('bookTypeStore') }}" enctype="multipart/form-data">
      @csrf
      <section class="form-grid-3 mb-4">
        <x-textbox id="title" label="Title" name="title" value="{{ old('title') }}" error="{{ $errors->first('title') }}" />
      </section>
      <button type="submit" class="button button-default">
        Add
      </button>
    </form>
  </section>
</x-layout>