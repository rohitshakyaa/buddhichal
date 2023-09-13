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
        <x-textbox id="caption" label="Caption" name="caption" error="{{ $errors->first('caption') }}" />
        <x-textbox id="link" label="Link" name="link" error="{{ $errors->first('link') }}" />
        <div>
          <label class="form-label" for="image">Upload Image</label>
          <input accept="image/*" class="file-input" id="image" name="image" type="file">
        </div>
      </section>
      <div class="mb-4">
        <div id="preview-img" class="w-64"></div>
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
        imageDiv.innerHTML = "";
        let filesAmount = this.files.length;
        for (i = 0; i < filesAmount; i++) {
          var reader = new FileReader();
          reader.onload = (event) => {
            const imageDiv = document.createElement('div');
            const imageTag = document.createElement('img');
            imageTag.src = event.target.result;
            imageTag.classList.add("w-full");
            imageDiv.appendChild(imageTag);
            imgPreviewPlaceholder.appendChild(imageDiv);
          }
          reader.readAsDataURL(this.files[i]);
        }
      }
    });
  </script>
</x-layout>