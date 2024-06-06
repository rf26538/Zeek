@extends('layouts.admin')


@section('page-header-right')

<a href="{{route('withdraws')}}" class="btn btn-dark ml-2"> <i class="la la-clock-o"></i> Pending</a>
<a href="{{route('withdraws', ['status' => 'success'])}}" class="btn btn-success ml-2"> <i class="la la-check-circle"></i> Success</a>
<a href="{{route('withdraws', ['status' => 'rejected'])}}" class="btn btn-warning ml-2"> <i class="la la-exclamation-circle"></i> Rejected</a>
<a href="{{route('withdraws', ['status' => 'all'])}}" class="btn btn-light ml-2"> <i class="la la-th-list"></i> All</a>

@endsection

@section('content')

@if(isset($assignments) && count($assignments) > 0)
<table class="table table-bordered bg-white mt-3">

  <tr>
    <th>Sr No.</th>
    <th>Assignment</th>
    <th>Instructor</th>
    <th>Collage Name</th>
    <th>Department</th>
    <th>Course</th>
    <th>Status</th>
    @if (Auth::user()->user_type == 'admin')
    <th>Amount</th>
    @endif
    @if (Auth::user()->user_type == 'instructor' || Auth::user()->user_type == 'admin')
    <th>Action</th>
    @endif
    @if (Auth::user()->user_type == 'student')
    <th>Price</th>
    <th>Download</th>
    @endif
  </tr>

  @php
  $count = 1;
  @endphp
  @foreach($assignments as $assignment)

  <tr>
    <td>{{ $count }}</td>
    <td>
      <input type="hidden" id="asId" value="{{ $assignment['id'] }}">
      <a href="{{ asset('/uploads/studentsAssignments/' . $assignment['assignment_file_name']) }}" id="downloadFile" download>{{ $assignment['assignment_file_name'] }}</a>

    </td>
    <td>{{ $assignment['user'] ? $assignment['user']['name'] : ''}}</td>
    <td>{{ $assignment['collage_name'] }}</td>
    <td>{{ $assignment['department_name'] }}</td>
    <td>{{ $assignment['course_name']}}</td>
    <td>
      @if ($assignment['status'] == 0)
      <span class="badge payment-status-initial badge-secondary">{{ __a('in_progress') }}</span>
      @elseif ($assignment['status'] == 1)
      <span class="badge payment-status-success badge-primary">{{ __a('assigned') }}</span>
      @elseif ($assignment['status'] == 2)
      <span class="badge payment-status-success badge-success">{{ __a('completed') }}</span>
      @elseif ($assignment['status'] == 3)
      <span class="badge payment-status-success badge-success">{{ __a('paid') }}</span>
      @endif
    </td>

    @if (Auth::user()->user_type == 'admin')
    <td>
      {{$assignment['amount'] ?? 0}}
    </td>
    <td>
      <a href="{{ route('admin_assignment_edit', $assignment['id'])}}" class="btn btn-info">
        <span class="badge badge-info mx-2" data-toggle="tooltip" title="" data-original-title="Edit">
          <i class="la la-eye"></i>
        </span>
      </a>
    </td>
    @endif
    @if (Auth::user()->user_type == 'instructor')
    <td>
      @if ($assignment['status'] == 0)
      <input type="hidden" id="assignmentId" value="{{ $assignment['id'] }}">
      <input type="hidden" id="instructorId" value="{{ $assignment['assinged_user_id'] }}">
      <button type="button" id="approvePayment" class="btn btn-secondary"><i class="la la-check-double"></i></button>
      @else
      <button type="button" class="btn btn-success"><i class="la la-check-double"></i></button>
      @endif
      <button type="button" data-toggle="tooltip" title="" id="button-upload" class="btn btn-primary" data-upload-success="reload" data-original-title="Upload"><i class="la la-upload"></i></button>
    </td>
    @endif
    @if (Auth::user()->user_type == 'student')
    <td>{{ $assignment['amount'] }}</td>
    <td>
      @if ($assignment['status'] == 0)
      <input type="hidden" id="assignmentId" value="{{ $assignment['id'] }}">
      <input type="hidden" id="amount" value="{{ $assignment['amount'] }}">
      <button type="button" id="doPayment" class="btn btn-primary">{{__t('pay_here')}}</button>
      @else
      <button type="button" id="downloadAssignment" class="btn btn-info">{{__t('download')}}</button>
      @endif
    </td>
    @endif
  </tr>
  @php $count++; @endphp
  @endforeach

</table>
@else
{!! no_data() !!}
@endif

@endsection