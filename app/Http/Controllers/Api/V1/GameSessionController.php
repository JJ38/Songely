<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class GameSessionController extends Controller
{

    public function store(Request $request){

        $request->session()->regenerate();

        session([
            'songNumber' => 1,
            'guessCount' => 0
        ]);

        return response()->json([
            'message' => $request->session()->get('test'),
        ]);

    }

}
