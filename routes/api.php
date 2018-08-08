<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([
    'prefix' => 'auth'
], function () {

    // https://medium.com/modulr/create-api-authentication-with-passport-of-laravel-5-6-1dc2d400a7f
    Route::post('login', 'AuthController@login');
    Route::post('signup', 'AuthController@signup');



    Route::group([
        'middleware' => 'auth:api'
    ], function() {
        Route::get('logout', 'AuthController@logout');
        Route::get('user', 'AuthController@user');


        // classes Routes
        Route::prefix('classes')->group(function () {

            Route::get('/', 'ClassController@index');
            Route::get('/{class}', 'ClassController@show');

            Route::group([
                'middleware' => 'isAdmin'
            ], function (){
                Route::post('/', 'ClassController@create' );
                Route::patch('/{id}', 'ClassController@update');
                Route::delete('/{id}', 'ClassController@destroy');
            });

        });

        // classmembers Routes
        Route::prefix('classmembers')->group(function () {

            Route::get('/', 'ClassmemberController@index');


            Route::group([
                'middleware' => 'isAdmin'
            ], function (){

                Route::get('/class/{id}', 'ClassmemberController@showClass');
                Route::get('/pupil/{id}', 'ClassmemberController@showPupil');
                Route::get('/raw', 'ClassmemberController@getRaw');

                Route::post('/', 'ClassmemberController@create' );
                Route::patch('/class/{id}', 'ClassmemberController@updateClass');
                Route::delete('/pupil/{id}', 'ClassmemberController@destroyPupil');
            });


        });


        // School Routes
        Route::prefix('schools')->group(function () {

            Route::get('/', 'SchoolController@index');
            Route::get('/{school}', 'SchoolController@show');

            Route::group([
                'middleware' => 'isAdmin'
            ], function (){
                Route::post('/', 'SchoolController@create' );
                Route::patch('/{id}', 'SchoolController@update');
                Route::delete('/{id}', 'SchoolController@destroy');
            });

        });

        // Courses Routes
        Route::prefix('courses')->group(function () {

            Route::get('/', 'CoursController@index');
            Route::get('/{cours}', 'CoursController@show');

            Route::group([
                'middleware' => 'isAdmin'
            ], function (){
                Route::post('/', 'CoursController@create' );
                Route::patch('/{id}', 'CoursController@update');
                Route::delete('/{id}', 'CoursController@destroy');
            });

        });

        Route::prefix('lessons')->group(function () {

            Route::group([
                'middleware' => 'isAdmin'
            ], function (){
                Route::get('/raw', 'LessonController@getRaw');
                Route::post('/', 'LessonController@create' );
                Route::delete('/{id}', 'LessonController@destroy');
            });

            Route::get('/', 'LessonController@index');
            Route::get('/{cours}', 'LessonController@show');

            Route::patch('/{id}', 'LessonController@update')->middleware('isTeacher');



        });



    });
});

