 <div>
     <label for="{{$id}}" class="form-label">{{$label}}</label>
     <input type="{{$type}}" name="{{$name}}" id="{{$id}}" placeholder="{{$placeholder}}" class="text-input @if($error) text-input-error @endif">
     @if($error)
     <p class="error-text">{{ $error }}</p>
     @endif
 </div>