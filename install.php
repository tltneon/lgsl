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
		
	if(!empty($_POST["server"]) && !empty($_POST["login"]) && !empty($_POST["database"]) && !empty($_POST["table"])){
		$lgsl_database = mysqli_connect($mysql_server, $mysql_user, $mysql_password);
			
		if (!$lgsl_database) {
				printf("Connect failed: wrong mysql server, username or password (%s)\n", mysqli_connect_error());
		}
		else {
			$lgsl_select_db = mysqli_select_db($lgsl_database, $_POST["database"]);
			if(mysqli_query($lgsl_database, "
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
					`cache`      TEXT          NOT NULL,
					`cache_time` TEXT          NOT NULL,

					PRIMARY KEY (`id`)

				) ENGINE=MyISAM CHARSET=utf8 COLLATE=utf8_unicode_ci;") === TRUE){
					printf("LGSL table created successfully\n");
					$installed = "disabled";
				}
				else {
					printf("LGSL table wasn't created: wrong database name or table ".$_POST["table"]." already exists\n");
				}
			mysqli_close($lgsl_database);
		}
	}
	
?>


<!DOCTYPE html>
<html>
	<head>
		<title>LGSL Installation Page</title>
		<link rel='stylesheet' type='text/css' />
		<link rel="icon" href="lgsl_files/other/favicon.ico" type="image/x-icon">
		<link rel="shortcut icon" href="lgsl_files/other/favicon.ico" type="image/x-icon">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
		<meta http-equiv='content-style-type' content='text/css' />
		<style>
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
		</style>
	</head>

	<body>
		<div id="container">
			<div>
