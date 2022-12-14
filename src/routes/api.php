<?php

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

Route::post('login', 'Api\UserController@login')
    ->name('user.login');

Route::post('user', 'Api\UserController@store')
    ->name('user.create');

Route::group(['as' => 'api.', 'middleware' => 'auth:api'], function () {
    Route::put('user/{user}', 'Api\UserController@update')
        ->name('user.update');

    Route::get('user', 'Api\UserController@index')
        ->name('user.index');

    Orion::resource('category', Api\CategoryController::class);
});
