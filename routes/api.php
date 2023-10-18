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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function () {
    //generate the route for the paymentapi controller and hubtel callback controller
    Route::prefix('payment')->group(function () {
        Route::post('/initiate', [App\Http\Controllers\API\PaymentAPIController::class, 'initiate'])->name('payment.initiate');
        Route::get('/verify/{referenceID}', [App\Http\Controllers\API\DirectPaymentAPIController::class, 'verifyTransaction'])->name('directpayment.verify');
    });

    //prefix hubtel call back routes with hubtel
    Route::prefix('hubtel')->group(function () {
        Route::post('/callback/{referenceID}', [App\Http\Controllers\API\HubtelCallbackController::class, 'handleCallback'])->name('payment.hubtel.callback');
        Route::get('/return/{referenceID}', [App\Http\Controllers\API\HubtelCallbackController::class, 'return'])->name('payment.hubtel.return');
        Route::post('/cancel/{referenceID}', [App\Http\Controllers\API\HubtelCallbackController::class, 'cancel'])->name('payment.hubtel.cancel');

        //generate the route for the hubtel direct payment callback controller
        Route::post('/direct-payment/callback/{referenceID}', [App\Http\Controllers\API\HubtelCallbackController::class, 'DirectPaymentSuccess'])->name('directpayment.hubtel.callback.success');
        Route::post('/direct-payment/cancel/{referenceID}', [App\Http\Controllers\API\HubtelCallbackController::class, 'DirectPaymentCancel'])->name('directpayment.hubtel.callback.cancel');
    });

    //generate the the route for the directpaymentapi controller
    Route::prefix('direct-payment')->group(function () {
        Route::post('/initiate', [App\Http\Controllers\API\DirectPaymentAPIController::class, 'initiatePayment'])->name('directpayment.initiate');
        Route::get('/verify/{referenceID}', [App\Http\Controllers\API\DirectPaymentAPIController::class, 'verifyTransaction'])->name('directpayment.verify');
    });

    // USSD
    Route::post('ussd-session', [App\Http\Controllers\API\USSDSessionHandlerController::class, '__invoke']);
    // EOF USSD
});
