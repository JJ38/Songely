import Cookies from 'js-cookie';

const menu = document.getElementById('menu');
const gameContainer = document.getElementById('game_container');
const homeButton = document.getElementById('home_button');
const songNumberContainer = document.getElementById('song_number_container');

const gameCard = document.getElementById('game_card');

const roundSongTitle = document.getElementById('round_song_title');
const roundSongArtist = document.getElementById('round_song_artist');
const roundSongScore = document.getElementById('round_song_score');
const soundcloudLogo = document.getElementById('soundcloud_logo');

const nextRoundButtonContainer = document.getElementById('next_round_button_container');
const nextRoundButton = document.getElementById('next_round_button');
const endGameButton = document.getElementById('end_game_button');
const widgetTitle = document.getElementById('round_title');

const gameWidget = document.getElementById('game_end_widget');
const gameWidgetScore = document.getElementById('game_widget_score');
const gameSongArtist1 = document.getElementById('soundcloud_card_artist_1');
const gameSongArtist2 = document.getElementById('soundcloud_card_artist_2');
const gameSongArtist3 = document.getElementById('soundcloud_card_artist_3');

const gameSongImage1 = document.getElementById('soundcloud_card_image_1');
const gameSongImage2 = document.getElementById('soundcloud_card_image_2');
const gameSongImage3 = document.getElementById('soundcloud_card_image_3');

const gameSongTitle1 = document.getElementById('soundcloud_card_title_1');
const gameSongTitle2 = document.getElementById('soundcloud_card_title_2');
const gameSongTitle3 = document.getElementById('soundcloud_card_title_3');

const gameSongScore1 = document.getElementById('game_song_score_1');
const gameSongScore2 = document.getElementById('game_song_score_2');
const gameSongScore3 = document.getElementById('game_song_score_3');

const gameSongBar1 = document.getElementById('game_song_bar_1');
const gameSongBar2 = document.getElementById('game_song_bar_2');
const gameSongBar3 = document.getElementById('game_song_bar_3');

const soundcloudCardLink1 = document.getElementById('soundcloud_card_link_1');
const soundcloudCardLink2 = document.getElementById('soundcloud_card_link_2');
const soundcloudCardLink3 = document.getElementById('soundcloud_card_link_3');
const unlimitedSoundcloudCardLink= document.getElementById('unlimited_soundcloud_card_link');

const accuracyBonus = document.getElementById('accuracy_bonus');

const playbackButtonsContainer = document.getElementById('playback_button_wrapper')
const playPauseButton = document.getElementById('play_pause_button');
const skipStartButton = document.getElementById('skip_start_button');
const lockedButton = document.getElementById('locked_button');
const dailyButton = document.getElementById('ready_button');
const unlimitedButton = document.getElementById('unlimited_button');

const muteButton = document.getElementById('mute_button_container');
const volumeSlider = document.getElementById('volume_slider');
const muteIcon = document.getElementById('mute_icon');
const volumeIcon = document.getElementById('volume_icon');

const sliderButton = document.getElementById('slider_button');

const playbackBarContainer = document.getElementById('playback_bar_container');
const playedBar = document.getElementById('played_bar');
const revealedBar = document.getElementById('revealed_bar');

const playIcon = document.getElementById('play_icon');
const pauseIcon = document.getElementById('pause_icon');
const lockedIcon = document.getElementById('locked_icon');
const unlockedIcon = document.getElementById('unlocked_icon');

const albumImageContainer = document.getElementById('album_image_container');
const vinylLoader = document.getElementById('vinyl_loader');

const mainAlbumCover = document.getElementById('main_album_cover');
const leftAlbumCover = document.getElementById('left_album_cover');
const rightAlbumCover = document.getElementById('right_album_cover');

const guessInputContainer = document.getElementById('guess_input_container');
const guessInput = document.getElementById('guess_input');
const autoCompleteContainer = document.getElementById('autocomplete_container');
const autocompleteResults = document.getElementById('autocomplete_results');
const loaderContainer = document.getElementById('loader_container');
const placeholderAutocompleteInputs = document.getElementById('placeholder_autocomplete_inputs');

