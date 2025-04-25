const playPauseButton = document.getElementById('play_pause_button');
const skipStartButton = document.getElementById('skip_start_button');
const lockedButton = document.getElementById('locked_button');

const sliderButton = document.getElementById('slider_button');

const playedBar = document.getElementById('played_bar');
const revealedBar = document.getElementById('revealed_bar');

const playIcon = document.getElementById('play_icon');
const pauseIcon = document.getElementById('pause_icon');
const lockedIcon = document.getElementById('locked_icon');
const unlockedIcon = document.getElementById('unlocked_icon');

const albumImageContainer = document.getElementById('album_image_container');

const startingBlurAmount = 40; //px
const lengthOfBlurMilliseconds = 20000;
const lengthOfSliderBar = 900;
let songLengthMs = 29500;
let totalSongLength

const iframeElement = document.getElementById('sc-widget');

let scaleFactor = songLengthMs / lengthOfSliderBar;

let playbackController;
let pausePlayMutex = false;
let isPaused = true;
let isLocked = false;
let queuedPlaybackStateChange = false;
let timer;

let songTime = 0;
let sliderPos = 0;
let sliderDown = false;
let sliderDownPos = false;
let sliderInitialPos = 0;
let lengthOfRevealedBar = 0;

let startTime;
let greatestSongTime = 0;

let soundcloudReady = false;
let hasntBuffered = true;
let songOffset = 0;


// const songUrl = "https://soundcloud.com/postmalone/post-malone-something-real";
// const songUrl = "https://soundcloud.com/shaboozey/in-da-club";
const songUrl = "https://api.soundcloud.com/tracks/302151081";


//737896987
//what-do-you-mean

//use widget for audio
//https://api-widget.soundcloud.com/resolve?url=https%3A//api.soundcloud.com/tracks/1071204931&format=json&client_id=gqKBMSuBw5rbN9rDRYPqKNvF17ovlObu



//https://w.soundcloud.com/player/?url=https://api.soundcloud.com/tracks/{{track_id}} to get infor 

const playbackState = {

    REVEAL: 0,
    DONT_REVEAL: 1
   
}


const soundcloud = SC.Widget(iframeElement);

soundcloud.bind(SC.Widget.Events.READY, function() {

    bufferSong();
    
    soundcloud.bind(SC.Widget.Events.PAUSE, soundcloudPaused);
    soundcloud.getDuration((value) => {console.log(value)});
    // soundcloud.bind(SC.Widget.Events.PLAY_PROGRESS, (state) => { console.log(state); });

    //buffer and play song in background to stop jumping at the start
    addEventListeners();

});


function bufferSong(){    

    //makes soundcloud retrieve audio files. This will stop the audio from jumping at the start
    soundcloud.seekTo(1000);
    setTimeout(() => { 
        soundcloud.setVolume(100); 
        soundcloud.seekTo(0); 
        soundcloudIsReady(); 
    }, 1000);
    
}

function soundcloudIsReady(){

    soundcloudReady = true;
    playPauseButton.classList.add('bg-white','hover:bg-pink', 'hover:fill-white');

}


function soundcloudPaused(){
    console.log("soundcloud paused");
    if(!hasntBuffered){

    }
}


