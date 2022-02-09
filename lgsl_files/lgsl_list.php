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

  $type = (isset($_GET['type']) ? $_GET['type'] : '');
  $game = (isset($_GET['game']) ? $_GET['game'] : '');
  $page = ($lgsl_config['pagination_mod'] && isset($_GET['page']) ? (int)$_GET['page'] : 1);

  }
  $server_list = lgsl_query_group(array("type" => $type, "game" => $game, "page" => $page));
  $server_list = lgsl_sort_servers($server_list);

//------------------------------------------------------------------------------------------------------------+
  if(count($server_list) == 0 && $page < 2) {
    $output .= "<div id='back_to_servers_list'><a href='./admin.php'>ADD YOUR FIRST SERVER</a></div>";
  }

  $output .= "
  <table id='server_list_table'>
    <tr id='server_list_table_top'>
      <th class='status_cell'>{$lgsl_config['text']['sts']}:</th>
      <th class='connectlink_cell'>{$lgsl_config['text']['adr']}:</th>
      <th class='servername_cell'>{$lgsl_config['text']['tns']}:</th>
      <th class='map_cell'>{$lgsl_config['text']['map']}:</th>
      <th class='players_cell'>{$lgsl_config['text']['plr']}:</th>
      <th class='details_cell'>{$lgsl_config['text']['dtl']}:</th>
    </tr>";

  foreach ($server_list as $server)
  {
    $misc    = lgsl_server_misc($server);
    $server  = lgsl_server_html($server);
    $percent = strval($server['s']['players'] == 0 || $server['s']['playersmax'] == 0 ? 0 : floor($server['s']['players']/$server['s']['playersmax']*100));
    $lastupd = Date($lgsl_config['text']['tzn'], (int)$server['s']['cache_time']);
    $gamelink= lgsl_build_link_params($uri, array("game" => $server['s']['game']));

    $output .= "
    <tr class='server_{$misc['text_status']}'>

      <td class='status_cell'>
        <span title='{$lgsl_config['text'][$misc['text_status']]} | {$lgsl_config['text']['lst']}: {$lastupd}' class='status_icon_{$misc['text_status']}'></span>
        <a href='{$gamelink}'>
          <img alt='{$misc['name_filtered']}' src='{$misc['icon_game']}' title='{$misc['text_type_game']}' class='game_icon' />
        </a>
      </td>

      <td title='{$lgsl_config['text']['slk']}' class='connectlink_cell'>
        <a href='{$misc['software_link']}'>
          {$misc['connect_filtered']}
        </a>
      </td>

      <td title='{$server['s']['name']}' class='servername_cell'>
        <div class='servername_nolink'>
          {$misc['name_filtered']}
        </div>
        <div class='servername_link'>
          <a href='".lgsl_link($server['o']['id'])."'>
            {$misc['name_filtered']}
          </a>
        </div>
      </td>

      <td class='map_cell' data-path='{$misc['image_map']}'>
        {$server['s']['map']}
      </td>

      <td class='players_cell'>
        <div class='outer_bar'>
          <div class='inner_bar' style='width:{$percent}%;'>
            <span class='players_numeric'>{$server['s']['players']}/{$server['s']['playersmax']}</span>
            <span class='players_percent{$percent}'>{$percent}%</span>
          </div>
        </div>
      </td>

      <td class='details_cell'>";

      if ($lgsl_config['locations'])
      {
        $output .= "
        <a href='".lgsl_location_link($server['o']['location'])."' target='_blank' class='contry_link'>
          <img alt='{$misc['text_location']}' src='{$misc['icon_location']}' title='{$misc['text_location']}' class='contry_icon' />
        </a>";
      }

      $output .= "
        <a href='".lgsl_link($server['o']['id'])."' class='details_icon' title='{$lgsl_config['text']['vsd']}'></a>
      </td>

    </tr>";
  }

  $output .= "
  </table>";

  if($lgsl_config['pagination_mod'] && ((int)(count($server_list) / $lgsl_config['pagination_lim']) > 0 || $page > 1)){
    $output .= "
      <div id='pages'>
        " . ($page > 1 ? "<a href='" . lgsl_build_link_params($uri, array("page" => $page - 1)) . "'> < </a>" : "") . "
      <span>{$lgsl_config['text']['pag']} {$page}</span>
        " . (count($server_list) < $lgsl_config['pagination_lim'] ?
            "" :
            (isset($_GET['page']) ?
                "<a href='" . lgsl_build_link_params($uri, array("page" => $page + 1)) . "'> > </a>" :
                "<a href='" . lgsl_build_link_params($uri, array("page" => 2)) ."'>></a>")) . "
      </div>
      ";
  }

//------------------------------------------------------------------------------------------------------------+

  if ($lgsl_config['list']['totals'])
  {
    $total = lgsl_group_totals($server_list);

    $output .= "
    <div id='totals'>
        <div> {$lgsl_config['text']['tns']}: {$total['servers']}    </div>
        <div> {$lgsl_config['text']['tnp']}: {$total['players']}    </div>
        <div> {$lgsl_config['text']['tmp']}: {$total['playersmax']} </div>
    </div>";
  }

//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
//------ PLEASE MAKE A DONATION OR SIGN THE GUESTBOOK AT GREYCUBE.COM IF YOU REMOVE THIS CREDIT ----------------------------------------------------------------------------------------------------+
//------ WANNA BE HERE? https://github.com/tltneon/lgsl/wiki/Who-uses-LGSL -> LET CREDITS STAY :P --------------------------------------------------------------------------------------------------+
  $output .= "<div style='text-align:center; font-family:tahoma; font-size:9px; padding: 33px 0px 11px 0px;'><a href='https://github.com/tltneon/lgsl' style='text-decoration:none'>".lgsl_version()."</a></div>";
//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
