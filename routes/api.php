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

Route::post("/auth/admin", "AuthAdminController@login");

Route::group(['namespace' => 'Front'], function () {
    Route::get("/", "ReportController@index");
});

// TODO Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['assign.guard:admins','jwt.auth']],function ()
Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => []],function ()
{
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
});
