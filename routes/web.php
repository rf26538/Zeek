<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'HomeController@index')->name('home');
Route::get('clear', 'HomeController@clearCache')->name('clear_cache');

Route::get('installations', 'InstallationController@installations')->name('installations');
Route::get('installations/step/2', 'InstallationController@installationsTwo')->name('installations_step_two');
Route::post('installations/step/2', 'InstallationController@installationPost');
Route::get('installations/step/final', 'InstallationController@installationFinal')->name('installation_final');

/**
 * Authentication
 */
Route::get('login', 'AuthController@login')->name('login')->middleware('guest');
Route::post('login', 'AuthController@loginPost');
Route::any('logout', 'AuthController@logoutPost')->name('logout');

Route::get('register', 'AuthController@register')->name('register')->middleware('guest');
Route::post('register', 'AuthController@registerPost');

Route::get('forgot-password', 'AuthController@forgotPassword')->name('forgot_password');
Route::post('forgot-password', 'AuthController@sendResetToken');
Route::get('forgot-password/reset/{token}', 'AuthController@passwordResetForm')->name('reset_password_link');
Route::post('forgot-password/reset/{token}', 'AuthController@passwordReset');

Route::get('profile/{id}', 'UserController@profile')->name('profile');
Route::get('review/{id}', 'UserController@review')->name('review');

Route::get('courses', 'HomeController@courses')->name('courses');
Route::get('featured-courses', 'HomeController@courses')->name('featured_courses');
Route::get('popular-courses', 'HomeController@courses')->name('popular_courses');

Route::get('courses/{slug?}', 'CourseController@view')->name('course');
Route::get('courses/{slug}/lecture/{lecture_id}', 'CourseController@lectureView')->name('single_lecture');
Route::get('courses/{slug}/assignment/{assignment_id}', 'CourseController@assignmentView')->name('single_assignment');
Route::get('courses/{slug}/quiz/{quiz_id}', 'QuizController@quizView')->name('single_quiz');

Route::get('topics', 'CategoriesController@home')->name('categories');
Route::get('topics/{category_slug}', 'CategoriesController@show')->name('category_view');
//Get Topics Dropdown for course creation category select
Route::post('get-topic-options', 'CategoriesController@getTopicOptions')->name('get_topic_options');

Route::post('courses/free-enroll', 'CourseController@freeEnroll')->name('free_enroll');

//Attachment Download
Route::get('attachment-download/{hash}', 'CourseController@attachmentDownload')->name('attachment_download');

Route::get('payment-thank-you/{transaction_id?}', 'PaymentController@thankYou')->name('payment_thank_you_page');

Route::group(['prefix' => 'login'], function () {
    //Social login route
    Route::get('facebook', 'AuthController@redirectFacebook')->name('facebook_redirect');
    Route::get('facebook/callback', 'AuthController@callbackFacebook')->name('facebook_callback');

    Route::get('google', 'AuthController@redirectGoogle')->name('google_redirect');
    Route::get('google/callback', 'AuthController@callbackGoogle')->name('google_callback');

    Route::get('twitter', 'AuthController@redirectTwitter')->name('twitter_redirect');
    Route::get('twitter/callback', 'AuthController@callbackTwitter')->name('twitter_callback');

    Route::get('linkedin', 'AuthController@redirectLinkedIn')->name('linkedin_redirect');
    Route::get('linkedin/callback', 'AuthController@callbackLinkedIn')->name('linkin_callback');
});

