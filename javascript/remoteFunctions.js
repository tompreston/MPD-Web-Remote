var mpdControlFile = "mpd/mpdcontrol.php";

var init_page = function()
{
	addEventListeners();
	updatePage();
}

var addEventListeners = function()
{
	var lastUpdated = document.getElementById("lastUpdated");
	var shuffleCheckbox = document.getElementById("shuffleCheckbox");
	var previousButton = document.getElementById("previousButton");
	var playPauseButton = document.getElementById("playPauseButton");
	var nextButton = document.getElementById("nextButton");

	lastUpdated.addEventListener("click", updatePage, false);
	shuffleCheckbox.addEventListener("click", toggleRandom, false);
	previousButton.addEventListener("click", previous, false);
	playPauseButton.addEventListener("click", playPause, false);
	nextButton.addEventListener("click", next, false);
}

var status = "stop";
var updatePage = function()
{
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.open("GET", mpdControlFile, false);
	xmlhttp.send();
	var serverResponse = xmlhttp.responseText;
	
	var innerContent = document.getElementById("innerContent");
	var rightButton  = document.getElementById("rightbutton");
	
	/* Check if we have connected */
	var connectedMessage = document.getElementById("connectedMessage");
	if (serverResponse.search("Could not connect to the MPD server") != -1)
	{
		addClass(innerContent, "hidden");
		addClass(rightButton, "hidden");
		connectedMessage.innerHTML = "Could not connect to MPD";
	}
	else
	{
		removeClass(innerContent, "hidden");
		removeClass(rightButton, "hidden"); 
		var hostname = document.getElementById("hostname").content;
		connectedMessage.innerHTML = "Connected to " + hostname;
	}
	
	var serverResponseLine = serverResponse.split("\n");
	
	status = serverResponseLine[0];
	var randomStatus = serverResponseLine[1];
	var playqueueCount = serverResponseLine[2];
	var track = serverResponseLine[3];
	var artist = serverResponseLine[4];
	var album = serverResponseLine[5];
			
	if (status == "stop")
	{
		track = "";
		artist = "";
		album = "";
	}
	
	// Deal with the status
	var statusText;
	var playPauseButtonState;
	switch (status)
	{
		case "play":
			statusText = "Now Playing";
			playPauseButtonState = "Pause";
		break;
		case "pause":
			statusText = "Paused";
			playPauseButtonState = "Play";
		break;
		case "stop":
			statusText = "Stopped";
			playPauseButtonState = "Play";
		break;
	}
	
	// Update elements
	document.getElementById("Status").innerHTML = statusText;
	document.getElementById("Track").innerHTML  = track;
	document.getElementById("Artist").innerHTML = artist;
	document.getElementById("Album").innerHTML  = album;
	
	var theTime = new Date(); 
	document.getElementById("lastUpdated").innerHTML = "Last Updated: " +
	                                                    theTime.getHours() + "h" +
	                                                    theTime.getMinutes() + "m" +
	                                                    theTime.getSeconds() + "s";
	
	document.getElementById("shuffleCheckbox").checked = (randomStatus == 1)?true:false;
	
	document.getElementById("playqueueCount").innerHTML = "Tracks: " + playqueueCount;

	var playPauseButton = document.getElementById("playPauseButton");

	if (playPauseButtonState == "Play")
	{
		removeClass(playPauseButton, "pause");
		addClass(playPauseButton, "play");
	}
	else
	{
		removeClass(playPauseButton, "play");
		addClass(playPauseButton, "pause");
	}
}

setInterval( "updatePage()", 10000 ); // Auto update the page

var playMPD = function()
{
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.open("GET", mpdControlFile + "?action=Play", false);
	xmlhttp.send();
}

var pauseMPD = function()
{
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.open("GET", mpdControlFile + "?action=Pause", false);
	xmlhttp.send();
}

var nextMPD = function()
{
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.open("GET", mpdControlFile + "?action=Next", false);
	xmlhttp.send();
}

var previousMPD = function()
{
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.open("GET", mpdControlFile + "?action=Previous", false);
	xmlhttp.send();
}

var playPause = function()
{
	if (status == "play") // then pause
	{
		pauseMPD();
		updatePage();
	}
	else
	{
		playMPD();
		updatePage();
	}
}

var next = function()
{
	nextMPD();
	updatePage();
}

var previous = function()
{
	previousMPD();
	updatePage();
}

var toggleRandom = function()
{
	var turnRandomOn = document.getElementById("shuffleCheckbox").checked;
	
	if (turnRandomOn)
	{
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.open("GET", mpdControlFile + "?action=RandomOn", false);
		xmlhttp.send();
	}
	else
	{
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.open("GET", mpdControlFile + "?action=RandomOff", false);
		xmlhttp.send();
	}
	updatePage();
}