const guessButton = document.getElementById('guess_button');

const userScore = document.getElementById('score');
const userLives = document.getElementById('lives');
const userSong = document.getElementById('song_number');

const startingBlurAmount = 40; //px
const lengthOfBlurMilliseconds = 20000;
let lengthOfSliderBar = 900;

const lastFMKey = "aa937b96944a6e3f01b961d9557c641a";
const autoCompleteDebounce = 1000;


let song = null;

let songLengthMs = 30000;
let scaleFactor = songLengthMs / lengthOfSliderBar;

let gamemode;
let isPaused = true;
let isLocked = false;
let timer;
let mute = false;
let volume = 50;


let iframe;
let songTime = 1; //set to 1 not 0 to stop jumping at the start
let sliderPos = 0;
let sliderDown = false;
let sliderDownPos = false;
let sliderInitialPos = 0;
let lengthOfRevealedBar = 0;
let currentScore = 3000;

let lives = 3;
let noOfSongs = 3;
let guessCount = 0;

let greatestSongTime = 0;

let soundcloudReady = false;

let soundcloud;
let soundcloudBackground;
let lastGuessInputEpoch = 0;

let autocompleteGuess;

const referer = "localhost";

const playbackState = {

    REVEAL: 0,
    DONT_REVEAL: 1

}

const gameMode = {

    DAILY: 0,
    UNLIMITED: 1

}


addEventListeners();


