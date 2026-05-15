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
  global $output;

  $type = (isset($_GET['type']) ? $_GET['type'] : '');
  $game = (isset($_GET['game']) ? $_GET['game'] : '');
  $page = ($lgsl_config['pagination_mod'] && isset($_GET['page']) ? (int)$_GET['page'] : 1);

  $uri = $_SERVER['REQUEST_URI'];

  if ($lgsl_config['preloader']) {
    $uri = htmlspecialchars($_SERVER['HTTP_REFERER'], ENT_QUOTES, 'UTF-8');
  }

  $server_list = lgsl_query_group(array("type" => $type, "game" => $game, "page" => $page));
  $server_list = lgsl_sort_servers($server_list);

  $lgsl_filter_game_labels = array(
    "cstrike" => "Counter-Strike 1.6",
    "czero" => "Counter-Strike: Condition Zero",
    "valve" => "Half-Life",
    "dod" => "Day of Defeat",
    "tfc" => "Team Fortress Classic",
    "gearbox" => "Half-Life: Opposing Force",
    "dmc" => "Deathmatch Classic",
    "ricochet" => "Ricochet"
  );

  $lgsl_filter_mode_labels = array(
    "as" => "Assassination",
    "awp" => "AWP",
    "aim" => "Aim",
    "bhop" => "Bunny Hop",
    "cs" => "Hostage Rescue",
    "de" => "Bomb Defuse",
    "dm" => "Deathmatch",
    "dr" => "Deathrun",
    "deathrun" => "Deathrun",
    "fy" => "Fight Yard",
    "gg" => "GunGame",
    "he" => "HE Grenade",
    "hns" => "Hide and Seek",
    "jb" => "JailBreak",
    "ka" => "Knife Arena",
    "kz" => "Climb",
    "scout" => "Scout",
    "surf" => "Surf",
    "usp" => "USP",
    "ze" => "Zombie Escape",
    "zm" => "Zombie Mod"
  );

  $lgsl_filter_map_catalog = array(
    "de_airstrip", "de_aztec", "de_cbble", "de_chateau", "de_dust", "de_dust2", "de_inferno",
    "de_nuke", "de_piranesi", "de_prodigy", "de_storm", "de_survivor", "de_torn", "de_train",
    "de_vertigo", "cs_747", "cs_assault", "cs_backalley", "cs_estate", "cs_havana", "cs_italy",
    "cs_militia", "cs_office", "cs_siege", "as_oilrig", "awp_india", "aim_map", "fy_iceworld"
  );

  $lgsl_filter_type_labels = function_exists("lgsl_type_list") ? lgsl_type_list() : array();
  $lgsl_filter_game_labels = array_merge($lgsl_filter_type_labels, $lgsl_filter_game_labels);

  function lgsl_filter_attr($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
  }

  function lgsl_filter_json_attr($value) {
    return htmlspecialchars(json_encode($value), ENT_QUOTES, 'UTF-8');
  }

  function lgsl_filter_text($key, $fallback) {
    global $lgsl_config;
    return lgsl_filter_attr(isset($lgsl_config['text'][$key]) ? $lgsl_config['text'][$key] : $fallback);
  }

