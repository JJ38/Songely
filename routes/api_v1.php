<?php

use App\Http\Controllers\Api\V1\DailyController;
use App\Http\Controllers\Api\V1\GameSessionController;
use App\Http\Controllers\Api\V1\UnlimitedController;
use Illuminate\Cache\RateLimiting\Unlimited;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::prefix('v1')->group(function () {

    Route::get('/daily/getsong', [DailyController::class, 'index']);
    Route::post('/daily/guess', [DailyController::class, 'store']);
    Route::post('/daily/startgame', [GameSessionController::class, 'store']);

    Route::get('/unlimited/getsong', [UnlimitedController::class, 'index']);

});