Route::group(['middleware' => ['auth']], function () {
    Route::post('courses/{slug}/assignment/{assignment_id}', 'CourseController@assignmentSubmitting');
    Route::get('content_complete/{content_id}', 'CourseController@contentComplete')->name('content_complete');
    Route::post('courses-complete/{course_id}', 'CourseController@complete')->name('course_complete');

    Route::group(['prefix' => 'checkout'], function () {
        Route::get('/', 'CartController@checkout')->name('checkout');
        Route::post('bank-transfer', 'GatewayController@bankPost')->name('bank_transfer_submit');
        Route::post('paypal', 'GatewayController@paypalRedirect')->name('paypal_redirect');
        Route::post('offline', 'GatewayController@payOffline')->name('pay_offline');
    });

    Route::post('save-review/{course_id?}', 'CourseController@writeReview')->name('save_review');
    Route::post('update-wishlist', 'UserController@updateWishlist')->name('update_wish_list');

    Route::post('discussion/ask-question', 'DiscussionController@askQuestion')->name('ask_question');
    Route::post('discussion/reply/{id}', 'DiscussionController@replyPost')->name('discussion_reply_student');

    Route::post('quiz-start', 'QuizController@start')->name('start_quiz');
    Route::get('quiz/{id}', 'QuizController@quizAttempting')->name('quiz_attempt_url');
    Route::post('quiz/{id}', 'QuizController@answerSubmit');

    //Route::get('quiz/answer/submit', 'QuizController@answerSubmit')->name('quiz_answer_submit');
});

/**
 * Add and remove to Cart
 */
Route::post('add-to-cart', 'CartController@addToCart')->name('add_to_cart');
Route::post('remove-cart', 'CartController@removeCart')->name('remove_cart');

/**
 * Payment Gateway Silent Notification
 * CSRF verification skipped
 */
Route::group(['prefix' => 'gateway-ipn'], function () {
    Route::post('stripe', 'GatewayController@stripeCharge')->name('stripe_charge');
    Route::any('paypal/{transaction_id?}', 'IPNController@paypalNotify')->name('paypal_notify');
});

/**
 * Users,Instructor dashboard area
 */
