<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/




$router->get('/', function () use ($router) {
    echo "<center> Welcome </center>";
});

$router->get('/version', function () use ($router) {
    return $router->app->version();
});
$router->group(['middleware' => 'auth','prefix' => 'api'], function ($router) 
{
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
   
    Route::delete('delete_contact/{id}', 'ContactController@delete');

    Route::post('add_award', 'AwardController@add');
    Route::delete('delete_award/{id}', 'AwardController@delete');

    Route::post('add_news', 'NewsController@add');
    Route::delete('delete_news/{id}', 'NewsController@delete');

    Route::post('add_celebration', 'CelebrationController@add');
    Route::delete('delete_celebration/{id}', 'CelebrationController@delete');

    Route::post('add_birthday', 'BirthdayController@add');
    Route::delete('delete_birthday/{id}', 'BirthdayController@delete');

    Route::post('add_mou', 'MouController@add');
    Route::delete('delete_mou/{id}', 'MouController@delete');

    Route::post('add_certificate', 'CertificateController@add');
    Route::delete('delete_certificate/{id}', 'CertificateController@delete');

    Route::post('add_enquiry', 'EnquiryController@add');
    Route::delete('delete_enquiry/{id}', 'EnquiryController@delete');

    Route::post('add_home_counter', 'HomeCounterController@add');
    Route::post('update_home_counter/{id}', 'HomeCounterController@update');
    Route::delete('delete_home_counter/{id}', 'HomeCounterController@delete');

    
    Route::delete('delete_applyNow/{id}', 'ApplynowController@delete');

    Route::post('add_about_counter', 'AboutCounterController@add');
    Route::post('update_about_counter/{id}', 'AboutCounterController@update');
    Route::delete('delete_about_counter/{id}', 'AboutCounterController@delete');

    Route::post('add_teacher', 'TeacherController@add');
    Route::post('update_teacher/{id}', 'TeacherController@update');
    Route::delete('delete_teacher/{id}', 'TeacherController@delete');

    Route::post('add_coursecategory', 'CourseCategoryController@add');
    Route::post('update_coursecategory/{id}', 'CourseCategoryController@update');
    Route::delete('delete_coursecategory/{id}', 'CourseCategoryController@delete');

    Route::post('add_programdetails', 'ProgramDetailsController@add');
    Route::post('update_programdetails/{id}', 'ProgramDetailsController@update');
    Route::delete('delete_programdetails/{id}', 'ProgramDetailsController@delete');

    Route::post('add_popularCourses', 'PopularCoursesController@add');
    Route::post('update_popularCourses/{id}', 'PopularCoursesController@update');
    Route::delete('delete_popularCourses/{id}', 'PopularCoursesController@delete');

    Route::post('add_popularCoursesDetails', 'PopularCoursesDetailsController@add');
    Route::post('update_popularCoursesDetails/{id}', 'PopularCoursesDetailsController@update');
    Route::delete('delete_popularCoursesDetails/{id}', 'PopularCoursesDetailsController@delete');

    Route::post('add_events', 'EventsController@add');
    Route::post('update_events/{id}', 'EventsController@update');
    Route::delete('delete_events/{id}', 'EventsController@delete');
    Route::post('user-profile', 'AuthController@me');

    Route::get('get_eventDetails', 'EventDetailsController@index');
    Route::post('add_eventDetails', 'EventDetailsController@add');
    Route::post('update_eventDetails/{id}', 'EventDetailsController@update');
    Route::delete('delete_eventDetails/{id}', 'EventsController@delete');


    Route::post('add_expertReview', 'ExpertReviewController@add');
    Route::post('update_expertReview/{id}', 'ExpertReviewController@update');
    Route::delete('delete_expertReview/{id}', 'ExpertReviewController@delete');

    Route::get('get_consulting', 'ConsultingController@index');
    Route::post('update_consulting/{id}', 'ConsultingController@update');
    Route::delete('delete_consulting/{id}', 'ConsultingController@delete');

    Route::get('get_brochuer', 'BrochureController@index');
    Route::post('update_brochuer/{id}', 'BrochureController@update');
    Route::delete('delete_brochuer/{id}', 'BrochureController@delete');

    // Route::post('view_googleReview/{id}', 'GoogleReviewsController@view');

    Route::post('add_googleReview', 'GoogleReviewsController@add');
    Route::post('update_googleReview/{id}', 'GoogleReviewsController@update');
    Route::delete('delete_googleReview/{id}', 'GoogleReviewsController@delete');

    Route::get('download_applynow_cv/{id}', 'ApplynowController@downloadCV');
    Route::get('download_applynow_cl/{id}', 'ApplynowController@downloadCoverLetter');

    Route::post('add_bannerImages', 'BannerImagesController@add');
    Route::post('update_bannerImages/{id}', 'BannerImagesController@update');
    Route::delete('delete_bannerImages/{id}', 'BannerImagesController@delete');

    Route::post('add_hired', 'GetHiredController@add');
    Route::post('update_hired/{id}', 'GetHiredController@update');
    Route::delete('delete_hired/{id}', 'GetHiredController@delete');

    Route::post('add_mentor', 'MentorController@add');
    Route::post('update_mentor/{id}', 'MentorController@update');
    Route::delete('delete_mentor/{id}', 'MentorController@delete');

    Route::post('add_faq', 'FaqController@add');
    Route::post('update_faq/{id}', 'FaqController@update');
    Route::delete('delete_faq/{id}', 'FaqController@delete');

    Route::post('add_alumini', 'AluminiController@add');
    Route::post('update_alumini/{id}', 'AluminiController@update');
    Route::delete('delete_alumini/{id}', 'AluminiController@delete');

    Route::post('add_companyDetails', 'CompanyDetailsController@add');
    Route::post('update_companyDetails/{id}', 'CompanyDetailsController@update');
    Route::delete('delete_companyDetails/{id}', 'CompanyDetailsController@delete');

    Route::post('add_ourOffice', 'OurOfficeController@add');
    Route::post('update_ourOffice/{id}', 'OurOfficeController@update');
    Route::delete('delete_ourOffice/{id}', 'OurOfficeController@delete');

    Route::post('add_logo', 'LogoController@add');
    Route::post('update_logo/{id}', 'LogoController@update');
    Route::delete('delete_logo/{id}', 'LogoController@delete');

    Route::post('add_product', 'ProductController@add');
    Route::post('update_product/{id}', 'ProductController@update');
    Route::delete('delete_product/{id}', 'ProductController@delete');

    Route::post('add_handson_category', 'HandonProjectControllerController@addCategory');
    Route::post('update_handson_category/{id}', 'HandonProjectControllerController@updateCategory');
    Route::delete('delete_handson_category/{id}', 'HandonProjectControllerController@deleteCategory');
    Route::get('get_category', 'HandonProjectControllerController@getCategory');

    Route::get('get_handson_project_details', 'HandonProjectControllerController@getProjectDetails');
    Route::post('add_handson_project_details', 'HandonProjectControllerController@addProjectDetails');
    Route::post('update_handson_project_details/{id}', 'HandonProjectControllerController@updateProjectDetails');
    Route::delete('delete_handson_project_details/{id}', 'HandonProjectControllerController@deleteProjectDetails');

    Route::post('add_module', 'ModuleController@add');
    Route::post('update_module/{id}', 'ModuleController@update');
    Route::delete('delete_module/{id}', 'ModuleController@delete');

});

