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

    Route::post('add_ourProgram', 'OurProgramController@add');
    Route::post('update_ourProgram/{id}', 'OurProgramController@update');
    Route::delete('delete_ourProgram/{id}', 'OurProgramController@delete');

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

    Route::post('add_eventDetails', 'EventDetailsController@add');

    Route::post('add_expertReview', 'ExpertReviewController@add');
    Route::post('update_expertReview/{id}', 'ExpertReviewController@update');
    Route::delete('delete_expertReview/{id}', 'ExpertReviewController@delete');
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
    Route::get('get_ourProgram', 'OurProgramController@index');
    Route::get('get_programdetails', 'ProgramDetailsController@index');
    Route::get('get_popularCourses', 'PopularCoursesController@index');
    Route::get('get_popularCoursesDetails', 'PopularCoursesDetailsController@index');
    Route::get('get_events', 'EventsController@index');
    Route::post('add_applyNow', 'ApplynowController@add');
    Route::post('add_contact', 'ContactController@add');
   
    Route::get('view_popularCourseDetails/{id}', 'PopularCoursesDetailsController@view');
    Route::get('view_programdetails/{id}', 'ProgramDetailsController@view');

    Route::get('get_expertReview', 'ExpertReviewController@index');
    

});