function addEventListeners(){

    addEventListener("resize", (event) => {

        lengthOfSliderBar = playbackBarContainer.getBoundingClientRect().width

    });

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

    if(dailyButton != null){

        dailyButton.addEventListener('click', () => {

            gamemode = gameMode.DAILY;
            showGameUI();
            startGame();

        });

    }

    if(unlimitedButton != null){

        unlimitedButton.addEventListener('click', () => {

            gamemode = gameMode.UNLIMITED;
            showGameUI();
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

    if(nextRoundButton != null){

        nextRoundButton.addEventListener('click', () => {

            console.log("nextroundbutton");
            document.body.removeChild(soundcloudBackground);
            updateSongNumber(song['songNumber']);
            resetGameState();
            loadSong();

        });

    }

    if(homeButton != null){

        homeButton.addEventListener('click', () => {

            hideGameUI();
            showMenuUI();
            resetGameState();
            killGame();

        });

    }

    if(endGameButton != null){

        endGameButton.addEventListener('click', () => {

            hideGameUI();
            showMenuUI();
            resetGameState();
            killGame();

        });

    }

}


function killGame(){

    stopTimer();

    const iframes = document.querySelectorAll('iframe');

    for(let i = 0; i < iframes.length; i++){

        document.body.removeChild(iframes[0]);

    }

}


function showGameUI(){

    menu.classList.add('hidden');
    gameContainer.classList.remove('hidden');
    homeButton.classList.remove('hidden');
    nextRoundButton.classList.remove('hidden');

    if(gamemode == gameMode.DAILY){
        songNumberContainer.classList.remove('hidden');
    }

}


function hideGameUI(){

    menu.classList.add('hidden');
    songNumberContainer.classList.add('hidden')
    gameContainer.classList.add('hidden');
    homeButton.classList.remove('hidden');

}

function showMenuUI(){

    menu.classList.remove('hidden');
    gameContainer.classList.add('hidden');
    homeButton.classList.add('hidden');

}

async function startGame(){


    if(gamemode == gameMode.DAILY){

        startDailyGame();

    }else{

        startUnlimitedGame();

    }

}



async function startDailyGame(){


    await fetch(location.protocol + "//" + window.location.host + "/sanctum/csrf-cookie",{

        method: "GET",
        headers: {
            "Accept": "application/json",
            "Referer": referer
        }

    });

    const xsrf = Cookies.get('XSRF-TOKEN');

    const response = await fetch(location.protocol + '//' + window.location.host + '/api/v1/daily/startgame',{

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

    if(!response.ok){
        alert("error starting game");
    }

    const json = await response.json();
    console.log(json);

    if(json['completed'] === true){

        showGameEndWidget(json);
        return;

    }else if(json['gamePartiallyCompleted'] === true){

        console.log(json);
        song = json;
        loadSong();
        updateSongNumber(json['songNumber']);
        updateLives(lives - json['guessCount']);
        setSongTime(songLengthMs); //reveals song and sets score to zero to stop cheating by refreshing the page
        setSongTime(0);

    }else{

        await startRound();
        loadSong();

    }

}


async function startUnlimitedGame(){

    await startRound()
    loadSong();

}


async function startRound(){

    //used in unlimited game mode
    soundcloudReady = false;

    song = await fetchSong();

    filterTitle(song['title']);
    console.log(song);

    if(song == null){
        alert("error loading song.")
        return false;
    }

    return true;

}


function filterTitle(songTitle){

    const chars = ['[', '(',];

    console.log(songTitle);

    const title = songTitle.replaceAll(" ", "")

    for(let i = 0; i < title.length; i++){

        for(let j = 0; j < chars.length; j++){

            if(title[i] == chars[j]){
                // console.log(chars[j] + " at index " + i);
                return title.substring(0, i).replaceAll(" ", "");

            }

        }

    }

    return title;
}


function filterArtist(songArtist){

    const artist = songArtist.replaceAll(" ", "");
    const index = songArtist.indexOf('feat.');

    if(index != -1){

        return artist.substring(0, index);

    }

    return artist;

}


function resetGameState(){

    console.log("resetgamestate");

    songTime = 0;
    greatestSongTime = 0;
    sliderPos = 0;
    lengthOfRevealedBar = 0;
    isPaused= true;
    guessCount = 0;

    mainAlbumCover.classList.add('hidden');
    leftAlbumCover.classList.add('hidden');
    rightAlbumCover.classList.add('hidden');

    mainAlbumCover.classList.add('opacity-0');
    leftAlbumCover.classList.add('opacity-0');
    rightAlbumCover.classList.add('opacity-0');

    vinylLoader.classList.remove('hidden');

    playIcon.classList.remove('hidden');
    pauseIcon.classList.add('hidden');
    playPauseButton.classList.remove('bg-white', "hover:bg-pink", "hover:fill-white");

    gameWidget.classList.add('hidden');
    gameWidget.style = "";

    accuracyBonus.classList.add('hidden');

    //show song details
    widgetTitle.classList.add('hidden');
    roundSongArtist.classList.add('hidden');
    roundSongTitle.classList.add('hidden');
    roundSongScore.classList.add('hidden');


    //hide playback
    playbackButtonsContainer.classList.remove('hidden');
    playbackButtonsContainer.classList.remove('h-0');


    //change game card size
    gameCard.classList = "py-10 px-10 w-[320px] h-[390px] bg-white rounded-xl border drop-shadow-xl/25 duration-1000";
    albumImageContainer.style.filter = "";
    albumImageContainer.style.height = "";
    albumImageContainer.classList = "h-[220px] overflow-hidden rounded-xl blur-[40px]";

    soundcloudLogo.classList.add('hidden');

    mainAlbumCover.classList.add("opacity-0");
    mainAlbumCover.classList.add("duration-1000");

    nextRoundButtonContainer.classList.add('hidden');


    updateLives(lives);
    updateScore(3000);
    updateSliderPosition(sliderPos)
    updateSlidebar(sliderPos, true);
    updateAlbumBlur();

}


async function fetchSong(){

    let url;

    if(gamemode == gameMode.DAILY){

        url = location.protocol + '//' + window.location.host + '/api/v1/daily/getsong';

    }else{

        url = location.protocol + '//' + window.location.host + '/api/v1/unlimited/getsong';

    }

    try {

        const response = await fetch(url,{

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


function loadSong(){

    initialiseSoundcloud(getIframeURL(song['urn']));

}

function showAlbumCover(){

    vinylLoader.classList.add('hidden');

    mainAlbumCover.classList.remove('opacity-0');
    leftAlbumCover.classList.remove('opacity-0');
    rightAlbumCover.classList.remove('opacity-0');

}


function loadAlbumCover(albumCoverURL){

    //needed to be done before animating opacity as it would stop the opacity animatio otherwise
    mainAlbumCover.classList.remove('hidden');
    leftAlbumCover.classList.remove('hidden');
    rightAlbumCover.classList.remove('hidden');

    if(albumCoverURL != null){

        mainAlbumCover.src = albumCoverURL;
        leftAlbumCover.src = albumCoverURL;
        rightAlbumCover.src = albumCoverURL;

    }

}


function initialiseSoundcloud(songUrl){

    iframe = document.createElement('iframe');
    iframe.id = Date.now();
    iframe.src = songUrl;
    iframe.allow = "autoplay";
    iframe.classList.add("hidden");
    iframe.loading = "eager";

    document.body.appendChild(iframe);
    soundcloud = SC.Widget(iframe);

    soundcloud.bind(SC.Widget.Events.READY, function() {

        soundcloud.bind(SC.Widget.Events.PAUSE, () => {console.log("soundcloud paused")});
        soundcloud.getDuration((value) => {console.log(value)});
        soundcloud.bind(SC.Widget.Events.FINISH, soundcloudFinished);

        //buffer and play song in background to stop jumping at the start
        setTimeout(() => {
            bufferSong();
        }, 800);

    });

}


function bufferSong(){

    soundcloud.setVolume(0);
    soundcloud.play();
    loadAlbumCover(song['albumCover']);

    setTimeout(() => {

        soundcloud.pause();
        soundcloudIsReady();

        setTimeout(() => {

            soundcloud.seekTo(0);
            soundcloud.setVolume(volume);

        }, 200);

    }, 800);

}


function soundcloudIsReady(){

    showAlbumCover();

    soundcloudReady = true;
    playPauseButton.classList.add('bg-white','hover:bg-pink', 'hover:fill-white');

}


function getIframeURL(urn){

    const id = urn.replace("soundcloud:tracks:", "");
    console.log(id);
    const iframeURL = "https://w.soundcloud.com/player/?url=https://api.soundcloud.com/tracks/" + id;
    return iframeURL;

}


function soundcloudFinished(){

    console.log("soundcloud fin");
    updateScore(0);
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
        //console.log("soundcloudTime: " + value);

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
        console.log("songTime > songlenthms");
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
        updateAlbumBlur();
        updateScore();

    }


    const percentageOfSong = songTime / songLengthMs;
    const sliderPos = percentageOfSong * lengthOfSliderBar;

    updateSliderPosition(sliderPos);
    updateSlidebar(sliderPos);

}


function togglePlayback(){

    if(!soundcloudReady){
        console.log("!soundcloudReady");
        return;
    }

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


function updateScore(score){


    if(score == null){
        currentScore = parseInt((songLengthMs - greatestSongTime)/10)
    }else{
        currentScore = score;
    }

    userScore.innerText = currentScore;

}


function updateSliderPosition(sliderPos){

    sliderButton.style.left = sliderPos + "px";

}


function updateSlidebar(sliderPos, resettingRound){

    //are we the further into the song then at any point previously
    if(songTime == greatestSongTime || resettingRound){

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
    div.classList = "flex px-5 py-2 hover:bg-gray-200 hover:cursor-pointer duration-200";
    div.innerText = trackData['artist'] + " - " + trackData['name'];

    div.addEventListener(('click'), () => {

        guessInput.value = div.innerText;
        autocompleteGuess = {artist: trackData["artist"], title: trackData["name"]};
        console.log(autocompleteGuess);
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


async function dailyGuess(guess){

    guess['title'] = filterTitle(guess['title']);
    guess['artist'] = filterArtist(guess['artist']);

    const url = location.protocol + '//' + window.location.host + '/api/v1/daily/guess';
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
            'score': currentScore
        }),

    });

    const json = await response.json();
    checkGuessResult(json);


}


function unlimitedGuess(guess){

    guessCount ++;

    guess['title'] = filterTitle(guess['title']);
    guess['artist'] = filterArtist(guess['artist']);

    console.log(guess);

    let userGuess = true;

    if(!(song['filteredTitle'].toLowerCase() == guess['title'].toLowerCase()) || !(song['filteredArtist'].toLowerCase() == guess['artist'].toLowerCase())){
        //incorrect guess
        userGuess = false;
        flashRed();

    }

    if(guessCount == lives || userGuess){

        const guessResults = {

            'correctGuess': userGuess,
            'correctTitle': song['title'],
            'correctArtist': song['artist'],
            'url': song['url'],
            'score': userGuess ? currentScore : 0

        }

        endRound(guessResults);

    }

    updateLives(lives - guessCount);

}

function submitGuess(){

    if(guessInput.value.length == 0){
        return;
    }

    if(autocompleteGuess == null){
        alert("please select a guess from the suggested guesses");
        return;
    }

    if(guessInput.value != (autocompleteGuess['artist'] + " - " + autocompleteGuess['title'])){
        alert("please select a guess from the suggested guesses");
        return;
    }

    const guess = autocompleteGuess;

    if(gamemode == gameMode.DAILY){
        console.log("daily");

        dailyGuess(guess);

    }else{

        unlimitedGuess(guess);

    }
    console.log(gamemode);
    clearAutoComplete();
    guessInput.value = "";
    autocompleteGuess = null;

}


function checkGuessResult(json){

    console.log(json);

    const isGuessCorrect = json['correctGuess'];
    json['score'] = json['correctGuess'] ? currentScore : 0;

    if(!isGuessCorrect){
        incorrectGuess(json);
        return;
    }

    correctGuess(json);

}


function correctGuess(json){

    endRound(json);

}


function incorrectGuess(json){

    //handle incorrect guess
    const livesLeft =  lives - json['guessCount'];
    updateLives(livesLeft);
    //flash red

    flashRed();

    if(livesLeft == 0){

        console.log("Out Of Lives");
        endRound(json);

    }

}


function flashRed(){

    console.log('flash red');


    guessInput.classList.remove('duration-2000');
    guessInputContainer.classList.remove('duration-2000');
    guessInput.classList.add('border-red-500');
    guessInputContainer.classList.remove('opacity-0');


    setTimeout(() => {

        guessInput.classList.add('duration-2000');
        guessInput.classList.remove('border-red-500');

        guessInputContainer.classList.add('duration-2000');
        guessInputContainer.classList.add('opacity-0');

    }, 10);

}


function updateLives(livesLeft){
    userLives.innerText = livesLeft + "/" + lives;
}


function updateSongNumber(songNumber){
    console.log(song)
    userSong.innerText = songNumber + "/" + noOfSongs;
}


function endRound(json){

    if(json['anotherRound'] === false){
        endGameButton.classList.remove('hidden');
        nextRoundButton.classList.add('hidden');
        showGameEndWidget(json);
        return;
    }

    showRoundEndWidget(json);

}


function showRoundEndWidget(json){

    console.log(json);

    stopTimer();

    widgetTitle.innerText = json['correctGuess'] ? "Correct!" : "Incorrect";
    roundSongTitle.innerText = json['correctTitle'];
    roundSongArtist.innerText = json['correctArtist'];
    roundSongScore.innerText = "You guessed the song in " + ((songLengthMs/1000) - (json['score']/100)).toFixed(2) + "s";

    //show song details
    widgetTitle.classList.remove('hidden');
    roundSongArtist.classList.remove('hidden');
    roundSongTitle.classList.remove('hidden');
    roundSongScore.classList.remove('hidden');

    //hide playback
    playbackButtonsContainer.classList.add('hidden');
    playbackButtonsContainer.classList.add('h-0');

    //change game card size
    gameCard.classList = "flex flex-col items-center bg-white w-90 border rounded-xl z-20 py-10 px-6 duration-1000";
    albumImageContainer.style.filter = "none";
    albumImageContainer.style.height = "max-content";
    albumImageContainer.classList = "relative border-2 border-gray-400 flex justify-between px-3 py-2 px-5 rounded-xl flex gap-2 items-center w-full mt-3 overflow-hidden";
    unlimitedSoundcloudCardLink.href = json['url'];
    soundcloudLogo.classList.remove('hidden');

    mainAlbumCover.classList = "absolute right-0 duration-1000";

    //show next round button
    nextRoundButtonContainer.classList.remove('hidden');
    nextRoundButton.classList.remove('hidden')

    soundcloudBackground = iframe;

    startRound();

}


function showGameEndWidget(json){

    gameWidgetScore.innerText = json['overallScore'];

    // gameWidget.style.transitionDuration  = "1s";
    // gameWidget.style.width = "400px";

    gameSongScore1.innerText = json['scores'][0];
    gameSongScore2.innerText = json['scores'][1];
    gameSongScore3.innerText = json['scores'][2];

    gameSongArtist1.innerText = json['songs'][0]['artist'];
    gameSongArtist2.innerText = json['songs'][1]['artist'];
    gameSongArtist3.innerText = json['songs'][2]['artist'];

    gameSongTitle1.innerText = json['songs'][0]['title'];
    gameSongTitle2.innerText = json['songs'][1]['title'];
    gameSongTitle3.innerText = json['songs'][2]['title'];

    gameSongImage1.src = json['songs'][0]['albumCover'];
    gameSongImage2.src = json['songs'][1]['albumCover'];
    gameSongImage3.src = json['songs'][2]['albumCover'];

    soundcloudCardLink1.href = json['songs'][0]['url'];
    soundcloudCardLink2.href = json['songs'][1]['url'];
    soundcloudCardLink3.href = json['songs'][2]['url'];


    gameSongBar1.style.width = ((json['scores'][0] / 3000) * 100) + "%";
    gameSongBar2.style.width = ((json['scores'][1] / 3000) * 100) + "%";
    gameSongBar3.style.width = ((json['scores'][2] / 3000) * 100) + "%";

    if(json['accuracyBonus'] === true){
        accuracyBonus.classList.remove('hidden');
    }


    gameWidget.classList.remove('hidden');
    // gameWidget.classList.add('w-[400px]');
    // gameWidget.classList.remove('w-[320px]');

    //timeout is needed for the animation to work. It doesnt like having hidden being remove and animating at the same time
    setTimeout(() => {
        gameWidget.style.width = "450px"
        //gameWidget.classList = "absolute flex flex-col items-center bg-white w-[400px] h-min border rounded-xl z-20 right-[50%] translate-x-[50%] py-10 px-6 duration-1000";
    },10);



}


const dummyData = {
    anotherRound: false,
    correctArtist: "Natalie Imbruglia",
    correctGuess: true,
    correctTitle: "Torn",
    guessCount: 1,
    roundEnd: true,
    score: 3000,
    scores: [
        967,
        920,
        3000],
    songs:[
        {urn: 'soundcloud:tracks:1331242909', title: 'Calm Down', genre: 'Pop', albumCover: 'https://i1.sndcdn.com/artworks-pIPrJaNtVzzV-0-t500x500.jpg', artist: 'Rema'},
        {urn: 'soundcloud:tracks:1035123307', title: 'Save Your Tears', genre: 'R & B', albumCover: 'https://i1.sndcdn.com/artworks-yRwygOCUTQui-0-t500x500.jpg', artist: 'The Weeknd'},
        {urn: 'soundcloud:tracks:256614041', title: 'Torn', genre: 'Pop', albumCover: 'https://i1.sndcdn.com/artworks-tOpnt8iy33it-0-t500x500.jpg', artist: 'Natalie Imbruglia'}
    ],
    overallScore: 8744

}

// showGameEndWidget(dummyData);
// showGameUI();
