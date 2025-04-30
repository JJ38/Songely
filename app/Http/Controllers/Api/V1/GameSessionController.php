<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class GameSessionController extends Controller
{

    public function store(Request $request){

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            session([
                'test' => 'session variable abcdefg',
                'guessCount' => 0
            ]);

            return response()->json([
                'message' => $request->session()->get('test'),
                'user' => Auth::user()
            ]);
        }

        throw ValidationException::withMessages([
            'email' => __('The provided credentials do not match our records.'),
        ]);

    }

}
