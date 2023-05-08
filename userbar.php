<?php
  namespace tltneon\LGSL;

	function makeImage($src, $width, $height) {
		list($w, $h) = getimagesize($src);
    switch (substr($src, -3)) {
      case 'gif': {$result = imagecreatefromgif($src); break;}
      case 'png': {$result = imagecreatefrompng($src); break;}
      case 'jpg': {$result = imagecreatefromjpeg($src); break;}
    }
		if ($width != $w || $height != $h) {
			$image = $result;
			$result = imagecreatetruecolor($width, $height);
			imagecopyresampled($result, $image, 0, 0, 0, 0, $width, $height, $w, $h);
		}
		return $result;
	}

  function drawHistory(&$im, $x, $y, $w, $h, &$server) {
    $axis = imagecolorallocate($im, 255, 255, 255);
    $grid = imagecolorallocate($im, 90, 90, 90);
    $chart = imagecolorallocate($im, 120, 255, 120);
    $x0 = [];
    $y0 = [];
    $period = 60 * 60 *24;
    $history = $server->get_history();
    $avg = 0; $avgc = 0;
    foreach ($history as $key) {
      if (time() - $key['t'] > $period) {
        $avg += $key['p'];
        $avgc += 1;
      } else {
        array_push($x0, $key['t'] - time() + $period);
        array_push($y0, $key['p']);
      }
    }
    if ($avgc > 0) {
      array_unshift($x0, 1);
      array_unshift($y0, (int) ($avg / $avgc));
    }

    $max = $server->get_players_count('max') > 0 ? $server->get_players_count('max') : 1;
    $scaleX = $w / (count($x0) > 0 ? max($x0) : 1);
    $scaleY = $h / $max;

    imagestring($im, 1, $x - 15, $y + $h - 4, "0", $axis);
    imagestring($im, 1, $x - 15, floor($y + $h / 2) - 4, floor($max / 2), $axis);
    imagestring($im, 1, $x - 15, $y - 4, $max, $axis);
    imageline($im, $x, $y + $h, $x + $w, $y + $h, $axis);
    imageline($im, $x, $y - 1, $x, $y + $h, $axis);
    imageline($im, $x + 1, floor($y + $h / 2), $x + $w - 2, floor($y + $h / 2), $grid);
    imageline($im, $x + 1, $y, $x + $w - 2, $y, $grid);
    imagestringup($im, 1, $x + $w + 3, $y + $h, "24 hrs", $grid);
    imageantialias($im, true);
    imagesetthickness($im, 2);
    for ($i=1; $i < count($x0); $i++) {
      imageline($im, (int) ($x+$x0[$i-1]*$scaleX), (int) ($y+$h-$y0[$i-1]*$scaleY), (int) ($x+$x0[$i]*$scaleX), (int) ($y+$h-$y0[$i]*$scaleY), $chart);
    }
  }

	require "lgsl_files/lgsl_class.php";
  $query = "cs";
  $bar   = (isset($_GET['t']) ? (int) $_GET['t'] : 1 );
  if ($bar === 3) { $query .= "p"; }
  $s = isset($_GET['s']) ? (int) $_GET['s'] : null;
  $ip = isset($_GET['ip']) ? $_GET['ip'] : null;
  $port = isset($_GET['port']) ? (int) $_GET['port'] : null;
  $server = new Server(array("ip" => $ip, "c_port" => $port, "id" => $s));
  $server->lgsl_cached_query($query);
  if (!$server) {
    header("Content-type: image/gif");
    $im = imagecreatetruecolor(350, 20);
    $white = imagecolorallocate($im, 255, 255, 255);
    imagefill($im, 0, 0, $white);
    imagestring($im, 1, (int)(175 - strlen($lgsl_config['text']['mid']) * 2.2), 6, $lgsl_config['text']['mid'], imagecolorallocate($im, 0, 0, 0));
    imagegif($im);
    imagedestroy($im);
    exit();
  }
	
	// SHARED SETTINGS
	$font = dirname(__FILE__) . '/lgsl_files/other/cousine.ttf';

  switch ($bar) {
    case 2: {
      header("Content-type: image/png");
      // SETTINGS
      $w = 468;
      $h = 64;
      $im = @makeImage("lgsl_files/other/banner468x64.png", $w, $h);              // create background
			$color_nm = imagecolorallocate($im, 255, 255, 255);
			$color_ip = imagecolorallocate($im, 255, 255, 255);
			$color_mp = imagecolorallocate($im, 255, 255, 255);
			$color_pl = imagecolorallocate($im, 255, 255, 255);
			$color_tm = imagecolorallocate($im, 80, 80, 80);
			$stat_on = imagecolorallocate($im, 139, 227, 135);
			$stat_ps = imagecolorallocate($im, 248, 188, 133);
			$stat_pn = imagecolorallocate($im, 66, 66, 66);
			$stat_of = imagecolorallocate($im, 241, 171, 171);
			$border = imagecolorallocatealpha($im, 0, 0, 0, 20);
      // MAIN SECTION
      $link = $server->get_address();
      if (strlen($link) > 22 && $server->get_type() != 'discord') $link = gethostbyname(explode(":", $link)[0]) . ":" . explode(":", $link)[1];
      $max = "/{$server->get_players_count('max')}";
      if ($server->get_players_count('max') > 999) $max = '';

      $time = date(str_replace([':S', ':s', '/Y', '/y'], '', $lgsl_config['text']['tzn']));

      switch ($server->get_status()) {
        case Server::ONLINE: { $stat = $stat_on; break; }
        case Server::OFFLINE: { $stat = $stat_of; break; }
        case Server::PENDING: { $stat = $stat_pn; break; }
        case Server::PASSWORDED: { $stat = $stat_ps; break; }
      }
      imagefilledrectangle($im, 14, 14, 47, 47, $stat);
      $game_id = @makeImage($server->game_icon(), 32, 32);                          // create game icon
      imagecopy($im, $game_id, 16, 16, 0, 0, 32, 32);                             // place game icon

      imagettftext($im, 10, 0, 62,  19, $color_nm, $font, /* name     */  $server->get_name(false));
      imagettftext($im, 8,  0, 62,  32, $color_ip, $font, /* ip&port  */  str_replace('https://', '', $link));
      imagettftext($im, 7,  0, 154, 47, $color_mp, $font, /* map      */  "{$lgsl_config['text']['map']}:{$server->get_map()}");
      imagettftext($im, 7,  0, 62,  48, $color_pl, $font, /* players  */  "{$lgsl_config['text']['plr']}:{$server->get_players_count('active')}{$max}");
      imagettftext($im, 7,  0, 62,  59, $color_tm, $font, /* game     */  ucfirst($server->get_game()));
      imagettftext($im, 7,  0, 238, 59, $color_tm, $font, /* updated  */  "upd:{$time} /{$server->get_game()}");

      drawHistory($im, 374, 24, 80, 24, $server);
      break;
    }
    case 3: {
      header("Content-type: image/jpeg");
      // SETTINGS
      $w = 160;
      $h = 248;
      $im = @makeImage("lgsl_files/other/banner160x248.jpg", $w, $h);              // create background
			$color_nm = imagecolorallocate($im, 255, 255, 255);
			$color_ip = imagecolorallocate($im, 255, 255, 255);
			$color_mp = imagecolorallocate($im, 255, 255, 255);
			$color_pl = imagecolorallocate($im, 255, 255, 255);
			$color_tm = imagecolorallocate($im, 80, 80, 80);
			$stat_on = imagecolorallocate($im, 139, 227, 135);
			$stat_ps = imagecolorallocate($im, 248, 188, 133);
			$stat_pn = imagecolorallocate($im, 66, 66, 66);
			$stat_of = imagecolorallocate($im, 241, 171, 171);
			$border = imagecolorallocatealpha($im, 0, 0, 0, 20);
      // MAIN SECTION
      $link = $server->get_address();
      if (strlen($link) > 22 && $server->get_type() != 'discord') {
        $link = gethostbyname(explode(":", $link)[0]) . ":" . explode(":", $link)[1];
      }
      $time = date(str_replace(array(':S', ':s', '/Y', '/y'), '', $lgsl_config['text']['tzn']));

      switch ($server->get_status()) {
        case Server::ONLINE: { $stat = $stat_on; break; }
        case Server::OFFLINE: { $stat = $stat_of; break; }
        case Server::PENDING: { $stat = $stat_pn; break; }
        case Server::PASSWORDED: { $stat = $stat_ps; break; }
      }
      
      imagettftext($im, 8, 90, 12, $h, $color_nm, $font, /* name  */ $server->get_name(false));
      if (version_compare(phpversion(), '8.0.0', '<')) {
        imagefilledpolygon($im, [0,0, 16,0, 0,16], 3, $stat);
      } else {
        imagefilledpolygon($im, [0,0, 16,0, 0,16], $stat);
      }
      $game_id = @makeImage($server->game_icon(), 16, 16);                              // create game icon
      imagecopy($im, $game_id, $w-16, $h-16, 0, 0, 16, 16);                           // place game icon

      /*$loc_id = @makeImage("lgsl_files\other\locations.gif", 224, 198);    //$server->getLocation()                      // create location icon
			$result = imagecreatetruecolor(16, 11);
			$posX = 0; $posY = 33;
			imagecopyresampled($result, $loc_id, 0, 0, $posX, $posY, 16, 11, 16, 11);
      imagecopy($im, $result, $w-36, $h-13, 0, 0, 16, 11); */                          // place location icon

      //imagestringup($im, 2, 2, $h - 16 - 8, ucfirst($server['s']['game']), $color_nm);
      imagefilledrectangle($im, 17, 0, 20, $h, $border);
      imagefilledrectangle($im, 17, $h-21, $w, $h-17, $border);
      imagefilledrectangle($im, 17, 0, $w, 14, $border);
      imagettftext($im, 8, 0, 25, 12, $color_nm, $font, /* name  */ $lgsl_config['text']['nam']);
      imagettftext($im, 8, 0, 25, 32, $color_nm, $font, /* name  */ $server->get_name(false));
      imagefilledrectangle($im, 17, 40, $w, 54, $border);
      imagettftext($im, 8, 0, 25, 52, $color_ip, $font, /* ip  */  $lgsl_config['text']['adr']);
      if ($server->get_game() == 'discord') {
        imagettftext($im, 8, 0, 25, 74, $color_ip, $font, /* ip  */  str_replace('https://', '', $link));
      } else {
        imagettftext($im, 8, 0, 25, 74, $color_ip, $font, /* ip  */  str_replace('https://', '', $server->get_ip()));
        imagettftext($im, 8, 0, 118, 86, $color_ip, $font,/* port  */  ":{$server->get_c_port()}");
      }
      imagefilledrectangle($im, 17, 100, $w, 114, $border);
      imagettftext($im, 7, 0, 25, 112, $color_mp, $font, /* map      */  "{$lgsl_config['text']['map']}: {$server->get_map()}");
      imagefilledrectangle($im, 17, 120, $w, 134, $border);
      imagettftext($im, 7, 0, 25, 132, $color_pl, $font, /* players  */  "{$lgsl_config['text']['plr']}: {$server->get_players_count()}");
      $players = $server->get_players();
      if ($server->get_players_count('active') > 0 && count($players) > 0) {
        $i = 0;
        foreach ($players as $player) {
          imagettftext($im, 7, 0, 25, 144 + 10 * $i, $color_pl, $font, /* player  */  $player['name']);
          $i++;
          if ($i > 7) {
            imagettftext($im, 7, 0, 25, 144 + 10 * 8, $color_pl, $font, /* player  */  "+ " . ($server->get_players_count('active') - $i . " " . lcfirst($lgsl_config['text']['plr'])));
            break;
          }
        }
      } else {
        imagettftext($im, 7, 0, 25, 190, $color_pl, $font, /* players  */  $lgsl_config['text']['npi']);
      }
      
      imagettftext($im, 6, 0, 25, 242, $color_tm, $font, /* updated  */  "upd:{$time}");
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
      $link = $server->get_address();
      if (strlen($link) > 22 && $server->get_type() != 'discord') $link = gethostbyname(explode(":", $link)[0]) . ":" . explode(":", $link)[1];
      $map = $server->get_map();
      if (strlen($map) > 15) $map = substr($map, 0, 13) . '..';
      $max = "/{$server->get_players_count('max')}";
      if ($server->get_players_count('max') > 999) $max = '';

      $time = date(str_replace([':S', ':s', '/Y', '/y'], '', $lgsl_config['text']['tzn']));

      $on_id = @makeImage($server->icon_status(), 16, 16);                          // create status icon
      $game_id = @makeImage($server->game_icon(), 16, 16);                          // create game icon
      imagecopy($im, $on_id, 7, 2, 0, 0, 16, 16);                                 // place status icon
      imagecopy($im, $game_id, 25, 2, 0, 0, 16, 16);                              // place game icon

      imagettftext($im, 7, 0, 43,  17, $color_mp, $font, /* map      */  "{$lgsl_config['text']['map']}:{$map}");
      imagettftext($im, 7, 0, 43,  9,  $color_ip, $font, /* ip&port  */  str_replace('https://', '', $link));
      imagettftext($im, 8, 0, 156, 9,  $color_nm, $font, /* name     */  $server->get_name(false));
      imagettftext($im, 7, 0, 156, 17, $color_pl, $font, /* players  */  "{$lgsl_config['text']['plr']}:{$server->get_players_count('active')}{$max}");
      imagettftext($im, 5, 0, 238, 18, $color_tm, $font, /* updated  */  "upd:{$time} /{$server->get_game()}");
    }
  }

	imagegif($im);
	imagedestroy($im);
?>