//------------------------------------------------------------------------------------------------------------+
  if (count($server_list) == 0 && $page < 2) {
    $output .= "<div id='back_to_servers_list'><a href='./admin.php'>ADD YOUR FIRST SERVER</a></div>";
  }

  if (!isset($lgsl_config['list']['filters']) || $lgsl_config['list']['filters']) {
    $output .= "<div id='server_list_filters'
      data-search-label='".lgsl_filter_text('fse', 'Search server or address')."'
      data-all-maps='".lgsl_filter_text('fam', 'All maps')."'
      data-all-modes='".lgsl_filter_text('fmd', 'All modes')."'
      data-all-games='".lgsl_filter_text('fgm', 'All games')."'
      data-all-types='".lgsl_filter_text('fty', 'All types')."'
      data-all-players='".lgsl_filter_text('fpl', 'All players')."'
      data-with-players='".lgsl_filter_text('fpw', 'With players')."'
      data-has-slots='".lgsl_filter_text('fhs', 'Has slots')."'
      data-full='".lgsl_filter_text('ffu', 'Full')."'
      data-empty='".lgsl_filter_text('fem', 'Empty')."'
      data-no-results='".lgsl_filter_text('fno', 'No servers match the selected filters.')."'
      data-map-catalog='".lgsl_filter_json_attr($lgsl_filter_map_catalog)."'
      data-mode-labels='".lgsl_filter_json_attr($lgsl_filter_mode_labels)."'
      data-game-labels='".lgsl_filter_json_attr($lgsl_filter_game_labels)."'
      data-type-labels='".lgsl_filter_json_attr($lgsl_filter_type_labels)."'></div>";
  }

  $output .= "
  <table id='server_list_table'>
    <colgroup>
      <col class='status_col'>
      <col class='connectlink_col'>
      <col class='servername_col'>
      <col class='map_col'>
      <col class='players_col'>
      <col class='details_col'>
    </colgroup>
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
    $name_attr = htmlspecialchars($server['s']['name'], ENT_QUOTES, 'UTF-8');
    $map_attr = htmlspecialchars($server['s']['map'], ENT_QUOTES, 'UTF-8');
    $game_attr = htmlspecialchars($server['s']['game'], ENT_QUOTES, 'UTF-8');
    $type_attr = htmlspecialchars($server['b']['type'], ENT_QUOTES, 'UTF-8');
    $mode_key = strtolower(preg_replace('/_.*/', '', $server['s']['map']));
    $mode_attr = htmlspecialchars($mode_key, ENT_QUOTES, 'UTF-8');
    $mode_label_attr = lgsl_filter_attr(isset($lgsl_filter_mode_labels[$mode_key]) ? $lgsl_filter_mode_labels[$mode_key] : strtoupper($mode_key));
    $game_label_attr = lgsl_filter_attr(isset($lgsl_filter_game_labels[$server['s']['game']]) ? $lgsl_filter_game_labels[$server['s']['game']] : $server['s']['game']);
    $type_label_attr = lgsl_filter_attr(isset($lgsl_filter_type_labels[$server['b']['type']]) ? $lgsl_filter_type_labels[$server['b']['type']] : $server['b']['type']);
    $server  = lgsl_server_html($server);
    $percent = strval($server['s']['players'] == 0 || $server['s']['playersmax'] == 0 ? 0 : floor($server['s']['players']/$server['s']['playersmax']*100));
    $lastupd = Date($lgsl_config['text']['tzn'], (int)$server['s']['cache_time']);
    $gamelink= lgsl_build_link_params($uri, array("game" => $server['s']['game']));

    $output .= "
    <tr class='server_{$misc['text_status']}' data-name='{$name_attr}' data-map='{$map_attr}' data-mode='{$mode_attr}' data-mode-label='{$mode_label_attr}' data-game='{$game_attr}' data-game-label='{$game_label_attr}' data-type='{$type_attr}' data-type-label='{$type_label_attr}' data-status='{$misc['text_status']}' data-players='{$server['s']['players']}' data-playersmax='{$server['s']['playersmax']}'>

      <td class='status_cell'>
        <span title='{$lgsl_config['text'][$misc['text_status']]} | {$lgsl_config['text']['lst']}: {$lastupd}' class='status_icon_{$misc['text_status']}'></span>
        <a href='{$gamelink}'>
          <img alt='{$misc['name_filtered']}' src='{$misc['icon_game']}' title='{$misc['text_type_game']}' class='game_icon'>
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
          <a href='".lgsl_link($server['b']['ip'], $server['b']['c_port'])."'>
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

      if ($lgsl_config['locations']) {
        $output .= "
        <a href='".lgsl_location_link($server['o']['location'])."' target='_blank' class='contry_link'>
          <img alt='{$misc['text_location']}' src='{$misc['icon_location']}' title='{$misc['text_location']}' class='contry_icon'>
        </a>";
      }

      $output .= "
        <a href='".lgsl_link($server['b']['ip'], $server['b']['c_port'])."' class='details_icon' title='{$lgsl_config['text']['vsd']}'></a>
      </td>

    </tr>";
  }

  $output .= "
  </table>";

  if ($lgsl_config['pagination_mod'] && ((int)(count($server_list) / $lgsl_config['pagination_lim']) > 0 || $page > 1)) {
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

  if ($lgsl_config['list']['totals']) {
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
  $output .= lgsl_footer();
//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
if ($lgsl_config['preloader'])
  echo $output;