function addEventListeners(){

    if(playPauseButton != null){

        playPauseButton.addEventListener('click', () => {

            if(songTime == greatestSongTime){

                setPlaybackState(playbackState.REVEAL);

            }

            togglePlayback();

        });
    }

    if(skipStartButton != null){

        skipStartButton.addEventListener('click', () => {

            setSongTime(0);
            soundcloud.seekTo(0);

            if(isPaused){

                togglePlayback();

            }

            setPlaybackState(playbackState.DONT_REVEAL);

        });
    }

    if(lockedButton != null){

        lockedButton.addEventListener('click', () => {
            togglePlaybackState();   
        });
    }

    if(sliderButton != null){

        sliderButton.addEventListener('mousedown', (e) => {

            sliderDown = true;
            sliderDownPos = e.pageX;
            sliderInitialPos = parseInt(sliderButton.style.left.replace('px', ''));

            if(!isPaused){
                togglePlayback();
            }

        });

        document.addEventListener('mouseup', (e) => {
            sliderDown = false;
        });


        document.addEventListener('mousemove', (e) => {
          
            if(sliderDown){

                const delta = e.pageX - sliderDownPos;
                const projectedSliderPos = sliderInitialPos + delta;

                if(projectedSliderPos < 0 || projectedSliderPos > lengthOfRevealedBar){
                    
                    if(projectedSliderPos > lengthOfSliderBar && songTime > songLengthMs){
                        setSongTime(songLengthMs);
                    } else if(projectedSliderPos < 0 && songTime != 0){
                        setSongTime(0);
                    }

                    return;
                }

                sliderPos = sliderInitialPos + delta; 

                setSongTime(scaleFactor * sliderPos);

            }

        });

    }

}


function startTimer(){

    if(!isPaused){
        timer = setInterval(async () => {incrementSongTime()}, 10);
    }

}


function stopTimer(){

    clearInterval(timer);

}


function incrementSongTime(){

    soundcloud.getPosition((value) => {
        // console.log("soundcloudTime: " + value);

        setSongTime(value);

    });

    if(songTime > songLengthMs){
     
        setSongTime(songLengthMs); 
        //stopTimer();
        return;

    }

}


function setSongTime(timeMs){

    songTime = timeMs;

    console.log("songTime: " + songTime);
    // console.log("greatestSongTime: " + greatestSongTime);
    
    if(songTime > songLengthMs){
        songTime = songLengthMs;
        togglePlayback();
    }

    if(songTime > greatestSongTime){

        if(isLocked == playbackState.DONT_REVEAL){

            songTime = greatestSongTime;
            togglePlayback();
            togglePlaybackState();
            return;

        }

        greatestSongTime = songTime;
        updateAlbumBlur();

    }

    const percentageOfSong = songTime / songLengthMs;
    const sliderPos = percentageOfSong * lengthOfSliderBar;

    updateSliderPosition(sliderPos);
    updateSlidebar(sliderPos);

}


function togglePlayback(){


    console.log("toggleplayback");

    if(!soundcloudReady){
        return;
    }

    pausePlayMutex = true;

    isPaused = !isPaused;

    if(isPaused){

        soundcloud.pause();
        stopTimer();

    }else{

        if(songTime > songLengthMs - 1){

            togglePlayback();
            
        }else{

            soundcloud.seekTo(songTime);
            soundcloud.play();
            startTimer();

        }
        
    }

    if(playIcon != null){
        playIcon.classList.toggle('hidden');
    }

    if(pauseIcon != null){
        pauseIcon.classList.toggle('hidden');
    }

}

function togglePlaybackState(){

    isLocked = !isLocked;
    unlockedIcon.classList.toggle('hidden');
    lockedIcon.classList.toggle('hidden');

}

function setPlaybackState(newIsLocked){

    isLocked = newIsLocked;

    if(isLocked){

        lockedIcon.classList.remove('hidden');
        unlockedIcon.classList.add('hidden');

    }else{

        lockedIcon.classList.add('hidden');
        unlockedIcon.classList.remove('hidden');

    }

}


function updateAlbumBlur(){

    const blurAmount = parseInt(startingBlurAmount * ((lengthOfBlurMilliseconds - greatestSongTime) / lengthOfBlurMilliseconds));

    if(blurAmount < 0){

        albumImageContainer.style.filter = "blur(0px)";
        return;
        
    }   

    albumImageContainer.style.filter = "blur(" + blurAmount + "px)";
    

}


function updateSliderPosition(sliderPos){

    sliderButton.style.left = sliderPos + "px";

}


function updateSlidebar(sliderPos){

    //are we the further into the song then at any point previously
    if(songTime == greatestSongTime){

        revealedBar.style.width = sliderPos + "px";
        lengthOfRevealedBar = sliderPos;

    }
    
    playedBar.style.width = sliderPos + "px";

}