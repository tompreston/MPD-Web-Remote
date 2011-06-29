<?php
/*
 *  mpdcontrol.php
 *  Controls mpd using mpd.class.php
 */
  
require_once('mpdconfig.php');
require_once('mpd.class.php');
require_once('globalFunctions.php');

$mpd = new mpd($host,$mpdPort,$mpdPassword);

if ( !$mpd->connected)
{
  echo "\nCould not connect to the MPD server\n";
  exit(1);
}

// GET variables
if (isset($_GET['action']))
  $action = $_GET['action'];
else
  $action = "";

if (isset($_GET['track']))
  $track = $_GET['track'];
else
  $track = "";

// Control
switch ($action)
{
  case "Play":           $mpd->Play();               break;
  case "Pause":          $mpd->Pause();              break;
  case "Next":           $mpd->Next();               break;
  case "Previous":       $mpd->Previous();           break;
  case "SkipTo":         $mpd->SkipTo($track);       break;
  case "RandomOn":       $mpd->SetRandom(1);         break;
  case "RandomOff":      $mpd->SetRandom(0);         break;
  case "AddToPlayQueue": $mpd->PLAdd($track);        break;
  case "ClearPlayQueue": $mpd->PLClear();            break;
  case "AddAllTracksToPlayQueue": addAllTracks($mpd); break;
  
  case "AddAllTracksInPlaylistToPlayQueue": /* lol */
    addAllTracksInPlaylist($_GET['playlist'], $mpd);
    break;
    
  case "AddAllTracksFromSearchToPlayQueue":
    addAllTracksInSearch($_GET['searchText'], $mpd);
    break;
 
  default:                                           break;
}

// Print MPD's information  
echo $mpd->state."\n";
echo $mpd->random."\n";
echo $mpd->playlist_count."\n";

if ($mpd->state != "stop")
{
  echo $mpd->playlist[$mpd->current_track_id]['Title']."\n";
  echo $mpd->playlist[$mpd->current_track_id]['Artist']."\n";
  echo $mpd->playlist[$mpd->current_track_id]['Album'];
}

$mpd->Disconnect();

/*****************************************************************************/

function addAllTracks($mpd)
{
  $fileArray = getAllFilesInDirectory($mpd->GetDir(), $mpd);
  
  $mpd->PLAddBulk($fileArray);
}

function getAllFilesInDirectory($directoryListing, $mpd)
{
  $fileArray = array();
  
  // Get tracks from directories in this directory first
  for ($index = 0; $index < sizeof($directoryListing['directories']); $index++)
  {
    $thisDirectory = $directoryListing['directories'][$index];
    $subDir_directoryListing = $mpd->GetDir($thisDirectory);
    $arrayOfFilesInThisDirectory = getAllFilesInDirectory($subDir_directoryListing, $mpd);
    
    foreach ($arrayOfFilesInThisDirectory as $file)
      array_push( $fileArray,  $file );
  }
  
  // Then get the tracks from this directory
  for ($index = 0; $index < sizeof($directoryListing['files']); $index++)
    array_push($fileArray, $directoryListing['files'][$index]['file']);
  
  return $fileArray;
}

/*****************************************************************************/

function addAllTracksInPlaylist($playlistName, $mpd)
{
  $playlistTrackLiting_Vebose = explode("\n", $mpd->SendCommand("listplaylistinfo $playlistName"));
  
  // Get only the file info
  $index = 0;
  $playlistFile = array();
  
  foreach ($playlistTrackLiting_Vebose as $lineOfMetaData)
    if (preg_match('/file:/', $lineOfMetaData))
      $playlistFile[$index++] = preg_replace("/file: /", "", $lineOfMetaData);
  
  // Add them all
  $mpd->PLAddBulk($playlistFile);
}

function addAllTracksInSearch($searchText, $mpd)
{
  $searchResults_string = $mpd->SendCommand("search any $searchText");
  $searchResults = getDataArrayFromString($searchResults_string);
  
  $mpd->PLAddBulk($searchResults['file']);
}

?>
