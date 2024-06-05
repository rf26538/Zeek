@extends(theme('dashboard.layout'))
@section('content')

@if(isset($assignments) && count($assignments) > 0)
<table class="table table-bordered bg-white">
  <tr>
    <th>Assignment</th>
    <th>Collage Name</th>
    <th>Department</th>
    <th>Course</th>
    <th>Description</th>
    <th>Status</th>
    @if (Auth::user()->user_type == 'admin')
    <th>Amount</th>
    @endif
    @if (Auth::user()->user_type == 'instructor' || Auth::user()->user_type == 'admin')
    <th>Instructor Assignment</th>
    @endif
    @if (Auth::user()->user_type == 'student')
    <th>Price</th>
    <th>Action</th>
    @endif
  </tr>

  @foreach($assignments as $assignment)

  <tr>
    <td>
      <a href="{{ asset('/uploads/studentsAssignments/' . $assignment['assignment_file_name']) }}" id="downloadFile" download>{{ $assignment['assignment_file_name'] }}</a>
    </td>
    <td>{{ $assignment['collage_name'] }}</td>
    <td>{{ $assignment['department_name'] }}</td>
    <td><strong>{{$assignment['course_name']}}</td>
    <td>{{ $assignment['description'] }}</td>
    <td>
      @if ($assignment['status'] == 1)
        <span class="badge payment-status-success badge-primary">Assigned</span>
      @elseif ($assignment['status'] == 2)
        <span class="badge payment-status-success badge-success">Completed</span>
      @elseif ($assignment['status'] == 3)
      <span class="badge payment-status-success badge-success">Paid</span>
      @endif
    </td>

    @if (Auth::user()->user_type == 'admin')
    <td>
      <input type="hidden" id="aId" value="{{ $assignment['id'] }}">
      <input type="hidden" id="iId" value="{{ $assignment['assinged_user_id'] }}">
      <input type="text" id="putPrice" name="putPrice" pattern="\d+(\.\d{1,2})?" value="{{$assignment['amount']}}">
    </td>
    <td>
        @if (!$assignment['assinged_user_id'])
          <a href="{{ route('assign_assignment_view', $assignment['id'])}}" class="btn btn-info">{{__t('assign_instructor')}} </a>
        @else
          <a  class="btn btn-success">{{__t('instructor_assigned')}} </a>
        @endif
    </td>
    @endif
    @if (Auth::user()->user_type == 'instructor')
    <td>
        @if ($assignment['status'] == 2)
        <a href="{{ asset('/uploads/studentsAssignments/' . $assignment['instructor_assignment_file_name']) }}" id="downloadFile" download>{{ $assignment['instructor_assignment_file_name'] }}</a>
        @else
        <a href="{{ route('instructor_assignment_edit', $assignment['id'])}}" class="btn btn-primary"> 
            <i class="la la-upload"></i>  
          </a>
      @endif
    </td>
    @endif
    @if (Auth::user()->user_type == 'student')
    <td>{{ $assignment['amount'] }}</td>
    <td>
        @if ($assignment['status'] == 0)
          <input type="hidden" id="assignmentId" value="{{ $assignment['id'] }}">
          <input type="hidden" id="amount" value="{{ $assignment['amount'] }}">
          <button type="button" id="doPayment" class="btn btn-primary"><i class="la la-clock-o"></i></button>
        @else
          <a type="button" id="downloadAssignment" class="btn btn-info"><i class="la la-clock-o"></i></a>
        @endif
      </td>
    @endif
  </tr>

  @endforeach

</table>
@else
{!! no_data() !!}
@endif

@endsection