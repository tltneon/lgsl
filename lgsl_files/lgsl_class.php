<?php

 /*----------------------------------------------------------------------------------------------------------\
 |                                                                                                            |
 |                      [ LIVE GAME SERVER LIST ] [ © RICHARD PERRY FROM GREYCUBE.COM ]                       |
 |                                                                                                            |
 |    Released under the terms and conditions of the GNU General Public License Version 3 (http://gnu.org)    |
 |                                                                                                            |
 \-----------------------------------------------------------------------------------------------------------*/

//------------------------------------------------------------------------------------------------------------+
//------------------------------------------------------------------------------------------------------------+

  if (!function_exists('lgsl_url_path')) { // START OF DOUBLE LOAD PROTECTION

//------------------------------------------------------------------------------------------------------------+
//------------------------------------------------------------------------------------------------------------+

  function lgsl_link($s = "")
  {
    global $lgsl_config, $lgsl_url_path;

    $index = $lgsl_config['direct_index'] ? "index.php" : "";

    switch($lgsl_config['cms'])
    {
      case "e107":
        $link = $s ? e_PLUGIN_ABS."lgsl/{$index}?s={$s}" : e_PLUGIN_ABS."lgsl/{$index}";
      break;

      case "joomla":
        $link = $s ? JRoute::_("index.php?option=com_lgsl&s={$s}") : JRoute::_("index.php?option=com_lgsl");
      break;

      case "drupal":
        $link = $s ? url("LGSL/{$s}") : url("LGSL");
      break;

      case "phpnuke":
        $link = $s ? "modules.php?name=LGSL&s={$s}" : "modules.php?name=LGSL";
      break;

      default: // "sa"
        $link = $s ? $lgsl_url_path."../{$index}?s={$s}" : $lgsl_url_path."../{$index}";
      break;
    }

    return $link;
  }

//------------------------------------------------------------------------------------------------------------+

  function lgsl_database()
  {
    global $lgsl_database, $lgsl_config, $lgsl_file_path;

    if (!isset($lgsl_config['db']['prefix']))
    {
      $lgsl_config['db']['prefix'] = "";
    }

    if (!$lgsl_config['db']['pass'])
    {
      switch($lgsl_config['cms'])
      {
        case "e107":
          @include "{$lgsl_file_path}../../../e107_config.php";
          $lgsl_config['db']['server'] = $mySQLserver;
          $lgsl_config['db']['user']   = $mySQLuser;
          $lgsl_config['db']['pass']   = $mySQLpassword;
          $lgsl_config['db']['db']     = $mySQLdefaultdb;
          $lgsl_config['db']['prefix'] = $mySQLprefix;
        break;

        case "joomla":
          @include_once "{$lgsl_file_path}../../../configuration.php";
          $joomla_config = new JConfig();
          $lgsl_config['db']['server'] = $joomla_config->host;
          $lgsl_config['db']['user']   = $joomla_config->user;
          $lgsl_config['db']['pass']   = $joomla_config->password;
          $lgsl_config['db']['db']     = $joomla_config->db;
          $lgsl_config['db']['prefix'] = $joomla_config->dbprefix;
        break;

        case "drupal":
          global $db_url, $db_prefix;
          if (empty($db_url)) { @include "{$lgsl_file_path}../../../sites/default/settings.php"; }
          $drupal_config = is_array($db_url) ? parse_url($db_url['default']) : parse_url($db_url);
          $lgsl_config['db']['server'] = $drupal_config['host'];
          $lgsl_config['db']['user']   = $drupal_config['user'];
          $lgsl_config['db']['pass']   = isset($drupal_config['pass']) ? $drupal_config['pass'] : "";
          $lgsl_config['db']['db']     = substr($drupal_config['path'], 1);
          $lgsl_config['db']['prefix'] = isset($db_prefix['default']) ? $db_prefix['default'] : "";
        break;

        case "phpnuke":
          @include "{$lgsl_file_path}../../../config.php";
          @include "{$lgsl_file_path}../../../conf.inc.php";
          @include "{$lgsl_file_path}../../../includes/config.php";
          $lgsl_config['db']['server'] = $dbhost;
          $lgsl_config['db']['user']   = $dbuname;
          $lgsl_config['db']['pass']   = $dbpass;
          $lgsl_config['db']['db']     = $dbname;
          $lgsl_config['db']['prefix'] = $prefix."_";
        break;
      }
    }

    $lgsl_database  = mysqli_connect($lgsl_config['db']['server'], $lgsl_config['db']['user'], $lgsl_config['db']['pass']) or die(mysqli_error($lgsl_database));
    $lgsl_select_db = mysqli_select_db($lgsl_database, $lgsl_config['db']['db']) or die(mysqli_error($lgsl_database));
  }

//------------------------------------------------------------------------------------------------------------+

  function lgsl_query_cached($type, $ip, $c_port, $q_port, $s_port, $request, $id = NULL)
  {
    global $lgsl_config, $lgsl_database;

    lgsl_database();

    // LOOKUP SERVER

    if ($id != NULL)
    {
      $id           = intval($id);
      $mysqli_query  = "SELECT * FROM `{$lgsl_config['db']['prefix']}{$lgsl_config['db']['table']}` WHERE `id`='{$id}' LIMIT 1";
      $mysqli_result = mysqli_query($lgsl_database, $mysqli_query) or die(mysqli_error($lgsl_database));
      $mysqli_row    = mysqli_fetch_array($mysqli_result, MYSQLI_ASSOC);
      if (!$mysqli_row) { return FALSE; }
      list($type, $ip, $c_port, $q_port, $s_port) = array($mysqli_row['type'], $mysqli_row['ip'], $mysqli_row['c_port'], $mysqli_row['q_port'], $mysqli_row['s_port']);
    }
    else
    {
      list($type, $ip, $c_port, $q_port, $s_port) = array(mysqli_real_escape_string($lgsl_database, $type), mysqli_real_escape_string($lgsl_database, $ip), intval($c_port), intval($q_port), intval($s_port));

      if (!$type || !$ip || !$c_port || !$q_port) { exit("LGSL PROBLEM: INVALID SERVER '{$type} : {$ip} : {$c_port} : {$q_port} : {$s_port}'"); }
      $mysqli_query  = "SELECT * FROM `{$lgsl_config['db']['prefix']}{$lgsl_config['db']['table']}` WHERE `type`='{$type}' AND `ip`='{$ip}' AND `q_port`='{$q_port}' LIMIT 1";
      $mysqli_result = mysqli_query($lgsl_database, $mysqli_query) or die(mysqli_error($lgsl_database));
      $mysqli_row    = mysqli_fetch_array($mysqli_result, MYSQLI_ASSOC);

      if (!$mysqli_row)
      {
        if (strpos($request, "a") === FALSE) { exit("LGSL PROBLEM: SERVER NOT IN DATABASE '{$type} : {$ip} : {$c_port} : {$q_port} : {$s_port}'"); }
        $mysqli_query  = "INSERT INTO `{$lgsl_config['db']['prefix']}{$lgsl_config['db']['table']}` (`type`,`ip`,`c_port`,`q_port`,`s_port`,`cache`,`cache_time`) VALUES ('{$type}','{$ip}','{$c_port}','{$q_port}','{$s_port}','','')";
        $mysqli_result = mysqli_query($lgsl_database, $mysqli_query) or die(mysqli_error($lgsl_database));
        $mysqli_row    = array("id"=>mysqli_insert_id(), "zone"=>"0", "comment"=>"");
      }
    }

    // UNPACK CACHE AND CACHE TIMES

    $cache      = empty($mysqli_row['cache'])      ? array()      : unserialize(base64_decode($mysqli_row['cache']));
    $cache_time = empty($mysqli_row['cache_time']) ? array(0,0,0) : explode("_", $mysqli_row['cache_time']);

    // SET THE SERVER AS OFFLINE AND PENDING WHEN THERE IS NO CACHE

    if (empty($cache['b']) || !is_array($cache))
    {
      $cache      = array();
      $cache['b'] = array();
      $cache['b']['status']  = 0;
      $cache['b']['pending'] = 1;
    }

    // CONVERT HOSTNAME TO IP WHEN NEEDED

    if ($lgsl_config['host_to_ip'])
    {
      $ip = gethostbyname($ip);
    }

    // UPDATE CACHE WITH FIXED VALUES

    $cache['b']['type']    = $type;
    $cache['b']['ip']      = $ip;
    $cache['b']['c_port']  = $c_port;
    $cache['b']['q_port']  = $q_port;
    $cache['b']['s_port']  = $s_port;
    $cache['o']['request'] = $request;
    $cache['o']['id']      = $mysqli_row['id'];
    $cache['o']['zone']    = $mysqli_row['zone'];
    $cache['o']['comment'] = $mysqli_row['comment'];

    // UPDATE CACHE WITH LOCATION

    if (empty($cache['o']['location']))
    {
      $cache['o']['location'] = $lgsl_config['locations'] ? lgsl_query_location($ip) : "";
    }

    // UPDATE CACHE WITH DEFAULT OFFLINE VALUES

    if (!isset($cache['s']))
    {
      $cache['s']               = array();
      $cache['s']['game']       = $type;
      $cache['s']['name']       = $lgsl_config['text']['nnm'];
      $cache['s']['map']        = $lgsl_config['text']['nmp'];
      $cache['s']['players']    = 0;
      $cache['s']['playersmax'] = 0;
      $cache['s']['password']   = 0;
    }

    if (!isset($cache['e'])) { $cache['e'] = array(); }
    if (!isset($cache['p'])) { $cache['p'] = array(); }

    // CHECK AND GET THE NEEDED DATA

    $needed = "";

    if (strpos($request, "c") === FALSE) // CACHE ONLY REQUEST
    {
      if (strpos($request, "s") !== FALSE && time() > ($cache_time[0]+$lgsl_config['cache_time'])) { $needed .= "s"; }
      if (strpos($request, "e") !== FALSE && time() > ($cache_time[1]+$lgsl_config['cache_time'])) { $needed .= "e"; }
      if (strpos($request, "p") !== FALSE && time() > ($cache_time[2]+$lgsl_config['cache_time'])) { $needed .= "p"; }
    }

    if ($needed)
    {
      // UPDATE CACHE TIMES BEFORE QUERY - PREVENTS OTHER INSTANCES FROM QUERY FLOODING THE SAME SERVER

      $packed_times = time() + $lgsl_config['cache_time'] + 10;
      $packed_times = "{$packed_times}_{$packed_times}_{$packed_times}";
      $mysqli_query  = "UPDATE `{$lgsl_config['db']['prefix']}{$lgsl_config['db']['table']}` SET `cache_time`='{$packed_times}' WHERE `id`='{$mysqli_row['id']}' LIMIT 1";
      $mysqli_result = mysqli_query($lgsl_database, $mysqli_query) or die(mysqli_error($lgsl_database));

      // GET WHAT IS NEEDED

      $live = lgsl_query_live($type, $ip, $c_port, $q_port, $s_port, $needed);

      if (!$live['b']['status'] && $lgsl_config['retry_offline'] && !$lgsl_config['feed']['method'])
      {
        $live = lgsl_query_live($type, $ip, $c_port, $q_port, $s_port, $needed);
      }

      // CHECK AND CONVERT TO UTF-8 WHERE NEEDED

      $live = lgsl_charset_convert($live, lgsl_charset_detect($live));

      // IF SERVER IS OFFLINE PRESERVE SOME OF THE CACHE AND CLEAR THE REST

      if (!$live['b']['status'])
      {
        $live['s']['game']       = $cache['s']['game'];
        $live['s']['name']       = $cache['s']['name'];
        $live['s']['map']        = $cache['s']['map'];
        $live['s']['password']   = $cache['s']['password'];
        $live['s']['players']    = 0;
        $live['s']['playersmax'] = $cache['s']['playersmax'];
        $live['e']               = array();
        $live['p']               = array();
      }

      // MERGE LIVE INTO CACHE

      if (isset($live['b'])) { $cache['b'] = $live['b']; $cache['b']['pending'] = 0; }
      if (isset($live['s'])) { $cache['s'] = $live['s']; $cache_time[0] = time(); }
      if (isset($live['e'])) { $cache['e'] = $live['e']; $cache_time[1] = time(); }
      if (isset($live['p'])) { $cache['p'] = $live['p']; $cache_time[2] = time(); }

      // UPDATE CACHE

      $packed_cache = mysqli_real_escape_string($lgsl_database, base64_encode(serialize($cache)));
      $packed_times = mysqli_real_escape_string($lgsl_database, implode("_", $cache_time));
      $mysqli_query  = "UPDATE `{$lgsl_config['db']['prefix']}{$lgsl_config['db']['table']}` SET `status`='{$cache['b']['status']}',`cache`='{$packed_cache}',`cache_time`='{$packed_times}' WHERE `id`='{$mysqli_row['id']}' LIMIT 1";
      $mysqli_result = mysqli_query($lgsl_database, $mysqli_query) or die(mysqli_error($lgsl_database));
    }

    // RETURN ONLY THE REQUESTED

    if (strpos($request, "s") === FALSE) { unset($cache['s']); }
    if (strpos($request, "e") === FALSE) { unset($cache['e']); }
    if (strpos($request, "p") === FALSE) { unset($cache['p']); }

    return $cache;
  }

//------------------------------------------------------------------------------------------------------------+
//EXAMPLE USAGE: lgsl_query_group( array("request"=>"sep", "hide_offline"=>0, "random"=>0, "type"=>"source", "game"=>"cstrike") )

  function lgsl_query_group($options = array())
  {
    if (!is_array($options)) { exit("LGSL PROBLEM: lgsl_query_group OPTIONS MUST BE ARRAY"); }

    global $lgsl_config, $lgsl_database;

    lgsl_database();

    $request      = isset($options['request'])      ? $options['request']              : "s";
    $zone         = isset($options['zone'])         ? intval($options['zone'])         : 0;
    $hide_offline = isset($options['hide_offline']) ? intval($options['hide_offline']) : intval($lgsl_config['hide_offline'][$zone]);
    $random       = isset($options['random'])       ? intval($options['random'])       : intval($lgsl_config['random'][$zone]);
    $type         = empty($options['type'])         ? ""                               : preg_replace("/[^a-z0-9_]/", "_", strtolower($options['type']));
    $game         = empty($options['game'])         ? ""                               : preg_replace("/[^a-z0-9_]/", "_", strtolower($options['game']));
    $mysqli_order  = empty($random)                  ? "`cache_time` ASC"               : "rand()";
    $server_limit = empty($random)                  ? 0                                : $random;

                       $mysqli_where   = array("`disabled`=0");
    if ($zone != 0)  { $mysqli_where[] = "FIND_IN_SET('{$zone}',`zone`)"; }
    if ($type != "") { $mysqli_where[] = "`type`='{$type}'"; }

    $mysqli_query  = "SELECT `id` FROM `{$lgsl_config['db']['prefix']}{$lgsl_config['db']['table']}` WHERE ".implode(" AND ", $mysqli_where)." ORDER BY {$mysqli_order}";
    $mysqli_result = mysqli_query($lgsl_database, $mysqli_query) or die(mysqli_error($lgsl_database));
    $server_list  = array();

    while ($mysqli_row = mysqli_fetch_array($mysqli_result, MYSQLI_ASSOC))
    {
      if (strpos($request, "c") === FALSE && lgsl_timer("check")) { $request .= "c"; }

      $server = lgsl_query_cached("", "", "", "", "", $request, $mysqli_row['id']);

      if ($hide_offline && empty($server['b']['status'])) { continue; }
      if ($game && $game != preg_replace("/[^a-z0-9_]/", "_", strtolower($server['s']['game']))) { continue; }

      $server_list[] = $server;

      if ($server_limit && count($server_list) >= $server_limit) { break; }
    }

    return $server_list;
  }

//------------------------------------------------------------------------------------------------------------+

  function lgsl_group_totals($server_list = FALSE)
  {
    if (!is_array($server_list)) { $server_list = lgsl_query_group( array( "request"=>"sc" ) ); }

    $total = array("players"=>0, "playersmax"=>0, "servers"=>0, "servers_online"=>0, "servers_offline"=>0);

    foreach ($server_list as $server)
    {
      $total['players']    += $server['s']['players'];
      $total['playersmax'] += $server['s']['playersmax'];

                                    $total['servers']         ++;
      if ($server['b']['status']) { $total['servers_online']  ++; }
      else                        { $total['servers_offline'] ++; }
    }

    return $total;
  }

//------------------------------------------------------------------------------------------------------------+

  function lgsl_query_cached_all($request) // LEGACY - DO NOT USE
  {
    return lgsl_query_group( array( "request"=>$request ) );
  }

//------------------------------------------------------------------------------------------------------------+

  function lgsl_query_cached_zone($request, $zone) // LEGACY - DO NOT USE
  {
    return lgsl_query_group( array( "request"=>$request, "zone"=>$zone ) );
  }

//------------------------------------------------------------------------------------------------------------+

  function lgsl_cached_totals() // LEGACY - DO NOT USE
  {
    return lgsl_group_totals();
  }

//------------------------------------------------------------------------------------------------------------+

  function lgsl_lookup_id($id) // LEGACY - DO NOT USE
  {
    global $lgsl_config, $lgsl_database;

    lgsl_database();

    $id           = mysqli_real_escape_string($lgsl_database, intval($id));
    $mysqli_query  = "SELECT `type`,`ip`,`c_port`,`q_port`,`s_port` FROM `{$lgsl_config['db']['prefix']}{$lgsl_config['db']['table']}` WHERE `id`='{$id}' LIMIT 1";
    $mysqli_result = mysqli_query($lgsl_database, $mysqli_query) or die(mysqli_error($lgsl_database));
    $mysqli_row    = mysqli_fetch_array($mysqli_result, MYSQLI_ASSOC);

    return $mysqli_row;
  }
	
  function lgsl_lookup_server($ip, $port) // LEGACY - DO NOT USE
  {
    global $lgsl_config, $lgsl_database;

    lgsl_database();

    $ip           = mysqli_real_escape_string($lgsl_database, $ip);
    $port           = mysqli_real_escape_string($lgsl_database, intval($port));
    $mysqli_query  = "SELECT `id` FROM `{$lgsl_config['db']['prefix']}{$lgsl_config['db']['table']}` WHERE `ip`='{$ip}' AND `c_port`='{$port}' LIMIT 1";
    $mysqli_result = mysqli_query($lgsl_database, $mysqli_query) or die(mysqli_error($lgsl_database));
    $mysqli_row    = mysqli_fetch_array($mysqli_result, MYSQLI_ASSOC);

    return $mysqli_row['id'];
  }

//------------------------------------------------------------------------------------------------------------+

  function lgsl_timer($action)
  {
    global $lgsl_config;
    global $lgsl_timer;

    if (!$lgsl_timer)
    {
      $microtime  = microtime();
      $microtime  = explode(' ', $microtime);
      $microtime  = $microtime[1] + $microtime[0];
      $lgsl_timer = $microtime - 0.01;
    }

    $time_limit = intval($lgsl_config['live_time']);
    $time_php   = ini_get("max_execution_time");

    if ($time_limit > $time_php)
    {
      @set_time_limit($time_limit + 5);

      $time_php = ini_get("max_execution_time");

      if ($time_limit > $time_php)
      {
        $time_limit = $time_php - 5;
      }
    }

    if ($action == "limit")
    {
      return $time_limit;
    }

    $microtime  = microtime();
    $microtime  = explode(' ', $microtime);
    $microtime  = $microtime[1] + $microtime[0];
    $time_taken = $microtime - $lgsl_timer;

    if ($action == "check")
    {
      return ($time_taken > $time_limit) ? TRUE : FALSE;
    }
    else
    {
      return round($time_taken, 2);
    }
  }

//------------------------------------------------------------------------------------------------------------+

  function lgsl_server_misc($server)
  {
    global $lgsl_url_path;

    $misc['icon_details']       = $lgsl_url_path."other/icon_details.gif";
    $misc['icon_game']          = lgsl_icon_game($server['b']['type'], $server['s']['game']);
    $misc['icon_status']        = lgsl_icon_status($server['b']['status'], $server['s']['password'], $server['b']['pending']);
    $misc['icon_location']      = lgsl_icon_location($server['o']['location']);
    $misc['image_map']          = lgsl_image_map($server['b']['status'], $server['b']['type'], $server['s']['game'], $server['s']['map'], TRUE, $server['o']['id']);
    $misc['image_map_password'] = lgsl_image_map_password($server['b']['status'], $server['s']['password']);
    $misc['text_status']        = lgsl_text_status($server['b']['status'], $server['s']['password'], $server['b']['pending']);
    $misc['text_type_game']     = lgsl_text_type_game($server['b']['type'], $server['s']['game']);
    $misc['text_location']      = lgsl_text_location($server['o']['location']);
    $misc['name_filtered']      = lgsl_string_html($server['s']['name'], FALSE, 20); // LEGACY
    $misc['software_link']      = lgsl_software_link($server['b']['type'], $server['b']['ip'], $server['b']['c_port'], $server['b']['q_port'], $server['b']['s_port']);
    $misc['location_link']      = lgsl_location_link($server['o']['location']);

    return $misc;
  }

//------------------------------------------------------------------------------------------------------------+

  function lgsl_icon_game($type, $game)
  {
    global $lgsl_file_path, $lgsl_url_path;

    $type = preg_replace("/[^a-z0-9_]/", "_", strtolower($type));
    $game = preg_replace("/[^a-z0-9_]/", "_", strtolower($game));

    $path_list = array(
    "icons/{$type}/{$game}.gif",
    "icons/{$type}/{$game}.png",
    "icons/{$type}/{$type}.gif",
    "icons/{$type}/{$type}.png");

    foreach ($path_list as $path)
    {
      if (file_exists($lgsl_file_path.$path)) { return $lgsl_url_path.$path; }
    }

    return "{$lgsl_url_path}other/icon_unknown.gif";
  }

//------------------------------------------------------------------------------------------------------------+

  function lgsl_icon_status($status, $password, $pending = 0)
  {
    global $lgsl_url_path;

    if ($pending)  { return "{$lgsl_url_path}other/icon_unknown.gif"; }
    if (!$status)  { return "{$lgsl_url_path}other/icon_no_response.gif"; }
    if ($password) { return "{$lgsl_url_path}other/icon_online_password.gif"; }

    return "{$lgsl_url_path}other/icon_online.gif";
  }

//------------------------------------------------------------------------------------------------------------+

  function lgsl_icon_location($location)
  {
    global $lgsl_config, $lgsl_file_path, $lgsl_url_path;

    if (!$location || !$lgsl_config["locations"]) { return "{$lgsl_url_path}locations/OFF.png"; }

    if ($location)
    {
      $location = "locations/".strtoupper(preg_replace("/[^a-zA-Z0-9_]/", "_", $location)).".png";

      if (file_exists($lgsl_file_path.$location)) { return $lgsl_url_path.$location; }
    }

    return "{$lgsl_url_path}locations/XX.png";
  }

//------------------------------------------------------------------------------------------------------------+

  function lgsl_image_map($status, $type, $game, $map, $check_exists = TRUE, $id = 0)
  {
    global $lgsl_file_path, $lgsl_url_path;

    $type = preg_replace("/[^a-z0-9_]/", "_", strtolower($type));
    $game = preg_replace("/[^a-z0-9_]/", "_", strtolower($game));
    $map  = preg_replace("/[^a-z0-9_]/", "_", strtolower($map));

    if ($check_exists !== TRUE) { return "{$lgsl_url_path}maps/{$type}/{$game}/{$map}.jpg"; }

    if ($status)
    {
      $path_list = array(
      "maps/{$type}/{$game}/{$map}.jpg",
      "maps/{$type}/{$game}/{$map}.gif",
      "maps/{$type}/{$game}/{$map}.png",
      "maps/{$type}/{$map}.jpg",
      "maps/{$type}/{$map}.gif",
      "maps/{$type}/{$map}.png",
      "maps/{$type}/map_no_image.jpg",
      "maps/{$type}/map_no_image.gif",
      "maps/{$type}/map_no_image.png",
      "other/map_no_image_{$id}.jpg",
      "other/map_no_image_{$id}.gif",
      "other/map_no_image_{$id}.png",
      "other/map_no_image.jpg");
    }
    else
    {
      $path_list = array(
      "maps/{$type}/map_no_response.jpg",
      "maps/{$type}/map_no_response.gif",
      "maps/{$type}/map_no_response.png",
      "other/map_no_response_{$id}.jpg",
      "other/map_no_response_{$id}.gif",
      "other/map_no_response_{$id}.png",
      "other/map_no_response.jpg");
    }

    foreach ($path_list as $path)
    {
      if (file_exists($lgsl_file_path.$path)) { return "{$lgsl_url_path}{$path}"; }
    }

    return "#LGSL_DEFAULT_IMAGES_MISSING#";
  }

//------------------------------------------------------------------------------------------------------------+

  function lgsl_image_map_password($status, $password)
  {
    global $lgsl_url_path;

    if (!$password || !$status) { return "{$lgsl_url_path}other/map_overlay.gif"; }

    return "{$lgsl_url_path}other/map_overlay_password.gif";
  }

//------------------------------------------------------------------------------------------------------------+

  function lgsl_text_status($status, $password, $pending = 0)
  {
    if ($pending)  { return 'pen'; }
    if (!$status)  { return 'nrs'; }
    if ($password) { return 'onp'; }

    return 'onl';
  }

//------------------------------------------------------------------------------------------------------------+

  function lgsl_text_type_game($type, $game)
  {
    global $lgsl_config;

    return "[ {$lgsl_config['text']['typ']}: {$type} ] [ {$lgsl_config['text']['gme']}: {$game} ]";
  }

//------------------------------------------------------------------------------------------------------------+

  function lgsl_text_location($location)
  {
    global $lgsl_config;

    return $location ? "{$lgsl_config['text']['loc']} {$location}" : "";
  }

//------------------------------------------------------------------------------------------------------------+

  function lgsl_sort_servers($server_list)
  {
    global $lgsl_config;

    if (!is_array($server_list)) { return $server_list; }

    if     ($lgsl_config['sort']['servers'] == "id")      { usort($server_list, "lgsl_sort_servers_by_id");      }
    elseif ($lgsl_config['sort']['servers'] == "zone")    { usort($server_list, "lgsl_sort_servers_by_zone");    }
    elseif ($lgsl_config['sort']['servers'] == "type")    { usort($server_list, "lgsl_sort_servers_by_type");    }
    elseif ($lgsl_config['sort']['servers'] == "status")  { usort($server_list, "lgsl_sort_servers_by_status");  }
    elseif ($lgsl_config['sort']['servers'] == "players") { usort($server_list, "lgsl_sort_servers_by_players"); }

    return $server_list;
  }

//------------------------------------------------------------------------------------------------------------+

  function lgsl_sort_fields($server, $fields_show, $fields_hide, $fields_other)
  {
    $fields_list = array();

    if (!is_array($server['p'])) { return $fields_list; }

    foreach ($server['p'] as $player)
    {
      foreach ($player as $field => $value)
      {
        if ($value === "") { continue; }
        if (in_array($field, $fields_list)) { continue; }
        if (in_array($field, $fields_hide)) { continue; }
        $fields_list[] = $field;
      }
    }

    $fields_show = array_intersect($fields_show, $fields_list);

    if ($fields_other == FALSE) { return $fields_show; }

    $fields_list = array_diff($fields_list, $fields_show);

    return array_merge($fields_show, $fields_list);
  }

//------------------------------------------------------------------------------------------------------------+

  function lgsl_sort_servers_by_id($server_a, $server_b)
  {
    if ($server_a['o']['id'] == $server_b['o']['id']) { return 0; }

    return ($server_a['o']['id'] > $server_b['o']['id']) ? 1 : -1;
  }

//------------------------------------------------------------------------------------------------------------+

  function lgsl_sort_servers_by_zone($server_a, $server_b)
  {
    if ($server_a['o']['zone'] == $server_b['o']['zone']) { return 0; }

    return ($server_a['o']['zone'] > $server_b['o']['zone']) ? 1 : -1;
  }

//------------------------------------------------------------------------------------------------------------+

  function lgsl_sort_servers_by_type($server_a, $server_b)
  {
    $result = strcasecmp($server_a['b']['type'], $server_b['b']['type']);

    if ($result == 0)
    {
      $result = strcasecmp($server_a['s']['game'], $server_b['s']['game']);
    }

    return $result;
  }

//------------------------------------------------------------------------------------------------------------+

  function lgsl_sort_servers_by_status($server_a, $server_b)
  {
    if ($server_a['b']['status'] == $server_b['b']['status']) { return 0; }

    return ($server_a['b']['status'] < $server_b['b']['status']) ? 1 : -1;
  }

//------------------------------------------------------------------------------------------------------------+

  function lgsl_sort_servers_by_players($server_a, $server_b)
  {
    if ($server_a['s']['players'] == $server_b['s']['players'])
			if ($server_a['b']['status'] < $server_b['b']['status'])
					{ return 1; }
				else
					{ return 0; }

    return ($server_a['s']['players'] < $server_b['s']['players']) ? 1 : -1;
  }

//------------------------------------------------------------------------------------------------------------+

  function lgsl_sort_extras($server)
  {
    if (!is_array($server['e'])) { return $server; }

    ksort($server['e']);

    return $server;
  }

//------------------------------------------------------------------------------------------------------------+

  function lgsl_sort_players($server)
  {
    global $lgsl_config;

    if (!is_array($server['p'])) { return $server; }

    if     ($lgsl_config['sort']['players'] == "name")  { usort($server['p'], "lgsl_sort_players_by_name");  }
    elseif ($lgsl_config['sort']['players'] == "score") { usort($server['p'], "lgsl_sort_players_by_score"); }
    elseif ($lgsl_config['sort']['players'] == "time") { usort($server['p'], "lgsl_sort_players_by_time"); }

    return $server;
  }

//------------------------------------------------------------------------------------------------------------+

  function lgsl_sort_players_by_score($player_a, $player_b)
  {
    if ($player_a['score'] == $player_b['score']) { return 0; }

    return ($player_a['score'] < $player_b['score']) ? 1 : -1;
  }

//------------------------------------------------------------------------------------------------------------+
	 
  function lgsl_sort_players_by_time($player_a, $player_b)
  {
    if ($player_a['time'] == $player_b['time']) { return 0; }

    return ($player_a['time'] < $player_b['time']) ? 1 : -1;
  }

//------------------------------------------------------------------------------------------------------------+

  function lgsl_sort_players_by_name($player_a, $player_b)
  {
    // REMOVE NON ALPHA NUMERIC ASCII WHILE LEAVING UPPER UTF-8 CHARACTERS
    $name_a = preg_replace("/[\x{00}-\x{2F}\x{3A}-\x{40}\x{5B}-\x{60}\x{7B}-\x{7F}]/", "", $player_a['name']);
    $name_b = preg_replace("/[\x{00}-\x{2F}\x{3A}-\x{40}\x{5B}-\x{60}\x{7B}-\x{7F}]/", "", $player_b['name']);

    if (function_exists("mb_convert_case"))
    {
      $name_a = @mb_convert_case($name_a, MB_CASE_LOWER, "UTF-8");
      $name_b = @mb_convert_case($name_b, MB_CASE_LOWER, "UTF-8");
      return strcmp($name_a, $name_b);
    }
    else
    {
      return strcasecmp($name_a, $name_b);
    }
  }

//------------------------------------------------------------------------------------------------------------+

  function lgsl_charset_detect($server)
  {
    if (!function_exists("mb_detect_encoding")) { return "AUTO"; }

    $test = "";

    if (isset($server['s']['name'])) { $test .= " {$server['s']['name']} "; }

    if (isset($server['p']) && $server['p'])
    {
      foreach ($server['p'] as $player)
      {
        if (isset($player['name'])) { $test .= " {$player['name']} "; }
      }
    }

    $charset = @mb_detect_encoding($server['s']['name'], "UTF-8, Windows-1252, ISO-8859-1, ISO-8859-15");

    return $charset ? $charset : "AUTO";
  }

//------------------------------------------------------------------------------------------------------------+

  function lgsl_charset_convert($server, $charset)
  {
    if (!function_exists("mb_convert_encoding")) { return $server; }

    if (is_array($server))
    {
      foreach ($server as $key => $value)
      {
        $server[$key] = lgsl_charset_convert($value, $charset);
      }
    }
    else
    {
      $server = @mb_convert_encoding($server, "UTF-8", $charset);
    }

    return $server;
  }

//------------------------------------------------------------------------------------------------------------+

  function lgsl_server_html($server, $word_wrap = 20)
  {
    foreach ($server as $key => $value)
    {
      $server[$key] = is_array($value) ? lgsl_server_html($value, $word_wrap) : lgsl_string_html($value, FALSE, $word_wrap);
    }

    return $server;
  }

//------------------------------------------------------------------------------------------------------------+

  function lgsl_string_html($string, $xml_feed = FALSE, $word_wrap = 0)
  {
    if ($word_wrap) { $string = lgsl_word_wrap($string, $word_wrap); }

    if ($xml_feed != FALSE)
    {
      $string = htmlspecialchars($string, ENT_QUOTES);
    }
    elseif (function_exists("mb_convert_encoding"))
    {
      $string = htmlspecialchars($string, ENT_QUOTES);
      $string = @mb_convert_encoding($string, "HTML-ENTITIES", "UTF-8");
    }
    else
    {
      $string = htmlentities($string, ENT_QUOTES, "UTF-8");
    }

    if ($word_wrap) { $string = lgsl_word_wrap($string); }

    return $string;
  }

//------------------------------------------------------------------------------------------------------------+

  function lgsl_word_wrap($string, $length_limit = 0)
  {
    if (!$length_limit)
    {
//    http://www.quirksmode.org/oddsandends/wbr.html
//    return str_replace("\x05\x06", " ",       $string); // VISIBLE
//    return str_replace("\x05\x06", "&shy;",   $string); // FF2 VISIBLE AND DIV NEEDED
      return str_replace("\x05\x06", "&#8203;", $string); // IE6 VISIBLE
    }

    $word_list = explode(" ", $string);

    foreach ($word_list as $key => $word)
    {
      $word_length = function_exists("mb_strlen") ? mb_strlen($word, "UTF-8") : strlen($word);

      if ($word_length < $length_limit) { continue; }

      $word_new = "";

      for ($i=0; $i<$word_length; $i+=$length_limit)
      {
        $word_new .= function_exists("mb_substr") ? mb_substr($word, $i, $length_limit, "UTF-8") : substr($word, $i, $length_limit);
        $word_new .= "\x05\x06";
      }

      $word_list[$key] = $word_new;
    }

    return implode(" ", $word_list);
  }

//------------------------------------------------------------------------------------------------------------+

  function lgsl_location_link($location)
  {
    if (!$location) { return "#"; }

    return "https://www.google.com/maps/search/{$location}/";
  }

//------------------------------------------------------------------------------------------------------------+

  function lgsl_query_location($ip)
  {
    global $lgsl_config;

    if ($lgsl_config['locations'] !== 1 && $lgsl_config['locations'] !== true) { return $lgsl_config['locations']; }

    $ip = gethostbyname($ip);

    if (long2ip(ip2long($ip)) == "255.255.255.255") { return "XX"; }

    $url = "http://ip-api.com/json/".urlencode($ip)."?fields=countryCode"; // http://api.wipmania.com/

    if (function_exists('curl_init') && function_exists('curl_setopt') && function_exists('curl_exec'))
    {
      $lgsl_curl = curl_init();

      curl_setopt($lgsl_curl, CURLOPT_HEADER, 0);
      curl_setopt($lgsl_curl, CURLOPT_TIMEOUT, 2);
      curl_setopt($lgsl_curl, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($lgsl_curl, CURLOPT_CONNECTTIMEOUT, 2);
      curl_setopt($lgsl_curl, CURLOPT_URL, $url);

      $answer = curl_exec($lgsl_curl);
			$answer = json_decode($answer, true);
      $location = $answer["countryCode"];

      if (curl_error($lgsl_curl)) { $location = "XX"; }

      curl_close($lgsl_curl);
    }
    else
    {
      $location = @file_get_contents($url);
    }

    if (strlen($location) != 2) { $location = "XX"; }

    return $location;
  }

//------------------------------------------------------------------------------------------------------------+

  function lgsl_realpath($path)
  {
    // WRAPPER SO IT CAN BE DISABLED

    global $lgsl_config;

    return $lgsl_config['no_realpath'] ? $path : realpath($path);
  }

//------------------------------------------------------------------------------------------------------------+

  function lgsl_file_path()
  {
    // GET THE LGSL_CLASS.PHP PATH

    $lgsl_path = __FILE__;

    // SHORTEN TO JUST THE FOLDERS AND ADD TRAILING SLASH

    $lgsl_path = dirname($lgsl_path)."/";

    // CONVERT WINDOWS BACKSLASHES TO FORWARDSLASHES

    $lgsl_path = str_replace("\\", "/", $lgsl_path);

    return $lgsl_path;
  }

//------------------------------------------------------------------------------------------------------------+

  function lgsl_url_path()
  {
    // CHECK IF PATH HAS BEEN SET IN CONFIG

    global $lgsl_config;

    if ($lgsl_config['url_path'])
    {
      return $lgsl_config['url_path'];
    }

    // USE FULL DOMAIN PATH TO AVOID ALIAS PROBLEMS

    $host_path  = (!isset($_SERVER['HTTPS']) || strtolower($_SERVER['HTTPS']) != "on") ? "http://" : "https://";
    $host_path .= $_SERVER['HTTP_HOST'];

    // GET FULL PATHS ( EXTRA CODE FOR WINDOWS AND IIS - NO DOCUMENT_ROOT - BACKSLASHES - DOUBLESLASHES - ETC )

    if ($_SERVER['DOCUMENT_ROOT'])
    {
      $base_path = lgsl_realpath($_SERVER['DOCUMENT_ROOT']);
      $base_path = str_replace("\\", "/", $base_path);
      $base_path = str_replace("//", "/", $base_path);
    }
    else
    {
      $file_path = $_SERVER['SCRIPT_NAME'];
      $file_path = str_replace("\\", "/", $file_path);
      $file_path = str_replace("//", "/", $file_path);

      $base_path = $_SERVER['PATH_TRANSLATED'];
      $base_path = str_replace("\\", "/", $base_path);
      $base_path = str_replace("//", "/", $base_path);
      $base_path = substr($base_path, 0, -strlen($file_path));
    }

    $lgsl_path = dirname(lgsl_realpath(__FILE__));
    $lgsl_path = str_replace("\\", "/", $lgsl_path);

    // REMOVE ANY TRAILING SLASHES

    if (substr($base_path, -1) == "/") { $base_path = substr($base_path, 0, -1); }
    if (substr($lgsl_path, -1) == "/") { $lgsl_path = substr($lgsl_path, 0, -1); }

    // USE THE DIFFERENCE BETWEEN PATHS

    if (substr($lgsl_path, 0, strlen($base_path)) == $base_path)
    {
      $url_path = substr($lgsl_path, strlen($base_path));

      return $host_path.$url_path."/";
    }

    return "/#LGSL_PATH_PROBLEM#{$base_path}#{$lgsl_path}#/";
  }

//------------------------------------------------------------------------------------------------------------+
//------------------------------------------------------------------------------------------------------------+

  } // END OF DOUBLE LOAD PROTECTION

//------------------------------------------------------------------------------------------------------------+
//------------------------------------------------------------------------------------------------------------+

  global $lgsl_file_path, $lgsl_url_path;

  $lgsl_file_path = lgsl_file_path();

  if (isset($_GET['lgsl_debug']))
  {
    echo "<hr /><pre>".print_r($_SERVER, TRUE)."</pre>
          <hr />#d0# ".__FILE__."
          <hr />#d1# ".@realpath(__FILE__)."
          <hr />#d2# ".dirname(__FILE__)."
          <hr />#d3# {$lgsl_file_path}
          <hr />#d4# {$_SERVER['DOCUMENT_ROOT']}
          <hr />#d5# ".@realpath($_SERVER['DOCUMENT_ROOT']);
  }

  require $lgsl_file_path."lgsl_config.php";
  require $lgsl_file_path."lgsl_protocol.php";

  $lgsl_url_path = lgsl_url_path();

  if (isset($_GET['lgsl_debug']))
  {
    echo "<hr />#d6# {$lgsl_url_path}
          <hr />#c0# {$lgsl_config['url_path']}
          <hr />#c1# {$lgsl_config['no_realpath']}
          <hr />#c2# {$lgsl_config['feed']['method']}
          <hr />#c3# {$lgsl_config['feed']['url']}
          <hr />#c4# {$lgsl_config['cache_time']}
          <hr />#c5# {$lgsl_config['live_time']}
          <hr />#c6# {$lgsl_config['timeout']}
          <hr />#c7# {$lgsl_config['cms']}
          <hr />";
  }

  if (!isset($lgsl_config['locations']))
  {
    exit("LGSL PROBLEM: lgsl_config.php FAILED TO LOAD OR MISSING ENTRIES");
  }

//------------------------------------------------------------------------------------------------------------+
