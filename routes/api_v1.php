<?php

use App\Http\Controllers\Api\V1\GameController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::prefix('v1')->group(function () {

    Route::get('/getsong', [GameController::class, 'index']);
    Route::post('/guess', [GameController::class, 'store']);

});
