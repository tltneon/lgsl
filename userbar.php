<?php

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

	require "lgsl_files/lgsl_class.php";
	$lookup = lgsl_lookup_id($_GET['s']);
  if(!$lookup){
    header("Content-type: image/gif");
    $im = imagecreatetruecolor(350, 20);
    $white = imagecolorallocate($im, 255, 255, 255);
    imagefill($im, 0, 0, $white);
    imagestring($im, 1, (int)(175 - strlen($lgsl_config['text']['mid']) * 2.2), 6, $lgsl_config['text']['mid'], imagecolorallocate($im, 0, 0, 0));
    imagegif($im);
    imagedestroy($im);
    exit();
  }
	$server = lgsl_query_cached($lookup['type'], $lookup['ip'], $lookup['c_port'], $lookup['q_port'], $lookup['s_port'], "s");
	$misc   = lgsl_server_misc($server);
  $bar = (isset($_GET['t']) ? (int) $_GET['t'] : 1 );

  switch($bar){
    case 2: {
      header("Content-type: image/png");
      // SETTINGS
      $w = 468;
      $h = 64;
      $im = @makeImage("lgsl_files/other/banner468x64.png", $w, $h);              // create background
      $color_nm = imagecolorallocate($im, 255, 255, 255);
      $color_ip = imagecolorallocate($im, 255, 0, 0);
      $color_mp = imagecolorallocate($im, 255, 255, 255);
      $color_pl = imagecolorallocate($im, 255, 255, 255);
      $color_tm = imagecolorallocate($im, 80, 80, 80);
      $stat_on = imagecolorallocate($im, 139, 227, 135);
      $stat_ps = imagecolorallocate($im, 248, 188, 133);
      $stat_pn = imagecolorallocate($im, 66, 66, 66);
      $stat_of = imagecolorallocate($im, 241, 171, 171);
      // MAIN SECTION
      if(strlen($misc['connect_filtered']) > 22 && $lookup['type'] != 'discord') $misc['connect_filtered'] = gethostbyname(explode(":", $misc['connect_filtered'])[0]) . ":" . explode(":", $misc['connect_filtered'])[1];

      $time = date(str_replace(array(':S', ':s', '/Y', '/y'), '', $lgsl_config['text']['tzn']));

      switch($misc['text_status']){
        case 'pen': { $stat = $stat_pn; break; }
        case 'nrs': { $stat = $stat_of; break; }
        case 'onp': { $stat = $stat_ps; break; }
        case 'onl': { $stat = $stat_on; break; }
      }
      imagefilledrectangle($im, 14, 14, 47, 47, $stat);
      $game_id = makeImage($misc['icon_game'], 32, 32);                          // create game icon
      imagecopy($im, $game_id, 16, 16, 0, 0, 32, 32);                             // place game icon

      $font = dirname(__FILE__) . '/lgsl_files/other/cousine.ttf';
      imagettftext($im, 10, 0, 62,  20, $color_nm, $font, /* name     */  $server['s']['name']);
      imagettftext($im, 8,  0, 62,  32, $color_ip, $font, /* ip&port  */  str_replace('https://', '', $misc['connect_filtered']));
      imagettftext($im, 7,  0, 154, 47, $color_mp, $font, /* map      */  $lgsl_config['text']['map'].":".$server['s']['map']);
      imagettftext($im, 7,  0, 62,  48, $color_pl, $font, /* players  */  $lgsl_config['text']['plr'].":".$server['s']['players'].($server['s']['playersmax'] > 999 ? "" : "/".$server['s']['playersmax']));
      imagettftext($im, 6,  0, 238, 58, $color_tm, $font, /* updated  */  "upd:".$time." /".$server['s']['game']);      
      break;
    }
    default: {
      header("Content-type: image/gif");
      // SETTINGS
      $w = 350;
      $h = 20;
      $im = @makeImage("lgsl_files/other/banner350x20.gif", $w, $h);              // create background
      $color_nm = imagecolorallocate($im, 128, 0, 0);
      $color_ip = imagecolorallocate($im, 255, 0, 0);
      $color_mp = imagecolorallocate($im, 0, 0, 0);
      $color_pl = imagecolorallocate($im, 255, 94, 0);
      $color_tm = imagecolorallocate($im, 66, 66, 66);
      // MAIN SECTION
      if(strlen($misc['connect_filtered']) > 22 && $lookup['type'] != 'discord') $misc['connect_filtered'] = gethostbyname(explode(":", $misc['connect_filtered'])[0]) . ":" . explode(":", $misc['connect_filtered'])[1];
      $map = $server['s']['map'];
      if(strlen($server['s']['map']) > 15) $map = substr($server['s']['map'], 0, 13) . '..';

      $time = date(str_replace(array(':S', ':s', '/Y', '/y'), '', $lgsl_config['text']['tzn']));

      $on_id = makeImage($misc['icon_status'], 16, 16);                          // create status icon
      $game_id = makeImage($misc['icon_game'], 16, 16);                          // create game icon
      imagecopy($im, $on_id, 7, 2, 0, 0, 16, 16);                                // place status icon
      imagecopy($im, $game_id, 25, 2, 0, 0, 16, 16);                             // place game icon

      $font = dirname(__FILE__) . '/lgsl_files/other/cousine.ttf';
      imagettftext($im, 7, 0, 43,  17, $color_mp, $font, /* map      */  $lgsl_config['text']['map'].":".$map);
      imagettftext($im, 7, 0, 43,  9,  $color_ip, $font, /* ip&port  */  str_replace('https://', '', $misc['connect_filtered']));
      imagettftext($im, 8, 0, 156, 9,  $color_nm, $font, /* name     */  $server['s']['name']);
      imagettftext($im, 7, 0, 156, 17, $color_pl, $font, /* players  */  $lgsl_config['text']['plr'].":".$server['s']['players'].($server['s']['playersmax'] > 999 ? "" : "/".$server['s']['playersmax']));
      imagettftext($im, 5, 0, 238, 18, $color_tm, $font, /* updated  */  "upd:".$time." /".$server['s']['game']);
    }
  }

	imagegif($im);
	imagedestroy($im);
?>