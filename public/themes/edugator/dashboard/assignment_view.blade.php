@extends(theme('dashboard.layout'))
@section('content')

@if(isset($assignments) && count($assignments) > 0)
<table class="table table-bordered bg-white">
  <tr>
    <th>Sr No.</th>
    @if (Auth::user()->user_type == 'student')
    <th>My Assignments</th>
    @else
    <th>Assignment</th>
    @endif
    <th>Collage Name</th>
    <th>Department</th>
    <th>Course</th>
    @if (Auth::user()->user_type == 'student')
    <th>Price</th>
    @endif
    <th>Status</th>
    @if (Auth::user()->user_type == 'admin')
    <th>Amount</th>
    @endif
  </tr>

  @php
  $count = 1;
  @endphp
  @foreach($assignments as $assignment)

  <tr>
    <td>{{ $count }}</td>
    <td>
      <a href="{{ asset('/uploads/studentsAssignments/' . $assignment['assignment_file_name']) }}" id="downloadFile" download>{{ $assignment['assignment_file_name'] }}</a>
    </td>
    <td>{{ $assignment['collage_name'] }}</td>
    <td>{{ $assignment['department_name'] }}</td>
    <td><strong>{{$assignment['course_name']}}</td>
    @if (Auth::user()->user_type == 'student')
    <td>{{ $assignment['amount'] }}</td>
    @endif
    <td>
      @if ($assignment['status'] == 0)
      <span class="badge payment-status-initial badge-secondary">{{__a('in_progress')}}</span>
      @elseif($assignment['status'] == 1)
      <span class="badge payment-status-initial badge-primary">{{__a('assigned')}}</span>
      @elseif($assignment['status'] == 2)
      <span class="badge payment-status-initial badge-success">{{Auth::user()->user_type == 'instructor' ? __a('completed') : __a('com_download')}}</span>
      @elseif($assignment['status'] == 3)
      <span class="badge payment-status-initial badge-success">{{__a('completed')}}</span>
      @endif
    </td>
    <td>

      <a href="{{ route('assignment_edit', $assignment['id'])}}" class="btn btn-info">
        <span class="badge badge-info mx-2" data-toggle="tooltip" title="" data-original-title="view">
          <i class="la la-eye"></i>
        </span>
      </a>
    </td>

  </tr>
  @php $count++; @endphp
  @endforeach

</table>
@else
{!! no_data() !!}
@endif

@endsection