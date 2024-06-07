@extends(theme('dashboard.layout'))

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__t('Home')}}</a></li>
        <li class="breadcrumb-item"><a href="{{route('list_assignment_view')}}">{{__a('assignment_title')}}</a></li>
        <li class="breadcrumb-item">{{__a('upload_ans')}}</li>
    </ol>
</nav>
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
        <th>{{__a('instructor')}}</th>
        <td>{{ $assignment->user ? $assignment->user->name : ''}}</td>
    </tr>
    <tr>
        <th>{{__a('amount')}}</th>
        <td>{{ $assignment['amount'] ?? 0 }}</td>
    </tr>
    <tr>
        <th>{{__a('file')}}</th>
        <td><a href="{{ $assignment['assignment_file_name'] ? asset('/uploads/studentsAssignments/' . $assignment['assignment_file_name']) : '#' }}" download>{{ $assignment['assignment_file_name'] ?? 'Not Available Yet' }}</a></td>
    </tr>
    <tr>
        <th>{{__a('ans_sheet')}}</th>
        <td>
            @if($assignment['instructor_assignment_file_name'] && Auth::user()->user_type == 'instructor')
            <a href="{{ asset('/uploads/InstructorAssignment/' . $assignment['instructor_assignment_file_name']) }}" download>{{ $assignment['instructor_assignment_file_name'] }}</a>
            @elseif($assignment['instructor_assignment_file_name'] && $assignment['status'] == 2)
                <span>{{__a('com_download')}}</span>
            @elseif($assignment['instructor_assignment_file_name'] && $assignment['status'] == 3)
                <a href="{{ asset('/uploads/InstructorAssignment/' . $assignment['instructor_assignment_file_name']) }}" download>{{ $assignment['instructor_assignment_file_name'] }}</a>
            @else
            <span>Not Available Yet</span>
            @endif
        </td>

    </tr>

</table>

@if (Auth::user()->user_type == 'instructor' && !$assignment['instructor_assignment_file_name'])
<form action="{{ route('instructor_assignment_update') }}" method="post" enctype="multipart/form-data">
    @csrf
    <input type="hidden" value="{{ $assignment['id'] }}" name="id" />
    <div class="status-update-form-wrap d-flex p-3 bg-light">

        <div class="col-md-6">
            <input type="file" name="instructorAssignment" class="form-control ">
            @error('instructorAssignment')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-3">
            <input type="text" name="amount" class="form-control reg" placeholder="Amount" value="{{ old('instructor_amount') ?? $assignment['instructor_amount'] }}">
            @error('amount')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-3">
            <button type="submit" class="btn btn-info mb-2">{{__a('update_status')}}</button>
        </div>
    </div>
</form>
@endif
@endsection