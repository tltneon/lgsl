<?php
  namespace tltneon\LGSL;

  function findMax(&$server) {
    $history = $server->get_history();
    $max = 1;
    if (count($history) > 0) {
      foreach ($history as $item) {
        if ($item['p'] > $max) $max = $item['p'];
      }
    }
    return $max + 1;
  }

  // SETTINGS

  $w = 400;
  $h = 150;
  $im = @imagecreate($w, $h);
  $white = imagecolorallocate($im, 255, 255, 255);
  $gray = imagecolorallocate($im, 225, 225, 225);
  $black = imagecolorallocate($im, 0, 0, 0);
  $green = imagecolorallocate($im, 20, 255, 0);
  $red = imagecolorallocate($im, 255, 0, 0);

  // MAIN SECTION

  header("Content-Type: image/png");
  require "src/lgsl_class.php";
  $s = (int) ($_GET['s'] ?? null);
  $ip = $_GET['ip'] ?? null;
  $port = (int) ($_GET['port'] ?? null);
  $server = new Server(["ip" => $ip, "c_port" => $port, "id" => $s]);
  $server->lgsl_cached_query("cs");
  if (!$server) {
    Image::makeImageError($w, $h, $lgsl_config['text']['mid']);
  }
  $max = $server->get_players_count('max') > 0 ? $server->get_players_count('max') : findMax($server);
  $x0 = 30;
  $y0 = 20;
  global $lgsl_config;
  $period = 3600 * $lgsl_config['history_hours'];
  $xStep = 30;
  $yStep = (int) ($max > 32 ? 9 : 100 / $max) + 1;

  $s = $x = $y = [];
  $history = $server->get_history();
  $avg = 0; $avgc = 0;
  foreach ($history as $key) {
    if (time() - $key['t'] > $period * 1000) {
      $avg += $key['p'];
      $avgc += 1;
    } else {
      array_push($s, $key['s']);
      array_push($x, $key['t'] - time() + $period);
      array_push($y, $key['p']);
    }
  }
  if ($avgc > 0) {
    array_unshift($s, 1);
    array_unshift($x, 1);
    array_unshift($y, (int) ($avg / $avgc));
  }

  $maxX = $w - $x0;
  $maxY = $h - $y0;
  $scaleX = ($maxX - $x0) / (count($x) > 0 ? max($x) : 1);
  $scaleY = ($maxY - $y0) / $max;

  // DRAW AXIS

  imageline($im, $x0, $maxY, $maxX, $maxY, $black);
  imageline($im, $x0, $y0, $x0, $maxY, $black);
  imageantialias($im, true);

  // DRAW GRID

  $xSteps = ($maxX - $x0) / $xStep - 1;
  for ($i = 1; $i < $xSteps + 1; $i++) {
    imageline($im, $x0 + $xStep * $i, $y0, $x0 + $xStep * $i, $maxY - 1, $gray);
    $str = Date("H:i", time() - $period + (int) ($i * round($xStep / $scaleX, 1)));
    imagestring($im, 1, (($x0 + $xStep * $i) - 6), $maxY + 2, $str, $black);
  }
  imagestring($im, 1, $x0 - 6, $maxY + 2, $str, $black);

  if (count($history) > 0) {
    $ySteps = ($maxY-$y0) / $yStep - 1;
    for ($i = 1; $i < $ySteps + 1; $i++) {
      imageline($im, $x0 + 1, (int) $maxY - $yStep * $i, $maxX, (int) $maxY - $yStep * $i, $gray);
      if ($max > 32 || $i % (int) (1 + $max / 10) == 0) {
        imagestring($im, 1, 3, ($maxY - $yStep * $i) - 3, round($i * $yStep / $scaleY, 0), $black);
      }
    }
  } else {
    imagestring($im, 2, 150, 65, $lgsl_config['text']['npi'], $black);
  }
  imageline($im, $x0 - 15, $maxY, $x0, $maxY, $black);
  imagestring($im, 1, 3, $maxY - 3, 0, $black);
  imageline($im, $x0 - 8, $y0, $x0, $y0, $black);
  // imagestring($im, 1, 3, $y0 - 3, $server['s']['playersmax'], $black);

  // DRAW GRAPH

  imagesetthickness($im, 3);
	if (count($x) == 1) {
		imagefilledellipse($im, (int) ($x0 + $x[0] * $scaleX), (int) ($maxY - $y[0] * $scaleY), 6, 6, $green);
	} else {
		for ($i = 1; $i < count($x); $i++) {
			if ($s[$i] == 0) {
				imagefilledellipse($im, (int) ($x0 + $x[$i] * $scaleX), (int) ($maxY - $y[$i] * $scaleY), 6, 6, $red);
			}
			imageline($im, (int) ($x0 + $x[$i-1] * $scaleX), (int) ($maxY - $y[$i-1] * $scaleY), (int) ($x0 + $x[$i] * $scaleX), (int) ($maxY - $y[$i] * $scaleY), $green);
		}
	}

  $game_id = Image::makeImage($server->game_icon('src/'), 16, 16); // create game icon
  imagecopy($im, $game_id, 7, 2, 0, 0, 16, 16);             // place game icon

  $font = dirname(__FILE__) . '/src/other/cousine.ttf';
	imagettftext($im, 7, 0, 28, 8, $black, $font, $lgsl_config['text']['nam'] . ": " . trim($server->get_name(false)));
	imagettftext($im, 6, 0, 27, 17, $black, $font, $lgsl_config['text']['adr'] . ": " . str_replace('https://', '', $server->get_address()));
	imagettftext($im, 6, 0, $w - 52, 17, $black, $font, date($lgsl_config['text']['tzn']));
  imagettftext($im, 6, 0, $w - 110, $h-3, $black, $font, "Shows last {$lgsl_config['history_hours']} hours");

  $s = (isset($_SERVER['HTTPS']) ? 's' : '');
  header("Link: <http{$s}://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}>; rel=\"canonical\"");
  header("X-Powered-By: PHP/" . phpversion() . " LGSL/" . LGSL::VERSION); 
  imagepng($im);
  imagedestroy($im);
?>