<?php
//------------------------------------------------------------------------------------------------------------+
	# original author: playzone46@yandex.ru
	header("Content-type: image/gif");
	require "lgsl_files/lgsl_class.php";
	
	function resizeImage($width, $height, $src){
		list($w, $h) = getimagesize($src);
		$image_p = imagecreatetruecolor($width, $width);
		$image = imagecreatefromgif($src);
		imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $w, $h);
		return $image_p;
	}
//------------------------------------------------------------------------------------------------------------+
	$lookup = lgsl_lookup_id($_GET['s']);
	$server = lgsl_query_cached($lookup['type'], $lookup['ip'], $lookup['c_port'], $lookup['q_port'], $lookup['s_port'], "sep");
	$misc   = lgsl_server_misc($server);

	$hour = date("H"); 
	$hourpl = 0; 
	$hour = $hour + $hourpl; 
	if($hour >= 24) {
		$hour - 24;
	} 
	$time = date("d.m ".$hour.":i"); 

	$im = @imagecreatefromgif("lgsl_files/other/banner_thin.gif"); 	// create background
	
	$on_id = imagecreatefromgif($misc['icon_status']);							// create status icon
	list($width, $height) = getimagesize($misc['icon_status']);
	if($width > 16){
		$on_id = resizeImage(16, 16, $misc['icon_status']);						// resize to 16x16 if it needed
	}
	
	$game_id = imagecreatefromgif($misc['icon_game']);							// create game icon
	list($width, $height) = getimagesize($misc['icon_game']);
	if($width > 16){
		$game_id = resizeImage(16, 16, $misc['icon_game']);						// resize to 16x16 if it needed
	}

	$color_pz = imagecolorallocate($im, 128, 0, 0);
	$color_ip = imagecolorallocate($im, 255, 0, 0);
	$color_map = imagecolorallocate($im, 0, 0, 0); 
	$color_pl = imagecolorallocate($im, 0, 128, 0);
	$color_time = imagecolorallocate($im, 66, 66, 66); 

	imagecopy($im, $on_id, 8, 2, 0, 0, 16, 16);											// place status icon
	imagecopy($im, $game_id, 26, 2, 0, 0, 16, 16);									// place game icon

	imagettftext($im, 7, 0, 44, 17, $color_map, "lgsl_files/other/verdana", 	/* map 			*/	$lgsl_config['text']['map'].": ".$server['s']['map']);
	imagettftext($im, 7, 0, 44, 9, 	$color_ip, 	"lgsl_files/other/verdana", 	/* ip&port	*/ 	$misc['connect_filtered']);
	imagettftext($im, 8, 0, 180, 10, $color_pz, "lgsl_files/other/verdana", 	/* name 		*/	$server['s']['name']);
	imagettftext($im, 7, 0, 150, 18, $color_pl, "lgsl_files/other/verdana", 	/* players 	*/	$lgsl_config['text']['plr'].": ".$server['s']['players']."/".$server['s']['playersmax']);
	imagettftext($im, 5, 0, 238, 18, $color_time, "lgsl_files/other/verdana", /* updated	*/	"upd: ".$time." | ".$server['s']['game']);
	 
	imagegif($im); 
	imagedestroy($im);
//------------------------------------------------------------------------------------------------------------+
?>