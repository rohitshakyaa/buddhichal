<x-layout>
  <div class="flex gap-2 items-center">
    <a href="{{ route('bookTypeIndex') }}" title="Go Back">
      <i class="dark:text-white fa-solid fa-arrow-left-long fa-xl"></i>
    </a>
    <h1 class="dark:text-white text-2xl font-bold">Edit Book type</h1>
  </div>
  <section class="mt-5">
    <form method="POST" action="{{ route('bookTypeUpdate', $bookType->id) }}" enctype="multipart/form-data">
      @csrf
      <section class="form-grid-3 mb-4">
        <x-textbox id="key" label="Key" name="key" value="{{ old('key', $bookType->key) }}" error="{{ $errors->first('key') }}" />
        <x-textbox id="title" label="title" name="title" value="{{ old('title', $bookType->title) }}" error="{{ $errors->first('title') }}" />
      </section>
      <button type="submit" class="button button-default">
        Update
      </button>
    </form>
  </section>
</x-layout>