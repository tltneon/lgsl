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
	if ($lgsl_config['cms'] == "sa") { $output .= "<div id='back_to_servers_list'><a href='./'> {$lgsl_config['text']['bak']} </a></div>"; }

  $fields = lgsl_sort_fields($server, $fields_show, $fields_hide, $fields_other);
  $server = lgsl_sort_players($server);
  $server = lgsl_sort_extras($server);
  $misc   = lgsl_server_misc($server);
  $server = lgsl_server_html($server);

//------------------------------------------------------------------------------------------------------------+

  $output .= "
  <div style='margin:auto; text-align:center'>";

  $output .="<div class='spacer'></div>";

//------------------------------------------------------------------------------------------------------------+
// SHOW THE STANDARD INFO

  $output .= "
	<div id='servername'> {$server['s']['name']} </div>
  <table cellpadding='2' cellspacing='2' style='margin:auto'>
    <tr>
      <td colspan='2' style='text-align:center'>
        <div id='gamelink'><a href='{$misc['software_link']}'>{$lgsl_config['text']['slk']}</a></div>
      </td>
      <td rowspan='2' style='text-align:center; vertical-align:top'>
        <div style='width:{$lgsl_config['zone']['width']}px; padding:2px; position:relative; margin:auto'>
          <img alt='' src='{$misc['image_map']}' 					id='image_map'          			    style='vertical-align:middle' />
          <img alt='' src='{$misc['image_map_password']}'                                   style='position:absolute; z-index:2; top:0px; left:0px;' />
          <img alt='' src='{$misc['icon_game']}'          title='{$misc['text_type_game']}' style='position:absolute; z-index:2; top:6px; left:6px;' />
          <img alt='' src='{$misc['icon_location']}'      title='{$misc['text_location']}'  style='position:absolute; z-index:2; top:6px; right:6px;' />
        </div>
      </td>
    </tr>
    <tr>
      <td style='text-align:center'>
        <table cellpadding='4' cellspacing='2' style='margin:auto'>
          <tr style='".lgsl_bg().";white-space:nowrap'><td> <b> {$lgsl_config['text']['sts']} </b></td><td style='white-space:nowrap'> {$misc['text_status']}                                   </td></tr>
          <tr style='".lgsl_bg().";white-space:nowrap'><td> <b> {$lgsl_config['text']['adr']} </b></td><td style='white-space:nowrap'> {$server['b']['ip']}                                     </td></tr>
          <tr style='".lgsl_bg().";white-space:nowrap'><td> <b> {$lgsl_config['text']['cpt']} </b></td><td style='white-space:nowrap'> {$server['b']['c_port']}                                 </td></tr>
          <tr style='".lgsl_bg().";white-space:nowrap'><td> <b> {$lgsl_config['text']['qpt']} </b></td><td style='white-space:nowrap'> {$server['b']['q_port']}                                 </td></tr>
        </table>
      </td>
      <td style='text-align:center'>
        <table cellpadding='4' cellspacing='2' style='margin:auto'>
          <tr style='".lgsl_bg().";white-space:nowrap'><td> <b> {$lgsl_config['text']['typ']} </b></td><td style='white-space:nowrap'> {$server['b']['type']}                                   </td></tr>
          <tr style='".lgsl_bg().";white-space:nowrap'><td> <b> {$lgsl_config['text']['gme']} </b></td><td style='white-space:nowrap'> {$server['s']['game']}                                   </td></tr>
          <tr style='".lgsl_bg().";white-space:nowrap'><td> <b> {$lgsl_config['text']['map']} </b></td><td style='white-space:nowrap'> {$server['s']['map']}                                    </td></tr>
          <tr style='".lgsl_bg().";white-space:nowrap'><td> <b> {$lgsl_config['text']['plr']} </b></td><td style='white-space:nowrap'> {$server['s']['players']} / {$server['s']['playersmax']} </td></tr>
        </table>
      </td>
    </tr>
  </table>";

//------------------------------------------------------------------------------------------------------------+

  $output .= "<div class='spacer'></div>";

//------------------------------------------------------------------------------------------------------------+
// SHOW THE PLAYERS

  $output .= "
  <div style='margin:auto; overflow:auto; text-align:center; padding:10px'>";

  if (empty($server['p']) || !is_array($server['p']))
  {
    $output .= "<div class='noinfo'>{$lgsl_config['text']['npi']}</div>";
  }
  else
  {
    $output .= "
    <table cellpadding='4' cellspacing='2' style='margin:auto'>
      <tr style='".lgsl_bg(FALSE)."'>";

      foreach ($fields as $field)
      {
        $field = ucfirst($field);
        $output .= "
        <td> <b>{$field}</b> </td>";
      }

      $output .= "
      </tr>";

      foreach ($server['p'] as $player_key => $player)
      {
        $output .= "
        <tr style='".lgsl_bg()."'>";

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
    <table cellpadding='4' cellspacing='2' style='margin:auto'>
      <tr style='".lgsl_bg(FALSE)."'>
        <td> <b>{$lgsl_config['text']['ehs']}</b> </td>
        <td> <b>{$lgsl_config['text']['ehv']}</b> </td>
      </tr>";

    foreach ($server['e'] as $field => $value)
    {
      $color = lgsl_bg();

      $output .= "
      <tr>
        <td style='{$color}'> {$field} </td>
        <td style='{$color}'> {$value} </td>
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
  $output .= "<div style='text-align:center; font-family:tahoma; font-size:9px'><br /><br /><br /><a href='http://www.greycube.com' style='text-decoration:none'>".lgsl_version()."</a><br /></div>";
//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
