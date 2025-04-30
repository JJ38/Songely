import Cookies from 'js-cookie';


const playPauseButton = document.getElementById('play_pause_button');
const skipStartButton = document.getElementById('skip_start_button');
const lockedButton = document.getElementById('locked_button');
const readyButton = document.getElementById('ready_button');

const muteButton = document.getElementById('mute_button_container');
const volumeSlider = document.getElementById('volume_slider');
const muteIcon = document.getElementById('mute_icon');
const volumeIcon = document.getElementById('volume_icon');

const playbackButtonWrapper = document.getElementById('playback_button_wrapper');

const sliderButton = document.getElementById('slider_button');

const playedBar = document.getElementById('played_bar');
const revealedBar = document.getElementById('revealed_bar');

const playIcon = document.getElementById('play_icon');
const pauseIcon = document.getElementById('pause_icon');
const lockedIcon = document.getElementById('locked_icon');
const unlockedIcon = document.getElementById('unlocked_icon');

const albumImageContainer = document.getElementById('album_image_container');

const mainAlbumCover = document.getElementById('main_album_cover');
const leftAlbumCover = document.getElementById('left_album_cover');
const rightAlbumCover = document.getElementById('right_album_cover');

const guessInput = document.getElementById('guess_input');
const autoCompleteContainer = document.getElementById('autocomplete_container');
const autocompleteResults = document.getElementById('autocomplete_results');
const loaderContainer = document.getElementById('loader_container');
const placeholderAutocompleteInputs = document.getElementById('placeholder_autocomplete_inputs');

const iframeElement = document.getElementById('sc-widget');
const guessButton = document.getElementById('guess_button');

const score = document.getElementById('score');

const startingBlurAmount = 40; //px
const lengthOfBlurMilliseconds = 20000;
const lengthOfSliderBar = 900;

const lastFMKey = "aa937b96944a6e3f01b961d9557c641a";
const autoCompleteDebounce = 1000;

let songLengthMs = 30000;
let totalSongLength

let scaleFactor = songLengthMs / lengthOfSliderBar;

let playbackController;
let pausePlayMutex = false;
let isPaused = true;
let isLocked = false;
let queuedPlaybackStateChange = false;
let timer;
let mute = false;
let volume = 50;


let sessionKey = null;
let songTime = 1; //set to 1 not 0 to stop jumping at the start
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

let soundcloud;
let lastGuessInputEpoch = 0;


const referer = "localhost";

const songUrl = "https://soundcloud.com/postmalone/post-malone-something-real";
// const songUrl = "https://soundcloud.com/shaboozey/in-da-club";
// const songUrl = "https://api.soundcloud.com/tracks/302151081";

//737896987
//what-do-you-mean

//use widget for audio
//https://api-widget.soundcloud.com/resolve?url=https%3A//api.soundcloud.com/tracks/1071204931&format=json&client_id=gqKBMSuBw5rbN9rDRYPqKNvF17ovlObu
//https://w.soundcloud.com/player/?url=https://api.soundcloud.com/tracks/{{track_id}} to get infor

const playbackState = {

    REVEAL: 0,
    DONT_REVEAL: 1

}


addEventListeners();


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

            if(isPaused){

                togglePlayback();

            }

            setSongTime(0);
            soundcloud.seekTo(1);

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

    if(readyButton != null){

        readyButton.addEventListener('click', () => {
            readyButton.classList.add("hidden");
            playbackButtonWrapper.classList.remove("hidden");
            startGame();
        });

    }

    if(guessInput != null){

        guessInput.addEventListener("input", (input) => {

            lastGuessInputEpoch = Date.now();
            const userInput = input.target.value;

            if(userInput == ""){

                clearAutoComplete();
                return;

            }else{

                showAutoCompleteLoader();
            }

            setTimeout(() => {

                if((lastGuessInputEpoch + autoCompleteDebounce) <= Date.now()){

                    guessAutocomplete(userInput);

                }

            }, autoCompleteDebounce);

        });

    }

    if(guessButton != null){

        guessButton.addEventListener(('click'), () => {

            submitGuess();

        });

    }

    if(muteButton != null){

        muteButton.addEventListener('click', () => {

            toggleMute();

        });

    }

    if(volumeSlider != null){

        volumeSlider.addEventListener('input', (input) => {

            volume = input.target.value;
            setVolume();

        });

    }

}


