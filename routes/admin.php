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

// Route::post('login', [AuthController::class, 'login'])->name('login');
// Route::middleware('admin.auth')->group(function () {
//ADMIN AUTH

Route::group([
    'prefix' => 'ba',
    'as' => 'admin.',
    'namespace' => 'App\Http\Admin\Controllers'
], function () {

    Route::get('login', 'AuthController@showLoginPage')->name('login.page');
    Route::post('login', 'AuthController@login')->name('login');
    Route::get('logout', 'AuthController@logout')->name('logout');
    Route::post('passwords', 'AuthController@changePassword')->name('password.update');

    Route::middleware('admin.auth')
    ->group(function () {
        Route::get('/settings', 'SettingsController@index')->name('settings');
        Route::get('dashboard', 'DashboardController@index')->name('dashboard');

        Route::get('/customers', 'CustomersController@index')->name('customer.list');
        Route::get('/customers/new', 'CustomersController@showCreateForm')->name('customer.create.form');
        Route::post('/customers', 'CustomersController@create')->name('customer.create');
        Route::get('/customers/{id}', 'CustomersController@view')->name('customer.view');
        Route::get('/customers/update/{id}', 'CustomersController@showUpdateForm')->name('customer.update.form');
        Route::post('/customers/{id}', 'CustomersController@update')->name('customer.update');
        Route::delete('/customers/{id}', 'CustomersController@delete')->name('customer.delete');

        Route::get('/payments', 'PaymentsController@index')->name('payments.list');
        Route::get('/payments/export', 'PaymentsController@exportPayment')->name('payments.export');
        Route::get('/payments/{id}', 'PaymentsController@viewPayment')->name('payment.view');
        Route::put('/payments/{uuid}', 'PaymentsController@retryPayment')->name('payment.retry');

        Route::get('/transactions', 'TransactionsController@index')->name('transactions.list');
        Route::get('/transactions/{id}', 'TransactionsController@viewTransaction')->name('transaction.view');

        Route::group([
            'prefix' => 'statistics',
            'as' => 'statistics.',
            'namespace' => 'Statistics'
        ], function () {
            Route::get('/payments/main', 'PaymentsController@main')->name('payments.main');
            Route::get('/transactions/main', 'TransactionsController@main')->name('transactions.main');
        });
    });
});

