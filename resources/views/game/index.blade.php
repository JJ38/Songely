<?php
    //$albumImageLink = 'https://upload.wikimedia.org/wikipedia/en/thumb/a/ad/X_cover.png/250px-X_cover.png'
    // $albumImageLink = 'https://upload.wikimedia.org/wikipedia/en/thumb/4/45/Divide_cover.png/250px-Divide_cover.png';
    //$albumImageLink = 'https://upload.wikimedia.org/wikipedia/en/3/3f/Ed_Sheeran_%2B_cover.png';
    // $albumImageLink = 'https://upload.wikimedia.org/wikipedia/en/thumb/c/cd/Ed_Sheeran_-_Equals.png/250px-Ed_Sheeran_-_Equals.png';
    // $albumImageLink = 'https://m.media-amazon.com/images/I/715TN9agt9L.jpg';
    $albumImageLink = 'https://miro.medium.com/v2/resize:fit:1400/1*TUOvhO_6LkPhp0orqH-QNA.jpeg';
    $albumImageLink = 'https://indieground.net/wp-content/uploads/2013/05/indieblog-best-album-covers-80s-01.1-1024x1024.jpg';
?>

<x-layout :links="['https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=play_arrow,replay,skip_previous']">
    
    <div class="relative">
        
        <div class=" w-[320px] h-[390px] bg-white rounded-xl mx-auto pt-8 border drop-shadow-xl/25">

            <div class="w-[220px] m-auto">
                
                <div class="h-[220px] overflow-hidden rounded-xl blur-xl">
                    <img src="{{ $albumImageLink }}" 
                    alt="{{ Vite::asset('resources/images/album_cover_placeholder.png') }}"
                    >
                </div>
                
                <div class="flex justify-between items-center mt-8">
            
                    <x-circle-button class="w-[50px] h-[50px] hover:bg-pink hover:fill-white hover:cursor-pointer duration-200">
                        <svg class="w-6 h-6 my-auto rotate-180" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M52.5 440.6c-9.5 7.9-22.8 9.7-34.1 4.4S0 428.4 0 416L0 96C0 83.6 7.2 72.3 18.4 67s24.5-3.6 34.1 4.4l192 160L256 241l0-145c0-17.7 14.3-32 32-32s32 14.3 32 32l0 320c0 17.7-14.3 32-32 32s-32-14.3-32-32l0-145-11.5 9.6-192 160z"/></svg>
                    </x-circle-button>
        
                    <x-circle-button class="w-[70px] h-[70px] hover:bg-pink hover:fill-white hover:cursor-pointer duration-200">
                        <svg class="h-6 w-6 my-auto pl-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M73 39c-14.8-9.1-33.4-9.4-48.5-.9S0 62.6 0 80L0 432c0 17.4 9.4 33.4 24.5 41.9s33.7 8.1 48.5-.9L361 297c14.3-8.7 23-24.2 23-41s-8.7-32.2-23-41L73 39z"/></svg>
                    </x-circle-button>
                    
                    <x-circle-button class="w-[50px] h-[50px] hover:bg-pink hover:fill-white hover:cursor-pointer duration-200">
                        <svg class="w-6 h-6 my-auto" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M205 34.8c11.5 5.1 19 16.6 19 29.2l0 64 112 0c97.2 0 176 78.8 176 176c0 113.3-81.5 163.9-100.2 174.1c-2.5 1.4-5.3 1.9-8.1 1.9c-10.9 0-19.7-8.9-19.7-19.7c0-7.5 4.3-14.4 9.8-19.5c9.4-8.8 22.2-26.4 22.2-56.7c0-53-43-96-96-96l-96 0 0 64c0 12.6-7.4 24.1-19 29.2s-25 3-34.4-5.4l-160-144C3.9 225.7 0 217.1 0 208s3.9-17.7 10.6-23.8l160-144c9.4-8.5 22.9-10.6 34.4-5.4z"/></svg>
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
        <div class="bg-gray-300 h-[5px] w-[300px] absolute"></div>
        <div class="bg-gray-600 h-[5px] w-[200px] absolute"></div>

        <x-circle-button class="w-[27px] h-[27px] left-[200px] top-[2px] translate-x-[-50%] translate-y-[-50%] absolute hover:w-[32px] hover:h-[32px] hover:cursor-pointer duration-100"></x-circle-button>

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