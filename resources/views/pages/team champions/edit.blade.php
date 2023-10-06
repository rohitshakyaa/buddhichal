<x-layout>
  <div class="flex gap-2 items-center">
    <a href="{{ route('teamChampionIndex') }}" title="Go Back">
      <i class="dark:text-white fa-solid fa-arrow-left-long fa-xl"></i>
    </a>
    <h1 class="dark:text-white text-2xl font-bold">Update Team Champion</h1>
  </div>
  <section class="mt-5">
    <form method="POST" id="form" action="{{ route('teamChampionUpdate', ['id' => $teamChampion->id]) }}" enctype="multipart/form-data">
      @csrf
      <section class="form-grid-3 mb-4">
        <x-textbox id="priority" type="number" label="Priority" name="priority" value="{{ old('priority', $teamChampion->priority) }}" error="{{ $errors->first('priority') }}" />
        <x-textbox id="title" label="Title" name="title" value="{{ old('title', $teamChampion->title) }}" error="{{ $errors->first('title') }}" />
        <x-textbox id="location" label="Location" name="location" value="{{ old('location', $teamChampion->location) }}" error="{{ $errors->first('location') }}" />
        <x-textbox id="captain_name" label="Captain Name" name="captain_name" value="{{ old('captain_name', $teamChampion->captain_name) }}" error="{{ $errors->first('captain_name') }}" />
        <x-textbox id="phone_number" type="number" label="Phone Number" name="phone_number" value="{{ old('phone_number', $teamChampion->phone_number) }}" error="{{ $errors->first('phone_number') }}" />
        <x-textbox type="number" id="year" label="Year in BS" name="year" value="{{ old('year', $teamChampion->year) }}" error="{{ $errors->first('year') }}" />
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
      <div>
        <p class="mb-2 font-semibold text-lg">Current Images: </p>
        <div id="currentImages" class="grid xl:grid-cols-5 lg:grid-cols-4 md:grid-cols-3 grid-cols-2 gap-4"></div>
      </div>

      <button type="submit" class="button button-default mt-3">
        Update
      </button>
    </form>
  </section>

  <script>
    const images = <?php echo json_encode($teamChampion->images); ?>;
    const currentImageContainer = document.getElementById("currentImages");
    images.forEach((image, index) => {
      const imageDiv = document.createElement('div');
      imageDiv.setAttribute("class", "relative");
      imageDiv.id = `currentImage${index}`;
      const imageTag = document.createElement('img');
      imageTag.src = image.image_path;
      imageTag.classList.add("w-full");
      imageDiv.appendChild(imageTag);
      const crossIcon = document.createElement("div");
      crossIcon.title = "Remove this image";
      crossIcon.setAttribute("class", "absolute -top-2 -right-2 w-5 h-5 rounded-full border bg-gray-100 text-black flex justify-center items-center hover:bg-gray-200 cursor-pointer dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:text-xs")
      const icon = document.createElement("i");
      icon.setAttribute("class", "fa-solid fa-times");

      crossIcon.addEventListener("click", () => {
        const inputField = document.createElement("input");
        inputField.hidden = true;
        inputField.name = "removedImageIds[]";
        inputField.value = image.id;
        form.appendChild(inputField);
        document.getElementById(`currentImage${index}`)?.remove();
      });

      crossIcon.appendChild(icon);
      imageDiv.appendChild(crossIcon);
      currentImageContainer.appendChild(imageDiv);
    })



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