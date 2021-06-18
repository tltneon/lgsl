<?php # original author: playzone46@yandex.ru
	header("Content-type: image/gif");
	require "lgsl_files/lgsl_class.php";

	function makeImage($src, $width, $height){
		list($w, $h) = getimagesize($src);
		if(substr($src, -3) == 'gif'){
			$result = imagecreatefromgif($src);
		}
		else {
			$result = imagecreatefrompng($src);
		}
		if($width != $w || $height != $h){
			$image = $result;
			$result = imagecreatetruecolor($width, $height);
			imagecopyresampled($result, $image, 0, 0, 0, 0, $width, $height, $w, $h);
		}
		return $result;
	}

	$lookup = lgsl_lookup_id($_GET['s']);
	$server = lgsl_query_cached($lookup['type'], $lookup['ip'], $lookup['c_port'], $lookup['q_port'], $lookup['s_port'], "s");
	$misc   = lgsl_server_misc($server);
	if(strlen($misc['connect_filtered']) > 22 && $lookup['type'] != 'discord') $misc['connect_filtered'] = gethostbyname(explode(":", $misc['connect_filtered'])[0]) . ":" . explode(":", $misc['connect_filtered'])[1];
  $map = $server['s']['map'];
	if(strlen($server['s']['map']) > 15) $map = substr($server['s']['map'], 0, 13) . '..';

	$hour = date("H") + 0;
	if($hour >= 24) $hour - 24;
	$time = date("d.m ".$hour.":i");

	$im = @makeImage("lgsl_files/other/banner_thin.gif", 350, 20);             // create background
	$on_id = makeImage($misc['icon_status'], 16, 16);                          // create status icon
	$game_id = makeImage($misc['icon_game'], 16, 16);                          // create game icon

	$color_pz = imagecolorallocate($im, 128, 0, 0);
	$color_ip = imagecolorallocate($im, 255, 0, 0);
	$color_map = imagecolorallocate($im, 0, 0, 0);
	$color_pl = imagecolorallocate($im, 255, 94, 0);
	$color_time = imagecolorallocate($im, 66, 66, 66);
	imagecopy($im, $on_id, 8, 2, 0, 0, 16, 16);                                // place status icon
	imagecopy($im, $game_id, 26, 2, 0, 0, 16, 16);                             // place game icon

  $font = dirname(__FILE__) . '/lgsl_files/other/verdana.ttf';
	imagettftext($im, 7, 0, 44, 17, $color_map, $font,   /* map      */  $lgsl_config['text']['map'].": ".$map);
	imagettftext($im, 7, 0, 44, 9, $color_ip, $font,     /* ip&port  */  str_replace('https://', '', $misc['connect_filtered']));
	imagettftext($im, 8, 0, 160, 10, $color_pz, $font,   /* name     */  $server['s']['name']);
	imagettftext($im, 7, 0, 150, 18, $color_pl, $font,   /* players  */  $lgsl_config['text']['plr'].": ".$server['s']['players'].($server['s']['playersmax'] > 999 ? "" : "/".$server['s']['playersmax']));
	imagettftext($im, 5, 0, 238, 18, $color_time, $font, /* updated  */  "upd: ".$time." | ".$server['s']['game']);

	imagegif($im);
	imagedestroy($im);
?>