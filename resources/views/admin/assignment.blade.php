@extends('layouts.admin')
@section('content')

<!-- <div class="container mt-4 mb-4">
        <div class="row">
            <div class="col-md-5">
                <img src="{{asset('uploads/assignment.jpg')}}" class="img-fluid fixed-size-img" alt="Sample Image">
            </div>
            <div class="col-md-7">
                <form action="{{ route('register_assignment') }}" method="post" enctype="multipart/form-data">
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
                            <input type="text" name="pagenum" id="pagenum" class="form-control reg" placeholder="Page Number" value="{{ old('pagenum') }}">
                            @error('pagenum')
                            <div id="pagenumError" class="text-danger">{{ $message }}</div>
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
                            <div id="fileTypeLabel" ></div>
                            <div id="fileTypeLabelError" class="text-danger"></div> 
                        </div>
                    </div>
                    <div class="col-auto mt-3">
                        <button type="submit" class="btn btn-primary mb-2 reg">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div> -->

<div class="profile-settings-wrap">
        <form action="{{ route('admin_assignment_submit') }}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="profile-basic-info bg-white p-3">

                <div class="form-row">
                    <div class="form-group col-md-6 {{ $errors->has('name') ? ' has-error' : '' }}">
                        <label>{{__t('title_name')}}</label>
                        <input type="tel" class="form-control" name="name" value="" >
                        @if ($errors->has('name'))
                            <span class="invalid-feedback"><strong>{{ $errors->first('name') }}</strong></span>
                        @endif
                    </div>

                    <div class="form-group col-md-6 {{ $errors->has('colgname') ? ' has-error' : '' }}">
                        <label>{{__t('shoool_collage_name')}}</label>
                        <input type="text" class="form-control" name="colgname" value="">
                        @if ($errors->has('colgname'))
                            <span class="invalid-feedback"><strong>{{ $errors->first('colgname') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-5 {{ $errors->has('depname') ? ' has-error' : '' }}">
                        <label>{{__t('department_name')}}</label>
                        <input type="tel" class="form-control" name="depname" value="" >
                        @if ($errors->has('depname'))
                            <span class="invalid-feedback"><strong>{{ $errors->first('depname') }}</strong></span>
                        @endif
                    </div>

                    <div class="form-group col-md-5 {{ $errors->has('crsname') ? ' has-error' : '' }}">
                        <label>{{__t('course_name')}}</label>
                        <input type="text" class="form-control" name="crsname" value="">
                        @if ($errors->has('crsname'))
                            <span class="invalid-feedback"><strong>{{ $errors->first('crsname') }}</strong></span>
                        @endif
                    </div>

                    <div class="form-group col-md-2">
                        <label>{{__t('pages')}}</label>
                        <input type="text" class="form-control" name="pagenum" id="pagenum" value="">
                    </div>
                </div>


                <div class="form-row">
                    <div class="form-group col-md-7">
                        <label>{{__t('description')}}</label>
                        <textarea class="form-control" name="desc" id="description" rows="3"></textarea>
                    </div>

                    <div class="form-group col-md-5">
                    <label>{{__t('select_assignment')}}</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" name="assignments" class="custom-file-input" id="inputGroupFileAdmin">
                                    <label class="custom-file-label" for="inputGroupFileAdmin">Choose file</label>
                                </div>
                            </div>
                            @error('assignments')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                            <div id="fileTypeLabel" ></div>
                            <div id="fileTypeLabelError" class="text-danger"></div> 
                        </div>
                </div>

            </div>

            <button type="submit" class="btn btn-purple btn-lg mt-2"> Submit Assignment</button>
        </form>


    </div>

    <script>
        document.getElementById('inputGroupFileAdmin').addEventListener('change', handleFileInputChange);

        function handleFileInputChange() {
            var fileInput = document.getElementById('inputGroupFileAdmin');
            var file = fileInput.files[0];
            var fileName = fileInput.value.split('\\').pop();
            var fileType = file ? file.type : null;

            // Display filename below the file input if it's a PDF or DOC/DOCX file
            if (fileType === 'application/pdf' || fileName.toLowerCase().endsWith('.pdf')) {
                document.getElementById('fileTypeLabel').textContent = fileName;
                document.getElementById('fileTypeLabelError').textContent = '';
            } else {
                document.getElementById('fileTypeLabel').textContent = '';
                document.getElementById('fileTypeLabelError').textContent = 'Only pdfs are allowed';
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            var pagenumInput = document.getElementById('pagenum');

            pagenumInput.addEventListener('input', function () {
                var inputValue = pagenumInput.value;

                // Remove non-numeric characters using regex
                var numericValue = inputValue.replace(/\D/g, '');

                // Update input value with only numeric characters
                pagenumInput.value = numericValue;

                // Display error if non-numeric characters were entered
                var errorDiv = document.getElementById('pagenumError');
                if (inputValue !== numericValue) {
                    errorDiv.textContent = 'Please enter only numbers.';
                } else {
                    errorDiv.textContent = '';
                }
            });
        });
    </script>

@endsection