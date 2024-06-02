@extends(theme('dashboard.layout'))
@section('content')

<h1 class="display-6 blockquote text-center">Upload Assignment</h1>
<form id="uploadAssignmentForm" enctype="multipart/form-data">
    @csrf
    <div class="input-group">
      <div class="custom-file">
        <input type="file" name="file[]" class="custom-file-input" id="assignmentFile">
        <label class="custom-file-label" for="assignmentFile">Choose file</label>
      </div>
    </div>
    <div class="text-center mt-3">
        <button type="button" id="uploadAssignmentFile" class="btn btn-primary">Submit</button>
    </div>
</form>

@endsection
