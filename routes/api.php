<?php

use App\Http\Controllers\ExchangeRateController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('usd-rates', [ExchangeRateController::class, 'index'])
    ->middleware('throttle:60,1');

Route::get('/greeting', function () {
    return 'Hello World';
});

Route::post('exchange-rates', [ExchangeRateController::class, 'store'])
    ->middleware('throttle:60,1');
