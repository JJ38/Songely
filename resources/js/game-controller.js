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

const startingBlurAmount = 24; //px
const lengthOfBlurMilliseconds = 20000;
const lengthOfSliderBar = 900;
const songLengthMs = 30000;

const scaleFactor = songLengthMs / lengthOfSliderBar;

let playbackController;
let pausePlayMutex = false;
let isPaused = true;
let isLocked = false;
let queuedPlaybackStateChange = false;
let timer
let furthestSongPosition = 0;

let songTime = 0;
let sliderPos = 0;
let sliderDown = false;
let sliderDownPos = false;
let sliderInitialPos = 0;
let lengthOfRevealedBar = 0;

let startTime;
let timerStarted = false;
let greatestSongTime = 0;

const playbackState = {

    REVEAL: 0,
    DONT_REVEAL: 1
   
}


window.onSpotifyIframeApiReady = (IFrameAPI) => {
    const element = document.getElementById('embed-iframe');
    
    const options = {
        width: '0',
        height: '0',
        uri: 'spotify:track:7qiZfU4dY1lWllzX7mPBI3' //https://open.spotify.com/embed/track/7qiZfU4dY1lWllzX7mPBI3
    };

    const callback = (EmbedController) => {
        
        playbackController = EmbedController;
        
        addEventListeners(playbackController);

    };

    IFrameAPI.createController(element, options, callback);

};



function addEventListeners(playbackController){

    //playbackController.addListener('playback_update', e => {


    //     if(e.data.isPaused != isPaused){

    //         isPaused = e.data.isPaused;

    //         if(isPaused){

    //             stopTimer();
    //             console.log(songTime);

    //         }else{

    //             if(!timerStarted){
    //                 startTimer();
    //             }
           
                
    //         }

    //         //ui and controller state in sync. The mutext can be opened
    //         pausePlayMutex = !pausePlayMutex;

    //         //check if playback is wanting to be updated immediately
    //         if(queuedPlaybackStateChange){
    //             togglePlayback(playbackController);
    //             queuedPlaybackStateChange = false;
    //         }
    //     }

    //     const songPositionMs = e.data.position;

    //     updateAlbumBlur(songPositionMs);
    //     //updateSliderPosition(songPositionMs);

    // });
      
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
        timer = setInterval(async () => {incrementSongTime(10)}, 10);
    }

}

function stopTimer(){

    clearInterval(timer);

}


function incrementSongTime(incrementAmountMs){

    const newSongTime = songTime + incrementAmountMs;

    if(songTime > songLengthMs){
     
        setSongTime(songLengthMs);
        stopTimer();
        return;

    }

    setSongTime(newSongTime);

}


function setSongTime(timeMs){

    songTime = timeMs;

    console.log("songTime: " + songTime);
    console.log("greatestSongTime: " + greatestSongTime);

    if(songTime > greatestSongTime){

        if(isLocked == playbackState.DONT_REVEAL){

            songTime = greatestSongTime;
            togglePlayback();
            return;

        }

        console.log(isLocked == playbackState.DONT_REVEAL);
        greatestSongTime = songTime;

    }

    const percentageOfSong = songTime / songLengthMs;
    const sliderPos = percentageOfSong * lengthOfSliderBar;

    updateSliderPosition(sliderPos);
    updateSlidebar(sliderPos);

}


function togglePlayback(){

    pausePlayMutex = true;

    isPaused = !isPaused;

    if(isPaused){
        stopTimer();
    }else{
        startTimer();
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


function updateAlbumBlur(songPositionMs){

    if(songPositionMs > furthestSongPosition){

        furthestSongPosition = songPositionMs;
        const blurAmount = startingBlurAmount * ((lengthOfBlurMilliseconds - furthestSongPosition) / lengthOfBlurMilliseconds);

        if(blurAmount < 0){

            albumImageContainer.style.filter = "blur(0px)";
            return;
            
        }   

        albumImageContainer.style.filter = "blur(" + blurAmount + "px)";
    }

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