@extends('layouts.admin')


@section('page-header-right')
<a href="{{route('admin_assignment_view')}}" data-toggle="tooltip" title="{{__a('assignment_list')}}"> <i class="la la-arrow-circle-left"></i> {{__a('back_to_assignment')}} </a>
@endsection
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
        <th>{{__a('instructor')}}</th>
        <td>{{ $assignment->user ? $assignment->user->name : ''}}</td>
    </tr>
    <tr>
        <th>{{__a('amount')}}</th>
        <td>{{ $assignment['amount'] ?? 0 }}</td>
    </tr>
    <tr>
        <th>{{__a('instructor_price')}}</th>
        <td>{{ $assignment['instructor_amount'] ?? 0 }}</td>
    </tr>
    <tr>
        <th>{{__a('file')}}</th>
        <td><a href="{{ asset('/uploads/studentsAssignments/' . $assignment['assignment_file_name']) }}" id="downloadFile" download>{{ $assignment['assignment_file_name'] }}</a></td>
    </tr>
    <th>{{__a('ans_sheet')}}</th>
        <td>
            @if($assignment['instructor_assignment_file_name'])
            <a href="{{ asset('/uploads/InstructorAssignment/' . $assignment['instructor_assignment_file_name']) }}" download>{{ $assignment['instructor_assignment_file_name'] }}</a>
            @else
            <span>Not Available Yet</span>
            @endif
        </td>

    </tr>

</table>

<form action="{{ route('admin_assignment_update') }}" method="post" enctype="multipart/form-data">
    @csrf
    <input type="hidden" value="{{ $assignment['id'] }}" name="id" />
    <div class="status-update-form-wrap d-flex p-3 bg-light">
        <div class="col-md-2">
            <select class="form-control" name="assinged_user_id" {{ $assignment['status'] == 2 ? 'disabled' : ''}}>
                <option value="">Select Instructor</option>
                @foreach ($users as $user)
                <option value="{{ $user->id }}" {{(old('assinged_user_id') ?? $assignment['assinged_user_id']) == $user->id ? 'selected' : ''}}>{{ $user->name }}</option>
                @endforeach
            </select>
            @error('assinged_user_id')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-2">
            <input type="hidden" name="instructorAssignment" class="form-control reg" value="{{ $assignment['instructor_assignment_file_name'] }}">
            <input type="text" name="amount" class="form-control reg" placeholder="Amount" value="{{ old('amount') ?? $assignment['amount'] }}" {{ $assignment['status'] == 3 ? 'readonly' : '' }}>
            @error('amount')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-3">
            <input type="text" name="instamount" class="form-control reg" placeholder="Instructor amount" value="{{ old('instructor_amount') ?? $assignment['instructor_amount'] }}" {{ $assignment['status'] == 2 ? 'readonly' : '' }}>
            @error('instructor_amount')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-info mb-2" {{$assignment['status'] == 3 ? 'disabled' : ''}}>{{__a('update')}}</button>
        </div>
    </div>
</form>

@endsection