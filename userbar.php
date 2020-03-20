<?php
//------------------------------------------------------------------------------------------------------------+
	# Copyright by http://Play-Z.ru, playzone46@yandex.ru

	header("Content-type: image/gif");

	require "lgsl_files/lgsl_class.php";
//------------------------------------------------------------------------------------------------------------+

	$lookup = lgsl_lookup_id($_GET['s']);
	$server = lgsl_query_cached($lookup['type'], $lookup['ip'], $lookup['c_port'], $lookup['q_port'], $lookup['s_port'], "sep");

	$server = lgsl_sort_players($server);
	$server = lgsl_sort_extras($server);

	$misc   = lgsl_server_misc($server);
	$server = lgsl_server_html($server);

	$hour = date("H"); 
	$hourpl = 0; 
	$hour = $hour + $hourpl; 
	if($hour>=24) {
		$hour-24;
	} 
	$time = date("d.m ".$hour.":i"); 

	$im = @imagecreatefromgif("lgsl_files/other/banner_thin.gif"); 
	$on_id = imagecreatefromgif($misc['icon_status']);
	$game_id = imagecreatefromgif($misc['icon_game']);
	list($width, $height) = getimagesize($misc['icon_game']);
	if($width > 16){
		$image_p = imagecreatetruecolor(16, 16);
		$image = imagecreatefromgif($misc['icon_game']);
		imagecopyresampled($image_p, $image, 0, 0, 0, 0, 16, 16, $width, $height);
		$game_id = $image_p;
	}

	$color_pz = imagecolorallocate($im, 128, 0, 0);
	$color_ip = imagecolorallocate($im, 255, 0, 0);
	$color_map = imagecolorallocate($im, 0, 0, 0); 
	$color_pl = imagecolorallocate($im, 0, 128, 0);
	$color_time = imagecolorallocate($im, 66, 66, 66); 

	imagecopy($im, $on_id, 10, 2, 0, 0, 16, 16);
	imagecopy($im, $game_id, 30, 2, 0, 0, 16, 16);

	imagettftext($im, 8, 0, 155, 10, $color_pz, "lgsl_files/other/verdana.ttf", 	$server['s']['name']);
	imagettftext($im, 7, 0, 51, 17, $color_map, "lgsl_files/other/verdana.ttf", 	$lgsl_config['text']['map'].": ".$server['s']['map']);
	imagettftext($im, 7, 0, 50, 9, 	$color_ip, 	"lgsl_files/other/verdana.ttf", 	$server['b']['ip'].":".$server['b']['c_port']);
	imagettftext($im, 7, 0, 155, 18, $color_pl, "lgsl_files/other/verdana.ttf", 	$lgsl_config['text']['plr'].": ".$server['s']['players']."/".$server['s']['playersmax']);
	imagettftext($im, 5, 0, 242, 18, $color_time, "lgsl_files/other/verdana.ttf", 	"upd: ".$time." | ".$server['s']['game']);
	 
	imagegif($im); 
	imagedestroy($im);
//------------------------------------------------------------------------------------------------------------+
?>