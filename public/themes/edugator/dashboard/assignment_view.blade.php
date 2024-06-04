@extends(theme('dashboard.layout'))
@section('content')

@if($assignments)
<table class="table table-bordered bg-white">

  <tr>
    <th>Sr No.</th>
    <th>Assignment</th>
    <th>Collage Name</th>
    <th>Department</th>
    <th>Course</th>
    <th>Description</th>
    <th>Status</th>
    @if (Auth::user()->user_type == 'admin')
      <th>Action</th>
      <th>Amount</th>
    @endif
    @if (Auth::user()->user_type == 'instructor')
      <th>Approve</th>
    @endif
    @if (Auth::user()->user_type == 'student')
      <th>Download</th>
    @endif
  </tr>

  @foreach($assignments as $assignment)

  <tr>
    <td>{{ $assignment['id'] }}</td>
    <td><img src="{{ asset('uploads/studentsAssignments/'.$assignment['assignment_files_name']) }}" width="80" /></td>
    <td>{{ $assignment['collage_name'] }}</td>
    <td>{{ $assignment['department_name'] }}</td>
    <td><strong>{{$assignment['course_name']}}</td>
    <td>{{ $assignment['description'] }}</td>
    <td>
      @if ($assignment['status'] == 0)
        <span class="badge payment-status-initial badge-secondary"> <i class="la la-clock-o"></i>Progress</span>
        @else
        <span class="badge payment-status-initial badge-secondary"> <i class="la la-clock-o"></i>Success</span>
      @endif
    </td>

    @if (Auth::user()->user_type == 'admin')
    <td>
        @if (!$assignment['assinged_user_id'])
          <a href="{{ route('assign_assignment_view', $assignment['id'])}}" class="btn btn-info">{{__t('assign_instructor')}} </a>
        @else
          <a  class="btn btn-success">{{__t('instructor_assigned')}} </a>
        @endif
    </td>
    <td>
    <input type="text" id="putPrice" name="putPrice" pattern="\d+(\.\d{1,2})?" placeholder="Price">
    </td>
    @endif
    @if (Auth::user()->user_type == 'instructor')
    <td>
        @if ($assignment['status'] == 0)
          <input type="hidden" id="assignmentId" value="{{ $assignment['id'] }}">
          <input type="hidden" id="instructorId" value="{{ $assignment['assinged_user_id'] }}">
          <button type="button" id="approvePayment" class="btn btn-primary">{{__t('approve')}}</button>
        @else
          <button type="button" class="btn btn-info">{{__t('approved')}}</button>
        @endif
    </td>
    @endif
    @if (Auth::user()->user_type == 'student')
    <td>
        @if ($assignment['status'] == 0)
          <input type="hidden" id="assignmentId" value="{{ $assignment['id'] }}">
          <input type="hidden" id="instructorId" value="{{ $assignment['assinged_user_id'] }}">
          <button type="button" id="doPayment" class="btn btn-primary">{{__t('pay_here')}}</button>
        @else
          <button type="button" id="downloadAssignment" class="btn btn-info">{{__t('download')}}</button>
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