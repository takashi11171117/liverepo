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

Route::get('/', function () {
    return "Hello!! This is liverepo's api";
});

Route::group(['prefix' => 'auth'], function () {
    Route::post('register', 'Auth\User\RegisterController@action');
    Route::post('login', 'Auth\User\LoginController@action');
    Route::get('me', 'Auth\User\MeController@action');

    Route::post('admin', 'Auth\Admin\LoginController@action');
});

Route::group(['prefix' => 'oauth', 'namespace' => 'OAuth'], function () {
    Route::group(['prefix' => 'twitter'], function () {
        Route::get('redirect', 'TwitterController@redirect');
        Route::get('callback', 'TwitterController@callback');
    });
});

Route::group(['namespace' => 'Front', 'middleware' => ['assign.guard:api', 'jwt.auth']], function () {
    Route::post('comedy/reports', 'ReportController@post');
    Route::post('users/profile', 'UserController@profile');
});

Route::group(['namespace' => 'Front'], function () {
    Route::group(['prefix' => 'comedy'], function () {
        Route::group(['prefix' => 'reports'], function () {
            Route::get('/', 'ReportController@index');
            Route::get('month/{month}', 'ReportController@findListByMonth');
            Route::get('{date}', 'ReportController@findListByDate');
            Route::get('{id}', 'ReportController@show');
        });

        Route::group(['prefix' => 'report_tags'], function () {
            Route::get('/', 'ReportTagController@index');
            Route::get('tagify', 'ReportTagController@tagify');
            Route::get('{name}', 'ReportTagController@show');
        });
    });

    Route::get('users/{name}', 'UserController@show');
    Route::get('users/{name}/reports', 'ReportController@findListByUser');
});

Route::group(['namespace' => 'Front', 'middleware' => ['assign.guard:api', 'jwt.auth']], function () {
    Route::get('follow_users/{id}', 'FollowUserController@show');
    Route::post('follow_users', 'FollowUserController@store');
    Route::delete('follow_users/{id}', 'FollowUserController@destroy');

    Route::get('follow_report_tags/{id}', 'FollowReportTagController@show');
    Route::post('follow_report_tags', 'FollowReportTagController@store');
    Route::delete('follow_report_tags/{id}', 'FollowReportTagController@destroy');

    Route::get('follow_reports/{id}', 'FollowReportController@show');
    Route::post('follow_reports', 'FollowReportController@store');
    Route::delete('follow_reports/{id}', 'FollowReportController@destroy');

    Route::post('report_comments', 'ReportCommentController@store');
});

Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['assign.guard:admins', 'jwt.auth']], function () {
    // admin
    Route::get('admins', 'AdminController@index');
    Route::post('admins', 'AdminController@store');
    Route::get('admins/{id}', 'AdminController@show');
    Route::put('admins/{id}', 'AdminController@update');
    Route::delete('admins/{id}', 'AdminController@destroy');

    // report
    Route::get('reports', 'ReportController@index');
    Route::post('reports', 'ReportController@store');
    Route::get('reports/{id}', 'ReportController@show');
    Route::put('reports/{id}', 'ReportController@update');
    Route::delete('reports/{id}', 'ReportController@destroy');

    // tag
    Route::get('report_tags/tagify', 'ReportTagController@tagify');
});
