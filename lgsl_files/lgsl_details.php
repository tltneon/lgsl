<?php

 /*----------------------------------------------------------------------------------------------------------\
 |                                                                                                            |
 |                      [ LIVE GAME SERVER LIST ] [ © RICHARD PERRY FROM GREYCUBE.COM ]                       |
 |                                                                                                            |
 |    Released under the terms and conditions of the GNU General Public License Version 3 (http://gnu.org)    |
 |                                                                                                            |
 \-----------------------------------------------------------------------------------------------------------*/

//------------------------------------------------------------------------------------------------------------+

  require "lgsl_class.php";

//------------------------------------------------------------------------------------------------------------+
// THIS CONTROLS HOW THE PLAYER FIELDS ARE DISPLAYED

  $fields_show  = array("name", "score", "kills", "deaths", "team", "ping", "bot", "time"); // ORDERED FIRST
  $fields_hide  = array("teamindex", "pid", "pbguid"); // REMOVED
  $fields_other = TRUE; // FALSE TO ONLY SHOW FIELDS IN $fields_show

//------------------------------------------------------------------------------------------------------------+
// GET THE SERVER DETAILS AND PREPARE IT FOR DISPLAY

  global $lgsl_server_id;

  $server = lgsl_query_cached("", "", "", "", "", "sep", $lgsl_server_id);

	if (!$server) { $output .= "<div id='invalid_server_id'> {$lgsl_config['text']['mid']} </div>"; return; }

	$fields = lgsl_sort_fields($server, $fields_show, $fields_hide, $fields_other);
	$server = lgsl_sort_players($server);
	$server = lgsl_sort_extras($server);
	$misc   = lgsl_server_misc($server);
	$server = lgsl_server_html($server);

//------------------------------------------------------------------------------------------------------------+

  $output .= "
  <div style='margin:auto; text-align:center'>
    <div class='spacer'></div>";

//------------------------------------------------------------------------------------------------------------+
// SHOW THE STANDARD INFO

  $output .= "
	<div id='servername_{$misc['text_status']}'> {$server['s']['name']} </div>
    <div class='details_info'>
      <div class='details_info_column'>
        <a id='gamelink' href='{$misc['software_link']}'>{$lgsl_config['text']['slk']}</a>
        <div class='details_info_row'>
          <div class='details_info_scolumn'>
            <div class='details_info_srow'>
              <div class='details_info_ceil'>{$lgsl_config['text']['sts']}:</div><div class='details_info_ceil'>{$lgsl_config['text'][$misc['text_status']]}</div></div>
            <div class='details_info_srow'>
              <div class='details_info_ceil'>{$lgsl_config['text']['adr']}:</div><div class='details_info_ceil'>{$server['b']['ip']} </div></div>
            <div class='details_info_srow'>
              <div class='details_info_ceil'>{$lgsl_config['text']['cpt']}:</div><div class='details_info_ceil'>{$server['b']['c_port']}</div></div>
            <div class='details_info_srow'>
              <div class='details_info_ceil'>{$lgsl_config['text']['qpt']}:</div><div class='details_info_ceil'>{$server['b']['q_port']}</div></div></div>
          <div class='details_info_scolumn'>
            <div class='details_info_srow'>
              <div class='details_info_ceil'>{$lgsl_config['text']['typ']}:</div><div class='details_info_ceil'>{$server['b']['type']}</div></div>
            <div class='details_info_srow'>
              <div class='details_info_ceil'>{$lgsl_config['text']['gme']}:</div><div class='details_info_ceil'>{$server['s']['game']}</div></div>
            <div class='details_info_srow'>
              <div class='details_info_ceil'>{$lgsl_config['text']['map']}:</div><div class='details_info_ceil'>{$server['s']['map']}</div></div>
            <div class='details_info_srow'>
              <div class='details_info_ceil'>{$lgsl_config['text']['plr']}:</div><div class='details_info_ceil'>{$server['s']['players']} / {$server['s']['playersmax']}</div></div>
          </div>
        </div>
				<div class='details_info_row'>
					Last update: " . Date('d.m.Y H:i:s', $server['s']['cache_time']) . "
        </div>
      </div>
      <div class='details_info_column zone{$server['o']['zone']}' style='background-image: url({$misc['image_map']});'>
        <span class='details_location_image' style='background-image: url({$misc['icon_location']});' title='{$misc['text_location']}'></span>
        <span class='details_password_image zone{$server['o']['zone']}' style='background-image: url({$misc['image_map_password']});' title='Map: {$server['s']['map']}'></span>
        <span class='details_game_image' style='background-image: url({$misc['icon_game']});' title='{$misc['text_type_game']}'></span>
      </div>
    </div>";

