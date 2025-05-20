<?php
  namespace tltneon\LGSL;

  function drawHistory(&$im, $x, $y, $w, $h, &$server) {
    $axis = imagecolorallocate($im, 255, 255, 255);
    $grid = imagecolorallocate($im, 90, 90, 90);
    $chart = imagecolorallocate($im, 120, 255, 120);
    $x0 = $y0 = [];
    global $lgsl_config;
    $period = 3600 * $lgsl_config['history_hours'];
    $history = $server->getHistoryArray();
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

    $max = $server->getPlayersMaxCount() > 0 ? $server->getPlayersMaxCount() : 1;
    $scaleX = $w / (count($x0) > 0 ? max($x0) : 1);
    $scaleY = $h / $max;

    imagestring($im, 1, $x - 27, $y + $h - 4, str_pad("0", 5, " ", STR_PAD_LEFT), $axis);
    imagestring($im, 1, $x - 27, floor($y + $h / 2) - 4, str_pad(floor($max / 2), 5, " ", STR_PAD_LEFT), $axis);
    imagestring($im, 1, $x - 27, $y - 4, str_pad($max, 5, " ", STR_PAD_LEFT), $axis);
    imageline($im, $x, $y + $h, $x + $w, $y + $h, $axis);
    imageline($im, $x, $y - 1, $x, $y + $h, $axis);
    imageline($im, $x + 1, floor($y + $h / 2), $x + $w - 2, floor($y + $h / 2), $grid);
    imageline($im, $x + 1, $y, $x + $w - 2, $y, $grid);
    imagestringup($im, 1, $x + $w + 3, $y + $h, "{$lgsl_config['history_hours']} hrs", $grid);
    imageantialias($im, true);
    imagesetthickness($im, 2);
    for ($i=1; $i < count($x0); $i++) {
      imageline($im, (int) ($x+$x0[$i-1]*$scaleX), (int) ($y+$h-$y0[$i-1]*$scaleY), (int) ($x+$x0[$i]*$scaleX), (int) ($y+$h-$y0[$i]*$scaleY), $chart);
    }
  }

	require "src/lgsl_class.php";
  $query = "s" . (isset($_GET['cacheonly']) ? "c" : "");
  $bar = (int) ($_GET['t'] ?? 1);
  if ($bar === 3) { $query .= "p"; }
  $s = isset($_GET['s']) ? (int) $_GET['s'] : null;
  $ip = isset($_GET['ip']) ? $_GET['ip'] : null;
  $port = isset($_GET['port']) ? (int) $_GET['port'] : null;
  $server = new Server(["ip" => $ip, "c_port" => $port, "id" => $s]);
  $server->queryCached($query);
  if (!$server) {
    Image::makeImageError(350, 20, $lgsl_config['text']['mid']);
  }
	
	// SHARED SETTINGS
	$font = dirname(__FILE__) . '/src/other/cousine.ttf';

  switch ($bar) {
    case 2: {
      // SETTINGS
      $w = 468;
      $h = 64;
      $im = @Image::makeImage("src/other/banner468x64.png", $w, $h);              // create background
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
      $link = $server->getAddress();
      if (strlen($link) > 22 && $server->getType() != 'discord') $link = gethostbyname(explode(":", $link)[0]) . ":" . explode(":", $link)[1];
      $max = "/{$server->getPlayersMaxCount()}";
      if ($server->getPlayersMaxCount() > 999) $max = '';

      $time = date(str_replace([':S', ':s', '/Y', '/y'], '', $lgsl_config['text']['tzn']));

      switch ($server->getStatus()) {
        case Server::ERROR:
        case Server::ONLINE: { $stat = $stat_on; break; }
        case Server::OFFLINE: { $stat = $stat_of; break; }
        case Server::PENDING: { $stat = $stat_pn; break; }
        case Server::PASSWORDED: { $stat = $stat_ps; break; }
      }
      imagefilledrectangle($im, 14, 14, 47, 47, $stat);
      $game_id = @Image::makeImage($server->getGameIcon('src/'), 32, 32);                          // create game icon
      imagecopy($im, $game_id, 16, 16, 0, 0, 32, 32);                             // place game icon

      imagettftext($im, 10, 0, 62,  19, $color_nm, $font, /* name     */  $server->getName(true));
      imagettftext($im, 8,  0, 62,  32, $color_ip, $font, /* ip&port  */  str_replace('https://', '', $link));
      imagettftext($im, 7,  0, 154, 47, $color_mp, $font, /* map      */  "{$lgsl_config['text']['map']}: {$server->getMap()}");
      imagettftext($im, 7,  0, 62,  48, $color_pl, $font, /* players  */  "{$lgsl_config['text']['plr']}: {$server->getPlayersCount()}{$max}");
      imagettftext($im, 7,  0, 62,  59, $color_tm, $font, /* game     */  ucfirst($server->getGame()));
      imagettftext($im, 7,  0, 238, 59, $color_tm, $font, /* updated  */  "upd:{$time} /{$server->getGame()}");

      if ($lgsl_config['history']) drawHistory($im, 374, 24, 80, 24, $server);
      break;
    }
    case 3: {
      // SETTINGS
      $w = 160;
      $h = 248;
      $im = @Image::makeImage("src/other/banner160x248.jpg", $w, $h);              // create background
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
      $link = $server->getAddress();
      if (strlen($link) > 22 && $server->getType() != 'discord') {
        $link = gethostbyname(explode(":", $link)[0]) . ":" . explode(":", $link)[1];
      }
      $time = date(str_replace([':S', ':s', '/Y', '/y'], '', $lgsl_config['text']['tzn']));

      switch ($server->getStatus()) {
        case Server::ERROR:
        case Server::ONLINE: { $stat = $stat_on; break; }
        case Server::OFFLINE: { $stat = $stat_of; break; }
        case Server::PENDING: { $stat = $stat_pn; break; }
        case Server::PASSWORDED: { $stat = $stat_ps; break; }
      }
      
      imagettftext($im, 8, 90, 12, $h, $color_nm, $font, /* name  */ $server->getName(false));
      if (version_compare(phpversion(), '8.0.0', '<')) {
        imagefilledpolygon($im, [0,0, 16,0, 0,16], 3, $stat);
      } else {
        imagefilledpolygon($im, [0,0, 16,0, 0,16], $stat);
      }
      $game_id = @Image::makeImage($server->getGameIcon('src/'), 16, 16);                              // create game icon
      imagecopy($im, $game_id, $w-16, $h-16, 0, 0, 16, 16);                           // place game icon

      if ($lgsl_config['locations']) {
        $loc_id = @Image::makeImage("src/other/locations.gif", 224, 198);              // create location icon
        $result = imagecreatetruecolor(16, 11);
        $pos = LGSL::locationCoords($server->getLocation());
        imagecopyresampled($result, $loc_id, 0, 0, $pos[0], $pos[1], 16, 11, 16, 11);
        imagecopy($im, $result, $w-36, $h-13, 0, 0, 16, 11);                           // place location icon
      }

      //imagestringup($im, 2, 2, $h - 16 - 8, ucfirst($server['s']['game']), $color_nm);
      imagefilledrectangle($im, 17, 0, 20, $h, $border);
      imagefilledrectangle($im, 17, $h-21, $w, $h-17, $border);
      imagefilledrectangle($im, 17, 0, $w, 14, $border);
      imagettftext($im, 8, 0, 25, 12, $color_nm, $font, /* name  */ $lgsl_config['text']['nam']);
      imagettftext($im, 8, 0, 25, 32, $color_nm, $font, /* name  */ $server->getName(false));
      imagefilledrectangle($im, 17, 40, $w, 54, $border);
      imagettftext($im, 8, 0, 25, 52, $color_ip, $font, /* ip  */  $lgsl_config['text']['adr']);
      if ($server->getGame() == 'discord') {
        imagettftext($im, 8, 0, 25, 74, $color_ip, $font, /* ip  */  str_replace('https://', '', $link));
      } else {
        imagettftext($im, 8, 0, 25, 74, $color_ip, $font, /* ip  */  str_replace('https://', '', $server->getIp()));
        imagettftext($im, 8, 0, 118, 86, $color_ip, $font,/* port  */  ":{$server->getConnectionPort()}");
      }
      imagefilledrectangle($im, 17, 100, $w, 114, $border);
      imagettftext($im, 7, 0, 25, 112, $color_mp, $font, /* map      */  "{$lgsl_config['text']['map']}: {$server->getMap()}");
      imagefilledrectangle($im, 17, 120, $w, 134, $border);
      imagettftext($im, 7, 0, 25, 132, $color_pl, $font, /* players  */  "{$lgsl_config['text']['plr']}: {$server->getPlayersCountFormatted()}");
      $players = $server->getPlayersArray();
      if ($server->getPlayersCount() > 0 && count($players) > 0) {
        $i = 0;
        foreach ($players as $player) {
          imagettftext($im, 7, 0, 25, 144 + 10 * $i, $color_pl, $font, /* player  */  $player['name']);
          $i++;
          if ($i > 7) {
            imagettftext($im, 7, 0, 25, 144 + 10 * 8, $color_pl, $font, /* player  */  "+ " . ($server->getPlayersCount() - $i . " " . lcfirst($lgsl_config['text']['plr'])));
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
      // SETTINGS
      $w = 350;
      $h = 20;
      $im = @Image::makeImage("src/other/banner350x20.gif", $w, $h);              // create background
      $color_nm = imagecolorallocate($im, 128, 0, 0);
      $color_ip = imagecolorallocate($im, 255, 0, 0);
      $color_mp = imagecolorallocate($im, 0, 0, 0);
      $color_pl = imagecolorallocate($im, 255, 94, 0);
      $color_tm = imagecolorallocate($im, 66, 66, 66);
      // MAIN SECTION
      $link = $server->getAddress();
      if (strlen($link) > 22 && $server->getType() != 'discord') $link = gethostbyname(explode(":", $link)[0]) . ":" . explode(":", $link)[1];
      $map = $server->getMap();
      if (strlen($map) > 15) $map = substr($map, 0, 13) . '..';
      $max = "/{$server->getPlayersMaxCount()}";
      if ($server->getPlayersMaxCount() > 999) $max = '';

      $time = date(str_replace([':S', ':s', '/Y', '/y'], '', $lgsl_config['text']['tzn']));

      $on_id = @Image::makeImage($server->getStatusIcon('src/'), 16, 16);                          // create status icon
      $game_id = @Image::makeImage($server->getGameIcon('src/'), 16, 16);                          // create game icon
      imagecopy($im, $on_id, 7, 2, 0, 0, 16, 16);                                 // place status icon
      imagecopy($im, $game_id, 25, 2, 0, 0, 16, 16);                              // place game icon

      imagettftext($im, 7, 0, 43,  17, $color_mp, $font, /* map      */  "{$lgsl_config['text']['map']}: {$map}");
      imagettftext($im, 7, 0, 43,  9,  $color_ip, $font, /* ip&port  */  str_replace('https://', '', $link));
      imagettftext($im, 8, 0, 156, 9,  $color_nm, $font, /* name     */  $server->getName(false));
      imagettftext($im, 7, 0, 156, 17, $color_pl, $font, /* players  */  "{$lgsl_config['text']['plr']}: {$server->getPlayersCount()}{$max}");
      imagettftext($im, 5, 0, 238, 18, $color_tm, $font, /* updated  */  "upd: {$time} / {$server->getGame()}");
    }
  }

  header("Content-type: image/gif");
  $s = (isset($_SERVER['HTTPS']) ? 's' : '');
  header("Link: <http{$s}://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}>; rel=\"canonical\"");
  header("X-Powered-By: PHP/" . phpversion() . " LGSL/" . LGSL::VERSION); 
	imagegif($im);
	imagedestroy($im);
?>
