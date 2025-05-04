<?php

use App\Http\Controllers\Api\V1\GameController;
use App\Http\Controllers\Api\V1\GameSessionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::prefix('v1')->group(function () {

    Route::get('/daily/getsong', [GameController::class, 'index']);
    Route::post('/daily/guess', [GameController::class, 'store']);
    Route::post('/daily/startgame', [GameSessionController::class, 'store']);

    // Route::get('/getsong', [GameController::class, 'index']);
    // Route::post('/guess', [GameController::class, 'store']);

    // Route::post('/guess', [GameController::class, 'store']);

});
