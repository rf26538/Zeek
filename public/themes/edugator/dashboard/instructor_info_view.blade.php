@extends('layouts.theme')
@section('content')

<div class="blog-author-wrap border p-4 my-5">
    <div class="course-single-instructor-wrap mb-4 d-flex">
        <div class="instructor-stats">
            <div class="profile-image mb-4">
                    <img src="{{ asset('icons/man2.png') }}" class="profile-photo" alt="Instructor Img">
            </div>
        </div>

        <div class="instructor-details">
                <h4 class="instructor-name">{{ $instructor['name'] }}</h4>
            <h5 class="instructor-designation">{{ $instructor['job_title']}}</h5>
            <div class="profle-about-me-text mt-4">
                <div class="content-expand-wrap">
                    <div class="content-expand-inner">
                    {{ $instructor['about_me']}}
                    </div>
                    <span class="expand-more-btn-wrap"><button type="button" class="expand-more-btn btn-sm btn btn-link"> + See More</button></span>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection