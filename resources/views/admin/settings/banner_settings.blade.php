@extends('layouts.admin')

@section('content')
<form action="{{route('upload_banners')}}" enctype="multipart/form-data" method="post">@csrf
    <div class="form-group row">
        <div class="col-sm-8">
            <div class="input-group">
                <div class="custom-file">
                    <input type="file" name="banner_file[]" multiple="" class="custom-file-input" id="inputGroupFile" >
                    <label class="custom-file-label" id="numfiles" for="inputGroupFile">Choose file</label>
                </div>
            </div>
            <div id="filePreview"></div>
        </div>

        <div class="text-center">
        <button type="submit" id="uploadAssignmentFile" class="btn btn-primary">Upload <i class="la la-upload"></i></button>
    </div>
    </div>
</form>

<div class="row media-manager-grid-wrap">
    @foreach ($files as $file)
    <div class="col">
        <img class="card-img-top-i" src="{{asset('uploads/banner/'.$file->file_name)}}" alt="signature.png" title="signature.png">
    </div>
        @endforeach
</div>


@endsection