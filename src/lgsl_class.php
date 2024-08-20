<?php
  namespace tltneon\LGSL;

 /*----------------------------------------------------------------------------------------------------------\
 |                                                                                                            |
 |                      [ LIVE GAME SERVER LIST ] [ RICHARD PERRY FROM GREYCUBE.COM ]                         |
 |                                                                                                            |
 |    Released under the terms and conditions of the GNU General Public License Version 3 (http://gnu.org)    |
 |                                                                                                            |
 \-----------------------------------------------------------------------------------------------------------*/

  if (!function_exists('lgsl_url_path')) { // START OF DOUBLE LOAD PROTECTION
  abstract class LGSL {
    const NONE = "--";
    const VERSION = "7.0.0";
    static function db() {
      $db = new Database();
      $db->instance();
      $db->connect();
      return $db;
    }
    static function link($s = "", $p = "") {
      global $lgsl_config, $lgsl_url_path;
      $index = $lgsl_config['direct_index'] ? "index.php" : "";
      if ($lgsl_config['cms'] === "sa") {
        return "{$lgsl_url_path}../{$index}" . ($s ? ($p ? "?ip={$s}&port={$p}" : "?s={$s}") : "");
      }

      switch ($lgsl_config['cms']) {
        case "e107": $link = e_PLUGIN_ABS . "lgsl/{$index}" . ($s ? "?s={$s}" : ""); break;
        case "joomla": $link = JRoute::_("index.php?option=com_lgsl" . ($s ? "&s={$s}" : "")); break;
        case "drupal": $link = url("LGSL" . ($s ? "/{$s}" : "")); break;
        case "phpnuke": $link = "modules.php?name=LGSL" . ($s ? "&s={$s}" : ""); break;
      }
      return $link;
    }
    static function filePath() {
      $lgsl_path = __FILE__; // GET THE LGSL_CLASS.PHP PATH
      $lgsl_path = dirname($lgsl_path)."/"; // SHORTEN TO JUST THE FOLDERS AND ADD TRAILING SLASH
      return str_replace("\\", "/", $lgsl_path); // CONVERT WINDOWS BACKSLASHES TO FORWARDSLASHES
    }
    static function urlPath() {
      global $lgsl_config;
      if ($lgsl_config['url_path']) { // CHECK IF PATH HAS BEEN SET IN CONFIG
        return $lgsl_config['url_path'];
      }

      $host_path  = (!isset($_SERVER['HTTPS']) || strtolower($_SERVER['HTTPS']) != "on") ? "http://" : "https://"; // USE FULL DOMAIN PATH TO AVOID ALIAS PROBLEMS
      $host_path .= $_SERVER['HTTP_HOST'] ?? "";

      // GET FULL PATHS ( EXTRA CODE FOR WINDOWS AND IIS - NO DOCUMENT_ROOT - BACKSLASHES - DOUBLESLASHES - ETC )
      if ($_SERVER['DOCUMENT_ROOT']) {
        $base_path = str_replace("\\", "/", LGSL::realpath($_SERVER['DOCUMENT_ROOT']));
        $base_path = str_replace("//", "/", $base_path);
      } else {
        $file_path = str_replace("\\", "/", $_SERVER['SCRIPT_NAME']);
        $file_path = str_replace("//", "/", $file_path);

        $base_path = str_replace("\\", "/", $_SERVER['PATH_TRANSLATED']);
        $base_path = str_replace("//", "/", $base_path);
        $base_path = substr($base_path, 0, -strlen($file_path));
      }

      $lgsl_path = dirname(LGSL::realpath(__FILE__));
      $lgsl_path = str_replace("\\", "/", $lgsl_path);

      // REMOVE ANY TRAILING SLASHES
      if (substr($base_path, -1) == "/") { $base_path = substr($base_path, 0, -1); }
      if (substr($lgsl_path, -1) == "/") { $lgsl_path = substr($lgsl_path, 0, -1); }

      if (substr($lgsl_path, 0, strlen($base_path)) == $base_path) { // USE THE DIFFERENCE BETWEEN PATHS
        $url_path = substr($lgsl_path, strlen($base_path));
        return "$host_path$url_path/";
      }
      return "/#LGSL_PATH_PROBLEM#{$base_path}#{$lgsl_path}#/";
    }
    static function locationLink($location) {
      if (!$location) { return "#"; }
      return "https://www.google.com/maps/search/{$location}/";
    }
    static function locationCode(string $ip): string {
      global $lgsl_config;
      if ($lgsl_config['locations'] !== 1 && $lgsl_config['locations'] !== true) { return $lgsl_config['locations']; }
      $ip = gethostbyname($ip);
      if (long2ip(ip2long($ip)) == "255.255.255.255") { return "XX"; }
      $url = "http://ip-api.com/json/".urlencode($ip)."?fields=countryCode";
  
      if (LGSL::isEnabled("curl")) {
        $stream = new Stream(PROTOCOL::HTTP);
        $stream->open();
        $stream->write($url);
        $answer = $stream->readJson();
        $location = $answer["countryCode"] ?? "XX";
        $stream->close();
      } else {
        $location = @file_get_contents($url);
      }
  
      if (strlen($location) != 2) { $location = "XX"; }
  
      return $location;
    }
    static public function groupTotals($server_list = FALSE) {
      if (!is_array($server_list)) { return Database::getStatistics(); }

      $total = ["players"=>0, "playersmax"=>0, "servers"=>0, "servers_online"=>0, "servers_offline"=>0];

      foreach ($server_list as $server) {
        $total['players']    += $server->getPlayersCount();
        $total['playersmax'] += $server->getPlayersMaxCount();

        $total['servers']++;
        if ($server->isOnline()) {
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
    static function realpath($path) {
      global $lgsl_config;
      return $lgsl_config['no_realpath'] ? $path : realpath($path);
    }
    static function buildLink($url, $params) {
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
		static public function isEnabled($func) {
			switch ($func) {
        case "curl": return function_exists('curl_init') && function_exists('curl_setopt') && function_exists('curl_exec');
        case "gd": return extension_loaded('gd');
      }
		}
    static public function locationsCodes($sort = true) {
      $arr = [
        "AD","AE","AF","AG","AI","AL","AM","AN","AO","AR","AS","AT","AU","VG",
        "AW","AX","AZ","BA","BB","BD","BE","BF","BG","BH","BI","BJ","BM","VI",
        "BN","BO","BR","BS","BT","BV","BW","BY","BZ","CA","CC","CD","CF","VN",
        "CG","CH","CI","CK","CL","CM","CN","CO","CR","CS","CU","CV","CX","VU",
        "CY","CZ","DE","DJ","DK","DM","DO","DZ","EC","EE","EG","EH","ER","WF",
        "ES","ET","EU","FI","FJ","FK","FM","FO","FR","GA","GB","GD","GE","WS",
        "GF","GH","GI","GL","GM","GN","GP","GQ","GR","GS","GT","GU","GW","XX",
        "GY","HK","HM","HN","HR","HT","HU","ID","IE","IL","IN","IO","IQ","YE",
        "IR","IS","IT","JM","JO","JP","KE","KG","KH","KI","KM","KN","KP","YT",
        "KR","KW","KY","KZ","LA","LB","LC","LI","LK","LR","LS","LT","LU","ZA",
        "LV","LY","MA","MC","MD","ME","MG","MH","MK","ML","MM","MN","MO","ZM",
        "MP","MQ","MR","MS","MT",  "","MU","MV","MW","MX","MY","MZ","NA","ZW",
        "NC","NE","NF","NG","NI","NL","NO","NP","NR","NU","NZ","OFF","OM","",
        "PA","PE","PF","PG","PH","PK","PL","PM","PN","PR","PS","PT","PW","",
        "PY","QA","RE","RO","RS","RU","RW","SA","SB","SC","SD","SE","SG","",
        "SH","SI","SJ","SK","SL","SM","SN","SO","SR","ST","SV","SY","SZ","",
        "TC","TD","TF","TG","TH","TJ","TK","TL","TM","TN","TO","TR","TT","",
        "TV","TW","TZ","UA","UG","UK","UM","US","UY","UZ","VA","VC","VE"];
      if ($sort) {
        sort($arr);
        return array_filter($arr, fn($value) => !is_null($value) && $value !== '');
      }
      return $arr;
    }
		static public function locationCoords($code) {
      $a = array_search($code, self::locationsCodes(false));
      return [$a % 14 * 16, floor($a / 14) * 11];
		}
    static public function normalizeString($string) {
      return preg_replace("/[^a-z0-9_]/", "_", strtolower($string));
    }
  }
//------------------------------------------------------------------------------------------------------------+
  class Database {
    public const ASSOC = 0;
    public const NUM = 1;
    public const BOTH = 2;
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
      global $lgsl_config;
			if ($type == null) {
				$type = $lgsl_config['db']['type'];
			}
      if ($lgsl_config['cms'] !== 'sa') {
        $this->loadCmsConfig();
      }
      $types = [
        'mysql' => 'tltneon\LGSL\MysqlWrapper',
        'sqlite' => 'tltneon\LGSL\SqliteWrapper',
        'postgres' => 'tltneon\LGSL\PostgresWrapper'
      ];
      $this->_connection = new $types[$type]();
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

    public function loadCmsConfig() {
      global $lgsl_config, $lgsl_file_path;
      switch ($lgsl_config['cms']) {
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
          $joomla_config = new \JConfig();
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
    function query($string, $single_result = false, $mode = Database::ASSOC) {
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


    public function loadServer(Server &$server): void {
      global $lgsl_config;
      $query = "SELECT * FROM {$lgsl_config['db']['prefix']}{$lgsl_config['db']['table']} WHERE ";
      if ($server->getId()) {
        $query .= "id = '{$server->getId()}';";
      } elseif ($server->getIp()) {
        $c_port = $server->getConnectionPort() > 1 ? "AND c_port = '{$server->getConnectionPort()}'" : "";
        $query .= "ip = '{$server->getIp()}' {$c_port};";
      }
      $result = $this->query($query, true);
      if ($result) {
        $server->fromArray($this->unserializeData($result));
      }
    }
    
    static function getServersGroup($options = []) {
      global $lgsl_config;
      $db = LGSL::db();

      $ip           = isset($options['ip'])           ? $options['ip']                   : (int) $lgsl_config['pagination_lim'];
      $port         = isset($options['port'])         ? (int) $options['port']           : (int) $lgsl_config['pagination_lim'];
      $limit        = isset($options['limit'])        ? (int) $options['limit']          : (int) $lgsl_config['pagination_lim'];
      $request      = isset($options['request'])      ? $options['request']              : "s";
      $zone         = isset($options['zone'])         ? (int) $options['zone']           : 0;
      $hide_offline = isset($options['hide_offline']) ? (int) $options['hide_offline']   : (int) $lgsl_config['hide_offline'][$zone];
      $random       = isset($options['random'])       ? (int) $options['random']         : (int) $lgsl_config['random'][$zone];
      $type         = empty($options['type'])         ? ""                               : LGSL::normalizeString($options['type']);
      $game         = empty($options['game'])         ? ""                               : LGSL::normalizeString($options['game']);
      $mode         = empty($options['mode'])         ? ""                               : LGSL::normalizeString($options['mode']);
      $page         = empty($options['page'])         ? ""                               : "LIMIT {$limit} OFFSET " . strval($limit*((int)$options['page'] - 1));
      $status       = empty($options['status'])       ? ""                               : 1;
      $order        = empty($options['order'])        ? ""                               : $options['order'];
      $sort         = empty($options['sort'])         ? ""                               : (in_array($options['sort'], ['ip', 'name', 'map', 'players']) ? $options['sort'] : "");
      $server_limit = empty($options['limit'])        ? ""                               : $lgsl_config['pagination_lim'];
      $server_limit = empty($random)                  ? $server_limit                    : $random;

                           $where   = ["`disabled`=0"];
      if ($zone != 0)    { $where[] = "FIND_IN_SET('{$zone}',`zone`)"; }
      if ($type != "")   { $where[] = "`type`='{$type}'"; }
      if ($game != "")   { $where[] = "`game`='{$game}'"; }
      if ($mode != "")   { $where[] = "`mode`='{$mode}'"; }
      if ($status != "") { $where[] = "`status`={$status}"; }
      if ($server_limit != "") { $server_limit = "LIMIT {$server_limit}"; }
      if ($sort != "") { $sort = "ORDER BY {$options['sort']} {$order}"; }

      $result = $db->query("SELECT * FROM `{$lgsl_config['db']['prefix']}{$lgsl_config['db']['table']}` WHERE ".implode(" AND ", $where)." {$sort} {$server_limit} {$page}");

      $output = [];
      foreach ($result as $s) {
        $server = new Server();
        $server->fromArray($db->unserializeData($s));

				if (!LGSL::requestHas($request, "c") && !LGSL::timer("check")) { // CACHE ONLY REQUEST
					if ($server->checkTimestamps($request)) {
						$server->queryLive($request);
						$db->saveServer($server);
					}
				}
        $output[] = $server;
      }
      return $output;
    }
    static public function getStatistics() {
      global $lgsl_config;
      $db = LGSL::db();

      $query  = "SELECT COUNT(*) as servers, SUM(players) as players, SUM(playersmax) as playersmax, SUM(STATUS) as servers_online, COUNT(*)-SUM(status) as servers_offline FROM `{$lgsl_config['db']['prefix']}{$lgsl_config['db']['table']}` WHERE disabled = 0;";
      return $db->query($query, true);
    }

    function saveServer(&$server) {
      global $lgsl_config;
      $packed_cache = $this->escape_string(base64_encode(serialize($server->toArray())));
      $status = (int) ($server->getStatus() === Server::ONLINE);
      $this->execute("
        UPDATE `{$lgsl_config['db']['prefix']}{$lgsl_config['db']['table']}`
        SET `status`='{$status}',
            `cache`='{$packed_cache}',
            `cache_time`='{$server->getTimestamps()}',
            `players`='{$server->getPlayersCount()}',
            `playersmax`='{$server->getPlayersMaxCount()}',
            `game`='{$server->getGame()}',
            `mode`='{$this->escape_string($server->getMode())}',
            `name`='{$this->escape_string($server->getName())}',
            `map`='{$server->getMap()}'
        WHERE `id` = '{$server->getId()}';");
    }
    
    function &unserializeData(array &$data): array {
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
        $server['s']['cache_time'] = new Timestamp($data['cache_time']);
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
		public function execute($c) {}
		public function clear() {
			global $lgsl_config;
			$this->execute("TRUNCATE TABLE `{$lgsl_config['db']['prefix']}{$lgsl_config['db']['table']}`;");
		}
		public function get_all() {
			global $lgsl_config;
			$t = $this->query("SELECT * FROM `{$lgsl_config['db']['prefix']}{$lgsl_config['db']['table']}`;");
			return $t->fetch_all();
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
			return $this->_connection->query($string);
		}
		public function get_error() {
			if ($this->_connection->connect_errno === 0) return null;
			return "{$this->_connection->connect_error} ({$this->_connection->connect_errno})";
		}
		public function escape_string($string = "") {
			return $this->_connection->escape_string($string);
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
	}
	class PostgresWrapper extends DBWrapper {
		public function connect() {
			global $lgsl_config;
			$dbname = $lgsl_config['db']['db'] ? "dbname={$lgsl_config['db']['db']}" : "";
			$password = $lgsl_config['db']['pass'] ? "password={$lgsl_config['db']['pass']}" : "";
			$this->_connection = \pg_connect("host={$lgsl_config['db']['server']} port=5432 {$dbname} user={$lgsl_config['db']['user']} {$password}");
		}
		public function get_error() {
			if (!$this->_connection) return "Not connected";
			return pg_last_error($this->_connection);
		}
		public function query($string) {
			return new PostgresResultWrapper(pg_query($this->_connection, str_replace('`', '"', $string)));
		}
		public function clear() {
			parent::clear();
			global $lgsl_config;
			$this->execute("ALTER SEQUENCE {$lgsl_config['db']['prefix']}{$lgsl_config['db']['table']}_id_seq RESTART WITH 1;");
		}
		public function escape_string($string = "") {
			return pg_escape_string($this->_connection, $string);
		}
		public function execute($string) {
			return $this->query($string);
		}
		public function select_db() {
			$this->connect();
		}
	}

	abstract class ResultWrapper {
		protected $_result;
		function __construct($r) {
			$this->_result = $r;
		}
		public function fetch_all($mode = Database::ASSOC) {
			return $this->_result;
		}
		public function fetch_array($mode = Database::ASSOC) {
			return $this->_result;
		}
	}
	class MysqlResultWrapper extends ResultWrapper {
    public const MODES = [
      Database::ASSOC => MYSQLI_ASSOC,
      Database::NUM => MYSQLI_NUM,
      Database::BOTH => MYSQLI_BOTH
    ];
		public function fetch_all($mode = Database::ASSOC) {
      $ret = [];
			if ($this->_result == false) return $ret;
			return $this->_result->fetch_all($this::MODES[$mode]);
		}
		public function fetch_array($mode = Database::ASSOC) {
			return $this->_result->fetch_array($this::MODES[$mode]);
		}
	}
	class SqliteResultWrapper extends ResultWrapper {
    public const MODES = [
      Database::ASSOC => SQLITE3_ASSOC,
      Database::NUM => SQLITE3_NUM,
      Database::BOTH => SQLITE3_BOTH
    ];
		public function fetch_all($mode = Database::ASSOC) {
			$ret = [];
			if ($this->_result == false) return $ret;
			while ($r = $this->_result->fetchArray($this::MODES[$mode])) {
				array_push($ret, $r);
			}
			return $ret;
		}
		public function fetch_array($mode = Database::ASSOC) {
			if ($this->_result == false) return [];
			return $this->_result->fetchArray($this::MODES[$mode]);
		}
	}
	class PostgresResultWrapper extends ResultWrapper {
    public const MODES = [
      Database::ASSOC => PGSQL_ASSOC,
      Database::NUM => PGSQL_NUM,
      Database::BOTH => PGSQL_BOTH
    ];
		public function fetch_all($m = Database::ASSOC) {
      $result = pg_fetch_all($this->_result);
      if (!$result) return [];
			return $result;
		}
		public function fetch_array($mode = Database::ASSOC) {
      $result = pg_fetch_array($this->_result, null, $this::MODES[$mode]);
      if (!$result) return [];
			return $result;
		}
	}
//------------------------------------------------------------------------------------------------------------+
  class Server {
		public const ONLINE = "onl";
		public const OFFLINE = "nrs";
		public const PASSWORDED = "pwd";
		public const PENDING = "pen";
		public const ERROR = "err";
    private $_base;
    private $_extra = [];
    private $_other;
    private $_server;
    private $_players = [];
    private $_history = [];
    
    function __construct($options = []) {
      $this->_base = array_merge([
        "id" => 0,
        "ip" => null,
        "c_port" => 0,
        "q_port" => 0,
        "s_port" => 0,
        "type" => null,
        "status" => 0,
        "pending" => 1
      ], $options);
      $this->_server = [
        "players" => 0,
        "playersmax" => 0,
        "name" => LGSL::NONE,
        "game" => $this->_base['type'],
        "mode" => "none",
        "password" => 0,
        "map" => "World",
        "cache_time" => new Timestamp()
      ];
      $this->_other = [
        "zone" => null,
        "comment" => ''
      ];
    }
    
    public function queryCached($request = 'seph') {
      $request = "{$request}c"; // cached by default
      $db = LGSL::db();
      $db->loadServer($this);
      global $lgsl_config;
      $needed = $this->checkTimestamps($request);
      if (LGSL::requestHas($request, "h")) { $needed .= "h"; }
      if ($needed) {
        $this->queryLive($needed);
        $db->saveServer($this);
      }
    }
    public function queryLive($request = 'seph') {
      if ($request === "h") return;
      $this->queried();
      $this->removeOption("_error");
      $protocol = new Protocol($this, $request);
      $protocol->query();

      global $lgsl_config;
      if ($lgsl_config['history'] && LGSL::requestHas($request, "h") && !$this->isPending()) {
        $last = end($this->_history);
        if (!$last || time() - $last['t'] >= 60 * 15) { // RECORD IF 15 MINS IS PASSED
          $history_limit = $lgsl_config['history_hours'] * 3600;
          foreach ($this->_history as $key => $value) {
            if (time() - $this->_history[$key]['t'] > $history_limit) { // NOT OLDER THAN $lgsl_config['history_hours'] HOURS
              unset($this->_history[$key]);
            } else {
              break;
            }
          }
          $this->_history = array_values($this->_history);
          array_push($this->_history, [
            "s" => $this->getStatus() != self::OFFLINE,
            "t" => time(),
            "p" => $this->getPlayersCount()
          ]);
        }
      }

      if ($lgsl_config['locations'] && empty($this->_other['location'])) {
        $this->_other['location'] = $this->queryLocation();
      }
    }
    
    public function updateValues(&$data) {
			$this->_base = array_merge($this->_base, $data['b'] ?? []);
			$this->_extra = array_merge($this->_extra, $data['e'] ?? []);
			$this->_other = array_merge($this->_other, $data['o'] ?? []);
			$this->_server = array_merge($this->_server, $data['s'] ?? []);
      if ($this->isOnline()) {
        $this->_players = array_merge($this->_players, $data['p'] ?? []);
      } else {
			  $this->_players = [];
      }
    }    
    public function fromArray($data) {
			$this->_base = isset($data['b']) ? array_merge($this->_base, $data['b']) : $this->_base;
			$this->_extra = isset($data['e']) ? $data['e'] : [];
			$this->_other = isset($data['o']) ? $data['o'] : [];
			$this->_server = isset($data['s']) ? array_merge($this->_server, $data['s']) : $this->_server;
			$this->_players = isset($data['p']) ? $data['p'] : [];
			$this->_history = isset($data['h']) ? $data['h'] : [];
    }    
    public function toArray() {
      return [
        'b' => $this->_base,
        'e' => $this->_extra,
        'o' => $this->_other,
        's' => $this->_server,
        'p' => $this->_players,
        'h' => $this->_history
      ];
    }
    public function isValid() {
      return (isset($this->_base['ip']) || isset($this->_base['id'])) && isset($this->_base['q_port']) && isset($this->_base['type']);
    }

    public function getId() {
      return $this->_base['id'];
    }
    public function getIp($forceIp = false) {
      if ($forceIp) return gethostbyname($this->_base['ip']);
      return $this->_base['ip'];
    }
    public function getConnectionPort($intOnly = true) {
      if ($this->_base['c_port'] > 1)
        return $this->_base['c_port'];
			if ($intOnly) return 0;
      return LGSL::NONE;
    }
    public function getQueryPort($intOnly = true) {
      if ($this->_base['q_port'] > 1)
        return $this->_base['q_port'];
			if ($intOnly) return 0;
      return LGSL::NONE;
    }
    public function getSoftwarePort() {
      return $this->_base['s_port'];
    }
    public function getAddress() {
      if ($this->_base['type'] === Protocol::DISCORD) {
        return "https://discord.gg/{$this->getIp()}";
      }
      if (Protocol::lgslProtocolWithoutPort($this->_base['type'])) {
        return $this->_base['ip'];
      }
      return "{$this->_base['ip']}:{$this->_base['c_port']}";
    }
    public function getType() {
      return $this->_base['type'];
    }
    public function getGame() {
      return $this->_server['game'] ? $this->_server['game'] : $this->_base['type'];
    }
    public function setGame($game) {
      return $this->_server['game'] = $game;
    }
    public function getMode() {
      return $this->_server['mode'] ? $this->_server['mode'] : 'none';
    }
    public function getMap($formatted = false) {
			if ($formatted) return $this->_server['map'] ? LGSL::normalizeString($this->_server['map']) : LGSL::NONE;
      return $this->_server['map'] ? $this->_server['map'] : LGSL::NONE;
    }
    public function getPlayersArray() {
      return $this->_players ?? [];
    }
    public function getHistoryArray() {
      return $this->_history ?? [];
    }
    public function getExtrasArray() {
      return $this->_extra ?? [];
    }
    public function getName($html = true) {
      if ($this->isPending()) {
				return LGSL::NONE;
      }
			if ($html) {
				return htmlspecialchars($this->_server['name'], ENT_QUOTES);
			}				
      return $this->_server['name'];
    }
    public function setName($name) {
      $this->_server['name'] = $name;
    }
    public function getPlayersCount() {
      if ($this->isPending() || $this->getStatus() === self::OFFLINE) {
        return 0;
      }
      return (int) $this->_server['players'] ?? 0;
    }
    public function getPlayersMaxCount() {
      return (int) ($this->_server['playersmax'] ?? 0);
    }
    public function getBotsCount() {
      return (int) $this->_extra['bots'] ?? 0;
    }
    public function getPlayersPercent() {
      return (int) ($this->_server['players'] == 0 || $this->_server['playersmax'] == 0 ? 0 : floor($this->_server['players']/$this->_server['playersmax']*100));
    }
    public function getPlayersCountFormatted() {
      if ($this->getPlayersCount() && $this->getPlayersMaxCount()) {
        if ($this->getPlayersCount() > 9999) {
          return $this->getPlayersCount();
        } else {
          return "{$this->getPlayersCount()}/{$this->getPlayersMaxCount()}";
        }
      }
      return LGSL::NONE;
    }
		public function getPlayersNames() {
			return array_reduce($this->getPlayersArray(), function($a, $c) {
        $a[] = $c['name'];
        return $a;
      }, []);
		}
    
    public function queried() {
      $this->_base['pending'] = 0;
    }
    public function isPending() {
      return $this->_base['pending'];
    }

    public function getConnectionLink() {
      $lgsl_software_link = [
        Protocol::ALTV          => "altv://connect/{IP}:{C_PORT}",
        Protocol::ARMA3         => "steam://connect/{IP}:{C_PORT}",
        Protocol::CALLOFDUTYIW  => "javascript:prompt('Put it into console:', 'connect {IP}:{C_PORT}')",
        Protocol::CALLOFDUTY4   => "cod4://{IP}:{S_PORT}",
        Protocol::CONANEXILES   => "steam://connect/{IP}:{C_PORT}",
        Protocol::CS2D          => "steam://connect/{IP}:{C_PORT}",
        Protocol::DISCORD       => "https://discord.gg/{IP}",
        Protocol::FACTORIO      => "steam://connect/{IP}",
        Protocol::FIVEM         => "fivem://connect/{IP}:{C_PORT}",
        Protocol::GTAC          => "gtac://connect/{IP}:{C_PORT}/gta:{GAME}",
        Protocol::HALFLIFE      => "steam://connect/{IP}:{C_PORT}",
        Protocol::HALFLIFEWON   => "steam://connect/{IP}:{C_PORT}",
        Protocol::JC2MP         => "steam://connect/{IP}:{C_PORT}",
        Protocol::KILLINGFLOOR  => "steam://connect/{IP}:{C_PORT}",
        Protocol::MAFIAC        => "mafiac://connect/{IP}:{C_PORT}/mafia:{GAME}",
        Protocol::MINECRAFT     => "minecraft://{IP}:{C_PORT}/",
        Protocol::MTA           => "mtasa://{IP}:{C_PORT}",
        Protocol::MUMBLE        => "mumble://{IP}/",
        Protocol::OPENTTD       => "steam://connect/{IP}:{C_PORT}",
        Protocol::RAGEMP        => "rage://v/connect?ip={IP}:{C_PORT}",
        Protocol::REDORCHESTRA  => "steam://connect/{IP}:{C_PORT}",
        Protocol::RFACTOR       => "rfactor://{IP}:{C_PORT}",
        Protocol::SAMP          => "samp://{IP}:{C_PORT}",
        Protocol::SCUM          => "steam://connect/{IP}:{C_PORT}",
        Protocol::SF            => "steam://connect/{IP}:{C_PORT}",
        Protocol::SOLDAT        => "soldat://{IP}:{C_PORT}",
        Protocol::SOURCE        => "steam://connect/{IP}:{C_PORT}",
        Protocol::TEST          => "https://github.com/tltneon/lgsl",
        Protocol::TEEWORLDS     => "steam://connect/{IP}:{C_PORT}",
        Protocol::TERRARIA      => "steam://connect/{IP}:{C_PORT}",
        Protocol::TITANFALL2    => "northstar://server@{IP}",
        Protocol::TS3           => "ts3server://{IP}?port={C_PORT}",
        Protocol::TEASPEAK      => "ts3server://{IP}?port={C_PORT}",
        Protocol::URBANTERROR   => "urt://{IP}:{S_PORT}",
        Protocol::UNVANQUISHED  => "unv://{IP}:{C_PORT}",
        Protocol::WARSOW        => "warsow://{IP}:{C_PORT}",
        Protocol::WOW           => "javascript:prompt('Put it into your realm list:', 'set realmlist {IP}')"];
    
        // SOFTWARE PORT IS THE QUERY PORT UNLESS SET
        if (!$this->getSoftwarePort()) {
          $s_port = $this->getQueryPort();
        } else {
          $s_port = $this->getSoftwarePort();
        }
				
				if (empty($lgsl_software_link[$this->getType()])) {
					$link = "javascript:prompt('IP:', '{IP}:{C_PORT}')";
				} else {
					$link = $lgsl_software_link[$this->getType()];
				}
    
        // INSERT DATA INTO STATIC LINK - CONVERT SPECIAL CHARACTERS - RETURN
        return htmlentities(str_replace(["{IP}", "{C_PORT}", "{Q_PORT}", "{S_PORT}", "{GAME}"], [$this->getIp(), $this->getConnectionPort(), $this->getQueryPort(), $s_port, $this->getGame()], $link), ENT_QUOTES);
    }
		public function addUrlPath($path = '') {
      global $lgsl_url_path;
			return "$lgsl_url_path$path";
		}
		public function addFilePath($path = '') {
			global $lgsl_file_path;
			return "$lgsl_file_path$path";
		}
    public function mapPasswordImage() {
      if ($this->getStatus() === self::PASSWORDED) return "{$this->addUrlPath()}other/map_overlay_password.gif";
      return "{$this->addUrlPath()}other/overlay.gif";
    }
    public function getMapImage($check_exists = true) {
      global $lgsl_file_path, $lgsl_url_path;

      $type = LGSL::normalizeString($this->getType());
      $game = LGSL::normalizeString($this->getGame());
      $map  = LGSL::normalizeString($this->getMap());
  
      if ($check_exists !== true) { return "{$lgsl_url_path}maps/{$type}/{$game}/{$map}.jpg"; }
  
      $id = "_{$this->getId()}";
      if ($this->isOnline()) {
        $path_list = [
        "maps/{$type}/{$game}/{$map}.jpg",
        "maps/{$type}/{$game}/{$map}.gif",
        "maps/{$type}/{$game}/{$map}.png",
        "maps/{$type}/{$map}.jpg",
        "maps/{$type}/{$map}.gif",
        "maps/{$type}/{$map}.png",
        "other/map_no_image_{$id}.jpg",
        "other/map_no_image.jpg"];
      } else {
        $path_list = [
        "maps/{$type}/map_no_response.jpg",
        "maps/{$type}/map_no_response.gif",
        "maps/{$type}/map_no_response.png",
        "other/map_no_response_{$id}.jpg",
        "other/map_no_response.jpg"];
      }
  
      foreach ($path_list as $path) {
        if (file_exists("{$lgsl_file_path}{$path}")) { return "{$lgsl_url_path}{$path}"; }
      }
  
      return "#LGSL_DEFAULT_IMAGES_MISSING#";
    }
    public function getGameFormatted() {
      global $lgsl_config;
      return "[ {$lgsl_config['text']['typ']}: {$this->getType()} ] [ {$lgsl_config['text']['gme']}: {$this->getGame()} ]";
    }
    public function getGameIcon($path = '') {
      $type = LGSL::normalizeString($this->getType());
      $game = LGSL::normalizeString($this->getGame());

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
    public function getStatusIcon($path = '') {
      switch ($this->getStatus()) {
        case self::PENDING: return "{$path}other/icon_unknown.gif";
        case self::ERROR: return "{$path}other/icon_unknown.gif";
        case self::OFFLINE: return "{$path}other/icon_no_response.gif";
        case self::PASSWORDED: return "{$path}other/icon_online_password.gif";
				default: return "{$path}other/icon_online.gif";
      }
    }
    public function getLocationFormatted() {
      global $lgsl_config;
      return "{$lgsl_config['text']['loc']} {$this->getLocation()}";
    }
    public function getLocation() {
      return $this->_other['location'] ?? "XX";
    }
    public function getTimestamp($type = Timestamp::SERVER) {
			return $this->_server['cache_time']->get($type);
    }
    public function getTimestampFormatted($type = Timestamp::SERVER) {
			$time = $this->getTimestamp($type);
      global $lgsl_config;
      if ($time > 0) {
        return Date($lgsl_config['text']['tzn'], $time);
      }
      return $lgsl_config['text']['pen'];
    }
    public function setTimestamp($type, $time) {
      $this->_server['cache_time']->set($type, $time);
    }
    public function getTimestamps() {
      return $this->_server['cache_time']->toString();
    }
    public function getAdditionalData(): array {
      $json = json_decode(str_replace("&quot;", '"', $this->_other['comment']), true);
      try {
        if (json_last_error() > 0) {
          throw new \Exception('JSON decode error code '. json_last_error() . " for server {$this->getId()}");
        }
        return $json;
      } catch (\Exception $e) {
        return [0 => $json, 1 => $e->getMessage()];
      }
    }
    public function setAdditionalData($data): void {
      $json = json_encode($this->_other['comment']);
      try {
        if (json_last_error() > 0) {
          throw new \Exception();
        }
        $this->_other['comment'] = $json;
      } catch (\Exception $e) {
        $this->_other['comment'] = $data;
      }
    }
    public function checkTimestamps($request = "") {
      global $lgsl_config;
      $needed = "";
      foreach ([Timestamp::SERVER, Timestamp::EXTRAS, Timestamp::PLAYERS] as $stamp) {
        if (LGSL::requestHas($request, $stamp) && time() > ($this->getTimestamp($stamp) + $lgsl_config['cache_time'])) { $needed .= $stamp; }
      }
      return $needed;
    }
    public function getZone() {
      return isset($this->_other['zone']) ? $this->_other['zone'] : "";
    }
    public function addOption($name, $value) {
      if (isset($this->_extra[$name])) {
        $this->_extra[$name] .= "\n{$value}";
      } else {
        $this->setOption($name, $value);
      }
    }
    public function setOption($name, $value) {
      $this->_extra[$name] = $value;
    }
    public function getOption($name) {
      return $this->_extra[$name] ?? LGSL::NONE;
    }
    public function removeOption($name) {
      unset($this->_extra['_error']);
    }
    public function setStatus($status) {
      $this->_base['status'] = (int) $status;
    }
    public function getStatus() {
      if ($this->_base['pending']) {
        return self::PENDING;
      }
      if ($this->_server['password']) {
        return self::PASSWORDED;
      }
      if ($this->_base['status'] === Query::WITH_ERROR && isset($this->_extra['_error'])) {
        return self::ERROR;
      }
      if ($this->_base['status']) {
        return self::ONLINE;
      }
      return self::OFFLINE;
    }
		public function isOnline() {
			$s = $this->getStatus();
			return $s === self::PASSWORDED || $s === self::ONLINE;
		}
		public function queryLocation() {
      return LGSL::locationCode($this->getIp());
		}
		public function sortPlayerFields() {
				$fields_show  = ["name", "score", "kills", "deaths", "team", "ping", "bot", "time"]; // ORDERED FIRST
				$fields_hide  = ["teamindex", "pid", "pbguid"]; // REMOVED
				$fields_other = TRUE; // FALSE TO ONLY SHOW FIELDS IN $fields_show
				$fields_list = [];

				if ($this->getPlayersCount() == 0) { return $fields_list; }
				foreach ($this->getPlayersArray() as $player)	{
					foreach ($player as $field => $value)	{
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
  class Image {
    static function makeImage($src, $width, $height) {
      if (!file_exists($src)) {
        error_log("Error with image: $src\n");
        return null;
      }
      list($w, $h) = getimagesize($src);
      $type = substr($src, -3);
      header("Content-type: image/$type");
      switch ($type) {
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
    static function makeImageError($width, $height, $text) {
      header("Content-type: image/gif");
      $text = "LGSL: {$text}";
      $im = imagecreatetruecolor($width, $height);
      $font = 6;
      $white = imagecolorallocate($im, 255, 255, 255);
      imagefill($im, 0, 0, $white);
      imagestring($im, 1, (int)(($width - strlen($text) * $font) / 2), $font, $text, imagecolorallocate($im, 0, 0, 0));
      imagegif($im);
      imagedestroy($im);
      exit();
    }
  }
  class Timestamp {
    const SERVER = "s";
    const PLAYERS = "p";
    const EXTRAS = "e";
    const INDEXES = [
      Timestamp::SERVER => 0,
      Timestamp::PLAYERS => 1,
      Timestamp::EXTRAS => 2
    ];
    private $timestamps = [];
    function __construct($timestamps = "0_0_0") {
      $this->parse($timestamps);
    }
    function get($code) {
      return (int) $this->timestamps[Timestamp::INDEXES[$code]];
    }
    function parse($timestamps) {
      $this->timestamps = explode("_", $timestamps);
    }
    function set($types, $timestamp) {
      $types = str_split($types, 1);
      foreach ($types as $type) {
        $this->timestamps[Timestamp::INDEXES[$type]] = $timestamp;
      }
    }
    function toString() {
      return implode("_", $this->timestamps);
    }
  }
  } // END OF DOUBLE LOAD PROTECTION

//------------------------------------------------------------------------------------------------------------+
//------------------------------------------------------------------------------------------------------------+

  global $lgsl_file_path, $lgsl_url_path, $lgsl_config;

  $lgsl_file_path = LGSL::filePath();

  require "{$lgsl_file_path}lgsl_config.php";
  require "{$lgsl_file_path}lgsl_protocol.php";

  $auth   = md5(($_SERVER['REMOTE_ADDR'] ?? "").md5($lgsl_config['admin']['user'].md5($lgsl_config['admin']['pass'])));
  $cookie = $_COOKIE['lgsl_admin_auth'] ?? "";
  $lgsl_url_path = LGSL::urlPath();


  if (isset($_GET['lgsl_debug']) and $auth === $cookie) {
    $output = "<details>
    <summary style='margin-bottom: 12px;'>
      Open debug infos
    </summary>";
    $debugInfo = [
      's0' => "<pre>".print_r($_SERVER, TRUE)."</pre>", 'd0' => __FILE__, 'd1' => @realpath(__FILE__), 'd2' => dirname(__FILE__), 'd3' => $lgsl_file_path, 'd4' => $_SERVER['DOCUMENT_ROOT'], 
      'd5' => @realpath($_SERVER['DOCUMENT_ROOT']), 'd6' => $lgsl_url_path, 'c0' => $lgsl_config['url_path'], 'c1' => $lgsl_config['no_realpath'], 'c2' => $lgsl_config['feed']['method'], 
      'c3' => $lgsl_config['feed']['url'], 'c4' => $lgsl_config['cache_time'], 'c5' => $lgsl_config['live_time'], 'c6' => $lgsl_config['timeout'], 'c7' => $lgsl_config['cms']
    ];
    $langs = ['breeze_style', 'classic_style', 'cards_style', 'disc_ff_style', 'material_style', 'ogp_style', 'parallax_style', 'wallpaper_style', 'darken_style'];
    foreach ($debugInfo as $code => $info) {
      $output .= "<hr />#{$code}# {$info}";
    }
    $output .= "<hr />
    </details>
    <select onchange='javascript:document.querySelector(\"link[rel=stylesheet]\").href = \"src/styles/\" + this.value + \".css\"'>";
    foreach ($langs as $lang) {
      $output .= "<option value='{$lang}'>{$lang}</option>";
    }
    $output .= "
    </select>";
  }
  