async function startGame(){

    await fetch("http://localhost/sanctum/csrf-cookie",{

        method: "GET",
        headers: {
            "Accept": "application/json",
            "Referer": referer
        }

    });

    const xsrf = Cookies.get('XSRF-TOKEN');

    const response = await fetch('http://' + window.location.host + '/api/v1/startgame',{

        method: "POST",
        headers: {
            "Accept": "application/json",
            "Content-Type": "application/json",
            "Referer": referer,
            'X-XSRF-TOKEN': xsrf
        },
        body: JSON.stringify({
            'email': 'test@example.com',
            'password': 'password'
         }),

    });

    console.log(await response.json())

    const song = await fetchSong();

    if(song == null){
        alert("error loading song.")
        return;
    }

    loadSong(song);

}


async function fetchSong(){

    // const url =  window.location.href + "api/v1/getsong";

    const url = 'http://' + window.location.host + '/api/v1/getsong';
    // const url = window.location.href + 'api/v1/getsong';


    try {

        //const response = await axios.get(url);


        const response = await fetch('http://' + window.location.host + '/api/v1/getsong',{

            method: "GET",
            headers: {
                "Accept": "application/json",
                "Referer": referer
            }

        });

        if (!response.status) {
            throw new Error(`Response status: ${response.status}`);
        }

        const json = await response.json();

        console.log(json);

        return json;

    } catch (error) {

        console.error(error.message);

    }

    return null;

}


function parseSong(json){

    console.log

    const song = {

        id: json['id'],
        title: json['title'],
        albumCover: json['albumcover']

    }

    return song;

}


function loadSong(song){

    //initialise soundcloud

    initialiseSoundcloud(getIframeURL(song['id']));
    loadAlbumCover(song['albumCover']);

}

function loadAlbumCover(albumCoverURL){

    if(albumCoverURL != null){

        mainAlbumCover.src = albumCoverURL;
        leftAlbumCover.src = albumCoverURL;
        rightAlbumCover.src = albumCoverURL;

    }


}


function initialiseSoundcloud(songUrl){

    const iframe = document.createElement('iframe');
    iframe.id = "sc-widget";
    iframe.src = songUrl;
    iframe.allow = "autoplay";
    iframe.classList.add("hidden");

    document.body.appendChild(iframe);
    soundcloud = SC.Widget(iframe);

    soundcloud.bind(SC.Widget.Events.READY, function() {

        soundcloud.bind(SC.Widget.Events.PAUSE, soundcloudPaused);
        soundcloud.getDuration((value) => {console.log(value)});
        soundcloud.bind(SC.Widget.Events.FINISH, soundcloudFinished);

        //buffer and play song in background to stop jumping at the start
        setTimeout(() => {
            bufferSong();
        }, 1000);

    });

}


function bufferSong(){

    console.log("bufferSong");

    soundcloud.setVolume(0);
    soundcloud.play();

    setTimeout(() => {

        soundcloud.pause();
        soundcloudIsReady();
        setTimeout(() => {
            soundcloud.setVolume(volume);
        }, 200);
    }, 1000);

}

function soundcloudIsReady(){

    soundcloudReady = true;
    playPauseButton.classList.add('bg-white','hover:bg-pink', 'hover:fill-white');

}

function getIframeURL(id){

    const iframeURL = "https://w.soundcloud.com/player/?url=https://api.soundcloud.com/tracks/" + id;
    return iframeURL;

}


