<?php
/*
 *  mpdconfig.php
 *  Configuration for MPD
 */


	/* some helpers for phpMpReloaded */
	define('__PHPMPRELOADED_MPD_SETTINGS__', '../../../../config/mpd_config.php' );
	define('__PHPMPRELOADED_CLIENT_SWITCHER__', '../../../../lib/ClientSwitcher.php');
	if (file_exists( __PHPMPRELOADED_MPD_SETTINGS__ )){
		include(__PHPMPRELOADED_MPD_SETTINGS__);
	}
 
	$host = $mpd_host;
	$mpdPort = $mpd_port;
	$mpdPassword = null;
?>
