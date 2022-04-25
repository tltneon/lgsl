<?php

 /*----------------------------------------------------------------------------------------------------------\
 |                                                                                                            |
 |                      [ LIVE GAME SERVER LIST ] [ � RICHARD PERRY FROM GREYCUBE.COM ]                       |
 |                                                                                                            |
 |    Released under the terms and conditions of the GNU General Public License Version 3 (http://gnu.org)    |
 |                                                                                                            |
 \-----------------------------------------------------------------------------------------------------------*/

//------------------------------------------------------------------------------------------------------------+

  require "lgsl_class.php";
  global $output, $server, $title;

//------------------------------------------------------------------------------------------------------------+
// THIS CONTROLS HOW THE PLAYER FIELDS ARE DISPLAYED

  $fields_show  = array("name", "score", "kills", "deaths", "team", "ping", "bot", "time"); // ORDERED FIRST
  $fields_hide  = array("teamindex", "pid", "pbguid"); // REMOVED
  $fields_other = TRUE; // FALSE TO ONLY SHOW FIELDS IN $fields_show

//------------------------------------------------------------------------------------------------------------+
// GET THE SERVER DETAILS AND PREPARE IT FOR DISPLAY

  global $lgsl_server_id;
  if ($lgsl_config['preloader']) {
    $lgsl_server_id = isset($_GET["s"]) ? (int) $_GET["s"] : null;
  }

  $server = lgsl_query_cached("", "", "", "", "", "sep", $lgsl_server_id);

  if ($server) {

    $title .= " | {$server['s']['name']}";
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

    $c_port = ($server['b']['c_port'] > 1 ? $server['b']['c_port'] : '--');
    $q_port = ($server['b']['q_port'] > 1 ? $server['b']['q_port'] : '--');
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
                <div class='details_info_ceil'>{$lgsl_config['text']['adr']}:</div><div class='details_info_ceil'>{$server['b']['ip']}</div></div>
              <div class='details_info_srow'>
                <div class='details_info_ceil'>{$lgsl_config['text']['cpt']}:</div><div class='details_info_ceil'>{$c_port}</div></div>
              <div class='details_info_srow'>
                <div class='details_info_ceil'>{$lgsl_config['text']['qpt']}:</div><div class='details_info_ceil'>{$q_port}</div></div></div>
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
              {$lgsl_config['text']['lst']}: " . Date($lgsl_config['text']['tzn'], $server['s']['cache_time']) . "
          </div>
        </div>
        <div class='details_info_column zone{$server['o']['zone']}' style='background-image: url({$misc['image_map']});'>
          <span class='details_location_image' style='background-image: url({$misc['icon_location']});' title='{$misc['text_location']}'></span>
          <span class='details_password_image zone{$server['o']['zone']}' style='background-image: url({$misc['image_map_password']});' title='{$lgsl_config['text']['map']}: {$server['s']['map']}'></span>
          <span class='details_game_image' style='background-image: url({$misc['icon_game']});' title='{$misc['text_type_game']}'></span>
        </div>
      </div>";

  //------------------------------------------------------------------------------------------------------------+

    $output .= "<div class='spacer'></div>";

  //------------------------------------------------------------------------------------------------------------+

    if ($lgsl_config['history']) {
      $output .= "<div style='overflow-x: auto;'><img src='charts.php?s=".intval($_GET["s"])."' alt='{$server["s"]["name"]}' style='border-radius: 6px;' id='chart' /></div>";
    }

    if ($lgsl_config['image_mod']) {
      if (extension_loaded('gd')) {
        $p = str_replace('lgsl_files/', '', lgsl_url_path());
        $output .= "
        <details>
          <summary style='margin-bottom: 12px;'>
            {$lgsl_config['text']['cts']}
          </summary>
          <div>
            <div style='overflow-x: auto;'><img src='userbar.php?s=".intval($_GET["s"])."' alt='{$server["s"]["name"]}'/></div>
            <textarea onClick='this.select();'>[url=".$p.($lgsl_config["direct_index"] ? 'index.php' : '')."?s=".intval($_GET["s"])."][img]".$p."userbar.php?s=".intval($_GET["s"])."[/img][/url]</textarea><br /><br />

            <div style='overflow-x: auto;'><img src='userbar.php?s=".intval($_GET["s"])."&t=2' alt='{$server["s"]["name"]}'/></div>
            <textarea onClick='this.select();'>[url=".$p.($lgsl_config["direct_index"] ? 'index.php' : '')."?s=".intval($_GET["s"])."][img]".$p."userbar.php?s=".intval($_GET["s"])."&t=2[/img][/url]</textarea><br /><br />

            <img src='userbar.php?s=".intval($_GET["s"])."&t=3' alt='{$server["s"]["name"]}'/><br />
            <textarea onClick='this.select();'>[url=".$p.($lgsl_config["direct_index"] ? 'index.php' : '')."?s=".intval($_GET["s"])."][img]".$p."userbar.php?s=".intval($_GET["s"])."&t=3[/img][/url]</textarea>
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
      }
      else {$output .= "<div id='invalid_server_id'> Error while trying to display userbar: GD library not loaded (see php.ini) </div>";}
    }

  //------------------------------------------------------------------------------------------------------------+
  // SHOW THE PLAYERS

    $output .= "
    <div id='details_playerlist'>";

    if (empty($server['p']) || !is_array($server['p'])) {
      $output .= "<div class='noinfo'>{$lgsl_config['text']['npi']}</div>";
    } else {
      $output .= "
      <table class='players_table'>
        <tr class='table_head'>";

        foreach ($fields as $field) {
          $field = ucfirst($lgsl_config['text'][substr(strtolower($field), 0, 3)]);
          $output .= "<td> {$field} </td>";
        }

        $output .= "
        </tr>";

        foreach ($server['p'] as $player_key => $player) {
          $output .= "
          <tr>";

          foreach ($fields as $field) {
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

    if (empty($server['e']) || !is_array($server['e'])) {
      $output .= "<div class='noinfo'>{$lgsl_config['text']['nei']} </div>";
    } else {
      $hide_options = count($server['e']) > 40;
      if ($hide_options) {
         $output .= "
        <details>
          <summary style='margin-bottom: 12px;'>
            {$lgsl_config['text']['ctb']}
          </summary>
          <div>
         ";
      }
      $output .= "
      <table class='settings_table'>
        <tr class='table_head'>
          <th> {$lgsl_config['text']['ehs']} </th>
          <th> {$lgsl_config['text']['ehv']} </th>
        </tr>";

      foreach ($server['e'] as $field => $value) {
        $value = preg_replace('/((https*:\/\/|https*:\/\/www\.|www\.)[\w\d\.\-\/=$?​]*)/i', "<a href='$1' target='_blank'>$1</a>", $value);
        $output .= "
        <tr>
          <td> {$field} </td>
          <td> {$value} </td>
        </tr>";
      }

      $output .= "
      </table>";
      if ($hide_options) {
        $output .= "
        </div>
        </details>";
      }
    }

  //------------------------------------------------------------------------------------------------------------+

    $output .= "<div class='spacer'></div>";

    $output .= "
    </div>";
  }
  else {
    $output .= "<div id='invalid_server_id'> {$lgsl_config['text']['mid']} </div>";
  }

//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
//------ PLEASE MAKE A DONATION OR SIGN THE GUESTBOOK AT GREYCUBE.COM IF YOU REMOVE THIS CREDIT ----------------------------------------------------------------------------------------------------+
  $output .= "<div style='text-align:center; font-family:tahoma; font-size:9px; padding: 33px 0px 11px 0px;'><a href='https://github.com/tltneon/lgsl' style='text-decoration:none'>".lgsl_version()."</a></div>";
//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+

if ($lgsl_config['preloader']) {
  echo $output;
}