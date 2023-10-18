<?php

use App\Http\Controllers\BankController;
use App\Http\Controllers\Merchant\CheckoutController;
use App\Http\Controllers\Merchant\PaymentPageController;
use App\Http\Controllers\Merchant\TransactionController;
use App\Http\Controllers\MerchantController;
use App\Http\Controllers\MerchantUserController;
use App\Http\Controllers\PayoutsController;
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
//make /login route the default route
Route::redirect('/', '/login');

Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

//Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home');
Route::group(['middleware' => 'auth'], function () {
    Route::resource('users', 'App\Http\Controllers\UserController', ['except' => ['show']]);
    Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
    Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
    Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);
    Route::get('/transactions', [TransactionController::class, 'index'])->name('merchants.transactions.index');
    Route::get('/transactions/dashboard', [TransactionController::class, 'dashboard'])->name('merchants.dashboard.index');

    //update the merchant routes below, group them, protect them with auth middleware and name them accordingly
    Route::middleware(['role:admin'])->group(function () {
        /**
         * Admin routes for merchants
         */
        Route::prefix('merchants')->group(function () {
            Route::get('/list', [MerchantController::class, 'index'])->name('merchants.index');
            Route::get('/create', [MerchantController::class, 'create'])->name('merchants.create');
            Route::post('/', [MerchantController::class, 'store'])->name('merchants.store');

            Route::prefix('payouts')->group(function () {
                Route::get('/merchants', [PayoutsController::class, 'index'])->name('payouts.index');
                Route::get('/initiated', [PayoutsController::class, 'initiated'])->name('payouts.inititated');
                Route::get('/completed', [PayoutsController::class, 'completed'])->name('payouts.completed');
                Route::get('/cancelled', [PayoutsController::class, 'cancelled'])->name('payouts.cancelled');
                Route::get('/initiate', [PayoutsController::class, 'intiate'])->name('payouts.initiate');

            });

            //0202949149 530

            Route::prefix('merchants')->group(function () {
                Route::get('/list', [MerchantController::class, 'index'])->name('merchants.index');
                Route::get('/create', [MerchantController::class, 'create'])->name('merchants.create');
                Route::post('/', [MerchantController::class, 'store'])->name('merchants.store');

                Route::prefix('{merchant}')->group(function () {
                    Route::get('/generate-credentials', [MerchantController::class, 'generateCredentials'])->name('merchants.generate-credentials');
                    Route::get('/', [MerchantController::class, 'show'])->name('merchants.show');
                    Route::get('/edit', [MerchantController::class, 'edit'])->name('merchants.edit');
                    Route::put('/', [MerchantController::class, 'update'])->name('merchants.update');
                    Route::delete('/', [MerchantController::class, 'destroy'])->name('merchants.destroy');

                    // Show the form to create a new merchant user
                    Route::prefix('users')->group(function () {

                        Route::get('/create', [MerchantUserController::class, 'create'])->name('merchants.users.create');
                        Route::post('/', [MerchantUserController::class, 'store'])->name('merchants.users.store');
                        Route::get('/{user}/edit', [MerchantUserController::class, 'edit'])->name('merchants.users.edit');
                        Route::put('/{user}', [MerchantUserController::class, 'update'])->name('merchants.users.update');
                        Route::delete('/{user}', [MerchantUserController::class, 'destroy'])->name('merchants.users.destroy');
                    });
                });
            });
        });

        /**
         * Merchant routes for merchants
         */
        Route::middleware(['role:merchant'])->group(function () {

            Route::resource('bank', BankController::class)->except(['show','edit','update', 'destroy']);
            Route::prefix('payment-pages')->group(function () {
                Route::get('/', [PaymentPageController::class, 'index'])->name('merchants.payment-page.index');
                Route::get('/create', [PaymentPageController::class, 'create'])->name('merchants.payment-page.create');
                Route::post('/', [PaymentPageController::class, 'store'])->name('merchants.payment-page.store');
                Route::get('/{uuid}', [PaymentPageController::class, 'show'])->name('merchants.payment-page.show');
                Route::get('/{uuid}/edit', [PaymentPageController::class, 'edit'])->name('merchants.payment-page.edit');
                Route::put('/{uuid}', [PaymentPageController::class, 'update'])->name('merchants.payment-page.update');
                Route::delete('/{uuid}', [PaymentPageController::class, 'destroy'])->name('merchants.payment-page.destroy');

            });

        });
    });

    Route::get('/payment/checkout/{uuid}', [CheckoutController::class, 'checkout'])->name('merchants.payment.checkout');
    Route::post('/payment/checkout/{uuid}', [CheckoutController::class, 'processCheckout'])->name('merchants.payment.process-checkout');
    Route::get('/payment/checkout/{uuid}/success', [CheckoutController::class, 'success'])->name('merchants.payment.success');
});
