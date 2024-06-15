@extends('layouts.admin')
@section('content')

<div class="container mt-4 mb-4">
<div id="responseMessage" class="alert alert-success" role="alert" style="display: none;"></div>
  <form method="GET" action="{{ route('admin_assignment_view') }}">
    <div class="row">
      <div class="col-md-12">
        <div class="search-filter-form-wrap mb-3">
          <div class="input-group">
            <input type="text" class="form-control mr-3" name="q" value="{{ request('q') }}" placeholder="College Name">
            <input type="text" class="form-control mr-3" name="q1" value="{{ request('q1') }}" placeholder="Department">
            <input type="text" class="form-control mr-3" name="q2" value="{{ request('q2') }}" placeholder="Course">
            <select name="status" class="mr-3">
              <option value="">Status</option>
              <option value="all">All</option>
              <option value="0" {{ request('status') == '0' ? ' selected' : '' }}>In-progress</option>
              <option value="1" {{ request('status') == '1' ? ' selected' : '' }}>Assigned</option>
              <option value="2" {{ request('status') == '2' ? ' selected' : '' }}>Completed</option>
            </select>
            <button type="submit" class="btn btn-primary btn-purple"><i class="la la-search-plus"></i> Filter results</button>
          </div>
        </div>
      </div>
    </div>
    @if($assignments->count())
    <div class="row">
      <div class="col-sm-12">
        <table class="table table-bordered table-striped">
          <tr>
            <th>Sr No.</th>
            <th>Instructor</th>
            <th>College Name</th>
            <th>Department</th>
            <th>Course</th>
            <th>Status</th>
            <th>Is For Dashboard</th>
            @if (Auth::user()->user_type == 'instructor' || Auth::user()->user_type == 'admin')
            <th>Action</th>
            @endif
            @if (Auth::user()->user_type == 'student')
            <th>Price</th>
            <th>Download</th>
            @endif
          </tr>
          @foreach($assignments as $key => $assignment)
          <tr>
            <td>{{ $key+1 }}</td>
            <td>{{ $assignment['user'] ? $assignment['user']['name'] : ''}}</td>
            <td>{{ $assignment['collage_name'] }}</td>
            <td>{{ $assignment['department_name'] }}</td>
            <td>{{ $assignment['course_name']}}</td>
            <td>
              @if ($assignment['status'] == 0)
              <span class="badge payment-status-initial badge-secondary">{{ __a('in_progress') }}</span>
              @elseif ($assignment['status'] == 1)
              <span class="badge payment-status-success badge-primary">{{ __a('assigned') }}</span>
              @elseif ($assignment['instructor_assignment_file_name'] && $assignment['status'] == 2)
              <span class="badge payment-status-success badge-success">{{ __a('completed') }}</span>
              @elseif ($assignment['instructor_assignment_file_name'] && $assignment['status'] == 3)
              <a href="{{ asset('/uploads/InstructorAssignment/' . $assignment['instructor_assignment_file_name']) }}" download>{{ $assignment['instructor_assignment_file_name'] }}</a>
              @endif
            </td>
            <td>
              @if ($assignment['status'] == 2 || $assignment['is_admin'] == 1)
                <label class="switch inst">
                  <input type="checkbox" id="isForDashboard" data-id="{{ $assignment['id'] }}" {{ $assignment->is_for_dashboard == 1 ? 'checked': ''}}>
                  <span class="slider inst round"></span>
                </label>
              @endif
            </td>
            @if (Auth::user()->user_type == 'admin')
            <td>
              @if ($assignment['is_admin'])
              <a href="{{ route('admin_assignment_delete', $assignment['id'])}}" class="btn btn-danger">
                <i class="la la-trash"></i>
              </a>

              @else
              <a href="{{ route('admin_assignment_edit', $assignment['id'])}}" class="btn btn-info">
                <i class="la la-eye"></i>
              </a>
              @endif
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
          @endforeach
        </table>
        {!! $assignments->links() !!}
      </div>
    </div>
    @else
    {!! no_data() !!}
    @endif
  </form>
</div>

@endsection