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

Route::get('/', function()
{
    return "Hello!! This is liverepo's api";
});

Route::group(['prefix' => 'auth'], function () {
    Route::post('register', 'Auth\User\RegisterController@action');
    Route::post('login', 'Auth\User\LoginController@action');
    Route::get('me', 'Auth\User\MeController@action');

    Route::post('admin', 'Auth\Admin\LoginController@action');
});

Route::group(['prefix' => 'oauth', 'namespace' => 'OAuth'], function () {
    Route::group(['prefix' => 'twitter'], function() {
        Route::get('redirect', 'TwitterController@redirect');
        Route::get('callback', 'TwitterController@callback');
    });
});

Route::group(['namespace' => 'Front'], function () {
    Route::group(['prefix' => 'comedy'], function() {
        Route::group(['prefix' => 'reports'], function() {
            Route::get("/", "ReportController@index");
            Route::get("month/{month}", "ReportController@findListByMonth");
            Route::get("{date}", "ReportController@findListByDate");
            Route::get('{id}', 'ReportController@show');
            Route::post('/', 'ReportController@post');
        });

        // tag
        Route::get('report_tags/tagify', [
            'as' => 'comedy.report_tags.tagify',
            'uses' => 'ReportTagController@tagify'
        ]);

        // tag
        Route::get('report_tags', [
            'as' => 'comedy.report_tags.index',
            'uses' => 'ReportTagController@index'
        ]);

        // tag
        Route::get('report_tags/{name}', [
            'as' => 'comedy.report_tags.show',
            'uses' => 'ReportTagController@show'
        ]);
    });

    Route::get('users/{name}', [
        'as' => 'users.index',
        'uses' => 'UserController@index'
    ]);
});

Route::group(['namespace' => 'Front', 'middleware' => ['assign.guard:api','jwt.auth']],function ()
{
    Route::post('follow_users', [
        'as' => 'follow_users.store',
        'uses' => 'FollowUserController@store'
    ]);

    Route::delete('follow_users/{id}', [
        'as' => 'follow_users.destroy',
        'uses' => 'FollowUserController@destroy'
    ]);

    Route::get('follow_users/{id}', [
        'as' => 'follow_users.is_following',
        'uses' => 'FollowUserController@isFollowing'
    ]);

    Route::post('follow_report_tags', [
        'as' => 'follow_report_tags.store',
        'uses' => 'FollowReportTagController@store'
    ]);

    Route::delete('follow_report_tags/{id}', [
        'as' => 'follow_report_tags.destroy',
        'uses' => 'FollowReportTagController@destroy'
    ]);

    Route::get('follow_report_tags/{id}', [
        'as' => 'follow_report_tags.is_following',
        'uses' => 'FollowReportTagController@isFollowing'
    ]);

    Route::post('follow_reports', [
        'as' => 'follow_reports.store',
        'uses' => 'FollowReportController@store'
    ]);

    Route::delete('follow_reports/{id}', [
        'as' => 'follow_reports.destroy',
        'uses' => 'FollowReportController@destroy'
    ]);

    Route::get('follow_reports/{id}', [
        'as' => 'follow_reports.is_following',
        'uses' => 'FollowReportController@isFollowing'
    ]);

    Route::post('report_comments', [
        'as' => 'report_comments.store',
        'uses' => 'ReportCommentController@store'
    ]);
});

Route::group(['prefix' => 'setting', 'namespace' => 'Front', 'middleware' => ['assign.guard:api','jwt.auth']],function ()
{
    Route::get('report/{user_id}', [
        'as'   => 'setting.report',
        'uses' => 'SettingController@index'
    ]);

    Route::post('profile', [
        'as' => 'users.profile',
        'uses' => 'SettingController@profile'
    ]);
});

Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['assign.guard:admins','jwt.auth']],function ()
{
    // admin
    Route::get('admins', [
        'as'   => 'admin.admins.index',
        'uses' => 'AdminController@index'
    ]);
    Route::post('admins', [
        'as' => 'admin.admins.store',
        'uses' => 'AdminController@store'
    ]);
    Route::get('admins/{id}', [
        'as' => 'admin.admins.show',
        'uses' => 'AdminController@show'
    ]);
    Route::put('admins/{id}', [
        'as' => 'admin.admins.update',
        'uses' => 'AdminController@update'
    ]);
    Route::delete('admins/{id}', [
        'as' => 'admin.admin.destroy',
        'uses' => 'AdminController@destroy'
    ]);

    // report
    Route::get('reports', [
        'as'   => 'admin.reports.index',
        'uses' => 'ReportController@index'
    ]);
    Route::post('reports', 'ReportController@store');
    Route::get('reports/{id}', 'ReportController@show');
    Route::put('reports/{id}','ReportController@update');
    Route::delete('reports/{id}', 'ReportController@destroy');

    // tag
    Route::get('report_tags/tagify', 'ReportTagController@tagify');
});
