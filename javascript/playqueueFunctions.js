var playqueue_init = function()
{
	addEventListeners();
	updatePlayQueue();
}

var addEventListeners = function()
{
	var clearButton = document.getElementById("rightbutton");

	clearButton.addEventListener("click", clearPlayQueue, false);
}

var updatePlayQueue = function()
{
  var xmlhttp = new XMLHttpRequest();
  
  xmlhttp.onreadystatechange=function()
  {
    if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
      document.getElementById("playlist").innerHTML = formatPlayQueue(xmlhttp.responseText);
      document.getElementById("loading").innerHTML = "";
    }
  }
  
  xmlhttp.open("GET", "mpd/mpdquery.php?request=playqueue", true);
  xmlhttp.send();
  
  document.getElementById("loading").innerHTML = "Loading...";
}

setInterval( "updatePlayQueue()", 60000 ); // Auto update the page


var formatPlayQueue = function(trackString)
{
  var listOfTracks = trackString.split("\n");
  listOfTracks.pop(); // Get rid of the last element (it's only there because of the newline)
  
  // Format the tracks
  var formatedTracks  = "";
  for (index in listOfTracks)
  {
    var trackInfo = listOfTracks[index].split("#:#");
    
    var trackNumber = trackInfo[0];
    var isPlaying   = trackInfo[1];
    var title       = trackInfo[2];
    var artist      = trackInfo[3];
    var time        = trackInfo[4];
    
    formatedTracks +=
    '<li>' +
    '  <div class="playlistItemWrapper" onclick="playSong(' + trackNumber + ')">' +
    '    <span class="number">' + trackNumber + '</span>' +
    '    <span class="' + isPlaying + '"></span>' +
    '    <span class="name">' + title + ' - ' + artist + '</span>' +
    '    <span class="time">' + convertSecsToMinsSecs(time) + '</span>' +
    '  </div>' +
    '</li>';
  }
  return formatedTracks;
}


  

var playSong = function(trackNumber)
{
  var xmlhttp = new XMLHttpRequest();
  xmlhttp.open("GET", "mpd/mpdcontrol.php?action=SkipTo&track=" + --trackNumber, false);
  xmlhttp.send();
  
  // Change back to the controls
  location.href = "index.php";
}

var clearPlayQueue = function(event)
{
  var userIsSure = confirm("Are you sure you want to clear the play queue?");
  if (userIsSure)
  {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open("GET", "mpd/mpdcontrol.php?action=ClearPlayQueue", false);
    xmlhttp.send();
    
    updatePlayQueue();
  }
}
