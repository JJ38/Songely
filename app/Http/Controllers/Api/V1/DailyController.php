<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Song;
use App\Http\Controllers\Controller;
use App\Http\Requests\GuessRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rules\Unique;

class DailyController extends Controller
{

    // api/v1/getsong
    public function index(Request $request){

        $songIDArray = $request->session()->get('songIDs');
        $uniqueID = false;
        $songID = 0;

        $numberOfSongs = 346;
        $salt = "ouijasdrfhguopiasdrfoiphu" . $request->session()->get('songNumber');
        $hashInput = date("Y/m/d") . $salt;

        $hash = hash('sha256', $hashInput);
        $seed = intval(substr($hash,0,6),16);

        $songID = $seed % $numberOfSongs;


        while(!$uniqueID){

            //check if already fetched
            if(!in_array($songID, $songIDArray)){
                $uniqueID = true;
                $request->session()->push('songIDs', $songID);
            }else{

                $songID = ($songID + 1) % $numberOfSongs;

            }

        }

        $song = Song::query()
            ->find($songID);

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
            'session' => $request->session()->all()
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

        $response = [
            'roundEnd' => false,
            'guessCount' => $request->session()->get('guessCount'),
        ];

        //if incorrect and round not over
        if(!$correctGuess){

            $response = array_merge($response, [
                'correctGuess' =>  false,
            ]);

        }

        if($correctGuess){

            //round over
            $response = array_merge($response, [
                'correctGuess' =>  true,
            ]);

        }

        //is round over
        if($correctGuess || $request->session()->get('guessCount') >= 3){

            $currentScore = $request->session()->get('overallScore');
            $newScore = $currentScore + $request->get('score');
            session(['overallScore' => $newScore]);

            $response = array_merge($response, [
                'roundEnd' => true,
                'anotherRound' => $request->session()->get('songNumber') < 3,
                'score' =>  $request->get('score'),
                'correctArtist' => $songToGuess['artist'],
                'correctTitle' => $songToGuess['title']
            ]);

        }

        return response()->json($response);

    }

}
