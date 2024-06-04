@extends(theme('dashboard.layout'))
@section('content')

@if($assignment)
<form action="{{ route('assign_assignment_instructor', $assignment->id)}}" method="POST">
    @csrf
    <select class="custom-select" name="select_option">
        <option selected>Select Instructor</option>
        @foreach ($users as $key => $user)
            <option value="{{ $user->id }}">{{ $user->name }}</option>
        @endforeach
    </select>
    <div class="text-center mt-3">
        <button type="submit" class="btn btn-primary">Primary</button>
    </div>
</form>
@else
{!! no_data() !!}
@endif

@endsection