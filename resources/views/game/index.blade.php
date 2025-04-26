<?php
    $albumImageLink = 'https://upload.wikimedia.org/wikipedia/en/thumb/c/cd/Ed_Sheeran_-_Equals.png/250px-Ed_Sheeran_-_Equals.png';
?>

<x-layout :links="[
    'https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=play_arrow,replay,skip_previous']">

    <script src="https://w.soundcloud.com/player/api.js" type="text/javascript"></script>

    <div class="relative">
        
        <div class="w-[320px] h-[390px] bg-white rounded-xl mx-auto pt-8 border drop-shadow-xl/25">

            <div class="w-[220px] m-auto">

                <div class="rounded-2xl">
                    <div id="album_image_container" class="h-[220px] overflow-hidden rounded-xl blur-[40px]">
                        <img id="main_album_cover" src="" 
                         alt="{{ Vite::asset('resources/images/album_cover_placeholder.png') }}"
                        >
                    </div>
                </div>
                
                <div class="mt-8 h-[70px]">

                    <div id="playback_button_wrapper" class="flex justify-between items-center hidden">
            
                        <x-circle-button id="skip_start_button" class="w-[50px] h-[50px] bg-white hover:bg-pink hover:fill-white hover:cursor-pointer duration-200">
                            <svg class="w-6 h-6 my-auto rotate-180" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M52.5 440.6c-9.5 7.9-22.8 9.7-34.1 4.4S0 428.4 0 416L0 96C0 83.6 7.2 72.3 18.4 67s24.5-3.6 34.1 4.4l192 160L256 241l0-145c0-17.7 14.3-32 32-32s32 14.3 32 32l0 320c0 17.7-14.3 32-32 32s-32-14.3-32-32l0-145-11.5 9.6-192 160z"/></svg>
                        </x-circle-button>
            
                        <x-circle-button id="play_pause_button" class="w-[70px] h-[70px] bg-gray-300 hover:cursor-pointer duration-200">
                            <svg id="play_icon" class="h-6 w-6 my-auto pl-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M73 39c-14.8-9.1-33.4-9.4-48.5-.9S0 62.6 0 80L0 432c0 17.4 9.4 33.4 24.5 41.9s33.7 8.1 48.5-.9L361 297c14.3-8.7 23-24.2 23-41s-8.7-32.2-23-41L73 39z"/></svg>
                            <svg id="pause_icon" class="hidden h-6 w-6 my-auto" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M48 64C21.5 64 0 85.5 0 112L0 400c0 26.5 21.5 48 48 48l32 0c26.5 0 48-21.5 48-48l0-288c0-26.5-21.5-48-48-48L48 64zm192 0c-26.5 0-48 21.5-48 48l0 288c0 26.5 21.5 48 48 48l32 0c26.5 0 48-21.5 48-48l0-288c0-26.5-21.5-48-48-48l-32 0z"/></svg>
                        </x-circle-button>
                        
                        <x-circle-button id="locked_button" class="w-[50px] h-[50px] bg-white hover:bg-pink hover:fill-white hover:cursor-pointer duration-200">
                            <svg id="unlocked_icon" class="h-6 w-6 my-auto pl-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M352 144c0-44.2 35.8-80 80-80s80 35.8 80 80l0 48c0 17.7 14.3 32 32 32s32-14.3 32-32l0-48C576 64.5 511.5 0 432 0S288 64.5 288 144l0 48L64 192c-35.3 0-64 28.7-64 64L0 448c0 35.3 28.7 64 64 64l320 0c35.3 0 64-28.7 64-64l0-192c0-35.3-28.7-64-64-64l-32 0 0-48z"/></svg>
                            <svg id="locked_icon" class="hidden h-6 w-6 my-auto pl-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M144 144l0 48 160 0 0-48c0-44.2-35.8-80-80-80s-80 35.8-80 80zM80 192l0-48C80 64.5 144.5 0 224 0s144 64.5 144 144l0 48 16 0c35.3 0 64 28.7 64 64l0 192c0 35.3-28.7 64-64 64L64 512c-35.3 0-64-28.7-64-64L0 256c0-35.3 28.7-64 64-64l16 0z"/></svg>
                        </x-circle-button>                
                                        
                    </div>

                    <div class="flex justify-center h-full">
                        <button id="ready_button" class="text-white text-2xl bg-pink px-6 py-3 rounded-lg hover:bg-pink-300 hover:cursor-pointer duration-200">
                            Ready
                        </button>
                    </div>
                    
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

        <x-circle-button id="slider_button" class="w-[27px] h-[27px] top-[2px] bg-white translate-x-[-50%] translate-y-[-50%] absolute hover:w-[32px] hover:h-[32px] hover:cursor-pointer" style="left: 0px"></x-circle-button>

    </div>

   

    {{-- <div class="bg-white text-xl border border-b-0">

        <x-suggested-song>a team ed sheeran</x-suggested-song>
        <x-suggested-song>a team theme song</x-suggested-song>
        <x-suggested-song>a tear in space glass animals</x-suggested-song>
        <x-suggested-song>a team theme</x-suggested-song>

    </div> --}}

    {{-- <input id="guess_input" class="bg-white h-[60px] w-full border px-5 text-xl" placeholder="Guess a song" type="text" /> --}}

  
    <div class="relative flex flex-col mx-auto w-[1000px] mt-auto mb-8"> 

        <div id="autocomplete_container" class="relative absolute bottom-full bg-white text-xl border border-b-0 w-full z-10 hidden">

            <div id="autocomplete_results" class="hidden">

            </div>

            <div id="placeholder_autocomplete_inputs" class="hover:cursor-progress hidden">

                <x-suggested-song-placeholder>w</x-suggested-song-placeholder>
                <x-suggested-song-placeholder>w</x-suggested-song-placeholder>
                <x-suggested-song-placeholder>w</x-suggested-song-placeholder>
                <x-suggested-song-placeholder>w</x-suggested-song-placeholder>
                <x-suggested-song-placeholder>w</x-suggested-song-placeholder>
                <x-suggested-song-placeholder>w</x-suggested-song-placeholder>
        
            </div>

            <div id="loader_container" class="absolute w-full flex justify-center top-[50%] translate-y-[-50%] hidden">

                <svg aria-hidden="true" class="inline w-16 h-16 text-gray-200 animate-spin dark:text-gray-600 fill-pink" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                    <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                </svg>

            </div>
           
    
        </div> 
    
        <input id="guess_input" class="bg-white h-[60px] w-full border px-5 text-xl" placeholder="Guess a song" type="text" />
       
        <div class="mx-auto mt-4">
            <button id="guess_button" class="text-white text-2xl bg-pink px-6 py-3 rounded-lg w-min hover:bg-pink-300 hover:cursor-pointer duration-200">
                Guess
            </button>
        </div>
      
    </div>
    
    <div class="absolute left-0 top-0 blur-[300px] translate-x-[-90%] translate-y-[-50%] -z-10">
        <img id="left_album_cover" class="w-150" src="" 
        alt="{{ Vite::asset('resources/images/album_cover_placeholder.png') }}"
        >
    </div>
    
    <div class="absolute right-0 bottom-0 blur-[300px] translate-x-[90%] translate-y-[50%] -z-10">
        <img id="right_album_cover" class="w-150 h-150" src="" 
        alt="{{ Vite::asset('resources/images/album_cover_placeholder.png') }}"
        >
    </div>
   
</x-layout>