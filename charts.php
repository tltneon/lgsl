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
  require "lgsl_files/lgsl_class.php";
  $lookup = lgsl_lookup_id($_GET['s']);
  if(!$lookup){
    imagestring($im, 1, (int)($w / 2 - strlen($lgsl_config['text']['mid']) * 2.2), (int)($h / 2), $lgsl_config['text']['mid'], $black);
    imagepng($im);
    imagedestroy($im);
    exit();
  }
  $server = lgsl_query_cached($lookup['type'], $lookup['ip'], $lookup['c_port'], $lookup['q_port'], $lookup['s_port'], "s");
  $misc   = lgsl_server_misc($server);
  $server['s']['playersmax'] = $server['s']['playersmax'] > 0 ? $server['s']['playersmax'] : 1;

  $x0 = 30;
  $y0 = 20;
  $period = 60 * 60 * 24; // 1 day
  $xStep = 30;
  $yStep = (int)($server['s']['playersmax'] > 32 ? 9 : 100 / $server['s']['playersmax']) + 1;

  $s = array();
  $x = array();
  $y = array();
  $history = $server['s']['history'] or array();
  foreach($history as $key){
    array_push($s, $key['status']);
    array_push($x, $key['time'] - time() + $period);
    array_push($y, $key['players']);
  }

  $maxX = $w - $x0;
  $maxY = $h - $y0;
  $scaleX = ($maxX-$x0) / max($x);
  $scaleY = ($maxY-$y0) / $server['s']['playersmax'];

  // DRAW AXIS

  imageline($im, $x0, $maxY, $maxX, $maxY, $black);
  imageline($im, $x0, $y0, $x0, $maxY, $black);

  // DRAW GRID

  $xSteps = ($maxX-$x0) / $xStep-1;
  for($i=1; $i < $xSteps+1; $i++) {
    imageline($im, $x0+$xStep*$i, $y0, $x0+$xStep*$i, $maxY-1, $gray);
    $str = Date("H:i", time() - $period + (int) ($i * round($xStep/$scaleX, 1)));
    imagestring($im, 1, (($x0+$xStep*$i) - 6), $maxY+2, $str, $black);
  }
  imagestring($im, 1, $x0 - 6, $maxY+2, $str, $black);

  $ySteps = ($maxY-$y0) / $yStep-1;
  for($i=1; $i < $ySteps+1; $i++) {
    imageline($im, $x0+1, (int) $maxY-$yStep*$i, $maxX, (int) $maxY-$yStep*$i, $gray);
    if($server['s']['playersmax'] > 32 or $i % (int)(1 + $server['s']['playersmax']/10) == 0) {
      imagestring($im, 1, 3, ($maxY-$yStep*$i)-3, round($i * $yStep/$scaleY, 0), $black);
    }
  }
  imageline($im, $x0 - 15, $maxY, $x0, $maxY, $black);
  imagestring($im, 1, 3, $maxY - 3, 0, $black);
  imageline($im, $x0 - 8, $y0, $x0, $y0, $black);
  // imagestring($im, 1, 3, $y0 - 3, $server['s']['playersmax'], $black);

  // DRAW GRAPH

 for($i=1; $i < count($x); $i++) {
    if($s[$i-1]) {
      imageline($im, (int) ($x0+$x[$i-1]*$scaleX), (int) ($maxY-$y[$i-1]*$scaleY), (int) ($x0+$x[$i]*$scaleX), (int) ($maxY-$y[$i]*$scaleY), $green);
    }
    else {
      imagefilledellipse($im, (int) ($x0+$x[$i]*$scaleX), (int) ($maxY-$y[$i]*$scaleY), 4, 4, $red);
    }
  }

  $game_id = makeImage($misc['icon_game'], 16, 16);                          // create game icon
  imagecopy($im, $game_id, 7, 2, 0, 0, 16, 16);                             // place game icon

  $font = dirname(__FILE__) . '/lgsl_files/other/cousine.ttf';
	imagettftext($im, 7, 0, 28, 8, $black, $font, $lgsl_config['text']['nam'] . ": " . trim ($server['s']['name']));
	imagettftext($im, 6, 0, 27, 17, $black, $font, $lgsl_config['text']['adr'] . ": " . str_replace('https://', '', $misc['connect_filtered']));
	imagettftext($im, 6, 0, $w - 52, 17, $black, $font, date($lgsl_config['text']['tzn']));

  imagepng($im);
  imagedestroy($im);
?>