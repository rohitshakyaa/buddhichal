<x-layout>
  <div class="flex gap-2 items-center">
    <a href="{{ route('teamChampionIndex') }}" title="Go Back">
      <i class="dark:text-white fa-solid fa-arrow-left-long fa-xl"></i>
    </a>
    <h1 class="dark:text-white text-2xl font-bold">Add Team Champion</h1>
  </div>
  <section class="mt-5">
    <form method="POST" action="{{ route('teamChampionStore') }}" enctype="multipart/form-data">
      @csrf
      <section class="form-grid-3 mb-4">
        <x-textbox id="priority" type="number" label="Priority" name="priority" value="{{ old('priority') }}" error="{{ $errors->first('priority') }}" />
        <x-textbox id="title" label="Title" name="title" value="{{ old('title') }}" error="{{ $errors->first('title') }}" />
        <x-textbox id="location" label="Location" name="location" value="{{ old('location') }}" error="{{ $errors->first('location') }}" />
        <x-textbox id="captain_name" label="Captain Name" name="captain_name" value="{{ old('captain_name') }}" error="{{ $errors->first('captain_name') }}" />
        <x-textbox id="phone_number" type="number" label="Phone Number" name="phone_number" value="{{ old('phone_number') }}" error="{{ $errors->first('phone_number') }}" />
        <x-textbox type="number" id="year" label="Year in BS" name="year" value="{{ old('year') }}" error="{{ $errors->first('year') }}" />
      </section>
      <div class="mb-4">
        <label class="form-label" for="images">Upload Images</label>
        <input accept="image/jpeg, image/jpg, image/png" class="file-input" id="images" name="images[]" type="file" multiple>
        @if($error = $errors->first('images'))
        <p class="error-text">{{ $error }}</p>
        @endif
      </div>
      <div class="mb-4">
        <div id="preview-img" class="grid xl:grid-cols-5 lg:grid-cols-4 md:grid-cols-3 grid-cols-2 gap-4"></div>
      </div>
      <button type="submit" class="button button-default">
        Add
      </button>
    </form>
  </section>

  <script>
    document.getElementById("images").addEventListener("change", function(e) {
      let imgPreviewPlaceholder = document.getElementById("preview-img");
      if (this.files) {
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