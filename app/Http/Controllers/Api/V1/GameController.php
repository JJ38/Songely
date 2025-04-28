<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Song;
use App\Http\Controllers\Controller;
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
        $song->albumCover = str_replace('-large.', '-t500x500.', $song->albumCover);

        return response()->json([
            'id' => $song->id,
            'title' => $song->title,
            'albumCover' => $song->albumCover,
            'message' => "refactored api",

        ]);

    }

    public function store()
    {
        return response()->json([
            'correct_guess' =>  true,
            'message' => "refactored api",
        ]);
    }

}
