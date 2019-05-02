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

Route::group(['prefix' => 'admin','middleware' => ['assign.guard:admins','jwt.auth']],function ()
{
    Route::get('/admin', [
        'as'   => 'admin.index',
        'uses' => 'AdminController@index'
    ]);
    Route::post('admin/add', [
        'as' => 'admin.store',
        'uses' => 'AdminController@store'
    ]);
    Route::get('admin/{id}', [
        'as' => 'admin.show',
        'uses' => 'AdminController@show'
    ]);
    Route::put('admin/{id}/update', [
        'as' => 'admin.update',
        'uses' => 'AdminController@update'
    ]);
    Route::delete('admin/{id}/delete', [
        'as' => 'admin.destroy',
        'uses' => 'AdminController@destroy'
    ]);
});
