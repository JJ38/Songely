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
        $filteredTitle = str_replace(" ", "" , str_replace(strpbrk($song->title, '(['), "", $song->title));


        $filteredArtist = str_replace(" ", "" , $song->artist);

        if(strpos($filteredArtist, 'feat.')){
            $filteredArtist = substr($filteredArtist, 0, strpos($filteredArtist, 'feat.'));
        }

        return response()->json([
            'filteredTitle' => $filteredTitle,
            'filteredArtist' => $filteredArtist,
            'urn' => $song->urn,
            'url' => $song->url,
            'title' => $song->title,
            'artist' => $song->artist,
            'albumCover' => $song->albumCover,
        ], 200);

    }

}
