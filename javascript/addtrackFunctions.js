var addTrackPage_init = function()
{
	updateAddTrackPage();
}

var updateAddTrackPage = function()
{
  var xmlhttp = new XMLHttpRequest();
  xmlhttp.open("GET", "mpd/mpdquery.php?request=totalTrackCount", false);
  xmlhttp.send();
  var totalSongs = xmlhttp.responseText;
  
  document.getElementById("totalTrackCount").innerHTML = "Tracks: " + totalSongs;
  
  updatePlaylists();
}

setInterval( "updateAddTrackPage()", 60000 ); // Auto update the page

var updatePlaylists = function()
{
  var xmlhttp = new XMLHttpRequest();
  xmlhttp.open("GET", "mpd/mpdquery.php?request=playlists", false);
  xmlhttp.send();
  var playlists = xmlhttp.responseText;
  
  if (playlists.length == 0)
  {
    document.getElementById("outerPlaylistHolder").style.visibility = "hidden";
  }
  else
  { 
    var numberOfNewLines = playlists.split("\n").length; // Dirty, drity hack
    var playlist = playlists.split("\n", numberOfNewLines - 1);
    
    // Format the playlists
    var formatedPlaylists  = "";
    for (index in playlist)
    {
      var playlistName = playlist[index].replace(/#:#.*$/, '');
      var trackCount = playlist[index].replace(/^.*#:#/, '');
      formatedPlaylists += 
      '<li class="store">' +
        '<a onclick="parent.location=\'showSongs.php?mode=playlist&playlist=' + playlistName + '\'">' +
	        '<span class="image" style="background-image: url(\'images/SpeakerIcon.png\')"></span>' +
	        '<span class="comment">Tracks: ' + trackCount + '</span>' +
	        '<span class="name">' + playlistName + '</span>' +
       		'<span class="arrow"></span>' +
        '</a>' +
      '</li>';
    }
    
    // Update elements
    document.getElementById("outerPlaylistHolder").style.visibility = "visible";
    document.getElementById("innerPlaylistHolder").innerHTML = formatedPlaylists;
  }
}
