<?php

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
    $x0 = array();
    $y0 = array();
    $history = $server['s']['history'] or array();
    foreach ($history as $key) {
      array_push($x0, $key['time'] - time() + 60*60*24);
      array_push($y0, $key['players']);
    }

    $server['s']['playersmax'] = $server['s']['playersmax'] > 0 ? $server['s']['playersmax'] : 1;
    $scaleX = $w / (count($x0) > 0 ? max($x0) : 1);
    $scaleY = $h / $server['s']['playersmax'];

    imagestring($im, 1, $x - 27, $y + $h - 4, str_pad("0", 5, " ", STR_PAD_LEFT), $axis);
    imagestring($im, 1, $x - 27, floor($y + $h / 2) - 4, str_pad(floor($server['s']['playersmax'] / 2), 5, " ", STR_PAD_LEFT), $axis);
    imagestring($im, 1, $x - 27, $y - 4, str_pad($server['s']['playersmax'], 5, " ", STR_PAD_LEFT), $axis);
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
  $bar   = (isset($_GET['t']) ? (int) $_GET['t'] : 1);
  if ($bar == 3) { $query .= "p"; }
  $server = isset($_GET['s']) ? lgsl_query_cached("", "", "", "", "", $query, (int) $_GET['s']) : lgsl_query_cached("", $_GET['ip'], (int) $_GET['port'], "", "", $query);
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
  $misc = lgsl_server_misc($server);
  global $lgsl_url_path;
  $misc['icon_game'] = str_replace($lgsl_url_path, "lgsl_files/", $misc['icon_game']);
  $misc['icon_location'] = str_replace($lgsl_url_path, "lgsl_files/", $misc['icon_location']);
  $misc['icon_status'] = str_replace($lgsl_url_path, "lgsl_files/", $misc['icon_status']);  

  switch ($bar) {
    case 2: {
      // SETTINGS
      $w = 468;
      $h = 64;
      $im = @makeImage("lgsl_files/other/banner468x64.png", $w, $h);              // create background
      $color_nm = imagecolorallocate($im, 255, 255, 255);
      $color_ip = imagecolorallocate($im, 255, 0, 0);
      $color_mp = imagecolorallocate($im, 255, 255, 255);
      $color_pl = imagecolorallocate($im, 255, 255, 255);
      $color_tm = imagecolorallocate($im, 110, 110, 110);
      $stat_on = imagecolorallocate($im, 139, 227, 135);
      $stat_ps = imagecolorallocate($im, 248, 188, 133);
      $stat_pn = imagecolorallocate($im, 66, 66, 66);
      $stat_of = imagecolorallocate($im, 241, 171, 171);
      $font = dirname(__FILE__) . '/lgsl_files/other/cousine.ttf';
      // MAIN SECTION
      if(strlen($misc['connect_filtered']) > 22 && $server['b']['type'] != 'discord') $misc['connect_filtered'] = gethostbyname(explode(":", $misc['connect_filtered'])[0]) . ":" . explode(":", $misc['connect_filtered'])[1];

      $time = date(str_replace(array(':S', ':s', '/Y', '/y'), '', $lgsl_config['text']['tzn']));

      switch ($misc['text_status']) {
        case 'pen': { $stat = $stat_pn; break; }
        case 'nrs': { $stat = $stat_of; break; }
        case 'onp': { $stat = $stat_ps; break; }
        case 'onl': { $stat = $stat_on; break; }
      }
      imagefilledrectangle($im, 14, 14, 47, 47, $stat);
      $game_id = @makeImage($misc['icon_game'], 32, 32);                          // create game icon
      imagecopy($im, $game_id, 16, 16, 0, 0, 32, 32);                             // place game icon

      imagettftext($im, 10, 0, 62,  19, $color_nm, $font, /* name     */  $server['s']['name']);
      imagettftext($im, 8,  0, 62,  32, $color_ip, $font, /* ip&port  */  str_replace('https://', '', $misc['connect_filtered']));
      imagettftext($im, 7,  0, 154, 47, $color_mp, $font, /* map      */  "{$lgsl_config['text']['map']}:{$server['s']['map']}");
      imagettftext($im, 7,  0, 62,  48, $color_pl, $font, /* players  */  "{$lgsl_config['text']['plr']}:{$server['s']['players']}".($server['s']['playersmax'] > 999 ? "" : "/{$server['s']['playersmax']}"));
      imagettftext($im, 7,  0, 62,  59, $color_tm, $font, /* game     */  ucfirst($server['s']['game']));
      imagettftext($im, 7,  0, 238, 59, $color_tm, $font, /* updated  */  "upd:{$time} /{$server['s']['game']}");

      if ($lgsl_config['history']) drawHistory($im, 374, 24, 80, 24, $server);
      break;
    }
    case 3: {
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
      $font = dirname(__FILE__) . '/lgsl_files/other/cousine.ttf';
      // MAIN SECTION
      if (strlen($misc['connect_filtered']) > 22 && $server['b']['type'] != 'discord') $misc['connect_filtered'] = gethostbyname(explode(":", $misc['connect_filtered'])[0]) . ":" . explode(":", $misc['connect_filtered'])[1];

      $time = date(str_replace(array(':S', ':s', '/Y', '/y'), '', $lgsl_config['text']['tzn']));

      switch ($misc['text_status']) {
        case 'pen': { $stat = $stat_pn; break; }
        case 'nrs': { $stat = $stat_of; break; }
        case 'onp': { $stat = $stat_ps; break; }
        case 'onl': { $stat = $stat_on; break; }
      }

      imagettftext($im, 8, 90, 12, $h, $color_nm, $font, /* name  */ $server['s']['name']);
      if (version_compare(phpversion(), '8.0.0', '<')) {
        imagefilledpolygon($im, array(0,0, 16,0, 0,16), 3, $stat);
      } else {
        imagefilledpolygon($im, array(0,0, 16,0, 0,16), $stat);
      }
      $game_id = @makeImage($misc['icon_game'], 16, 16);                             // create game icon
      imagecopy($im, $game_id, $w-16, $h-16, 0, 0, 16, 16);                          // place game icon

      $loc_id = @makeImage($misc['icon_location'], 12, 12);                          // create location icon
      imagecopy($im, $loc_id, $w-30, $h-14, 0, 0, 12, 12);                           // place location icon

      //imagestringup($im, 2, 2, $h - 16 - 8, ucfirst($server['s']['game']), $color_nm);
      imagefilledrectangle($im, 17, 0, 20, $h, $border);
      imagefilledrectangle($im, 17, $h-21, $w, $h-17, $border);
      imagefilledrectangle($im, 17, 0, $w, 14, $border);
      imagettftext($im, 8, 0, 25, 12, $color_nm, $font, /* name  */ $lgsl_config['text']['nam']);
      imagettftext($im, 8, 0, 25, 32, $color_nm, $font, /* name  */ $server['s']['name']);
      imagefilledrectangle($im, 17, 40, $w, 54, $border);
      imagettftext($im, 8, 0, 25, 52, $color_ip, $font, /* ip  */  $lgsl_config['text']['adr']);
      if ($server['s']['game'] == 'discord') {
        imagettftext($im, 8, 0, 25, 74, $color_ip, $font, /* ip  */  str_replace('https://', '', $misc['connect_filtered']));
      } else {
        imagettftext($im, 8, 0, 25, 74, $color_ip, $font, /* ip  */  str_replace('https://', '', $server['b']['ip']));
        imagettftext($im, 8, 0, 118, 86, $color_ip, $font,/* port  */  ":{$server['b']['c_port']}");
      }
      imagefilledrectangle($im, 17, 100, $w, 114, $border);
      imagettftext($im, 7, 0, 25, 112, $color_mp, $font, /* map      */  "{$lgsl_config['text']['map']}: {$server['s']['map']}");
      imagefilledrectangle($im, 17, 120, $w, 134, $border);
      imagettftext($im, 7, 0, 25, 132, $color_pl, $font, /* players  */  "{$lgsl_config['text']['plr']}: {$server['s']['players']}/{$server['s']['playersmax']}");
      if ($server['s']['players'] > 0 && isset($server['p']) && count($server['p']) > 0) {
        $i = 0;
        foreach ($server['p'] as $player) {
          imagettftext($im, 7, 0, 25, 144 + 10 * $i, $color_pl, $font, /* player  */  $player['name']);
          $i++;
          if ($i > 7) {
            imagettftext($im, 7, 0, 25, 144 + 10 * 8, $color_pl, $font, /* player  */  "+ " . ($server['s']['players'] - $i . " " . lcfirst($lgsl_config['text']['plr'])));
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
      $im = @makeImage("lgsl_files/other/banner350x20.gif", $w, $h);              // create background
      $color_nm = imagecolorallocate($im, 128, 0, 0);
      $color_ip = imagecolorallocate($im, 255, 0, 0);
      $color_mp = imagecolorallocate($im, 0, 0, 0);
      $color_pl = imagecolorallocate($im, 255, 94, 0);
      $color_tm = imagecolorallocate($im, 66, 66, 66);
      $font = dirname(__FILE__) . '/lgsl_files/other/cousine.ttf';
      // MAIN SECTION
      if (strlen($misc['connect_filtered']) > 22 && $server['b']['type'] != 'discord') $misc['connect_filtered'] = gethostbyname(explode(":", $misc['connect_filtered'])[0]) . ":" . explode(":", $misc['connect_filtered'])[1];
      $map = $server['s']['map'];
      if (strlen($server['s']['map']) > 15) $map = substr($server['s']['map'], 0, 13) . '..';

      $time = date(str_replace(array(':S', ':s', '/Y', '/y'), '', $lgsl_config['text']['tzn']));

      $on_id = @makeImage($misc['icon_status'], 16, 16);                          // create status icon
      $game_id = @makeImage($misc['icon_game'], 16, 16);                          // create game icon
      imagecopy($im, $on_id, 7, 2, 0, 0, 16, 16);                                 // place status icon
      imagecopy($im, $game_id, 25, 2, 0, 0, 16, 16);                              // place game icon

      imagettftext($im, 7, 0, 43,  17, $color_mp, $font, /* map      */  "{$lgsl_config['text']['map']}:{$map}");
      imagettftext($im, 7, 0, 43,  9,  $color_ip, $font, /* ip&port  */  str_replace('https://', '', $misc['connect_filtered']));
      imagettftext($im, 8, 0, 156, 9,  $color_nm, $font, /* name     */  $server['s']['name']);
      imagettftext($im, 7, 0, 156, 17, $color_pl, $font, /* players  */  "{$lgsl_config['text']['plr']}:{$server['s']['players']}".($server['s']['playersmax'] > 999 ? "" : "/{$server['s']['playersmax']}"));
      imagettftext($im, 5, 0, 238, 18, $color_tm, $font, /* updated  */  "upd:{$time} /{$server['s']['game']}");
    }
  }

  header("Content-type: image/gif");
  imagegif($im);
  imagedestroy($im);
?>