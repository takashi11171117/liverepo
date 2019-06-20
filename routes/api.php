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

Route::group(['namespace' => 'Front'], function () {
    Route::get("/", "ReportController@index");

    Route::group(['prefix' => 'comedy'], function() {
        Route::get('report/{id}', [
            'as'   => 'comedy.report.show',
            'uses' => 'ReportController@show'
        ]);
    });
});

Route::group(['prefix' => 'user', 'namespace' => 'Front\User', 'middleware' => ['assign.guard:api','jwt.auth']],function ()
{
    // admin
    Route::get('report/{user_id}', [
        'as'   => 'user.report',
        'uses' => 'ReportController@index'
    ]);

    Route::post('report/add/{user_id}', [
        'as' => 'user.store',
        'uses' => 'ReportController@store'
    ]);
});

Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['assign.guard:admins','jwt.auth']],function ()
{
    // admin
    Route::get('admin', [
        'as'   => 'admin.admin.index',
        'uses' => 'AdminController@index'
    ]);
    Route::post('admin/add', [
        'as' => 'admin.admin.store',
        'uses' => 'AdminController@store'
    ]);
    Route::get('admin/{id}', [
        'as' => 'admin.admin.show',
        'uses' => 'AdminController@show'
    ]);
    Route::put('admin/{id}/update', [
        'as' => 'admin.admin.update',
        'uses' => 'AdminController@update'
    ]);
    Route::delete('admin/{id}/delete', [
        'as' => 'admin.admin.destroy',
        'uses' => 'AdminController@destroy'
    ]);

    // report
    Route::get('report', [
        'as'   => 'admin.report.index',
        'uses' => 'ReportController@index'
    ]);
    Route::post('report/add', [
        'as' => 'admin.report.store',
        'uses' => 'ReportController@store'
    ]);
    Route::get('report/{id}', [
        'as' => 'admin.report.show',
        'uses' => 'ReportController@show'
    ]);
    Route::put('report/{id}/update', [
        'as' => 'admin.report.update',
        'uses' => 'ReportController@update'
    ]);
    Route::delete('report/{id}/delete', [
        'as' => 'admin.report.destroy',
        'uses' => 'ReportController@destroy'
    ]);

    // tag
    Route::get('report_tag/tagify', [
        'as' => 'admin.report_tag.index',
        'uses' => 'ReportTagController@tagify'
    ]);
});
