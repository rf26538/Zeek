@extends('layouts.admin')


@section('page-header-right')

    <a href="{{route('withdraws')}}" class="btn btn-dark ml-2" > <i class="la la-clock-o"></i> Pending</a>
    <a href="{{route('withdraws', ['status' => 'success'])}}" class="btn btn-success ml-2" > <i class="la la-check-circle"></i> Success</a>
    <a href="{{route('withdraws', ['status' => 'rejected'])}}" class="btn btn-warning ml-2" > <i class="la la-exclamation-circle"></i> Rejected</a>
    <a href="{{route('withdraws', ['status' => 'all'])}}" class="btn btn-light ml-2" > <i class="la la-th-list"></i> All</a>

@endsection

@section('content')

<div class="container mt-4 mb-4">
    <h1 class="display-4 text-center">Assignment</h1>

    <form action="{{ route('register_assignment') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="form-row">
            <div class="col mt-2">
                <input type="text" name="name" class="form-control reg" placeholder="Title / Name">
                @error('name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col mt-2">
                <input type="text" name="colgname" class="form-control reg" placeholder="School / Collage Name">
                @error('colgname')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col mt-2">
                <input type="text" name="depname" class="form-control reg" placeholder="Department Name">
                @error('depname')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="form-row">
            <div class="col mt-2">
                <input type="text" name="crsname" class="form-control reg" placeholder="Course Name">
                @error('crsname')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col mt-2">
                <input type="text" name="pagenum" class="form-control reg" placeholder="Page Number">
                @error('pagenum')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="form-row">
            <div class="col mt-2">
                <div class="form-group">
                    <textarea class="form-control reg" name="desc" placeholder="Description" id="description" rows="3"></textarea>
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
                        <input type="file" name="assignments" class="custom-file-input" id="inputGroupFile">
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