		// Are we using a webkit browser?
    if (RegExp(" AppleWebKit/").test(navigator.userAgent))
		{
			document.write('<link href="css/iWebKit_style.css" rel="stylesheet" media="screen" type="text/css" />\n');
			document.write('<script src="javascript/iWebKit_functions.js" type="text/javascript"></'+'script>\n');
		}
	else if (RegExp(" Firefox/").test(navigator.userAgent))
		{
			document.write('<link href="css/firefox.css" rel="stylesheet" media="screen" type="text/css" />');
		}
	else 
		{
			document.write('<link href="css/firefox.css" rel="stylesheet" media="screen" type="text/css" />');
/*
			document.write('<div style="width:300px;border:thin solid red;background-color:yellow">');
			document.write('This browser is not webkit nor firefox because of this the remote will display incorrectly.<br> Alternative style sheets are comming soon! :-) <p> Check out the project page <a href="www.checkhere.com">www.checkhere.com</a>');
			document.write('</div>');
*/		
		}
		