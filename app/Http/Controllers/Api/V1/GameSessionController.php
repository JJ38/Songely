<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class GameSessionController extends Controller
{

    public function store(Request $request){

        //session()->flush();
        date_default_timezone_set('UTC');

        //if the dates are the same and completed they have played todays game to COMPLETION
        if((session()->get('date') === date("Y/m/d")) && (session()->get('completed'))){

            return response()->json([
                'gameInitialised' => false,
                'completed' => session()->get('completed'),
                'message' => "already played today",
                'songs' => session()->get('songs'),
                'scores' => session()->get('scores'),
                'overallScore' => session()->get('overallScore'),
                'accuracyBonus' => session()->get('accuracyBonus'),
                'sessionDate' => session()->get('date'),
                'date' => date("Y/m/d")
            ]);

        }
        //if the player has partially completed todays game
        else if((session()->get('date') === date("Y/m/d")) && !(session()->get('completed'))){

            $songArray = session()->get('songs');
            $song = end($songArray);

            //sets score to zero to stop people from playing song and refreshing, getting to hear the song without losing point
            session(['score' => 0]);

            //returns state of game
            return response()->json([

                'gameInitialised' => true,
                'gamePartiallyCompleted' => true,
                'urn' => $song->urn,
                'albumCover' => $song->albumCover,
                'songNumber' => session()->get('songNumber'),
                'guessCount' => session()->get('guessCount'),
                'score' => 0
            ]);

        }

        //reset/generate game state
        $request->session()->regenerate();

        session([
            'date' => date("Y/m/d"),
            'completed' => false,
            'songNumber' => 0,
            'guessCount' => 0,
            'overallScore' => 0,
            'songIDs' => [],
            'state' => [
                'score' => 0,
                'songNumber' => 0,
            ]
        ]);

        return response()->json([
            'gameInitialised' => true,
        ]);

    }

}
