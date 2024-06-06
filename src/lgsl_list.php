<?php
  namespace tltneon\LGSL;

  /*----------------------------------------------------------------------------------------------------------\
  |                                                                                                            |
  |                      [ LIVE GAME SERVER LIST ] [ RICHARD PERRY FROM GREYCUBE.COM ]                         |
  |                                                                                                            |
  |    Released under the terms and conditions of the GNU General Public License Version 3 (http://gnu.org)    |
  |                                                                                                            |
  \-----------------------------------------------------------------------------------------------------------*/

//------------------------------------------------------------------------------------------------------------+

  require "lgsl_class.php";
  require "lgsl_language.php";
  $lang = new Lang($_COOKIE['lgsl_lang'] ?? Lang::EN);
  global $output;

  $type = $_GET['type'] ?? '';
  $game = $_GET['game'] ?? '';
  $mode = $_GET['mode'] ?? '';
  $sort = $_GET['sort'] ?? '';
  $order= (isset($_GET['order']) ? $_GET['order'] == "ASC" ? "DESC" : 'ASC' : "ASC");

  $page = ($lgsl_config['pagination_mod'] && isset($_GET['page']) ? (int)$_GET['page'] : 1);

  $uri = $_SERVER['REQUEST_URI'];
  
  if ($lgsl_config['preloader']) {
    $uri = $_SERVER['HTTP_REFERER'];
  }

  $server_list = Database::getServersGroup(["type" => $type, "game" => $game, "mode" => $mode, "page" => $page, "sort" => $sort, "order" => $order]);
  $servers = count($server_list);
  if ($servers == 0 && $page < 2) {
    $output .= "<div id='back_to_servers_list'><a href='./admin.php'>ADD YOUR FIRST SERVER</a></div>";
  }
  if ($type || $game || $mode) {
    $output .= "<div id='back_to_servers_list'><a href='./'>CLEAR FILTERS</a></div>";
  }
  $ipsort = LGSL::buildLink($uri, ["sort" => "ip", "order" => $order]);
  $mapsort = LGSL::buildLink($uri, ["sort" => "map", "order" => $order]);
  $namesort = LGSL::buildLink($uri, ["sort" => "name", "order" => $order]);
  $playersort = LGSL::buildLink($uri, ["sort" => "players", "order" => $order]);

  $output .= "
  <table id='server_list_table'>
    <tr id='server_list_table_top'>
      <th class='status_cell'>{$lgsl_config['text']['sts']}:</th>
      <th class='connectlink_cell'><a href='{$ipsort}'>{$lgsl_config['text']['adr']}:</a></th>
      <th class='servername_cell'><a href='{$namesort}'>{$lgsl_config['text']['tns']}:</a></th>
      <th class='map_cell'><a href='{$mapsort}'>{$lgsl_config['text']['map']}:</a></th>
      <th class='players_cell'><a href='{$playersort}'>{$lgsl_config['text']['plr']}:</a></th>
      <th class='details_cell'>{$lgsl_config['text']['dtl']}:</th>
    </tr>";

  foreach ($server_list as $server) {
    $lastupd = $server->getTimestamp(Timestamp::SERVER);
    $gamelink= LGSL::buildLink($uri, ["game" => $server->getGame()]);

    $output .= "
    <tr class='server_{$server->getStatus()}'>

      <td class='status_cell'>
        <span title='{$lgsl_config['text'][$server->getStatus()]} | {$lgsl_config['text']['lst']}: {$lastupd}' class='status_icon_{$server->getStatus()}'></span>
        <a href='{$gamelink}'>
          <img alt='{$server->getName()}' src='{$server->addUrlPath($server->getGameIcon())}' title='{$server->getGameFormatted()}' class='game_icon' />
        </a>
      </td>

      <td title='{$lgsl_config['text']['slk']}' class='connectlink_cell'>
        <a href='{$server->getConnectionLink()}'>
          {$server->getAddress()}
        </a>
      </td>

      <td title='{$server->getName()}' class='servername_cell'>
        <div class='servername_nolink'>
          {$server->getName()}
        </div>
        <div class='servername_link'>
          <a href='".LGSL::link($server->getIp(), $server->getConnectionPort())."'>
            {$server->getName()}
          </a>
        </div>
      </td>

      <td class='map_cell' data-path='{$server->getMapImage()}'>
        {$server->getMap()}
      </td>

      <td class='players_cell'>
        <div class='outer_bar'>
          <div class='inner_bar' style='width:{$server->getPlayersPercent()}%;'>
            <span class='players_numeric'>{$server->getPlayersCountFormatted()}</span>
            <span class='players_percent{$server->getPlayersPercent()}'>{$server->getPlayersPercent()}%</span>
          </div>
        </div>
      </td>

      <td class='details_cell'>";

      if ($lgsl_config['locations']) {
        $output .= "
        <a href='".LGSL::locationLink($server->getLocationFormatted())."' title='{$server->getLocationFormatted()}'  target='_blank' class='contry_link'>
          <i class='contry_icon flag f{$server->getLocation()}'></i>
        </a>";
      }

      $output .= "
        <a href='".LGSL::link($server->getIp(), $server->getConnectionPort(false))."' class='details_icon' title='{$lgsl_config['text']['vsd']}'></a>
      </td>

    </tr>";
  }

  $output .= "
  </table>";

  if ($lgsl_config['pagination_mod'] && ((int)($servers / $lgsl_config['pagination_lim']) > 0 || $page > 1)) {
    $output .= "
      <div id='pages'>
      " . ($page > 1 ? "<a href='" . LGSL::buildLink($uri, ["page" => $page - 1]) . "'> < </a>" : "") . "
      <span>{$lgsl_config['text']['pag']} {$page}</span>
      " . ($servers < $lgsl_config['pagination_lim'] ?
          "" :
          (isset($_GET['page']) ?
              "<a href='" . LGSL::buildLink($uri, ["page" => $page + 1]) . "'> > </a>" :
              "<a href='" . LGSL::buildLink($uri, ["page" => 2]) ."'>></a>")) . "
      </div>
      ";
  }

  if ($lgsl_config['list']['totals']) {
    $total = LGSL::groupTotals();

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
if ($lgsl_config['preloader'])
  echo $output;