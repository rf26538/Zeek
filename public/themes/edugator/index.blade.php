@extends('layouts.theme')


@section('content')

<!-- <div class="hero-banner py-3">

        <div class="container">
            <div class="row">
                <div class="col-md-12 col-lg-6">

                    <div class="hero-left-wrap">
                        <h1 class="hero-title mb-4">{{__t('hero_title')}}</h1>
                        <p class="hero-subtitle  mb-4">
                            {!! __t('hero_subtitle') !!}
                        </p>
                        <a href="{{route('categories')}}" class="btn btn-theme-primary btn-lg">Browse Course</a>
                    </div>

                </div>


                <div class="col-md-12 col-lg-6 hero-right-col">
                    <div class="hero-right-wrap">
                        <img src="{{theme_url('images/hero-image.png')}}" class="img-fluid" />
                    </div>
                </div>
            </div>
        </div>


    </div> -->

<div class="hero-banner py-3">

    <div class="container">
        <div class="row">
            <div class="col-md-12 col-lg-6">

                <div class="hero-left-wrap">
                    <h1 class="hero-title mb-4">{{__t('hero_title')}}</h1>
                    <p class="hero-subtitle  mb-4">
                        {!! __t('hero_subtitle') !!}
                    </p>
                    <a href="{{route('categories')}}" class="btn btn-theme-primary btn-lg">Browse Course</a>
                </div>

            </div>


            <div class="col-md-12 col-lg-6 hero-right-col">
                <div class="hero-right-wrap">
                    <img src="{{theme_url('images/hero-image.png')}}" class="img-fluid" />
                </div>
            </div>
        </div>
    </div>


</div>

<!--  BANNER SLIDER  -->
<div class="banner">
    <div class="row fullwidth">
        <div class="col-md-12">
            <ul class="bannerSlider">
                @foreach($banners as $banner)
                <li class="slide">
                    <a href="#">
                        <div class="slide__image">
                            <img src="{{ asset('uploads/banner/'.$banner->file_name)}}" alt="" />
                        </div>
                    </a>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>

<!-- ASSIGMENT -->

<!-- <div class="become-instructor-section"> -->
    <div class="container">
        <div class="row">
        <a href="{{route('assignment_register_view')}}">
            <div class="col mt-3">
                <div class="col-md-4">
                    <div class="card" style="width: 18rem;">
                        <div class="row g-0">
                            <div class="col-md-4">
                                <div class="position-relative overflow-hidden" style="max-width: 100px; min-width: 100px; height: 100%;">
                                    <img class="card-image" src="{{ asset('uploads/banner/Screenshot 2024-02-16 183217.png')}}" alt="IT 201 Final Summary, by Lashein .pdf" style="width: 100%; height: 100%;">
                                    <div class="bg-gray-200 animate-pulse" style="width: 100%; height: 100%;"></div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title text-truncate">IT 201 Final Summary, by Lashein .pdf</h5>
                                    <p class="card-text text-gray-800">Solutions available</p>
                                    <p class="card-text">
                                        <small class="text-muted">IT 201 - Saudi Electronic University</small>
                                    </p>
                                    <div class="d-flex mt-2">
                                        <span class="bg-teal-200 text-teal-500 rounded-pill py-1 px-2 me-2">NOTES</span>
                                        <span class="text-gray-600">65 views</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </a>
        <div class="col mt-3">
            <div class="col-md-4">
                <div class="card" style="width: 18rem;">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <div class="position-relative overflow-hidden" style="max-width: 100px; min-width: 100px; height: 100%;">
                                <img class="card-image" src="{{ asset('uploads/banner/Screenshot 2024-02-16 183217.png')}}" alt="IT 201 Final Summary, by Lashein .pdf" style="width: 100%; height: 100%;">
                                <div class="bg-gray-200 animate-pulse" style="width: 100%; height: 100%;"></div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title text-truncate">IT 201 Final Summary, by Lashein .pdf</h5>
                                <p class="card-text text-gray-800">Solutions available</p>
                                <p class="card-text">
                                    <small class="text-muted">IT 201 - Saudi Electronic University</small>
                                </p>
                                <div class="d-flex mt-2">
                                    <span class="bg-teal-200 text-teal-500 rounded-pill py-1 px-2 me-2">NOTES</span>
                                    <span class="text-gray-600">65 views</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col mt-3">
            <div class="col-md-4">
                <div class="card" style="width: 18rem;">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <div class="position-relative overflow-hidden" style="max-width: 100px; min-width: 100px; height: 100%;">
                                <img class="card-image" src="{{ asset('uploads/banner/Screenshot 2024-02-16 183217.png')}}" alt="IT 201 Final Summary, by Lashein .pdf" style="width: 100%; height: 100%;">
                                <div class="bg-gray-200 animate-pulse" style="width: 100%; height: 100%;"></div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title text-truncate">IT 201 Final Summary, by Lashein .pdf</h5>
                                <p class="card-text text-gray-800">Solutions available</p>
                                <p class="card-text">
                                    <small class="text-muted">IT 201 - Saudi Electronic University</small>
                                </p>
                                <div class="d-flex mt-2">
                                    <span class="bg-teal-200 text-teal-500 rounded-pill py-1 px-2 me-2">NOTES</span>
                                    <span class="text-gray-600">65 views</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>  
    </div>
