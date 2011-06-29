<?php
/*
 *  mpdquery.php
 *  Lists MPD's playlist's and/or song database
 *
 */

require_once('mpdconfig.php');
require_once('mpd.class.php');
require_once('globalFunctions.php');

$mpd = new mpd($host,$mpdPort,$mpdPassword);

if (isset($_GET['request']))
  $request = $_GET['request'];
else
  $request = "";

switch ($request)
{
  // global mpd object doesn't work for some reason...
  case "playqueue": printPlayQueue($mpd);                       break;
  case "playlists": printPlaylists($mpd);                       break;
  case "playlist": printPlaylist($_GET['playlist'], $mpd);      break;
  case "totalTrackCount": printTotalTrackCount($mpd);           break;
  case "allTracks": printAllTracks($mpd);                       break;
  case "search": printSearchResults($_GET['searchText'], $mpd); break;
  default:                                                      break;
}

$mpd->Disconnect();

/******************************************************************************/

function printPlayQueue($mpd)
{
  $trackNumber = 1;
  foreach ($mpd->playlist as $song)
  {
    // trackNumber
    echo $trackNumber."#:#";
    
    // isPlaying
    if ($mpd->current_track_id == ($trackNumber - 1))
      echo "play";
    else
      echo "stop";
    
    echo "#:#";
    
    echo $song['Title']."#:#";  // title
    echo $song['Artist']."#:#"; // artist
    echo $song['Time']."#:#\n"; // time
    
    $trackNumber++;
  }
}

function printPlaylists($mpd)
{
  // Get the playlists (this isn't in mpd.class.php... yet...)
  $playlists = explode("\n", $mpd->SendCommand("listplaylists"));
  
  // Print only the names of the playlists
  foreach ($playlists as $playlist)
    if (preg_match('/playlist/', $playlist))
    {
      $playlistName = preg_replace('/playlist: /', '', $playlist);
      $trackListing = explode("\n", $mpd->SendCommand("listplaylist $playlistName"));
      
      $trackCount = -1; // to ignore the extra line from the last \n
      foreach ($trackListing as $track)
        $trackCount++;
      
      echo $playlistName."#:#".$trackCount."\n";
    }
}

function printTotalTrackCount($mpd)
{
  echo $mpd->num_songs;
}

function printPlaylist($playlistName, $mpd)
{
  /* Get the info */
  $playlistTrackLiting = getDataArrayFromString($mpd->SendCommand("listplaylistinfo $playlistName"));
  
  // Then print the tracks
  for ($index = 0; $index < sizeof($playlistTrackLiting['file']); $index++)
  {
    echo $playlistTrackLiting['file'][$index]."#:#";
    echo $playlistTrackLiting['title'][$index]."#:#";
    echo $playlistTrackLiting['artist'][$index]."#:#";
    echo $playlistTrackLiting['time'][$index]."\n";
  }
}

function printAllTracks($mpd)
{
  $trackArray = $mpd->GetDir();
  
  // Print all tracks in the root directory
  printAllTracksInDirectory($trackArray, $mpd);
}

function printAllTracksInDirectory($trackArray, $mpd)
{
  // Print tracks from directories in this directory first
  for ($index = 0; $index < sizeof($trackArray['directories']); $index++)
  {
    $thisDirectory = $trackArray['directories'][$index];
    $subDir_trackArray = $mpd->GetDir($thisDirectory);
    printAllTracksInDirectory($subDir_trackArray, $mpd);
  }
  
  // Then print the tracks
  for ($index = 0; $index < sizeof($trackArray['files']); $index++)
  {
    echo $trackArray['files'][$index]['file']."#:#";
    echo $trackArray['files'][$index]['Title']."#:#";
    echo $trackArray['files'][$index]['Artist']."#:#";
    echo $trackArray['files'][$index]['Time']."\n";
  }
}

function printSearchResults($searchText, $mpd)
{
  $searchResults_string = $mpd->SendCommand("search any $searchText");
  $searchResults = getDataArrayFromString($searchResults_string);
  
  // Then print the tracks
  for ($index = 0; $index < sizeof($searchResults['file']); $index++)
  {
    echo $searchResults['file'][$index]."#:#";
    
    if (isset($searchResults['title'][$index]))
      echo $searchResults['title'][$index]."#:#";
      
    if (isset($searchResults['artist'][$index]))
      echo $searchResults['artist'][$index]."#:#";
      
    if (isset($searchResults['time'][$index]))
      echo $searchResults['time'][$index]."\n";
  }
}

?>
