<?php
	namespace tltneon\LGSL;
	//------------------------------------------------------------------------------------------------------------+
		header("Content-Type:text/html; charset=utf-8");
	//------------------------------------------------------------------------------------------------------------+
	
	require('src/lgsl_class.php');
	

	$db_type = empty($_POST["type"]) ? "mysql" : $_POST["type"];
	$db_server = empty($_POST["server"]) ? "localhost" : $_POST["server"];
	$db_user = empty($_POST["login"]) ? "" : $_POST["login"];
	$db_password = empty($_POST["password"]) ? "" : $_POST["password"];
	$db_database = empty($_POST["database"]) ? "lgsl" : $_POST["database"];
	$db_table = empty($_POST["table"]) ? "lgsl" : $_POST["table"];
	$db_prefix = empty($_POST["prefix"]) ? "" : $_POST["prefix"];
	$step = 1;
	$query_success = false;

	if (isset($_POST["_createtables"]) || isset($_POST["_updatetables"])) {
		if (empty($_POST["server"]) || empty($_POST["login"]) || empty($_POST["database"]) || empty($_POST["table"])) {
			echo('<l k="filli"></l>');
		} else {
			try {
				if ($db_type === "mysql") {
					mysqli_report(MYSQLI_REPORT_ERROR);
					global $lgsl_config; $lgsl_config['db'] = [
						'server' => $_POST["server"],
						'user'   => $_POST["login"],
						'pass'   => $_POST["password"],
						'db'     => '',
						'prefix' => "{$_POST["server"]}_"
					];
					$db = new Database();
					$db->connect('mysql');
					$db->execute("CREATE DATABASE IF NOT EXISTS {$_POST['database']}");
					$lgsl_config['db']['db'] = $_POST["database"];

					if (!$db) {
						printf("Connect <span style='color: red;'>failed</span>: wrong mysql server, username or password (%s)\n", mysqli_connect_error());
					} else {
						$db->select_db();
						if (isset($_POST["_updatetables"])) {
							$query = "
							ALTER TABLE `{$_POST["table"]}`
							ADD    `name`           VARCHAR (255) NOT NULL DEFAULT '' AFTER `id`,
							ADD    `game`           VARCHAR (50)  NOT NULL DEFAULT '' AFTER `type`,
							ADD    `mode`           VARCHAR (50)  NOT NULL DEFAULT '' AFTER `game`,
							ADD    `map`            VARCHAR (255) NOT NULL DEFAULT '' AFTER `s_port`,
							ADD    `players`        SMALLINT (5)  NOT NULL DEFAULT '0' AFTER `map`,
							ADD    `playersmax`     SMALLINT (5)  NOT NULL DEFAULT '0' AFTER `players`,
							CHANGE `cache` `cache`  MEDIUMTEXT    NOT NULL;";
						} else {
							$query = "
							CREATE TABLE `{$_POST["table"]}` (

								`id`         INT     (11)  NOT NULL auto_increment,
								`name`       VARCHAR (255) NOT NULL DEFAULT '',
								`type`       VARCHAR (50)  NOT NULL DEFAULT '',
								`game`       VARCHAR (50)  NOT NULL DEFAULT '',
								`mode`       VARCHAR (50)  NOT NULL DEFAULT '',
								`ip`         VARCHAR (255) NOT NULL DEFAULT '',
								`c_port`     VARCHAR (5)   NOT NULL DEFAULT '0',
								`q_port`     VARCHAR (5)   NOT NULL DEFAULT '0',
								`s_port`     VARCHAR (5)   NOT NULL DEFAULT '0',
								`map`        VARCHAR (255) NOT NULL DEFAULT '',
								`players`    SMALLINT (5)  NOT NULL DEFAULT '0',
								`playersmax` SMALLINT (5)  NOT NULL DEFAULT '0',
								`zone`       VARCHAR (255) NOT NULL DEFAULT '',
								`disabled`   TINYINT (1)   NOT NULL DEFAULT '0',
								`comment`    VARCHAR (255) NOT NULL DEFAULT '',
								`status`     TINYINT (1)   NOT NULL DEFAULT '0',
								`cache`      MEDIUMTEXT    NOT NULL,
								`cache_time` TEXT          NOT NULL,

								PRIMARY KEY (`id`)

							) ENGINE=MyISAM CHARSET=utf8 COLLATE=utf8_unicode_ci;";
						}
						if ($db->execute($query) == TRUE) {
							printf('');
							$step = 2;
							$query_success = true;
						} else {
							printf('<l k="table"></l>');
						}
					}
				} else {
					$db = new Database();
					$db->connect('sqlite');
					$db->execute("PRAGMA encoding='utf-8';");
					$query = "
						CREATE TABLE `{$_POST["table"]}` (
							`name`       VARCHAR (255) NOT NULL DEFAULT '',
							`type`       VARCHAR (50)  NOT NULL DEFAULT '',
							`game`       VARCHAR (50)  NOT NULL DEFAULT '',
							`mode`       VARCHAR (50)  NOT NULL DEFAULT '',
							`ip`         VARCHAR (255) NOT NULL DEFAULT '',
							`c_port`     VARCHAR (5)   NOT NULL DEFAULT '0',
							`q_port`     VARCHAR (5)   NOT NULL DEFAULT '0',
							`s_port`     VARCHAR (5)   NOT NULL DEFAULT '0',
							`map`        VARCHAR (255) NOT NULL DEFAULT '',
							`players`    SMALLINT (5)  NOT NULL DEFAULT '0',
							`playersmax` SMALLINT (5)  NOT NULL DEFAULT '0',
							`zone`       VARCHAR (255) NOT NULL DEFAULT '',
							`disabled`   TINYINT (1)   NOT NULL DEFAULT '0',
							`comment`    VARCHAR (255) NOT NULL DEFAULT '',
							`status`     TINYINT (1)   NOT NULL DEFAULT '0',
							`cache`      MEDIUMTEXT    NOT NULL,
							`cache_time` TEXT          NOT NULL

						);";
						$db->execute($query);
					$step = 2;
					$query_success = true;
				}
			} catch (Error $e) {
				var_dump($e);
				printf('<l k="mysld"></l>');
			}
		}
	}
	if (isset($_POST['_skipstep1'])) {
		$step = 2;
	}
	if (isset($_POST['_finishInstallation'])) {
		$conf = json_decode($_POST['_config'], true);
		try {
			//$lgsl_database = mysqli_connect($db_server, $db_user, $db_password);
		} catch (Error $e) {
			//echo 'err';
		}
		if (empty($lgsl_database)) {
			
			file_put_contents('install.php', 666);
			//chmod('install.php', 666);
			chmod('src/lgsl_config.php', 666);
			function type($var) {
				if (gettype($var) == "Array") return $var;
				if ($var === true) return 'true';
				if ($var === false) return 'false';
				return "$var";
			}
			foreach ($conf as $key => $value) {
				$conf[$key] = type($conf[$key]);
			}
			$config = 
"<?php
	global \$lgsl_config; \$lgsl_config = [];
	/* */
	\$lgsl_config['installed'] = true;
	\$lgsl_config['feed']['method'] = 0;
	\$lgsl_config['feed']['url'] = \"http://www.greycube.co.uk/lgsl/feed/lgsl_files/lgsl_feed.php\";
	\$lgsl_config['style'] = '{$conf['style']}'; // options: breeze_style.css, darken_style.css, classic_style.css, ogp_style.css, parallax_style.css, disc_ff_style.css, materials_style.css
	\$lgsl_config['scripts'] = {$conf['scripts']};
	\$lgsl_config['locations'] = {$conf['locations']};
	\$lgsl_config['list']['totals'] = {$conf['totals']};
	\$lgsl_config['sort']['servers'] = \"{$conf['sort_servers_by']}\";	// OPTIONS: id  type  zone  players  status
	\$lgsl_config['sort']['players'] = \"{$conf['sort_players_by']}\";	// OPTIONS: name  score
	\$lgsl_config['zone']['width'] = \"160\"; // images will be cropped unless also resized to match
	\$lgsl_config['zone']['line_size'] = \"19\";  // player box height is this number multiplied by player names
	\$lgsl_config['zone']['height'] = \"100\"; // player box height limit
	\$lgsl_config['grid']     = [1,1,1,1,1,1,1,1,1,1];
	\$lgsl_config['players']  = [1,1,1,1,1,1,1,1,1,1];
	\$lgsl_config['random']   = [0,0,0,0,0,0,0,0,0,0];
	\$lgsl_config['hide_offline'] = [{$conf['hide_offline']},0,0,0,0,0,0,0,0,0];
	\$lgsl_config['title'] = ['Live Game Server List', 'Server', 'Server', 'Server', 'Server', 'Server', 'Server', 'Server', 'Server', 'Server'];
	\$lgsl_config['admin']['user'] = \"{$conf['lgsl_user']}\";
	\$lgsl_config['admin']['pass'] = \"{$conf['lgsl_password']}\";
	\$lgsl_config['db']['type']    = \"{$conf['db_type']}\";
	\$lgsl_config['db']['server']  = \"{$conf['db_server']}\";
	\$lgsl_config['db']['user']    = \"{$conf['db_user']}\";
	\$lgsl_config['db']['pass']    = \"{$conf['db_password']}\";
	\$lgsl_config['db']['db']      = \"{$conf['db_database']}\";
	\$lgsl_config['db']['table']   = \"{$conf['db_table']}\";
	\$lgsl_config['db']['prefix']  = \"{$conf['db_prefix']}\";
	\$lgsl_config['image_mod']     = {$conf['image_mod']};
	\$lgsl_config['preloader']     = {$conf['preloader']};   // true=using ajax to faster loading page
	\$lgsl_config['pagination_mod']= {$conf['page_mod']};   // true = using pagination
	\$lgsl_config['pagination_lim']= {$conf['page_lim']};   // limit per page
	\$lgsl_config['direct_index']  = 0;                     // 1=link to index.php instead of the folder
	\$lgsl_config['no_realpath']   = 0;                     // 1=do not use the realpath function
	\$lgsl_config['url_path']      = '';                  // full url to /src/ for when auto detection fails
	\$lgsl_config['management']    = 0;                     // 1=show advanced management in the admin by default
	\$lgsl_config['host_to_ip']    = 0;                     // 1=show the servers ip instead of its hostname
	\$lgsl_config['public_add']    = {$conf['public_add']}; // 1=servers require approval OR 2=servers shown instantly
	\$lgsl_config['public_feed']   = 0;                     // 1=feed requests can add new servers to your list
	\$lgsl_config['cache_time']    = {$conf['cache_time']}; // seconds=time before a server needs updating
	\$lgsl_config['autoreload']    = {$conf['autoreload']}; // 1=reloads page when cache_time is passed
	\$lgsl_config['history']       = {$conf['history']};    // 1=record server history
	\$lgsl_config['live_time']     = 3;                     // seconds=time allowed for updating servers per page load
	\$lgsl_config['timeout']       = 0;                     // 1=gives more time for servers to respond but adds loading delay
	\$lgsl_config['retry_offline'] = 0;                     // 1=repeats query when there is no response but adds loading delay
	\$lgsl_config['cms']           = 'sa';                // sets which CMS specific code to use
	include('languages/{$conf['language']}.php');        // sets LGSL language
?>";
			file_put_contents('src/lgsl_config.php', $config);
			unlink('install.php');
			exit('done');
		} else {
			$step = 2;
			printf('<l k="table"></l>');
		} 
	}

