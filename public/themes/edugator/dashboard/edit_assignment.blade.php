@extends(theme('dashboard.layout'))
@section('content')

<table class="table table-striped table-bordered table-sm">
    <tr>
        <th>{{__a('assignment_title')}}</th>
        <td>{{ $assignment['name'] }}</td>
    </tr>
    <tr>
        <th>{{__a('school')}}</th>
        <td>{{ $assignment['collage_name'] }}</td>
    </tr>
    <tr>
        <th>{{__a('dep')}}</th>
        <td>{{ $assignment['department_name'] }}</td>
    </tr>
    <tr>
        <th>{{__a('course')}}</th>
        <td>{{ $assignment['course_name'] }}</td>
    </tr>
    <tr>
        <th>{{__a('page')}}</th>
        <td>{{ $assignment['page_number'] }}</td>
    </tr>
    <tr>
        <th>{{__a('amount')}}</th>
        <td>{{ $assignment['amount'] ?? 0 }}</td>
    </tr>
    <tr>
        <th>{{__a('file')}}</th>
        <td><a href="{{ asset('/uploads/studentsAssignments/' . $assignment['assignment_file_name']) }}" id="downloadFile" download>{{ $assignment['assignment_file_name'] }}</a></td>
    </tr>

</table>

<form action="{{ route('instructor_assignment_update') }}" method="post" enctype="multipart/form-data">
    @csrf
    <input type="hidden" value="{{ $assignment['id'] }}" name="id" />
    <div class="status-update-form-wrap d-flex p-3 bg-light">
        <div class="col-md-8">
                <input type="file" name="instructorAssignment" class="custom-file-input" id="inputGroupFile">
                <label class="custom-file-label" id="numfiles" for="inputGroupFile">Choose file</label>
            @error('amount')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-3">
            <button type="submit" class="btn btn-primary mb-2">{{__a('upload')}}</button>
        </div>
    </div>
</form>

@endsection