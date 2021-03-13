<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::namespace('API')->name('api.')->group(function () {
    Route::namespace('v1_0')->prefix('v1_0')->name('v1_0.')->group(function () {
        Route::prefix('user')->name('user.')->group(function () {
            Route::get('get-list', 'UserController@getList')->name('get-list');
            Route::post('add', 'UserController@add')->name('add');
            Route::put('edit', 'UserController@edit')->name('edit');
            Route::delete('delete', 'UserController@delete')->name('delete');
        });

        Route::prefix('role')->name('role.')->group(function () {
            Route::get('get-list', 'RoleController@getList')->name('get-list');
            Route::post('add', 'RoleController@add')->name('add');
            Route::put('edit', 'RoleController@edit')->name('edit');
            Route::delete('delete', 'RoleController@delete')->name('delete');
        });

        Route::prefix('project')->name('project.')->group(function () {
            Route::get('get-list', 'ProjectController@getList')->name('get-list');
            Route::post('add', 'ProjectController@add')->name('add');
            Route::put('edit', 'ProjectController@edit')->name('edit');
            Route::delete('delete', 'ProjectController@delete')->name('delete');
        });
    });
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