?>


<!DOCTYPE html>
<html>
	<head>
		<title>LGSL Installation Page</title>
		<link rel='stylesheet' type='text/css' href='src/styles/darken_style.css' />
		<link rel="icon" href="src/other/favicon.ico" type="image/x-icon">
		<link rel="shortcut icon" href="src/other/favicon.ico" type="image/x-icon">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
		<meta http-equiv='content-style-type' content='text/css' />
		<style>
			body {
				padding: 2px 4px;
			}
			input[type="text"], input[type="password"], select {
				float: right;
			}
			select {
				width: 170px;
				height: 21.5px;
			}
			div#container{
				width: inherit !important;
			}
			div#container > div {
				max-width: 375px;
				margin: auto;
			}
			h5 {
				float: right;
				margin: 0;
				text-decoration: underline;
			}
			h4 {
				text-align: center;
			}
			button{
				margin: auto;
				display: inline-block;
				width: 32%;
			}
			.hinfolink {
				font-size: 10px;
				color: blue;
				text-decoration: none;
				border: 1px solid blue;
				border-radius: 32px;
				margin-bottom: 0px;
				vertical-align: super;
				padding: 2px 2px 2px 3px;
				line-height: 6px;
				width: 6px;
				height: 7px;
				display: inline-block;
			}
			.badge {
				border-radius: 4px;
				display: inline;
				padding: 1px 4px;
			}
			.bg-red {
				background: red;
			}
			.bg-green {
				background: green;
			}
		</style>
	</head>

	<body>
		<div id="container">
			<div>
