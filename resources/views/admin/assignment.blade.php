@extends('layouts.admin')


@section('content')

<div class="container mt-4 mb-4">
    <form action="{{ route('admin_assignment_submit') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="form-row">
            <div class="col mt-2">
                <input type="text" name="name" class="form-control reg" placeholder="Title / Name" value="{{ old('name') }}">
                @error('name')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col mt-2">
                <input type="text" name="colgname" class="form-control reg" placeholder="School / Collage Name" value="{{ old('colgname') }}">
                @error('colgname')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col mt-2">
                <input type="text" name="depname" class="form-control reg" placeholder="Department Name" value="{{ old('depname') }}">
                @error('depname')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="form-row">
            <div class="col mt-2">
                <input type="text" name="crsname" class="form-control reg" placeholder="Course Name" value="{{ old('crsname') }}">
                @error('crsname')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col mt-2">
                <input type="text" name="pagenum" class="form-control reg" placeholder="Page Number" value="{{ old('pagenum') }}">
                @error('pagenum')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="form-row">
            <div class="col mt-2">
                <div class="form-group">
                    <textarea class="form-control reg" name="desc" placeholder="Description" id="description" rows="3">{{ old('desc') }}</textarea>
                    @error('desc')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="col mt-2">
                <div class="input-group">
                    <div class="custom-file">
                        <input type="file" name="assignments" class="custom-file-input" id="inputGroupFileAdmin">
                        <label class="custom-file-label" for="inputGroupFileAdmin">Choose file</label>
                    </div>
                </div>
                @error('assignments')
                <div class="text-danger">{{ $message }}</div>
                @enderror
                <div id="fileTypeLabel" ></div> <!-- Display filename here -->
                <div id="fileTypeLabelError" class="text-danger"></div> 
            </div>
        </div>
        <div class="col-auto mt-3">
            <button type="submit" class="btn btn-primary mb-2 reg">Submit</button>
        </div>
    </form>

    <script>
        document.getElementById('inputGroupFileAdmin').addEventListener('change', handleFileInputChange);

        function handleFileInputChange() {
            var fileInput = document.getElementById('inputGroupFileAdmin');
            var file = fileInput.files[0];
            var fileName = fileInput.value.split('\\').pop();
            var fileType = file ? file.type : null;

            // Display filename below the file input if it's a PDF or DOC/DOCX file
            if (fileType === 'application/pdf' || fileName.toLowerCase().endsWith('.pdf') ||
                fileType === 'application/msword' || fileType === 'application/vnd.openxmlformats-officedocument.wordprocessingml.document' ||
                fileName.toLowerCase().endsWith('.doc') || fileName.toLowerCase().endsWith('.docx')) {
                document.getElementById('fileTypeLabel').textContent = fileName;
                document.getElementById('fileTypeLabelError').textContent = '';
            } else {
                document.getElementById('fileTypeLabel').textContent = '';
                document.getElementById('fileTypeLabelError').textContent = 'Only pdf and docs are allowed';
            }
        }
    </script>

</div>

@endsection