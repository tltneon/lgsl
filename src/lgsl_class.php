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

      $total = ["players"=>0, "playersmax"=>0, "servers"=>0, "servers_online"=>0, "servers_offline"=>0];

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
    static function realpath($path)
    {
      global $lgsl_config;
      return $lgsl_config['no_realpath'] ? $path : realpath($path);
    }
    static function build_link($url, $params)
    {
      if (!strpos($url, '?')) { // IS NO PARAMS
        return "{$url}?" . http_build_query($params);
      }
      $args = ['game', 'type', 'mode', 'sort', 'order', 'page']; // IS '?' EXISTS
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

    public function connect($type = null) {
      global $lgsl_config, $lgsl_file_path;
			if ($type == null) {
				$type = $lgsl_config['db']['type'];
			}
      if ($lgsl_config['cms'] !== 'sa') {
        $this->load_cms_config();
      }
			if ($type === 'mysql') {
				$this->_connection = new MysqlWrapper();
			} else {
				$this->_connection = new SqliteWrapper();					
			}
			$this->_connection->connect();
      if ($this->get_error()) {
        return null;
      }
      if ($lgsl_config['db']['db'] != '') {
				$this->_db = $lgsl_config['db']['db'];
				$this->select_db();
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
    public function clear() {
      $this->_connection->clear();
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
      $result = $this->_connection->query($string);
      if ($result === false) {
        printf("Connect failed: %s\n", $this->_connection->get_error());
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
      $result = $this->_connection->execute($string) || $this->_connection->get_error();
      return $result;
    }
    function get_error() {
      return $this->_connection->get_error();
    }
    function escape_string($string) {
      return $this->_connection->escape_string($string);
    }
		function get_all() {
			return $this->_connection->get_all();
		}

    public function load_server($query) {
      $result = $this->query($query, true);
      if ($result) {
        return $this->lgsl_unserialize_server_data($result);
      }
      return null;
    }
    function get_server_by_id($id) {
			return $this->load_server($this->_connection->get_server_by_id_query_string($id));
    }

    function get_server_by_ip($ip, $c_port) {
      global $lgsl_config;
			if ($c_port > 1) $c_port = "and c_port = {$c_port}";
			else $c_port = "";
      return $this->load_server("SELECT * FROM {$lgsl_config['db']['prefix']}{$lgsl_config['db']['table']} WHERE ip = '{$ip}' {$c_port};");
    }
    
    static function get_servers_group($options = []) {
      global $lgsl_config;
      $db = LGSL::db();

      $ip           = isset($options['ip'])           ? $options['ip']                   : (int) $lgsl_config['pagination_lim'];
      $port         = isset($options['port'])         ? (int) $options['port']           : (int) $lgsl_config['pagination_lim'];
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
      $status = (int) ($server->get_status() === Server::ONLINE);
      $mysqli_query  = "
        UPDATE `{$lgsl_config['db']['prefix']}{$lgsl_config['db']['table']}`
        SET `status`='{$status}',
            `cache`='{$packed_cache}',
            `cache_time`='{$packed_times}',
            `players`='{$server->get_players_count('active')}',
            `playersmax`='{$server->get_players_count('max')}',
            `game`='{$server->get_game()}',
            `mode`='{$this->escape_string($server->get_mode())}',
            `name`='{$this->escape_string($server->get_name())}',
            `map`='{$server->get_map()}'
        WHERE `id` = '{$server->get_id()}'
        ";
        $this->execute($mysqli_query);
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
        $server['e'] = $cache['e'];
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
  abstract class DBWrapper {
		protected $_connection;
    public $_id = 'id';
		public function select_db() {}
		public function set_charset($c) {}
		public function clear() {
			global $lgsl_config;
			$this->execute("TRUNCATE TABLE `{$lgsl_config['db']['prefix']}{$lgsl_config['db']['table']}`;");
		}
  }
	class MysqlWrapper extends DBWrapper {
		public function connect() {
			global $lgsl_config;
			$this->_connection = new \mysqli($lgsl_config['db']['server'], $lgsl_config['db']['user'], $lgsl_config['db']['pass']);
		}
		public function select_db() {
			global $lgsl_config;
			$this->_connection->select_db($lgsl_config['db']['db']);
		}
		public function set_charset($charset) {
			$this->_connection->set_charset($charset);
		}
    public function query($string) {
      $result = $this->_connection->query($string);
      return new MysqlResultWrapper($result);
    }
		public function execute($string) {
			//echo $string;
			return $this->_connection->query($string);
		}
		public function get_error() {
			if ($this->_connection->connect_errno === 0) return null;
			return "{$this->_connection->connect_error} ({$this->_connection->connect_errno})";
		}
		public function get_all() {
			global $lgsl_config;
			$t = $this->query("SELECT * FROM `{$lgsl_config['db']['prefix']}{$lgsl_config['db']['table']}`;");
			return $t->fetch_all(MYSQLI_ASSOC);
		}
		public function escape_string($string) {
			return $this->_connection->escape_string($string);
		}
		public function get_server_by_id_query_string($id) {
      global $lgsl_config;
      return "SELECT * FROM {$lgsl_config['db']['prefix']}{$lgsl_config['db']['table']} WHERE id = {$id};";
		}
	}
	abstract class ResultWrapper {
		public $_result;
		function __construct($r) {
			$this->_result = $r;
		}
		public function fetch_all() {
			return $this->_result;
		}
		public function fetch_array() {
			return $this->_result;
		}
	}
	class MysqlResultWrapper extends ResultWrapper {
		public function fetch_all() {
			if ($this->_result == false) return $ret;
			return $this->_result->fetch_all(MYSQLI_ASSOC);
		}
		public function fetch_array() {
			return $this->_result->fetch_array(MYSQLI_ASSOC);
		}
	}
	class SqliteWrapper extends DBWrapper {
    public $_id = 'rowid';
		public function connect() {
			global $lgsl_file_path, $lgsl_config;
			$this->_connection = new \SQLite3("$lgsl_file_path/{$lgsl_config['db']['db']}.db");
		}
		public function get_error() {
			if ($this->_connection->lastErrorCode())
				return $this->_connection->lastErrorMsg();
			return null;
		}
		public function clear() {
			global $lgsl_config;
			$this->execute("DELETE FROM `{$lgsl_config['db']['prefix']}{$lgsl_config['db']['table']}`;");
		}
		public function escape_string($string) {
			return $this->_connection->escapeString($string);
		}
		public function query($string) {
			$string = str_replace("SELECT ", "SELECT `rowid` as id, ", $string);
			return new SqliteResultWrapper($this->_connection->query($string));
		}
		public function execute($string) {
			$string = str_replace("WHERE `id`", "WHERE `rowid`", $string);
			$this->_connection->exec($string);
		}
		public function get_all() {
			global $lgsl_config;
			//return 
			$t = $this->query("SELECT rowid as id, * FROM `{$lgsl_config['db']['prefix']}{$lgsl_config['db']['table']}`;");
			return $t->fetch_all();
		}
		public function get_server_by_id_query_string($id) {
      global $lgsl_config;
      return "SELECT rowid as id, * FROM {$lgsl_config['db']['prefix']}{$lgsl_config['db']['table']} WHERE rowid = {$id};";
		}
	}
	class SqliteResultWrapper extends ResultWrapper {
		public function fetch_all() {
			$ret = [];
			if ($this->_result == false) return $ret;
			while ($r = $this->_result->fetchArray(SQLITE3_ASSOC)) {
				array_push($ret, $r);
			}
			return $ret;
		}
		public function fetch_array() {
			if ($this->_result == false) return [];
			return $this->_result->fetchArray(SQLITE3_ASSOC);
		}
	}
//------------------------------------------------------------------------------------------------------------+
  class Server {
		public const ONLINE = "onl";
		public const OFFLINE = "nrs";
		public const PASSWORDED = "pwd";
		public const PENDING = "pen";
    private $_base;
    private $_extra = [];
    private $_other;
    private $_server;
    private $_players = [];
    private $_history = [];
    private $_valid = false;
    
    function __construct($options = []) {
      $this->_base = array_merge([
        "id" => 0,
        "ip" => "",
        "c_port" => 0,
        "q_port" => 0,
        "s_port" => 0,
        "type" => "",
        "status" => 0,
        "pending" => 1
      ], $options);
      $this->_server = [
        "players" => 0,
        "playersmax" => 0,
        "name" => "--",
        "game" => "",
        "mode" => "none",
        "password" => 0
      ];
      $this->_other = [
        "zone" => null,
        "comment" => ''
      ];
    }
    
    public function lgsl_cached_query($request = 'seph') {
      $db = LGSL::db();
      if ($this->_base['id']) {
        $result = $db->get_server_by_id($this->_base['id']);
      } elseif ($this->_base['ip']) {
        $result = $db->get_server_by_ip($this->_base['ip'], $this->_base['c_port']);
      }
      if ($result) {
        $this->from_array($result);
        $this->validate();
				if (!LGSL::requestHas($request, "c")) { // CACHE ONLY REQUEST
					global $lgsl_config;
					$needed = "";
					if (LGSL::requestHas($request, "s") && time() > ($this->get_timestamp('s', true) + $lgsl_config['cache_time'])) { $needed .= "s"; }
					if (LGSL::requestHas($request, "e") && time() > ($this->get_timestamp('e', true) + $lgsl_config['cache_time'])) { $needed .= "e"; }
					if (LGSL::requestHas($request, "p") && time() > ($this->get_timestamp('p', true) + $lgsl_config['cache_time'])) { $needed .= "p"; }
					if (LGSL::requestHas($request, "h")) { $needed .= "h"; }
					if ($needed) {
						$this->lgsl_live_query($needed);
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
        if (!$last || time() - $last['t'] >= 60 * 15) { // RECORD IF 15 MINS IS PASSED
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
      $server = [];
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
    public function get_c_port($intOnly = true) {
      if ($this->_base['c_port'] > 1)
        return $this->_base['c_port'];
			if ($intOnly) return 0;
      return "--";
    }
    public function get_q_port($intOnly = true) {
      if ($this->_base['q_port'] > 1)
        return $this->_base['q_port'];
			if ($intOnly) return 0;
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
			if ($html) {
				$d = LGSL::DB();
				return $d->escape_string($this->_server['name']);
			}				
      return $this->_server['name'];
    }
    public function set_name($name) {
      $this->_server['name'] = $name;
    }
    public function get_players_count($out = null) {
      if ($this->get_pending() || $this->get_status() === self::OFFLINE) {
        return $out ? 0 : "--";
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
		public function get_player_names() {
			if ($this->get_players_count('active') > 0) {
				return array_reduce($this->get_players(), function($a, $c) {
					$a[] = $c['name'];
					return $a;
				}, []);
			}
			else return [];
		}

    public function get_software_link() {
      $lgsl_software_link = [
        "arma3"         => "steam://connect/{IP}:{C_PORT}",
        "callofdutyiw"  => "javascript:prompt('Put it into console:', 'connect {IP}:{C_PORT}')",
        "callofduty4"   => "cod4://{IP}:{S_PORT}",
        "conanexiles"   => "steam://connect/{IP}:{C_PORT}",
        "cs2d"          => "steam://connect/{IP}:{C_PORT}",
        "discord"       => "https://discord.gg/{IP}",
        "factorio"      => "steam://connect/{IP}",
        "farmsim"       => "steam://connect/{IP}:{C_PORT}",
        "fivem"         => "fivem://connect/{IP}:{C_PORT}",
        "gtac"          => "gtac://connect/{IP}:{C_PORT}/gta:{GAME}",
        "halflife"      => "steam://connect/{IP}:{C_PORT}",
        "halflifewon"   => "steam://connect/{IP}:{C_PORT}",
        "jc2mp"         => "steam://connect/{IP}:{C_PORT}",
        "killingfloor"  => "steam://connect/{IP}:{C_PORT}",
        "mafiac"        => "mafiac://connect/{IP}:{C_PORT}/mafia:{GAME}",
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
        "wow"           => "javascript:prompt('Put it into your realm list:', 'set realmlist {IP}')"];
    
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
        return htmlentities(str_replace(["{IP}", "{C_PORT}", "{Q_PORT}", "{S_PORT}", "{GAME}"], [$this->get_ip(), $this->get_c_port(), $this->get_q_port(), $s_port, $this->get_game()], $link), ENT_QUOTES);
    }
		public function add_url_path($path = '') {
      global $lgsl_url_path;
			return "$lgsl_url_path$path";
		}
		public function add_file_path($path = '') {
			global $lgsl_file_path;
			return "$lgsl_file_path$path";
		}
    public function map_password_image() {
      if ($this->get_status() === self::PASSWORDED) return "{$lgsl_url_path}other/map_overlay_password.gif";
      return "{$this->add_url_path()}other/overlay.gif";
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
    public function game_icon($path = '') {
      $type = preg_replace("/[^a-z0-9_]/", "_", strtolower($this->get_type()));
      $game = preg_replace("/[^a-z0-9_]/", "_", strtolower($this->get_game()));

      $path_list = [
      "icons/{$type}/{$game}.gif",
      "icons/{$type}/{$game}.png",
      "icons/{$type}/{$type}.gif",
      "icons/{$type}/{$type}.png"];

      foreach ($path_list as $icon_path) {
        if (file_exists("$path$icon_path")) { return "$path$icon_path"; }
      }

      return "{$path}other/icon_unknown.gif";
    }
    public function icon_status($path = '') {
      global $lgsl_url_path;
      switch ($this->get_status()) {
        case self::PENDING: return "{$path}other/icon_unknown.gif";
        case self::OFFLINE: return "{$path}other/icon_no_response.gif";
        case self::PASSWORDED: return "{$path}other/icon_online_password.gif";
				default: return "{$path}other/icon_online.gif";
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
        case 'e': return 1;
        case 'p': return 2;
        default: return 0;
      }
    }
    public function set_timestamp($types, $time) {
      if (!isset($this->_server) || !isset($this->_server['cache_time'])) {
        $this->_server['cache_time'] = [0, 0, 0];
      }
      $types = str_split($types, 1);
      foreach ($types as $type) {
        $this->_server['cache_time'][$this->_cache_time_index($type)] = (int) $time;
      }
    }
    public function get_timestamp($type = 's', $raw = false) {
			$time = 0;
      if (isset($this->_server['cache_time'])) {
				if (isset($this->_server['cache_time'][$this->_cache_time_index($type)])) {
					$time = (int) $this->_server['cache_time'][$this->_cache_time_index($type)];
				}
        if ($time > 0) {
					global $lgsl_config;
					return $raw ? $time : Date($lgsl_config['text']['tzn'], $time);
        }
      }
      return $raw ? $time : 'not queried';
    }
    public function set_timestamps($cache_time) {
      $this->_server['cache_time'] = $cache_time;
    }
    public function get_timestamps() {
      return isset($this->_server['cache_time']) ? $this->_server['cache_time'] : [];
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
			return $s === self::PASSWORDED || $s === self::ONLINE;
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
        $location = $answer["countryCode"] ?? "XX";
  
        if (curl_error($lgsl_curl)) { $location = "XX"; }
  
        curl_close($lgsl_curl);
      } else {
        $location = @file_get_contents($url);
      }
  
      if (strlen($location) != 2) { $location = "XX"; }
			
      return $location;
		}
		public function sort_player_fields() {
			//------------------------------------------------------------------------------------------------------------+
			// THIS CONTROLS HOW THE PLAYER FIELDS ARE DISPLAYED

				$fields_show  = ["name", "score", "kills", "deaths", "team", "ping", "bot", "time"]; // ORDERED FIRST
				$fields_hide  = ["teamindex", "pid", "pbguid"]; // REMOVED
				$fields_other = TRUE; // FALSE TO ONLY SHOW FIELDS IN $fields_show

				$fields_list = [];

				if ($this->get_players_count('active') == 0) { return $fields_list; }

				foreach ($this->get_players() as $player)
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
      $base_path = LGSL::realpath($_SERVER['DOCUMENT_ROOT']);
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

    $lgsl_path = dirname(LGSL::realpath(__FILE__));
    $lgsl_path = str_replace("\\", "/", $lgsl_path);

    // REMOVE ANY TRAILING SLASHES

    if (substr($base_path, -1) == "/") { $base_path = substr($base_path, 0, -1); }
    if (substr($lgsl_path, -1) == "/") { $lgsl_path = substr($lgsl_path, 0, -1); }

    // USE THE DIFFERENCE BETWEEN PATHS

    if (substr($lgsl_path, 0, strlen($base_path)) == $base_path)
    {
      $url_path = substr($lgsl_path, strlen($base_path));

      return "$host_path$url_path/";
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

  require "{$lgsl_file_path}lgsl_config.php";
  require "{$lgsl_file_path}lgsl_protocol.php";

  $auth   = md5($_SERVER['REMOTE_ADDR'].md5($lgsl_config['admin']['user'].md5($lgsl_config['admin']['pass'])));
  $cookie = $_COOKIE['lgsl_admin_auth'] ?? "";
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

//------------------------------------------------------------------------------------------------------------+
