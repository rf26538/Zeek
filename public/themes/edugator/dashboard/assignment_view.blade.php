@extends(theme('dashboard.layout'))
@section('content')

<form method="GET" action="{{ route('list_assignment_view') }}">
  <div class="row">
    <div class="col-md-12">
      <div class="search-filter-form-wrap mb-3">
        <div class="input-group">
          <input type="text" class="form-control mr-3" name="q" value="{{ request('q') }}" placeholder="Collage Name">
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
  @if($assignments && count($assignments) > 0)

  <div class="row">
    <div class="col-sm-12">
      <table class="table table-bordered table-striped">
        <tr>
          <th>#</th>
          @if (Auth::user()->user_type == 'student')
          <th>{{ trans('admin.my_assignment') }}</th>
          @endif
          <th>{{ trans('admin.collage_name') }}</th>
          <th>{{ trans('admin.dep') }}</th>
          <th>{{ trans('admin.course') }}</th>
          @if (Auth::user()->user_type == 'student')
          <th>{{ trans('admin.price') }}</th>
          @elseif (Auth::user()->user_type == 'instructor')
          <th>{{ trans('admin.instructor_amount') }}</th>
          @endif
          <th>{{ trans('admin.status') }}</th>
          <th>{{ trans('admin.action') }}</th>
        </tr>
        @foreach($assignments as $key => $assignment)
        <tr>
          <td>
            <label>
              <small class="text-muted">{{$key+1}}</small>
            </label>
          </td>
          @if (Auth::user()->user_type == 'student')
          <td>
            <a href="{{ asset('/uploads/studentsAssignments/' . $assignment['assignment_file_name']) }}" id="downloadFile" download>{{ $assignment['assignment_file_name'] }}</a>
          </td>
          @endif
          <td>{{ $assignment['collage_name'] }}</td>
          <td>{{ $assignment['department_name'] }}</td>
          <td><strong>{{$assignment['course_name']}}</td>
          @if (Auth::user()->user_type == 'student')
          <td>{{ $assignment['amount'] }}</td>
          @elseif (Auth::user()->user_type == 'instructor')
          <td>{{ $assignment['instructor_amount'] }}</td>
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
        </tr>
        @endforeach
      </table>
      {!! $assignments->links() !!}
    </div>
  </div>
  @else
  {!! no_data() !!}
  @endif
  @endsection