<?php
//------------------------------------------------------------------------------------------------------------+
	$loc = array_reduce(["AD","AE","AF","AG","AI","AL","AM","AN","AO","AR","AS","AT","AU","AW","AX","AZ","BA","BB","BD","BE","BF","BG","BH","BI","BJ","BM","BN",
		"BO","BR","BS","BT","BV","BW","BY","BZ","CA","CC","CD","CF","CG","CH","CI","CK","CL","CM","CN","CO","CR","CS","CU","CV","CX","CY","CZ",
		"DE","DJ","DK","DM","DO","DZ","EC","EE","EG","EH","ER","ES","ET","EU","FI","FJ","FK","FM","FO","FR","GA","GB","GD","GE","GF","GH","GI",
		"GL","GM","GN","GP","GQ","GR","GS","GT","GU","GW","GY","HK","HM","HN","HR","HT","HU","ID","IE","IL","IN","IO","IQ","IR","IS","IT","JM",
		"JO","JP","KE","KG","KH","KI","KM","KN","KP","KR","KW","KY","KZ","LA","LB","LC","LI","LK","LR","LS","LT","LU","LV","LY","MA","MC","MD",
		"ME","MG","MH","MK","ML","MM","MN","MO","MP","MQ","MR","MS","MT","MU","MV","MW","MX","MY","MZ","NA","NC","NE","NF","NG","NI","NL","NO",
		"NP","NR","NU","NZ","OFF","OM","PA","PE","PF","PG","PH","PK","PL","PM","PN","PR","PS","PT","PW","PY","QA","RE","RO","RS","RU","RW","SA",
		"SB","SC","SD","SE","SG","SH","SI","SJ","SK","SL","SM","SN","SO","SR","ST","SV","SY","SZ","TC","TD","TF","TG","TH","TJ","TK","TL","TM",
		"TN","TO","TR","TT","TV","TW","TZ","UA","UG","UM","US","UY","UZ","VA","VC","VE","VG","VI","VN","VU","WF","WS","YE","YT","ZA","ZM","ZW"],
		function($a, $b) {
			return "{$a}<option value='{$b}'>{$b}</option>";
		});

	$output = '
	<h4>LGSL Installation page</h4>
	<h6><a href="./"><l k="back"></l></a></h6>
	<h5><a href="https://github.com/tltneon/lgsl/wiki/How-to-install-LGSL" target="_blank"><l k="owiki"></l></a></h5>
	<div>';

		if ($step == 1) {
			$output .= '<h4><l k="check"></l></h4>';
			
			function check($name, $bool, $hint = '') {
				if ($bool) return "<p class='badge bg-green'>$name</p>";
				return "<p class='badge bg-red' title='$hint'>$name</p>";
			}
			
			$output .= check('MySQL', function_exists("mysqli_connect"), 'used for mysql db');
			$output .= check('PHP 7+', version_compare(PHP_VERSION, "7.0.0") >= 0, 'errors may occurs if PHP < 7.0');
			$output .= check('FSOCKOPEN', function_exists("fsockopen") && fsockopen("udp://127.0.0.1", 13, $errno, $errstr, 3), 'mainly used for querying');
			$output .= check('CURL', function_exists("curl_init") && function_exists("curl_setopt") && function_exists("curl_exec"), 'optional: for some games');
			$output .= check('BZ2', function_exists("bzdecompress"), 'optional: for some games');
			$output .= check('GD', function_exists("gd"), 'optional: for charts & userbars');
		}

	$output .= "	
		<br>" . ($step == 1 ? "<h4><l k='step1'></l></h4>" : "") . "
		<form method='post' action='?'>
			<p>
				DB Type*:
				<select name='db_type' onChange='changeValue(event, {dbChanged: true})'>
					<option ". ($db_type == 'mysql' ? 'selected' : '') .">mysql</option>
					<option ". ($db_type == 'sqlite' ? 'selected' : '') .">sqlite</option>
				</select>
			</p>
			<p id='db_server'>
				DB Server*:
				<input type='text' name='server' onChange='vars.db_server = event.target.value' value='{$db_server}' />
			</p>
			<p>
				DB Login*:
				<input type='text' name='login' onChange='vars.db_user = event.target.value' value='{$db_user}' />
			</p>
			<p>
				DB Password:
				<input type='password' name='password' onChange='vars.db_password = event.target.value' value='{$db_password}' />
			</p>
			<p id='db_database'>
				DB Database*:
				<input type='text' name='database' onChange='vars.db_database = event.target.value' value='{$db_database}' />
			</p>
			<p>
				DB Table*:
				<input type='text' name='table' onChange='vars.db_table = event.target.value' value='{$db_table}' />
			</p>
			<p>
				Table Prefix:
				<input type='text' name='prefix' onChange='vars.db_prefix = event.target.value' value='{$db_prefix}' />
			</p>
			<div style='display: ". ($step == 1 ? 'block' : 'none') ."'>
				<button type='submit' name='_createtables'>
					<l k='creat'></l>
				</button>
				<button type='submit' name='_updatetables'>
					<l k='updat'></l>
				</button>
				<button type='submit' name='_skipstep1'>
					<l k='skips'></l>
				</button>
			</div>
		</form>
	</div>

	<div style='display: ". ($step == 2 ? 'block' : 'none') ."'>
		". ($query_success == 2 ? "<div><l k='cretd'></l></div>" : "") ."

			<h4><l k='step2'></l></h4>

			<p>
				LGSL Admin Login*:
				<input type='text' onChange='vars.lgsl_user = event.target.value' />
			</p>
			<p>
				LGSL Admin Password*:
				<input type='text' onChange='vars.lgsl_password = event.target.value' />
			</p>

			<hr />

			<p>
				<l k='selst'></l>:
				<select type='text' name='style' onChange='changeValue(event, {styleChanged: true})' />
					<option value='darken_style.css'>Darken</option>
					<option value='ogp_style.css'>OGP</option>
					<option value='material_style.css'>Material Design</option>
					<option value='breeze_style.css'>Breeze</option>
					<option value='parallax_style.css'>Parallax</option>
					<option value='cards_style.css'>Cards</option>
					<option value='classic_style.css'>Classic</option>
					<option value='disc_ff_style.css'>Disc FF</option>
					<option value='wallpaper_style.css'>Wallpaper</option>
					<option value='showcase' style='color: green;'>(external) Showcase</option>
				</select>
			</p>
			<p>
				<l k='sella'></l>:
				<select type='text' name='language' onChange='changeValue(event, {translationInput: true})' />
					<option value='english'>English</option>
					<option value='russian'>Русский</option>
					<option value='french'>Français</option>
					<option value='german'>Deutsch</option>
					<option value='spanish'>Español</option>
					<option value='czech'>Čeština</option>
					<option value='bulgarian'>български</option>
					<option value='slovak'>Slovenčina</option>
					<option value='arabic'>اَلْعَرَبِيَّةُ</option>
					<option value='turkish'>Türkçe</option>
					<option value='korean'>한국어</option>
					<option value='romanian'>Română</option>
					<option value='chinese_simplified'>简体中文</option>
					<option value='help' style='color: green;'>!Help to translate LGSL!</option>
				</select>
			</p>

			<p>
				<l k='selsc'></l> <a href='https://github.com/tltneon/lgsl/wiki/scripts' target='_blank' class='hinfolink'>?</a>:
				<br /><input type='checkbox' id='parallax.js' name='scripts' onChange='changeCheckbox(event)' /> parallax (for Parallax Style)
				<br /><input type='checkbox' id='preview.js' name='scripts' onChange='changeCheckbox(event)' /> map preview (on server list)
				<br /><input type='checkbox' id='refresh.js' name='scripts' onChange='changeCheckbox(event)' /> refresh (manually refresh server status)
				<br /><input type='checkbox' id='flag-icon.js' name='scripts' onChange='changeCheckbox(event)' /> flag-icon (replacing with svg)
			</p>

			<hr />

			<p>
				<l k='sorts'></l>:
				<select type='text' name='sort_servers_by' onChange='changeValue(event)' />
					<option value='id'>ID</option>
					<option value='type'>Type</option>
					<option value='zone'>Zone</option>
					<option value='players'>Players</option>
					<option value='status'>Status</option>
				</select>
			</p>
			<p>
				<l k='sortp'></l>:
				<select type='text' name='sort_players_by' onChange='changeValue(event)' />
					<option value='name'>Name</option>
					<option value='score'>Score</option>
					<option value='time'>Time</option>
				</select>
			</p>
			<p>
				<l k='enaim'></l> <a href='https://github.com/tltneon/lgsl/wiki/LGSL-with-Image-Mod' target='_blank' class='hinfolink'>?</a>:
				<input type='checkbox' name='image_mod' onChange='changeCheckbox(event)' />
			</p>
			<p>
				Enable Preloader <a href='https://github.com/tltneon/lgsl/wiki/features#preloader' target='_blank' class='hinfolink'>?</a>:
				<input type='checkbox' name='preloader' onChange='changeCheckbox(event)' />
			</p>
			<p>
				Enable Pagination <a href='https://github.com/tltneon/lgsl/wiki/features#pagination' target='_blank' class='hinfolink'>?</a>:
				<input type='checkbox' name='page_mod' onChange='changeCheckbox(event)' />
				<input type='number' min='5' max='35' value='15' onChange='vars.page_lim = event.target.value' />
			</p>
			<p>
				Automatically reload page:
				<input type='checkbox' name='autoreload' onChange='changeCheckbox(event)' />
			</p>
			<p>
				Time before a server needs updating:
				<input type='number' min='0' max='3600' value='60' onChange='vars.cache_time = event.target.value' />
			</p>
			<p>
				Enable server tracking (history) <a href='https://github.com/tltneon/lgsl/wiki/features#pagination' target='_blank' class='hinfolink'>?</a>:
				<input type='checkbox' name='history' onChange='changeCheckbox(event)' />
			</p>
			<p>
				<l k='hideo'></l>:
				<input type='checkbox' name='hide_offline' onChange='changeCheckbox(event)' />
			</p>
			<p>
				<l k='pubad'></l>:
				<select type='text' name='public_add' onChange='changeValue(event)' />
					<option value='0' style='color: red;'>Disabled</option>
					<option value='1' style='color: orange;'>Enabled (require approval)</option>
					<option value='2' style='color: green;'>Enabled (shows instantly)</option>
				</select>
			</p>
			<p>
				<l k='showt'></l>:
				<input type='checkbox' name='totals' onChange='changeCheckbox(event)' />
			</p>
			<p>
				<l k='showl'></l>:
				<select type='text' name='locations' onChange='changeValue(event)' />
					<option value='0' style='color: red;'>Disabled</option>
					<option value='1' style='color: green;'>Enabled</option>
					<option disabled style='background: gray;'></option>
					<option disabled>Select manually:</option>
					{$loc}
				</select>
			</p>

			<button onClick='generateConfig()'>
				<l k='gener'></l>
			</button>
		</div>
	";

  echo $output;
  unset($output);
