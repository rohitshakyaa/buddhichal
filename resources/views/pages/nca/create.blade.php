<x-layout>
  <div class="flex gap-2 items-center">
    <a href="{{ route('ncaIndex') }}" title="Go Back">
      <i class="dark:text-white fa-solid fa-arrow-left-long fa-xl"></i>
    </a>
    <h1 class="dark:text-white text-2xl font-bold">Add NCA Member</h1>
  </div>
  <section class="mt-5">
    <form method="POST" action="{{ route('ncaStore') }}" enctype="multipart/form-data">
      @csrf
      <section class="form-grid-3 mb-4">
        <x-textbox id="name" label="Name" name="name" error="{{ $errors->first('name') }}" />
        <x-textbox id="phone_number" type="number" label="Phone Number" name="phone_number" error="{{ $errors->first('phone_number') }}" />
        <x-textbox id="post" type="text" label="Post" name="post" error="{{ $errors->first('post') }}" />
        <x-textbox id="email" type="email" label="Email" name="email" error="{{ $errors->first('email') }}" />
        <x-textbox id="position" type="number" label="Position" name="position" error="{{ $errors->first('position') }}" />
      </section>
      <div class="mb-4">
        <label class="form-label" for="image">Upload Image</label>
        <input accept="image/*" class="file-input" id="image" name="image" type="file">
      </div>
      <div class="mb-4">
        <div id="preview-img" class="w-64"></div>
      </div>
      <button type="submit" class="button button-default">
        Add
      </button>
    </form>
  </section>

  <script>
    document.getElementById("image").addEventListener("change", function(e) {
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