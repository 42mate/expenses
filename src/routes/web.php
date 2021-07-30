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

Route::get('/', 'HomeController@public_home')
    ->name('public_home');

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', 'HomeController@dashboard')
        ->name('home');

    Route::get('/api/v1/charts/categories', 'HomeController@getChartByCategory')
        ->name('api.chart.category');

    Route::get('/create', 'ExpenseController@create')->name('expense.create');

    Route::post('/create', 'ExpenseController@store')->name('expense.store');

    Route::get('/expense/{expense}', 'ExpenseController@view')->name('expense.view');

    Route::get('/expense/{expense}/edit', 'ExpenseController@edit')->name('expense.edit');

    Route::put('/expense/{expense}', 'ExpenseController@update')->name('expense.update');

    Route::delete('/expense/{expense}', 'ExpenseController@delete')->name('expense.delete');


    Route::get('/expense', 'ExpenseController@index')->name('expense.index');

    Route::get('/category', 'CategoryController@index')->name('category.index');

    Route::get('/category/create', 'CategoryController@create')->name('category.create');

    Route::get('/category/{category}/edit', 'CategoryController@edit')->name('category.edit');

    Route::post('/category/create', 'CategoryController@store')->name('category.store');

    Route::put('/category/{category}', 'CategoryController@update')->name('category.update');

    Route::delete('/category/{category}', 'CategoryController@delete')->name('category.delete');

    Route::get('/wallet/create', 'WalletController@create')->name('wallet.create');

    Route::post('/wallet/create', 'WalletController@store')->name('wallet.store');


    Route::get('/wallet', 'WalletController@index')->name('wallet.index');

    Route::get('/wallet/{wallet}/edit', 'WalletController@edit')->name('wallet.edit');

    Route::put('/wallet/{wallet}/edit', 'WalletController@update')->name('wallet.update');

    Route::delete('/wallet/{wallet}', 'WalletController@delete')->name('wallet.delete');


    Route::get('/tag', 'TagController@index')->name('tag.index');

    Route::get('/tag/{model}/edit', 'TagController@edit')->name('tag.edit');

    Route::put('/tag/{model}/edit', 'TagController@update')->name('tag.update');

    Route::delete('/tag/{model}', 'TagController@delete')->name('tag.delete');

    Route::get('/recurrent_expense/create', 'RecurrentExpenseController@create')
        ->name('recurrent_expense.create');

    Route::post('/recurrent_expense/create', 'RecurrentExpenseController@store')
        ->name('recurrent_expense.store');

    Route::put('/recurrent_expense/{recurrent_expense}', 'RecurrentExpenseController@update')
        ->name('recurrent_expense.update');

    Route::get('/recurrent_expense/{recurrent_expense}', 'RecurrentExpenseController@edit')
        ->name('recurrent_expense.edit');

    Route::delete('/recurrent_expense/{recurrent_expense}', 'RecurrentExpenseController@delete')
        ->name('recurrent_expense.delete');

    Route::get('/recurrent_expense', 'RecurrentExpenseController@index')
        ->name('recurrent_expense.index');

    Route::get('/me', 'UserController@edit')->name('user.edit');

    Route::put('/me', 'UserController@update')->name('user.update');

    Route::name('reports.')->group(function () {
        Route::prefix('reports')->group(function () {
            Route::get('/month_flow', 'ReportsController@monthFlow')->name('month_flow');

        });
    });

    Route::get('/api/v1/expenses/table', 'ExpenseController@apiGetExpenseTable')
        ->name('api.expense.table');

    Route::get('/api/v1/charts/expense/month', 'ExpenseController@apiGetTotalByMonth')
        ->name('api.chart.report.month');
});
