<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\GuessRequest;
use App\Http\Controllers\Controller;
use App\Models\Song;
use Illuminate\Http\Request;

class UnlimitedController extends Controller
{

    public function index(){

        $song = Song::query()
            ->inRandomOrder()
            ->first();

        $song->albumCover = str_replace('-large.', '-t500x500.', $song->albumCover);

        return response()->json([
            'id' => $song->id,
            'title' => $song->title,
            'artist' => $song->artist,
            'albumCover' => $song->albumCover,
        ], 200);

    }

}
