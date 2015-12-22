<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return redirect()->route('tasks.index');
});

Route::group(['middleware' => 'web'], function () {
    Route::group(['prefix' => 'auth'], function() {
        Route::auth();
    });

    Route::resource('tasks', 'TaskController', ['only' => ['index', 'store', 'update', 'destroy']]);
    Route::resource('users', 'UserController', ['only' => ['index']]);
});