function soundcloudPaused(){

    console.log("soundcloud paused");


    setTimeout(() => {
        soundcloud.seekTo(0);
    }, 200);

}


function soundcloudFinished(){

    togglePlayback();
    updateSlidebar(lengthOfSliderBar);

}




function startTimer(){

    if(!isPaused){
        timer = setInterval(() => {incrementSongTime()}, 10);
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
    //console.log("songTime: " + songTime);
    // console.log("greatestSongTime: " + greatestSongTime);

    if(songTime > songLengthMs){
        songTime = songLengthMs;
        togglePlayback();
    }

    if(songTime > greatestSongTime){

        //stops song playing past unrevealed section if locked
        if(isLocked == playbackState.DONT_REVEAL){

            songTime = greatestSongTime;
            togglePlayback();
            togglePlaybackState();
            return;

        }

        greatestSongTime = songTime;
        updateScore();
        updateAlbumBlur();

    }

    const percentageOfSong = songTime / songLengthMs;
    const sliderPos = percentageOfSong * lengthOfSliderBar;

    updateSliderPosition(sliderPos);
    updateSlidebar(sliderPos);

}


function togglePlayback(){

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

function updateScore(){

    const newScore = parseInt((songLengthMs - greatestSongTime)/10);
    score.innerText = newScore;

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


function toggleMute(){

    mute = !mute;

    console.log(mute);
    setVolume();

    muteIcon.classList.toggle('hidden');
    volumeIcon.classList.toggle('hidden');

}


function setVolume(){

    if(soundcloud == null){
       return;
    }

    if(mute){
        //set directly so the volume prior to muting isnt lost
        soundcloud.setVolume(0);
        return;
    }

    soundcloud.setVolume(volume);

}


async function guessAutocomplete(input){

    const autocompleteURL = "https://ws.audioscrobbler.com/2.0/?method=track.search&track=" + input + "&api_key=" + lastFMKey + "&format=json&limit=8";
    const response = await fetch(autocompleteURL);

    const json = await response.json();

    parseAutocomplete(json);

}

function parseAutocomplete(json){

    const trackArray = json["results"]["trackmatches"]["track"];

    //hide loading symbol
    showAutoCompleteResults();

    for(let i = 0; i < trackArray.length; i++){

        autocompleteResults.appendChild(createAutocompleteElement(trackArray[i]));

    }

}


function createAutocompleteElement(trackData){

    const div = document.createElement('div');
    div.classList = "px-5 py-2 hover:bg-gray-200 hover:cursor-pointer duration-200";
    div.innerText =  trackData['artist'] + " - " + trackData['name'];

    div.addEventListener(('click'), () => {

        guessInput.value = div.innerText;
        clearAutoComplete();

    });

    return div;

}

function showAutoCompleteResults(){

    loaderContainer.classList.add('hidden');
    placeholderAutocompleteInputs.classList.add('hidden');
    autocompleteResults.classList.remove('hidden');

}

function showAutoCompleteLoader(){

    autoCompleteContainer.classList.remove('hidden');
    loaderContainer.classList.remove('hidden');
    placeholderAutocompleteInputs.classList.remove('hidden');
    autocompleteResults.innerHTML = "";


}

function clearAutoComplete(){

    autocompleteResults.innerHTML = "";
    autoCompleteContainer.classList.add('hidden');

}

async function submitGuess(){

    const guess = guessInput.value;
    console.log(guess);

    const url = 'http://' + window.location.host + '/api/v1/guess';
    // const url = window.location.href + 'api/v1/guess';
    const xsrf = Cookies.get('XSRF-TOKEN');

    const response = await fetch(url,{

        method: "POST",
        headers: {
            "Accept": "application/json",
            "Content-Type": "application/json",
            "Referer": referer,
            "X-XSRF-TOKEN": xsrf
        },
        body: JSON.stringify({
            'guess': guess,
        }),

    });

    console.log(await response.json());

}
