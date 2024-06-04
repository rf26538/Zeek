@extends('layouts.theme')
@section('content')

<div class="container mt-4 mb-4">
<h1 class="display-4 text-center">Assignment</h1>
    <form action="{{route('register_assignment')}}" method="post" enctype="multipart/form-data">@csrf
      <div class="form-row">
        <div class="col mt-2">
          <input type="text" name="name" class="form-control reg" placeholder="Title / Name">
        </div>
        <div class="col mt-2">
          <input type="text" name="colgname" class="form-control reg" placeholder="School / Collage Name">
        </div>
        <div class="col mt-2">
          <input type="text" name="depname" class="form-control reg" placeholder="Department Name">
        </div>
    </div>
    <div class="form-row">
          <div class="col mt-2">
            <input type="text" name="crsname" class="form-control reg" placeholder="Course Name">
          </div>
        <div class="col mt-2">
          <input type="text" name="pagenum" class="form-control reg" placeholder="Page Number">
        </div>
      </div>
      <div class="form-row">
        <div class="col mt-2">
          <div class="form-group">
            <textarea class="form-control reg" name="desc" placeholder="Description" id="description" rows="3"></textarea>
        </div>
        </div>
      </div>
      <div class="form-row">
        <div class="col mt-2">
                <div class="input-group">
                    <div class="custom-file">
                        <input type="file" name="assignments" class="custom-file-input" id="inputGroupFile" >
                        <label class="custom-file-label" id="numfiles" for="inputGroupFile">Choose file</label>
                    </div>
                </div>
                <div id="filePreview"></div>
            </div>
      </div>
      <div class="col-auto mt-3">
      <button type="submit" class="btn btn-primary mb-2 reg">Submit</button>
    </div>
    </form>

</div>

@endsection