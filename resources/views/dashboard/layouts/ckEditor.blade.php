<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jodit/3.1.92/jodit.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jodit/3.1.92/jodit.min.js"></script>

<textarea name="{{$field}}" id="{{$field}}-Jodit" class="form-control"style='height:200px' >{{ old('description') }}</textarea>
<script>  var editor = new Jodit('#{{$field}}-Jodit');</script>
