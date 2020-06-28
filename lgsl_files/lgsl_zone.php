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
  <table cellpadding='0' cellspacing='0' style='width:100%; margin:auto; text-align:center'>
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

      $output .= "
      <td style='padding-top:5px; padding-bottom:5px; vertical-align:top; text-align:center'>

        <table style='width:{$zone_width}; margin:auto; text-align:center' cellpadding='0' cellspacing='2'>

          <tr>
            <td title='{$lgsl_config['text']['slk']}' style='padding:0px; text-align:center'>
              <div style='left:0px; right:0px; top:0px; bottom:0px; width:{$zone_width}; white-space:nowrap; overflow:hidden; text-align:center'>
                <a href='{$misc['software_link']}' style='text-decoration:none'>
                  {$server['b']['ip']}:{$server['b']['c_port']}
                </a>
              </div>
            </td>
          </tr>

          <tr>
            <td title='{$server['s']['name']}' style='padding:0px; text-align:center'>
              <div style='left:0px; right:0px; top:0px; bottom:0px; width:{$zone_width}; white-space:nowrap; overflow:hidden; text-align:center'>
                {$misc['name_filtered']}
              </div>
            </td>
          </tr>

          <tr>
            <td style='padding:0px; text-align:center'>
              <div style='left:0px; right:0px; top:0px; bottom:0px; width:{$zone_width}; padding:0px; position:relative'>
                <a href='".lgsl_link($server['o']['id'])."'>
                  <img alt='' src='{$misc['image_map']}'          title='{$lgsl_config['text']['vsd']}' style='border:none; vertical-align:middle; width: 100%;' />
                  <img alt='' src='{$misc['image_map_password']}' title='{$lgsl_config['text']['vsd']}' style='border:none; position:absolute; z-index:2; top:0px; left:0px;' />
                  <img alt='' src='{$misc['icon_game']}'          title='{$misc['text_type_game']}'     style='border:none; position:absolute; z-index:2; top:4px; left:4px; width: 24px; border-radius: 4px;' />
                  <img alt='' src='{$misc['icon_location']}'      title='{$misc['text_location']}'      style='border:none; position:absolute; z-index:2; top:4px; right:4px;' />
                </a>
              </div>
            </td>
          </tr>

          <tr>
            <td title='{$server['s']['map']}' style='padding:0px; text-align:center'>
              <div style='left:0px; right:0px; top:0px; bottom:0px; width:{$zone_width}; white-space:nowrap; overflow:hidden; text-align:center'>
                {$server['s']['map']}
              </div>
            </td>
          </tr>";

        if ($server['p'] && $lgsl_config['players'][$lgsl_zone_number])
        {
          $zone_height = $lgsl_config['zone']['line_size'] * (count($server['p']) + 2);
          $zone_height = $zone_height > $lgsl_config['zone']['height'] ? "{$lgsl_config['zone']['height']}px" : "{$zone_height}px";

          $output .= "
          <tr>
            <td style='padding: 0px 5px; border: 1px solid gray;'>
              <div style='left:0px; right:0px; top:0px; bottom:0px; width:{$zone_width}; height:{$zone_height}; overflow:auto; text-align:left'>
                <span style='padding:1px; float:left'> {$lgsl_config['text']['zpl']} </span>
                <span style='padding:1px; float:right'> {$server['s']['players']} / {$server['s']['playersmax']} </span>
                <br />
                <br />";

                foreach ($server['p'] as $player)
                {
                  $output .= "
                  <div style='left:0px; right:0px; top:0px; bottom:0px; padding:1px; white-space:nowrap; overflow:hidden; text-align:left' title='{$player['name']}'> {$player['name']} </div>";
                }

                $output .= "
              </div>
            </td>
          </tr>";
        }
        else
        {
          $output .= "
          <tr>
            <td style='padding:0px; border:1px solid'>
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
