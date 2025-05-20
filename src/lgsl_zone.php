<?php
  namespace tltneon\LGSL;
 /*----------------------------------------------------------------------------------------------------------\
 |                                                                                                            |
 |                      [ LIVE GAME SERVER LIST ] [ RICHARD PERRY FROM GREYCUBE.COM ]                       |
 |                                                                                                            |
 |    Released under the terms and conditions of the GNU General Public License Version 3 (http://gnu.org)    |
 |                                                                                                            |
 \-----------------------------------------------------------------------------------------------------------*/

  global $lgsl_config, $lgsl_zone_number;
  $lgsl_zone_number = $_GET['zone'] ?? null;
  $ip = $_GET['ip'] ?? null;
  $port = (int) ($_GET['port'] ?? 0);
  if (!isset($lgsl_zone_number) && !$ip && !$port) { exit("LGSL PROBLEM: $lgsl_zone_number NOT SET"); }
  $background = $_GET['bg'] ?? '#FFF';
  $text = $_GET['text'] ?? '#000';
  $link = $_GET['link'] ?? '#0000ED';

  require "lgsl_class.php";
  require "lgsl_language.php";
  $lang = new Lang($_COOKIE['lgsl_lang'] ?? Lang::EN);

  $zone_width = "{$lgsl_config['zone']['width']}px";
  $zone_grid  = $lgsl_config['grid'][$lgsl_zone_number] ?? 1;
  $zone_count = 0;
  $output = "<link rel='stylesheet' href='other/_lgsl_zone.css' type='text/css' />";
  $request = (isset($_GET['cacheonly']) ? "c" : "") . (empty($lgsl_config['players'][$lgsl_zone_number]) ? "s" : "sp");
  if ($lgsl_zone_number) {
    $server_list = Database::getServersGroup(["request"=>$request, "zone"=>$lgsl_zone_number]);
  } else {
    $server_list = [new Server(["ip"=>$ip, "c_port"=>$port])];
    $server_list[0]->queryCached($request);
  }
  //$server_list = lgsl_sort_servers($server_list);

  if (!$server_list) {
    $output .= "<div class='center'>NO SERVERS IN ZONE {$lgsl_zone_number}</div>"; return;
  }

  $output .= "
	<link rel='stylesheet' href='other/_lgsl_locations.css' type='text/css' />
  <style>
    html {
      background-color: $background;
      color: $text
    }
    a {
      color: $link;
      text-decoration:none;
    }
    @keyframes marquee{
      0%{transform: translateX(15px);}
      100%{transform: translateX(calc(-100% + {$zone_width} - 15px));}
    }
  </style>
  <table cellpadding='0' cellspacing='0' style='width:100%;' class='sidebarserver center'>
    <tr>";

    foreach ($server_list as $server) {

      if ($zone_count != 0 && !($zone_count % $zone_grid)) {
        $output .= "
        </tr>
        <tr>";
      }

      $zone_count ++;

      $marquee = strlen($server->getName()) > 25 ? "class='on'" : "";
      $location = "";
      if ($lgsl_config['locations']) {
        $location = "<img class='details_location_image flag f{$server->getLocation()} abs z2 t2 r2' title='{$server->getLocationFormatted()}' alt=''>";
      }
      $output .= "
      <td style='vertical-align:top;'>

        <table style='width:{$zone_width};' cellpadding='0' cellspacing='2' class='center'>

          <tr>
            <td class='p0' title='{$lang->get('slk')}'>
              <div class='nooverflow' style='width:{$zone_width};'>
                <a href='{$server->getConnectionLink()}'>
                  {$server->getAddress()}
                </a>
              </div>
            </td>
          </tr>

          <tr>
            <td class='p0' title='{$server->getName()}'>
              <div class='marquee nooverflow' style='width:{$zone_width};'>
                <span {$marquee}>{$server->getName()}</span>
              </div>
            </td>
          </tr>

          <tr>
            <td class='p0'>
              <div class='p0' style='width:{$zone_width}; position:relative'>
                <a href='".LGSL::link($server->getIp(), $server->getConnectionPort())."' target='_blank'>
                  <img class='rounded' src='{$server->getMapImage()}' title='{$lang->get('vsd')}' style='vertical-align:middle; width: 100%;' alt=''>
                  <img class='abs z2 b2 r2' src='{$server->mapPasswordImage()}' title='{$lang->get('vsd')}' alt=''>
                  <img class='abs z2 t2 l2 rounded' src='{$server->addUrlPath($server->getGameIcon())}' title='{$server->getGameFormatted()}' style='width: 24px;' alt=''>
                  {$location}
                </a>
              </div>
            </td>
          </tr>

          <tr>
            <td class='p0' title='{$lang->get('map')}: {$server->getMap()}'>
              <div class='nooverflow' style='width:{$zone_width};'>
                {$server->getMap()}
              </div>
            </td>
          </tr>";

        if ($server->getPlayersCount() /*&& isset($lgsl_config['players']) && isset($lgsl_config['players'][$lgsl_zone_number])*/) {
          $zone_height = $lgsl_config['zone']['line_size'] * ($server->getPlayersCount() + 1);
          $zone_height = $zone_height > $lgsl_config['zone']['height'] ? "{$lgsl_config['zone']['height']}px" : "{$zone_height}px";

          $output .= "
          <tr>
            <td class='p0 rounded'>
              <span class='p1' style='float:left'> {$lang->get('zpl')} </span>
              <span class='p1' style='float:right'> {$server->getPlayersCountFormatted()} </span>";
              $players = $server->getPlayersArray();
              if (count($players) > 0) {
                $output .= "<div style='width:{$zone_width}; height:{$zone_height}; border-top: 1px solid #8080807a; overflow: overlay; text-align:left'>";

                foreach ($players as $player) {
                  $output .= "
                  <div class='nooverflow p1' style='text-align:left' title='{$player['name']}'> {$player['name']} </div>";
                }

                $output .= "</div";
              } else {
                $inner_width = $server->getPlayersPercent();
                $output .="
                <br>
                <div style='margin-top: 5px; border: 1px solid #555555; background-color: #222222; height: 4px;'>
                  <div style='width: $inner_width%; background-color: #ff8400; height: 4px;'></div>
                </div>";
              }
              $output .= "
            </td>
          </tr>";
        } else {
          $output .= "
          <tr>
            <td class='p0 rounded' style='border:1px solid;'>
              <span class='p1' style='float:left'> {$lang->get('zpl')} </span>
              <span class='p1' style='float:right'> {$server->getPlayersCount()} </span>
            </td>
          </tr>";
        }

        $output .= "
        </table>
      </td>";
    }

    $output .= "
    </tr>
  </table>";

  LGSL::preloader($output);