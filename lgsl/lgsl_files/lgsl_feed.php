<?php

 /*----------------------------------------------------------------------------------------------------------\
 |                                                                                                            |
 |                      [ LIVE GAME SERVER LIST ] [ © RICHARD PERRY FROM GREYCUBE.COM ]                       |
 |                                                                                                            |
 |    Released under the terms and conditions of the GNU General Public License Version 3 (http://gnu.org)    |
 |                                                                                                            |
 \-----------------------------------------------------------------------------------------------------------*/

//------------------------------------------------------------------------------------------------------------+

  require "lgsl_class.php";

//------------------------------------------------------------------------------------------------------------+

  $type    = isset($_GET['type'])    ? lgsl_string_html($_GET['type'])    : "";
  $ip      = isset($_GET['ip'])      ? lgsl_string_html($_GET['ip'])      : "";
  $c_port  = isset($_GET['c_port'])  ? intval($_GET['c_port'])            : 0;
  $q_port  = isset($_GET['q_port'])  ? intval($_GET['q_port'])            : 0;
  $s_port  = isset($_GET['s_port'])  ? intval($_GET['s_port'])            : 0;
  $request = isset($_GET['request']) ? lgsl_string_html($_GET['request']) : "";
  $version = isset($_GET['version']) ? lgsl_string_html($_GET['version']) : "";
  $xml     = isset($_GET['xml'])     ? intval($_GET['xml'])               : 0;
  $format  = isset($_GET['format'])  ? intval($_GET['format'])            : 0;

//------------------------------------------------------------------------------------------------------------+
// VALIDATE REQUEST

  if (!$type || !$ip || !$c_port || !$q_port  || !$request)
  {
    exit("LGSL FEED PROBLEM: INCOMPLETE REQUEST");
  }

  if ($q_port > 99999 || $q_port < 1024)
  {
    exit("LGSL FEED PROBLEM: INVALID QUERY PORT: '{$q_port}'");
  }

  if (preg_match("/[^0-9a-z\.\-\[\]\:]/i", $ip))
  {
    exit("LGSL FEED PROBLEM: INVALID IP OR HOSTNAME: '{$ip}'");
  }

  if (preg_match("/[^a-z]/", $request))
  {
    exit("LGSL FEED PROBLEM: INVALID REQUEST: '{$request}'");
  }

  if ($type == "test")
  {
    exit("LGSL FEED PROBLEM: TYPE 'test' IS NOT ALLOWED");
  }

  $lgsl_protocol_list = lgsl_protocol_list();

  if (!isset($lgsl_protocol_list[$type]))
  {
    exit("LGSL FEED PROBLEM: ".($type ? "UNKNOWN TYPE '{$type}'" : "MISSING TYPE")." FOR {$ip} : {$c_port} : {$q_port} : {$s_port}");
  }

//------------------------------------------------------------------------------------------------------------+
// FILTER HOSTNAME AND IP FORMATS THAT PHP ACCEPTS BUT ARE NOT WANTED

  if     (preg_match("/(\[[0-9a-z\:]+\])/iU", $ip, $match)) { $ip = $match[1]; }
  elseif (preg_match("/([0-9a-z\.\-]+)/i", $ip, $match))    { $ip = $match[1]; }

//------------------------------------------------------------------------------------------------------------+
// CHECK PUBLIC FEED SETTING AND EITHER ADD [a] REQUEST OR ENSURE [a] IS REMOVED

  $request = $lgsl_config['public_feed'] ? $request."a" : str_replace("a", "", $request);

//------------------------------------------------------------------------------------------------------------+
// QUERY SERVER

  $server = lgsl_query_cached($type, $ip, $c_port, $q_port, $s_port, $request);

//------------------------------------------------------------------------------------------------------------+
// ADD THE FEED PROVIDER

  if ($server['e']) { $server['e']['_feed_'] = "http://{$_SERVER['HTTP_HOST']}"; }

//------------------------------------------------------------------------------------------------------------+
// FEED USAGE LOGGING - 'logs' FOLDER MUST BE MANUALLY CREATED AND SET AS WRITABLE

  if (is_dir("logs") && is_writable("logs"))
  {
//  $file_path = "logs/log_feed.html";
    $file_path = "logs/log_feed_{$_SERVER['REMOTE_ADDR']}.html";

    if (filesize($file_path) > 1234567) { unlink($file_path); }

    $file_handle = fopen($file_path, "a");

    $file_string  = "
    [ ".date("Y/m/d H:i:s")." ] {$type}:{$ip}:{$c_port}:{$q_port}:{$s_port}:{$request}
    [ <a href='http://".lgsl_string_html($_SERVER['REMOTE_ADDR']) ."'>".lgsl_string_html($_SERVER['REMOTE_ADDR']) ."</a> ]
    [ <a href='"       .lgsl_string_html($_SERVER['HTTP_REFERER'])."'>".lgsl_string_html($_SERVER['HTTP_REFERER'])."</a> ]
    ".($version ? " [ {$version} ] " : "")."
    ".($xml     ? " [ XML ]        " : "")."
    <br />";

    fwrite($file_handle, $file_string);

    fclose($file_handle);
  }

//------------------------------------------------------------------------------------------------------------+
// SERIALIZED OUTPUT

  if (!$xml)
  {
    if ($format == 0) { exit("_SLGSLF_".serialize($server)."_SLGSLF_"); } // LEGACY SYSTEM ( 5.6 AND OLDER )

    if (($format == 3 || $format == 4) && function_exists("json_encode"))
    {
      if ($format == 4 && function_exists("gzcompress")) { exit("_F4_".base64_encode(gzcompress(json_encode($server)))."_F4_"); }
      else                                               { exit("_F3_".base64_encode(           json_encode($server)). "_F3_"); }
    }
    else
    {
      if ($format == 2 && function_exists("gzcompress")) { exit("_F2_".base64_encode(gzcompress(serialize($server)))."_F2_"); }
      else                                               { exit("_F1_".base64_encode(           serialize($server)). "_F1_"); }
    }
  }

//------------------------------------------------------------------------------------------------------------+
// XML OUTPUT

  header("content-type: text/xml");

  echo "<?xml version='1.0' encoding='UTF-8' ?>\r\n<server>\r\n";

  foreach ($server as $a => $b)
  {
    echo "<".lgsl_string_html($a, TRUE).">";

    foreach ($b as $c => $d)
    {
      if (is_array($d))
      {
        echo "<player>\r\n";

        foreach ($d as $e => $f)
        {
          echo "<".lgsl_string_html($e, TRUE).">".lgsl_string_html($f, TRUE)."</".lgsl_string_html($e, TRUE).">\r\n";
        }

        echo "</player>\r\n";
      }
      else
      {
        echo "<".lgsl_string_html($c, TRUE).">".lgsl_string_html($d, TRUE)."</".lgsl_string_html($c, TRUE).">\r\n";
      }
    }

    echo "</".lgsl_string_html($a, TRUE).">\r\n";
  }

  echo "</server>\r\n";

//------------------------------------------------------------------------------------------------------------+