Route::group([

    'prefix' => 'api'

],function ($router) {


    Route::post('login', 'AuthController@login');
    Route::get('get_contact', 'ContactController@index');
    Route::get('get_award', 'AwardController@index');
    Route::get('get_news', 'NewsController@index');
    Route::get('get_celebration', 'CelebrationController@index');
    Route::get('get_birthday', 'BirthdayController@index');
    Route::get('get_mou', 'MouController@index');
    Route::get('get_certificate', 'CertificateController@index');
    Route::get('get_enquiry', 'EnquiryController@index');
    Route::get('get_home_counter', 'HomeCounterController@index');
    Route::get('get_applyNow', 'ApplynowController@index');
    Route::get('get_about_counter', 'AboutCounterController@index');
    Route::get('get_teacher', 'TeacherController@index');
    Route::get('get_coursecategory', 'CourseCategoryController@index');
    Route::get('get_programdetails', 'ProgramDetailsController@index');
    Route::get('get_popularCourses', 'PopularCoursesController@index');
    Route::get('get_popularCoursesDetails', 'PopularCoursesDetailsController@index');
    Route::get('get_events', 'EventsController@index');
    Route::post('add_applyNow', 'ApplynowController@add');
    Route::post('add_contact', 'ContactController@add');
   
    Route::get('view_popularCourseDetails/{id}', 'PopularCoursesDetailsController@view');
    Route::get('view_programdetails/{id}', 'ProgramDetailsController@view');

    Route::get('get_expertReview', 'ExpertReviewController@index');
    Route::get('view_eventDetails/{id}', 'EventDetailsController@view');
    Route::post('add_consulting', 'ConsultingController@add');
    Route::post('add_brochuer', 'BrochureController@add');

    Route::get('get_googleReview', 'GoogleReviewsController@index');
    Route::get('get_bannerImages', 'BannerImagesController@index');
    Route::get('get_hired', 'GetHiredController@index');
    Route::get('get_mentor', 'MentorController@index');
    Route::get('get_faq', 'FaqController@index');
    Route::get('get_alumini', 'AluminiController@index');
    Route::get('get_companyDetails', 'CompanyDetailsController@index');
    Route::get('get_ourOffice', 'OurOfficeController@index');
    Route::get('get_logo', 'LogoController@index');
    Route::get('get_product', 'ProductController@index');

    Route::get('get_module', 'ModuleController@index');


});

