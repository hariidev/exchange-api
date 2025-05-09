<?php

use App\Http\Controllers\ExchangeRateController;
use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;


Route::get('usd-rates', [ExchangeRateController::class, 'index'])
    ->middleware('throttle:60,1');

Route::post('exchange-rates', [ExchangeRateController::class, 'store'])
    ->middleware('throttle:60,1');

Route::post('register', [AuthController::class, 'register']);
