<?php

use App\Http\Controllers\ExchangeRateController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\ExchangeRateActivityController;
use Illuminate\Support\Facades\Route;

Route::get('usd-rates', [ExchangeRateController::class, 'index'])
    ->middleware('throttle:60,1');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('exchange-rates', [ExchangeRateController::class, 'store'])
    ->middleware('throttle:60,1');
    Route::get('/exchange-rate/activities', [ExchangeRateActivityController::class, 'getStoreActivities']);
});

//Authentication
Route::post('register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
