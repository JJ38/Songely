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

        $request->session()->increment('songNumber');
        session([
            'songToGuess' => $song
        ]);


        return response()->json([
            'id' => $song->id,
            'title' => $song->title,
            'artist' => $song->artist,
            'albumCover' => $song->albumCover,
        ], 200);

    }
    // api/v1/guess
    public function store(GuessRequest $request){

        $guess = $request->get('guess');
        $songToGuess = session()->get('songToGuess');
        $request->session()->increment('guessCount');



        if(!(strtolower($songToGuess['title']) == strtolower($guess['title'])) || !(strtolower($songToGuess['artist']) == strtolower($guess['artist']))){
            //incorrect guess

            return response()->json([
                'correctGuess' =>  false,
                'roundEnd' => $request->session()->get('guessCount') >= 3,
                'anotherRound' => $request->session()->get('songNumber') >= 3,
                'guessCount' => $request->session()->get('guessCount'),
                'songNumber' => $request->session()->get('songNumber'),
            ]);

        }

        //correct guess



        return response()->json([
            'correctGuess' =>  true,
            'message' => $guess,
            'guessCount' => $request->session()->get('guessCount'),
            'songToGuess' => $songToGuess,
            'correctArtist' => $songToGuess['artist'],
            'correctTitle' => $songToGuess['title'],
            'score' =>  $request->get('score'),
            'songNumber' => $request->session()->get('songNumber')
        ]);
    }

}
