<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return redirect()->route('tasks.index');
});

Route::group(['prefix' => 'auth'], function () {
    Route::auth();
});

Route::resource('tasks', 'TaskController', ['only' => ['index', 'store', 'update', 'destroy']]);
Route::resource('users', 'UserController', ['only' => ['index']]);

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/
Route::group(['prefix' => 'api', 'middleware' => ['auth:api', 'api'], 'namespace' => 'Api'], function () {
    Route::resource('tasks', 'TaskController');
});
