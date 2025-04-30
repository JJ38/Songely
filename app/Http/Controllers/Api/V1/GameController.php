<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Song;
use App\Http\Controllers\Controller;
use App\Http\Requests\GuessRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // api/v1/getsong
    public function index(Request $request){

        $song = Song::query()
            ->inRandomOrder()
            ->first();

        $song->albumCover = str_replace('-large.', '-t500x500.', $song->albumCover);
        // session(['test' => 'wadawd']);

        $sessionVariable = session()->get('test');


        return response()->json([
            'id' => $song->id,
            'title' => $song->title,
            'albumCover' => $song->albumCover,
            'message' => $sessionVariable,
            'user' => Auth::user()
        ], 200);

    }
    // api/v1/guess
    public function store(GuessRequest $request){

        $guess = $request->get('guess');

        $sessionData = session('test');

        // Auth::user()->email;
        $request->session()->increment('guessCount');
        $guessCount = $request->session()->get('guessCount');

        return response()->json([
            'correct_guess' =>  true,
            'message' => $guess,
            'guessCount' => $guessCount,
            'sessionData' => $sessionData
        ]);
    }

}