Route::group(['prefix' => 'dashboard', 'middleware' => ['auth']], function () {
    Route::get('/', 'DashboardController@index')->name('dashboard');

    /**
     * Only instructor has access in this group
     */
    Route::group(['middleware' => ['instructor']], function () {
        Route::post('update-section/{id}', 'CourseController@updateSection')->name('update_section');
        Route::post('delete-section', 'CourseController@deleteSection')->name('delete_section');

        Route::group(['prefix' => 'courses'], function () {
            Route::get('new', 'CourseController@create')->name('create_course');
            Route::post('new', 'CourseController@store');

            Route::get('{course_id}/information', 'CourseController@information')->name('edit_course_information');
            Route::post('{course_id}/information', 'CourseController@informationPost');

            Route::group(['prefix' => '{course_id}/curriculum'], function () {
                Route::get('', 'CourseController@curriculum')->name('edit_course_curriculum');
                Route::get('new-section', 'CourseController@newSection')->name('new_section');
                Route::post('new-section', 'CourseController@newSectionPost');

                Route::post('new-lecture', 'CourseController@newLecture')->name('new_lecture');
                Route::post('update-lecture/{id}', 'CourseController@updateLecture')->name('update_lecture');

                Route::post('new-assignment', 'CurriculumController@newAssignment')->name('new_assignment');
                Route::post('update-assignment/{id}', 'CurriculumController@updateAssignment')->name('update_assignment');

                Route::group(['prefix' => 'quiz'], function () {
                    Route::post('create', 'QuizController@newQuiz')->name('new_quiz');
                    Route::post('update/{id}', 'QuizController@updateQuiz')->name('update_quiz');

                    Route::post('{quiz_id}/create-question', 'QuizController@createQuestion')->name('create_question');
                });
            });

            Route::post('quiz/edit-question', 'QuizController@editQuestion')->name('edit_question_form');
            Route::post('quiz/update-question', 'QuizController@updateQuestion')->name('edit_question');
            Route::post('load-quiz-questions', 'QuizController@loadQuestions')->name('load_questions');
            Route::post('sort-questions', 'QuizController@sortQuestions')->name('sort_questions');
            Route::post('delete-question', 'QuizController@deleteQuestion')->name('delete_question');
            Route::post('delete-option', 'QuizController@deleteOption')->name('option_delete');

            Route::post('edit-item', 'CourseController@editItem')->name('edit_item_form');
            Route::post('delete-item', 'CourseController@deleteItem')->name('delete_item');
            Route::post('curriculum_sort', 'CurriculumController@sort')->name('curriculum_sort');

            Route::post('delete-attachment', 'CurriculumController@deleteAttachment')->name('delete_attachment_item');

            Route::post('load-section-items', 'CourseController@loadContents')->name('load_contents');

            Route::get('{id}/pricing', 'CourseController@pricing')->name('edit_course_pricing');
            Route::post('{id}/pricing', 'CourseController@pricingSet');
            Route::get('{id}/drip', 'CourseController@drip')->name('edit_course_drip');
            Route::post('{id}/drip', 'CourseController@dripPost');
            Route::get('{id}/publish', 'CourseController@publish')->name('publish_course');
            Route::post('{id}/publish', 'CourseController@publishPost');
        });

        Route::get('my-courses', 'CourseController@myCourses')->name('my_courses');
        Route::get('my-courses-reviews', 'CourseController@myCoursesReviews')->name('my_courses_reviews');

        Route::group(['prefix' => 'courses-has-quiz'], function () {
            Route::get('/', 'QuizController@quizCourses')->name('courses_has_quiz');
            Route::get('quizzes/{id}', 'QuizController@quizzes')->name('courses_quizzes');
            Route::get('attempts/{quiz_id}', 'QuizController@attempts')->name('quiz_attempts');
            Route::get('attempt/{attempt_id}', 'QuizController@attemptDetail')->name('attempt_detail');
            Route::post('attempt/{attempt_id}', 'QuizController@attemptReview');
        });

        Route::group(['prefix' => 'assignments'], function () {
            Route::get('/', 'AssignmentController@index')->name('courses_has_assignments');
            Route::get('course/{course_id}', 'AssignmentController@assignmentsByCourse')->name('courses_assignments');
            Route::get('submissions/{assignment_id}', 'AssignmentController@submissions')->name('assignment_submissions');
            Route::get('submission/{submission_id}', 'AssignmentController@submission')->name('assignment_submission');
            Route::post('submission/{submission_id}', 'AssignmentController@evaluation');
        });

        Route::group(['prefix' => 'earning'], function () {
            Route::get('/', 'EarningController@earning')->name('earning');
            Route::get('report', 'EarningController@earningReport')->name('earning_report');
        });
        Route::group(['prefix' => 'withdraw'], function () {
            Route::get('/', 'EarningController@withdraw')->name('withdraw');
            Route::post('/', 'EarningController@withdrawPost');

            Route::get('preference', 'EarningController@withdrawPreference')->name('withdraw_preference');
            Route::post('preference', 'EarningController@withdrawPreferencePost');
        });

        Route::group(['prefix' => 'discussions'], function () {
            Route::get('/', 'DiscussionController@index')->name('instructor_discussions');
            Route::get('reply/{id}', 'DiscussionController@reply')->name('discussion_reply');
            Route::post('reply/{id}', 'DiscussionController@replyPost');
        });
    });

    Route::group(['prefix' => 'media'], function () {
        Route::post('upload', 'MediaController@store')->name('post_media_upload');
        Route::get('load_filemanager', 'MediaController@loadFileManager')->name('load_filemanager');
        Route::post('delete', 'MediaController@delete')->name('delete_media');
    });

    Route::group(['prefix' => 'settings'], function () {
        Route::get('/', 'DashboardController@profileSettings')->name('profile_settings');
        Route::post('/', 'DashboardController@profileSettingsPost');

        Route::get('reset-password', 'DashboardController@resetPassword')->name('profile_reset_password');
        Route::post('reset-password', 'DashboardController@resetPasswordPost');
    });

    Route::get('enrolled-courses', 'DashboardController@enrolledCourses')->name('enrolled_courses');
    Route::get('reviews-i-wrote', 'DashboardController@myReviews')->name('reviews_i_wrote');
    Route::get('wishlist', 'DashboardController@wishlist')->name('wishlist');

    Route::get('my-quiz-attempts', 'QuizController@myQuizAttempts')->name('my_quiz_attempts');
    Route::get('list_assignment_view', 'DashboardController@listAssignmentView')->name('list_assignment_view');
    Route::post('upload_assignment', 'DashboardController@uploadAssignment')->name('upload_assignment');
    Route::get('assignment_register_view', 'DashboardController@assignmentRegisterView')->name('assignment_register_view');
    Route::post('register_assignment', 'DashboardController@registerAssignment')->name('register_assignment');
    Route::get('assign_assignment_view/{id}', 'DashboardController@assignAssignmentView')->name('assign_assignment_view');
    Route::get('instructor_assignment_edit/{id}', 'DashboardController@editInstructorAssigment')->name('instructor_assignment_edit');
    Route::post('instructor_assignment_update', 'DashboardController@submitInstructorAssigment')->name('instructor_assignment_update');
    Route::post('assign_assignment_instructor/{id}', 'DashboardController@assignAssignmentInstructor')->name('assign_assignment_instructor');
    Route::post('approve_payment', 'DashboardController@approvePayment')->name('approve_payment');
    Route::post('set_assignment_payment', 'DashboardController@setAssignmentPayment')->name('set_assignment_payment');
    Route::post('download_assignment', 'DashboardController@downloadAssignment')->name('download_assignment');
    Route::post('upload_assignment', 'DashboardController@uploadAssignment')->name('upload_assignment');
    Route::get('admin_assignment', 'AdminController@adminAssignment')->name('admin_assignment');
    Route::get('admin_assignment_view', 'AdminController@adminAssignmentView')->name('admin_assignment_view');
    Route::post('admin_assignment_submit', 'AdminController@adminAssignmentSubmit')->name('admin_assignment_submit');
    Route::post('admin_assignment_update', 'AdminController@adminAssignmentUpdate')->name('admin_assignment_update');
    Route::get('admin_assignment_edit/{id}', 'AdminController@editAssigment')->name('admin_assignment_edit');
    Route::get('admin_assignment_delete/{id}', 'AdminController@deleteAssigment')->name('admin_assignment_delete');
    Route::post('admin_assignment_update_is_for_dashboard', 'AdminController@assigmentUpdateShow')->name('admin_assignment_update_is_for_dashboard');
    Route::post('update_instructor_status', 'AdminController@updateInstructorStatus')->name('update_instructor_status');
    Route::get('assignment_edit/{id}', 'DashboardController@editAssigment')->name('assignment_edit');
    Route::get('dashbord_assignment_view/{id}', 'DashboardController@dashboardAssigmentView')->name('dashbord_assignment_view');
    Route::post('/payment/callback', 'RazorPaymentController@handleCallback');
    
    Route::group(['prefix' => 'purchases'], function () {
        Route::get('/', 'DashboardController@purchaseHistory')->name('purchase_history');
        Route::get('view/{id}', 'DashboardController@purchaseView')->name('purchase_view');
        });
});
        
    Route::get('instructor_info/{id}', 'DashboardController@instructorInfoView')->name('instructor_info');
