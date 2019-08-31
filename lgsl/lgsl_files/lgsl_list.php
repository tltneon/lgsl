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

  $server_list = lgsl_query_group();
  $server_list = lgsl_sort_servers($server_list);

//------------------------------------------------------------------------------------------------------------+

  $output .= "
  <div style='text-align:center;margin-top:30px;'>
    <table id='server_list_table' cellpadding='4' cellspacing='2'>";

    foreach ($server_list as $server)
    {
      $misc   = lgsl_server_misc($server);
      $server = lgsl_server_html($server);

      $output .= "
      <tr style='table-layout:fixed'>

        <td style='white-space:nowrap; text-align:center'>
          <img alt='' src='{$misc['icon_status']}' title='{$misc['text_status']}'    class='list_icon' />
          <img alt='' src='{$misc['icon_game']}'   title='{$misc['text_type_game']}' class='list_icon' />
        </td>

        <td title='{$lgsl_config['text']['slk']}' style='text-align:right'>
          <a href='{$misc['software_link']}' style='text-decoration:none'>
            {$server['b']['ip']}:{$server['b']['c_port']}
          </a>
        </td>

        <td title='{$server['s']['name']}' style='text-align:left'>
          <div style='width:100%; overflow:hidden; height:1.3em; line-height:1.3em'>
            {$misc['name_filtered']}
          </div>
        </td>

        <td style='white-space:nowrap; text-align:left'>
          {$server['s']['map']}
        </td>

        <td style='white-space:nowrap; text-align:right'>
          {$server['s']['players']} / {$server['s']['playersmax']}
        </td>

        <td style='white-space:nowrap; text-align:center'>";

        if ($lgsl_config['locations'])
        {
          $output .= "
          <a href='".lgsl_location_link($server['o']['location'])."' style='text-decoration:none'>
            <img alt='' src='{$misc['icon_location']}' title='{$misc['text_location']}' class='list_icon' />
          </a>";
        }

        $output .= "
          <a href='".lgsl_link($server['o']['id'])."' style='text-decoration:none'>
            <img alt='' src='{$misc['icon_details']}' title='{$lgsl_config['text']['vsd']}' class='list_icon' />
          </a>
        </td>

      </tr>";
    }

    $output .= "
    </table>
  </div>";

//------------------------------------------------------------------------------------------------------------+

  if ($lgsl_config['list']['totals'])
  {
    $total = lgsl_group_totals($server_list);

    $output .= "
    <div id='totals'>
          <div class='inline'> {$lgsl_config['text']['tns']} {$total['servers']}    </div>
          <div class='inline'> {$lgsl_config['text']['tnp']} {$total['players']}    </div>
          <div class='inline'> {$lgsl_config['text']['tmp']} {$total['playersmax']} </div>
    </div>";
  }

//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
//------ PLEASE MAKE A DONATION OR SIGN THE GUESTBOOK AT GREYCUBE.COM IF YOU REMOVE THIS CREDIT ----------------------------------------------------------------------------------------------------+
  $output .= "<div style='text-align:center; font-family:tahoma; font-size:9px'><br /><br /><br /><a href='http://www.greycube.com' style='text-decoration:none'>".lgsl_version()."</a><br /></div>";
//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
