<?php

use App\Http\Controllers\V1\Admin\AuthController;
use App\Http\Controllers\V1\Admin\PaymentController;
use App\Http\Controllers\V1\Admin\ReportingController;
use App\Http\Controllers\V1\Admin\TransactionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::group(['prefix' => 'v1'], function () {
    Route::group(['prefix' => 'admin'], function () {
        Route::post('login', [AuthController::class, 'webLogin']);
        Route::post('login/mobile', [AuthController::class, 'tokenLogin']);

        Route::group(['middleware' => ['auth:sanctum', 'can:isAdmin']], function () {
            Route::apiResource('transactions', TransactionController::class)->only(['index', 'store']);
            Route::post('payments', [PaymentController::class, 'recordPayment']);
            Route::get('generate_report', [ReportingController::class, 'generateReport']);
        });
    });

    Route::group(['prefix' => 'customer'], function () {
        Route::post('login', [\App\Http\Controllers\V1\Customer\AuthController::class, 'webLogin']);
        Route::post('login/mobile', [\App\Http\Controllers\V1\Customer\AuthController::class, 'tokenLogin']);

        Route::group(['middleware' => ['auth:sanctum']], function () {
            Route::get('transactions', [\App\Http\Controllers\V1\Customer\TransactionController::class, 'getTransactions']);
        });
    });

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/user', function (Request $request) {
            return $request->user();
        });

        Route::get('/logout', function (Request $request) {
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            Auth::guard("web")->logout();
            return response()->json('Successfully logged out');
        });
    });
});

