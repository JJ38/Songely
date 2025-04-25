//object/log/entries[i]/response/content/text
const message = document.getElementById('message');


let songList = [];

function parseSongs(soundcloudSongData){


    for(let i = 0; i < soundcloudSongData.length; i++){

        const songData = soundcloudSongData[i];

        const song = {
            id: songData['id'],
            urn: songData['urn'],
            title: songData['title'],
            genre: songData['genre'],
            albumCover: songData['artwork_url'],
            url: songData['permalink_url'],
        
        };

        songList.push(song);

    }

}

const fileInput = document.getElementById("file-input");


fileInput.addEventListener("change", handleFileSelection);

function handleFileSelection(event) {

  const file = event.target.files[0];

  // Validate file existence and type
  if (!file) {
    showMessage("No file selected. Please choose a file.", "error");
    return;
  }

//   if (!file.type.startsWith("text")) {
//     showMessage("Unsupported file type. Please select a text file.", "error");
//     return;
//   }

  // Read the file
  const reader = new FileReader();
  reader.onload = () => {

    const fileContent = reader.result;
    convertTextToJson(fileContent);

  };

  reader.readAsText(file);

}

function convertTextToJson(text){

    const json = JSON.parse(text);
    console.log(json);
    getSoundcloudData(json)

}

function getSoundcloudData(json){

    const requestArray = eval(json['log']['entries']);

    for(let i = 0; i < requestArray.length; i++){
        
        const textToParse = json['log']['entries'][i]['response']['content']['text'];
        const encoding = json['log']['entries'][i]['response']['content']['encoding'];

        if(encoding == "base64"){
          console.log("base64");
          const decodedData = window.atob(textToParse);
          const songDataArray = eval(decodedData);
          parseSongs(songDataArray);
          console.log(songDataArray);
        }

        if(textToParse[0] == "["){

          const songDataArray = eval(textToParse);
          
          console.log(songDataArray);
          parseSongs(songDataArray);

        }

    }
    console.log(songList);
}


function convertToCSV(){

    // const songIterator = songList.entries();

    for(const songData of songList){

        let song = "";

        song += songData['id'] + ','
        song += songData['urn'] + ','
        song += songData['title'] + ','
        song += songData['genre'] + ','
        song += songData['albumCover'] + ','
        song += songData['url'] + " <br> "
        
        message.innerHTML = message.innerHTML + song;

    }

    songList = [];

}


