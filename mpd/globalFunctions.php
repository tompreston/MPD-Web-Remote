<?php

function convertSecsToMinsSecs($seconds)
{
  /* IMPLEMENT THIS IN JAVASCRIPT
  $minutes = floor($seconds / 60);
  $seconds = $seconds % 60;
  
  // there has to be a better way of formatting than this...
  return $minutes.":".date("s", $seconds);
  */
  return $seconds;
}

function getDataArrayFromString($dataString)
{
  /* This is pretty nasty
   * I can't think of a better way to do this at the moment
   * I use seperate indexes for each info item because the
   * file/time/title/artist info can come in different orders
   * 
   * Blergh
   *
   * At the moment it only returns the file, artist, title and time information
   * Feel free to add to it or make it better
   */
  
  /* Make an array of lines from the string */
  $trackLiting_Vebose = explode("\n", $dataString);
  
  /* Now get the information out of the array */
  $fileIndex = $timeIndex = $titleIndex = $artistIndex = -1;
  $fileArray = array();
  $timeArray = array();
  $titleArray = array();
  $artistArray = array();
  
  foreach ($trackLiting_Vebose as $lineOfMetaData)
  {
    if (preg_match('/file:/', $lineOfMetaData))
      $fileArray[++$fileIndex] = preg_replace("/file: /", "", $lineOfMetaData);
      
    if (preg_match('/Time:/', $lineOfMetaData))
      $timeArray[++$timeIndex] = preg_replace("/Time: /", "", $lineOfMetaData);
      
    if (preg_match('/Title:/', $lineOfMetaData))
      $titleArray[++$titleIndex] = preg_replace("/Title: /", "", $lineOfMetaData);
    
    if (preg_match('/Artist:/', $lineOfMetaData))
      $artistArray[++$artistIndex] = preg_replace("/Artist: /", "", $lineOfMetaData);
  }
  
  /* Send back a two dimensional array of this info */
  return $dataArray = array( "file"   => $fileArray,
                   						 "title"  => $titleArray,
                               "artist" => $artistArray,
                               "time"   => $timeArray      );
}

?>