<!-- </div> -->

<div class="become-instructor-section">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <img src="{{theme_url('images/6101073.jpg')}}" alt="Become an Instructor">
            </div>
            <div class="col-md-6">
                <h2>Become an Instructor</h2>
                <p>Reach millions of participants worldwide in the largest online learning marketplace, and deliver your course.
                </p>
                <p>Earn money and build your personal brand, all while making a real difference in the lives of participants.</p>
                <div class="row">
                    <div class="col-md-6">
                        <h3 class="mb-2 text-xl font-semibold text-instrucko-text">1. Initial Screening</h3>
                        <p class="text-sm text-instrucko-gray">Our teacher recruitment team will run through your CV and application.</p>
                    </div>
                    <div class="col-md-6">
                        <h3 class="mb-2 text-xl font-semibold text-instrucko-text">2. Short Demo</h3>
                        <p class="text-sm text-instrucko-gray">We’ll schedule a short teaching demo to understand your style of teaching.</p>
                    </div>
                    <div class="col-md-6">
                        <h3 class="mb-2 text-xl font-semibold text-instrucko-text">3. Background Checks</h3>
                        <p class="text-sm text-instrucko-gray">Safety for our learners is a key priority, so we’ll perform background checks.</p>
                    </div>
                    <div class="col-md-6">
                        <h3 class="mb-2 text-xl font-semibold text-instrucko-text">4. Welcome Onboard</h3>
                        <p class="text-sm text-instrucko-gray">We’ll set you up with instrucko’s LMS, and prepare you to book your first class.</p>
                    </div>
                </div>
                <!-- <a href="#" class="btn btn-primary">Start Teaching Now</a> -->
                <a href="{{route('register')}}" class="btn btn-theme-primary">Start Teaching Today</a>
            </div>

        </div>
    </div>
</div>

<div class="home-section-wrap home-info-box-wrapper py-5">
    <div class="container">
        <div class="row">

            <div class="col-md-3">
                <div class="home-info-box">
                    <img src="{{theme_url('images/skills.svg')}}">
                    <h3 class="info-box-title">Learn the latest skills</h3>
                    <p class="info-box-desc">like business analytics, graphic design, Python, and more</p>
                </div>
            </div>

            <div class="col-md-3">
                <div class="home-info-box">
                    <img src="{{theme_url('images/career-goal.svg')}}">
                    <h3 class="info-box-title">Get ready for a career</h3>
                    <p class="info-box-desc">in high-demand fields like IT, AI and cloud engineering</p>
                </div>
            </div>

            <div class="col-md-3">
                <div class="home-info-box">
                    <img src="{{theme_url('images/instructions.svg')}}">
                    <h3 class="info-box-title">Expert instruction</h3>
                    <p class="info-box-desc">Every course designed by expert instructor</p>
                </div>
            </div>

            <div class="col-md-3">
                <div class="home-info-box">
                    <img src="{{theme_url('images/cartificate.svg')}}">
                    <h3 class="info-box-title">Earn a certificate</h3>
                    <p class="info-box-desc">Get certified upon completing a course</p>
                </div>
            </div>
        </div>
    </div>
</div>


@if($featured_courses->count())
<div class="home-section-wrap home-featured-courses-wrapper py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="section-header-wrap">
                    <h3 class="section-title">
                        {{__t('featured_courses')}}

                        <a href="{{route('featured_courses')}}" class="btn btn-link float-right"><i class="la la-bookmark"></i> {{__t('all_featured_courses')}}</a>
                    </h3>

                    <p class="section-subtitle">{{__t('featured_courses_desc')}}</p>
                </div>
            </div>
        </div>
        <div class="popular-courses-cards-wrap mt-3">
            <div class="row">
                @foreach($featured_courses as $course)
                {!! course_card($course, 'col-md-4') !!}
                @endforeach
            </div>
        </div>
    </div>
</div>
@endif


<div class="mid-callto-action-wrap text-white text-center py-5">
    <div class="container py-3">
        <div class="row">
            <div class="col-md-12">
                <h2 class="mb-3">Find the perfect course for you</h2>
                <h4 class="mb-3 mid-callto-action-subtitle">Choose from over 100 online video courses <br /> with new additions published every day</h4>

                <a href="{{route('courses')}}" class="btn btn-warning btn-lg">Find new courses</a>
            </div>
        </div>
    </div>
</div>

@if($popular_courses->count())
<div class="home-section-wrap home-fatured-courses-wrapper py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="section-header-wrap">
                    <h3 class="section-title">{{__t('popular_courses')}}

                        <a href="{{route('popular_courses')}}" class="btn btn-link float-right"><i class="la la-bolt"></i> {{__t('all_popular_courses')}}</a>
                    </h3>
                    <p class="section-subtitle">{{__t('popular_courses_desc')}}</p>
                </div>
            </div>
        </div>
        <div class="popular-courses-cards-wrap mt-3">
            <div class="row">
                @foreach($featured_courses as $course)
                {!! course_card($course) !!}
                @endforeach
            </div>
        </div>
    </div>