//------------------------------------------------------------------------------------------------------------+

  $output .= "<div class='spacer'></div>";

//------------------------------------------------------------------------------------------------------------+

  if($lgsl_config['image_mod']){
    $output .= '<img src="userbar.php?s='.intval($_GET['s']).'" alt="'.$server['s']['name'].'"/><br />
    <textarea style="width: 500px; height: 40px;">[url='.str_replace("lgsl_files/", "", lgsl_url_path()).($lgsl_config['direct_index'] ? "index.php" : "").'?s='.intval($_GET['s']).'][img]'.str_replace("lgsl_files/", "", lgsl_url_path()).'userbar.php?s='.intval($_GET['s']).'[/img][/url]</textarea>
    <div class="spacer"></div>
    <style>
      @media (max-width: 414px){
        textarea { width: 98.5% !important; }
      }
    </style>';
  }

//------------------------------------------------------------------------------------------------------------+
// SHOW THE PLAYERS

  $output .= "
  <div id='details_playerlist'>";

  if (empty($server['p']) || !is_array($server['p']))
  {
    $output .= "<div class='noinfo'>{$lgsl_config['text']['npi']}</div>";
  }
  else
  {
    $output .= "
    <table class='players_table'>
      <tr class='table_head'>";

      foreach ($fields as $field)
      {
        $field = ucfirst($field);
        $output .= "<td> {$field} </td>";
      }

      $output .= "
      </tr>";

      foreach ($server['p'] as $player_key => $player)
      {
        $output .= "
        <tr>";

        foreach ($fields as $field)
        {
          $output .= "<td> {$player[$field]} </td>";
        }

        $output .= "
        </tr>";
      }

    $output .= "
    </table>";
  }

  $output .= "
  </div>";

//------------------------------------------------------------------------------------------------------------+

  $output .= "<div class='spacer'></div>";

//------------------------------------------------------------------------------------------------------------+
// SHOW THE SETTINGS

  if (empty($server['e']) || !is_array($server['e']))
  {
    $output .= "<div class='noinfo'>{$lgsl_config['text']['nei']} </div>";
  }
  else
  {
    $output .= "
    <table class='settings_table'>
      <tr class='table_head'>
        <th> {$lgsl_config['text']['ehs']} </th>
        <th> {$lgsl_config['text']['ehv']} </th>
      </tr>";

    foreach ($server['e'] as $field => $value)
    {
			if(preg_match('/(https*:\/\/www\.|www\.)([\w]*\.*)*\w+\/*([\w]*\/*)*/i', $value)){
				$value = "<a href='".$value."' target='_blank'>".$value."</a>";
			}
      $output .= "
      <tr>
        <td> {$field} </td>
        <td> {$value} </td>
      </tr>";
    }

    $output .= "
    </table>";
  }

//------------------------------------------------------------------------------------------------------------+

  $output .= "<div class='spacer'></div>";

  $output .= "
  </div>";
	
//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
//------ PLEASE MAKE A DONATION OR SIGN THE GUESTBOOK AT GREYCUBE.COM IF YOU REMOVE THIS CREDIT ----------------------------------------------------------------------------------------------------+
  $output .= "<div style='text-align:center; font-family:tahoma; font-size:9px; padding: 33px 0px 11px 0px;'><a href='http://www.greycube.com' style='text-decoration:none'>".lgsl_version()."</a></div>";
//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
