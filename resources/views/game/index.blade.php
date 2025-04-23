<?php
    // $albumImageLink = 'https://upload.wikimedia.org/wikipedia/en/thumb/a/ad/X_cover.png/250px-X_cover.png'
    $albumImageLink = 'https://upload.wikimedia.org/wikipedia/en/thumb/4/45/Divide_cover.png/250px-Divide_cover.png';
    // $albumImageLink = 'https://upload.wikimedia.org/wikipedia/en/3/3f/Ed_Sheeran_%2B_cover.png';
    // $albumImageLink = 'https://upload.wikimedia.org/wikipedia/en/thumb/c/cd/Ed_Sheeran_-_Equals.png/250px-Ed_Sheeran_-_Equals.png';
    // $albumImageLink = 'https://m.media-amazon.com/images/I/715TN9agt9L.jpg';
    // $albumImageLink = 'https://miro.medium.com/v2/resize:fit:1400/1*TUOvhO_6LkPhp0orqH-QNA.jpeg';
    // $albumImageLink = 'https://indieground.net/wp-content/uploads/2013/05/indieblog-best-album-covers-80s-01.1-1024x1024.jpg';
?>

<x-layout :links="[
    'https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=play_arrow,replay,skip_previous']">

    {{-- <div id="embed-iframe"></div>
    <script src="https://open.spotify.com/embed/iframe-api/v1" async>
    </script> --}}

    <iframe id="sc-widget" class="hidden" src="https://w.soundcloud.com/player/?url=https://soundcloud.com/edsheeran/shape-of-you" width="100" height="100" scrolling="no" frameborder="no" allow="autoplay"></iframe>
    <script src="https://w.soundcloud.com/player/api.js" type="text/javascript"></script>
    
    <div class="relative">
        
        <div class=" w-[320px] h-[390px] bg-white rounded-xl mx-auto pt-8 border drop-shadow-xl/25">

            <div class="w-[220px] m-auto">
                
                <div id="album_image_container" class="h-[220px] overflow-hidden rounded-xl blur-[24px] transition duration-833">
                    <img src="{{ $albumImageLink }}" 
                    alt="{{ Vite::asset('resources/images/album_cover_placeholder.png') }}"
                    >
                </div>
                
                <div class="flex justify-between items-center mt-8">
            
                    <x-circle-button id="skip_start_button" class="w-[50px] h-[50px] hover:bg-pink hover:fill-white hover:cursor-pointer duration-200">
                        <svg class="w-6 h-6 my-auto rotate-180" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M52.5 440.6c-9.5 7.9-22.8 9.7-34.1 4.4S0 428.4 0 416L0 96C0 83.6 7.2 72.3 18.4 67s24.5-3.6 34.1 4.4l192 160L256 241l0-145c0-17.7 14.3-32 32-32s32 14.3 32 32l0 320c0 17.7-14.3 32-32 32s-32-14.3-32-32l0-145-11.5 9.6-192 160z"/></svg>
                    </x-circle-button>
        
                    <x-circle-button id="play_pause_button" class="w-[70px] h-[70px] hover:bg-pink hover:fill-white hover:cursor-pointer duration-200">
                        <svg id="play_icon" class="h-6 w-6 my-auto pl-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M73 39c-14.8-9.1-33.4-9.4-48.5-.9S0 62.6 0 80L0 432c0 17.4 9.4 33.4 24.5 41.9s33.7 8.1 48.5-.9L361 297c14.3-8.7 23-24.2 23-41s-8.7-32.2-23-41L73 39z"/></svg>
                        <svg id="pause_icon" class="hidden h-6 w-6 my-auto" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M48 64C21.5 64 0 85.5 0 112L0 400c0 26.5 21.5 48 48 48l32 0c26.5 0 48-21.5 48-48l0-288c0-26.5-21.5-48-48-48L48 64zm192 0c-26.5 0-48 21.5-48 48l0 288c0 26.5 21.5 48 48 48l32 0c26.5 0 48-21.5 48-48l0-288c0-26.5-21.5-48-48-48l-32 0z"/></svg>
                    </x-circle-button>
                    
                    <x-circle-button id="locked_button" class="w-[50px] h-[50px] hover:bg-pink hover:fill-white hover:cursor-pointer duration-200">
                        <svg id="unlocked_icon" class="h-6 w-6 my-auto pl-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M352 144c0-44.2 35.8-80 80-80s80 35.8 80 80l0 48c0 17.7 14.3 32 32 32s32-14.3 32-32l0-48C576 64.5 511.5 0 432 0S288 64.5 288 144l0 48L64 192c-35.3 0-64 28.7-64 64L0 448c0 35.3 28.7 64 64 64l320 0c35.3 0 64-28.7 64-64l0-192c0-35.3-28.7-64-64-64l-32 0 0-48z"/></svg>
                        <svg id="locked_icon" class="hidden h-6 w-6 my-auto pl-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M144 144l0 48 160 0 0-48c0-44.2-35.8-80-80-80s-80 35.8-80 80zM80 192l0-48C80 64.5 144.5 0 224 0s144 64.5 144 144l0 48 16 0c35.3 0 64 28.7 64 64l0 192c0 35.3-28.7 64-64 64L64 512c-35.3 0-64-28.7-64-64L0 256c0-35.3 28.7-64 64-64l16 0z"/></svg>
                    </x-circle-button>                
                                    
                </div>
            
            </div>

        </div>

              {{-- image below card to create shadow --}}

        {{-- <div class="absolute left-[50%] translate-x-[-50%] top-10 -z-10 blur-[50px]">
            <img src="https://upload.wikimedia.org/wikipedia/en/4/45/Divide_cover.png" 
            alt="{{ Vite::asset('resources/images/album_cover_placeholder.png') }}"
            >
        </div> --}}

    </div>

    <div class="relative mt-18 h-[1px] w-[900px] mx-auto">

        <div class="bg-pink h-[5px] w-[900px] absolute"></div>
        <div id="revealed_bar" class="bg-gray-300 h-[5px] w-[0px] absolute"></div>
        <div id="played_bar" class="bg-gray-600 h-[5px] w-[0px] absolute"></div>

        <x-circle-button id="slider_button" class="w-[27px] h-[27px] top-[2px] translate-x-[-50%] translate-y-[-50%] absolute hover:w-[32px] hover:h-[32px] hover:cursor-pointer" style="left: 0px"></x-circle-button>

    </div>

    <div class="w-[1000px] mx-auto">
        <input class="bg-white h-[60px] w-full border mt-12 px-5 text-xl" placeholder="Guess a song" />

        <div class="bg-white text-xl border border-t-0">
    
            <x-suggested-song>a team ed sheeran</x-suggested-song>
            <x-suggested-song>a team theme song</x-suggested-song>
            <x-suggested-song>a tear in space glass animals</x-suggested-song>
            <x-suggested-song>a team theme</x-suggested-song>
    
        </div>
    
    </div>
  
    <div class="mx-auto w-min mt-auto mb-8"> 
        <button class="text-white text-2xl bg-pink px-6 py-3 rounded-lg hover:bg-pink-300 hover:cursor-pointer duration-200">
            Guess
        </button>
    </div>


    
    <div class="absolute left-0 top-0 blur-[300px] translate-x-[-90%] translate-y-[-50%] -z-10">
        <img class="w-150" src="{{ $albumImageLink }}" 
        alt="{{ Vite::asset('resources/images/album_cover_placeholder.png') }}"
        >
    </div>

    
    <div class="absolute right-0 bottom-0 blur-[300px] translate-x-[90%] translate-y-[50%] -z-10">
        <img class="w-150" src="{{ $albumImageLink }}" 
        alt="{{ Vite::asset('resources/images/album_cover_placeholder.png') }}"
        >
    </div>
   
</x-layout>