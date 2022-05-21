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
Route::group(['domain' => 'localhost:3000', 'as' => 'web.'], function () {
    Route::get('payments/payment/status', function () {
        //
    })->name('payment.status');
});


Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('payments/check-bank-payment-status', 'App\Http\Web\Controllers\Users\Payments\CheckBankPaymentStatusController');
