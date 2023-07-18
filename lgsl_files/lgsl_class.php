<?php
  namespace tltneon\LGSL;

 /*----------------------------------------------------------------------------------------------------------\
 |                                                                                                            |
 |                      [ LIVE GAME SERVER LIST ] [ RICHARD PERRY FROM GREYCUBE.COM ]                       |
 |                                                                                                            |
 |    Released under the terms and conditions of the GNU General Public License Version 3 (http://gnu.org)    |
 |                                                                                                            |
 \-----------------------------------------------------------------------------------------------------------*/

//------------------------------------------------------------------------------------------------------------+
//------------------------------------------------------------------------------------------------------------+

  if (!function_exists('lgsl_url_path')) { // START OF DOUBLE LOAD PROTECTION

//------------------------------------------------------------------------------------------------------------+
//------------------------------------------------------------------------------------------------------------+
  class LGSL {
    static function db() {
      $db = new Database();
      $db->instance();
      $db->connect();
      return $db;
    }
    static function link($s = "", $p = "") {
      global $lgsl_config, $lgsl_url_path;
      $index = $lgsl_config['direct_index'] ? "index.php" : "";

      switch($lgsl_config['cms']) {
        case "e107": $link = $s ? e_PLUGIN_ABS."lgsl/{$index}?s={$s}" : e_PLUGIN_ABS."lgsl/{$index}"; break;
        case "joomla": $link = $s ? JRoute::_("index.php?option=com_lgsl&s={$s}") : JRoute::_("index.php?option=com_lgsl"); break;
        case "drupal": $link = $s ? url("LGSL/{$s}") : url("LGSL"); break;
        case "phpnuke": $link = $s ? "modules.php?name=LGSL&s={$s}" : "modules.php?name=LGSL"; break;
        /*"sa"*/
        default: 
          $link = $s ? 
                    $p ?
                      "{$lgsl_url_path}../{$index}?ip={$s}&port={$p}" :
                      "{$lgsl_url_path}../{$index}?s={$s}" :
                      "{$lgsl_url_path}../{$index}";
        break;
      }
      return $link;
    }
    static function location_link($location) {
      if (!$location) { return "#"; }
      return "https://www.google.com/maps/search/{$location}/";
    }
    static function query_location($ip) {
      global $lgsl_config;
  
      if ($lgsl_config['locations'] !== 1 && $lgsl_config['locations'] !== true) { return $lgsl_config['locations']; }
  
      $ip = gethostbyname($ip);
  
      if (long2ip(ip2long($ip)) == "255.255.255.255") { return "XX"; }
  
      $url = "http://ip-api.com/json/".urlencode($ip)."?fields=countryCode";
  
      if (function_exists('curl_init') && function_exists('curl_setopt') && function_exists('curl_exec')) {
        $lgsl_curl = curl_init();
  
        curl_setopt($lgsl_curl, CURLOPT_HEADER, 0);
        curl_setopt($lgsl_curl, CURLOPT_TIMEOUT, 2);
        curl_setopt($lgsl_curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($lgsl_curl, CURLOPT_CONNECTTIMEOUT, 2);
        curl_setopt($lgsl_curl, CURLOPT_URL, $url);
  
        $answer = curl_exec($lgsl_curl);
        $answer = json_decode($answer, true);
        $location = (isset($answer["countryCode"]) ? $answer["countryCode"] : "XX");
  
        if (curl_error($lgsl_curl)) { $location = "XX"; }
  
        curl_close($lgsl_curl);
      } else {
        $location = @file_get_contents($url);
      }
  
      if (strlen($location) != 2) { $location = "XX"; }
  
      return $location;
    }
    static public function group_totals($server_list = FALSE) {
      if (!is_array($server_list)) { return Database::get_statistics(); }

      $total = array("players"=>0, "playersmax"=>0, "servers"=>0, "servers_online"=>0, "servers_offline"=>0);

      foreach ($server_list as $server) {
        $total['players']    += $server->get_players_count('active');
        $total['playersmax'] += $server->get_players_count('max');

        $total['servers']++;
        if (in_array($server->get_status(), [self::ONLINE, self::PASSWORDED])) {
          $total['servers_online']++;
        } else {
          $total['servers_offline']++;
        }
      }

      return $total;
    }
		static public function requestHas($request, $type) {
			return stripos($request, $type) !== false;
		}
		static public function removeChars($s) {
			return preg_replace('/[\x00-\x01]/', '', $s);
		}
		static public function timer($action) {
			global $lgsl_config, $lgsl_timer;

			if (!$lgsl_timer) {
				$microtime  = microtime();
				$microtime  = explode(' ', $microtime);
				$microtime  = $microtime[1] + $microtime[0];
				$lgsl_timer = $microtime - 0.01;
			}

			$time_limit = intval($lgsl_config['live_time']);
			$time_php   = ini_get("max_execution_time");

			if ($time_limit > $time_php) {
				@set_time_limit($time_limit + 5);

				$time_php = ini_get("max_execution_time");

				if ($time_limit > $time_php) {
					$time_limit = $time_php - 5;
				}
			}

			if ($action == "limit") {
				return $time_limit;
			}

			$microtime  = microtime();
			$microtime  = explode(' ', $microtime);
			$microtime  = $microtime[1] + $microtime[0];
			$time_taken = $microtime - $lgsl_timer;

			if ($action == "check") {
				return $time_taken > $time_limit;
			} else {
				return round($time_taken, 2);
			}
		}
		static public function locationCoords($code) {
			$a = ["AD"=>[0,0],"AE"=>[16,0],"AF"=>[32,0],"AG"=>[48,0],"AI"=>[64,0],"AL"=>[80,0],"AM"=>[96,0],"AN"=>[112,0],"AO"=>[128,0],"AR"=>[144,0],"AS"=>[160,0],"AT"=>[176,0],"AU"=>[192,0],"AW"=>[0,11],"AX"=>[16,11],"AZ"=>[32,11],
						"BA"=>[48,11],"BB"=>[64,11],"BD"=>[80,11],"BE"=>[96,11],"BF"=>[112,11],"BG"=>[128,11],"BH"=>[144,11],"BI"=>[160,11],"BJ"=>[176,11],"BM"=>[192,11],"BN"=>[0,22],"BO"=>[16,22],"BR"=>[32,22],"BS"=>[48,22],"BT"=>[64,22],"BV"=>[80,22],
						"BW"=>[96,22],"BY"=>[112,22],"BZ"=>[128,22],"CA"=>[144,22],"CC"=>[160,22],"CD"=>[176,22],"CF"=>[192,22],"CG"=>[0,33],"CH"=>[16,33],"CI"=>[32,33],"CK"=>[48,33],"CL"=>[64,33],"CM"=>[80,33],"CN"=>[96,33],"CO"=>[112,33],"CR"=>[128,33],
						"CS"=>[144,33],"CU"=>[160,33],"CV"=>[176,33],"CX"=>[192,33],"CY"=>[0,44],"CZ"=>[16,44],"DE"=>[32,44],"DJ"=>[48,44],"DK"=>[64,44],"DM"=>[80,44],"DO"=>[96,44],"DZ"=>[112,44],"EC"=>[128,44],"EE"=>[144,44],"EG"=>[160,44],"EH"=>[176,44],
						"ER"=>[192,44],"ES"=>[0,55],"ET"=>[16,55],"EU"=>[32,55],"FI"=>[48,55],"FJ"=>[64,55],"FK"=>[80,55],"FM"=>[96,55],"FO"=>[112,55],"FR"=>[128,55],"GA"=>[144,55],"GB"=>[160,55],"GD"=>[176,55],"GE"=>[192,55],"GF"=>[0,66],"GH"=>[16,66],
						"GI"=>[32,66],"GL"=>[48,66],"GM"=>[64,66],"GN"=>[80,66],"GP"=>[96,66],"GQ"=>[112,66],"GR"=>[128,66],"GS"=>[144,66],"GT"=>[160,66],"GU"=>[176,66],"GW"=>[192,66],"GY"=>[0,77],"HK"=>[16,77],"HM"=>[32,77],"HN"=>[48,77],"HR"=>[64,77],
						"HT"=>[80,77],"HU"=>[96,77],"ID"=>[112,77],"IE"=>[128,77],"IL"=>[144,77],"IN"=>[160,77],"IO"=>[176,77],"IQ"=>[192,77],"IR"=>[0,88],"IS"=>[16,88],"IT"=>[32,88],"JM"=>[48,88],"JO"=>[64,88],"JP"=>[80,88],"KE"=>[96,88],"KG"=>[112,88],
						"KH"=>[128,88],"KI"=>[144,88],"KM"=>[160,88],"KN"=>[176,88],"KP"=>[192,88],"KR"=>[0,99],"KW"=>[16,99],"KY"=>[32,99],"KZ"=>[48,99],"LA"=>[64,99],"LB"=>[80,99],"LC"=>[96,99],"LI"=>[112,99],"LK"=>[128,99],"LR"=>[144,99],"LS"=>[160,99],
						"LT"=>[176,99],"LU"=>[192,99],"LV"=>[0,110],"LY"=>[16,110],"MA"=>[32,110],"MC"=>[48,110],"MD"=>[64,110],"ME"=>[80,110],"MG"=>[96,110],"MH"=>[112,110],"MK"=>[128,110],"ML"=>[144,110],"MM"=>[160,110],"MN"=>[176,110],"MO"=>[192,110],
						"MP"=>[0,121],"MQ"=>[16,121],"MR"=>[32,121],"MS"=>[48,121],"MT"=>[64,121],"MU"=>[96,121],"MV"=>[112,121],"MW"=>[128,121],"MX"=>[144,121],"MY"=>[160,121],"MZ"=>[176,121],"NA"=>[192,121],"NC"=>[0,132],"NE"=>[16,132],"NF"=>[32,132],
						"NG"=>[48,132],"NI"=>[64,132],"NL"=>[80,132],"NO"=>[96,132],"NP"=>[112,132],"NR"=>[128,132],"NU"=>[144,132],"NZ"=>[160,132],"OFF"=>[176,132],"OM"=>[192,132],"PA"=>[0,143],"PE"=>[16,143],"PF"=>[32,143],"PG"=>[48,143],"PH"=>[64,143],
						"PK"=>[80,143],"PL"=>[96,143],"PM"=>[112,143],"PN"=>[128,143],"PR"=>[144,143],"PS"=>[160,143],"PT"=>[176,143],"PW"=>[192,143],"PY"=>[0,154],"QA"=>[16,154],"RE"=>[32,154],"RO"=>[48,154],"RS"=>[64,154],"RU"=>[80,154],"RW"=>[96,154],
						"SA"=>[112,154],"SB"=>[128,154],"SC"=>[144,154],"SD"=>[160,154],"SE"=>[176,154],"SG"=>[192,154],"SH"=>[0,165],"SI"=>[16,165],"SJ"=>[32,165],"SK"=>[48,165],"SL"=>[64,165],"SM"=>[80,165],"SN"=>[96,165],"SO"=>[112,165],"SR"=>[128,165],
						"ST"=>[144,165],"SV"=>[160,165],"SY"=>[176,165],"SZ"=>[192,165],"TC"=>[0,176],"TD"=>[16,176],"TF"=>[32,176],"TG"=>[48,176],"TH"=>[64,176],"TJ"=>[80,176],"TK"=>[96,176],"TL"=>[112,176],"TM"=>[128,176],"TN"=>[144,176],"TO"=>[160,176],
						"TR"=>[176,176],"TT"=>[192,176],"TV"=>[0,187],"TW"=>[16,187],"TZ"=>[32,187],"UA"=>[48,187],"UG"=>[64,187],"UK"=>[80,187],"UM"=>[96,187],"US"=>[112,187],"UY"=>[128,187],"UZ"=>[144,187],"VA"=>[160,187],"VC"=>[176,187],"VE"=>[192,187],
						"VG"=>[208,0],"VI"=>[208,11],"VN"=>[208,22],"VU"=>[208,33],"WF"=>[208,44],"WS"=>[208,55],"XX"=>[208,66],"YE"=>[208,77],"YT"=>[208,88],"ZA"=>[208,99],"ZM"=>[208,110],"ZW"=>[208,121]];
			return $a[$code];
		}
  }
//------------------------------------------------------------------------------------------------------------+
  class Database {
    private static $_instance = null;
    private $_connection;
    private $_db;
    
    public static function instance() {
      if (static::$_instance === null) {
        static::$_instance = new static();
      }
      return static::$_instance;
    }

    public function connect() {
      global $lgsl_config, $lgsl_file_path;
      if (!isset($lgsl_config['db']['prefix'])) {
        $lgsl_config['db']['prefix'] = "";
      }
      if (!$lgsl_config['db']['pass']) {
        $this->load_cms_config();
      }      
      if (!$this->_connection) {
        $this->_connection = new \mysqli($lgsl_config['db']['server'], $lgsl_config['db']['user'], $lgsl_config['db']['pass'], $lgsl_config['db']['db']);
      }
      $this->_db = $lgsl_config['db']['db'];
      $this->select_db();
      if ($this->_connection->connect_errno) {
        printf("Connect failed: %s\n", $this->_connection->connect_error);
        exit();
      }
      return $this->_connection;
    }
    public function select_db() {
      if ($this->_connection) {
        $this->_connection->select_db($this->_db);
      }
    }
    public function set_charset($charset) {
      $this->_connection->set_charset($charset);
    }
    public function load_cms_config() {
      global $lgsl_config, $lgsl_file_path;
      switch($lgsl_config['cms']) {
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
    function query($string, $single_result = false, $mode = MYSQLI_ASSOC) {
      $result = $this->execute($string);
      if ($result === false) {
        printf("Connect failed: %s\n", $this->_connection->connect_error);
      } elseif ($result === true) {
        return "Successfully updated";
      } else {
        if ($single_result) {
          return $result->fetch_array($mode);
        }
        return $result->fetch_all($mode);
      }
    }
    function execute($string) {
      $result = $this->_connection->query($string) or $this->err();
      return $result;
    }
    function err() {
      die("DB Error: {$this->_connection->error}");
    }
    function escape_string($string) {
      return $this->_connection->escape_string($string);
    }

    public function load_server($query) {
      $result = $this->query($query, true);
      if ($result) {
        return $this->lgsl_unserialize_server_data($result);
      }
      return null;
    }
    function get_server_by_id($id) {
      global $lgsl_config;
      return $this->load_server("SELECT * FROM {$lgsl_config['db']['prefix']}{$lgsl_config['db']['table']} WHERE id = {$id};");
    }

    function get_server_by_ip($ip, $c_port) {
      global $lgsl_config;
			if ($c_port > 1) $c_port = "and c_port = {$c_port}";
			else $c_port = "";
      return $this->load_server("SELECT * FROM {$lgsl_config['db']['prefix']}{$lgsl_config['db']['table']} WHERE ip = '{$ip}' {$c_port};");
    }
    
    static function get_servers_group($options = array()) {
      global $lgsl_config;
      $db = LGSL::db();

      $limit        = isset($options['limit'])        ? (int) $options['limit']          : (int) $lgsl_config['pagination_lim'];
      $request      = isset($options['request'])      ? $options['request']              : "s";
      $zone         = isset($options['zone'])         ? (int) $options['zone']           : 0;
      $hide_offline = isset($options['hide_offline']) ? (int) $options['hide_offline']   : (int) $lgsl_config['hide_offline'][$zone];
      $random       = isset($options['random'])       ? (int) $options['random']         : (int) $lgsl_config['random'][$zone];
      $type         = empty($options['type'])         ? ""                               : preg_replace("/[^a-z0-9_]/", "_", strtolower($options['type']));
      $game         = empty($options['game'])         ? ""                               : preg_replace("/[^a-z0-9_]/", "_", strtolower($options['game']));
      $mode         = empty($options['mode'])         ? ""                               : preg_replace("/[^a-z0-9_]/", "_", strtolower($options['mode']));
      $page         = empty($options['page'])         ? ""                               : "LIMIT {$limit} OFFSET " . strval($limit*((int)$options['page'] - 1));
      $status       = empty($options['status'])       ? ""                               : 1;
      $order        = empty($options['order'])        ? ""                               : $options['order'];
      $sort         = empty($options['sort'])         ? ""                               : (in_array($options['sort'], ['ip', 'name', 'map', 'players']) ? $options['sort'] : "");
      $server_limit = empty($options['limit'])        ? ""                               : $lgsl_config['pagination_lim'];
      $server_limit = empty($random)                  ? $server_limit                    : $random;

                           $mysqli_where   = ["`disabled`=0"];
      if ($zone != 0)    { $mysqli_where[] = "FIND_IN_SET('{$zone}',`zone`)"; }
      if ($type != "")   { $mysqli_where[] = "`type`='{$type}'"; }
      if ($game != "")   { $mysqli_where[] = "`game`='{$game}'"; }
      if ($mode != "")   { $mysqli_where[] = "`mode`='{$mode}'"; }
      if ($status != "") { $mysqli_where[] = "`status`={$status}"; }
      if ($server_limit != "") { $server_limit = "LIMIT {$server_limit}"; }
      if ($sort != "") { $sort = "ORDER BY {$options['sort']} {$order}"; }

      $mysqli_query  = "SELECT * FROM `{$lgsl_config['db']['prefix']}{$lgsl_config['db']['table']}` WHERE ".implode(" AND ", $mysqli_where)." {$sort} {$server_limit} {$page}";
      $mysqli_result = $db->query($mysqli_query);

      $output = [];
      foreach ($mysqli_result as $s) {
        $server = new Server();
        $server->from_array($db->lgsl_unserialize_server_data($s));
        $server->validate();

				if (!LGSL::requestHas($request, "c") && !LGSL::timer("check")) { // CACHE ONLY REQUEST
					$needed = "";
					$time = time();
					if (LGSL::requestHas($request, "s") && $time > ($server->get_timestamp('s', true) + $lgsl_config['cache_time'])) { $needed .= "s"; }
					if (LGSL::requestHas($request, "e") && $time > ($server->get_timestamp('e', true) + $lgsl_config['cache_time'])) { $needed .= "e"; }
					if (LGSL::requestHas($request, "p") && $time > ($server->get_timestamp('p', true) + $lgsl_config['cache_time'])) { $needed .= "p"; }
					if ($needed) {
						$server->lgsl_live_query($request);
						$db->lgsl_save_cache($server);
					}
				}
        $output[] = $server;
      }
      return $output;
    }
    static public function get_statistics() {
      global $lgsl_config;
      $db = LGSL::db();

      $mysqli_query  = "SELECT COUNT(*) as servers, SUM(players) as players, SUM(playersmax) as playersmax, SUM(STATUS) as servers_online, COUNT(*)-SUM(status) as servers_offline FROM `{$lgsl_config['db']['prefix']}{$lgsl_config['db']['table']}` WHERE disabled = 0;";
      $mysqli_result = $db->query($mysqli_query, true);
      return $mysqli_result;
    }

    function lgsl_save_cache(&$server) {
      global $lgsl_config;
      $packed_cache = $this->escape_string(base64_encode(serialize($server->to_array())));
      $packed_times = $this->escape_string(implode("_", $server->get_timestamps()));
      $status = $server->get_status() === Server::ONLINE;
      $mysqli_query  = "
        UPDATE `{$lgsl_config['db']['prefix']}{$lgsl_config['db']['table']}`
        SET `status`='{$status}',
            `cache`='{$packed_cache}',
            `cache_time`='{$packed_times}',
            `players`='{$server->get_players_count('active')}',
            `playersmax`='{$server->get_players_count('max')}',
            `game`='{$server->get_game()}',
            `mode`='{$server->get_mode()}',
            `name`='{$server->get_name()}',
            `map`='{$server->get_map()}'
        WHERE `id`='{$server->get_id()}'
        LIMIT 1";
        $this->query($mysqli_query);
    }
    
    function lgsl_unserialize_server_data($data) {
      $server = [];
      foreach (['name', 'game', 'mode', 'map', 'players', 'playersmax'] as $i) {
        $server['s'][$i] = $data[$i];
        unset($data[$i]);
      }
      foreach (['zone', 'comment'] as $i) {
        $server['o'][$i] = $data[$i];
        unset($data[$i]);
      }
      $server['b'] = $data;
      unset($server['b']['cache']);
      unset($server['b']['cache_time']);
      if (strlen($data['cache']) > 0) {
        $cache = unserialize(base64_decode($data['cache']));
        $server['b'] = array_merge($server['b'], $cache['b']);
        $server['p'] = $cache['p'];
        if (isset($cache['h'])) $server['h'] = $cache['h'];
        if (isset($cache['o']['location'])) $server['o']['location'] = $cache['o']['location'];
        $server['s']['cache_time'] = explode("_", $data['cache_time']);
      }
      return $server;
    }

    private function __clone(){}
    function __construct() {}
    function __wakeup(){}
  }
//------------------------------------------------------------------------------------------------------------+
  class Server {
		public const ONLINE = "onl";
		public const OFFLINE = "nrs";
		public const PASSWORDED = "pwd";
		public const PENDING = "pen";
    private $_base;
    private $_extra;
    private $_other;
    private $_server;
    private $_players;
    private $_history;
    private $_valid = false;
    
    function __construct($options = array()) {
      $this->_base = array_merge(array(
        "id" => 0,
        "ip" => "",
        "c_port" => 0,
        "q_port" => 0,
        "s_port" => 0,
        "type" => "",
        "status" => 0,
        "pending" => 1
      ), $options);
      $this->_server = array(
        "players" => 0,
        "playersmax" => 0,
        "name" => "--",
        "game" => "",
        "mode" => "none",
        "password" => 0
      );
      $this->_other = array(
        "zone" => null,
        "comment" => ''
      );
      $this->_extra = [];
      $this->_players = [];
      $this->_history = [];
    }
    
    public function lgsl_cached_query($request = 'sep') {
      $db = LGSL::db();
      if ($this->_base['id']) {
        $result = $db->get_server_by_id($this->_base['id']);
      } elseif ($this->_base['ip']) {
        $result = $db->get_server_by_ip($this->_base['ip'], $this->_base['c_port']);
      }
      if ($result) {
				global $lgsl_config;
        $this->from_array($result);
        $this->validate();
				if (!LGSL::requestHas($request, "c")) { // CACHE ONLY REQUEST
					$needed = "";
					if (LGSL::requestHas($request, "s") && time() > ($this->get_timestamp('s', true) + $lgsl_config['cache_time'])) { $needed .= "s"; }
					if (LGSL::requestHas($request, "e") && time() > ($this->get_timestamp('e', true) + $lgsl_config['cache_time'])) { $needed .= "e"; }
					if (LGSL::requestHas($request, "p") && time() > ($this->get_timestamp('p', true) + $lgsl_config['cache_time'])) { $needed .= "p"; }
					if ($needed) {
						$this->lgsl_live_query($request);
						$db->lgsl_save_cache($this);
					}
				}
      }
    }
    public function lgsl_live_query($request = 'seph') {
      $this->set_queried();
      $protocol = new Protocol($this, $request);
      $protocol->query();

      global $lgsl_config;
      if ($lgsl_config['history'] and LGSL::requestHas($request, "h") and $this->get_status() != self::PENDING) {
        $last = end($this->_history);
        if (!$last or time() - $last['t'] >= 60 * 15) { // RECORD IF 15 MINS IS PASSED
          $history_limit = $lgsl_config['history_hours'] * 60 * 60;
          foreach ($this->_history as $key => $value) {
            if (time() - $this->_history[$key]['t'] > $history_limit) { // NOT OLDER THAN $lgsl_config['history_hours'] HOURS
              unset($this->_history[$key]);
            } else {
              break;
            }
          }
          $this->_history = array_values($this->_history);
          array_push($this->_history, [
            "s" => $this->get_status() != self::OFFLINE,
            "t" => time(),
            "p" => $this->get_players_count('active')
          ]);
        }
      }

      if ($lgsl_config['locations'] && empty($this->_other['location'])) {
        $this->_other['location'] = $lgsl_config['locations'] ? $this->queryLocation() : "";
      }

      $this->validate();
    }
    
    public function from_array($data) {
			$this->_base = isset($data['b']) ? array_merge($this->_base, $data['b']) : $this->_base;
			$this->_extra = isset($data['e']) ? $data['e'] : [];
			$this->_other = isset($data['o']) ? $data['o'] : [];
			$this->_server = isset($data['s']) ? array_merge($this->_server, $data['s']) : $this->_server;
			$this->_players = isset($data['p']) ? $data['p'] : [];
			$this->_history = isset($data['h']) ? $data['h'] : [];
    }    
    public function to_array() {
      $server = array();
      $server['b'] = $this->_base;
      $server['e'] = $this->_extra;
      $server['o'] = $this->_other;
      $server['s'] = $this->_server;
      $server['p'] = $this->_players;
      $server['h'] = $this->_history;
      return $server;
    }
    public function validate() {
      $this->_valid = true;
    }
    public function isvalid() {
      return $this->_valid;
    }

    public function get_id() {
      return $this->_base['id'];
    }
    public function get_ip() {
      return $this->_base['ip'];
    }
    public function get_c_port() {
      if ($this->_base['c_port'] > 1)
        return $this->_base['c_port'];
      return "--";
    }
    public function get_q_port() {
      if ($this->_base['q_port'] > 1)
        return $this->_base['q_port'];
      return "--";
    }
    public function get_s_port() {
      return $this->_base['s_port'];
    }
    public function get_address() {
      if ($this->_base['type'] === 'discord') {
        return "https://discord.gg/{$this->get_ip()}";
      }
      return "{$this->_base['ip']}:{$this->_base['c_port']}";
    }
    public function get_type() {
      return $this->_base['type'];
    }
    public function get_game() {
      return $this->_server['game'] ? $this->_server['game'] : $this->_base['type'];
    }
    public function set_game($game) {
      return $this->_server['game'] = $game;
    }
    public function get_mode() {
      return $this->_server['mode'] ? $this->_server['mode'] : 'none';
    }
    public function get_map($formatted = false) {
			if ($formatted) return $this->_server['map'] ? preg_replace("/[^a-z0-9_]/", "_", strtolower($this->_server['map'])) : "--";
      return $this->_server['map'] ? $this->_server['map'] : "--";
    }
    public function get_players() {
      return $this->_players;
    }
    public function get_history() {
      return $this->_history;
    }
    public function get_extras() {
      return $this->_extra;
    }
    public function get_name($html = true) {
      if ($this->get_pending()) {
				return "--";
      }
      return $this->_server['name'];
    }
    public function set_name($name) {
      $this->_server['name'] = $name;
    }
    public function get_players_count($out = null) {
      if ($this->get_pending() or $this->get_status() === self::OFFLINE) {
        return "--";
      }
      if ($out === 'active') {
        return (int) (isset($this->_server['players']) ? $this->_server['players'] : 0);
      }
      if ($out === 'max') {
        return (int) (isset($this->_server['playersmax']) ? $this->_server['playersmax'] : 0);
      }
      if ($out === 'bots') {
        return (int) (isset($this->_extra['bots']) ? $this->_extra['bots'] : 0);
      }
      if ($out === 'percent') {
        return (int) ($this->_server['players'] == 0 || $this->_server['playersmax'] == 0 ? 0 : floor($this->_server['players']/$this->_server['playersmax']*100));
      }
      if (isset($this->_server['players']) and isset($this->_server['playersmax'])) {
        if ($this->_server['playersmax'] > 999) {
          return $this->_server['players'];
        } else {
          return "{$this->_server['players']}/{$this->_server['playersmax']}";
        }
      }
      return '--';
    }
    
    public function set_queried() {
      $this->_base['pending'] = 0;
    }
    public function get_pending() {
      return $this->_base['pending'];
    }
		public function getPlayerNames() {
			if ($this->get_players_count('active') > 0) {
				return array_reduce($this->get_players(), function($a, $c) {
					$a[] = $c['name'];
					return $a;
				}, []);
			}
			else return [];
		}

    public function get_software_link() {
      $lgsl_software_link = array(
        "arma3"         => "steam://connect/{IP}:{C_PORT}",
        "callofdutyiw"  => "javascript:prompt('Put it into console:', 'connect {IP}:{C_PORT}')",
        "callofduty4"   => "cod4://{IP}:{S_PORT}",
        "conanexiles"   => "steam://connect/{IP}:{C_PORT}",
        "cs2d"          => "steam://connect/{IP}:{C_PORT}",
        "discord"       => "https://discord.gg/{IP}",
        "factorio"      => "steam://connect/{IP}",
        "farmsim"       => "steam://connect/{IP}:{C_PORT}",
        "fivem"         => "fivem://connect/{IP}:{C_PORT}",
        "halflife"      => "steam://connect/{IP}:{C_PORT}",
        "halflifewon"   => "steam://connect/{IP}:{C_PORT}",
        "jc2mp"         => "steam://connect/{IP}:{C_PORT}",
        "killingfloor"  => "steam://connect/{IP}:{C_PORT}",
        "minecraft"     => "minecraft://{IP}:{C_PORT}/",
        "mta"           => "mtasa://{IP}:{C_PORT}",
        "mumble"        => "mumble://{IP}/",
        "openttd"       => "steam://connect/{IP}:{C_PORT}",
        "ragemp"        => "rage://v/connect?ip={IP}:{C_PORT}",
        "redorchestra"  => "steam://connect/{IP}:{C_PORT}",
        "rfactor"       => "rfactor://{IP}:{C_PORT}",
        "samp"          => "samp://{IP}:{C_PORT}",
        "scum"          => "steam://connect/{IP}:{C_PORT}",
        "sf"            => "steam://connect/{IP}:{C_PORT}",
        "soldat"        => "soldat://{IP}:{C_PORT}",
        "source"        => "steam://connect/{IP}:{C_PORT}",
        "test"          => "https://github.com/tltneon/lgsl",
        "teeworlds"     => "steam://connect/{IP}:{C_PORT}",
        "terraria"      => "steam://connect/{IP}:{C_PORT}",
        "ts3"           => "ts3server://{IP}?port={C_PORT}",
        "teaspeak"      => "ts3server://{IP}?port={C_PORT}",
        "warsow"        => "warsow://{IP}:{C_PORT}",
        "wow"           => "javascript:prompt('Put it into your realm list:', 'set realmlist {IP}')");
    
        // SOFTWARE PORT IS THE QUERY PORT UNLESS SET
        if (!$this->get_s_port()) {
          $s_port = $this->get_q_port();
        } else {
          $s_port = $this->get_s_port();
        }
				
				if (empty($lgsl_software_link[$this->get_type()])) {
					$link = "javascript:prompt('IP:', '{IP}:{C_PORT}')";
				} else {
					$link = $lgsl_software_link[$this->get_type()];
				}
    
        // INSERT DATA INTO STATIC LINK - CONVERT SPECIAL CHARACTERS - RETURN
        return htmlentities(str_replace(["{IP}", "{C_PORT}", "{Q_PORT}", "{S_PORT}"], [$this->get_ip(), $this->get_c_port(), $this->get_q_port(), $s_port], $link), ENT_QUOTES);
    }
    public function map_password_image() {
      global $lgsl_url_path;
      if ($this->get_status() === self::PASSWORDED) return "{$lgsl_url_path}other/map_overlay_password.gif";
      return "{$lgsl_url_path}other/overlay.gif";
    }
    public function get_map_image($check_exists = true, $id = -1) {
      global $lgsl_file_path, $lgsl_url_path;

      $type = preg_replace("/[^a-z0-9_]/", "_", strtolower($this->get_type()));
      $game = preg_replace("/[^a-z0-9_]/", "_", strtolower($this->get_game()));
      $map  = preg_replace("/[^a-z0-9_]/", "_", strtolower($this->get_map()));
  
      if ($check_exists !== true) { return "{$lgsl_url_path}maps/{$type}/{$game}/{$map}.jpg"; }
  
      if ($this->_base['status']) {
        $path_list = [
        "maps/{$type}/{$game}/{$map}.jpg",
        "maps/{$type}/{$game}/{$map}.gif",
        "maps/{$type}/{$game}/{$map}.png",
        "maps/{$type}/{$map}.jpg",
        "maps/{$type}/{$map}.gif",
        "maps/{$type}/{$map}.png",
        "other/map_no_image.jpg"];
        if ($id > -1) {
          $path_list_id = [
            "other/map_no_image_{$id}.jpg",
            "other/map_no_image_{$id}.gif",
            "other/map_no_image_{$id}.png"];
          $path_list = array_merge($path_list, $path_list_id);
        }
      } else {
        $path_list = [
        "maps/{$type}/map_no_response.jpg",
        "maps/{$type}/map_no_response.gif",
        "maps/{$type}/map_no_response.png",
        "other/map_no_response.jpg"];
        if ($id > -1) {
          $path_list_id = [
            "other/map_no_response_{$id}.jpg",
            "other/map_no_response_{$id}.gif",
            "other/map_no_response_{$id}.png"];
          $path_list = array_merge($path_list, $path_list_id);
        }
      }
  
      foreach ($path_list as $path) {
        if (file_exists("{$lgsl_file_path}{$path}")) { return "{$lgsl_url_path}{$path}"; }
      }
  
      return "#LGSL_DEFAULT_IMAGES_MISSING#";
    }
    public function text_type_game() {
      global $lgsl_config;
      return "[ {$lgsl_config['text']['typ']}: {$this->get_type()} ] [ {$lgsl_config['text']['gme']}: {$this->get_game()} ]";
    }
    public function game_icon() {
      global $lgsl_file_path, $lgsl_url_path;

      $type = preg_replace("/[^a-z0-9_]/", "_", strtolower($this->get_type()));
      $game = preg_replace("/[^a-z0-9_]/", "_", strtolower($this->get_game()));

      $path_list = array(
      "icons/{$type}/{$game}.gif",
      "icons/{$type}/{$game}.png",
      "icons/{$type}/{$type}.gif",
      "icons/{$type}/{$type}.png");

      foreach ($path_list as $path) {
        if (file_exists("{$lgsl_file_path}{$path}")) { return "{$lgsl_url_path}{$path}"; }
      }

      return "{$lgsl_url_path}other/icon_unknown.gif";
    }
    public function icon_status() {
      global $lgsl_url_path;
      switch ($this->get_status()) {
        case self::PENDING: return "{$lgsl_url_path}other/icon_unknown.gif";
        case self::OFFLINE: return "{$lgsl_url_path}other/icon_no_response.gif";
        case self::PASSWORDED: return "{$lgsl_url_path}other/icon_online_password.gif";
        default: return "{$lgsl_url_path}other/icon_online.gif";
      }
    }
    public function location_text() {
      global $lgsl_config;
      return isset($this->_other['location']) ? "{$lgsl_config['text']['loc']} {$this->_other['location']}" : "";
    }
    public function location_icon() {
      global $lgsl_config, $lgsl_file_path, $lgsl_url_path;
  
      if (!isset($this->_other['location']) || !$lgsl_config["locations"]) { return "{$lgsl_url_path}locations/OFF.png"; }
  
      if ($this->_other['location']) {
        $loc = "locations/".strtoupper(preg_replace("/[^a-zA-Z0-9_]/", "_", $this->_other['location'])).".png";
  
        if (file_exists($lgsl_file_path.$loc)) { return $lgsl_url_path.$loc; }
      }
  
      return "{$lgsl_url_path}locations/XX.png";
    }
    public function getLocation() {
      if (isset($this->_other['location'])) return $this->_other['location'];
			return "XX";
    }
    private function _cache_time_index($c) {
      switch ($c) {
        case 'e': $t = 1; break;
        case 'p': $t = 2; break;
        default: $t = 0; break;
      }
      return $t;
    }
    public function set_timestamp($types, $time) {
      if (!isset($this->_server) || !isset($this->_server['cache_time'])) {
        $this->_server['cache_time'] = array(0, 0, 0);
      }
      $types = str_split($types, 1);
      foreach ($types as $type) {
        $this->_server['cache_time'][$this->_cache_time_index($type)] = (int) $time;
      }
    }
    public function get_timestamp($type = 's', $raw = false) {
      global $lgsl_config;
			$time = 0;
      if (isset($this->_server['cache_time'])) {
				if (isset($this->_server['cache_time'][$this->_cache_time_index($type)])) {
					$time = (int) $this->_server['cache_time'][$this->_cache_time_index($type)];
				}
        if ($time > 0) {
					return $raw ? $time : Date($lgsl_config['text']['tzn'], $time);
        }
      }
      return $raw ? $time : 'not queried';
    }
    public function get_timestamps() {
      return isset($this->_server['cache_time']) ? $this->_server['cache_time'] : array();
    }
    public function get_zone() {
      return isset($this->_other['zone']) ? $this->_other['zone'] : "";
    }
    public function set_extra_value($name, $value) {
      $this->_extra[$name] = $value;
    }
    public function set_status($status) {
      $this->_base['status'] = (int) $status;
    }
    public function get_status() {
      if ($this->_base['pending']) {
        return self::PENDING;
      }
      if ($this->_server['password']) {
        return self::PASSWORDED;
      }
      if ($this->_base['status']) {
        return self::ONLINE;
      }
      return self::OFFLINE;
    }
		public function isOnline() {
			$s = $this->get_status();
			return $s === self::PASSWORDED or $s === self::ONLINE;
		}
		public function queryLocation() {
			global $lgsl_config;
      if ($lgsl_config['locations'] !== 1 && $lgsl_config['locations'] !== true) { return $lgsl_config['locations']; }
      $ip = gethostbyname($this->get_ip());  
      if (long2ip(ip2long($ip)) === "255.255.255.255") { return "XX"; }
  
      $url = "http://ip-api.com/json/".urlencode($ip)."?fields=countryCode";
  
      if (function_exists('curl_init') && function_exists('curl_setopt') && function_exists('curl_exec')) {
        $lgsl_curl = curl_init();
  
        curl_setopt($lgsl_curl, CURLOPT_HEADER, 0);
        curl_setopt($lgsl_curl, CURLOPT_TIMEOUT, 2);
        curl_setopt($lgsl_curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($lgsl_curl, CURLOPT_CONNECTTIMEOUT, 2);
        curl_setopt($lgsl_curl, CURLOPT_URL, $url);
  
        $answer = curl_exec($lgsl_curl);
        $answer = json_decode($answer, true);
        $location = (isset($answer["countryCode"]) ? $answer["countryCode"] : "XX");
  
        if (curl_error($lgsl_curl)) { $location = "XX"; }
  
        curl_close($lgsl_curl);
      } else {
        $location = @file_get_contents($url);
      }
  
      if (strlen($location) != 2) { $location = "XX"; }
			
      return $location;
		}
  }
  function lgsl_query_cached($type, $ip, $c_port, $q_port, $s_port, $request, $id = NULL) 
  {
    global $lgsl_config;

    $db = LGSL::db();

    // LOOKUP SERVER

    if ($id != NULL) {
      $id            = intval($id);
      $mysqli_query  = "SELECT * FROM `{$lgsl_config['db']['prefix']}{$lgsl_config['db']['table']}` WHERE `id`='{$id}' LIMIT 1";
    } elseif ($ip != "" && $c_port != "" && ($type == "" || $q_port == "")) {
      list($ip, $c_port) = array($db->escape_string($ip), intval($c_port));
      $mysqli_query  = "SELECT * FROM `{$lgsl_config['db']['prefix']}{$lgsl_config['db']['table']}` WHERE `ip`='{$ip}' AND `c_port`='{$c_port}' LIMIT 1";
    } else {
      list($type, $ip, $c_port, $q_port, $s_port) = array($db->escape_string($type), $db->escape_string($ip), intval($c_port), intval($q_port), intval($s_port));
      if (!$type || !$ip || !$c_port || !$q_port) { exit("LGSL PROBLEM: INVALID SERVER '{$type} : {$ip} : {$c_port} : {$q_port} : {$s_port}'"); }
      $mysqli_query  = "SELECT * FROM `{$lgsl_config['db']['prefix']}{$lgsl_config['db']['table']}` WHERE `type`='{$type}' AND `ip`='{$ip}' AND `q_port`='{$q_port}' LIMIT 1";
    }

    $mysqli_row    = $db->query($mysqli_query, true);
    if (!$mysqli_row) {
      if (strpos($request, "a") === FALSE) { exit("LGSL PROBLEM: SERVER NOT IN DATABASE '{$type} : {$ip} : {$c_port} : {$q_port} : {$s_port}'"); }
      $mysqli_query  = "INSERT INTO `{$lgsl_config['db']['prefix']}{$lgsl_config['db']['table']}` (`type`,`ip`,`c_port`,`q_port`,`s_port`,`cache`,`cache_time`) VALUES ('{$type}','{$ip}','{$c_port}','{$q_port}','{$s_port}','','')";
      $mysqli_result = $db->query($mysqli_query);
      $mysqli_row    = array("id" => mysqli_insert_id(), "zone" => "0", "comment" => "");
    }
    list($type, $ip, $c_port, $q_port, $s_port) = array($mysqli_row['type'], $mysqli_row['ip'], $mysqli_row['c_port'], $mysqli_row['q_port'], $mysqli_row['s_port']);

    // UNPACK CACHE AND CACHE TIMES

    $cache      = empty($mysqli_row['cache'])      ? array()      : unserialize(base64_decode($mysqli_row['cache']));
    $cache_time = empty($mysqli_row['cache_time']) ? array(0,0,0) : explode("_", $mysqli_row['cache_time']);

    // SET THE SERVER AS OFFLINE AND PENDING WHEN THERE IS NO CACHE

    if (empty($cache['b']) || !is_array($cache)) {
      $cache      = array();
      $cache['b'] = array();
      $cache['b']['status']  = 0;
      $cache['b']['pending'] = 1;
    }

    // CONVERT HOSTNAME TO IP WHEN NEEDED

    if ($lgsl_config['host_to_ip']) {
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

    if (empty($cache['o']['location'])) {
      $cache['o']['location'] = $lgsl_config['locations'] ? LGSL::query_location($ip) : "";
    }

    // UPDATE CACHE WITH DEFAULT OFFLINE VALUES

    if (!isset($cache['s'])) {
      $cache['s']               = array();
      $cache['s']['game']       = $type;
      $cache['s']['name']       = $lgsl_config['text']['nnm'];
      $cache['s']['map']        = $lgsl_config['text']['nmp'];
      $cache['s']['players']    = 0;
      $cache['s']['playersmax'] = 0;
      $cache['s']['password']   = 0;
      $cache['s']['cache_time'] = $cache_time[0] == '' ? 0 : $cache_time[0];
      $cache['s']['history']    = array();
    }

    if (!isset($cache['e'])) { $cache['e'] = array(); }
    if (!isset($cache['p'])) { $cache['p'] = array(); }

    // CHECK AND GET THE NEEDED DATA

    $needed = "";

    if (strpos($request, "c") === FALSE) { // CACHE ONLY REQUEST
      if (strpos($request, "s") !== FALSE && time() > ($cache_time[0]+$lgsl_config['cache_time'])) { $needed .= "s"; }
      if (strpos($request, "e") !== FALSE && time() > ($cache_time[1]+$lgsl_config['cache_time'])) { $needed .= "e"; }
      if (strpos($request, "p") !== FALSE && time() > ($cache_time[2]+$lgsl_config['cache_time'])) { $needed .= "p"; }
    }

    if ($needed) {
      // UPDATE CACHE TIMES BEFORE QUERY - PREVENTS OTHER INSTANCES FROM QUERY FLOODING THE SAME SERVER

      $packed_times = time() + $lgsl_config['cache_time'] + 10;
      $packed_times = "{$packed_times}_{$packed_times}_{$packed_times}";
      $mysqli_query  = "UPDATE `{$lgsl_config['db']['prefix']}{$lgsl_config['db']['table']}` SET `cache_time`='{$packed_times}' WHERE `id`='{$mysqli_row['id']}' LIMIT 1";
      $db->query($mysqli_query);

      // GET WHAT IS NEEDED

      $live = lgsl_query_live($type, $ip, $c_port, $q_port, $s_port, $needed);

      if (!$live['b']['status'] && $lgsl_config['retry_offline'] && !$lgsl_config['feed']['method']) {
        $live = lgsl_query_live($type, $ip, $c_port, $q_port, $s_port, $needed);
      }

      // CHECK AND CONVERT TO UTF-8 WHERE NEEDED

      $live = lgsl_charset_convert($live, lgsl_charset_detect($live));

      // IF SERVER IS OFFLINE PRESERVE SOME OF THE CACHE AND CLEAR THE REST

      if (!$live['b']['status']) {
        $live['s']['game']       = $cache['s']['game'];
        $live['s']['name']       = $cache['s']['name'];
        $live['s']['map']        = $cache['s']['map'];
        $live['s']['password']   = $cache['s']['password'];
        $live['s']['players']    = 0;
        $live['s']['playersmax'] = $cache['s']['playersmax'];
        $live['s']['cache_time'] = time();
        $live['e']               = $live['e'] or array();
        $live['p']               = array();
      }

      // WRITING STATS

      if ($lgsl_config['history']) {
        $live['s']['history']    = array();

        if (isset($cache['s']['history'])) {
          foreach ($cache['s']['history'] as $item) {
            if (time() - $item['time'] < 60 * 60 * 25) // NOT OLDER THAN 1 DAY + 1 HOUR
              array_push($live['s']['history'], $item);
          }
          $last = ($cache['s']['history'] ? end($cache['s']['history']) : null);
          if (!$last or time() - $last['time'] >= 60 * 15 ) { // RECORD IF 15 MINS IS PASSED
            array_push($live['s']['history'], array(
              "status"  => (int) $live['b']['status'],
              "time"    => $live['s']['cache_time'],
              "players" => (int) $live['s']['players']
            ));
          }
        }
      }

      // MERGE LIVE INTO CACHE

      if (isset($live['b'])) { $cache['b'] = $live['b']; $cache['b']['pending'] = 0; }
      if (isset($live['s'])) { $cache['s'] = $live['s']; $cache_time[0] = time(); }
      if (isset($live['e'])) { $cache['e'] = $live['e']; $cache_time[1] = time(); }
      if (isset($live['p'])) { $cache['p'] = $live['p']; $cache_time[2] = time(); }

      // UPDATE CACHE

      $packed_cache = $db->escape_string(base64_encode(serialize($cache)));
      $packed_times = $db->escape_string(implode("_", $cache_time));
      $mysqli_query  = "
        UPDATE `{$lgsl_config['db']['prefix']}{$lgsl_config['db']['table']}`
        SET `status`='{$cache['b']['status']}',
            `cache`='{$packed_cache}',
            `cache_time`='{$packed_times}',
            `players`='{$cache['s']['players']}',
            `playersmax`='{$cache['s']['playersmax']}',
            `game`='{$cache['s']['game']}',
            `mode`='{$cache['s']['mode']}',
            `name`='{$cache['s']['name']}',
            `map`='{$cache['s']['map']}'
        WHERE `id`='{$mysqli_row['id']}'
        LIMIT 1";
        $db->query($mysqli_query);
    }

    // RETURN ONLY THE REQUESTED

    if (strpos($request, "s") === FALSE) { unset($cache['s']); }
    if (strpos($request, "e") === FALSE) { unset($cache['e']); }
    if (strpos($request, "p") === FALSE) { unset($cache['p']); }

    return $cache;
  }

//------------------------------------------------------------------------------------------------------------+
//EXAMPLE USAGE: lgsl_query_group( array("request"=>"sep", "hide_offline"=>0, "random"=>0, "type"=>"source", "game"=>"cstrike", "sort"=>"id") )

  function lgsl_query_group($options = array()) {
    if (!is_array($options)) { exit("LGSL PROBLEM: lgsl_query_group OPTIONS MUST BE ARRAY"); }

    global $lgsl_config;

    $db = LGSL::db();

    $request      = isset($options['request'])      ? $options['request']              : "s";
    $zone         = isset($options['zone'])         ? intval($options['zone'])         : 0;
    $hide_offline = isset($options['hide_offline']) ? intval($options['hide_offline']) : intval($lgsl_config['hide_offline'][$zone]);
    $random       = isset($options['random'])       ? intval($options['random'])       : intval($lgsl_config['random'][$zone]);
    $type         = empty($options['type'])         ? ""                               : preg_replace("/[^a-z0-9_]/", "_", strtolower($options['type']));
    $game         = empty($options['game'])         ? ""                               : preg_replace("/[^a-z0-9_]/", "_", strtolower($options['game']));
    $mode         = empty($options['mode'])         ? ""                               : preg_replace("/[^a-z0-9_]/", "_", strtolower($options['mode']));
    $page         = empty($options['page'])         ? ""                               : "LIMIT {$lgsl_config['pagination_lim']} OFFSET " . strval($lgsl_config['pagination_lim']*((int)$options['page'] - 1));
    $default_order= empty($random)                  ? $lgsl_config['sort']['servers']  : "rand()";
    $order        = empty($options['order'])        ? ""                               : $options['order'];
    $sort         = empty($options['sort'])         ? $default_order                   : "{$options['sort']} {$order}";
    $server_limit = empty($random)                  ? 0                                : $random;

                       $mysqli_where   = array("`disabled`=0");
    if ($zone != 0)  { $mysqli_where[] = "FIND_IN_SET('{$zone}',`zone`)"; }
    if ($type != "") { $mysqli_where[] = "`type`='{$type}'"; }

    $mysqli_query  = "SELECT `id` FROM `{$lgsl_config['db']['prefix']}{$lgsl_config['db']['table']}` WHERE ".implode(" AND ", $mysqli_where)." ORDER BY {$sort} {$page}";
    $mysqli_result = $db->query($mysqli_query);
    $server_list  = array();

    foreach ($mysqli_result as $mysqli_row) {
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

  function lgsl_timer($action) {
    global $lgsl_config, $lgsl_timer;

    if (!$lgsl_timer) {
      $microtime  = microtime();
      $microtime  = explode(' ', $microtime);
      $microtime  = $microtime[1] + $microtime[0];
      $lgsl_timer = $microtime - 0.01;
    }

    $time_limit = intval($lgsl_config['live_time']);
    $time_php   = ini_get("max_execution_time");

    if ($time_limit > $time_php) {
      @set_time_limit($time_limit + 5);

      $time_php = ini_get("max_execution_time");

      if ($time_limit > $time_php) {
        $time_limit = $time_php - 5;
      }
    }

    if ($action == "limit") {
      return $time_limit;
    }

    $microtime  = microtime();
    $microtime  = explode(' ', $microtime);
    $microtime  = $microtime[1] + $microtime[0];
    $time_taken = $microtime - $lgsl_timer;

    if ($action == "check") {
      return $time_taken > $time_limit;
    } else {
      return round($time_taken, 2);
    }
  }

//------------------------------------------------------------------------------------------------------------+

  function lgsl_server_misc($server)
  {
    global $lgsl_url_path;

    $misc['icon_details']       = $lgsl_url_path."other/icon_details.gif";
    $misc['icon_game']          = lgsl_icon_game($server['b']['type'], $server['s']['game']);
    $misc['icon_location']      = lgsl_icon_location($server['o']['location']);
    $misc['image_map']          = lgsl_image_map($server['b']['status'], $server['b']['type'], $server['s']['game'], $server['s']['map'], TRUE, $server['o']['id']);
    $misc['image_map_password'] = lgsl_image_map_password($server['b']['status'], $server['s']['password']);
    $misc['text_status']        = lgsl_text_status($server['b']['status'], $server['s']['password'], $server['b']['pending']);
    $misc['text_type_game']     = lgsl_text_type_game($server['b']['type'], $server['s']['game']);
    $misc['text_location']      = lgsl_text_location($server['o']['location']);
    $misc['name_filtered']      = lgsl_string_html($server['s']['name'], FALSE, 20); // LEGACY

    return $misc;
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

    if (!$password || !$status) { return "{$lgsl_url_path}other/overlay.gif"; }

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

    switch($lgsl_config['sort']['servers']){

      case "id":      { usort($server_list, "lgsl_sort_servers_by_id");      break; }
      case "zone":    { usort($server_list, "lgsl_sort_servers_by_zone");    break; }
      case "type":    { usort($server_list, "lgsl_sort_servers_by_type");    break; }
      case "status":  { usort($server_list, "lgsl_sort_servers_by_status");  break; }
      case "players": { usort($server_list, "lgsl_sort_servers_by_players"); break; }
      
    }

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

  function lgsl_sort_extras(&$server)
  {
    if (!is_array($server['e'])) { return $server; }

    ksort($server['e']);

    return $server;
  }

//------------------------------------------------------------------------------------------------------------+

  function lgsl_sort_players($server)
  {
    global $lgsl_config;

    if (!isset($server['p']) or !is_array($server['p'])) { return $server; }

    if     ($lgsl_config['sort']['players'] == "name")  { usort($server['p'], "tltneon\LGSL\lgsl_sort_players_by_name");  }
    elseif ($lgsl_config['sort']['players'] == "score") { usort($server['p'], "tltneon\LGSL\lgsl_sort_players_by_score"); }
    elseif ($lgsl_config['sort']['players'] == "time") { usort($server['p'], "tltneon\LGSL\lgsl_sort_players_by_time"); }

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
    if((isset($player_a['time']))&&(isset($player_b['time'])))
    {
      if ($player_a['time'] == $player_b['time']) { return 0; }

      return ($player_a['time'] < $player_b['time']) ? 1 : -1;
    }
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
      //$server = @iconv('UTF-8', 'UTF-8//TRANSLIT//IGNORE', $server);
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

  function lgsl_string_html($string = "", $xml_feed = FALSE, $word_wrap = 0)
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

  function lgsl_build_link_params($url, $params)
  {
    // IS NO PARAMS

    if (!strpos($url, '?')) {
      return "{$url}?" . http_build_query($params);
    }

    // IS '?' EXISTS
    $args = array('game', 'type', 'mode', 'sort', 'order', 'page');
    foreach ($args as $a) {
      if (isset($params[$a])) {
        if (strpos($url, "page=")) {
          $url = preg_replace("/page=\d+/", "{$a}={$params[$a]}", $url);
        } elseif (strpos($url, "{$a}=")) {
          $url = preg_replace("/{$a}=([\w\d\_\-])+/", "{$a}={$params[$a]}", $url);
        } else {
          $url .= "&{$a}={$params[$a]}";
        }
      }
    }

    return $url;
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

  global $lgsl_file_path, $lgsl_url_path, $lgsl_config;

  $lgsl_file_path = lgsl_file_path();

  require $lgsl_file_path."lgsl_config.php";
  require $lgsl_file_path."lgsl_protocol.php";

  $auth   = md5($_SERVER['REMOTE_ADDR'].md5($lgsl_config['admin']['user'].md5($lgsl_config['admin']['pass'])));
  $cookie = isset($_COOKIE['lgsl_admin_auth']) ? $_COOKIE['lgsl_admin_auth'] : "";
  $lgsl_url_path = lgsl_url_path();

  if (isset($_GET['lgsl_debug']) and $auth === $cookie)
  {
    echo "<details>
            <summary style='margin-bottom: 12px;'>
              Open debug infos
            </summary>
            <hr /><pre>".print_r($_SERVER, TRUE)."</pre>
            <hr />#d0# ".__FILE__."
            <hr />#d1# ".@realpath(__FILE__)."
            <hr />#d2# ".dirname(__FILE__)."
            <hr />#d3# {$lgsl_file_path}
            <hr />#d4# {$_SERVER['DOCUMENT_ROOT']}
            <hr />#d5# ".@realpath($_SERVER['DOCUMENT_ROOT'])."
            <hr />#d6# {$lgsl_url_path}
            <hr />#c0# {$lgsl_config['url_path']}
            <hr />#c1# {$lgsl_config['no_realpath']}
            <hr />#c2# {$lgsl_config['feed']['method']}
            <hr />#c3# {$lgsl_config['feed']['url']}
            <hr />#c4# {$lgsl_config['cache_time']}
            <hr />#c5# {$lgsl_config['live_time']}
            <hr />#c6# {$lgsl_config['timeout']}
            <hr />#c7# {$lgsl_config['cms']}
            <hr />
          </details>
          <select onchange='javascript:document.querySelector(\"link[rel=stylesheet]\").href = \"lgsl_files/styles/\" + this.value + \".css\"'>
            <option value='breeze_style'>breeze_style</option>
            <option value='classic_style'>classic_style</option>
            <option value='cards_style'>cards_style</option>
            <option value='disc_ff_style'>disc_ff_style</option>
            <option value='material_style'>material_style</option>
            <option value='ogp_style'>ogp_style</option>
            <option value='parallax_style'>parallax_style</option>
            <option value='wallpaper_style'>wallpaper_style</option>
            <option value='darken_style'>darken_style</option>
          </select>";
  }

  if (!isset($lgsl_config['locations']))
  {
    exit("LGSL PROBLEM: lgsl_config.php FAILED TO LOAD OR MISSING ENTRIES");
  }

//------------------------------------------------------------------------------------------------------------+