</div>
@endif


@if($new_courses->count())
<div class="home-section-wrap home-new-courses-wrapper py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="section-header-wrap">
                    <h3 class="section-title">{{__t('new_arrival')}}

                        <a href="{{route('courses')}}" class="btn btn-link float-right"><i class="la la-list"></i> {{__t('all_courses')}}</a>
                    </h3>
                    <p class="section-subtitle">{{__t('new_arrival_desc')}}</p>
                </div>
            </div>
        </div>

        <div class="popular-courses-cards-wrap mt-3">
            <div class="row">
                @foreach($new_courses as $course)
                {!! course_card($course) !!}
                @endforeach
            </div>
        </div>
    </div>
</div>
@endif

@if($posts->count())
<div class="home-section-wrap home-blog-section-wrapper py-5">

    <div class="container">

        <div class="row mb-3">
            <div class="col-md-12">
                <div class="section-header-wrap">
                    <h3 class="section-title">{{__t('latest_blog_text')}}</h3>
                    <p class="section-subtitle">{{__t('latest_blog_desc')}}</p>
                </div>
            </div>
        </div>


        <div class="row">
            @foreach($posts as $post)
            <div class="col-lg-4 mb-4">
                <div class="home-blog-card">
                    <a href="{{$post->url}}">
                        <img src="{{$post->thumbnail_url->image_md}}" alt="{{$post->title}}" class="img-fluid">
                    </a>
                    <div class="excerpt px-4">
                        <h2><a href="{{$post->url}}">{{$post->title}}</a></h2>
                        <div class="post-meta d-flex justify-content-between">
                            <span>
                                <i class="la la-user"></i>
                                <a href="{{route('profile', $post->user_id)}}">
                                    {{$post->author->name}}
                                </a>
                            </span>
                            <span>&nbsp;<i class="la la-calendar"></i>&nbsp; {{$post->published_time}}</span>
                        </div>
                        <p class="mt-4">
                            <a href="{{$post->url}}"><strong>READ MORE <i class="la la-arrow-right"></i> </strong></a>
                        </p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="btn-see-all-posts-wrapper pt-4">
            <div class="row">
                <div class="col-md-12 d-flex">
                    <a href="{{route('blog')}}" class="btn btn-lg btn-theme-primary ml-auto mr-auto">
                        <i class="la la-blog"></i> See All Posts
                    </a>
                </div>
            </div>
        </div>

    </div>
</div>

@endif

<div class="home-section-wrap home-cta-wrapper py-5 ">

    <div class="home-partners-logo-section pb-5 mb-5 text-center">
        <div class="container">

            <h5 class="home-partners-title mb-5">Companies use ZeekHub Enterprises to enrich their brand & business.</h5>

            <div class="home-partners-logo-wrap">
                <div class="logo-item">
                    <a href=""><img src="{{theme_url('images/adidas.png')}}" alt="adidas" /></a>
                </div>
                <div class="logo-item">
                    <a href=""><img src="{{theme_url('images/disnep.png')}}" alt="images" /></a>
                </div>
                <div class="logo-item">
                    <a href=""><img src="{{theme_url('images/intel.png')}}" alt="intel" /></a>
                </div>
                <div class="logo-item">
                    <a href=""><img src="{{theme_url('images/penlaw.png')}}" alt="penlaw" /></a>
                </div>
                <div class="logo-item">
                    <a href=""><img src="{{theme_url('images/shopify.png')}}" alt="shopify" /></a>
                </div>
            </div>

        </div>
    </div>

    <div class="home-course-stats-wrap pb-5 mb-5 text-center">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <h3>580</h3>
                    <h5>Active Courses</h5>
                </div>
                <div class="col-md-3">
                    <h3>1200</h3>
                    <h5>Hours Video</h5>
                </div>
                <div class="col-md-3">
                    <h3>850</h3>
                    <h5>Teachers</h5>
                </div>
                <div class="col-md-3">
                    <h3>1800</h3>
                    <h5>Students Learning</h5>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-sm-6 home-cta-left-col">

                <div class="home-cta-text-wrapper px-5 text-center">
                    <h4>Become an instructor</h4>
                    <p>Spread your knowledge to millions of students around the world through ZeekHub Enterprises teaching platform. You can teach any tech you love from heart.
                    </p>
                    <a href="{{route('create_course')}}" class="btn btn-theme-primary">Start Teaching Today</a>

                </div>

            </div>

            <div class="col-sm-6">

                <div class="home-cta-text-wrapper px-5 text-center">
                    <h4>Discover latest technology</h4>
                    <p>Earn new skills and enroll to the new courses. Continuous learning is only key to keep your self up-to-date with modern technology.
                    </p>
                    <a href="{{route('courses')}}" class="btn btn-theme-primary">{{__t('find_new_courses')}}</a>
                </div>

            </div>

        </div>
    </div>

</div>

@endsection