//------------------------------------------------------------------------------------------------------------+
?>
			</div>
		</div>
	</body>
</html>

<script>
document.addEventListener("DOMContentLoaded", reloadLocale);
document.addEventListener("reloadLocale", reloadLocale);
	function reloadLocale() {
		document.querySelectorAll("l").forEach(
			(item, i, arr) => {
				updateLValue(item, item.getAttribute("k"));
			}
		);
	}
	var locale = "english";
	let vars = {
		db_type: "<?php echo $db_type; ?>",
		db_server: "<?php echo $db_server; ?>",
		db_user: "<?php echo $db_user; ?>",
		db_password: "<?php echo $db_password; ?>",
		db_database: "<?php echo $db_database; ?>",
		db_table: "<?php echo $db_table; ?>",
		db_prefix: "<?php echo $db_prefix; ?>",
		lgsl_user: "",
		lgsl_password: "",
		//
		style: "darken_style.css",
		scripts: [],
		language: "english",
		sort_servers_by: "id",
		sort_players_by: "name",
		image_mod: false,
		page_mod: false,
		page_lim: 15,
		autoreload: false,
		history: false,
		cache_time: 60,
		hide_offline: false,
		public_add: false,
		totals: false,
		locations: false,
    	preloader: false
	}
	function changeValue(event, options = {}) {
		if (options.styleChanged) {
			vars["scripts"]["parallax.js"] = false;
			document.querySelector("input[id='parallax.js']").checked = false;
			if (event.target.value == "showcase") {
				event.target.value = "darken_style.css";
				window.open("https://github.com/tltneon/lgsl/wiki/Styles");
			}
			if (event.target.value == "parallax_style.css") {
				vars["scripts"]["parallax.js"] = true;
				document.querySelector("input[id='parallax.js']").checked = true;
			}
			document.getElementsByTagName("link")[0].href = `src/styles/${event.target.value}`;
		}
		if (options.translationInput) {
			if (event.target.value == "help") {
				event.target.value = "english";
				window.open("https://github.com/tltneon/lgsl/wiki#how-do-i-change-language");
			}
			locale = event.target.value;
			document.dispatchEvent(new Event("reloadLocale"));
		}
		if (options.dbChanged) {
			console.log(event.target.value);
			if (event.target.value == 'sqlite') {
				document.querySelector("p[id='db_server']").style.display = 'none';
			} else {
				document.querySelector("p[id='db_server']").style.display = 'inherit';
			}
		}
		vars[event.target.name] = event.target.value;
	}
	function changeCheckbox(event) {
		if (event.target.name == 'scripts') {
			vars[event.target.name][event.target.id] = event.target.checked;
		} else {
			vars[event.target.name] = event.target.checked;
		}
	}
	function updateLValue(el, key) {
		el.innerText = "";
		el.insertAdjacentHTML('beforeend', l(key));
	}
	function generateConfig() {
		if (vars.db_user == "" || vars.lgsl_user == "" || vars.lgsl_password == "") return alert(l("filla"));
		let textarea = document.body.getElementsByTagName("textarea")[0] ? document.body.getElementsByTagName("textarea")[0] : document.createElement("textarea");
		let slist = "";
		for (s in vars['scripts']) {
			if (vars['scripts'][s])
				slist += `"${s}",`;
		}
		httpRequest = new XMLHttpRequest();
		if (!httpRequest) {
			alert('Cannot create an XMLHTTP instance');
			return false;
		}
		httpRequest.open('POST', 'install.php');
		httpRequest.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
		vars['scripts'] = `[${slist}]`;
		console.log(vars);
		httpRequest.onreadystatechange = alertContents;
		httpRequest.send(`_config=${JSON.stringify(vars)}&_finishInstallation=true`);
		function alertContents() {
            if (httpRequest.readyState === XMLHttpRequest.DONE) {
              if (httpRequest.status === 200) {
				if (httpRequest.responseText === 'done') {
              		document.getElementById('container').innerHTML = 'LGSL successfully installed! lgsl_config.php rewrited & install.php was deleted.<br>Redirecting to main page.. <a href=".">Link</a>';
					setTimeout(() => {
						window.location = '.';
					}, 1000);
				} else {
					alert('There was a problem with the request. Message: ' + httpRequest.responseText);
				}
              } else {
                alert('There was a problem with the request. HTTP Code: ' + httpRequest.status);
              }
            }
          }
	}

	function l(key) {
		let t = {
			"english": {
				"tablc": "LGSL table created <span style='color: green;'>successfully</span>.",
				"filli": "You need to fill inputs (<span style='color:red'>step 1</span>) correctly.",
				"consu": "Connection <span style='color: green;'>successfully</span> established, LGSL can take data from game servers.",
				"coutd": "LGSL <span style='color: red;'>couldn't take data from most of game servers</span> due to UDP upflow is blocked on your hosting.",
				"remem": "Remember to remove the install.php after install LGSL!",
				"after": "After you make config, replace it into src/lgsl_config.php",
				"selst": "Select style",
				"sella": "Select language",
				"selsc": "Select scripts",
				"sorts": "Sort servers by",
				"sortp": "Sort players by",
				"enaim": "Enable Image mod",
				"hideo": "Hide offline servers",
				"pubad": "Public add servers",
				"showt": "Show totals",
				"showl": "Show locations",
				"step1": "Step 1: Install / Update LGSL Tables",
				"step2": "Step 2: Configurating LGSL",
				"back": "< Back",
				"owiki": "Online Wiki: How to",
				"gener": "Generate config",
				"creat": "Create table",
				"updat": "Update table",
				"skips": "Skip step",
				"filla": "You need to fill required* inputs.",
				"mysld": "Connect <span style='color: red;'>failed</span>: mysqli extension doesn't active.",
				"table": "LGSL <span style='color: red;'>table wasn't created</span>: wrong database name or table already exists.",
				"cretd": "Table <span style='color: green;'>successfully</span> created! Get to Step 2.",
        "check": "Check requirements",
			},
			"russian": {
				"back": "< Назад",
			},
			"french": {
				"back": "< Arrière",
			},
			"german": {
				"back": "< Zurück",
			},
			"spanish": {
				"back": "< Espalda",
			},
			"czech": {
				"back": "< Zadní",
			},
			"bulgarian": {
				"back": "< Обратно",
			},
			"slovak": {
				"tablc": "LGSL tabuľka bola vytvorená <span style='color: green;'>úspešne</span>.",
				"filli": "Musíte vyplniť formulár (<span style='color:red'>krok 1</span>) správne.",
				"consu": "Spojenie bolo <span style='color: green;'>úspešne</span> nadviazané, LGSL môže brať údaje z herných serverov.",
				"coutd": "LGSL <span style='color: red;'>nemôže získať údaje z herného servera</span>, iba teamspeak server (UDP upflow je zakázané na vašom hostingu).",
				"remem": "Nezabudni vymazať súbor install.php po nainštalovaní LGSL!",
				"after": "Potom čo vytvoríš konfiguraciu, vymeň subor za src/lgsl_config.php",
				"selst": "Zvoliť štýl",
				"sella": "Zvoliť jazyk",
				"selsc": "Select scripts",
				"sorts": "Zoradiť servery podľa",
				"sortp": "Zoradiť hráčov podľa",
				"enaim": "Povoliť obrázkové zobrazovanie",
				"hideo": "Nezobrazovať neaktívne servery.",
				"pubad": "Povoliť verejné pridávanie serverov",
				"showt": "Zobraziť celkové údaje",
				"showl": "Zobraziť lokality",
				"step1": "Krok 1: Inštalovať LGSL Tabuľky",
				"step2": "Krok 2: Konfigurovanie LGSL",
				"back": "Späť",
				"owiki": "Online Wiki: Ako na to",
				"gener": "Vytvoriť konfiguráciu",
				"creat": "Vytvoriť tabuľky",
				"filla": "Musíš vyplniť povinné* údaje (krok 1 or 2).",
				"mysld": "Pripojenie <span style='color: red;'>Zlyhalo</span>: PHP rozšírenie mysqli nie je aktívne.",
				"table": "LGSL <span style='color: red;'>tabulka nebola vytvorená</span>: nesprávny názov databázy alebo tabuľka už existuje.",
			},
			"arabic": {
				"back": "< Back",
			},
			"turkish": {
				"tablc": "LGSL tablosu oluşturuldu <span style='color: green;'>Başarıyla Tamamlandı!</span>.",
				"filli": "Girişleri doldurmanız gerekiyor (<span style='color:red'>1'inci Adımı</span>) Kontrol Ediniz.",
				"consu": "Bağlantı <span style='color: green;'>Başarıyla</span> kuruldu, LGSL oyun sunucularından veri alabilir.",
				"coutd": "LGSL <span style='color: red;'>Barındırma işleminizde UDP yukarı akışı engellendiğinden</span> oyun sunucularının çoğundan veri alınamadı.",
				"remem": "LGSL'yi kurduktan sonra install.php'yi kaldırmayı unutmayın!",
				"after": "Yapılandırmayı yaptıktan sonra, onu src/lgsl_config.php olarak değiştirin",
				"selst": "Stil seçin",
				"sella": "Dilinizi Seçin",
				"selsc": "Script'leri Seçin",
				"sorts": "Sunucuya Göre Sırala",
				"sortp": "Oyuncuya Göre Sırala",
				"enaim": "Görüntü modunu etkinleştir",
				"hideo": "Çevrimdışı sunucuları gizle",
				"pubad": "Özel Sunucu Ekle",
				"showt": "Toplamları göster",
				"showl": "Konumları göster",
				"step1": "Adım 1: LGSL Tablolarını Kurun",
				"step2": "2. Adım: LGSL'yi Yapılandırma",
				"back": "< Geri Git",
				"owiki": "Çevrimiçi Wiki: Nasıl Yapılır?",
				"gener": "Yapılandırma oluştur",
				"creat": "Tablo oluştur",
				"filla": "Gerekli* girişleri doldurmanız gerekir (adım 1 veya 2).",
				"mysld": "Bağlantı <span style='color: red;'>failed</span>: Hatalı <span style='color: red;'>Bağlantı Başarısız</span>: mysqli uzantısı etkin değil.",
				"table": "LGSL <span style='color: red;'>tablo oluşturulmadı</span>: yanlış veritabanı adı veya tablo zaten var.",
				"cretd": "Tablo <span style='color: green;'>Başarıyla Oluşturuldu!</span> Oluşturuldu! 2'inci adıma geçin",
			},
			"romanian": {
				"tablc": "Tabelul LGSL a fost creat cu <span style='color: green;'>success</span>.",
				"filli": "Trebuie să completezi câmpurile (<span style='color:red'>pasul 1</span>) corect.",
				"consu": "Conexiunea a fost stabilită cu <span style='color: green;'>succes</span>, LGSL poate prelua date de la serverele de jocuri.",
				"coutd": "LGSL <span style='color: red;'>nu a putut prelua date de la majoritatea serverelor de jocuri</span> deoarece traficul UDP este blocat pe găzduirea dvs.",
				"remem": "Nu uitați să eliminați install.php după instalarea LGSL!",
				"after": "După ce finalizați configurația, înlocuiți-o în src/lgsl_config.php",
				"selst": "Selectați stilul",
				"sella": "Selectați limba",
				"selsc": "Selectați scripturi",
				"sorts": "Sortați serverele după",
				"sortp": "Sortați jucătorii după",
				"enaim": "Activați modul pentru imagine status server",
				"hideo": "Ascunde serverele offline",
				"pubad": "Oricine poate adăuga servere",
				"showt": "Afișați totalurile",
				"showl": "Afișați locațiile",
				"step1": "Pasul 1: Inițializați tabelele LGSL",
				"step2": "Pasul 2: Configurare LGSL",
				"back": "< Înapoi",
				"owiki": "Wiki online: Cum să",
				"gener": "Generați configurația",
				"creat": "Creați un tabel",
				"filla": "Trebuie să completați câmpurile necesare* (pasul 1 sau 2).",
				"mysld": "Conectarea a <span style='color: red;'>eșuat</span>: extensia mysqli nu este activă.",
				"table": "<span style='color: red;'>Tabelul LGSL nu a fost creat</span>: nume greșit al bazei de date sau tabelul există deja.",
				"cretd": "Tabel creat cu <span style='color: green;'>succes</span> created! Continuați cu Pasul 2.",
				"check": "Verificați cerințele",
			},
			"korean": {
				"tablc": "LGSL 테이블이<span style='color: green;'>완료되었습니다!</span>를 만들었습니다.",
				"filli": "항목을 채워야 합니다(<span style='color:red'>1단계</span>). 확인해야 합니다.",
				"consu": "연결 <span style='color: green;'>성공적으로 설정</span>, LGSL 게임 서버에서 데이터를 받을 수 있습니다.",
				"coutd": "LGSL <span style='color: red;'>UDP 업스트림이 호스팅에서 차단되었기 때문입니다</span>. 대부분의 게임 서버에서 데이터를 검색하지 못했습니다.",
				"remem": "LGSL을 설치한 후 install.php를 제거하는 것을 잊지 마십시오!",
				"after": "설정 후 src/lgsl_config.php로 변경",
				"selst": "테마 선택",
				"sella": "당신의 언어를 고르시 오",
				"selsc": "플러그인 선택",
				"sorts": "서버별 정렬",
				"sortp": "플레이어별로 정렬",
				"enaim": "디스플레이 모드 활성화",
				"hideo": "오프라인 서버 숨기기",
				"pubad": "사설 서버 추가",
				"showt": "총계 미리보기",
				"showl": "위치를 표시합니다.",
				"step1": "1단계: LGSL 테이블 설치",
				"step2": "2단계: LGSL 구성",
				"back": "< 돌아가기",
				"owiki": "온라인 위키: 방법 배우다",
				"gener": "구성 만들기",
				"creat": "테이블 생성",
				"filla": "필수* 항목을 입력해야 합니다(1단계 또는 2단계).",
				"mysld": "링크 <span style='color: red;'>실패</span>: 잘못된 <span style='color: red;'>연결 실패</span>: mysqli 확장이 활성화되어 있지 않습니다.",
				"table": "LGSL <span style='color: red;'>테이블이 생성되지 않음</span>: 잘못된 데이터베이스 이름 또는 테이블이 이미 존재합니다.",
				"cretd": "<span style='color: green;'>성공적으로 생성되었습니다!</span> 테이블이 생성되었습니다! 2단계로 이동",
			},
			"chinese_simplified": {
				"tablc": "LGSL 数据表创建 <span style='color: green;'>成功</span>.",
				"filli": "您必须确保必填项 (<span style='color:red'>步骤1</span>) 正确.",
				"consu": "连接 <span style='color: green;'>成功</span> 确认, LGSL 可以从游戏服务器获取数据。",
				"coutd": "LGSL <span style='color: red;'>无法从大多数游戏服务器获取数据</span> ，因为UDP upflow在您的当前服务器主机上被阻止。",
				"remem": "请务必在LGSL安装成功删除install.php",
				"after": "接下来, 请将它替换到 src/lgsl_config.php",
				"selst": "选择风格",
				"sella": "选择语言",
				"selsc": "选择脚本",
				"sorts": "服务器排序方式",
				"sortp": "玩家排序方式",
				"enaim": "开启图片mod",
				"hideo": "隐藏离线服务器",
				"pubad": "开放服务器添加",
				"showt": "显示总数",
				"showl": "显示位置",
				"step1": "步骤1: 安装LGSL数据表",
				"step2": "步骤2: 配置LGSL",
				"back": "< 返回",
				"owiki": "在线文档: 访问",
				"gener": "生成配置文件",
				"creat": "创建数据表",
				"filla": "您必须完成必填项* (步骤1或步骤2).",
				"mysld": "连接 <span style='color: red;'>失败</span>: mysqli扩展未激活。",
				"table": "LGSL <span style='color: red;'>数据表未创建</span>: 数据库名称有误或数据表已被创建。",
				"cretd": "数据表 <span style='color: green;'>成功</span> 创建! 请进入第2步。",
			}
		};
		return t[locale][key] ?? t['english'][key];
	}
</script>