<?php
//------------------------------------------------------------------------------------------------------------+

	$output = '
	<h5><a href="https://github.com/tltneon/lgsl/wiki/How-to-install-LGSL">Online Wiki: How to</a></h5>
	<h4>Step 1: Install LGSL Tables</h4>
	<form method="post" action="">
		<p>
			MySQL Server:
			<input type="text" name="server" onChange="vars.mysql_server = event.target.value" value="'.$mysql_server.'" '.$installed.' />
		</p>
		<p>
			MySQL Login:
			<input type="text" name="login" onChange="vars.mysql_user = event.target.value" value="'.$mysql_user.'" '.$installed.' />
		</p>
		<p>
			MySQL Password:
			<input type="password" name="password" onChange="vars.mysql_password = event.target.value" value="'.$mysql_password.'" '.$installed.' />
		</p>
		<p>
			MySQL Database:
			<input type="text" name="database" onChange="vars.mysql_database = event.target.value" value="'.$mysql_database.'" '.$installed.' />
		</p>
		<p>
			MySQL Table:
			<input type="text" name="table" onChange="vars.mysql_table = event.target.value" value="'.$mysql_table.'" '.$installed.' />
		</p>
		<input type="submit" value="Create tables" '.$installed.'>
	</form>
	
	<br />
	
	<h4>Step 2: Configurating LGSL</h4>
	
	<p>
		LGSL Admin Login:
		<input type="text" onChange="vars.lgsl_user = event.target.value" />
	</p>
	<p>
		LGSL Admin Password:
		<input type="text" onChange="vars.lgsl_password = event.target.value" />
	</p>
	
	<hr />
	
	<p>
		Select style:
		<select type="text" name="style" onChange="changeValue(event, true)" />
			<option value="darken_style.css">Darken</option>
			<option value="ogp_style.css">OGP</option>
			<option value="breeze_style.css">Breeze</option>
			<option value="classic_style.css">Classic</option>
			<option value="parallax_style.css">Parallax</option>
			<option value="disc_ff_style.css">Disc FF</option>
			<option value="material_style.css">Material Design</option>
		</select>
	</p>
	<p>
		Select language:
		<select type="text" name="language" onChange="changeValue(event)" />
			<option value="english">English</option>
			<option value="russian">Русский</option>
			<option value="french">Français</option>
			<option value="german">Deutsch</option>
			<option value="spanish">Español</option>
			<option value="czech">Čeština</option>
			<option value="bulgarian">български</option>
		</select>
	</p>
	
	<hr />
	
	<p>
		Sort servers by:
		<select type="text" name="sort_servers_by" onChange="changeValue(event)" />
			<option value="id">ID</option>
			<option value="type">Type</option>
			<option value="zone">Zone</option>
			<option value="players">Players</option>
			<option value="status">Status</option>
		</select>
	</p>
	<p>
		Sort players by:
		<select type="text" name="sort_players_by" onChange="changeValue(event)" />
			<option value="name">Name</option>
			<option value="score">Score</option>
		</select>
	</p>
	<p>
		Hide offline servers:
		<input type="checkbox" name="hide_offline" onChange="changeCheckbox(event)" />
	</p>	
	<p>
		Public add servers:
		<input type="checkbox" name="public_add" onChange="changeCheckbox(event)" />
	</p>	
	<p>
		Show totals:
		<input type="checkbox" name="totals" onChange="changeCheckbox(event)" />
	</p>	
	<p>
		Show locations:
		<input type="checkbox" name="locations" onChange="changeCheckbox(event)" />
	</p>	
	
	<input type="submit" value="Generate config" onClick="generateConfig()" / >
	<p style="color: red; font-size: 9pt;">* Remember to remove the install.php after install LGSL!</p>
	<hr />
	
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
		language: "english",
		sort_servers_by: "id",
		sort_players_by: "name",
		hide_offline: false,
		public_add: false,
		totals: false,
		locations: false
	}
	function changeValue(event, isStyleChanged = false) {
		if(isStyleChanged)
			document.getElementsByTagName("link")[0].href = href='lgsl_files/styles/'+event.target.value;
		vars[event.target.name] = event.target.value;
	}
	function changeCheckbox(event) {
		vars[event.target.name] = event.target.checked;
	}
	
	function generateConfig()
	{
		if(vars.mysql_user == "" || vars.lgsl_user == "" || vars.lgsl_password == "") return alert("You need to fill inputs");
		let textarea = document.body.getElementsByTagName("textarea")[0] ? document.body.getElementsByTagName("textarea")[0] : document.createElement("textarea");
		document.body.getElementsByTagName("div")[0].appendChild(textarea);
		textarea.innerHTML = "&lt;?php \n" +
		"global $lgsl_config; $lgsl_config = array(); \n" +
		"$lgsl_config['feed']['method'] = 0; \n" +
		"$lgsl_config['feed']['url']    = \"http://www.greycube.co.uk/lgsl/feed/lgsl_files/lgsl_feed.php\"; \n" +
		"$lgsl_config['style'] = \""+ vars.style +"\"; // options: breeze_style.css, darken_style.css, classic_style.css, ogp_style.css, parallax_style.css, disc_ff_style.css \n" +
		"$lgsl_config['scripts'] = ['parallax.js']; \n" +
		"$lgsl_config['locations'] = "+ vars.locations +"; \n" +
		"$lgsl_config['list']['totals'] = "+ vars.totals +"; \n" +
		"$lgsl_config['sort']['servers'] = \""+ vars.sort_servers_by +"\";   // OPTIONS: id  type  zone  players  status \n" +
		"$lgsl_config['sort']['players'] = \""+ vars.sort_players_by +"\"; // OPTIONS: name  score \n" +
		"$lgsl_config['zone']['width']     = \"160\"; // images will be cropped unless also resized to match \n" +
		"$lgsl_config['zone']['line_size'] = \"19\";  // player box height is this number multiplied by player names \n" +
		"$lgsl_config['zone']['height']    = \"100\"; // player box height limit \n" +
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
		"$lgsl_config['db']['server'] = \""+ vars.mysql_server +"\"; \n" +
		"$lgsl_config['db']['user']   = \""+ vars.mysql_user +"\"; \n" +
		"$lgsl_config['db']['pass']   = \""+ vars.mysql_password +"\"; \n" +
		"$lgsl_config['db']['db']     = \""+ vars.mysql_database +"\"; \n" +
		"$lgsl_config['db']['table']  = \""+ vars.mysql_table +"\"; \n" +
		"$lgsl_config['direct_index'] = 0;  // 1=link to index.php instead of the folder \n" +
		"$lgsl_config['no_realpath']  = 0;  // 1=do not use the realpath function \n" +
		"$lgsl_config['url_path']     = \"\"; // full url to /lgsl_files/ for when auto detection fails \n" +
		"$lgsl_config['management']    = 0;         // 1=show advanced management in the admin by default \n" +
		"$lgsl_config['host_to_ip']    = 0;         // 1=show the servers ip instead of its hostname \n" +
		"$lgsl_config['public_add']    = "+ vars.public_add +";         // 1=servers require approval OR 2=servers shown instantly \n" +
		"$lgsl_config['public_feed']   = 0;         // 1=feed requests can add new servers to your list \n" +
		"$lgsl_config['cache_time']    = 60;        // seconds=time before a server needs updating \n" +
		"$lgsl_config['live_time']     = 3;         // seconds=time allowed for updating servers per page load \n" +
		"$lgsl_config['timeout']       = 0;         // 1=gives more time for servers to respond but adds loading delay \n" +
		"$lgsl_config['retry_offline'] = 0;         // 1=repeats query when there is no response but adds loading delay \n" +
		"$lgsl_config['cms']           = \"sa\";      // sets which CMS specific code to use \n" +
		"include(\"languages/"+ vars.language +".php\");									// sets LGSL language";
		textarea.style.width = "100%";
		textarea.style.height = "100vh";
	}
</script>
