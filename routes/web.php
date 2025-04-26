<?php

use App\Http\Controllers\GameController;
use Illuminate\Support\Facades\Route;

Route::get('/api/getsong', [GameController::class, 'index']);
Route::Post('/api/guess', [GameController::class, 'show']);
Route::get('/', function () { return view('game.index'); });