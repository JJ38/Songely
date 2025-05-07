<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Song;
use App\Http\Controllers\Controller;
use App\Http\Requests\GuessRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rules\Unique;
use Symfony\Component\String\TruncateMode;

class DailyController extends Controller
{

    // api/v1/getsong
    public function index(Request $request){

        //check if game completed today

        if(session()->get('completed')){
            return response()->json([
                'message' => "You have already completed todays game"
            ]);
        }

        $songIDArray = session()->get('songIDs');
        $uniqueID = false;
        $songID = 0;

        $numberOfSongs = 346;
        $salt = "ouijasdrfhguasdrfoiphu" . session()->get('songNumber');
        $hashInput = session()->get('date') . $salt;

        $hash = hash('sha256', $hashInput);
        $seed = intval(substr($hash,0,6),16);

        $songID = $seed % $numberOfSongs;


        while(!$uniqueID){

            //check if already fetched
            if(!in_array($songID, $songIDArray)){
                $uniqueID = true;
                session()->push('songIDs', $songID);
            }else{

                $songID = ($songID + 1) % $numberOfSongs;

            }

        }

        $song = Song::query()
            ->find($songID);

        $song->albumCover = str_replace('-large.', '-t500x500.', $song->albumCover);

        //get rid of noise in song title e.g [radio edition]
        $filteredTitle = str_replace(" ", "" , str_replace(strpbrk($song->title, '([-'), "", $song->title));
        $song['filteredTitle'] = $filteredTitle;
        session()->push('songs', $song);

        session()->increment('songNumber');

        session([
            'songToGuess' => $song,
            'guessCount' => 0,
            'accuracyBonus' => true
        ]);

        return response()->json([
            'fitleredTitle' => $filteredTitle,
            'urn' => $song->urn,
            'title' => $song->title,
            'artist' => $song->artist,
            'albumCover' => $song->albumCover,
            'link' => $song->url,
            'songNumber' => session()->get('songNumber'),
            'session' => session()->all()
        ], 200);

    }

    // api/v1/guess
    public function store(GuessRequest $request){

        $guess = $request->get('guess');
        $songToGuess = session()->get('songToGuess');
        session()->increment('guessCount');

        $correctGuess = true;

        if(!(strtolower($songToGuess['filteredTitle']) == strtolower($guess['title'])) || !(strtolower($songToGuess['artist']) == strtolower($guess['artist']))){
            //incorrect guess
            $correctGuess = false;
        }

        $response = [
            'roundEnd' => false,
            'guessCount' => session()->get('guessCount'),
        ];

        //if incorrect and round not over
        if(!$correctGuess){

            session(['accuracyBonus' => false]);

            $response = array_merge($response, [
                'correctGuess' =>  false,
            ]);

        }

        if($correctGuess){

            $response = array_merge($response, [
                'correctGuess' =>  true,
            ]);

        }

        //is round over
        if($correctGuess || session()->get('guessCount') >= 3){

            $roundscore = 0;
            if($correctGuess){
                $roundscore = $request->get('score');
            }

            $currentScore = session()->get('overallScore');
            $newScore = $currentScore +  $roundscore;
            session(['overallScore' => $newScore]);


            session()->push('scores',  $roundscore);


            $response = array_merge($response, [
                'roundEnd' => true,
                'score' =>  $request->get('score'),
                'scores' =>  session()->get('scores'), //debug
                'correctArtist' => $songToGuess['artist'],
                'correctTitle' => $songToGuess['title'],
                'anotherRound' => true,
            ]);

        }

        //is game over
        if(session()->get('songNumber') >= 3){

            session([
                'completed' => true
            ]);

            $overallScore = session()->get('overallScore');

            if(session()->get('accuracyBonus')){
                $overallScore += 1000;
                session(['overallScore' => $overallScore]); //done so it can be shown to the user if they try to play again today
            }

            $response = array_merge($response, [
                'anotherRound' => false,
                'songs' => session()->get('songs'),
                'overallScore' => $overallScore,
                'accuracyBonus' => session()->get('accuracyBonus')
            ]);

        }

        return response()->json($response);

    }

}
