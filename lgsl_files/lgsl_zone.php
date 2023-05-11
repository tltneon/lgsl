<?php

 /*----------------------------------------------------------------------------------------------------------\
 |                                                                                                            |
 |                      [ LIVE GAME SERVER LIST ] [ © RICHARD PERRY FROM GREYCUBE.COM ]                       |
 |                                                                                                            |
 |    Released under the terms and conditions of the GNU General Public License Version 3 (http://gnu.org)    |
 |                                                                                                            |
 \-----------------------------------------------------------------------------------------------------------*/

//------------------------------------------------------------------------------------------------------------+

  global $lgsl_config, $lgsl_zone_number;

  if (!isset($lgsl_zone_number)) { exit("LGSL PROBLEM: $lgsl_zone_number NOT SET"); }

  require "lgsl_class.php";

  $zone_width = $lgsl_config['zone']['width']."px";
  $zone_grid  = isset($lgsl_config['grid'][$lgsl_zone_number]) ? $lgsl_config['grid'][$lgsl_zone_number] : 1;
  $zone_count = 0;

//------------------------------------------------------------------------------------------------------------+

  $request     = empty($lgsl_config['players'][$lgsl_zone_number]) ? "s" : "sp";
  $server_list = lgsl_query_group( array( "request"=>$request, "zone"=>$lgsl_zone_number ) );
  $server_list = lgsl_sort_servers($server_list);

//------------------------------------------------------------------------------------------------------------+

  if (!$server_list)
  {
    $output .= "<div style='margin:auto; text-align:center'>NO SERVERS IN ZONE {$lgsl_zone_number}</div>"; return;
  }

