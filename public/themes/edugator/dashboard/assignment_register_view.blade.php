
@extends(theme('dashboard.layout'))
@section('content')
<div class="profile-settings-wrap">
        <h4 class="mb-3">{{__t('create_assignment')}}</h4>
        <form action="{{ route('register_assignment') }}" method="post" enctype="multipart/form-data">
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
