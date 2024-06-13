@extends('layouts.theme')
@section('content')


<style>
    .main_wrapper {
        width: 100%;
    }

    .left_pages {
        display: flex;
        align-items: center;
        flex-direction: column;
        gap: 20px;
        background-color: #fff;
        padding: 15px;
        border-radius: 5px;
    }

    .left_pages div,
    .left_pages div img {
        border-radius: 5px;
        overflow: hidden;
    }

    .left_pages div img {
        width: 100%;
        height: auto;
        max-height: 250px;
    }

    .right_pages {
        display: flex;
        align-items: center;
        flex-direction: column;
        gap: 20px;
        border-radius: 5px;
    }

    .right_pages div {
        border-radius: 5px;
        overflow: hidden;
        background-color: #fff;
        margin-bottom: 20px;
        width: 100%;
        height: 800px;
        padding: 15px;
        filter: blur(4px);
    }

    .right_pages div:nth-child(1) {
        filter: blur(0px)
    }

    .right_pages div img {
        height: auto;
        max-height: 100%;
        border-radius: 5px;
        width: 100%;
    }

    #section {
        width: 500px;
        height: 400px;
        word-wrap: break-word;
    }

    .moretext {
        display: none;
    }
</style>
<div class="main_wrapper">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-2">
                <div class="left_pages">
                        <div>
                            <img src="{{ asset('uploads/studentsAssignments/'. $images[0])}}" alt=""> 
                        </div>
                        <div>
                            <div class="article">
                                <p>{{ $assignment->name }}</p>
                                <p class="moretext">
                                {{ $assignment->description }} 
                                </p>
                            </div>
                            <a class="moreless-button" href="#">Read more</a>
                        </div>
                </div>
            </div>

            <div class="col-lg-9 col-md-9 col-sm-10">
                <div class="right_pages">
                    @foreach ($images as $image)                    
                    <div>
                        <img src="{{ asset('uploads/studentsAssignments/'. $image)}}" alt=""> 
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $('.moreless-button').click(function() {
  $('.moretext').slideToggle();
  if ($('.moreless-button').text() == "Read more") {
    $(this).text("Read less")
  } else {
    $(this).text("Read more")
  }
});
</script>
@endsection