//------------------------------------------------------------------------------------------------------------+

  $output .= "
  <style>
    .sidebarserver * {
      scrollbar-width: thin;
      scrollbar-color: black gray;
    }

    .sidebarserver *::-webkit-scrollbar {
      height: 12px;
      width: 12px;
    }
    .sidebarserver *::-webkit-scrollbar-track {
      background: gray;
    }
    .sidebarserver *::-webkit-scrollbar-thumb {
      background-color: black;
      border-radius: 5px;
      border: 3px solid gray;
    }

    .sidebarserver img {
      border: none;
    }

    .marquee{
      width:100%;
      white-space:nowrap;
      overflow:hidden;
    }

    .marquee span.on {
      display:inline-block;
      animation: marquee 10s infinite linear alternate;
    }
    .sidebarserver table:hover .marquee span.on {
      animation: marquee 4s infinite linear alternate;
    }

    @keyframes marquee{
      0%{transform: translateX(15px);}
      100%{transform: translateX(calc(-100% + {$zone_width} - 15px));}
    }
  </style>
  <table cellpadding='0' cellspacing='0' style='width:100%; margin:auto; text-align:center' class='sidebarserver'>
    <tr>";

    foreach ($server_list as $key => $server)
    {
      $server = lgsl_sort_players($server);
      $misc   = lgsl_server_misc($server);
      $server = lgsl_server_html($server);

//------------------------------------------------------------------------------------------------------------+
      if ($zone_count != 0 && !($zone_count % $zone_grid))
      {
        $output .= "
        </tr>
        <tr>";
      }

      $zone_count ++;
//------------------------------------------------------------------------------------------------------------+

      $marquee = strlen($misc['name_filtered']) > 25;
      $output .= "
      <td style='padding-top:5px; padding-bottom:5px; vertical-align:top; text-align:center'>

        <table style='width:{$zone_width}; margin:auto; text-align:center' cellpadding='0' cellspacing='2'>

          <tr>
            <td title='{$lgsl_config['text']['slk']}' style='padding:0; text-align:center'>
              <div style='left:0; right:0; top:0; bottom:0; width:{$zone_width}; white-space:nowrap; overflow:hidden; text-align:center'>
                <a href='{$misc['software_link']}' style='text-decoration:none'>
                  ". ($server['b']['type'] == 'discord' ? "#{$server['b']['ip']}" : "{$server['b']['ip']}:{$server['b']['c_port']}") ."
                </a>
              </div>
            </td>
          </tr>

          <tr>
            <td title='{$server['s']['name']}' style='padding:0; text-align:center'>
              <div class='marquee' style='left:0; right:0; top:0; bottom:0; width:{$zone_width}; white-space:nowrap; overflow:hidden; text-align:center'>
                <span ". ($marquee ? "class='on'" : "") .">{$misc['name_filtered']}</span>
              </div>
            </td>
          </tr>

          <tr>
            <td style='padding:0; text-align:center'>
              <div style='left:0; right:0; top:0; bottom:0; width:{$zone_width}; padding:0; position:relative'>
                <a href='".lgsl_link($server['o']['id'])."'>
                  <img alt='' src='{$misc['image_map']}'          title='{$lgsl_config['text']['vsd']}' style='vertical-align:middle; width: 100%; border-radius: 4px;'>
                  <img alt='' src='{$misc['image_map_password']}' title='{$lgsl_config['text']['vsd']}' style='position:absolute; z-index:2; bottom:2px; right:2px;'>
                  <img alt='' src='{$misc['icon_game']}'          title='{$misc['text_type_game']}'     style='position:absolute; z-index:2; top:2px; left:2px; width: 24px; border-radius: 4px;'>
                  <img alt='' src='{$misc['icon_location']}'      title='{$misc['text_location']}'      style='position:absolute; z-index:2; top:2px; right:2px;'>
                </a>
              </div>
            </td>
          </tr>

          <tr>
            <td title='{$server['s']['map']}' style='padding:0; text-align:center'>
              <div style='left:0; right:0; top:0; bottom:0; width:{$zone_width}; white-space:nowrap; overflow:hidden; text-align:center'>
                {$server['s']['map']}
              </div>
            </td>
          </tr>";

        if (isset($server['p']) && $lgsl_config['players'][$lgsl_zone_number])
        {
          $zone_height = $lgsl_config['zone']['line_size'] * (count($server['p']) + 2);
          $zone_height = $zone_height > $lgsl_config['zone']['height'] ? "{$lgsl_config['zone']['height']}px" : "{$zone_height}px";

          $output .= "
          <tr>
            <td style='border-radius: 4px;'>
              <span style='padding:1px; float:left'> {$lgsl_config['text']['zpl']} </span>
              <span style='padding:1px; float:right'> {$server['s']['players']} / {$server['s']['playersmax']} </span>";
              if(count($server['p']) > 0){
                $output .= "<div style='left:0; right:0; top:0; bottom:0; width:{$zone_width}; height:{$zone_height}; border-top: 1px solid #8080807a; overflow: overlay; text-align:left'>";

                foreach ($server['p'] as $player)
                {
                  $output .= "
                  <div style='left:0; right:0; top:0; bottom:0; padding:1px; white-space:nowrap; overflow:hidden; text-align:left' title='{$player['name']}'> {$player['name']} </div>";
                }

                $output .= "</div";
              }
              else {
                $inner_width = ($server['s']['playersmax'] > 0 ? $server['s']['players']/$server['s']['playersmax']*100 : 0);
                $output .="
                <br>
                <div style='margin-top: 5px; border: 1px solid #555; background-color: #222; height: 4px;'>
                  <div style='width: ". $inner_width ."%; background-color: #ff8400; height: 4px;'></div>
                </div>";
              }
              $output .= "
            </td>
          </tr>";
        }
        else
        {
          $output .= "
          <tr>
            <td style='padding:0; border:1px solid'>
              <span style='padding:1px; float:left'> {$lgsl_config['text']['zpl']} </span>
              <span style='padding:1px; float:right'> {$server['s']['players']} / {$server['s']['playersmax']} </span>
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

//------------------------------------------------------------------------------------------------------------+
