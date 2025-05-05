<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Song;
use App\Http\Controllers\Controller;
use App\Http\Requests\GuessRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class DailyController extends Controller
{

    // api/v1/getsong
    public function index(Request $request){



        $numberOfSongs = 346;
        $salt = "ouijasdrfhguopiasdrfoiphu" . $request->session()->get('songNumber');
        $hashInput = date("Y/m/d") . $salt;

        $hash = hash('sha256', $hashInput);
        $seed = intval(substr($hash,0,6),16);
        //echo $seed % $numberOfSongs;

        $song = Song::query()
            ->find($seed % $numberOfSongs);

        $song->albumCover = str_replace('-large.', '-t500x500.', $song->albumCover);

        $request->session()->increment('songNumber');

        session([
            'songToGuess' => $song,
            'guessCount' => 0
        ]);

        return response()->json([
            'urn' => $song->urn,
            'title' => $song->title,
            'artist' => $song->artist,
            'albumCover' => $song->albumCover,
            'songNumber' => $request->session()->get('songNumber'),
        ], 200);

    }

    // api/v1/guess
    public function store(GuessRequest $request){

        $guess = $request->get('guess');
        $songToGuess = session()->get('songToGuess');
        $request->session()->increment('guessCount');

        $correctGuess = true;

        if(!(strtolower($songToGuess['title']) == strtolower($guess['title'])) || !(strtolower($songToGuess['artist']) == strtolower($guess['artist']))){
            //incorrect guess
            $correctGuess = false;
        }

        if(!$correctGuess){

            return response()->json([
                'correctGuess' =>  false,
                'roundEnd' => $request->session()->get('guessCount') >= 3,
                'anotherRound' => $request->session()->get('songNumber') >= 3,
                'guessCount' => $request->session()->get('guessCount'),
                'songNumber' => $request->session()->get('songNumber'),
                'correctArtist' => $songToGuess['artist'],
                'correctTitle' => $songToGuess['title'],
                'overallScore' => $request->session()->get('overallScore')
            ]);

        }

        if($correctGuess || $request->session()->get('guessCount') == 3){

            //round over
            $currentScore = $request->session()->get('overallScore');
            $newScore = $currentScore + $request->get('score');
            session(['overallScore' => $newScore]);

            return response()->json([
                'correctGuess' =>  true,
                'message' => $guess,
                'guessCount' => $request->session()->get('guessCount'),
                'songToGuess' => $songToGuess,
                'correctArtist' => $songToGuess['artist'],
                'correctTitle' => $songToGuess['title'],
                'score' =>  $request->get('score'),
                'songNumber' => $request->session()->get('songNumber'),
                'overallScore' => $request->session()->get('overallScore')
            ]);

        }

    }

}
