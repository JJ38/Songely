<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class GameSessionController extends Controller
{

    public function store(Request $request){
        // session()->flush();

        //if the dates are the same and completed they have played todays game to COMPLETION
        if((session()->get('date') === date("Y/m/d")) && (session()->get('completed'))){

            return response()->json([
                'gameInitialised' => false,
                'completed' => session()->get('completed'),
                'message' => "already played today",
                'songs' => session()->get('songs'),
                'overallScore' => session()->get('overallScore'),
                'accuracyBonus' => session()->get('accuracyBonus')
            ]);

        }
        //if the player has partially completed todays game
        else if((session()->get('date') === date("Y/m/d")) && !(session()->get('completed'))){

            //return so game state isnt reset
            return response()->json([
                'gameInitialised' => true,
                'gamePartiallyCompleted' => true
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
            'songIDs' => []
        ]);

        return response()->json([
            'gameInitialised' => true,
        ]);

    }

}
