<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/', 'HomeController@home')
        ->name('home');

    Route::get('/api/v1/charts/categories', 'HomeController@getChartByCategory')
        ->name('api.chart.category');

    Route::get('/create', 'ExpenseController@create')->name('expense.create');

    Route::post('/create', 'ExpenseController@store')->name('expense.store');

    Route::get('/expense/{expense}', 'ExpenseController@view')->name('expense.view');

    Route::get('/expense/{expense}/edit', 'ExpenseController@edit')->name('expense.edit');

    Route::put('/expense/{expense}', 'ExpenseController@update')->name('expense.update');


    Route::get('/expense', 'ExpenseController@index')->name('expense.index');

    Route::get('/category', 'CategoryController@index')->name('category');

    Route::get('/category/create', 'CategoryController@create')->name('category.create');

    Route::post('/category/create', 'CategoryController@store')->name('category.store');

    Route::get('/wallet/create', 'WalletController@create')->name('wallet.create');

    Route::post('/wallet/create', 'WalletController@store')->name('wallet.store');

    Route::get('/me', 'UserController@edit')->name('user.edit');

    Route::put('/me', 'UserController@update')->name('user.update');

    Route::name('reports.')->group(function () {
        Route::prefix('reports')->group(function () {
            Route::get('/month_flow', 'ReportsController@monthFlow')->name('month_flow');

        });
    });

    Route::name('theme.')->group(function () {
        Route::prefix('theme')->group(function () {
            Route::get('/', 'StyleGuide@index')->name('index');

            Route::get('/{page}', 'StyleGuide@page')->name('page');
        });
    });

    Route::name('demo.')->group(function() {
        Route::resource('model', 'DemoCrud');
    });

    Route::get('/api/v1/expenses/table', 'ExpenseController@apiGetExpenseTable')
        ->name('api.expense.table');

    Route::get('/api/v1/charts/expense/month', 'ExpenseController@apiGetTotalByMonth')
        ->name('api.chart.report.month');
});