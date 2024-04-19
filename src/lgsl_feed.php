<?php
  namespace tltneon\LGSL;

  /*----------------------------------------------------------------------------------------------------------\
  |                                                                                                            |
  |                      [ LIVE GAME SERVER LIST ] [ RICHARD PERRY FROM GREYCUBE.COM ]                       |
  |                                                                                                            |
  |    Released under the terms and conditions of the GNU General Public License Version 3 (http://gnu.org)    |
  |                                                                                                            |
  \-----------------------------------------------------------------------------------------------------------*/

  require "lgsl_class.php";
  $type    = $_GET['type'] ?? "";
  $ip      = $_GET['ip'] ?? "";
  $request = $_GET['request'] ?? "sc";
  $c_port  = intval($_GET['c_port'] ?? 0);
  $q_port  = intval($_GET['q_port'] ?? 0);
  $s_port  = intval($_GET['s_port'] ?? 0);
  $xml     = intval($_GET['xml'] ?? 0);
  $format  = intval($_GET['format'] ?? 0);

// VALIDATE REQUEST

  if (!$type && !$ip && $lgsl_config['api']) {
    $servers = Database::get_servers_group(['request' => $request]);
    $result = [];
    foreach ($servers as $server) {
      $result[] = [
        'name' => $server->get_name(),
        'ip' => $server->get_ip(),
        'port' => $server->get_c_port(),
        'game' => $server->get_game(),
        'map' => $server->get_map(),
        'players' => $server->get_players_count('active'),
        'maxplayers' => $server->get_players_count('max'),
        'online' => $server->isOnline()
      ];
    }
    exit(json_encode($result, true));
  }

  if (!$type || !$ip || (!Protocol::lgslProtocolWithoutPort($type) && (!$c_port || !$q_port)) || !$request) {
    exit("LGSL FEED PROBLEM: INCOMPLETE REQUEST");
  }

  if ($q_port > 65535 || $q_port < 0) {
    exit("LGSL FEED PROBLEM: INVALID QUERY PORT: '{$q_port}'");
  }

  if (preg_match("/[^0-9a-z\.\-\[\]\:]/i", $ip)) {
    exit("LGSL FEED PROBLEM: INVALID IP OR HOSTNAME: '{$ip}'");
  }

  if (preg_match("/[^a-z]/", $request)) {
    exit("LGSL FEED PROBLEM: INVALID REQUEST: '{$request}'");
  }

  if ($type == "test") {
    exit("LGSL FEED PROBLEM: TYPE 'test' IS NOT ALLOWED");
  }

  $lgsl_protocol_list = Protocol::lgsl_protocol_list();

  if (!isset($lgsl_protocol_list[$type])) {
    exit("LGSL FEED PROBLEM: ".($type ? "UNKNOWN TYPE '{$type}'" : "MISSING TYPE")." FOR {$ip} : {$c_port} : {$q_port} : {$s_port}");
  }

//------------------------------------------------------------------------------------------------------------+
// FILTER HOSTNAME AND IP FORMATS THAT PHP ACCEPTS BUT ARE NOT WANTED

  if     (preg_match("/(\[[0-9a-z\:]+\])/iU", $ip, $match)) { $ip = $match[1]; }
  elseif (preg_match("/([0-9a-z\.\-]+)/i", $ip, $match))    { $ip = $match[1]; }

//------------------------------------------------------------------------------------------------------------+
// CHECK PUBLIC FEED SETTING AND EITHER ADD [a] REQUEST OR ENSURE [a] IS REMOVED

  $request = $lgsl_config['public_feed'] ? "{$request}a" : str_replace("a", "", $request);

//------------------------------------------------------------------------------------------------------------+
// QUERY SERVER

  $server = new Server(["type" => $type, "ip" => $ip, "c_port" => $c_port, "q_port" => $q_port, "s_port" => $s_port]);
  $server->lgsl_cached_query($request);

//------------------------------------------------------------------------------------------------------------+
// ADD THE FEED PROVIDER

  $server->set_extra_value('_feed_', "http://{$_SERVER['HTTP_HOST']}");
  $server->set_extra_value('_lgsl_', LGSL::VERSION);

//------------------------------------------------------------------------------------------------------------+
// FEED USAGE LOGGING - 'logs' FOLDER MUST BE MANUALLY CREATED AND SET AS WRITABLE

  if (is_dir("logs") && is_writable("logs")) {
    $file_path = "logs/log_feed_{$_SERVER['REMOTE_ADDR']}.html";
    if (filesize($file_path) > 1234567) { unlink($file_path); }
    $file_handle = fopen($file_path, "a");

    $file_string  = "
    [ ".date("Y/m/d H:i:s")." ] {$type}:{$ip}:{$c_port}:{$q_port}:{$s_port}:{$request}
    [ <a href='http://{$_SERVER['REMOTE_ADDR']}'>{$_SERVER['REMOTE_ADDR']}</a> ]
    [ <a href='{$_SERVER['HTTP_REFERER']}'>{$_SERVER['HTTP_REFERER']}</a> ]
    ".($version ? " [ {$version} ] " : "")."
    ".($xml     ? " [ XML ]        " : "")."
    <br>";

    fwrite($file_handle, $file_string);
    fclose($file_handle);
  }

//------------------------------------------------------------------------------------------------------------+
// SERIALIZED OUTPUT

  $server = $server->to_array();
  if (!$xml) {
    if (($format == 3 || $format == 4) && function_exists("json_encode")) {
      if ($format == 4 && function_exists("gzcompress")) { exit("_F4_".base64_encode(gzcompress(json_encode($server)))."_F4_"); }
      else                                               { exit("_F3_".base64_encode(           json_encode($server)). "_F3_"); }
    } else {
      if ($format == 2 && function_exists("gzcompress")) { exit("_F2_".base64_encode(gzcompress(serialize($server)))."_F2_"); }
      else                                               { exit("_F1_".base64_encode(           serialize($server)). "_F1_"); }
    }
  }

//------------------------------------------------------------------------------------------------------------+
// XML OUTPUT

  header("content-type: text/xml");
  echo "<?xml version='1.0' encoding='UTF-8' ?>\r\n<server>\r\n";

  foreach ($server as $a => $b) {
    echo "<".$a.">";

    foreach ($b as $c => $d) {
      if (is_array($d)) {
        echo "<player>\r\n";

        foreach ($d as $e => $f) {
          echo "<".$e, TRUE.">".$f."</".$e.">\r\n";
        }

        echo "</player>\r\n";
      } else {
        echo "<".$c.">".$d."</".$c.">\r\n";
      }
    }

    echo "</".$a.">\r\n";
  }

  echo "</server>\r\n";
