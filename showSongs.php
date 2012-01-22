<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
  
  <!-- iPhone Stuff -->
  <meta content="minimum-scale=1.0, width=device-width, maximum-scale=0.6667, user-scalable=no" name="viewport" />
  <meta name="keywords" content="iPhone, iPod Touch, remote, mpd, control, php" />
  <meta name="description" content="iPhone web based remote control for MPD" />
  <meta content="yes" name="apple-mobile-web-app-capable" /><!-- When opened from home screen app will not have safari bars -->
  <meta name="apple-mobile-web-app-status-bar-style" content="default"/><!-- Changes the status bar color. default/black/black-translucent -->
  <link rel="apple-touch-icon-precomposed" href="image.png"/><!-- icon on springboard 58x58px already  -->
  <link href="startup.png" rel="apple-touch-startup-image" /><!-- Start up icon 320x460px -->
  
  <!-- Check for webkit -->
	<script type="text/javascript">
		// Are we using a webkit browser?
    if (RegExp(" AppleWebKit/").test(navigator.userAgent))
		{
			document.write('<link href="css/iWebKit_style.css" rel="stylesheet" media="screen" type="text/css" />\n');
			document.write('<script src="javascript/iWebKit_functions.js" type="text/javascript"></'+'script>\n');
		}
		else
		{
			document.write("This browser is not webkit enabled and because of this the remote will display incorrectly. Alternative style sheets are comming soon! :-)\n");
		}
	</script>
	
	<!-- Style Sheets -->
  <link href="css/style.css" rel="stylesheet" media="screen" type="text/css" />

	<!-- Javascript -->
  <script src="javascript/globalFunctions.js" type="text/javascript"></script>
  <script src="javascript/showSongFunctions.js" type="text/javascript"></script>
  
  <title>Remote - Add Track</title>
  
  <meta name="mode" id="mode" content="<?php if (isset($_GET['mode'])) echo $_GET['mode']; ?>" />
  <meta name="playlistName" id="playlistName" content="<?php if (isset($_GET['playlist'])) echo $_GET['playlist']; ?>" />
  <meta name="searchText"  id="searchText"  content="<?php if (isset($_GET['searchText'])) echo $_GET['searchText']; ?>" />
  <style>
    #trackList li {
      overflow:hidden;
    }
  </style>
</head>

<body class="musiclist">
  
  <div id="topbar"> <!-- class="black" class="transparent"-->
    <div id="leftnav">
      <a href="index.php"><img alt="home" src="images/home.png" /></a>
      <a href="addtrack.html">Back</a>
    </div>
    <div id="title">Add Track</div>
    <div id="rightbutton"><a href="#">Add All</a></div>
  </div>
  
  <div class="searchbox">
    <form action="showSongs.php" method="get">
      <fieldset>
        <input name="mode" value="search" type="hidden" />
        <input name="searchText" id="searchTextEntry" placeholder="Search all" type="text" />
      </fieldset>
    </form>
  </div>
  
  <div id="noResultsHolder"></div>
  
  <div id="content">
    <ul id="trackList">
    <!--
      <li>
        <a href="page.html">
          <span class="number">1</span>
          <span class="name">Name</span>
          <span class="time">(1:33)</span>
          <span class="arrow"></span>
        </a>
      </li>
    -->
    </ul>
  </div>
  
  <div id="footer">
    <div id="loading"></div>
	</div>
	
	<script type="text/javascript">
		showSongs_init();
	</script>
	
</body>
</html>
