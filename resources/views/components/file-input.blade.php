 <div>
     <label for="{{$id}}" class="form-label">{{$label}}</label>
     <input accept="image/*" class="file-input @if($error) text-input-error @endif" name="{{$name}}" id="{{$id}}" type="file">
     @if($error)
     <p class="error-text">{{ $error }}</p>
     @endif
 </div>