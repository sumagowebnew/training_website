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
    Route::post('update_news/{id}', 'NewsController@update');

    Route::delete('delete_news/{id}', 'NewsController@delete');


    Route::post('add_celebration', 'CelebrationController@add');
    Route::delete('delete_celebration/{id}', 'CelebrationController@delete');

    Route::post('add_birthday', 'BirthdayController@add');
    Route::delete('delete_birthday/{id}', 'BirthdayController@delete');

    Route::post('add_mou', 'MouController@add');
    Route::delete('delete_mou/{id}', 'MouController@delete');

    Route::post('update_certificate/{id}', 'CertificateController@update');
    Route::post('add_certificate', 'CertificateController@add');
    Route::delete('delete_certificate/{id}', 'CertificateController@delete');

    Route::post('update_topranked/{id}', 'ToprankedController@update');
    Route::post('add_topranked', 'ToprankedController@add');
    Route::delete('delete_topranked/{id}', 'ToprankedController@delete');

    Route::post('update_emptygrid/{id}', 'DummydataController@update');
    Route::post('add_emptygrid', 'DummydataController@add');
    Route::delete('delete_emptygrid/{id}', 'DummydataController@delete');

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

    Route::post('add_course', 'CourseCategoryController@add');
    Route::post('update_course/{id}', 'CourseCategoryController@update');
    Route::delete('delete_course/{id}', 'CourseCategoryController@delete');

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

    Route::get('get_counselling', 'CounsellingController@index');
    Route::post('update_counselling/{id}', 'CounsellingController@update');
    Route::delete('delete_counselling/{id}', 'CounsellingController@delete');

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

    Route::get('get_all_mentors', 'MentorController@all_mentors');
    Route::post('add_mentor', 'MentorController@add');
    Route::post('update_mentor/{id}', 'MentorController@update');
    Route::delete('delete_mentor/{id}', 'MentorController@delete');

    Route::post('add_faq', 'FaqController@add');
    Route::post('update_faq/{id}', 'FaqController@update');
    Route::delete('delete_faq/{id}', 'FaqController@delete');

    Route::get('get_all_alumini', 'AluminiController@all_alumini');
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

    Route::post('add_subcourse', 'SubcoursesController@add');
    Route::post('update_subcourse/{id}', 'SubcoursesController@update');
    Route::delete('delete_subcourse/{id}', 'SubcoursesController@delete');

    Route::post('get_subcourse_details_list_by_course_id', 'SubcourseDetailsController@getSubcourseDetailsByCourseId');
    Route::post('add_subcourse_details', 'SubcourseDetailsController@add');
    Route::post('update_subcourse_details/{id}', 'SubcourseDetailsController@update');
    Route::delete('delete_subcourse_details/{id}', 'SubcourseDetailsController@delete');

    Route::post('add_handson_category', 'HandonProjectControllerController@addCategory');
    Route::post('update_handson_category/{id}', 'HandonProjectControllerController@updateCategory');
    Route::delete('delete_handson_category/{id}', 'HandonProjectControllerController@deleteCategory');
    Route::get('get_category', 'HandonProjectControllerController@getCategory');

    Route::get('get_handson_project_details', 'HandonProjectControllerController@getProjectDetails');
    Route::post('add_handson_project_details', 'HandonProjectControllerController@addProjectDetails');
    Route::post('update_handson_project_details/{id}', 'HandonProjectControllerController@updateProjectDetails');
    Route::delete('delete_handson_project_details/{id}', 'HandonProjectControllerController@deleteProjectDetails');

    Route::get('get_course_fee_details_list', 'CourseFeeDetailsController@getCourseFeeDetailsList');
    Route::post('add_course_fee_details', 'CourseFeeDetailsController@add');
    Route::post('update_course_fee_details/{id}', 'CourseFeeDetailsController@update');
    Route::delete('delete_course_fee_details/{id}', 'CourseFeeDetailsController@delete');

    Route::post('add_module', 'ModuleController@add');
    Route::post('update_module/{id}', 'ModuleController@update');
    Route::delete('delete_module/{id}', 'ModuleController@delete');

    Route::post('add_highlight', 'HighlightController@add');
    Route::post('update_highlight/{id}', 'HighlightController@update');
    Route::delete('delete_highlight/{id}', 'HighlightController@delete');

    Route::post('add_our_program_cities', 'OurProgramCitiesController@add');
    Route::post('update_our_program_cities/{id}', 'OurProgramCitiesController@update');
    Route::delete('delete_our_program_cities/{id}', 'OurProgramCitiesController@delete');
    
    Route::post('add_trainedStudentsCount', 'TrainedStudentsCountController@add');
    Route::post('update_trainedStudentsCount/{id}', 'TrainedStudentsCountController@update');
    Route::delete('delete_trainedStudentsCount/{id}', 'TrainedStudentsCountController@delete');

    Route::get('get_all_syllabus', 'SyllabusController@all_syllabus');
    Route::post('add_syllabus', 'SyllabusController@add');
    Route::post('update_syllabus/{id}', 'SyllabusController@update');
    Route::delete('delete_syllabus/{id}', 'SyllabusController@delete');

    Route::get('get_all_highlightDetails', 'HighlightDetailsController@all_highlightDetails');
    Route::post('add_highlightDetails', 'HighlightDetailsController@add');
    Route::post('update_highlightDetails/{id}', 'HighlightDetailsController@update');
    Route::delete('delete_highlightDetails/{id}', 'HighlightDetailsController@delete');

    Route::post('add_event_list', 'EventListController@add');
    Route::post('update_event_list/{id}', 'EventListController@update');
    Route::delete('delete_event_list/{id}', 'EventListController@delete');

    Route::post('add_event_upcoming', 'EventBannerPopupController@add');
    Route::post('update_event_upcoming/{id}', 'EventBannerPopupController@update');
    Route::delete('delete_event_upcoming/{id}', 'EventBannerPopupController@delete');

    Route::post('add_next_cohorts_dates', 'NextCohortsDatesController@add');
    Route::post('update_next_cohorts_dates/{id}', 'NextCohortsDatesController@update');
    Route::delete('delete_next_cohorts_dates/{id}', 'NextCohortsDatesController@delete');

    Route::post('add_learner_review', 'LearnerReviewController@add');
    Route::post('update_learner_review/{id}', 'LearnerReviewController@update');
    Route::delete('delete_learner_review/{id}', 'LearnerReviewController@delete');

    Route::get('get_feecategory', 'FeeCategoryController@index');
    Route::post('add_feecategory', 'FeeCategoryController@add');
    Route::post('update_feecategory/{id}', 'FeeCategoryController@update');
    Route::delete('delete_feecategory/{id}', 'FeeCategoryController@delete');

    Route::post('add_syllabus_pdf', 'SyllabusPdfController@add');
    Route::post('update_syllabus_pdf/{id}', 'SyllabusPdfController@update');
    Route::delete('delete_syllabus_pdf/{id}', 'SyllabusPdfController@delete');

    Route::get('get_funatworkcategory', 'FunatworkController@index');
    Route::post('add_funatworkcategory', 'FunatworkController@add');
    Route::post('update_funatworkcategory/{id}', 'FunatworkController@update');
    Route::delete('delete_funatworkcategory/{id}', 'FunatworkController@delete');

    Route::get('get_funatworkdetails', 'FunatworkdetailsController@index');
    Route::post('add_funatworkdetails', 'FunatworkdetailsController@add');
    Route::post('update_funatworkdetails/{id}', 'FunatworkdetailsController@update');
    Route::delete('delete_funatworkdetails/{id}', 'FunatworkdetailsController@delete');


    Route::get('get_recognitioncategory', 'RecognitioncategoryController@index');
    Route::post('add_recognitioncategory', 'RecognitioncategoryController@add');
    Route::post('update_recognitioncategory/{id}', 'RecognitioncategoryController@update');
    Route::delete('delete_recognitioncategory/{id}', 'RecognitioncategoryController@delete');

    Route::get('get_recognitiondetails', 'RecognitiondetailsController@index');
    Route::post('add_recognitiondetails', 'RecognitiondetailsController@add');
    Route::post('update_recognitiondetails/{id}', 'RecognitiondetailsController@update');
    Route::delete('delete_recognitiondetails/{id}', 'RecognitiondetailsController@delete');

    
    Route::get('get_moucategory', 'MoucategoryController@index');
    Route::post('add_moucategory', 'MoucategoryController@add');
    Route::post('update_moucategory/{id}', 'MoucategoryController@update');
    Route::delete('delete_moucategory/{id}', 'MoucategoryController@delete');

    Route::get('get_moudetails', 'MoudetailsController@index');
    Route::post('add_moudetails', 'MoudetailsController@add');
    Route::post('update_moudetails/{id}', 'MoudetailsController@update');
    Route::delete('delete_moudetails/{id}', 'MoudetailsController@delete');

    Route::get('get_newsdetails', 'NewsdetailsController@index');
    Route::post('add_newsdetails', 'NewsdetailsController@add');
    Route::post('update_newsdetails/{id}', 'NewsdetailsController@update');
    Route::delete('delete_newsdetails/{id}', 'NewsdetailsController@delete');

    Route::get('get_newsletter', 'NewsLetterController@index');
    Route::post('add_newsletter', 'NewsLetterController@add');
    Route::post('update_newsletter/{id}', 'NewsLetterController@update');
    Route::delete('delete_newsletter/{id}', 'NewsLetterController@delete');

    Route::post('/intern-joining/add', 'StudentInfoController@add');
    Route::get('/get-intern-joining', 'StudentInfoController@index');
    // $router->post('/portfolio/update/{id}', 'PortfolioController@update');
    Route::delete('intern-joining/delete/{id}', 'StudentInfoController@destroy');

    Route::post('/intern-completion/add', 'StudentInternshipCompletionController@add');
    Route::get('/get-perticular-intern/{id}', 'StudentInternshipCompletionController@getPerticular');
    Route::get('/get-perticular-completion-intern/{id}', 'StudentInternshipCompletionController@getPerticularCompletion');
    Route::get('/get-intern-completion-details', 'StudentInternshipCompletionController@index');
    Route::delete('intern-completion/delete/{id}', 'StudentInternshipCompletionController@destroy');

    Route::get('/get-intern-id-card-details', 'StudentIdCardInformationController@index');
    Route::post('/intern-id-card/add', 'StudentIdCardInformationController@add');
   
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
    Route::get('get_certificate/{id}', 'CertificateController@index');
    Route::get('get_enquiry', 'EnquiryController@index');
    Route::get('get_home_counter', 'HomeCounterController@index');
    Route::get('get_applyNow', 'ApplynowController@index');
    Route::get('get_about_counter', 'AboutCounterController@index');
    Route::get('get_teacher', 'TeacherController@index');
    Route::get('get_course', 'CourseCategoryController@index');
    Route::get('get_programdetails', 'ProgramDetailsController@index');
    Route::get('get_popularCourses', 'PopularCoursesController@index');
    Route::get('get_popularCoursesDetails', 'PopularCoursesDetailsController@index');
    Route::get('get_events/{id}', 'EventsController@index');
    Route::post('add_applyNow', 'ApplynowController@add');
    Route::post('add_contact', 'ContactController@add');


    Route::post('add_career', 'CareerController@add');
    Route::post('add_itsap', 'ITSapController@AddITSapData');
    
   
    Route::get('view_popularCourseDetails/{id}', 'PopularCoursesDetailsController@view');
    Route::get('view_programdetails/{id}', 'ProgramDetailsController@view');

    Route::get('get_expertReview', 'ExpertReviewController@index');
    Route::get('view_eventDetails/{id}', 'EventDetailsController@view');
    Route::post('add_counselling', 'CounsellingController@add');
    Route::post('add_boot_camp_data', 'CounsellingController@AddBootcampData');
    Route::post('add_boot_camp_applynow', 'CounsellingController@AddBootcampApplyNow');
    Route::post('add_brochuer', 'BrochureController@add');

    Route::get('get_googleReview', 'GoogleReviewsController@index');
    Route::get('get_bannerImages', 'BannerImagesController@index');
    Route::get('get_hired', 'GetHiredController@index');
    Route::post('get_mentor', 'MentorController@index');
    Route::get('get_all_faq', 'FaqController@all_faq');
    Route::get('get_alumini', 'AluminiController@getAllAlumini');
    Route::post('get_alumini_bycourse', 'AluminiController@index');
    Route::get('get_mentors', 'MentorController@all_mentors');
    Route::get('get_companyDetails', 'CompanyDetailsController@index');
    Route::get('get_ourOffice', 'OurOfficeController@index');
    Route::get('get_logo', 'LogoController@index');
    Route::get('get_product', 'ProductController@index');
    Route::get('get_subcourse/{id}', 'SubcoursesController@index');
    Route::get('get_all_subcourses', 'SubcoursesController@all_course');
    Route::get('get_subcourse_details/{id}', 'SubcourseDetailsController@index');
    Route::get('get_dashboard_count', 'DashboardController@get_dashboard_count');

    

    Route::get('get_module', 'ModuleController@index');
    Route::get('get_highlight', 'HighlightController@index');
    Route::get('get_our_program_cities', 'OurProgramCitiesController@index');
    Route::get('get_trainedStudentsCount', 'TrainedStudentsCountController@index');
    Route::get('get_syllabus/{id}', 'SyllabusController@index');
    Route::get('get_highlightDetails/{id}', 'HighlightDetailsController@index');
    Route::get('get_faq/{id}', 'FaqController@index');

    Route::get('get_event_list', 'EventListController@index');

    Route::get('get_course_fee_details_by_course_id/{id}', 'CourseFeeDetailsController@getByCourseId');

    Route::post('get_handson_category_by_course_id', 'HandonProjectControllerController@getCategoryByCouseId');
    Route::post('get_handson_project_by_handsoncategory_id', 'HandonProjectControllerController@getHandsonByHandsonCategoryId');
    
    Route::get('get_event_upcoming', 'EventBannerPopupController@index');

    Route::get('get_learner_review', 'LearnerReviewController@index');

    Route::get('get_next_cohorts_dates', 'NextCohortsDatesController@index');
    Route::get('get_syllabus_pdf/{id}', 'SyllabusPdfController@index');
    Route::post('getAllDataList', 'SyllabusPdfController@getAllDataList');
    Route::get('get_subcourse_details_list', 'SubcourseDetailsController@get_subcourse_details_list');
    Route::get('get_alumini_list', 'AluminiController@all_alumini');
    Route::get('getcoursewiseData', 'LearnerReviewController@getcoursewiseData');
    Route::get('get_emptygrid', 'DummydataController@index');
    Route::get('get_topranked', 'ToprankedController@index');
    Route::get('get_fronteventdetails', 'EventDetailsController@index');
    Route::get('get_frontevents_bycourse/{id}', 'EventDetailsController@get_events_bycourse');
    Route::get('get_frontevents_byevent/{id}', 'EventDetailsController@get_events_byevent');
    Route::get('get_all_events', 'EventsController@all_events');
    Route::get('get_all_certificate', 'CertificateController@all_certificate');
    Route::get('change_status/{table_name}/{id}', 'DummydataController@change_status');

    Route::get('getfront_funatworkcategory', 'FunatworkController@index');
    Route::get('getfront_funatworkdetails/{id}', 'FunatworkdetailsController@get_funatworkdetails');
    Route::get('getfront_recognitioncategory', 'RecognitioncategoryController@index');
    Route::get('getfront_recognitiondetails/{id}', 'RecognitiondetailsController@get_recognitiondetails');
    Route::get('getfront_moucategory', 'MoucategoryController@index');
    Route::get('getfront_moudetails', 'MoudetailsController@get_moudetails');
    Route::get('getfront_newsdetails', 'NewsdetailsController@index');
    Route::get('getfront_newsletter', 'NewsLetterController@index');
    
    
    

});

