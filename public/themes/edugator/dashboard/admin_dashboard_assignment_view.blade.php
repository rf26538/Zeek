@extends('layouts.theme')
@section('content')

<div class="container-fluid mb-10">
    <div class="row">
        <div class="col-md-4">
            <table class="table table-striped table-bordered">
                <tr>
                    <th>{{__a('assignment_title')}}</th>
                    <td>{{ $assignment->name}}</td>
                </tr>
                <tr>
                    <th>{{__a('school')}}</th>
                    <td>{{ $assignment->collage_name}}</td>
                </tr>
                <tr>
                    <th>{{__a('dep')}}</th>
                    <td>{{ $assignment->department_name}}</td>
                </tr>
                <tr>
                    <th>{{__a('course')}}</th>
                    <td>{{ $assignment->course_name}}</td>
                </tr>
                <tr>
                    <th>{{__a('page')}}</th>
                    <td>{{ $assignment->page_number}}</td>
                </tr>
                <tr>
                    <th>{{__a('file')}}</th>
                    <td>{{ $assignment->assignment_file_name}}</td>
                </tr>
                <tr>
                    <th>{{__a('instructor_amount')}}</th>
                    <td> {{ $assignment->instructor_amount ?? ''}}</td>
                </tr>

            </table>
        </div>
        
        <div class="col-md-8">
            <div class="iframe-container">
                <iframe src="{{ asset('uploads/InstructorAssignment/t.pdf')}}"  width="70%" height="800" style="border: none;" allowFullScreen></iframe>
            </div>
        </div>
    </div>
</div>



@endsection