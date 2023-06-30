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

Route::group([

    'prefix' => 'api'

], function ($router) {
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('user-profile', 'AuthController@me');

    Route::get('get_contact', 'ContactController@index');
    Route::post('add_contact', 'ContactController@add');
    Route::delete('delete_contact/{id}', 'ContactController@delete');

    Route::get('get_award', 'AwardController@index');
    Route::post('add_award', 'AwardController@add');
    Route::delete('delete_award/{id}', 'AwardController@delete');

    Route::get('get_news', 'NewsController@index');
    Route::post('add_news', 'NewsController@add');
    Route::delete('delete_news/{id}', 'NewsController@delete');

    Route::get('get_celebration', 'CelebrationController@index');
    Route::post('add_celebration', 'CelebrationController@add');
    Route::delete('delete_celebration/{id}', 'CelebrationController@delete');

    Route::get('get_birthday', 'BirthdayController@index');
    Route::post('add_birthday', 'BirthdayController@add');
    Route::delete('delete_birthday/{id}', 'BirthdayController@delete');

    Route::get('get_mou', 'MouController@index');
    Route::post('add_mou', 'MouController@add');
    Route::delete('delete_mou/{id}', 'MouController@delete');

    Route::get('get_certificate', 'CertificateController@index');
    Route::post('add_certificate', 'CertificateController@add');
    Route::delete('delete_certificate/{id}', 'CertificateController@delete');
});

