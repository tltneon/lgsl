<?php

//------------------------------------------------------------------------------------------------------------+
//[ PREPARE CONFIG - DO NOT CHANGE OR MOVE THIS ]

  global $lgsl_config; $lgsl_config = array();

//------------------------------------------------------------------------------------------------------------+
//[ FEED: 0=OFF 1=CURL OR FSOCKOPEN 2=FSOCKOPEN ONLY / LEAVE THE URL ALONE UNLESS YOU KNOW WHAT YOUR DOING ]

  $lgsl_config['feed']['method'] = 0;
  $lgsl_config['feed']['url']    = "http://www.greycube.co.uk/lgsl/feed/lgsl_files/lgsl_feed.php";

//------------------------------------------------------------------------------------------------------------+
//[ BACKGROUND COLORS: TEXT HARD TO READ ? CHANGE THESE TO CONTRAST THE FONT COLOR / www.colorpicker.com ]

  $lgsl_config['style'] = "breeze_style.css";
	$lgsl_config['background'][1] = "background-color:#e4eaf2";
  $lgsl_config['background'][2] = "background-color:#f4f7fa";

//------------------------------------------------------------------------------------------------------------+
//[ SHOW LOCATION FLAGS: 0=OFF 1=GEO-IP "GB"=MANUALLY SET COUNTRY CODE FOR SPEED ]

  $lgsl_config['locations'] = 0;

//------------------------------------------------------------------------------------------------------------+
//[ SHOW TOTAL SERVERS AND PLAYERS AT BOTTOM OF LIST: 0=OFF 1=ON ]

  $lgsl_config['list']['totals'] = 0;

//------------------------------------------------------------------------------------------------------------+
//[ SORTING OPTIONS ]

  $lgsl_config['sort']['servers'] = "id";   // OPTIONS: id  type  zone  players  status
  $lgsl_config['sort']['players'] = "name"; // OPTIONS: name  score

//------------------------------------------------------------------------------------------------------------+
//[ ZONE SIZING: HEIGHT OF PLAYER BOX DYNAMICALLY CHANGES WITH THE NUMBER OF PLAYERS ]

  $lgsl_config['zone']['width']     = "160"; // images will be cropped unless also resized to match
  $lgsl_config['zone']['line_size'] = "19";  // player box height is this number multiplied by player names
  $lgsl_config['zone']['height']    = "100"; // player box height limit

//------------------------------------------------------------------------------------------------------------+
//[ ZONE GRID: NUMBER=WIDTH OF GRID - INCREASE FOR HORIZONTAL ZONE STACKING ]

  $lgsl_config['grid'][1] = 1;
  $lgsl_config['grid'][2] = 1;
  $lgsl_config['grid'][3] = 1;
  $lgsl_config['grid'][4] = 1;
  $lgsl_config['grid'][5] = 1;
  $lgsl_config['grid'][6] = 1;
  $lgsl_config['grid'][7] = 1;
  $lgsl_config['grid'][8] = 1;

//------------------------------------------------------------------------------------------------------------+
//[ ZONE SHOWS PLAYER NAMES: 0=HIDE 1=SHOW ]

  $lgsl_config['players'][1] = 1;
  $lgsl_config['players'][2] = 1;
  $lgsl_config['players'][3] = 1;
  $lgsl_config['players'][4] = 1;
  $lgsl_config['players'][5] = 1;
  $lgsl_config['players'][6] = 1;
  $lgsl_config['players'][7] = 1;
  $lgsl_config['players'][8] = 1;

//------------------------------------------------------------------------------------------------------------+
//[ ZONE RANDOMISATION: NUMBER=MAX RANDOM SERVERS TO BE SHOWN ]

  $lgsl_config['random'][0] = 0;
  $lgsl_config['random'][1] = 0;
  $lgsl_config['random'][2] = 0;
  $lgsl_config['random'][3] = 0;
  $lgsl_config['random'][4] = 0;
  $lgsl_config['random'][5] = 0;
  $lgsl_config['random'][6] = 0;
  $lgsl_config['random'][7] = 0;
  $lgsl_config['random'][8] = 0;

//------------------------------------------------------------------------------------------------------------+
// [ HIDE OFFLINE SERVERS: 0=HIDE 1=SHOW

  $lgsl_config['hide_offline'][0] = 0;
  $lgsl_config['hide_offline'][1] = 0;
  $lgsl_config['hide_offline'][2] = 0;
  $lgsl_config['hide_offline'][3] = 0;
  $lgsl_config['hide_offline'][4] = 0;
  $lgsl_config['hide_offline'][5] = 0;
  $lgsl_config['hide_offline'][6] = 0;
  $lgsl_config['hide_offline'][7] = 0;
  $lgsl_config['hide_offline'][8] = 0;

//------------------------------------------------------------------------------------------------------------+
//[ e107 VERSION: TITLES - OTHER VERSIONS ARE SET BY THE CMS ]

  $lgsl_config['title'][0] = "Live Game Server List";
  $lgsl_config['title'][1] = "Game Server";
  $lgsl_config['title'][2] = "Game Server";
  $lgsl_config['title'][3] = "Game Server";
  $lgsl_config['title'][4] = "Game Server";
  $lgsl_config['title'][5] = "Game Server";
  $lgsl_config['title'][6] = "Game Server";
  $lgsl_config['title'][7] = "Game Server";
  $lgsl_config['title'][8] = "Game Server";

