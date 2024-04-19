<?php
  namespace tltneon\LGSL;

  /*----------------------------------------------------------------------------------------------------------\
  |                                                                                                            |
  |                      [ LIVE GAME SERVER LIST ] [ RICHARD PERRY FROM GREYCUBE.COM ]                         |
  |                                                                                                            |
  |    Released under the terms and conditions of the GNU General Public License Version 3 (http://gnu.org)    |
  |                                                                                                            |
  \-----------------------------------------------------------------------------------------------------------*/

  require "lgsl_class.php";
  require "lgsl_language.php";
  $lang = new Lang($_COOKIE['lgsl_lang']);
  global $output, $server, $title;

//------------------------------------------------------------------------------------------------------------+
// GET THE SERVER DETAILS AND PREPARE IT FOR DISPLAY

  global $lgsl_server_id;
  if ($lgsl_config['preloader']) {
    $lgsl_server_id = $_GET["s"] ?? null;
  }
  $lgsl_server_ip = $_GET["ip"] ?? "";
  $lgsl_server_port = $_GET["port"] ?? "";

  $server = new Server(["ip" => $lgsl_server_ip, "c_port" => $lgsl_server_port, "id" => $lgsl_server_id]);
  $server->lgsl_cached_query();

  if ($server->isvalid()) {
    $title .= " | {$server->get_name()}";
    $fields = $server->sort_player_fields();
    //$server = lgsl_sort_players($server->get_players());
    //$server = lgsl_sort_extras($server->get_extras());

    $output .= "
    <div style='margin:auto; text-align:center'>
      <div class='spacer'></div>";

  //------------------------------------------------------------------------------------------------------------+
  // SHOW THE STANDARD INFO

    $output .= "
      <div id='servername_{$server->get_status()}'> {$server->get_name()} </div>
      <div class='details_info'>
        <div class='details_info_column'>
          <a id='gamelink' href='{$server->get_software_link()}'>{$lang->get('slk')}</a>
          <div class='details_info_row'>
            <div class='details_info_scolumn'>
              <div class='details_info_srow'>
                <div class='details_info_ceil'>{$lang->get('sts')}:</div><div class='details_info_ceil'>{$lang->get($server->get_status())}</div></div>
              <div class='details_info_srow'>
                <div class='details_info_ceil'>{$lang->get('adr')}:</div><div class='details_info_ceil'>{$server->get_ip()}</div></div>
              <div class='details_info_srow'>
                <div class='details_info_ceil'>{$lang->get('cpt')}:</div><div class='details_info_ceil'>{$server->get_c_port()}</div></div>
              <div class='details_info_srow'>
                <div class='details_info_ceil'>{$lang->get('qpt')}:</div><div class='details_info_ceil'>{$server->get_q_port()}</div></div></div>
            <div class='details_info_scolumn'>
              <div class='details_info_srow'>
                <div class='details_info_ceil'>{$lang->get('typ')}:</div><div class='details_info_ceil'>{$server->get_type()}</div></div>
              <div class='details_info_srow'>
                <div class='details_info_ceil'>{$lang->get('gme')}:</div><div class='details_info_ceil'>{$server->get_game()}</div></div>
              <div class='details_info_srow'>
                <div class='details_info_ceil'>{$lang->get('map')}:</div><div class='details_info_ceil'>{$server->get_map()}</div></div>
              <div class='details_info_srow'>
                <div class='details_info_ceil'>{$lang->get('plr')}:</div><div class='details_info_ceil'>{$server->get_players_count()}</div></div>
            </div>
          </div>
          <div class='details_info_row'>
            <div class='details_info_scolumn'>
              <div class='details_info_srow'>
                <div class='details_info_ceil'>{$lang->get('mod')}:</div><div class='details_info_ceil'>{$server->get_mode()}</div></div>
                <div class='details_info_srow'>
                  <div class='details_info_ceil'>{$lang->get('lst')}:</div><div class='details_info_ceil'>{$server->get_timestamp()}</div></div></div>
             
          </div>
        </div>
        <div class='details_info_column zone{$server->get_zone()}' style='background-image: url({$server->get_map_image()});'>
          <i class='details_password_image zone{$server->get_zone()}' style='background-image: url({$server->map_password_image()});' title='{$lang->get('map')}: {$server->get_map()}'></i>
					<i class='details_location_image flag f{$server->getLocation()}' title='{$server->location_text()}'></i>
          <i class='details_game_image' style='background-image: url({$server->add_url_path($server->game_icon())});' title='{$server->text_type_game()}'></i>
        </div>
      </div>
      <div class='spacer'></div>";

    $g = "ip={$server->get_ip()}&port={$server->get_c_port()}";
    if ($lgsl_config['history']) {
      $output .= "<div style='overflow-x: auto;'><img src='charts.php?{$g}' alt='{$server->get_name()}' style='border-radius: 6px;' id='chart' /></div>";
    }

		$p = str_replace('src/', '', lgsl_url_path()) . ($lgsl_config["direct_index"] ? 'index.php' : '');
		$framespace = max(0, min(6, $server->get_players_count('active'))) * 8.8;
		$output .= "
        <details>
          <summary style='margin-bottom: 12px;'>
            {$lang->get('cts')}
          </summary>
          <div>";
					
					if ($lgsl_config['image_mod']) {
						if (extension_loaded('gd')) {
              for ($i = 1; $i < 4; $i++) {
                $output .= "
                <div style='overflow-x: auto;'><img src='userbar.php?{$g}&t={$i}' alt='{$server->get_name()}'/></div>
                <textarea onClick='this.select();'>[url={$p}?{$g}][img]{$p}userbar.php?{$g}&t={$i}[/img][/url]</textarea><br /><br />";
              }
						} else {
							$output .= "<div id='invalid_server_id'> Error while trying to display image userbar: GD library not loaded (see php.ini) </div>";
						}
					}
					
					$output .= "
						<iframe src='src/lgsl_zone.php?{$g}' alt='{$server->get_name()}' style='border: 0; display: block; background: white;width: 200px;height: calc(275px + {$framespace}px);margin: auto;'></iframe><br />
            <textarea onClick='this.select();'><iframe src='{$p}src/lgsl_zone.php?{$g}'></iframe></textarea>
          </div>
        </details>
        <div class='spacer'></div>
        <style>
          textarea {
            width: 32em;
            height: 2.3em;
            word-break: break-all;
          }
          @media (max-width: 414px){
            textarea { width: 98.5% !important; }
          }
          details[open] div {
            animation: spoiler 1s;
          }
          @keyframes spoiler {
            0%   {opacity: 0;}
            100% {opacity: 1;}
          }
        </style>";

  //------------------------------------------------------------------------------------------------------------+
  // SHOW THE PLAYERS

    $output .= "
    <div id='details_playerlist'>";

    if ($server->get_players_count('active') == 0 || count($server->get_players()) == 0) {
      $output .= "<div class='noinfo'>{$lang->get('npi')}</div>";
    } else {
      $players = $server->get_players();
      $output .= "
      <table class='players_table'>
        <thead>
          <tr class='table_head'>";

        foreach ($fields as $field) {
          $field = ucfirst($lang->get(substr(strtolower($field), 0, 3)));
          $output .= "<th> {$field} </th>";
        }

        $output .= "
          </tr>
        </thead>
        <tbody>";

        foreach ($players as $player_key => $player) {
          $output .= "
          <tr>";

          foreach ($fields as $field) {
            $output .= isset($player[$field]) ? "<td> {$player[$field]} </td>" : "<td> " . LGSL::NONE . " </td>";
          }

          $output .= "
          </tr>";
        }

      $output .= "
        </tbody>
      </table>";
    }

    $output .= "
    </div>";

    $output .= "<div class='spacer'></div>";

  //------------------------------------------------------------------------------------------------------------+
  // SHOW THE SETTINGS

    if (count($server->get_extras()) == 0) {
      $output .= "<div class='noinfo'>{$lang->get('nei')} </div>";
    } else {
      $extras = $server->get_extras();
      $hide_options = count($extras) > 40;
      if ($hide_options) {
         $output .= "
        <details>
          <summary style='margin-bottom: 12px;'>
            {$lang->get('ctb')}
          </summary>
          <div>
         ";
      }
      $output .= "
      <table class='settings_table'>
        <thead>
          <tr class='table_head'>
            <th> {$lang->get('ehs')} </th>
            <th> {$lang->get('ehv')} </th>
          </tr>
        </thead>
        <tbody>";

      foreach ($extras as $field => $value) {
        $value = preg_replace('/((https*:\/\/|https*:\/\/www\.|www\.)[\w\d\.\-\/:=$?​]*)/i', "<a href='$1' target='_blank'>$1</a>", $value);
        $output .= "
          <tr>
            <td> {$field} </td>
            <td> {$value} </td>
          </tr>";
      }

      $output .= "
        </tbody>
      </table>";
      if ($hide_options) {
        $output .= "
        </div>
        </details>";
      }
    }

    $output .= "<div class='spacer'></div>";

    $output .= "
    </div>";
  }
  else {
    $output .= "<div id='invalid_server_id'> {$lang->get('mid')} </div>";
  }

