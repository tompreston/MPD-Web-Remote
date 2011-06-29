var formatTracks = function(listOfTracks)
{
  var listOfTracks = listOfTracks.split("\n");
  
  // Get rid of the last element (it's only there because of the newline)
  listOfTracks.pop();
  
  // Format the tracks
  var formatedTracks  = "";
  for (index in listOfTracks)
  {
    var trackInfo = listOfTracks[index].split("#:#");
    
    var fileName  = trackInfo[0];
    var title     = trackInfo[1];
    var artist    = trackInfo[2];
    var time      = trackInfo[3];
    
    formatedTracks +=
    '<li>' +
    ' <a onclick="addTrackToPlayQueue(&#34;' + fileName + '&#34;)">' +
    '   <span class="number">' + (parseInt(index) + 1) + '</span>' +
    '   <span class="name">' + title + ' - ' + artist + '</span>' +
    '   <span class="time">(' + convertSecsToMinsSecs(time) + ')</span>' +
    '   <span class="addTrack"></span>' +
    '   </a>' +
    '</li>';
  }
  return formatedTracks;
}

var convertSecsToMinsSecs = function(timeInSeconds)
{
  var trackTime = new Date(0, 0, 0, 0, 0, timeInSeconds, 0);
  
  /* There has to be a better way of formatting the seconds than this */
  return trackTime.getMinutes() + ":" +
          (trackTime.getSeconds() < 10 ? '0' : '') + trackTime.getSeconds();
}
