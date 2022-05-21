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

Route::group([
    'prefix'    => 'v1',
    'as'        => 'api.v1.',
    'namespace' => 'App\Http\Api\V1\Controllers'
], function () {
    Route::group([
        'as' => 'auth.'
    ], function () {
        Route::post('login', 'Users\Auth\LoginController')->name('login');
        Route::post('verify-otp', 'Users\Auth\VerifyOtpController')->name('verifyOtp');
        Route::middleware('auth:sanctum')->get('logout', 'Users\Auth\LogoutController')->name('logout');
    });

    Route::group([
        'prefix' => 'payments',
        'middleware' => 'auth:sanctum',
    ], function () {

        Route::group([
            'as' => 'gts.'
        ], function () {
            Route::post('gts', 'Users\Payments\GTS\CreateController')->name('create');
            Route::get('gts-check-payment', 'Users\Payments\GTS\CheckPaymentController')->name('checkPayment');
        });

        Route::group([
            'as' => 'telecom.'
        ], function () {
            Route::post('telecom', 'Users\Payments\Telecom\CreateController')->name('create');
            Route::get('telecom-check-payment', 'Users\Payments\Telecom\CheckPaymentController')->name('checkPayment');
        });

        Route::group([
            'as' => 'tmcell.'
        ], function () {
            Route::post('tmcell', 'Users\Payments\Tmcell\CreateController')->name('create');
            Route::get('tmcell-check-payment', 'Users\Payments\Tmcell\CheckPaymentController')->name('checkPayment');
        });

        Route::get('check-bank-payment-status', 'Users\Payments\GTS\CheckPaymentController')->name('checkPayment');
        Route::get('/', 'Users\Payments\ListController')->name('payment.list');
        Route::get('/{payment_id}', 'Users\Payments\FetchController')->name('payment.fetch');
    });
});
