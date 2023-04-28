<?php
	//------------------------------------------------------------------------------------------------------------+
		header("Content-Type:text/html; charset=utf-8");
	//------------------------------------------------------------------------------------------------------------+

	$mysql_server = empty($_POST["server"]) ? "localhost" : $_POST["server"];
	$mysql_user = empty($_POST["login"]) ? "" : $_POST["login"];
	$mysql_password = empty($_POST["password"]) ? "" : $_POST["password"];
	$mysql_database = empty($_POST["database"]) ? "lgsl" : $_POST["database"];
	$mysql_table = empty($_POST["table"]) ? "lgsl" : $_POST["table"];
	$installed = "";

	if (isset($_POST["_createtables"])){
		if (empty($_POST["server"]) || empty($_POST["login"]) || empty($_POST["database"]) || empty($_POST["table"])){
			echo('<l k="filli"></l>');
		} else {
			try {
        		mysqli_report(MYSQLI_REPORT_ERROR);
				$lgsl_database = mysqli_connect($mysql_server, $mysql_user, $mysql_password);

				if (!$lgsl_database) {
					printf("Connect <span style='color: red;'>failed</span>: wrong mysql server, username or password (%s)\n", mysqli_connect_error());
				} else {
					$lgsl_select_db = mysqli_select_db($lgsl_database, $_POST["database"]);
					if (mysqli_query($lgsl_database, "
						CREATE TABLE `".$_POST["table"]."` (

							`id`         INT     (11)  NOT NULL auto_increment,
							`type`       VARCHAR (50)  NOT NULL DEFAULT '',
							`ip`         VARCHAR (255) NOT NULL DEFAULT '',
							`c_port`     VARCHAR (5)   NOT NULL DEFAULT '0',
							`q_port`     VARCHAR (5)   NOT NULL DEFAULT '0',
							`s_port`     VARCHAR (5)   NOT NULL DEFAULT '0',
							`zone`       VARCHAR (255) NOT NULL DEFAULT '',
							`disabled`   TINYINT (1)   NOT NULL DEFAULT '0',
							`comment`    VARCHAR (255) NOT NULL DEFAULT '',
							`status`     TINYINT (1)   NOT NULL DEFAULT '0',
							`cache`      MEDIUMTEXT    NOT NULL,
							`cache_time` TEXT          NOT NULL,

							PRIMARY KEY (`id`)

						) ENGINE=MyISAM CHARSET=utf8 COLLATE=utf8_unicode_ci;") === TRUE){
							printf("");
							$installed = "disabled";
						}
						else {
							printf('<l k="table"></l>');
						}
					mysqli_close($lgsl_database);
				}
			}
			catch (Error $e) {
				printf('<l k="mysld"></l>');
			}
		}
	}
	if (isset($_GET['test'])) {
		if (function_exists("fsockopen")) {
			$fp = fsockopen("udp://127.0.0.1", 13, $errno, $errstr, 3);
			if (!$fp) {
				echo "ERROR: $errno - $errstr<br />\n";
				echo "<l k='coutd'></l>\n";
			} else {
				fwrite($fp, "\n");
				echo "<l k='consu'></l>\n";
				fclose($fp);
			} 
		} else {
			echo("FSOCKOPEN: FAILED\n");
		}
		
		if (function_exists("curl_init") && function_exists("curl_setopt") && function_exists("curl_exec")) {
			echo("CURL: SUCCESS\n");
		} else {
			echo("CURL: FAILED\n");
		}
		
		if (function_exists("bzdecompress")) {
			echo("BZ2: SUCCESS\n");
		} else {
			echo("BZ2: FAILED\n");
		}

		if (extension_loaded('gd')) {
			echo("GD: SUCCESS\n");
		} else {
			echo("GD: FAILED\n");
		}
	}

?>


<!DOCTYPE html>
<html>
	<head>
		<title>LGSL Installation Page</title>
		<link rel='stylesheet' type='text/css' href='lgsl_files/styles/darken_style.css' />
		<link rel="icon" href="lgsl_files/other/favicon.ico" type="image/x-icon">
		<link rel="shortcut icon" href="lgsl_files/other/favicon.ico" type="image/x-icon">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
		<meta http-equiv='content-style-type' content='text/css' />
		<style>
			body {
				padding: 2px 4px;
			}
			input[type="text"], input[type="password"] {
				float: right;
			}
			div#container{
				width: inherit !important;
			}
			div#container > div{
				max-width: 375px;
				margin: auto;
			}
			h5 {
				float: right;
				margin: 0;
				text-decoration: underline;
			}
			button{
				margin: auto;
				display: block;
				width: 50%;
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
		</style>
	</head>

	<body>
		<div id="container">
			<div>
<?php
//------------------------------------------------------------------------------------------------------------+

	$output = '
	<h6><a href="./"><l k="back"></l></a> | <a href="?test"><l k="check"></l></a></h6>
	<h5><a href="https://github.com/tltneon/lgsl/wiki/How-to-install-LGSL" target="_blank"><l k="owiki"></l></a></h5>
	<h4><l k="step1"></l></h4>
	<form method="post" action="?">
		<p>
			MySQL Server*:
			<input type="text" name="server" onChange="vars.mysql_server = event.target.value" value="'.$mysql_server.'" '.$installed.' />
		</p>
		<p>
			MySQL Login*:
			<input type="text" name="login" onChange="vars.mysql_user = event.target.value" value="'.$mysql_user.'" '.$installed.' />
		</p>
		<p>
			MySQL Password:
			<input type="password" name="password" onChange="vars.mysql_password = event.target.value" value="'.$mysql_password.'" '.$installed.' />
		</p>
		<p>
			MySQL Database*:
			<input type="text" name="database" onChange="vars.mysql_database = event.target.value" value="'.$mysql_database.'" '.$installed.' />
		</p>
		<p>
			MySQL Table*:
			<input type="text" name="table" onChange="vars.mysql_table = event.target.value" value="'.$mysql_table.'" '.$installed.' />
		</p>
		<input type="hidden" name="_createtables" value="1" />
		<button type="submit" '.$installed.'>
			<l k="creat"></l>
		</button>
	</form>

	'.($installed == "disabled" ? '<div><l k="cretd"></l></div>' : '').'

	<br />

	<h4><l k="step2"></l></h4>

	<p>
		LGSL Admin Login*:
		<input type="text" onChange="vars.lgsl_user = event.target.value" />
	</p>
	<p>
		LGSL Admin Password*:
		<input type="text" onChange="vars.lgsl_password = event.target.value" />
	</p>

	<hr />

	<p>
		<l k="selst"></l>:
		<select type="text" name="style" onChange="changeValue(event, {styleChanged: true})" />
			<option value="darken_style.css">Darken</option>
			<option value="ogp_style.css">OGP</option>
			<option value="material_style.css">Material Design</option>
			<option value="breeze_style.css">Breeze</option>
			<option value="parallax_style.css">Parallax</option>
			<option value="cards_style.css">Cards</option>
			<option value="classic_style.css">Classic</option>
			<option value="disc_ff_style.css">Disc FF</option>
			<option value="wallpaper_style.css">Wallpaper</option>
			<option value="showcase" style="color: green;">(external) Showcase</option>
		</select>
	</p>
	<p>
		<l k="sella"></l>:
		<select type="text" name="language" onChange="changeValue(event, {translationInput: true})" />
			<option value="english">English</option>
			<option value="russian">Русский</option>
			<option value="french">Français</option>
			<option value="german">Deutsch</option>
			<option value="spanish">Español</option>
			<option value="czech">Čeština</option>
			<option value="bulgarian">български</option>
			<option value="slovak">Slovenčina</option>
			<option value="arabic">اَلْعَرَبِيَّةُ</option>
			<option value="turkish">Türkçe</option>
			<option value="korean">한국어</option>
			<option value="romanian">Română</option>
			<option value="chinese_simplified">简体中文</option>
			<option value="help" style="color: green;">!Help to translate LGSL!</option>
		</select>
	</p>

	<p>
		<l k="selsc"></l> <a href="https://github.com/tltneon/lgsl/wiki/scripts" target="_blank" class="hinfolink">?</a>:
		<br /><input type="checkbox" id="parallax.js" name="scripts" onChange="changeCheckbox(event)" /> parallax (for Parallax Style)
		<br /><input type="checkbox" id="preview.js" name="scripts" onChange="changeCheckbox(event)" /> map preview (on server list)
		<br /><input type="checkbox" id="refresh.js" name="scripts" onChange="changeCheckbox(event)" /> refresh (manually refresh server status)
		<br /><input type="checkbox" id="flag-icon.js" name="scripts" onChange="changeCheckbox(event)" /> flag-icon (replacing with svg)
	</p>

	<hr />

	<p>
		<l k="sorts"></l>:
		<select type="text" name="sort_servers_by" onChange="changeValue(event)" />
			<option value="id">ID</option>
			<option value="type">Type</option>
			<option value="zone">Zone</option>
			<option value="players">Players</option>
			<option value="status">Status</option>
		</select>
	</p>
	<p>
		<l k="sortp"></l>:
		<select type="text" name="sort_players_by" onChange="changeValue(event)" />
			<option value="name">Name</option>
			<option value="score">Score</option>
			<option value="time">Time</option>
		</select>
	</p>
	<p>
		<l k="enaim"></l> <a href="https://github.com/tltneon/lgsl/wiki/LGSL-with-Image-Mod" target="_blank" class="hinfolink">?</a>:
		<input type="checkbox" name="image_mod" onChange="changeCheckbox(event)" />
	</p>
	<p>
		Enable Preloader <a href="https://github.com/tltneon/lgsl/wiki/features#preloader" target="_blank" class="hinfolink">?</a>:
		<input type="checkbox" name="preloader" onChange="changeCheckbox(event)" />
	</p>
	<p>
		Enable Pagination <a href="https://github.com/tltneon/lgsl/wiki/features#pagination" target="_blank" class="hinfolink">?</a>:
		<input type="checkbox" name="page_mod" onChange="changeCheckbox(event)" />
		<input type="number" min="5" max="35" value="15" onChange="vars.page_lim = event.target.value" />
	</p>
	<p>
		Automatically reload page:
		<input type="checkbox" name="autoreload" onChange="changeCheckbox(event)" />
	</p>
	<p>
		Time before a server needs updating:
		<input type="number" min="0" max="3600" value="60" onChange="vars.cache_time = event.target.value" />
	</p>
	<p>
		Enable server tracking (history) <a href="https://github.com/tltneon/lgsl/wiki/features#pagination" target="_blank" class="hinfolink">?</a>:
		<input type="checkbox" name="history" onChange="changeCheckbox(event)" />
	</p>
	<p>
		<l k="hideo"></l>:
		<input type="checkbox" name="hide_offline" onChange="changeCheckbox(event)" />
	</p>
	<p>
		<l k="pubad"></l>:
		<select type="text" name="public_add" onChange="changeValue(event)" />
			<option value="0" style="color: red;">Disabled</option>
			<option value="1" style="color: orange;">Enabled (require approval)</option>
			<option value="2" style="color: green;">Enabled (shows instantly)</option>
		</select>
	</p>
	<p>
		<l k="showt"></l>:
		<input type="checkbox" name="totals" onChange="changeCheckbox(event)" />
	</p>
	<p>
		<l k="showl"></l>:
		<select type="text" name="locations" onChange="changeValue(event)" />
			<option value="0" style="color: red;">Disabled</option>
			<option value="1" style="color: green;">Enabled</option>
			<option disabled style="background: gray;"></option>
			<option disabled>Select manually:</option>
<option value="\'AD\'">AD</option><option value="\'AE\'">AE</option><option value="\'AF\'">AF</option><option value="\'AG\'">AG</option><option value="\'AI\'">AI</option><option value="\'AL\'">AL</option><option value="\'AM\'">AM</option><option value="\'AN\'">AN</option><option value="\'AO\'">AO</option><option value="\'AR\'">AR</option><option value="\'AS\'">AS</option><option value="\'AT\'">AT</option><option value="\'AU\'">AU</option><option value="\'AW\'">AW</option><option value="\'AX\'">AX</option><option value="\'AZ\'">AZ</option><option value="\'BA\'">BA</option><option value="\'BB\'">BB</option><option value="\'BD\'">BD</option><option value="\'BE\'">BE</option><option value="\'BF\'">BF</option><option value="\'BG\'">BG</option><option value="\'BH\'">BH</option><option value="\'BI\'">BI</option><option value="\'BJ\'">BJ</option><option value="\'BM\'">BM</option><option value="\'BN\'">BN</option><option value="\'BO\'">BO</option><option value="\'BR\'">BR</option><option value="\'BS\'">BS</option><option value="\'BT\'">BT</option><option value="\'BV\'">BV</option><option value="\'BW\'">BW</option><option value="\'BY\'">BY</option><option value="\'BZ\'">BZ</option><option value="\'CA\'">CA</option><option value="\'CC\'">CC</option><option value="\'CD\'">CD</option><option value="\'CF\'">CF</option><option value="\'CG\'">CG</option><option value="\'CH\'">CH</option><option value="\'CI\'">CI</option><option value="\'CK\'">CK</option><option value="\'CL\'">CL</option><option value="\'CM\'">CM</option><option value="\'CN\'">CN</option><option value="\'CO\'">CO</option><option value="\'CR\'">CR</option><option value="\'CS\'">CS</option><option value="\'CU\'">CU</option><option value="\'CV\'">CV</option><option value="\'CX\'">CX</option><option value="\'CY\'">CY</option><option value="\'CZ\'">CZ</option><option value="\'DE\'">DE</option><option value="\'DJ\'">DJ</option><option value="\'DK\'">DK</option><option value="\'DM\'">DM</option><option value="\'DO\'">DO</option><option value="\'DZ\'">DZ</option><option value="\'EC\'">EC</option><option value="\'EE\'">EE</option><option value="\'EG\'">EG</option><option value="\'EH\'">EH</option><option value="\'ER\'">ER</option><option value="\'ES\'">ES</option><option value="\'ET\'">ET</option><option value="\'EU\'">EU</option><option value="\'FI\'">FI</option><option value="\'FJ\'">FJ</option><option value="\'FK\'">FK</option><option value="\'FM\'">FM</option><option value="\'FO\'">FO</option><option value="\'FR\'">FR</option><option value="\'GA\'">GA</option><option value="\'GB\'">GB</option><option value="\'GD\'">GD</option><option value="\'GE\'">GE</option><option value="\'GF\'">GF</option><option value="\'GH\'">GH</option><option value="\'GI\'">GI</option><option value="\'GL\'">GL</option><option value="\'GM\'">GM</option><option value="\'GN\'">GN</option><option value="\'GP\'">GP</option><option value="\'GQ\'">GQ</option><option value="\'GR\'">GR</option><option value="\'GS\'">GS</option><option value="\'GT\'">GT</option><option value="\'GU\'">GU</option><option value="\'GW\'">GW</option><option value="\'GY\'">GY</option><option value="\'HK\'">HK</option><option value="\'HM\'">HM</option><option value="\'HN\'">HN</option><option value="\'HR\'">HR</option><option value="\'HT\'">HT</option><option value="\'HU\'">HU</option><option value="\'ID\'">ID</option><option value="\'IE\'">IE</option><option value="\'IL\'">IL</option><option value="\'IN\'">IN</option><option value="\'IO\'">IO</option><option value="\'IQ\'">IQ</option><option value="\'IR\'">IR</option><option value="\'IS\'">IS</option><option value="\'IT\'">IT</option><option value="\'JM\'">JM</option><option value="\'JO\'">JO</option><option value="\'JP\'">JP</option><option value="\'KE\'">KE</option><option value="\'KG\'">KG</option><option value="\'KH\'">KH</option><option value="\'KI\'">KI</option><option value="\'KM\'">KM</option><option value="\'KN\'">KN</option><option value="\'KP\'">KP</option><option value="\'KR\'">KR</option><option value="\'KW\'">KW</option><option value="\'KY\'">KY</option><option value="\'KZ\'">KZ</option><option value="\'LA\'">LA</option><option value="\'LB\'">LB</option><option value="\'LC\'">LC</option><option value="\'LI\'">LI</option><option value="\'LK\'">LK</option><option value="\'LR\'">LR</option><option value="\'LS\'">LS</option><option value="\'LT\'">LT</option><option value="\'LU\'">LU</option><option value="\'LV\'">LV</option><option value="\'LY\'">LY</option><option value="\'MA\'">MA</option><option value="\'MC\'">MC</option><option value="\'MD\'">MD</option><option value="\'ME\'">ME</option><option value="\'MG\'">MG</option><option value="\'MH\'">MH</option><option value="\'MK\'">MK</option><option value="\'ML\'">ML</option><option value="\'MM\'">MM</option><option value="\'MN\'">MN</option><option value="\'MO\'">MO</option><option value="\'MP\'">MP</option><option value="\'MQ\'">MQ</option><option value="\'MR\'">MR</option><option value="\'MS\'">MS</option><option value="\'MT\'">MT</option><option value="\'MU\'">MU</option><option value="\'MV\'">MV</option><option value="\'MW\'">MW</option><option value="\'MX\'">MX</option><option value="\'MY\'">MY</option><option value="\'MZ\'">MZ</option><option value="\'NA\'">NA</option><option value="\'NC\'">NC</option><option value="\'NE\'">NE</option><option value="\'NF\'">NF</option><option value="\'NG\'">NG</option><option value="\'NI\'">NI</option><option value="\'NL\'">NL</option><option value="\'NO\'">NO</option><option value="\'NP\'">NP</option><option value="\'NR\'">NR</option><option value="\'NU\'">NU</option><option value="\'NZ\'">NZ</option><option value="\'OFF\'">OFF</option><option value="\'OM\'">OM</option><option value="\'PA\'">PA</option><option value="\'PE\'">PE</option><option value="\'PF\'">PF</option><option value="\'PG\'">PG</option><option value="\'PH\'">PH</option><option value="\'PK\'">PK</option><option value="\'PL\'">PL</option><option value="\'PM\'">PM</option><option value="\'PN\'">PN</option><option value="\'PR\'">PR</option><option value="\'PS\'">PS</option><option value="\'PT\'">PT</option><option value="\'PW\'">PW</option><option value="\'PY\'">PY</option><option value="\'QA\'">QA</option><option value="\'RE\'">RE</option><option value="\'RO\'">RO</option><option value="\'RS\'">RS</option><option value="\'RU\'">RU</option><option value="\'RW\'">RW</option><option value="\'SA\'">SA</option><option value="\'SB\'">SB</option><option value="\'SC\'">SC</option><option value="\'SD\'">SD</option><option value="\'SE\'">SE</option><option value="\'SG\'">SG</option><option value="\'SH\'">SH</option><option value="\'SI\'">SI</option><option value="\'SJ\'">SJ</option><option value="\'SK\'">SK</option><option value="\'SL\'">SL</option><option value="\'SM\'">SM</option><option value="\'SN\'">SN</option><option value="\'SO\'">SO</option><option value="\'SR\'">SR</option><option value="\'ST\'">ST</option><option value="\'SV\'">SV</option><option value="\'SY\'">SY</option><option value="\'SZ\'">SZ</option><option value="\'TC\'">TC</option><option value="\'TD\'">TD</option><option value="\'TF\'">TF</option><option value="\'TG\'">TG</option><option value="\'TH\'">TH</option><option value="\'TJ\'">TJ</option><option value="\'TK\'">TK</option><option value="\'TL\'">TL</option><option value="\'TM\'">TM</option><option value="\'TN\'">TN</option><option value="\'TO\'">TO</option><option value="\'TR\'">TR</option><option value="\'TT\'">TT</option><option value="\'TV\'">TV</option><option value="\'TW\'">TW</option><option value="\'TZ\'">TZ</option><option value="\'UA\'">UA</option><option value="\'UG\'">UG</option><option value="\'UM\'">UM</option><option value="\'US\'">US</option><option value="\'UY\'">UY</option><option value="\'UZ\'">UZ</option><option value="\'VA\'">VA</option><option value="\'VC\'">VC</option><option value="\'VE\'">VE</option><option value="\'VG\'">VG</option><option value="\'VI\'">VI</option><option value="\'VN\'">VN</option><option value="\'VU\'">VU</option><option value="\'WF\'">WF</option><option value="\'WS\'">WS</option><option value="\'YE\'">YE</option><option value="\'YT\'">YT</option><option value="\'ZA\'">ZA</option><option value="\'ZM\'">ZM</option><option value="\'ZW\'">ZW</option>
		</select>
	</p>

	<button onClick="generateConfig()">
		<l k="gener"></l>
	</button>

	<p style="color: red; font-size: 12pt;"><l k="remem"></l></p>
	<hr />
	<p style="font-size: 9pt;"><l k="after"></l></p>
	';

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
	function reloadLocale(){
		document.querySelectorAll("l").forEach(
			(item, i, arr)=>{
				updateLValue(item, item.getAttribute("k"));
			}
		);
	}
	var locale = "english";
	let vars = {
		mysql_server: "<?php echo $mysql_server; ?>",
		mysql_user: "<?php echo $mysql_user; ?>",
		mysql_password: "<?php echo $mysql_password; ?>",
		mysql_database: "<?php echo $mysql_database; ?>",
		mysql_table: "<?php echo $mysql_table; ?>",
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
		console.log(event);
		if(options.styleChanged){
			if(event.target.value == "showcase"){
				event.target.value = "darken_style.css";
				window.open("https://github.com/tltneon/lgsl/wiki/Styles");
			}
			if(event.target.value == "parallax_style.css"){
				vars["scripts"]["parallax.js"] = true;
				document.querySelector("input[id='parallax.js']").checked = true;
			}
			document.getElementsByTagName("link")[0].href = `lgsl_files/styles/${event.target.value}`;
		}
		if(options.translationInput){
			if(event.target.value == "help"){
				event.target.value = "english";
				window.open("https://github.com/tltneon/lgsl/wiki#how-do-i-change-language");
			}
			locale = event.target.value;
			document.dispatchEvent(new Event("reloadLocale"));
		}
		vars[event.target.name] = event.target.value;
	}
	function changeCheckbox(event) {
		if(event.target.name == 'scripts'){
			vars[event.target.name][event.target.id] = event.target.checked;
		}
		else
		vars[event.target.name] = event.target.checked;
	}
	function updateLValue(el, key){
		el.innerText = "";
		el.insertAdjacentHTML('beforeend', l(key));
	}
	function generateConfig()
	{
		if(vars.mysql_user == "" || vars.lgsl_user == "" || vars.lgsl_password == "") return alert(l("filla"));
		let textarea = document.body.getElementsByTagName("textarea")[0] ? document.body.getElementsByTagName("textarea")[0] : document.createElement("textarea");
		let slist = '';
		for(s in vars['scripts']){
			if(vars['scripts'][s])
				slist += '"' + s + '",';
		}
		document.body.getElementsByTagName("div")[0].appendChild(textarea);
		textarea.innerHTML = "&lt;?php \n" +
		"global $lgsl_config; $lgsl_config = array(); \n" +
		"$lgsl_config['feed']['method'] = 0; \n" +
		"$lgsl_config['feed']['url'] = \"http://www.greycube.co.uk/lgsl/feed/lgsl_files/lgsl_feed.php\"; \n" +
		"$lgsl_config['style'] = \""+ vars.style +"\"; // options: breeze_style.css, darken_style.css, classic_style.css, ogp_style.css, parallax_style.css, disc_ff_style.css, materials_style.css \n" +
		"$lgsl_config['scripts'] = ["+ slist +"]; \n" +
		"$lgsl_config['locations'] = "+ vars.locations +"; \n" +
		"$lgsl_config['list']['totals'] = "+ vars.totals +"; \n" +
		"$lgsl_config['sort']['servers'] = \""+ vars.sort_servers_by +"\";	// OPTIONS: id  type  zone  players  status \n" +
		"$lgsl_config['sort']['players'] = \""+ vars.sort_players_by +"\";	// OPTIONS: name  score \n" +
		"$lgsl_config['zone']['width'] = \"160\"; // images will be cropped unless also resized to match \n" +
		"$lgsl_config['zone']['line_size'] = \"19\";  // player box height is this number multiplied by player names \n" +
		"$lgsl_config['zone']['height'] = \"100\"; // player box height limit \n" +
		"$lgsl_config['grid'][1] = 1; \n" +
		"$lgsl_config['grid'][2] = 1; \n" +
		"$lgsl_config['grid'][3] = 1; \n" +
		"$lgsl_config['grid'][4] = 1; \n" +
		"$lgsl_config['grid'][5] = 1; \n" +
		"$lgsl_config['grid'][6] = 1; \n" +
		"$lgsl_config['grid'][7] = 1; \n" +
		"$lgsl_config['grid'][8] = 1; \n" +
		"$lgsl_config['players'][1] = 1; \n" +
		"$lgsl_config['players'][2] = 1; \n" +
		"$lgsl_config['players'][3] = 1; \n" +
		"$lgsl_config['players'][4] = 1; \n" +
		"$lgsl_config['players'][5] = 1; \n" +
		"$lgsl_config['players'][6] = 1; \n" +
		"$lgsl_config['players'][7] = 1; \n" +
		"$lgsl_config['players'][8] = 1; \n" +
		"$lgsl_config['random'][0] = 0; \n" +
		"$lgsl_config['random'][1] = 0; \n" +
		"$lgsl_config['random'][2] = 0; \n" +
		"$lgsl_config['random'][3] = 0; \n" +
		"$lgsl_config['random'][4] = 0; \n" +
		"$lgsl_config['random'][5] = 0; \n" +
		"$lgsl_config['random'][6] = 0; \n" +
		"$lgsl_config['random'][7] = 0; \n" +
		"$lgsl_config['random'][8] = 0; \n" +
		"$lgsl_config['hide_offline'][0] = "+ vars.hide_offline +"; \n" +
		"$lgsl_config['hide_offline'][1] = 0; \n" +
		"$lgsl_config['hide_offline'][2] = 0; \n" +
		"$lgsl_config['hide_offline'][3] = 0; \n" +
		"$lgsl_config['hide_offline'][4] = 0; \n" +
		"$lgsl_config['hide_offline'][5] = 0; \n" +
		"$lgsl_config['hide_offline'][6] = 0; \n" +
		"$lgsl_config['hide_offline'][7] = 0; \n" +
		"$lgsl_config['hide_offline'][8] = 0; \n" +
		"$lgsl_config['title'][0] = \"Live Game Server List\"; \n" +
		"$lgsl_config['title'][1] = \"Game Server\"; \n" +
		"$lgsl_config['title'][2] = \"Game Server\"; \n" +
		"$lgsl_config['title'][3] = \"Game Server\"; \n" +
		"$lgsl_config['title'][4] = \"Game Server\"; \n" +
		"$lgsl_config['title'][5] = \"Game Server\"; \n" +
		"$lgsl_config['title'][6] = \"Game Server\"; \n" +
		"$lgsl_config['title'][7] = \"Game Server\"; \n" +
		"$lgsl_config['title'][8] = \"Game Server\"; \n" +
		"$lgsl_config['admin']['user'] = \""+ vars.lgsl_user +"\"; \n" +
		"$lgsl_config['admin']['pass'] = \""+ vars.lgsl_password +"\"; \n" +
		"$lgsl_config['db']['server']  = \""+ vars.mysql_server +"\"; \n" +
		"$lgsl_config['db']['user']    = \""+ vars.mysql_user +"\"; \n" +
		"$lgsl_config['db']['pass']    = \""+ vars.mysql_password +"\"; \n" +
		"$lgsl_config['db']['db']      = \""+ vars.mysql_database +"\"; \n" +
		"$lgsl_config['db']['table']   = \""+ vars.mysql_table +"\"; \n" +
		"$lgsl_config['image_mod']     = "+ vars.image_mod +"; \n" +
		"$lgsl_config['preloader']     = "+ vars.preloader +";   // true=using ajax to faster loading page\n" +
		"$lgsl_config['disabled_types']= false;     // allow to exclude some protocols (games) from list. usage: $lgsl_config['disabled_types']= array('warsowold', 'halflifewon', 'test');\n" +
		"$lgsl_config['pagination_mod']= "+ vars.page_mod +";   // true = using pagination\n" +
		"$lgsl_config['pagination_lim']= "+ vars.page_lim +";   // limit per page\n" +
		"$lgsl_config['direct_index']  = 0;                     // 1=link to index.php instead of the folder \n" +
		"$lgsl_config['no_realpath']   = 0;                     // 1=do not use the realpath function \n" +
		"$lgsl_config['url_path']      = \"\";                  // full url to /lgsl_files/ for when auto detection fails \n" +
		"$lgsl_config['management']    = 0;                     // 1=show advanced management in the admin by default \n" +
		"$lgsl_config['host_to_ip']    = 0;                     // 1=show the servers ip instead of its hostname \n" +
		"$lgsl_config['public_add']    = "+ vars.public_add +"; // 1=servers require approval OR 2=servers shown instantly \n" +
		"$lgsl_config['public_feed']   = 0;                     // 1=feed requests can add new servers to your list \n" +
		"$lgsl_config['cache_time']    = "+ vars.cache_time +"; // seconds=time before a server needs updating \n" +
		"$lgsl_config['autoreload']    = "+ vars.autoreload +"; // 1=reloads page when cache_time is passed \n" +
		"$lgsl_config['history']       = "+ vars.history +";    // 1=reloads page when cache_time is passed \n" +
		"$lgsl_config['live_time']     = 3;                     // seconds=time allowed for updating servers per page load \n" +
		"$lgsl_config['timeout']       = 0;                     // 1=gives more time for servers to respond but adds loading delay \n" +
		"$lgsl_config['retry_offline'] = 0;                     // 1=repeats query when there is no response but adds loading delay \n" +
		"$lgsl_config['cms']           = \"sa\";                // sets which CMS specific code to use \n" +
		"include(\"languages/"+ vars.language +".php\");        // sets LGSL language";
		textarea.style.width = "100%";
		textarea.style.height = "90vh";
		window.scrollTo(0, document.body.scrollHeight);
	}

	function l(key){
		let t = {
			"english": {
				"tablc": "LGSL table created <span style='color: green;'>successfully</span>.",
				"filli": "You need to fill inputs (<span style='color:red'>step 1</span>) correctly.",
				"consu": "Connection <span style='color: green;'>successfully</span> established, LGSL can take data from game servers.",
				"coutd": "LGSL <span style='color: red;'>couldn't take data from most of game servers</span> due to UDP upflow is blocked on your hosting.",
				"remem": "Remember to remove the install.php after install LGSL!",
				"after": "After you make config, replace it into lgsl_files/lgsl_config.php",
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
				"step1": "Step 1: Install LGSL Tables",
				"step2": "Step 2: Configurating LGSL",
				"back": "< Back",
				"owiki": "Online Wiki: How to",
				"gener": "Generate config",
				"creat": "Create table",
				"filla": "You need to fill required* inputs (step 1 or 2).",
				"mysld": "Connect <span style='color: red;'>failed</span>: mysqli extension doesn't active.",
				"table": "LGSL <span style='color: red;'>table wasn't created</span>: wrong database name or table already exists.",
				"cretd": "Table <span style='color: green;'>successfully</span> created! Get to Step 2.",
                "check": "Check requirements",
			},
			"russian": {
				"tablc": "LGSL table created <span style='color: green;'>successfully</span>.",
				"filli": "You need to fill inputs (<span style='color:red'>step 1</span>) correctly.",
				"consu": "Connection <span style='color: green;'>successfully</span> established, LGSL can take data from game servers.",
				"coutd": "LGSL <span style='color: red;'>couldn't take data from most of game servers</span> due to UDP upflow is blocked on your hosting.",
				"remem": "Remember to remove the install.php after install LGSL!",
				"after": "After you make config, replace it into lgsl_files/lgsl_config.php",
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
				"step1": "Step 1: Install LGSL Tables",
				"step2": "Step 2: Configurating LGSL",
				"back": "< Назад",
				"owiki": "Online Wiki: How to",
				"gener": "Generate config",
				"creat": "Create table",
				"filla": "You need to fill required* inputs (step 1 or 2).",
				"mysld": "Connect <span style='color: red;'>failed</span>: mysqli extension doesn't active.",
				"table": "LGSL <span style='color: red;'>table wasn't created</span>: wrong database name or table already exists.",
				"cretd": "Table <span style='color: green;'>successfully</span> created! Get to Step 2.",
                "check": "Check requirements",
			},
			"french": {
				"tablc": "LGSL table created <span style='color: green;'>successfully</span>.",
				"filli": "You need to fill inputs (<span style='color:red'>step 1</span>) correctly.",
				"consu": "Connection <span style='color: green;'>successfully</span> established, LGSL can take data from game servers.",
				"coutd": "LGSL <span style='color: red;'>couldn't take data from most of game servers</span> due to UDP upflow is blocked on your hosting.",
				"remem": "Remember to remove the install.php after install LGSL!",
				"after": "After you make config, replace it into lgsl_files/lgsl_config.php",
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
				"step1": "Step 1: Install LGSL Tables",
				"step2": "Step 2: Configurating LGSL",
				"back": "< Arrière",
				"owiki": "Online Wiki: How to",
				"gener": "Generate config",
				"creat": "Create table",
				"filla": "You need to fill required* inputs (step 1 or 2).",
				"mysld": "Connect <span style='color: red;'>failed</span>: mysqli extension doesn't active.",
				"table": "LGSL <span style='color: red;'>table wasn't created</span>: wrong database name or table already exists.",
				"cretd": "Table <span style='color: green;'>successfully</span> created! Get to Step 2.",
                "check": "Check requirements",
			},
			"german": {
				"tablc": "LGSL table created <span style='color: green;'>successfully</span>.",
				"filli": "You need to fill inputs (<span style='color:red'>step 1</span>) correctly.",
				"consu": "Connection <span style='color: green;'>successfully</span> established, LGSL can take data from game servers.",
				"coutd": "LGSL <span style='color: red;'>couldn't take data from most of game servers</span> due to UDP upflow is blocked on your hosting.",
				"remem": "Remember to remove the install.php after install LGSL!",
				"after": "After you make config, replace it into lgsl_files/lgsl_config.php",
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
				"step1": "Step 1: Install LGSL Tables",
				"step2": "Step 2: Configurating LGSL",
				"back": "< Zurück",
				"owiki": "Online Wiki: How to",
				"gener": "Generate config",
				"creat": "Create table",
				"filla": "You need to fill required* inputs (step 1 or 2).",
				"mysld": "Connect <span style='color: red;'>failed</span>: mysqli extension doesn't active.",
				"table": "LGSL <span style='color: red;'>table wasn't created</span>: wrong database name or table already exists.",
				"cretd": "Table <span style='color: green;'>successfully</span> created! Get to Step 2.",
                "check": "Check requirements",
			},
			"spanish": {
				"tablc": "LGSL table created <span style='color: green;'>successfully</span>.",
				"filli": "You need to fill inputs (<span style='color:red'>step 1</span>) correctly.",
				"consu": "Connection <span style='color: green;'>successfully</span> established, LGSL can take data from game servers.",
				"coutd": "LGSL <span style='color: red;'>couldn't take data from most of game servers</span> due to UDP upflow is blocked on your hosting.",
				"remem": "Remember to remove the install.php after install LGSL!",
				"after": "After you make config, replace it into lgsl_files/lgsl_config.php",
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
				"step1": "Step 1: Install LGSL Tables",
				"step2": "Step 2: Configurating LGSL",
				"back": "< Espalda",
				"owiki": "Online Wiki: How to",
				"gener": "Generate config",
				"creat": "Create table",
				"filla": "You need to fill required* inputs (step 1 or 2).",
				"mysld": "Connect <span style='color: red;'>failed</span>: mysqli extension doesn't active.",
				"table": "LGSL <span style='color: red;'>table wasn't created</span>: wrong database name or table already exists.",
				"cretd": "Table <span style='color: green;'>successfully</span> created! Get to Step 2.",
                "check": "Check requirements",
			},
			"czech": {
				"tablc": "LGSL table created <span style='color: green;'>successfully</span>.",
				"filli": "You need to fill inputs (<span style='color:red'>step 1</span>) correctly.",
				"consu": "Connection <span style='color: green;'>successfully</span> established, LGSL can take data from game servers.",
				"coutd": "LGSL <span style='color: red;'>couldn't take data from most of game servers</span> due to UDP upflow is blocked on your hosting.",
				"remem": "Remember to remove the install.php after install LGSL!",
				"after": "After you make config, replace it into lgsl_files/lgsl_config.php",
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
				"step1": "Step 1: Install LGSL Tables",
				"step2": "Step 2: Configurating LGSL",
				"back": "< Zadní",
				"owiki": "Online Wiki: How to",
				"gener": "Generate config",
				"creat": "Create table",
				"filla": "You need to fill required* inputs (step 1 or 2).",
				"mysld": "Connect <span style='color: red;'>failed</span>: mysqli extension doesn't active.",
				"table": "LGSL <span style='color: red;'>table wasn't created</span>: wrong database name or table already exists.",
				"cretd": "Table <span style='color: green;'>successfully</span> created! Get to Step 2.",
                "check": "Check requirements",
			},
			"bulgarian": {
				"tablc": "LGSL table created <span style='color: green;'>successfully</span>.",
				"filli": "You need to fill inputs (<span style='color:red'>step 1</span>) correctly.",
				"consu": "Connection <span style='color: green;'>successfully</span> established, LGSL can take data from game servers.",
				"coutd": "LGSL <span style='color: red;'>couldn't take data from most of game servers</span> due to UDP upflow is blocked on your hosting.",
				"remem": "Remember to remove the install.php after install LGSL!",
				"after": "After you make config, replace it into lgsl_files/lgsl_config.php",
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
				"step1": "Step 1: Install LGSL Tables",
				"step2": "Step 2: Configurating LGSL",
				"back": "< Обратно",
				"owiki": "Online Wiki: How to",
				"gener": "Generate config",
				"creat": "Create table",
				"filla": "You need to fill required* inputs (step 1 or 2).",
				"mysld": "Connect <span style='color: red;'>failed</span>: mysqli extension doesn't active.",
				"table": "LGSL <span style='color: red;'>table wasn't created</span>: wrong database name or table already exists.",
				"cretd": "Table <span style='color: green;'>successfully</span> created! Get to Step 2.",
                "check": "Check requirements",
			},
			"slovak": {
				"tablc": "LGSL tabuľka bola vytvorená <span style='color: green;'>úspešne</span>.",
				"filli": "Musíte vyplniť formulár (<span style='color:red'>krok 1</span>) správne.",
				"consu": "Spojenie bolo <span style='color: green;'>úspešne</span> nadviazané, LGSL môže brať údaje z herných serverov.",
				"coutd": "LGSL <span style='color: red;'>nemôže získať údaje z herného servera</span>, iba teamspeak server (UDP upflow je zakázané na vašom hostingu).",
				"remem": "Nezabudni vymazať súbor install.php po nainštalovaní LGSL!",
				"after": "Potom čo vytvoríš konfiguraciu, vymeň subor za lgsl_files/lgsl_config.php",
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
				"cretd": "Table <span style='color: green;'>successfully</span> created! Get to Step 2.",
                "check": "Check requirements",
			},
			"arabic": {
				"tablc": "LGSL table created <span style='color: green;'>successfully</span>.",
				"filli": "You need to fill inputs (<span style='color:red'>step 1</span>) correctly.",
				"consu": "Connection <span style='color: green;'>successfully</span> established, LGSL can take data from game servers.",
				"coutd": "LGSL <span style='color: red;'>couldn't take data from most of game servers</span> due to UDP upflow is blocked on your hosting.",
				"remem": "Remember to remove the install.php after install LGSL!",
				"after": "After you make config, replace it into lgsl_files/lgsl_config.php",
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
				"step1": "Step 1: Install LGSL Tables",
				"step2": "Step 2: Configurating LGSL",
				"back": "< Back",
				"owiki": "Online Wiki: How to",
				"gener": "Generate config",
				"creat": "Create table",
				"filla": "You need to fill required* inputs (step 1 or 2).",
				"mysld": "Connect <span style='color: red;'>failed</span>: mysqli extension doesn't active.",
				"table": "LGSL <span style='color: red;'>table wasn't created</span>: wrong database name or table already exists.",
				"cretd": "Table <span style='color: green;'>successfully</span> created! Get to Step 2.",
                "check": "Check requirements",
			},
			"turkish": {
				"tablc": "LGSL tablosu oluşturuldu <span style='color: green;'>Başarıyla Tamamlandı!</span>.",
				"filli": "Girişleri doldurmanız gerekiyor (<span style='color:red'>1'inci Adımı</span>) Kontrol Ediniz.",
				"consu": "Bağlantı <span style='color: green;'>Başarıyla</span> kuruldu, LGSL oyun sunucularından veri alabilir.",
				"coutd": "LGSL <span style='color: red;'>Barındırma işleminizde UDP yukarı akışı engellendiğinden</span> oyun sunucularının çoğundan veri alınamadı.",
				"remem": "LGSL'yi kurduktan sonra install.php'yi kaldırmayı unutmayın!",
				"after": "Yapılandırmayı yaptıktan sonra, onu lgsl_files/lgsl_config.php olarak değiştirin",
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
                "check": "Check requirements",
			},
			"romanian": {
				"tablc": "Tabelul LGSL a fost creat cu <span style='color: green;'>success</span>.",
				"filli": "Trebuie să completezi câmpurile (<span style='color:red'>pasul 1</span>) corect.",
				"consu": "Conexiunea a fost stabilită cu <span style='color: green;'>succes</span>, LGSL poate prelua date de la serverele de jocuri.",
				"coutd": "LGSL <span style='color: red;'>nu a putut prelua date de la majoritatea serverelor de jocuri</span> deoarece traficul UDP este blocat pe găzduirea dvs.",
				"remem": "Nu uitați să eliminați install.php după instalarea LGSL!",
				"after": "După ce finalizați configurația, înlocuiți-o în lgsl_files/lgsl_config.php",
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
				"after": "설정 후 lgsl_files/lgsl_config.php로 변경",
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
                "check": "Check requirements",
			},
            "chinese_simplified": {
                "tablc": "LGSL 数据表创建 <span style='color: green;'>成功</span>.",
                "filli": "您必须确保必填项 (<span style='color:red'>步骤1</span>) 正确.",
                "consu": "连接 <span style='color: green;'>成功</span> 确认, LGSL 可以从游戏服务器获取数据。",
                "coutd": "LGSL <span style='color: red;'>无法从大多数游戏服务器获取数据</span> ，因为UDP upflow在您的当前服务器主机上被阻止。",
                "remem": "请务必在LGSL安装成功删除install.php",
                "after": "接下来, 请将它替换到 lgsl_files/lgsl_config.php",
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
                "check": "Check requirements",
            }
		};
		return t[locale][key];
	}
</script>
