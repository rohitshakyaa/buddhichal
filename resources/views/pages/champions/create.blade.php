<x-layout>
  <div class="flex gap-2 items-center">
    <a href="{{ route('championIndex') }}" title="Go Back">
      <i class="dark:text-white fa-solid fa-arrow-left-long fa-xl"></i>
    </a>
    <h1 class="dark:text-white text-2xl font-bold">Create Champion</h1>
  </div>
  <section class="mt-5">
    <form method="POST" action="{{ route('championStore') }}" enctype="multipart/form-data">
      @csrf
      <section class="form-grid-3 mb-4">
        <x-textbox id="name" label="Name" name="name" value="{{ old('name') }}" error="{{ $errors->first('name') }}" />
        <x-textbox id="from_address" label="From Address" name="from_address" value="{{ old('from_address') }}" error="{{ $errors->first('from_address') }}" />
        <x-textbox id="game_at_address" label="Game At Address" name="game_at_address" value="{{ old('game_at_address') }}" error="{{ $errors->first('game_at_address') }}" />
        <div>
          <label for="gender" class="form-label">Gender</label>
          <div class="flex gap-3 mt-4">
            <div class="flex items-center">
              <input checked id="gender-male" type="radio" value="M" name="gender" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
              <label for="gender-male" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Male</label>
            </div>
            <div class="flex items-center">
              <input id="gender-female" type="radio" value="F" name="gender" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
              <label for="gender-female" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Female</label>
            </div>
          </div>
        </div>
        <x-textbox type="number" id="year" label="Year in BS" name="year" value="{{ old('year') }}" error="{{ $errors->first('year') }}" />
        <x-file-input id="image" label="Image" name="image" error="{{ $errors->first('image') }}" />
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