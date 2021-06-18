<?php
  header("Content-Type: image/png");
  require "lgsl_files/lgsl_class.php";
  $lookup = lgsl_lookup_id($_GET['s']);
  $server = lgsl_query_cached($lookup['type'], $lookup['ip'], $lookup['c_port'], $lookup['q_port'], $lookup['s_port'], "s");
  $server['s']['playersmax'] = $server['s']['playersmax'] > 0 ? $server['s']['playersmax'] : 1;

  // SETTINGS

  $w = 400;
  $h = 150;
  $im = @imagecreate($w, $h);
  $white = imagecolorallocate($im, 255, 255, 255);
  $gray = imagecolorallocate($im, 225, 225, 225);
  $black = imagecolorallocate($im, 0, 0, 0);
  $green = imagecolorallocate($im, 20, 255, 0);
  $red = imagecolorallocate($im, 255, 0, 0);
  $x0 = 30;
  $y0 = 20;
  $xStep = 30;
  $yStep = 30;
  $period = 60 * 60 * 24; // 1 day

  //

  $s = array();
  $x = array();
  $y = array();
  foreach($server['s']['history'] as $key){
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
  $ySteps = ($maxY-$y0) / $yStep-1;
  for($i=1; $i < $xSteps+1; $i++){
     imageline($im, $x0+$xStep*$i, $y0, $x0+$xStep*$i, $maxY-1, $gray);
     $str = Date("H:i", time() - $period + (int)($i * round($xStep/$scaleX, 1)));
     imagestring($im, 1, (($x0+$xStep*$i) - 6), $maxY+2, $str, $black);
  }

  for($i=1; $i < $ySteps+1; $i++){
    imageline($im, $x0+1, $maxY-$yStep*$i, $maxX, $maxY-$yStep*$i, $gray);
    imagestring($im, 1, 3, ($maxY-$yStep*$i)-3, (int)($i * round($yStep/$scaleY, 1) ), $black);
  }

  // DRAW GRAPH

 for($i=1; $i < count($x); $i++) {
    if($s[$i-1]) {
      imageline($im, (int) ($x0+$x[$i-1]*$scaleX), (int) ($maxY-$y[$i-1]*$scaleY), (int) ($x0+$x[$i]*$scaleX), (int) ($maxY-$y[$i]*$scaleY), $green);
    }
    else {
      imagefilledellipse($im, (int) ($x0+$x[$i]*$scaleX), (int) ($maxY-$y[$i]*$scaleY), 4, 4, $red);
    }
  }

  imagestring($im, 1, 10, 0, "Server: " . trim ($server['s']['name']), $black);
  imagestring($im, 1, 9, 10, "IP: " . ($lookup['type'] == 'discord' ? $lookup['ip'] : $lookup['ip'].':'.$lookup['c_port']), $black);
  imagestring($im, 1, $w - 80, 10, "Date: " . Date("d.m.y", time()), $black);

  imagepng($im);
  imagedestroy($im);
?>