/**
 * Admin Area
 */
Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'admin']], function () {
    Route::get('/', 'AdminController@index')->name('admin');

    Route::group(['prefix' => 'cms'], function () {
        Route::get('/', 'PostController@posts')->name('posts');
        Route::get('post/create', 'PostController@createPost')->name('create_post');
        Route::post('post/create', 'PostController@storePost');
        Route::get('post/edit/{id}', 'PostController@editPost')->name('edit_post');
        Route::post('post/edit/{id}', 'PostController@updatePost');

        Route::get('page', 'PostController@index')->name('pages');
        Route::get('page/create', 'PostController@create')->name('create_page');
        Route::post('page/create', 'PostController@store');
        Route::get('page/edit/{id}', 'PostController@edit')->name('edit_page');
        Route::post('page/edit/{id}', 'PostController@updatePage');
    });

    Route::group(['prefix' => 'media_manager'], function () {
        Route::get('/', 'MediaController@mediaManager')->name('media_manager');
        Route::post('media-update', 'MediaController@mediaManagerUpdate')->name('media_update');
    });

    Route::group(['prefix' => 'categories'], function () {
        Route::get('/', 'CategoriesController@index')->name('category_index');
        Route::get('create', 'CategoriesController@create')->name('category_create');
        Route::post('create', 'CategoriesController@store');
        Route::get('edit/{id}', 'CategoriesController@edit')->name('category_edit');
        Route::post('edit/{id}', 'CategoriesController@update');
        Route::post('delete', 'CategoriesController@destroy')->name('delete_category');
    });

    Route::group(['prefix' => 'courses'], function () {
        Route::get('/', 'AdminController@adminCourses')->name('admin_courses');
        Route::get('popular', 'AdminController@popularCourses')->name('admin_popular_courses');
        Route::get('featured', 'AdminController@featureCourses')->name('admin_featured_courses');
    });

    Route::group(['prefix' => 'plugins'], function () {
        Route::get('/', 'ExtendController@plugins')->name('plugins');
        Route::get('find', 'ExtendController@findPlugins')->name('find_plugins');
        Route::get('action', 'ExtendController@pluginAction')->name('plugin_action');
    });
    Route::group(['prefix' => 'themes'], function () {
        Route::get('/', 'ExtendController@themes')->name('themes');
        Route::post('activate', 'ExtendController@activateTheme')->name('activate_theme');
        Route::get('find', 'ExtendController@findThemes')->name('find_themes');
    });

    Route::group(['prefix' => 'settings'], function () {
        Route::get('theme-settings', 'SettingsController@ThemeSettings')->name('theme_settings');
        Route::get('invoice-settings', 'SettingsController@invoiceSettings')->name('invoice_settings');
        Route::get('general', 'SettingsController@GeneralSettings')->name('general_settings');
        Route::get('lms-settings', 'SettingsController@LMSSettings')->name('lms_settings');

        Route::get('social', 'SettingsController@SocialSettings')->name('social_settings');
        //Save settings / options
        Route::post('save-settings', 'SettingsController@update')->name('save_settings');
        Route::get('payment', 'PaymentController@PaymentSettings')->name('payment_settings');
        Route::get('storage', 'SettingsController@StorageSettings')->name('storage_settings');
        Route::get('banner_settings', 'SettingsController@bannerSetting')->name('banner_settings');
        Route::post('upload_banners', 'SettingsController@uploadBanner')->name('upload_banners');
        Route::post('delete_banners', 'SettingsController@deleteBanner')->name('delete_banners');
    });

    Route::get('gateways', 'PaymentController@PaymentGateways')->name('payment_gateways');
    Route::get('withdraw', 'SettingsController@withdraw')->name('withdraw_settings');

    Route::group(['prefix' => 'payments'], function () {
        Route::get('/', 'PaymentController@index')->name('payments');
        Route::get('view/{id}', 'PaymentController@view')->name('payment_view');
        Route::get('delete/{id}', 'PaymentController@delete')->name('payment_delete');

        Route::post('update-status/{id}', 'PaymentController@updateStatus')->name('update_status');
    });

    Route::group(['prefix' => 'withdraws'], function () {
        Route::get('/', 'AdminController@withdrawsRequests')->name('withdraws');
    });

    Route::group(['prefix' => 'users'], function () {
        Route::get('/', ['as' => 'users', 'uses' => 'UserController@users']);
        Route::get('create', ['as' => 'add_administrator', 'uses' => 'UserController@addAdministrator']);
        Route::post('create', ['uses' => 'UserController@storeAdministrator']);

        Route::post('block-unblock', ['as' => 'administratorBlockUnblock', 'uses' => 'UserController@administratorBlockUnblock']);
    });

    /**
     * Change Password route
     */
    Route::group(['prefix' => 'account'], function () {
        Route::get('change-password', 'UserController@changePassword')->name('change_password');
        Route::post('change-password', 'UserController@changePasswordPost');
    });
});

/**
 * Single Page
 */
//Route::get('{slug}', 'PostController@singlePage')->name('page');

Route::get('blog', 'PostController@blog')->name('blog');
Route::get('{slug}', 'PostController@postSingle')->name('post');
Route::get('post/{id?}', 'PostController@postProxy')->name('post_proxy');
