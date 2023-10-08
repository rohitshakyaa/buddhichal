<x-layout>
  <div class="flex gap-2 items-center">
    <a href="{{ route('bannerIndex') }}" title="Go Back">
      <i class="dark:text-white fa-solid fa-arrow-left-long fa-xl"></i>
    </a>
    <h1 class="dark:text-white text-2xl font-bold">Create Banner</h1>
  </div>
  <section class="mt-5">
    <form method="POST" action="{{ route('bannerStore') }}" enctype="multipart/form-data">
      @csrf
      <section class="form-grid-3 mb-4">
        <x-textbox id="caption" label="Caption" name="caption" value="{{ old('caption') }}" error="{{ $errors->first('caption') }}" />
        <x-textbox id="link" label="Link" name="link" value="{{ old('link') }}" error="{{ $errors->first('link') }}" />
        <x-file-input id="image" accept="image/png, image/jpeg, image/jpg" label="Image" name="image" error="{{ $errors->first('image') }}" />
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