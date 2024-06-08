
<footer>

    <div class="footer-top py-5">

        <div class="container">
            <div class="row">

                <div class="col-md-3">
                    <div class="footer-widget-wrap">
                        <h4>About US</h4>
                        <p class="footer-about-us-desc">
                            ZeekHub Enterprises is a LMS platform that connect Teachers with Students globally. Teachers crate high quality course and present them in super easy way. ZeekHub Enterprises LMS created by <a href="https://victoriousinfotech.com" target="_blank">Victorious Infotech Pvt. Ltd.</a>
                        </p>
                        <p class="footer-social-icon-wrap">
                            <a href="#"><i class="la la-facebook"></i> </a>
                            <a href="#"><i class="la la-twitter"></i> </a>
                            <a href="#"><i class="la la-youtube"></i> </a>
                        </p>
                    </div>
                </div>


                <div class="col-md-3">
                    <div class="footer-widget-wrap contact-us-widget-wrap">
                        <h4>Contact</h4>
                        <p class="footer-address">
                        A-320 , Urbtech Trade Centre , Sector 132, Noida-201301- UP,India 
                        </p>

                        <p class="mb-0"> Tel.: +918595961106 </p>
                        <p class="mb-0"> Fax: +918595961106 </p>
                        <p class="mb-0"> contact@zeekhub.com </p>
                    </div>
                </div>



                <div class="col-md-6">
                    <div class="footer-widget-wrap link-widget-wrap">

                        <ul class="footer-links">
                            <li><a href="{{route('home')}}">{{__t('home')}}</a> </li>
                            <li><a href="{{route('dashboard')}}">{{__t('dashboard')}}</a> </li>
                            <li><a href="{{route('courses')}}">{{__t('courses')}}</a> </li>
                            <li><a href="{{route('popular_courses')}}">{{__t('popular_courses')}}</a> </li>
                            <li><a href="{{route('featured_courses')}}">{{__t('featured_courses')}}</a> </li>
                            <li><a href="{{route('blog')}}">{{__t('blog')}}</a> </li>
                            <li><a href="{{route('post_proxy')}}">{{__t('about_us')}}</a> </li>
                            <li><a href="{{route('register')}}">{{__t('signup')}}</a> </li>
                            <li><a href="#">Contact Us</a> </li>
                        </ul>

                    </div>
                </div>

            </div>
        </div>
    </div>


    <div class="footer-bottom py-5">

        <div class="container">

            <div class="row">
                <div class="col-md-12">
                    <div class="footer-bottom-contents-wrap d-flex">

                        <div class="footer-bottom-left d-flex">
                            <h5 class="text-warning">ZeekHub Enterprises LMS</h5>
                            <span class="ml-4">Copyright © 2020 ZeekHub Enterprises. All rights reserved.</span>
                        </div>

                        <div class="footer-bottom-right flex-grow-1 text-right">
                            <ul class="footer-bottom-right-links">
                                <li>
                                    <a href="{{route('post_proxy', get_option('terms_of_use_page'))}}">
                                        {{__t('terms_of_use')}}
                                    </a>
                                </li>
                                <li>
                                    <a href="{{route('post_proxy', get_option('privacy_policy_page'))}}">
                                        {{__t('privacy_policy')}} &amp; {{__t('cookie_policy')}}
                                    </a>
                                </li>

                            </ul>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>


</footer>


<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
    {{ csrf_field() }}
</form>

@if( ! auth()->check() && request()->path() != 'login')
    @include(theme('template-part.login-modal-form'))
@endif

<!-- bootstrap js -->
<script src="{{asset('assets/js/bootstrap.bundle.min.js')}}"></script>

@yield('page-js')

<!-- main js -->
<script src="{{theme_asset('js/main.js')}}"></script>
<script src="{{theme_asset('js/razor.js')}}"></script>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>

</body>
</html>
