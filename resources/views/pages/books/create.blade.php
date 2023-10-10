<x-layout>
  <div class="flex gap-2 items-center">
    <a href="{{ route('bookIndex') }}" title="Go Back">
      <i class="dark:text-white fa-solid fa-arrow-left-long fa-xl"></i>
    </a>
    <h1 class="dark:text-white text-2xl font-bold">Create Chess Book</h1>
  </div>
  <section class="mt-5">
    <form method="POST" action="{{ route('bookStore') }}" enctype="multipart/form-data">
      @csrf
      <section class="form-grid-3 mb-4">
        <x-textbox id="name" label="Name" name="name" value="{{ old('name') }}" error="{{ $errors->first('name') }}" />
        <div>
          <label for="type_id" class="form-label">Book Type</label>
          <select id="" name="type_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            @foreach($types as $type)
            <option value="{{ $type->id }}" {{ old('type_id') === $type->id ? "selected" : "" }}>{{ $type->title }}</option>
            @endforeach
          </select>
          @if($error = $errors->first('type_id'))
          <p class="error-text">{{ $error }}</p>
          @endif
        </div>
        <div>
          <x-file-input id="image" accept="image/jpg, image/jpeg, image/png" label="Image" name="image" error="{{ $errors->first('image') }}" />
        </div>
        <x-file-input id="book-file" accept="application/pdf" label="Book File" name="book_file" error="{{ $errors->first('book_file') }}" />
      </section>
      <div id="imageDiv" class="mb-4 hidden">
        <label class="form-label">Preview Image: </label>
        <div id="" class="w-64">
          <img id="preview-img" src="" alt="">
        </div>
      </div>
      <button type="submit" class="button button-default">
        Create
      </button>
    </form>
  </section>

  <script>
    document.getElementById("image").addEventListener("change", function(e) {
      let imgPreviewPlaceholder = document.getElementById("preview-img");
      if (this.files) {
        imageDiv.classList.remove("hidden");
        let filesAmount = this.files.length;
        for (i = 0; i < filesAmount; i++) {
          var reader = new FileReader();
          reader.onload = (event) => {
            imgPreviewPlaceholder.src = event.target.result;
          }
          reader.readAsDataURL(this.files[i]);
        }
      } else {
        imageDiv.classList.add("hidden");
      }
    });
  </script>
</x-layout>