//------------------------------------------------------------------------------------------------------------+
//[ STAND-ALONE VERSION: LGSL ADMIN LOGON ]

  $lgsl_config['admin']['user'] = "lgsladmin";
  $lgsl_config['admin']['pass'] = "changeme";

//------------------------------------------------------------------------------------------------------------+
//[ DATABASE SETTINGS: FOR STAND-ALONE OR TO OVERRIDE CMS DEFAULTS ]

  $lgsl_config['db']['server'] = "localhost";
  $lgsl_config['db']['user']   = "root";
  $lgsl_config['db']['pass']   = "";
  $lgsl_config['db']['db']     = "lgsl";
  $lgsl_config['db']['table']  = "lgsl";

//------------------------------------------------------------------------------------------------------------+
//[ HOSTING FIXES ]

  $lgsl_config['direct_index'] = 0;  // 1=link to index.php instead of the folder
  $lgsl_config['no_realpath']  = 0;  // 1=do not use the realpath function
  $lgsl_config['url_path']     = ""; // full url to /lgsl_files/ for when auto detection fails

//------------------------------------------------------------------------------------------------------------+
//[ ADVANCED SETTINGS ]

  $lgsl_config['management']    = 0;         // 1=show advanced management in the admin by default
  $lgsl_config['host_to_ip']    = 0;         // 1=show the servers ip instead of its hostname
  $lgsl_config['public_add']    = 0;         // 1=servers require approval OR 2=servers shown instantly
  $lgsl_config['public_feed']   = 0;         // 1=feed requests can add new servers to your list
  $lgsl_config['cache_time']    = 60;        // seconds=time before a server needs updating
  $lgsl_config['live_time']     = 3;         // seconds=time allowed for updating servers per page load
  $lgsl_config['timeout']       = 0;         // 1=gives more time for servers to respond but adds loading delay
  $lgsl_config['retry_offline'] = 0;         // 1=repeats query when there is no response but adds loading delay
  $lgsl_config['cms']           = "sa";      // sets which CMS specific code to use

//------------------------------------------------------------------------------------------------------------+
//[ TRANSLATION ]

  $lgsl_config['text']['vsd'] = "CLICK TO VIEW SERVER DETAILS";
  $lgsl_config['text']['slk'] = "GAME LINK";
  $lgsl_config['text']['sts'] = "Status:";
  $lgsl_config['text']['adr'] = "Address:";
  $lgsl_config['text']['cpt'] = "Connection Port:";
  $lgsl_config['text']['qpt'] = "Query Port:";
  $lgsl_config['text']['typ'] = "Type:";
  $lgsl_config['text']['gme'] = "Game:";
  $lgsl_config['text']['map'] = "Map:";
  $lgsl_config['text']['plr'] = "Players:";
  $lgsl_config['text']['npi'] = "NO PLAYER INFO";
  $lgsl_config['text']['nei'] = "NO EXTRA INFO";
  $lgsl_config['text']['ehs'] = "Setting";
  $lgsl_config['text']['ehv'] = "Value";
  $lgsl_config['text']['onl'] = "ONLINE";
  $lgsl_config['text']['onp'] = "ONLINE WITH PASSWORD";
  $lgsl_config['text']['nrs'] = "NO RESPONSE";
  $lgsl_config['text']['pen'] = "WAITING TO BE QUERIED";
  $lgsl_config['text']['zpl'] = "PLAYERS:";
  $lgsl_config['text']['mid'] = "INVALID SERVER ID";
  $lgsl_config['text']['nnm'] = "--";
  $lgsl_config['text']['nmp'] = "--";
  $lgsl_config['text']['tns'] = "Servers:";
  $lgsl_config['text']['tnp'] = "Players:";
  $lgsl_config['text']['tmp'] = "Max Players:";
  $lgsl_config['text']['asd'] = "PUBLIC ADDING OF SERVERS IS DISABLED";
  $lgsl_config['text']['awm'] = "THIS AREA ALLOWS YOU TO TEST AND THEN ADD ONLINE GAME SERVERS TO THE LIST";
  $lgsl_config['text']['ats'] = "Test Server";
  $lgsl_config['text']['aaa'] = "SERVER ALREADY ADDED AND NEEDS ADMIN APPROVAL";
  $lgsl_config['text']['aan'] = "SERVER ALREADY ADDED";
  $lgsl_config['text']['anr'] = "NO RESPONSE - MAKE SURE YOU ENTERED THE CORRECT DETAILS";
  $lgsl_config['text']['ada'] = "SERVER HAS BEEN ADDED FOR ADMIN APPROVAL";
  $lgsl_config['text']['adn'] = "SERVER HAS BEEN ADDED";
  $lgsl_config['text']['asc'] = "SUCCESS - PLEASE CONFIRM ITS THE CORRECT SERVER";
  $lgsl_config['text']['aas'] = "Add Server";
  $lgsl_config['text']['loc'] = "Location:";
	$lgsl_config['text']['umn'] = "USERNAME";
	$lgsl_config['text']['pwd'] = "PASSWORD";
	$lgsl_config['text']['lgn'] = "Login";
	$lgsl_config['text']['skc'] = "Save - Keep Cache";
	$lgsl_config['text']['srh'] = "Save - Reset Cache";
	$lgsl_config['text']['mip'] = "Map Image Paths";
	$lgsl_config['text']['avm'] = "Advanced Management";
	$lgsl_config['text']['nrm'] = "Normal Management";
	$lgsl_config['text']['bak'] = "BACK TO SERVERS LIST";

//------------------------------------------------------------------------------------------------------------+
