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
	<link rel="apple-touch-icon" href="apple-touch-icon.png"/>
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
  <script src="javascript/addRemoveClass.js" type="text/javascript"></script>
  <script src="javascript/remoteFunctions.js" type="text/javascript"></script>
	
	<!-- Hostname -->
	<meta name="hostname"	id="hostname"	content="<?php echo `hostname`;?>" />
	
	<title>Remote</title>
</head>

<body>

	<div id="topbar"> <!-- class="black" class="transparent"-->
		<span id="title">Remote</span>
		<span id="rightbutton"><a href="addtrack.html">Add Track</a></span>
	</div>
	
	<div id="content">
		
		<span class="graytitle" id="connectedMessage"></span>
		
		<div id="innerContent">
		
			<ul class="pageitem">
				<li class="textbox">
					<span class="header">
						<div id="Status"></div>
					</span>
					<p>
						<div id="Track"></div>
						<div id="Artist"></div>
						<div id="Album"></div>
					</p>
					<p id="lastUpdated"></p>
				</li>
			</ul>
			
			<ul class="pageitem">
				<li class="checkbox"><span class="name">Random</span><input id="shuffleCheckbox" type="checkbox" /></li>
				<li class="checkbox"><span class="name">Repeat</span><input id="repeatCheckbox" type="checkbox" /></li>
			</ul>
			
			<ul class="pageitem">
				<li class="menu" id="volumeUp">
					<span class="name">Volume Up</span>	
				</li>
				<li class="menu" id="volumeDown">
					<span class="name">Volume Down</span>
				</li>
			</ul>

			<ul class="pageitem">
				<li class="menu">
					<a href="playqueue.html">
						<span class="name">Play Queue</span>
						<span class="comment" id="playqueueCount"></span>
						<span class="arrow"></span>
					</a>
				</li>
			</ul>	
		</div> <!-- inner content; don't display if we can't connect to mpd -->
	</div>
	
	<div id="bottombar" class="buttonWrapper">
		<div id="buttonHolder">
			<span id="previousButton"></span>
			<span id="playPauseButton" class="play"></span>
			<span id="nextButton"></span>
		</div>
		<div id="buttonBackgroundFiller"></div>
	</div>


	<div id="footer">
		<a class="noeffect" href="http://iwebkit.net">Thanks to iWebKit for all the style sheets.</a>
	</div>
	
	<script type="text/javascript">
		init_page();
	</script>
</body>
</html>
