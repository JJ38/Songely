<?php

namespace App\Http\Controllers;

use App\Models\Song;
use Illuminate\Http\Request;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(){

        $song = Song::query()
            ->inRandomOrder()
            ->first();

        // dd($song);
        $song->albumCover =str_replace('-large.', '-t500x500.', $song->albumCover);

        return response()->json([
            'id' => $song->id,
            'title' => $song->title,
            'albumCover' => $song->albumCover
        ]);

    }

    public function show(string $guess)
    {   
        
        return response()->json([
            'correct_guess' =>  true
        ]);
    }

}