//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
//------ PLEASE MAKE A DONATION OR SIGN THE GUESTBOOK AT GREYCUBE.COM IF YOU REMOVE THIS CREDIT ----------------------------------------------------------------------------------------------------+
  $output .= "<div style='text-align:center; font-family:tahoma; font-size:9px; padding: 33px 0px 11px 0px;'><a href='https://github.com/tltneon/lgsl' style='text-decoration:none'>".lgsl_version()."</a></div>";
//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+

	$output .= "
	<script type=\"application/ld+json\">
	{
		\"@context\": \"https://schema.org\",
		\"@type\": \"GameServer\",
		\"@id\": \"GameServer\",
		\"potentialAction\": {
			\"@context\": \"https://schema.org\",
			\"@type\": \"Action\",
			\"@id\": \"Action\",
			\"name\": \"Connect to server\",
			\"url\": \"{$server->get_software_link()}\"
		},
		\"description\": \"{$server->get_name()} | game: {$server->get_game()} | ip: {$server->get_ip()}:{$server->get_c_port()} | status: {$lang->get($server->get_status())} | players: {$server->get_players_count()}\",
		\"identifier\": \"{$lgsl_server_id}\",
		\"name\": \"{$server->get_name()}\",
		\"playersOnline\": \"{$server->get_players_count("active")}\",
		\"url\": \"$_SERVER[HTTP_REFERER]\"
	}
	</script>
	";

if ($lgsl_config['preloader']) {
  echo $output;
}