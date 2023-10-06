<x-layout>
  <div class="flex gap-2 items-center">
    <a href="{{ route('tournamentIndex') }}" title="Go Back">
      <i class="dark:text-white fa-solid fa-arrow-left-long fa-xl"></i>
    </a>
    <h1 class="dark:text-white text-2xl font-bold">Update Tournament</h1>
  </div>
  <section class="mt-5">
    <form method="POST" id="form" action="{{ route('tournamentUpdate', ['id' => $tournament->id]) }}" enctype="multipart/form-data">
      @csrf
      <section class="form-grid-3 mb-4">
        <x-textbox id="title" label="Title" name="title" value="{{ old('title', $tournament->title) }}" error="{{ $errors->first('title') }}" />
        <x-textbox id="number" type="number" label="Contact Number" name="number" value="{{ old('number', $tournament->number) }}" error="{{ $errors->first('number') }}" />
        <x-textbox id="start_date" type="date" label="Start Date" name="start_date" value="{{ old('start_date', $tournament->start_date) }}" error="{{ $errors->first('start_date') }}" />
        <x-textbox id="end_date" type="date" label="End Date" name="end_date" value="{{ old('end_date', $tournament->end_date) }}" error="{{ $errors->first('end_date') }}" />
        <x-textbox id="total_prize" type="number" label="Total Prize (Rs.)" name="total_prize" value="{{ old('total_prize', $tournament->total_prize) }}" error="{{ $errors->first('total_prize') }}" />
        <div>
          <label for="register" class="form-label">Register</label>
          <div class="flex gap-3 mt-4">
            <div class="flex items-center">
              <input {{ old('register', $tournament->register) ? old('register', $tournament->register) === '0' ? "checked" : "" : "checked" }} id="register-no" type="radio" value="0" name="register" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
              <label for="register-no" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">No</label>
            </div>
            <div class="flex items-center">
              <input {{ old('register', $tournament->register) === '1' ? "checked" : "" }} id="register-yes" type="radio" value="1" name="register" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
              <label for="register-yes" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Yes</label>
            </div>
          </div>
        </div>
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
    const images = <?php echo json_encode($tournament->images); ?>;
    const currentImageContainer = document.getElementById("currentImages");
    images.forEach((image, index) => {
      console.log(image);
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