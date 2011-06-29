var showSongs_init = function()
{
	addEventListeners();
	updatePage();
}

var addEventListeners = function()
{
	var addAllTracksButton = document.getElementById("rightbutton");

	addAllTracksButton.addEventListener("click", addAllTracks, false);
}

var updatePage = function()
{
  var mode = document.getElementById("mode").content;
  
  switch (mode)
  {
    case "allsongs": showAllSongs();        break;
    case "playlist": showPlaylist();        break;
    case "search"  : showSongsFromSearch(); break;
    default:                                break;
  }  
}

/*****************************************************************************/

var showAllSongs = function()
{
  xmlhttp = new XMLHttpRequest();
  
  xmlhttp.onreadystatechange=function()
  {
    if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
      document.getElementById("trackList").innerHTML = formatTracks(xmlhttp.responseText);
      document.getElementById("loading").innerHTML = "";
    }
  }
  
  xmlhttp.open("GET", "mpd/mpdquery.php?request=allTracks", true);
  xmlhttp.send();
  
  document.getElementById("loading").innerHTML = "Loading...";
}

var showPlaylist = function()
{
  var playlistName = document.getElementById("playlistName").content;
  
  xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange=function()
  {
    if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
      document.getElementById("trackList").innerHTML = formatTracks(xmlhttp.responseText);
      document.getElementById("loading").innerHTML = "";
    }
  }
  xmlhttp.open("GET",
               "mpd/mpdquery.php?request=playlist&playlist=" + encodeURIComponent(playlistName),
               true);
  xmlhttp.send();
  
  document.getElementById("loading").innerHTML = "Loading...";
  
}

var showSongsFromSearch = function()
{
  var previousSearch = document.getElementById("searchText").content
  var searchText = "\"" + previousSearch + "\"";
  
  xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange=function()
  {
    if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
      if (formatTracks(xmlhttp.responseText) == "")
      {
        document.getElementById("trackList").innerHTML = "";
        document.getElementById("searchTextEntry").value = previousSearch;
        document.getElementById("noResultsHolder").innerHTML = "No Results";
      }
      else
      {
        document.getElementById("trackList").innerHTML = formatTracks(xmlhttp.responseText);
        document.getElementById("searchTextEntry").value = previousSearch;
        document.getElementById("noResultsHolder").innerHTML = "";
      }
      document.getElementById("loading").innerHTML = "";
    }
  }
  xmlhttp.open("GET",
               "mpd/mpdquery.php?request=search&searchText=" + encodeURIComponent(searchText),
               true);
  xmlhttp.send();
  
  document.getElementById("loading").innerHTML = "Loading...";
}


/*****************************************************************************/

var addTrackToPlayQueue = function(trackFileName)
{
  xmlhttp = new XMLHttpRequest();
  xmlhttp.open("GET",
               "mpd/mpdcontrol.php?action=AddToPlayQueue&track=" + encodeURIComponent(trackFileName),
               false);
  xmlhttp.send();
  
  alert("Added \"" + trackFileName + "\" to the play queue");
}

/*****************************************************************************/

var addAllTracks = function()
{
  var mode = document.getElementById("mode").content;
  
  switch (mode)
  {
    case "allsongs": addAllSongsToPlayQueue();             break;
    case "playlist": addPlaylistToPlayQueue(); break;
    case "search":   addAllSongsFromSearch(); break;
    default:                                               break;
  }
}

var addAllSongsToPlayQueue = function()
{
  var userIsSure = confirm("Are you sure you want to add all of these tracks to the play queue?");
  
  if (userIsSure)
  {
    xmlhttp = new XMLHttpRequest();
    xmlhttp.open("GET", "mpd/mpdcontrol.php?action=AddAllTracksToPlayQueue", false);
    xmlhttp.send();
    
    alert("Added all tracks to the play queue");
  }
}

var addPlaylistToPlayQueue = function(playlistName)
{
  var userIsSure = confirm("Are you sure you want to add all of these tracks to the play queue?");
  
  if (userIsSure)
  {
    var playlistName = document.getElementById("playlistName").content;
    
    xmlhttp = new XMLHttpRequest();
    xmlhttp.open("GET", "mpd/mpdcontrol.php?action=AddAllTracksInPlaylistToPlayQueue&playlist=" + playlistName, false);
    xmlhttp.send();
    
    alert("Added all tracks to the play queue");
  }
}

var addAllSongsFromSearch = function()
{
  var userIsSure = confirm("Are you sure you want to add all of these tracks to the play queue?");
  
  if (userIsSure)
  {
    var searchText = "\"" + document.getElementById("searchText").content + "\"";
    
    xmlhttp = new XMLHttpRequest();
    xmlhttp.open("GET", "mpd/mpdcontrol.php?action=AddAllTracksFromSearchToPlayQueue&searchText=" + searchText, false);
    xmlhttp.send();
    
    alert("Added all tracks to the play queue");
  }
}
